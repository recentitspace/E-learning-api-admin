<x-dashboard-layout>
    <x-slot:title>{{ translate('Contact Reply') }}</x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="Reply Contact" page-to="Contact" />

    <form action="{{ route('contact.reply') }}" method="post" class="form">
        @csrf
        <input type="hidden" name="title" value="{{ $contact->title }}" class="form-input">
        <div class="card">
            <div class="grid grid-cols-2 gap-x-4 gap-y-5">
                <div class="col-span-full xl:col-auto leading-none">
                    <label for="noticeTitle" class="form-label"> {{ translate('Email') }} <span
                            class="text-danger">*</span></label>
                    <input type="text" name="email" value="{{ $contact->email }}" readonly class="form-input">
                    <span class="text-danger error-text email_err"></span>
                </div>
                <div class="col-span-full">
                    <label for="courseType" class="form-label"> {{ translate('Message') }} </label>
                    <textarea class="summernote" name="message">{{ 'Hello' . ' ' . $contact->name }}</textarea>
                    <span class="text-danger error-text message_err"></span>
                </div>
            </div>
        </div>
        <div class="card flex justify-end">
            <button type="submit" class="btn b-solid btn-primary-solid dk-theme-card-square">
                {{ translate('Reply') }}
            </button>
        </div>
    </form>

</x-dashboard-layout>
