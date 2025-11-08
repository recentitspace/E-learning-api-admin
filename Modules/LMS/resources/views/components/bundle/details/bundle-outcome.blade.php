@php
    $outcomes = $bundle->bundleOutComes ?? [];
@endphp
@if (!empty($outcomes))
    <article>
        <h2 class="area-title xl:text-3xl mb-5">
            {{ translate('Learning Outcomes') }}
        </h2>
        <ul class="text-heading dark:text-white font-medium list-image-none [&>:not(:first-child)]:mt-2">
            @foreach ($outcomes as $outcome)
                <li
                    class="flex gap-4 before:font-remix before:content-['\f100'] before:leading-[1.9] before:text-primary">
                    {{ $outcome?->title }}
                </li>
            @endforeach
        </ul>
    </article>
@endif
