<x-dashboard-layout>
    <x-slot:title>{{ translate('Sub Forum Create') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="{{ isset($subForum) ? 'Edit' : 'Create' }} Sub Forum" page-to="Sub Forum" />
    <form method="post" class="form"
        action="{{ isset($subForum) ? route('sub-forum.update', $subForum->id) : route('sub-forum.store') }}">
        @csrf
        @if (isset($subForum))
            @method('PUT')
            <input type="hidden" name="id" value="{{ $subForum->id }}">
        @endif
        <div class="card">
            <div class="mt-6">
                <label for="forumTitle" class="form-label">{{ translate('Title') }} <span
                        class="text-danger">*</span></label>
                <input type="text" id="forumTitle" placeholder="{{ translate('Title') }}" name="name"
                    value="{{ isset($subForum) ? $subForum->name : '' }}" class="form-input">
                <span class="text-danger error-text name_err"></span>
            </div>
            <div class="mt-6">
                <label class="form-label">{{ translate('Select Forum') }} <span class="text-danger">*</span></label>
                <select class="singleSelect" name="forum_id">
                    <option selected disabled> {{ translate('Select Forum') }} </option>
                    @foreach (forums() as $forum)
                        <option value="{{ $forum->id }}"
                            {{ isset($subForum) && $subForum->forum_id == $forum->id ? 'selected' : '' }}>
                            {{ $forum->title }}</option>
                    @endforeach
                </select>
                <span class="text-danger error-text forum_id_err"></span>
            </div>
            <div class="mt-6">
                <label for="forumTitle" class="form-label"> {{ translate('Description') }} <span
                        class="text-danger">*</span></label>
                <textarea name="description" class="summernote">{!! clean($subForum->description ?? '') !!}</textarea>
                <span class="text-danger error-text description_err"></span>
            </div>
            <div class="mt-6">
                <label class="form-label">{{ translate('Icon') }}</label>
                <label for="imgage"
                    class="dropzone-wrappe file-container ac-bg text-xs leading-none font-semibold mb-3 cursor-pointer size-[200px] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 rounded-10 dk-theme-card-square">
                    <input type="file" hidden name="sub_forum_img" id="imgage"
                        class="dropzone dropzone-image img-src peer/file">
                    <span class="flex-center flex-col peer-[.uploaded]/file:hidden">
                        <img src="{{ asset('lms/') }}/assets/images/icons/upload-file.svg" alt="file-icon"
                            class="size-8 lg:size-auto">
                        <div class="text-gray-500 dark:text-dark-text mt-2"> {{ translate('Choose file') }} </div>
                    </span>
                    <span class="text-danger error-text icon_err"></span>
                </label>
                <div class="preview-zone dropzone-preview">
                    <div class="box box-solid">
                        <div class="box-body flex items-center gap-2 flex-wrap">

                            @if (isset($subForum) &&
                                    fileExists($folder = 'lms/forums/icons', $fileName = $subForum->icon) == true &&
                                    $subForum->icon != '')
                                <div class="img-thumb-wrapper"> <button class="remove">
                                        <i class="ri-close-line text-inherit text-[13px]"></i> </button>
                                    <img class="img-thumb" width="100"
                                        src="{{ asset('storage/lms/forums/icons/' . $subForum->icon) }}" />
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card flex justify-end">
            <button type="submit" class="btn b-solid btn-primary-solid px-5 cursor-pointer dk-theme-card-square">
                {{ translate('Submit') }}
            </button>
        </div>
    </form>
</x-dashboard-layout>
