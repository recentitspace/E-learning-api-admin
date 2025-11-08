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
    <form action="{{ $action ?? '#' }}" method="POST" data-key="education" name="education-form">
        @csrf
        <input type="hidden" name="id" value="{{ $user?->userable?->id }}">
        <input type="hidden" name="user_id" value="{{ $user?->id }}">

        <div class="card flex-center-between">
            <h6 class="text-xl font-semibold text-heading"> {{ translate('Educational Qualification') }} </h6>
            <button type="button" class="btn b-solid btn-primary-solid add-education">
                <i class="ri-add-circle-line text-inherit"></i>
                <span> {{ translate('Add') }} </span>
            </button>
        </div>

        <div class="education-area" data-length="{{ isset($user->educations) ? $user->educations->count() : 0 }}">
            @if (isset($user->educations) && !empty($user->educations))
                @foreach ($user->educations as $key => $education)
                    <div class="card education-card relative">
                        <div class="grow grid grid-cols-2 gap-6 pt-10">
                            <div class="col-span-full md:col-auto relative">
                                <label class="form-label"> {{ translate('Institute Name') }} </label>
                                <input type="text" placeholder="{{ translate('Enter Institute Name') }}"
                                    name="educations[{{ $key }}][name]" id="searchInput"
                                    class="form-input search-suggestion" data-search-type="university"
                                    value="{{ $education->name }}">
                                <div class="search-show"></div>
                            </div>
                            <div class="col-span-full md:col-auto">
                                <label class="form-label mb-2 d-block">
                                    {{ translate('Department') }}
                                </label>
                                <input type="text" placeholder="{{ translate('Enter Department') }}"
                                    name="educations[{{ $key }}][department]" class="form-input"
                                    value="{{ $education?->pivot?->department ?? '' }}">
                            </div>
                            <div class="col-span-full md:col-auto">
                                <label class="form-label"> {{ translate('Degree') }} </label>
                                <input type="text"
                                    placeholder="{{ translate('Example') }} : {{ translate('BSC') }}"
                                    name="educations[{{ $key }}][degree]" class="form-input"
                                    value="{{ $education?->pivot?->degree ?? '' }}">
                            </div>
                            <div class="col-span-full md:col-auto">
                                <label class="form-label">{{ translate('CGPA') }}</label>
                                <input type="text" placeholder="{{ translate('Enter CGPA') }}"
                                    name="educations[{{ $key }}][cgpa]" class="form-input"
                                    value="{{ $education?->pivot?->cgpa ?? '' }}">
                            </div>

                            <div class="col-span-full md:col-auto">
                                <label class="form-label"> {{ translate('Duration') }}({{ translate('Years') }})
                                </label>
                                <input type="text" placeholder="{{ translate('Enter Duration') }}"
                                    name="educations[{{ $key }}][duration]" class="form-input"
                                    value="{{ $education?->pivot?->duration ?? '' }}">
                            </div>
                            <div class="col-span-full md:col-auto">
                                <label class="form-label"> {{ translate('Passing Year') }} </label>
                                <select class="singleSelect" name="educations[{{ $key }}][passing_year]" n>
                                    <option selected disabled>{{ translate('Select Passing Year') }}
                                    </option>
                                    @foreach (range(date('Y'), 2000) as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <button type="button"
                            class="btn b-solid btn-danger-solid h-max shrink-0 delete-btn dk-theme-card-square absolute top-6 right-6"
                            data-action="{{ route($prefix . '.setting.info.delete', ['type' => 'education', 'id' => $education->pivot->id]) }}">
                            {{ translate('Remove') }}
                        </button>
                        <script>
                            document.forms['education-form'].elements['educations[{{ $key }}][passing_year]'].value =
                                "{{ $education?->pivot?->passing_year }}";
                        </script>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="card flex justify-end gap-4">
            <button type="button" class="prev-form-btn btn b-outline btn-primary-outline"> {{ translate('Previous') }}
            </button>
            <button type="button" class="next-form-btn btn b-solid btn-primary-solid dk-theme-card-square">
                {{ translate('Save & Continue') }}
            </button>
        </div>
    </form>
</div>
