<!-- Start Info -->
<div class="fieldset">
    <form action="{{ $action ?? '#' }}" method="POST" data-key="additional_information">
        @csrf
        <input type="hidden" name="course_id" class="courseId" value="{{ $course->id ?? '' }}">
        <!-- COURSE FAQ -->
        <div class="card">
            <div class="grid grid-cols-12 gap-y-5 faq-item">
                <div class="col-span-full">
                    <div class="flex-center-between">
                        <h6 class="leading-none text-xl font-semibold text-heading"> {{ translate('Add Course FAQ') }}
                        </h6>
                        <button type="button" class="btn b-solid btn-primary-solid add-faq">
                            <i class="ri-add-circle-line text-inherit"></i> {{ translate('Add') }}
                        </button>
                    </div>
                </div>
                <div class="col-span-full">
                    <div class="flex flex-col gap-5 faq-area"
                        data-length="{{ isset($course, $course->courseFaqs) ? $course->courseFaqs->count() : 0 }}">
                        @if (isset($course, $course->courseFaqs) && !empty($course->courseFaqs))
                            @foreach ($course->courseFaqs as $courseFaq)
                                <div class="flex gap-4">
                                    <div class="grow flex flex-col gap-2">
                                        <input type="hidden" name="faqs[{{ $courseFaq->id }}][id]" class="form-input"
                                            value="{{ $courseFaq->id }}">

                                        <input type="text"
                                            placeholder="{{ translate('Faq question') }}"name="faqs[{{ $courseFaq->id }}][title]"
                                            class="form-input" value="{{ $courseFaq->title }}">
                                        <textarea name="faqs[{{ $courseFaq->id }}][answer]" placeholder="{{ translate('Faq Answer') }}" class="form-input">{{ $courseFaq->answer }}</textarea>
                                    </div>
                                    <button type="button" class="btn-icon btn-danger-icon-light shrink-0 delete-btn"
                                        data-id="{{ $courseFaq->id }}" data-key="faq">
                                        <i class="ri-delete-bin-line text-inherit"></i>
                                    </button>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- COURSE OUTCOME -->
        <div class="card">
            <div class="grid grid-cols-12 gap-y-5 outcome-item">
                <div class="col-span-full">
                    <div class="flex-center-between">
                        <h6 class="leading-none text-xl font-semibold text-heading">
                            {{ translate('Add Course Outcomes') }} </h6>
                        <button type="button" class="btn b-solid btn-primary-solid add-outcomes"> <i
                                class="ri-add-circle-line text-inherit"></i> {{ translate('Add') }}
                        </button>
                    </div>
                </div>
                <div class="col-span-full">
                    <div class="flex flex-col gap-5 outcomes-area"
                        data-length="{{ isset($course, $course->courseOutComes) ? $course->courseOutComes->count() : 0 }}">
                        @if (isset($course, $course->courseOutComes) && !empty($course->courseOutComes))
                            @foreach ($course->courseOutComes as $courseOutCome)
                                <div class="flex gap-4">
                                    <div class="grow flex flex-col gap-2 relative">
                                        <input type="text" placeholder="{{ translate('Course Outcomes') }}"
                                            id="searchInput" name="outcomes[{{ $courseOutCome->id }}][title]"
                                            class="form-input outcomes search-suggestion"
                                            value="{{ $courseOutCome->title }}" data-search-type="outcomes">

                                        <div class="search-show"></div>
                                    </div>
                                    <button type="button" class="btn-icon btn-danger-icon-light shrink-0 delete-btn">
                                        <i class="ri-delete-bin-line text-inherit"></i>
                                    </button>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- COURSE REQUIREMENTS -->
        <div class="card">
            <div class="grid grid-cols-12 gap-y-5 requirement-item">
                <div class="col-span-full">
                    <div class="flex-center-between">
                        <h6 class="leading-none text-xl font-semibold text-heading">
                            {{ translate('Course Requirements') }}
                        </h6>
                        <button type="button" class="btn b-solid btn-primary-solid add-requirement">
                            <i class="ri-add-circle-line text-inherit"></i> {{ translate('Add') }}
                        </button>
                    </div>
                </div>
                <div class="col-span-full">
                    <div class="flex flex-col gap-5 requirement-area"
                        data-length="{{ isset($course, $course->courseRequirements) ? $course->courseRequirements->count() : 0 }}">
                        @if (isset($course, $course->courseRequirements) && !empty($course->courseRequirements))
                            @foreach ($course->courseRequirements as $courseRequirement)
                                <div class="flex gap-4">
                                    <div class="grow flex flex-col gap-2 relative">
                                        <input type="text" placeholder="{{ translate('Course Requirements') }}"
                                            id="searchInput" name="requirements[{{ $courseRequirement->id }}][title]"
                                            class="form-input search-suggestion" data-search-type="requirement"
                                            value="{{ $courseRequirement->title }}">
                                        <div class="search-show"></div>
                                    </div>
                                    <button type="button" class="btn-icon btn-danger-icon-light shrink-0 delete-btn">
                                        <i class="ri-delete-bin-line text-inherit"></i>
                                    </button>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- COURSE TAG -->
        <div class="card">
            <div class="grid grid-cols-12 gap-4">
                <div class="col-span-full">
                    <div class="flex-center-between">
                        <h6 class="text-xl font-semibold text-heading"> {{ translate('Course Tag') }} </h6>
                    </div>
                </div>
                <div class="col-span-full">
                    <select class="tag-list" name="tags[]" multiple="multiple">
                        <option></option>
                    </select>
                </div>
            </div>
        </div>
        <div class="card flex-center gap-4 justify-end">
            <button type="button" class="prev-form-btn btn b-outline btn-primary-outline">
                {{ translate('Previous') }}
            </button>
            <button type="button" class="next-form-btn btn b-solid btn-primary-solid dk-theme-card-square">
                {{ translate('Save & Continue') }}
            </button>
        </div>
    </form>
</div>
