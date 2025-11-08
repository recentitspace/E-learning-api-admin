<?php

namespace Modules\ModuleManager\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Modules\ModuleManager\Services\ModuleManager;
use Modules\ModuleManager\Services\EnvatoService;
use Nwidart\Modules\Facades\Module;
use Exception;

class ModuleManagerController extends Controller
{
    protected $moduleManager;
    protected $envatoService;
    
    public function __construct(ModuleManager $moduleManager, EnvatoService $envatoService)
    {
        $this->moduleManager = $moduleManager;
        $this->envatoService = $envatoService;
    }
    
    /**
     * Display module management dashboard
     */
    public function index()
    {
        $installedModules = Module::all();
        $enabledModules = Module::allEnabled();
        $disabledModules = Module::allDisabled();
        
        return view('modulemanager::index', compact('installedModules', 'enabledModules', 'disabledModules'));
    }
    
    /**
     * Show installed modules
     */
    public function installed()
    {
        $modules = Module::all();
        
        return view('modulemanager::installed', compact('modules'));
    }
    
    /**
     * Show marketplace modules
     */
    public function marketplace()
    {
        $marketplaceUrl = config('module_manager.marketplace_api_url');
        $availableModules = $this->moduleManager->getAvailableModules($marketplaceUrl);
        
        return view('modulemanager::marketplace', compact('availableModules'));
    }
    
    /**
     * Show Envato marketplace
     */
    public function envato()
    {
        $envatoToken = config('module_manager.envato_api_token');
        $hasPurchases = false;
        $purchases = [];
        
        if ($envatoToken) {
            $purchases = $this->envatoService->getPurchases();
            $hasPurchases = !empty($purchases);
        }
        
        return view('modulemanager::envato', compact('hasPurchases', 'purchases', 'envatoToken'));
    }
    
    /**
     * Search Envato marketplace
     */
    public function searchEnvato(Request $request)
    {
        $query = $request->input('query');
        $category = $request->input('category');
        
        $results = $this->envatoService->searchItems($query, $category);
        
        return response()->json($results);
    }
    
    /**
     * Enable a module
     */
    public function enable($module)
    {
        try {
            // Use the enhanced ModuleManager service
            $isEnabled = $this->moduleManager->enable($module);

            if ($isEnabled) {
                return redirect()->back()->with('success', "Module {$module} has been enabled and all dependencies have been processed.");
            }
            
            return redirect()->back()->with('failed', "Module {$module} didn't enable.");
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    
    /**
     * Disable a module
     */
    public function disable($module)
    {
        try {
            $isDisabled = $this->moduleManager->disable($module);
            
            if ($isDisabled) {
                return redirect()->back()->with('success', "Module {$module} has been disabled.");
            }
            
            return redirect()->back()->with('failed', "Module {$module} didn't disable.");
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    
    /**
     * Uninstall a module
     */
    public function uninstall($module)
    {
        try {
            $result = $this->moduleManager->uninstall($module);
            
            if ($result) {
                return redirect()->route('module-manager.index')
                    ->with('success', "Module {$module} has been uninstalled successfully.");
            }
            
            return redirect()->back()->with('error', "Failed to uninstall module {$module}.");
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    
    /**
     * Upload and install a module
     */
    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'module_zip' => 'required|file|mimes:zip',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        try {
            $zipPath = $request->file('module_zip')->path();
            $installed = $this->moduleManager->installFromZip($zipPath);
            
            if ($installed) {
                return redirect()->route('module-manager.index')
                    ->with('success', 'Module installed successfully.');
            }
            
            return redirect()->back()->with('error', 'Failed to install module.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    
    /**
     * Install a module from a repository URL
     */
    public function installFromUrl(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'download_url' => 'required|url',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        try {
            $url = $request->input('download_url');
            $downloadPath = $this->moduleManager->downloadModule($url);
            
            if ($downloadPath) {
                $installed = $this->moduleManager->installFromZip($downloadPath);
                
                if ($installed) {
                    return redirect()->route('module-manager.index')
                        ->with('success', 'Module installed successfully.');
                }
            }
            
            return redirect()->back()->with('error', 'Failed to download or install module.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    
    /**
     * Purchase and install a module from Envato
     */
    public function installFromEnvato(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'purchase_code' => 'required|string|min:8',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        try {
            $purchaseCode = $request->input('purchase_code');
            
            // Verify purchase
            $verification = $this->envatoService->verifyPurchase($purchaseCode);
            
            if (!$verification) {
                return redirect()->back()->with('error', 'Invalid purchase code or the purchase could not be verified.');
            }
            
            // Get download URL
            $downloadUrl = $this->envatoService->getDownloadUrl($purchaseCode);
            
            if (!$downloadUrl) {
                return redirect()->back()->with('error', 'Failed to get download URL for this purchase.');
            }
            
            // Download module
            $downloadPath = $this->moduleManager->downloadModule($downloadUrl);
            
            if (!$downloadPath) {
                return redirect()->back()->with('error', 'Failed to download module.');
            }
            
            // Save purchase information for license verification
            $this->moduleManager->savePurchaseInfo($purchaseCode, $verification);
            
            // Install the module
            $installed = $this->moduleManager->installFromZip($downloadPath);
            
            if ($installed) {
                return redirect()->route('module-manager.index')
                    ->with('success', 'Module purchased and installed successfully.');
            }
            
            return redirect()->back()->with('error', 'Failed to install module.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    
    /**
     * Check for updates for installed modules
     */
    public function checkUpdates()
    {
        try {
            $updates = $this->moduleManager->checkForUpdates();
            
            return view('modulemanager::updates', compact('updates'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    
    /**
     * Update a specific module
     */
    public function update($module)
    {
        try {
            $updated = $this->moduleManager->updateModule($module);
            
            if ($updated) {
                return redirect()->back()->with('success', "Module {$module} has been updated successfully.");
            }
            
            return redirect()->back()->with('error', "Failed to update module {$module}.");
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    
    /**
     * Show settings page for Module Manager
     */
    public function settings()
    {
        $settings = config('module_manager');
        
        return view('modulemanager::settings', compact('settings'));
    }
    
    /**
     * Save Module Manager settings
     */
    public function saveSettings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'envato_api_token' => 'nullable|string',
            'marketplace_api_url' => 'nullable|url',
            'enable_auto_updates' => 'boolean',
            'run_seeders' => 'boolean', // Added for controlling seeders execution
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        try {
            $this->moduleManager->saveSettings($request->all());
            
            return redirect()->back()->with('success', 'Settings saved successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Verify module licenses
     */
    public function verifyLicenses()
    {
        try {
            $results = $this->moduleManager->verifyLicenses();
            
            if (isset($results['error'])) {
                return redirect()->back()->with('error', $results['error']);
            }
            
            if (empty($results)) {
                return redirect()->back()->with('info', 'No module licenses found to verify.');
            }
            
            return redirect()->back()->with('success', 'Module licenses verified successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}