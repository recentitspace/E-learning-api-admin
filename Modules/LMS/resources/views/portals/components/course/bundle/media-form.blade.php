<div class="fieldset">
    <form action="{{ $action ?? '#' }}" method="POST" data-key="media">
        @csrf
        <input type="hidden" name="bundle_id" class="bundleId" value="{{ $bundle->id ?? '' }}">
        <div class="grid grid-cols-12 gap-x-4">
            <div class="col-span-full lg:col-span-7 card">
                @php
                    $src_type = $bundle->video_src_type ?? null;
                @endphp
                <div class="leading-none mt-6">
                    <label class="form-label">
                        {{ translate('Bundle Demo Video') }}
                        <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                    </label>
                    <select class="singleSelect" name="video_src_type" id="source-type-select">
                        <option disabled selected>{{ translate('Select Source Type') }}</option>
                        <option value="youtube" {{ $src_type == 'youtube' ? 'selected' : '' }}>
                            {{ translate('Youtube') }}</option>
                        <option value="vimeo" {{ $src_type == 'vimeo' ? 'selected' : '' }}>
                            {{ translate('Vimeo') }}
                        </option>
                        <option value="local" {{ $src_type == 'local' ? 'selected' : '' }}>
                            {{ translate('Local') }}
                        </option>
                    </select>
                    <span class="text-danger error-text video_src_type_err"></span>
                    <div id="courseVideoFile" class="mt-4">
                        @if (isset($bundle, $src_type) && $src_type !== 'local')
                            <label class="form-label">
                                {{ translate('Video url') }}
                                <span class="text-danger"
                                    title="{{ translate('This field is required') }}"><b>*</b></span>
                            </label>
                            <input type="url" class="form-input" placeholder="{{ translate('Video url') }}"
                                value="{{ $bundle->video_demo ?? '' }}" name="demo_url" autocomplete="off" />
                        @elseif (isset($bundle) && $src_type == 'local')
                            <label class="form-label">
                                {{ translate('Upload File') }}
                                <span class="text-danger"
                                    title="{{ translate('This field is required') }}"><b>*</b></span>
                            </label>
                            <div class="border border-input-border rounded-md px-2 py-1.5">
                                <input type="file" class="w-full" name="short_video">
                            </div>
                            <span class="text-danger error-text short_video_err"></span>

                            <div class="video mt-4">
                                @if (fileExists('lms/courses/bundles/videos', $bundle->video_demo) == true && $bundle->video_demo !== '')
                                    <video width="320" height="240" controls autoplay>
                                        <source
                                            src="{{ asset('storage/lms/courses/bundles/videos/' . $bundle->video_demo) }}">
                                    </video>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-span-full lg:col-span-5 card">
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
                        <div class="text-gray-500 dark:text-dark-text mt-2">
                            {{ translate('Choose file') }} </div>
                    </span>
                </label>
                <div class="preview-zone dropzone-preview">
                    <div class="box box-solid">
                        <div class="box-body flex items-center gap-2 flex-wrap">
                            @if (isset($bundle) && fileExists('lms/courses/bundles', $bundle?->thumbnail) == true && $bundle?->thumbnail !== '')
                                <div class="img-thumb-wrapper">
                                    <img class="img-thumb" width="100"
                                        src="{{ asset('storage/lms/courses/bundles/' . $bundle->thumbnail) }}" />
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <span class="text-danger error-text thumbnail_err"></span>
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



@push('js')
    <script>
        $(document).on("change", "#source-type-select", function(e) {
            if ($(this).val() !== "local") {
                $("#courseVideoFile").html(`
              <label class="form-label">${embedVideoUrl}</label>  
              <input type="text" id="v-url" class="form-input" placeholder="${embedVideoUrl}" name="demo_url" value="" autocomplete="off" />
             `);
            } else {
                $("#courseVideoFile").html(
                    `<label class="form-label">${uploadFileText}</label>
                <div class="border border-input-border rounded-md px-2 py-1.5">
                    <input type="file" id="v-url" class="w-full" name="short_video"> 
                    <span class="text-danger error-text short_video_err"></span>
                </div> 
                `
                );
            }
        });
    </script>
@endpush
