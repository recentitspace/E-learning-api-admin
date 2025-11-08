@if (isset($course->courseRequirements) && !empty($course->courseRequirements))
    <article>
        <h2 class="area-title xl:text-3xl mb-5">{{ translate('Course Requirements') }}</h2>
        <ul class="text-heading dark:text-white font-medium list-image-none [&>:not(:first-child)]:mt-2">
            @foreach ($course->courseRequirements as $requirement)
                <li class="flex gap-4 before:font-remix before:content-['\f100'] before:leading-[1.9] before:text-primary">
                    {{ $requirement?->title }}
                </li>
            @endforeach
        </ul>
    </article>
@endif
