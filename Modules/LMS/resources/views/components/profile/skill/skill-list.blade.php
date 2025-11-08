<h5 class="text-xl font-semibold text-heading dark:text-white mb-4">
    {{ translate('Skill') }}
</h5>
<ul class="space-y-2">
    @foreach ($skills as $skill)
        <li> {{ $skill->name }}</li>
    @endforeach
</ul>
