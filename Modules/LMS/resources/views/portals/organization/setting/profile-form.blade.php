<x-dashboard-layout>
    <x-slot:title> {{ translate('profile/setting') }} </x-slot:title>
    <x-portal::profile.setting action="{{ route('organization.profile.update') }}" />
</x-dashboard-layout>
