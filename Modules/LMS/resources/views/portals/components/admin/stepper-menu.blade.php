<div class="card">
    <div class="container relative">
        <button class="prev-step-btn btn-icon b-solid btn-primary-icon-solid opacity-40 hover:opacity-100 absolute top-1/2 -left-4 -translate-y-1/2">
            <i class="ri-arrow-left-circle-line text-inherit text-[24px]"></i>
        </button>
        <div class="stepper-menu flex items-center text-center overflow-hidden scroll-smooth [&.dragging]:scroll-auto [&.dragging]:cursor-grab group/stepper-menu">
            @if ($type == 'translation')
                <button type="button" class="stepper-step-btn active d-hidden">
                    <i class="ri-stack-line text-inherit"></i>
                    {{ translate('Basic') }}
                </button>
            @elseif ($type == 'edit')
                <button type="button" class="stepper-step-btn active">
                    <i class="ri-stack-line text-inherit"></i>
                    {{ translate('Basic') }}
                </button>
                <button type="button" class="stepper-step-btn">
                    <i class="ri-book-3-line text-inherit"></i>
                    {{ translate('Curriculum') }}
                </button>
                <button type="button" class="stepper-step-btn">
                    <i class="ri-information-line text-inherit"></i>
                    {{ translate('Info') }}
                </button>
                <button type="button" class="stepper-step-btn">
                    <i class="ri-price-tag-2-line text-inherit"></i>
                    {{ translate('Price') }}
                </button>
                <button type="button" class="stepper-step-btn">
                    <i class="ri-image-2-line text-inherit"></i>
                    {{ translate('Media') }}
                </button>
                <button type="button" class="stepper-step-btn">
                    <i class="ri-group-line text-inherit"></i>
                    {{ translate('Manage Meeting') }}
                </button>
                <button type="button" class="stepper-step-btn">
                    <i class="ri-alarm-warning-line text-inherit"></i>
                    {{ translate('Notices Board') }}
                </button>
                <button type="button" class="stepper-step-btn">
                    <i class="ri-settings-3-line text-inherit"></i>
                    {{ translate('Setting') }}
                </button>
                <button type="button" class="stepper-step-btn">
                    <i class="ri-flag-line text-inherit"></i>
                    {{ translate('Finish') }}
                </button>
            @endif
        </div>
        <button class="next-step-btn btn-icon b-solid btn-primary-icon-solid opacity-40 hover:opacity-100 absolute top-1/2 -right-4 -translate-y-1/2">
            <i class="ri-arrow-right-circle-line text-inherit text-[24px]"></i>
        </button>
    </div>
</div>
