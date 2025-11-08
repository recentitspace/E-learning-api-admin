<form action="{{ route('checkout') }}" class="border border-border bg-white rounded-xl p-4 form" method="post"
    enctype="multipart/form-data">
    @csrf
    <h2 class="area-title text-xl font-semibold">
        {{ translate('Upload Your Bank Information') }}</h2>
    @csrf
    <input type="hidden" name="payment_method" value="offline">
    <div class="grid grid-cols-2 gap-x-3 gap-y-4 mt-4">
        <div class="col-span-full">
            <label class="form-label">{{ translate('Document of your payment ') }}
                ( {{ translate('jpg') }} , {{ translate('pdf') }} , {{ translate('txt') }} , {{ translate('png') }}
                {{ translate('png') }},
                {{ translate('docx') }}) </label>
            <div class="relative">
                <input type="file" name="bank_document" class="form-input" />
            </div>
            <span class="text-danger error-text bank_document_err"></span>
        </div>
        <div class="col-span-full">
            <button type="submit" aria-label="Deposit Slip" class="btn b-solid btn-info-solid !font-medium">
                {{ translate('Upload') }}
            </button>
        </div>
    </div>
</form>
