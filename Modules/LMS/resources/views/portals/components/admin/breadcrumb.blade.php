@php
    $route = '#';
    if (isAdmin()) {
        $route = route('admin.dashboard');
    }

    if (isInstructor()) {
        $route = route('instructor.dashboard');
    }

    if (isOrganization()) {
        $route = route('organization.dashboard');
    }

    if (isStudent()) {
        $route = route('student.dashboard');
    }

    $backUrl = $backUrl ?? '';
    $pageTo = $pageTo ?? '';
@endphp
<div class="col-span-full">
    <div class="card">
        <div class="flex items-center justify-between gap-4 flex-wrap">
            <div class="shrink-0">
                <div class="flex items-center gap-4">
                    @if ($backUrl)
                        <a href="{{ $backUrl }}"
                            class="size-7 flex-center bg-gray-200 text-gray-500 dark:bg-dark-icon dark:text-dark-text rounded-md dk-theme-card-square">
                            <i class="ri-arrow-left-line text-inherit text-[18px]"></i>
                        </a>
                    @endif
                    @if ($title)
                        <h5 class="card-title">{{ translate(ucfirst($title)) }}</h5>
                    @endif

                </div>
                <ul
                    class="text-sm flex items-center flex-wrap gap-1.5 *:flex-center *:gap-1.5 leading-none text-gray-900 mt-3">
                    <li
                        class="text-primary-500 after:font-remix after:flex-center after:font-normal after:text-gray-900 after:size-auto after:content-['\f2e5'] rtl:after:content-['\f2e3'] after:translate-y-[1.4px] last:after:hidden [&.current-page]:text-gray-500 dark:text-dark-text">
                        <a href="{{ $route ?? '#' }}">{{ translate('Dashboard') }}</a>
                    </li>
                    @if ($pageTo)
                        <li
                            class="text-primary-500 after:font-remix after:flex-center after:font-normal after:text-gray-900 after:size-auto after:content-['\f2e5'] rtl:after:content-['\f2e3'] after:translate-y-[1.4px] last:after:hidden [&.current-page]:text-gray-500 dark:[&.current-page]:text-dark-text-two current-page">
                            {{ translate($pageTo) }}
                        </li>
                    @endif
                </ul>
            </div>
            @if (isset($actionRoute))
                <div class="flex items-center gap-3">
                    <a href="{{ $actionRoute ?? '#' }}"
                        class="btn b-outline btn-primary-outline btn-sm dk-theme-card-square">
                        <i class="ri-add-line text-inherit"></i>
                        {{ translate('Add new') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
