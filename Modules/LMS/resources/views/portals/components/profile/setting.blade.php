@push('css')
    <link rel="stylesheet" href="{{ asset('lms/assets/css/vendor/tagmanager.css') }}" />
@endpush
<div class="card">
    <div class="container relative">
        <button
            class="prev-step-btn btn-icon b-solid btn-primary-icon-solid opacity-40 hover:opacity-100 absolute top-1/2 -left-4 -translate-y-1/2">
            <i class="ri-arrow-left-circle-line text-inherit text-[24px]"></i>
        </button>
        <div
            class="stepper-menu flex items-center text-center overflow-hidden scroll-smooth [&.dragging]:scroll-auto [&.dragging]:cursor-grab group/stepper-menu">
            <button type="button" class="stepper-step-btn active">
                <i class="ri-stack-line text-inherit"></i>
                {{ translate('Basic') }}
            </button>
            <button type="button" class="stepper-step-btn">
                <i class="ri-image-2-line text-inherit"></i>
                {{ translate('Images') }}
            </button>
            <button type="button" class="stepper-step-btn">
                <i class="ri-graduation-cap-line text-inherit"></i>
                {{ translate('Education') }}
            </button>
            <button type="button" class="stepper-step-btn">
                <i class="ri-tent-line text-inherit"></i>
                {{ translate('Experience') }}
            </button>
            <button type="button" class="stepper-step-btn">
                <i class="ri-shake-hands-line text-inherit"></i>
                {{ translate('Top Skill') }}
            </button>
            <button type="button" class="stepper-step-btn">
                <i class="ri-inbox-unarchive-line text-inherit"></i>
                {{ translate('Extra') }}
            </button>
        </div>
        <button
            class="next-step-btn btn-icon b-solid btn-primary-icon-solid opacity-40 hover:opacity-100 absolute top-1/2 -right-4 -translate-y-1/2">
            <i class="ri-arrow-right-circle-line text-inherit text-[24px]"></i>
        </button>
    </div>
</div>
<div id="msform" class="*:hidden">
    <x-portal::profile.basic-form action="{{ $action ?? '#' }}" />

    <x-portal::profile.media-form action="{{ $action ?? '#' }}" />

    <x-portal::profile.education-form action="{{ $action ?? '#' }}" />

    <x-portal::profile.experience-form action="{{ $action ?? '#' }}" />

    <x-portal::profile.skill-form action="{{ $action ?? '#' }}" />

    <x-portal::profile.extra-information-form action="{{ $action ?? '#' }}" />
</div>

<input type="hidden" id="countryId" value="{{ authCheck()?->userable?->country_id }}">
<input type="hidden" id="stateId" value="{{ authCheck()?->userable?->state_id }}">
<input type="hidden" id="cityId" value="{{ authCheck()?->userable?->city_id }}">
@push('js')
    <script src="{{ asset('lms/assets/js/vendor/tagmanager.min.js') }}"></script>
    <script src="{{ asset('lms/assets/js/vendor/bootstrap3-typeahead.js') }}"></script>
    <script src="{{ edulab_asset('lms/assets/js/component/stepper.js') }}"></script>
    <script src="{{ edulab_asset('lms/assets/js/component/profile.js') }}"></script>
@endpush
