<ul class="">
    @if( !empty($socials) )   
        @foreach( $socials as $social )
            <li>
                <a
                    href="{{ $social['url'] ?? '#' }}"
                    class="size-9 flex-center border border-border rounded-lg text-heading hover:border-transparent hover:bg-secondary custom-transition"
                    aria-label="Social media link"
                >
                    {!! $social['icon'] !!}
                </a>
            </li>
        @endforeach
    @endif
</ul>