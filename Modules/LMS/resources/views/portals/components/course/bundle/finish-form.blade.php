<!-- Finish -->
<div class="fieldset">
    <div
        class="card relative h-[calc(100vh_-_calc(theme(spacing.header)_+_32px))]lg:h-[calc(100vh_-_calc(theme(spacing.header)_+_48px))] ">
        <div class="flex flex-col items-center justify-center py-20 gap-6 text-center">
            <div>
                <img src="{{ asset('lms/assets/images/loti/loti-success-confirmation.svg') }}" alt="loti">
            </div>
            <div>
                <h3 class="text-2xl sm:text-[42px] leading-[1.23] font-semibold text-heading">
                    {{ translate('Congratulations') }}!
                </h3>
                <p class="font-spline_sans text-gray-900 my-4">
                    {{ translate('Your Bundle has been successfully created. Learn the best things in the world.') }}
                </p>
                <p class="font-spline_sans text-gray-900 my-4">
                    {{ translate('Thank you for choosing our LMS for your teaching needs!') }}
                </p>
                <a class="btn b-solid btn-primary-solid btn-lg" href="{{ $action ?? '#' }}">
                    {{ translate('Go to List') }}
                </a>
            </div>
        </div>
    </div>

</div>
