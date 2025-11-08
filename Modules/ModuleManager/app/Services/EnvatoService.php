<?php

namespace Modules\ModuleManager\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Exception;

class EnvatoService
{
    protected $apiToken;
    protected $apiUrl = 'https://api.envato.com/v3';
    
    public function __construct()
    {
        $this->apiToken = config('module_manager.envato_api_token');
    }
    
    /**
     * Set API token
     *
     * @param string $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->apiToken = $token;
        return $this;
    }
    
    /**
     * Get user's purchases
     *
     * @return array
     */
    public function getPurchases()
    {
        try {
            $cacheKey = 'envato_purchases_' . md5($this->apiToken);
            
            return Cache::remember($cacheKey, 60 * 24, function () {
                $response = Http::withToken($this->apiToken)
                    ->get("{$this->apiUrl}/market/buyer/purchases");
                
                if ($response->successful()) {
                    return $response->json();
                }
                
                Log::error('Envato API error: ' . $response->body());
                return [];
            });
        } catch (Exception $e) {
            Log::error('Envato service error: ' . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Verify purchase code
     *
     * @param string $code
     * @return array|bool Purchase details or false if invalid
     */
    public function verifyPurchase($code)
    {
        try {
            $response = Http::withToken($this->apiToken)
                ->get("{$this->apiUrl}/market/author/sale", [
                    'code' => $code
                ]);
            
            if ($response->successful()) {
                return $response->json();
            }
            
            Log::error('Envato purchase verification error: ' . $response->body());
            return false;
        } catch (Exception $e) {
            Log::error('Envato purchase verification error: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Get download URL for a purchased item
     *
     * @param string $purchaseCode
     * @return string|null
     */
    public function getDownloadUrl($purchaseCode)
    {
        try {
            $verification = $this->verifyPurchase($purchaseCode);
            
            if (!$verification) {
                return null;
            }
            
            $itemId = $verification['item']['id'];
            
            $response = Http::withToken($this->apiToken)
                ->get("{$this->apiUrl}/market/buyer/download", [
                    'item_id' => $itemId,
                    'purchase_code' => $purchaseCode
                ]);
            
            if ($response->successful()) {
                $data = $response->json();
                return $data['download_url'] ?? null;
            }
            
            return null;
        } catch (Exception $e) {
            Log::error('Envato download URL error: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Search Envato market for modules
     *
     * @param string $query Search term
     * @param string $category Optional category
     * @return array
     */
    public function searchItems($query, $category = null)
    {
        try {
            $params = [
                'term' => $query,
            ];
            
            if ($category) {
                $params['category'] = $category;
            }
            
            $response = Http::withToken($this->apiToken)
                ->get("{$this->apiUrl}/market/catalog/search", $params);
            
            if ($response->successful()) {
                return $response->json();
            }
            
            return [];
        } catch (Exception $e) {
            Log::error('Envato search error: ' . $e->getMessage());
            return [];
        }
    }
}