@php
    $languages = get_all_language();
@endphp
<div id="ai-content-modal-btn-wrapper" class="fixed top-1/4 right-0 rtl:right-auto rtl:left-0 translate-x-[98px] rtl:-translate-x-[98px] hover:translate-x-0 z-backdrop duration-200">
    <button type="button" class="ai-content-modal-btn flex-center gap-3.5 bg-primary text-white duration-300 rounded-l-lg rtl:rounded-l-none rtl:rounded-r-lg shadow-md" aria-label="Ai content generate button">
        <span class="flex-center pl-3.5 py-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 512 512">
                <path fill="currentColor" fill-rule="evenodd" d="M384 128v256H128V128zm-148.25 64h-24.932l-47.334 128h22.493l8.936-25.023h56.662L260.32 320h23.847zm88.344 0h-22.402v128h22.402zm-101 21.475l22.315 63.858h-44.274zM405.335 320H448v42.667h-42.667zm-256 85.333H192V448h-42.667zm85.333 0h42.666V448h-42.666zM149.333 64H192v42.667h-42.667zM320 405.333h42.667V448H320zM234.667 64h42.666v42.667h-42.666zM320 64h42.667v42.667H320zm85.333 170.667H448v42.666h-42.667zM64 320h42.667v42.667H64zm341.333-170.667H448V192h-42.667zM64 234.667h42.667v42.666H64zm0-85.334h42.667V192H64z" />
            </svg>
        </span>
        <span id="ai-content-modal-btn-dragger" class="flex-center pr-3.5 py-2 cursor-move">{{ translate('AI Content') }}</span>
    </button>
</div>
<div id="ai-modal-generate" data-visibility="false" class="w-full max-w-screen-md bg-white dark:bg-dark-card-shade rounded-lg !fixed top-4 right-4 z-modal duration-300 shadow-[0_0_10px_1px_rgba(0,0,0,0.75)] data-[visibility=true]:visible data-[visibility=true]:opacity-100 data-[visibility=true]:block data-[visibility=false]:invisible data-[visibility=false]:opacity-0 data-[visibility=false]:hidden">
    <div class="">
        <!-- Modal Header -->
        <div id="ai-content-modal-dragger" class="flex items-center justify-between p-4 border-b dark:border-dark-border cursor-move">
            <div class="card-title text-lg">
                {{ translate('AI Content') }}
            </div>
            <div class="flex items-center gap-2">
                <div aria-label="Ai content modal dragger indicator" class="btn btn-sm size-8 text-heading dark:text-dark-text bg-gray-200 dark:bg-dark-icon rounded-lg cursor-move">
                    <i class="ri-drag-move-2-fill text-inherit"></i>
                </div>
                <button type="button" aria-label="Ai content modal close button" class="btn btn-sm size-8 text-heading dark:text-dark-text bg-gray-200 dark:bg-dark-icon rounded-lg ai-content-modal-close-btn">
                    <i class="ri-close-line text-inherit"></i>
                </button>
            </div>
        </div>
        <!-- Modal Body -->
        <div class="p-4 pt-0 max-h-[80vh] overflow-auto">
            <form action="{{ route('generate.content') }}" method="post" class="form mt-2">
                @csrf
                <label class="form-label block">
                    <select name="service_type_id" class="singleSelect">
                        <option disabled selected>{{ translate('Select Type') }}</option>
                        @foreach (ai_service_type() as $aiServiceType)
                            <option value="{{ $aiServiceType->id }}">{{ $aiServiceType->title }}</option>
                        @endforeach
                    </select>
                </label>
                <label class="form-label block">
                    <input type="text" name="keyword" placeholder="{{ translate('Enter Keyword') }}" class="form-input" />
                    <span class="text-danger error-text keyword_err"></span>
                </label>
                <div class="grid grid-cols-2 gap-2">
                    <label class="col-span-full sm:col-span-1 form-label block">
                        <input type="number" name="max_token" placeholder="{{ translate('Max content length') }}" class="form-input" />
                    </label>
                    <label class="col-span-full sm:col-span-1 form-label block">
                        <select name="language" class="singleSelect">
                            @foreach ($languages as $key => $language)
                                <option value="{{ $language->name }}">{{ $language->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger error-text language_err"></span>
                    </label>
                </div>
                <button type="submit" class="btn b-solid btn-primary-solid w-full dk-theme-card-square my-3">{{ translate('Generate') }}</button>
                <div class="form-label block">
                    <textarea id="outputContent" class="form-input font-normal edit-ai-content" placeholder="{{ translate('Generated content will show here') }}" rows="10" readonly></textarea>
                    <div class="flex items-center justify-end gap-2 mt-1">
                        <button type="button" class="btn btn-sm [&.active]:bg-primary [&.active]:text-white" data-editor-class="edit-ai-content">
                            <i class="ri-file-edit-line text-[14px] text-inherit"></i>
                            {{ translate('Edit') }}
                        </button>
                        <button type="button" class="btn btn-sm [&.active]:bg-primary [&.active]:text-white copytext" data-copy-button>
                            <i class="ri-file-copy-line text-[14px] text-inherit"></i>
                            <span class="text">{{ translate('Copy') }}</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
