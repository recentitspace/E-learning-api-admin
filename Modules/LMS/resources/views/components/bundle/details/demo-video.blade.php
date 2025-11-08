<div id="demo-video-modal" class="fixed inset-0 z-modal flex-center !hidden bg-black/50 modal">
    <div
        class="modal-content bg-white rounded-lg shadow-lg w-full max-w-screen-md transform transition-all duration-300 opacity-0 -translate-y-10 m-4">
        <!-- Modal Header -->
        <div class="flex items-center justify-between p-4 border-b">
            <div>
                <div class="area-subtitle">
                    {{ translate('Free Course Preview') }}
                </div>
                <h2 class="text-xl font-semibold mt-1">{{ $bundle->title }}</h2>
            </div>
            <button type="button" aria-label="Course demo video modal close button"
                class="absolute top-3 end-2.5 text-heading dark:text-white bg-gray-200 rounded-lg size-8 flex-center close-modal-btn demo-course-video-stop">
                <i class="ri-close-line text-inherit"></i>
            </button>
        </div>
        <!-- Modal Body -->
        <div class="p-4 pt-0 max-h-[80vh] overflow-auto">
            <x-theme::bundle.details.video-play :bundle="$bundle" />
        </div>
    </div>
</div>
