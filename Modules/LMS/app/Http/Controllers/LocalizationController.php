<?php

namespace Modules\LMS\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Modules\LMS\Models\Auth\Admin;
use Modules\LMS\Models\Language;
use Modules\LMS\Models\Localization\Localization;
use Modules\LMS\Models\User;
use Stevebauman\Location\Facades\Location;

class LocalizationController extends Controller
{
    public function setLanguage(Request $request)
    {
        $request->validate([
            'locale' => 'required',
        ]);

        $locale = $request->locale ?? App::getLocale();
        $language = Language::where('code', $locale)->first();

        if (! $language) {
            return redirect()->back();
        }

        $ip = request()->ip();
        $location = Location::get($ip);
        $country = null;
        $countryCode = null;
        $user_id = $request->user_id ?? null;
        $admin_id = $request->admin_id ?? null;
        $user = null;
        $guard = null;
        $localization = null;
        $fields = [
            'ip' => $ip,
        ];

        if ($user_id) {
            $user = User::find($user_id);
            if ($user) {
                $localization = $user->localization ?? null;
                $guard = 'web';
            }
        }

        if ($admin_id) {
            $user = Admin::find($admin_id);
            if ($user) {
                $localization = $user->localization ?? null;
                $guard = 'admin';
            }
        }

        if ($location) {
            $country = $location->countryName;
            $countryCode = strtolower($location->countryCode);
            $fields['country_code'] = $countryCode;
        }

        if (! $user || ! $localization) {
            $localization = Localization::where($fields)->first();
        }

        if (! $localization) {
            $localization = new Localization();
        }

        $localization->user_id = $user->id ?? null;
        $localization->guard = $guard;
        $localization->language_id = $language->id;
        $localization->ip = $ip;
        $localization->country = $country;
        $localization->country_code = $countryCode;

        $localization->save();

        session()->put('locale', $locale);
        App::setLocale($locale);

        return redirect()->back();
    }
}
