@foreach ($faqs as $faq)
    <div>
        <div class="accordion accordion-faq {{ $loop->first ? 'active' : '' }}"> 
            {{ $faq->title }}
        </div>
        <div class="accordionpanel panel px-5">
            <p class="pb-5"> {!! clean($faq->answer) !!}.</p>
        </div>
    </div>
@endforeach
