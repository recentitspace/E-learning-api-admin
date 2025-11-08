@if (isset($course->courseFaqs) && !empty($course->courseFaqs))
    <article>
        <h2 class="area-title xl:text-3xl mb-5">
            {{ translate('Course FAQS') }}
        </h2>
        <div class="flex flex-col gap-5">
            <!-- SINGLE CURRICULUM -->
            @foreach ($course->courseFaqs as $key => $faq)
                <div class="border border-border rounded-lg lms-accordion">
                    <div
                        class="flex-center-between px-4 py-3 cursor-pointer lms-accordion-button {{ $loop->first ? 'panel-show' : '' }}  group/accordion peer/accordion">
                        <div class="flex items-center justify-between gap-1 grow">
                            <h6 class="area-title !text-lg font-bold">
                                {{ $faq->title }}
                            </h6>
                            <span class="group-[.panel-show]/accordion:rotate-90 leading-normal">
                                <i class="ri-arrow-right-s-line"></i>
                            </span>
                        </div>
                    </div>
                    <div
                        class="border-t border-border p-4 lms-accordion-panel peer-[.panel-show]/accordion:block hidden">
                        {!! clean($faq->answer) !!}?
                    </div>
                </div>
            @endforeach
        </div>
    </article>
@endif
