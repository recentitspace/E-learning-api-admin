@php
    if (isOrganization()) {
        $prefix = 'organization';
    }

    if (isInstructor()) {
        $prefix = 'instructor';
    }

    $user = authCheck();
@endphp
<div class="fieldset">
    <form action="{{ $action ?? '#' }}" method="POST" data-key="company">
        @csrf
        <input type="hidden" name="id" value="{{ $user?->userable?->id }}">
        <input type="hidden" name="user_id" value="{{ $user?->id }}">

        <div class="card flex-center-between">
            <h6 class="text-xl font-semibold text-heading"> {{ translate('Previous Experience') }} </h6>
            <button type="button" class="btn b-solid btn-primary-solid add-experience">
                <i class="ri-add-circle-line text-inherit"></i>
                <span> {{ translate('Add') }} </span>
            </button>
        </div>

        <div class="experience-area" data-length="{{ isset($user->experiences) ? $user->experiences->count() : 0 }}">
            @if (isset($user->experiences) & !empty($user->experiences))

                @foreach ($user->experiences as $key => $experience)
                    <div class="card experience-card relative">
                        <div class="grow grid grid-cols-2 gap-6 pt-10">
                            <div class="col-span-full lg:col-auto leading-none">
                                <label for="company-name" class="form-label"> {{ translate('Company Name') }} </label>
                                <input type="text" id="company-name" placeholder="{{ translate('Company name') }}"
                                    id="searchInput" class="form-input search-suggestion" data-search-type="company"
                                    autocomplete="off" name="experiences[{{ $key }}][name]"
                                    value="{{ $experience->name }}">
                                <div class="search-show"></div>
                            </div>
                            <div class="col-span-full lg:col-auto leading-none">
                                <label for="designation" class="form-label"> {{ translate('Designation') }} </label>
                                <input type="text" id="designation" placeholder="{{ translate('Designation') }}"
                                    class="form-input" autocomplete="off"
                                    name="experiences[{{ $key }}][designation]"
                                    value="{{ $experience?->pivot?->designation ?? '' }}">
                            </div>
                            <div class="col-span-full lg:col-auto leading-none">
                                <label for="start-date" class="form-label"> {{ translate('Start Date') }} </label>
                                <input type="date" id="start-date" placeholder="{{ translate('Start Date') }}"
                                    class="form-input" autocomplete="off"
                                    name="experiences[{{ $key }}][start_date]"
                                    value="{{ $experience?->pivot?->start_date ?? '' }}">
                            </div>
                            <div class="col-span-full lg:col-auto leading-none">
                                <div class="flex items-center gap-2">
                                    <div class="grow">
                                        <label for="end-date" class="form-label"> {{ translate('End Date') }} </label>
                                        <input type="date" id="end-date" placeholder="{{ translate('End Date') }}"
                                            class="form-input" autocomplete="off"
                                            name="experiences[{{ $key }}][end_date]"
                                            value="{{ $experience?->pivot?->end_date ?? '' }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-full lg:col-auto leading-none">
                                <div class="flex items-center gap-2">
                                    <input type="checkbox" name="experiences[{{ $key }}][is_present]"
                                        id="current{{ $key }}"
                                        class="check check-primary-solid continue-working"
                                        {{ $experience?->pivot?->is_present == 1 ? 'checked' : '' }}>
                                    <label for="current{{ $key }}" class="form-label m-0">
                                        {{ translate('To Present') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <button type="button"
                            class="btn b-solid btn-danger-solid h-max shrink-0 dk-theme-card-square delete-btn absolute top-6 right-6"
                            data-action="{{ route($prefix . '.setting.info.delete', ['type' => 'experience', 'id' => $experience->pivot->id]) }}">
                            {{ translate('Remove') }}
                        </button>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="card flex justify-end gap-4">
            <button type="button" class="prev-form-btn btn b-outline btn-primary-outline">
                {{ translate('Previous') }}
            </button>
            <button type="button" class="next-form-btn btn b-solid btn-primary-solid dk-theme-card-square">
                {{ translate('Save & Continue') }}
            </button>
        </div>
    </form>
</div>
