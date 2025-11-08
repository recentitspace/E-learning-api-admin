<h5 class="text-xl font-semibold text-heading dark:text-white mb-4">
    {{ translate('Contact') }}
</h5>
<ul class="space-y-2">
    @php
        $userInfo = $user->userable ?? null;
    @endphp
    <li>
        <span class="text-heading">{{ translate('Phone') }}:</span>
        {{ $userInfo?->phone }}
    </li>
    <li>
        <span class="text-heading">{{ translate('Email') }}:</span>
        <a href="mailto:{{ $user->email }}" class="text-primary">{{ $user->email }}</a>
    </li>

    @if (!empty($userInfo->city?->name) || !empty($userInfo?->state?->name) || !empty($userInfo?->country?->name))
        <li>
            @php
                $city = $userInfo?->city?->name;
                $state = $userInfo?->state?->name;
                $country = $userInfo?->country?->name;
            @endphp
            <span class="text-heading">{{ translate('Location') }}:</span>
            {{ $city ? $city . ',' : '' }}
            {{ $state ? $state . ',' : '' }}
            {{ $country ? $country . '.' : '' }}
        </li>
    @endif
</ul>
