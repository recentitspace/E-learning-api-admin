<x-dashboard-layout>
    <x-slot:title>{{ translate('View Faq') }} </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('faq.index') }}" title="{{ translate('View Faq') }} " page-to="Faq" />
    <div class="card">
        <div>
            <label for="title" class="form-label">{{ translate('Title') }} <span class="require-field">*</span></label>
            <input type="text" id="title" name="title" placeholder="{{ translate('Enter Title') }}"
                class="form-input" value="{{ $faq->title ?? '' }}" readonly>
        </div>
        <div class="mt-6">
            <label for="answer" class="form-label">{{ translate('Answer') }} <span
                    class="require-field">*</span></label>
            <textarea name="answer" class="summernote form-input">{!! clean($faq->answer ?? '') !!}</textarea>
        </div>
    </div>

</x-dashboard-layout>
