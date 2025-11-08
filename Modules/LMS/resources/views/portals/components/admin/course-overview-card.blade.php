<div class="col-span-full md:col-span-6 lg:col-span-3 rounded-10 dk-border-one p-5 mb-0">
    <p class="text-gray-500 dark:text-dark-text font-medium leading-none mb-2">
        {{ isset($title) ? translate($title) : translate('Title') }}
    </p>
    <div class="counter-value text-{{ isset($colorType) ? $colorType : 'primary' }} text-[32px] font-semibold leading-none"
        data-value="{{ $value }}">
        {{ $value }}
    </div>
</div>
