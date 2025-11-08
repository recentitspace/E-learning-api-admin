<!-- Start Media -->
<div class="fieldset">
    <form action="{{ $action ?? '#' }}" method="POST" data-key="media">
        @csrf
        <input type="hidden" name="course_id" class="courseId" value="{{ $course->id ?? '' }}">
        <div class="grid grid-cols-12 gap-x-4">
            <div class="col-span-full lg:col-span-6 card">
                <h6 class="leading-none text-xl font-semibold text-heading dark:text-white mb-5">
                    {{ translate('Add media files') }}
                </h6>
                <p class="text-xs text-gray-500 dark:text-dark-text leading-none font-semibold mb-3">
                    {{ translate('Thumbnail') }}({{ translate('300') }}x{{ translate('300') }})
                    <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                </p>
                <label for="thumbnail-one"
                    class="dropzone-wrappe file-container ac-bg text-xs leading-none font-semibold mb-3 cursor-pointer w-full h-[200px] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 rounded-10 dk-theme-card-square">
                    <input type="file" hidden name="thumbnail" id="thumbnail-one"
                        class="dropzone dropzone-image img-src peer/file">

                    <span class="flex-center flex-col peer-[.uploaded]/file:hidden">
                        <img src="{{ asset('lms/assets/images/icons/upload-file.svg') }}" alt="file-icon"
                            class="size-8 lg:size-auto">
                        <div class="text-gray-500 dark:text-dark-text mt-2"> {{ translate('Choose file') }} </div>
                    </span>
                </label>
                <div class="preview-zone dropzone-preview">
                    <div class="box box-solid">
                        <div class="box-body flex items-center gap-2 flex-wrap">

                            @if (isset($course) &&
                                    fileExists($folder = 'lms/courses/thumbnails', $fileName = $course?->thumbnail) == true &&
                                    $course?->thumbnail !== '')
                                <div class="img-thumb-wrapper">
                                    <img class="img-thumb" width="100"
                                        src="{{ asset('storage/lms/courses/thumbnails/' . $course->thumbnail) }}" />
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <span class="text-danger error-text thumbnail_err"></span>
            </div>
            <div class="col-span-full lg:col-span-6 card">
                <h6 class="leading-none text-xl font-semibold text-heading dark:text-white mb-5">
                    {{ translate('Add media files') }}
                </h6>
                <p class="text-xs text-gray-500 dark:text-dark-text leading-none font-semibold mb-3">
                    {{ translate('Course Preview Image') }} ({{ translate('300') }}x{{ translate('300') }})
                    <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                </p>
                <label for="main-file-src"
                    class="dropzone-wrapper file-container text-xs leading-none font-semibold mb-3 cursor-pointer w-full h-[200px] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 rounded-10 dk-theme-card-square">
                    <input type="file" id="main-file-src" hidden class="peer/file file-src dropzone multiple-image"
                        name="preview_image[]" multiple>
                    <span class="flex-center flex-col">
                        <img src="{{ asset('lms/') }}/assets/images/icons/upload-file.svg" alt="file-icon"
                            class="size-8 lg:size-auto">
                        <div class="text-gray-500 dark:text-dark-text mt-2"> {{ translate('Choose file') }} </div>
                    </span>
                </label>
                <div class="gallery-preview-zone dropzone-preview">
                    <div class="box box-solid">
                        <div class="box-body flex items-center gap-2 flex-wrap">
                            @if (isset($course, $course->coursePreviews) && $course->coursePreviews->count() > 0)
                                @foreach ($course->coursePreviews as $image)
                                    <div class="img-thumb-wrapper">
                                        <button class="remove multiple-image-remove"
                                            data-action="{{ route('course.multiple.image.delete', $image->id) }}">
                                            <i class="ri-close-line text-inherit text-[13px]"></i>
                                        </button>
                                        <img class="img-thumb" width="100"
                                            src="{{ asset('storage/lms/courses/previews/' . $image->image) }}" />
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <span class="text-danger error-text preview_image_err"></span>
            </div>
        </div>
        <div class="card flex-center gap-4 justify-end">
            <button type="button" class="prev-form-btn btn b-outline btn-primary-outline"> {{ translate('Previous') }}
            </button>
            <button type="button" class="next-form-btn btn b-solid btn-primary-solid dk-theme-card-square">
                {{ translate('Save & Continue') }}
            </button>
        </div>
    </form>
</div>
