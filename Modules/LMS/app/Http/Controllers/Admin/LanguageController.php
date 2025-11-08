<?php

namespace Modules\LMS\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use Modules\LMS\Models\Translation;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Modules\LMS\Models\Language;
use Modules\LMS\Repositories\LanguageRepository;

class LanguageController extends Controller
{
    public function __construct(protected LanguageRepository $language) {}

    /**
     * Display a listing of the languages.
     *
     * @return View
     */
    public function index(Request $request): View
    {
        $options = [];
        $filterType = '';
        if ($request->has('filter')) {
            $filterType = $request->filter ?? '';
        }
        switch ($filterType) {
            case 'trash':
                $options['onlyTrashed'] = [];
                break;
            case 'all':
                $options['withTrashed'] = [];
                break;
        }
        $response = $this->language->paginate(10, options: $options, relations: ['translations' => function ($query) {
            $query->where('locale', app()->getLocale());
        }]);
        $languages = $response['data'] ?? [];
        $countResponse = $this->language->trashCount();
        $countData = [
            'total' => 0,
            'published' => 0,
            'trashed' => 0
        ];

        if ($countResponse['status'] === 'success') {
            $countData = $countResponse['data']->toArray() ?? $countData;
        }

        return view('portal::admin.language.index', compact('languages', 'countData'));
    }
    /**
     * Show the form for creating a new language.
     *
     * @return View
     */
    public function create(): View
    {
        return view('portal::admin.language.form');
    }
    /**
     * Store a newly created language in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        // Check user permission to add a language
        if (!has_permissions($request->user(), ['add.language'])) {
            return  json_error('You have no permission.');
        }
        // Get Language.
        $response = $this->language->save($request->all());
        if ($response['status'] !== 'success') {
            return response()->json($response);
        }
        // success.
        toastr()->success(translate('Language has been saved successfully!'));
        return response()->json(['status' => 'success', 'url' => route('language.index')]);
    }

    /**
     * Show the form for editing the specified language.
     *
     * @param int $id
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function edit(int $id, Request $request)
    {
        // Check user permission to change language status
        if (!has_permissions($request->user(), ['edit.language'])) {
            toastr()->error(translate('You have no permission.'));
            return redirect()->back();
        }
        $locale = $request->locale ?? app()->getLocale();
        // Get subject.
        $response = $this->language->first($id, relations: ['translations' => function ($query) use ($locale) {
            $query->where('locale', $locale);
        }]);
        // Check response status.
        if ($response['status'] !== 'success') {
            return view('portal::admin.404');
        }
        // return response view.
        $language = $response['data'];
        return view('portal::admin.language.form', compact('language'));
    }

    /**
     * Update the specified language in storage.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update(int $id, Request $request): JsonResponse
    {
        // Check user permission to change language status
        if (!has_permissions($request->user(), ['edit.language'])) {
            return json_error('You have no permission.');
        }
        // get language
        $response = $this->language->update($id, $request);
        // Check if the update was successful
        return $response['status'] === 'success'
            ? $this->jsonSuccess('Language has been updated successfully!', route('language.index'))
            : response()->json($response);
    }
    /**
     * Change the default of the specified language.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function defaultChange(int $id, Request $request): JsonResponse
    {
        // Check user permission to change language default
        if (!has_permissions($request->user(), 'status.language')) {
            return json_error('You have no permission.');
        }
        $language = $this->language->defaultChange($id);
        if ($language['status'] == 'success') {
            $language['url'] = route('site.language');
        }
        // Return error response for permission denial
        return response()->json($language);
    }

    /**
     * Change the rtl of the specified language.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function rtlActive(int $id, Request $request): JsonResponse
    {
        // Check user permission to change language default
        if (!has_permissions($request->user(), 'rtl.language')) {
            return json_error('You have no permission.');
        }
        $language = $this->language->rtlActive($id);
        if ($language['status'] == 'success') {
            $language['url'] = route('site.language');
        }
        // Return error response for permission denial
        return response()->json($language);
    }



    /**
     * Change the status of the specified language.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function statusChange(int $id, Request $request): JsonResponse
    {
        // Check user permission to change language status
        if (!has_permissions($request->user(), 'status.language')) {
            return json_error('You have no permission.');
        }
        $language = $this->language->statusChange($id);
        // Return error response for permission denial
        return response()->json($language);
    }

    /**
     * Remove the specified language from storage.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(int $id, Request $request): JsonResponse
    {
        // Check user permission to delete a language
        if (!has_permissions($request->user(), ['delete.language'])) {
            return json_error('You have no permission.');
        }
        $language = $this->language->delete(id: $id, data: [
            'status' => 0,
        ]);
        $language['url'] = route('language.index');
        return response()->json($language);
    }

    /**
     * Remove the specified language from storage.
     *
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function restore(int $id, Request $request)
    {
        // Check user permission to delete a language
        if (!has_permissions($request->user(), ['delete.language'])) {
            return json_error('You have no permission.');
        }

        $response = $this->language->restore(id: $id);
        $response['url'] = route('language.index');

        return response()->json($response);
    }

    public function translate(Request $request, $id)
    {

        $language = Language::where('id', $id)->first();
        if (!$language) {
            return  view('portal::admin.404');
        }

        $searchKey = $request->search;
        $response = Translation::where('lang', env('DEFAULT_LANGUAGE', 'en'));
        if ($request->has('search')) {
            $lang_keys = $response->whereAny(['lang_key', 'lang_value'], 'like', '%' . $request->search . '%');
        }
        $langKeys = $response->paginate(100);
        return view('portal::admin.setting-option.language.translate', compact('langKeys', 'language', 'searchKey'));
    }

    public function translateStore(Request $request, $id)
    {
        try {
            // Check user permission to change language status
            if (!has_permissions($request->user(), ['translate.language'])) {
                toastr()->error(translate('You have no permission.'));
                return redirect()->back();
            }

            $language = $this->language->first($id)['data'];
            foreach ($request->values as $key => $value) {
                $translation = Translation::where('lang_key', $key)->where('lang', $language->code)->latest()->first();
                if (!$translation) {
                    $translation = new Translation;
                    $translation->lang = $language->code;
                    $translation->lang_key = $key;
                    $translation->lang_value = $value;
                    $translation->save();
                } else {
                    $translation->lang_value = $value;
                    $translation->update();
                }
            }
            Cache::forget('translations-' . $language->code);
            toastr()->success(translate('Translate Successfully'));
            return redirect()->back();
        } catch (\Exception $th) {
            return ['status' => false, 'message' => $th->getMessage()];
        }
    }


    public function siteLanguage(Request $request): View
    {
        $response = $this->language->paginate(10);
        $languages = $response['data'] ?? [];
        return view('portal::admin.setting-option.language.index', compact('languages'));
    }
}
