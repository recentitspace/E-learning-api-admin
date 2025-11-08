<x-dashboard-layout>
    <x-slot:title>{{ isset($certificate) ? translate('Edit') : translate('Create') }}
        {{ translate('Cerficate') }} </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="{{ isset($certificate) ? 'Edit' : 'Create' }} Certificate" page-to="Certificate" />
    <div class="overflow-x-auto scrollbar-table">
        @php
            $inputContent = $certificate->input_content ?? null;

        @endphp
        <form
            action="{{ isset($certificate) ? route('certificate.update', $certificate->id) : route('certificate.store') }}"
            class="add-cerficate" method="post">
            @if (isset($certificate))
                @method('PUT')
            @endif
            @csrf
            <div class="card">
                <div id="certificate-builder-area" class="certificate-builder-area text-align-justify !overflow-x-auto">
                    @if (isset($certificate))
                        {!! $certificate->certificate_content !!}
                    @else
                        <div class="certificate-template-container" id="certificateImg"
                            style="background: url('{{ asset('lms/assets/images/certificate-template.jpg') }}'); background-repeat:no-repeat; background-size: 100% 100% ">
                            <div data-name="student" class="dragable-element">{student_name}</div>
                            <div data-name="platform-name" class="dragable-element">{platform_name}</div>
                            <div data-name="course-completed-date" class="dragable-element">{course_title}</div>
                            <div data-name="course-completed-date" class="dragable-element">
                                {course_completed_date} </div>
                            <div data-name="course-completed-date" class="dragable-element">{instructor_name}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="card">
                <div class="form-group">
                    <label for="courseTitle" class="form-label">{{ translate('Certificate Template Image') }}
                        ({{ translate('1056') }}x{{ translate('816') }})</label>
                    <label for="imgage"
                        class="dropzone-wrappe file-container ac-bg text-xs leading-none font-semibold mb-3 cursor-pointer size-[200px] flex flex-col items-center justify-center gap-2.5 border border-dashed border-gray-900 rounded-10 dk-theme-card-square">
                        <input type="file" class="dropzone theme-setting-image" data-type="certificate" hidden
                            id="imgage">
                        <input type="hidden" name="item[bg]" id="oldFile">
                        <span class="flex-center flex-col peer-[.uploaded]/file:hidden">
                            <img src="{{ asset('lms/') }}/assets/images/icons/upload-file.svg" alt="file-icon"
                                class="size-8 lg:size-auto">
                            <div class="text-gray-500 dark:text-dark-text mt-2">
                                {{ translate('Choose file') }}
                            </div>
                        </span>
                    </label>
                    <div class="preview-zone dropzone-preview">
                        <div class="box box-solid">
                            <div class="box-body flex items-center gap-2 flex-wrap">
                                @if (isset($certificate, $inputContent['bg']))
                                    @if (fileExists($folder = 'lms/certificates', $inputContent['bg']) == true && $inputContent['bg'] != '')
                                        <img id="preview_img" width="120"
                                            src="{{ asset('storage/lms/certificates/' . $inputContent['bg']) }}" />
                                    @endif
                                @endif
                            </div>
                            <img id="preview_img" src="" width="120">
                        </div>
                    </div>
                </div>
                <div class="form-group mt-6">
                    <label for="courseTitle" class="form-label">{{ translate('Certificate Name') }}</span></label>
                    <input type="text" name="title" placeholder="{{ translate('Certificate Title') }}"
                        class="form-input dragable-element-control dragable-element-title"
                        value="{{ $certificate->title ?? '' }}" required>
                </div>
                <div class="element-area hidden" data-item="title">
                    <div class="form-group mt-6">
                        <label for="courseTitle" class="form-label">{{ translate('Title Font Color') }}</label>
                        <div
                            class="flex items-center border border-input-border dark:border-dark-border rounded-md p-[3px_4px] gap-1 h-11">
                            <input type="color" name="item[title][color]" id="color-picker"
                                value="{{ isset($certificate) ? $inputContent['title']['color'] ?? null : '' }}"
                                class="dragable-element-control dragable-element-color border-none outline-0 bg-transparent size-[30px]">
                            <div class="color-value font-semibold text-gray-500 dark:text-dark-text uppercase">
                                {{ isset($certificate) ? $inputContent['title']['color'] ?? null : '' }}</div>
                        </div>
                    </div>
                    <div class="form-group mt-6 hidden">
                        <label for="courseTitle" class="form-label">{{ translate('Title Font Size') }}</span></label>
                        <input type="number" name="item[title][font_size]"
                            value="{{ isset($certificate) ? $inputContent['title']['font_size'] ?? 18 : 18 }}"
                            min="5" class="form-input dragable-element-control dragable-element-size">
                    </div>
                </div>
            </div>
            <div class="card flex justify-end">
                <button type="submit" class="btn b-solid btn-primary-solid dk-theme-card-square">
                    {{ isset($certificate) ? translate('Update') : translate('Save') }}
                </button>
            </div>
        </form>
    </div>
    @push('js')
        <script src="{{ asset('lms/assets/js/vendor/jquery-ui.min.js') }}"></script>
        <script src="{{ edulab_asset('lms/assets/js/component/certificate.js') }}"></script>
    @endpush
</x-dashboard-layout>
