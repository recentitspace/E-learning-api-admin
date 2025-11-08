@php
    $subscribe = $data['subscribe'] ?? [];
@endphp
<form action="{{ route('newsletter.subscribe') }}" class="{{ $subscribe['form_class'] ?? 'mt-6' }} form" method="POST">
    @csrf
    <div class="{{ $subscribe['wrapper_class'] ?? 'flex' }}">
        <input type="email" placeholder="{{ translate('Enter email address') }}" name="email" autocomplete="off"
            required
            class="{{ $subscribe['input_class'] ?? 'bg-white text-heading/80 font-medium placeholder:text-heading/80 placeholder:font-semibold h-12 rounded-r-none rounded-l-full rtl:rounded-l-none rtl:rounded-r-full px-4 focus:outline-none grow' }} w-full">
        <button type="submit" aria-label="Join now with us"
            class="{{ $subscribe['btn_class'] ?? 'btn b-solid btn-primary-solid rounded-l-none rounded-r-full rtl:rounded-r-none rtl:rounded-l-full' }}">
            {{ $subscribe['btn_text'] ?? translate('Join Now') }}
        </button>
    </div>
</form>
