<x-dashboard-layout>
    <x-slot:title>
        @if (isset($emailTemplate))
            {{ translate('Edit Email') }}
        @else
            {{ translate('Create Email') }}
        @endif
    </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('email-template.index') }}"
        title="{{ isset($emailTemplate) ? 'Edit' : 'Create' }}" page-to="Email" />
    <form
        action="{{ isset($emailTemplate) ? route('email-template.update', $emailTemplate->id) : route('email-template.store') }}"
        method="POST" class="form" enctype="multipart/form-data">
        @if (isset($emailTemplate))
            @method('put')
        @endif
        @csrf
        <div class="card">
            <div class="grid grid-cols-2 gap-x-4 gap-y-6">
                <div class="col-span-full xl:col-auto leading-none">
                    <label for="subjectName" class="form-label">
                        {{ translate('Subject Name') }}
                    </label>
                    <input type="text" name="subject" id="subjectName" placeholder="{{ translate('Subject Name') }}"
                        class="form-input" value="{{ $emailTemplate->subject ?? '' }}">
                    <span class="text-danger error-text subject_err"></span>
                </div>
                <div class="col-span-full xl:col-auto leading-none">
                    <label for="emailTemplate" class="form-label">
                        {{ translate('Template Name') }}
                    </label>
                    <input type="text" name="template_name" id="emailTemplate"
                        placeholder="{{ translate('Template Name') }}" class="form-input"
                        value="{{ $emailTemplate->template_name ?? '' }}">
                    <span class="text-danger error-text template_name_err"></span>
                </div>
                <div class="col-span-full">
                    <label for="description" class="form-label">
                        {{ translate('Template Content') }}
                    </label>
                    <textarea name="description" class="summernote">{!! clean($emailTemplate->description ?? '') !!}</textarea>
                    <span class="text-danger error-text description_err"></span>
                </div>
            </div>
        </div>
        <div class="card flex justify-end">
            <button type="submit" class="btn b-solid btn-primary-solid dk-theme-card-square">
                {{ isset($emailTemplate) ? translate('Update') : translate('Submit') }}
            </button>
        </div>
    </form>
</x-dashboard-layout>
