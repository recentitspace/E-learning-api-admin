@php
    $user = authCheck();
@endphp


<div class="fieldset">
    <form action="{{ $action ?? '#' }}" method="POST" data-key="media" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $user?->userable?->id }}">
        <div class="grid grid-cols-12 gap-x-4">
            @php
                $folder = isOrganization() ? 'lms/organizations' : 'lms/instructors';
            @endphp
            <div class="col-span-full lg:col-span-6 card">
                <h6 class="card-title"> {{ translate('Profile Image') }} </h6>
                <div class="mt-7">
                    <label class="form-label"> {{ translate('Profile Image') }}({{ translate('200') }}x{{ translate('200') }})</label>
                    <label for="profileImg"
                        class="dropzone-wrappe file-container ac-bg text-xs leading-none font-semibold mb-3 cursor-pointer w-full h-[200px] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 rounded-10 dk-theme-card-square">
                        <input type="file" hidden name="profile_image" id="profileImg"
                            class="dropzone dropzone-image img-src peer/file">

                        <span class="flex-center flex-col peer-[.uploaded]/file:hidden">
                            <img src="{{ asset('lms/') }}/assets/images/icons/upload-file.svg" alt="file-icon"
                                class="size-8 lg:size-auto">
                            <div class="text-gray-500 dark:text-dark-text mt-2"> {{ translate('Choose file') }} </div>
                        </span>
                    </label>
                    <div class="preview-zone dropzone-preview">
                        <div class="box box-solid">
                            <div class="box-body flex items-center gap-2 flex-wrap">
                                @if (fileExists($folder = $folder, $fileName = $user?->userable?->profile_img) == true &&
                                        $user?->userable?->profile_img !== '')
                                    <div class="img-thumb-wrapper"> <button class="remove text-danger">
                                            <i class="ri-close-line text-inherit text-[13px]"></i> </button>
                                        <img class="img-thumb" width="100"
                                            src="{{ asset('storage/' . $folder . '/' . $user?->userable?->profile_img) }}" />
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <span class="text-danger error-text profile_image_err"></span>
                </div>
            </div>
            <div class="col-span-full lg:col-span-6 card">
                <h6 class="card-title"> {{ translate('Cover Image') }} </h6>
                <div class="mt-7">
                    <label class="form-label"> {{ translate('Cover Image') }} </label>
                    <label
                        class="dropzone-wrappe file-container ac-bg text-xs leading-none font-semibold mb-3 cursor-pointer w-full h-[200px] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 rounded-10 dk-theme-card-square">
                        <input type="file" hidden name="profile_cover"
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
                                @if (fileExists($folder, $fileName = $user?->userable?->cover_photo) == true && $user?->userable?->cover_photo !== '')
                                    <div class="img-thumb-wrapper"> <button class="remove text-danger">
                                            <i class="ri-close-line text-inherit text-[13px]"></i> </button>
                                        <img class="img-thumb" width="100"
                                            src="{{ asset('storage/' . $folder . '/' . $user?->userable?->cover_photo) }}" />
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <span class="text-danger error-text profile_cover_err"></span>
                </div>
            </div>
        </div>

        <div class="card flex justify-end gap-4">
            <button type="button" class="prev-form-btn btn b-outline btn-primary-outline"> {{ translate('Previous') }}
            </button>
            <button type="button" class="next-form-btn btn b-solid btn-primary-solid dk-theme-card-square">
                {{ translate('Save & Continue') }} </button>
        </div>
    </form>
</div>
