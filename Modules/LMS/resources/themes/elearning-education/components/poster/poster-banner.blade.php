@php
    $response =
        get_theme_option('poster' . active_language()) ?:
        get_theme_option('posteren') ?? get_theme_option('postere' . app('default_language'));
    $posters = $response['poster'] ?? [];
    $defaultBanner = 'lms/frontend/assets/images/poster/become-a-student.png';
    $bannerPath = 'storage/lms/theme-options';

@endphp

@if (is_iterable($posters) && count($posters) > 0)
    <div class="bg-white pt-16 sm:pt-24 lg:pt-[120px]">
        <div class="container">
            <div class="grid grid-cols-12 gap-4 xl:gap-7">
                @foreach ($posters as $key => $poster)
                    <div class="col-span-full lg:col-span-6">
                        @php
                            $posterImage = $poster['poster_img'] ?? '';
                            $bannerImage =
                                $posterImage && fileExists('lms/theme-options', $posterImage) == true
                                    ? asset("$bannerPath/{$posterImage}")
                                    : asset($defaultBanner);
                        @endphp
                        <div 
                            class="flex flex-col {{ $loop->iteration % 2 == 0 ? 'bg-secondary text-heading' : 'bg-primary text-white' }} bg-no-repeat bg-cover bg-right h-[300px] px-10 py-12 pb-[60px] rtl:rotate-xz-180"
                            style='{{ $bannerImage ? "background-image: url( $bannerImage)" : '' }}'
                        >
                            <div class="rtl:rotate-xz-180">
                                <h3 class="area-title lg:text-3xl text-inherit">
                                    {{ $poster['title'] ?? '' }}
                                </h3>
                                <p class="area-description mt-3 text-inherit sm:max-w-[60%]">
                                    {{ $poster['description'] ?? '' }}
                                </p>
                                <a href="{{ $poster['button_link'] ?? '#' }}" aria-label="Poster call to action"
                                    class="btn b-solid {{ $loop->iteration % 2 == 0 ? 'btn-primary-solid' : 'btn-secondary-solid' }} btn-lg !rounded-none mt-11">
                                    {{ $poster['button_label'] ?? translate('Learn More') }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
