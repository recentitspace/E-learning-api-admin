<x-dashboard-layout>
    <x-slot:title>{{ translate('forum/create') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="{{ isset($forum) ? 'Edit' : 'Create' }} Forum" page-to="Forum" />
    <div class="card">
        <form method="post" class="form"
            action="{{ isset($forum) ? route('forum.update', $forum->id) : route('forum.store') }}">
            @csrf
            @if (isset($forum))
                @method('PUT')
                <input type="hidden" name="id" value="{{ $forum->id }}">
            @endif
            <div class="">
                <label for="forumTitle" class="form-label">{{ translate('Title') }} *</label>
                <input type="text" id="forumTitle" placeholder="{{ translate('Title') }}" name="title"
                    value="{{ $forum->title ?? '' }}" class="form-input">
                <span class="text-danger error-text title_err"></span>
            </div>
            <div class="mt-6">
                <label for="forumDescription" class="form-label">{{ translate('Description') }}</label>
                <textarea class="summernote description" name="description">{!! clean($forum->description) !!}</textarea>
                <span class="text-danger error-text description"></span>
            </div>
            <div class="mt-6">
                <label class="form-label">{{ translate('Image') }}</label>
                <label for="imgage"
                    class="dropzone-wrappe file-container ac-bg text-xs leading-none font-semibold mb-3 cursor-pointer size-[200px] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 rounded-10 dk-theme-card-square">
                    <input type="file" hidden name="forum_img" id="imgage"
                        class="dropzone dropzone-image img-src peer/file">
                    <span class="flex-center flex-col peer-[.uploaded]/file:hidden">
                        <img src="{{ asset('lms/assets/images/icons/upload-file.svg') }}"
                            alt="{{ translate('file-icon') }}" class="size-8 lg:size-auto">
                        <div class="text-gray-500 dark:text-dark-text mt-2"> {{ translate('Choose file') }} </div>
                    </span>
                    <span class="text-danger error-text image_err"></span>
                </label>
                <div class="preview-zone dropzone-preview">
                    <div class="box box-solid">
                        <div class="box-body flex items-center gap-2 flex-wrap">

                            @if (isset($forum) && fileExists($folder = 'lms/forums', $fileName = $forum->image) == true && $forum->image != '')
                                <div class="img-thumb-wrapper"> <button class="remove">
                                        <i class="ri-close-line text-inherit text-[13px]"></i> </button>
                                    <img class="img-thumb" width="100"
                                        src="{{ asset('storage/lms/forums/' . $forum->image) }}" />
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn b-solid btn-primary-solid px-5 cursor-pointer dk-theme-card-square mt-10">
                {{ translate('Submit') }}
            </button>
        </form>
    </div>
</x-dashboard-layout>
