@if (count($users) > 0)
    @foreach ($users as $user)
        @php
            $userInfo = $user->userable;
            $userTranslations = parse_translation($userInfo, $locale);
        @endphp
        <option value="{{ $user->id }}">
            {{ $userTranslations['first_name'] ?? $userInfo->first_name }}
            {{ $userTranslations['last_name'] ?? $userInfo->last_name }}
        </option>
    @endforeach
@endif
