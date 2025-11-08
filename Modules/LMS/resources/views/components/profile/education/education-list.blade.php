<h5 class="text-xl font-semibold text-heading dark:text-white mb-4">
    {{ translate('Education') }}
</h5>
<ul class="space-y-2">
    @foreach ($educations as $education)
        <li><span class="text-heading">{{ translate('Degree') }}:</span> {{ $education?->pivot?->degree }}</li>
        <li><span class="text-heading">{{ translate('University') }}:</span> {{ $education->name }} </li>
        <li><span class="text-heading">{{ translate('Focus') }}:</span> {{ $education?->pivot?->department }}</li>
        @if ($education?->pivot?->passing_year)
            <li><span class="text-heading">{{ translate('Passing Year') }}:</span>
                {{ $education?->pivot?->passing_year }}</li>
        @endif
    @endforeach
</ul>
