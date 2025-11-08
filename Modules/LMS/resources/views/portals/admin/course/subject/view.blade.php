<x-dashboard-layout>
    <x-slot:title> {{ translate('View Subject') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('subject.index') }}" title="View" page-to="Subject" />
    <div class="grid grid-cols-12 gap-x-4">
        <div class="col-span-full md:col-span-8">
            <div class="card">
                <div class="grid grid-cols-2 gap-x-4 gap-y-5">
                    <div class="col-span-full xl:col-auto leading-none">
                        <label for="courseTitle" class="form-label">
                            {{ translate('Name') }}
                            <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
                        </label>
                        <input type="text" id="courseTitle" name="name" readonly
                            value="{{ $subject->name ?? '' }}" class="form-input">
                        <span class="text-danger error-text name_err"></span>
                    </div>
                    <div class="col-span-full xl:col-auto leading-none">
                        <label for="meta_title" class="form-label">
                            {{ translate('Meta Title') }}
                        </label>
                        <input type="text" id="meta_title" readonly name="meta_title"
                            value="{{ $subject->meta_title ?? '' }}" class="form-input">
                    </div>
                    <div class="col-span-full">
                        <label for="courseType" class="card-title">
                            {{ translate('Meta Description') }}
                        </label>
                        <div class="card-description text-gray-500 dark:text-dark-text-two mt-4">
                            {!! clean($subject->meta_description ?? '') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-full md:col-span-4 card">
            <label class="form-label">
                {{ translate('Subject thumbnail') }}
                <span class="text-danger" title="{{ translate('This field is required') }}"><b>*</b></span>
            </label>

            <div class="preview-zone dropzone-preview">
                <div class="box box-solid">
                    <div class="box-body flex items-center gap-2 flex-wrap">
                        @if (isset($subject) &&
                                fileExists($folder = 'lms/subjects', $fileName = $subject->image) == true &&
                                $subject->image !== '')
                            <div class="img-thumb-wrapper">
                                <img class="img-thumb" src="{{ asset('storage/lms/subjects/' . $subject->image) }}" />
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>
