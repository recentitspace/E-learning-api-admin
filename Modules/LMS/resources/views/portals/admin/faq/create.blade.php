<x-dashboard-layout>
    <x-slot:title>{{ isset($faq) ? translate('Edit') : translate('Create') }} {{ translate('Faq') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('faq.index') }}" title="{{ isset($faq) ? 'Edit' : 'Create' }} Faq"
        page-to="Faq" />
    <form action="{{ isset($faq) ? route('faq.update', $faq->id) : route('faq.store') }}" method="post" class="form mb-4"
        enctype="multipart/form-data">
        @if (isset($faq))
            @method('PUT')
        @endif
        @csrf
        <div class="card">
            <div>
                <label for="title" class="form-label">{{ translate('Title') }} <span
                        class="require-field">*</span></label>

                <input type="text" id="title" name="title" placeholder="{{ translate('Enter Title') }}"
                    class="form-input" value="{{ $faq->title ?? null }}">
                <span class="text-danger error-text title_err"></span>
            </div>

            <div class="mt-6">
                <label for="answer" class="form-label">{{ translate('Answer') }} <span
                        class="require-field">*</span></label>

                <textarea name="answer" class="summernote form-input">{!! clean($faq->answer ?? '') !!}</textarea>
                <span class="text-danger error-text answer_err"></span>
            </div>
        </div>
        <div class="card flex justify-end">
            <button type="submit" class="btn b-solid btn-primary-solid dk-theme-card-square">
                {{ isset($faq) ? translate('Update') : translate('Save') }}
            </button>
        </div>
    </form>
</x-dashboard-layout>
