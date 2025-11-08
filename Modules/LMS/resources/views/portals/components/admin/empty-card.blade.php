<div class="card flex-center flex-col h-[300px]">
    <h2 class="card-title text-center !normal-case">
        {{ translate($title ?? 'Empty Title') }}
    </h2>
    @if (!empty($action))
        <a href="{{ $action ?? '#' }}" class="btn b-solid btn-primary-solid !text-base !leading-none mt-5">
            {{ translate($btnText) ?? 'Button text' }} 
        </a>
    @endif
</div>