<div class="fieldset">
    <form action="{{ $action ?? '#' }}" method="POST" data-key="additional_information">
        @csrf
        <input type="hidden" name="bundle_id" class="bundleId" value="{{ $bundle->id ?? '' }}">
        <div class="card">
            <div class="grid grid-cols-12 gap-y-5 faq-item">
                <div class="col-span-full">
                    <div class="flex-center-between">
                        <h6 class="leading-none text-xl font-semibold text-heading">
                            {{ translate('Add Bundle FAQ') }}
                        </h6>
                        <button type="button" class="btn b-solid btn-primary-solid add-faq">
                            <i class="ri-add-circle-line text-inherit"></i> {{ translate('Add') }}
                        </button>
                    </div>
                </div>
                <div class="col-span-full">
                    <div class="flex flex-col gap-5 faq-area"
                        data-length="{{ isset($bundle, $bundle->bundleFaqs) ? $bundle->bundleFaqs->count() : 0 }}">
                        @if (isset($bundle, $bundle->bundleFaqs) && !empty($bundle->bundleFaqs))
                            @foreach ($bundle->bundleFaqs as $bundleFaq)
                                <div class="flex gap-4">
                                    <div class="grow flex flex-col gap-2">
                                        <input type="hidden" name="faqs[{{ $bundleFaq->id }}][id]" class="form-input"
                                            value="{{ $bundleFaq->id }}">

                                        <input type="text"
                                            placeholder="{{ translate('Faq question') }}"name="faqs[{{ $bundleFaq->id }}][title]"
                                            class="form-input" value="{{ $bundleFaq->question }}">
                                        <textarea name="faqs[{{ $bundleFaq->id }}][answer]" placeholder="{{ translate('Faq Answer') }}" class="form-input">{{ $bundleFaq->answer }}</textarea>
                                    </div>
                                    <button type="button" class="btn-icon btn-danger-icon-light shrink-0 delete-btn"
                                        data-id="{{ $bundleFaq->id }}" data-key="faq">
                                        <i class="ri-delete-bin-line text-inherit"></i>
                                    </button>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- COURSE OUTCOME -->
        <div class="card">
            <div class="grid grid-cols-12 gap-y-5 outcome-item">
                <div class="col-span-full">
                    <div class="flex-center-between">
                        <h6 class="leading-none text-xl font-semibold text-heading">
                            {{ translate('Add Bundle Outcomes') }} </h6>
                        <button type="button" class="btn b-solid btn-primary-solid add-outcomes"> <i
                                class="ri-add-circle-line text-inherit"></i> {{ translate('Add') }}
                        </button>
                    </div>
                </div>
                <div class="col-span-full">
                    <div class="flex flex-col gap-5 outcomes-area"
                        data-length="{{ isset($bundle, $bundle->bundleOutComes) ? $bundle->bundleOutComes->count() : 0 }}">
                        @if (isset($bundle, $bundle->bundleOutComes) && !empty($bundle->bundleOutComes))
                            @foreach ($bundle->bundleOutComes as $bundleOutCome)
                                <div class="flex gap-4">
                                    <div class="grow flex flex-col gap-2 relative">
                                        <input type="text" placeholder="{{ translate('Bundle Outcomes') }}"
                                            id="searchInput" name="outcomes[{{ $bundleOutCome->id }}][title]"
                                            class="form-input outcomes search-suggestion"
                                            value="{{ $bundleOutCome->title }}" data-search-type="outcomes">

                                        <div class="search-show"></div>
                                    </div>
                                    <button type="button" class="btn-icon btn-danger-icon-light shrink-0 delete-btn">
                                        <i class="ri-delete-bin-line text-inherit"></i>
                                    </button>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card flex-center gap-4 justify-end">
            <button type="button" class="prev-form-btn btn b-outline btn-primary-outline">
                {{ translate('Previous') }}
            </button>
            <button type="button" class="next-form-btn btn b-solid btn-primary-solid dk-theme-card-square">
                {{ translate('Save & Continue') }}
            </button>
        </div>
    </form>
</div>
