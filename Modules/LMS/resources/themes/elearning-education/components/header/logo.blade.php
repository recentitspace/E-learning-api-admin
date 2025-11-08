 @php
     $activeThemeSnake = key_snake_case(active_theme_slug());
     $logo = get_theme_option(key: 'theme_logo_' . $activeThemeSnake) ?? get_theme_option(key: 'theme_logo');
     $defaultLogo = $defaultLogo ?? asset('lms/frontend/assets/images/logo/default-logo-dark.svg');
     $themeLogo =
         isset($logo['logo']) && fileExists($folder = 'lms/theme-options', $fileName = $logo['logo']) == true
             ? asset("storage/lms/theme-options/{$logo['logo']}")
             : $defaultLogo;
 @endphp
 <a href="{{ route('home.index') }}" class="flex-center">
     <img src="{{ $themeLogo }}" alt="Header site logo" class="max-w-24 sm:max-w-40">
 </a>
