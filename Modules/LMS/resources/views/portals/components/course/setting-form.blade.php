<!-- Start Setting -->
<div class="fieldset">
    <form action="{{ $action ?? '#' }}" method="POST" data-key="setting">
        @csrf
        <input type="hidden" name="course_id" class="courseId" value="{{ $course->id ?? '' }}">
        <input type="hidden" name="setting_id" value="{{ $course?->courseSetting?->id ?? null }}">

        <div class="grid grid-cols-12 gap-x-4">
            <div class="col-span-full lg:col-span-6 card">
                <h6 class="text-xl font-semibold text-heading">{{ translate('Course Settings') }}</h6>
                <div class="mt-10">
                    <div class="leading-none mb-10">
                        <label for="seat" class="form-label">{{ translate('Seat Capacity') }}</label>
                        <input type="number" id="seat" placeholder="{{ translate('Seat Capacity') }}"
                            name="seat_capacity" class="form-input"
                            value="{{ $course?->courseSetting?->seat_capacity ?? '' }}">
                    </div>
                </div>
            </div>
            <div class="col-span-full lg:col-span-6 card">
                <h6 class="text-xl font-semibold text-heading">{{ translate('Course Settings Options') }}</h6>
                <div class="mt-10">
                    <div class="leading-none flex items-center gap-4 mb-10">
                        <label for="support" class="inline-flex items-center me-5 cursor-pointer">
                            <input type="checkbox" id="support" name="has_support" class="appearance-none peer"
                                {{ isset($course) && $course?->courseSetting?->has_support == 1 ? 'checked' : '' }}>
                            <div class="switcher switcher-primary-solid"></div>
                        </label>
                        <div class="text-gray-500 dark:text-dark-text font-medium inline-block">
                            {{ translate('Has Support') }}</div>
                    </div>
                    <div class="leading-none flex items-center gap-4 mb-10">
                        <label for="certificate" class="inline-flex items-center me-5 cursor-pointer">
                            <input type="checkbox" id="certificate" name="is_certificate" class="appearance-none peer"
                                {{ isset($course) && $course?->courseSetting?->is_certificate == 1 ? 'checked' : '' }}>
                            <div class="switcher switcher-primary-solid"></div>
                        </label>
                        <div class="text-gray-500 dark:text-dark-text font-medium inline-block">
                            {{ translate('Has Certificate') }}</div>
                    </div>

                    <div class="leading-none flex items-center gap-4 mb-10">
                        <label for="upcoming" class="inline-flex items-center me-5 cursor-pointer">
                            <input type="checkbox" id="upcoming" class="appearance-none peer" name="is_upcoming"
                                {{ isset($course) && $course?->courseSetting?->is_upcoming == 1 ? 'checked' : '' }}>
                            <div class="switcher switcher-primary-solid"></div>
                        </label>
                        <div class="text-gray-500 dark:text-dark-text font-medium inline-block">
                            {{ translate('Is Upcoming') }}</div>
                    </div>
                    <div class="leading-none flex items-center gap-4 mb-10">
                        <label for="free" class="inline-flex items-center me-5 cursor-pointer">
                            <input type="checkbox" id="free" class="appearance-none peer" name="is_free"
                                {{ isset($course) && $course?->courseSetting?->is_free == 1 ? 'checked' : '' }}>
                            <div class="switcher switcher-primary-solid"></div>
                        </label>
                        <div class="text-gray-500 dark:text-dark-text font-medium inline-block">
                            {{ translate('Is Free Course') }}</div>
                    </div>
                    <div class="leading-none flex items-center gap-4 mb-10">
                        <label for="live" class="inline-flex items-center me-5 cursor-pointer">
                            <input type="checkbox" id="live" class="appearance-none peer" name="is_live"
                                {{ isset($course) && $course?->courseSetting?->is_live == 1 ? 'checked' : '' }}>
                            <div class="switcher switcher-primary-solid"></div>
                        </label>
                        <div class="text-gray-500 dark:text-dark-text font-medium inline-block">
                            {{ translate('Is Live') }}</div>
                    </div>

                    <div class="leading-none flex items-center gap-4 mb-10">
                        <label for="is_subscribe" class="inline-flex items-center me-5 cursor-pointer">
                            <input type="checkbox" id="is_subscribe" class="appearance-none peer" name="is_subscribe"
                                {{ isset($course) && $course?->courseSetting?->is_subscribe == 1 ? 'checked' : '' }}>
                            <div class="switcher switcher-primary-solid"></div>
                        </label>
                        <div class="text-gray-500 dark:text-dark-text font-medium inline-block">
                            {{ translate('Subscribe') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card flex-center gap-4 justify-end">
            <button type="button"
                class="prev-form-btn btn b-outline btn-primary-outline">{{ translate('Previous') }}</button>
            <button type="button"
                class="next-form-btn btn b-solid btn-primary-solid dk-theme-card-square">{{ translate('Save & Continue') }}</button>
        </div>
    </form>
</div>
