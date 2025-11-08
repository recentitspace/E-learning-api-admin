<article class="bg-white p-6 border border-border rounded-xl shadow-md">
    <h6 class="area-title text-xl">{{ translate('What to do') }}</h6>
    <div class="area-description mt-5">
        {!! clean($assignment->description) !!}
    </div>
    <div class="flex items-center gap-4 pt-5 mt-5 border-t border-border">
        @foreach ($assignment->sourceFiles as $sourceFile)
            @if (fileExists('lms/courses/topics/assignments', $sourceFile->file) == true && $sourceFile->file != '')
                <a target="_bank" href="{{ asset("storage/lms/courses/topics/assignments/{$sourceFile->file}") }}"
                    aria-label="Assignment information"
                    class="flex items-center gap-3 px-4 py-2 bg-primary-50 rounded-md border border-transparent hover:border-primary select-none custom-transition">
                    <i class="ri-file-download-line"></i>
                    <div>
                        <h6 class="area-title text-sm font-semibold !leading-none">
                            {{ $sourceFile->file_name ?? translate('Assignment file') }}</h6>
                        <p class="text-heading/70 leading-none text-xs mt-2 uppercase">
                            {{ getFileExtension($sourceFile->file) }}</p>
                    </div>
                </a>
            @endif
        @endforeach
    </div>
</article>
