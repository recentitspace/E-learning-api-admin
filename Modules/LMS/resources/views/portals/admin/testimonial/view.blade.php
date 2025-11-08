<x-dashboard-layout>
    <x-slot:title>
        {{ translate('View Testimonial') }}
    </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('testimonial.index') }}" title="{{ translate('view') }}"
        page-to="Testimonial" />

    <div class="grid grid-cols-12 gap-x-4">
        <div class="col-span-full md:col-span-7 card">
            <div class="p-1.5">

                <div class="mt-7">
                    <div>
                        <label for="testimonial-name" class="form-label">{{ translate('Name') }} :</label>
                        {{ $testimonial->name }}
                    </div>
                    <div class="mt-6">
                        <label for="designation" class="form-label">{{ translate('Designation') }} :</label>
                        {{ $testimonial->designation }}
                    </div>
                    <div class="mt-6">
                        <label for="rating" class="form-label">{{ translate('Rating') }}: </label>
                        <span class="rating_err"> {{ $testimonial->rating }}</span>
                    </div>
                    <div class="mt-6">
                        <label for="testimonial-content" class="form-label"><b>{{ translate('Description') }}</b> :
                        </label>
                        {!! clean($testimonial->comments ?? '') !!}
                    </div>
                </div>

            </div>
        </div>
        <div class="col-span-full md:col-span-5 card">
            <h6 class="leading-none text-xl font-semibold text-heading">{{ translate('Media') }}</h6>
            <div class="mt-7">
                <p class="text-xs text-gray-500 dark:text-dark-text leading-none font-semibold mb-3">
                    {{ translate('Image') }}
                </p>

                <div class="preview-zone dropzone-preview">
                    <div class="box box-solid">
                        <div class="box-body flex items-center gap-2 flex-wrap">

                            @if (isset($testimonial) &&
                                    fileExists($folder = 'lms/testimonials', $fileName = $testimonial->profile_image) == true &&
                                    $testimonial->profile_image != '')
                                <div class="img-thumb-wrapper">
                                    <img class="img-thumb" width="100"
                                        src="{{ asset('storage/lms/testimonials/' . $testimonial->profile_image) }}" />
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-dashboard-layout>
