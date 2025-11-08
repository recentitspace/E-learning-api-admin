<x-frontend-layout>
    <x-theme::breadcrumbs.breadcrumb-one pageTitle="Assignment" pageRoute="#" pageName="Assignment" />
    @php
        $assignment = $data['assignment'];
        $userExam = $data['userExam'];
        $type = $data['type'];
    @endphp

    <!-- START INNER CONTENT AREA -->
    <div class="container">
        <!-- ASSIGNMENT HEADER -->
        <div class="flex !justify-end sm:!justify-between gap-4">
            <div class="hidden sm:block grow">
                <h2 class="area-title text-2xl">{{ $assignment?->topic?->chapter?->course?->title ?? '' }}</h2>
                <ul class="flex items-center flex-wrap gap-1.5 *:flex-center *:gap-1.5 leading-none mt-4">
                    @if ($assignment?->topic?->chapter?->title)
                        <li
                            class="text-lg leading-none font-semibold text-heading/90 after:font-remix after:flex-center after:font-thin after:text-heading/60 after:size-5 after:content-['\f2e5'] rtl:after:content-['\f2e3'] after:translate-y-[1.4px] last:after:hidden">
                            {{ $assignment?->topic?->chapter?->title ?? '' }}
                        </li>
                    @endif
                    <li
                        class="text-lg leading-none font-semibold text-primary after:font-remix after:flex-center after:font-thin after:text-heading/60 after:size-5 after:content-['\f2e5'] rtl:after:content-['\f2e3'] after:translate-y-[1.4px] last:after:hidden">
                        {{ $assignment->title }}
                    </li>
                </ul>
            </div>
            <div class="shrink-0">
                @php
                    $actionRoute = route('play.course', [
                        'slug' => $assignment?->topic?->chapter?->course?->slug,
                        'topic_id' => $assignment?->topic?->id ?? null,
                        'type' => $type,
                        'chapter_id' => $assignment?->topic?->chapter?->id ?? null,
                    ]);
                @endphp
                <a href="{{ $actionRoute }}" class="btn b-solid btn-primary-solid" aria-label="Course video">
                    <i class="ri-arrow-left-line rtl:before:content-['\ea6c']"></i>
                    {{ translate('Course Video') }}
                </a>
            </div>
        </div>
        <!-- ASSIGNMENT OVERVIEW -->
        <div class="assignment-overview mt-10">
            <div class="grid grid-cols-10 gap-6">
                @php
                    $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="41" height="24" viewBox="0 0 41 24" fill="none">
                                <path d="M20.0339 9.53995C21.8811 9.53995 23.6967 10.026 25.2839 10.9458C25.7041 11.1894 26.1088 11.4635 26.4919 11.7623L20.778 16.1381C20.6354 16.111 20.4913 16.0904 20.3457 16.0793C20.2408 16.0713 20.1358 16.0668 20.0339 16.0668C17.8467 16.0668 16.0673 17.8462 16.0673 20.0334C16.0673 22.2205 17.8467 24 20.0339 24C22.2211 24 24.0005 22.2205 24.0005 20.0334C24.0005 19.9305 23.9965 19.8255 23.9879 19.7216C23.9764 19.576 23.9563 19.4319 23.9292 19.2893L28.305 13.5758C29.741 15.414 30.5278 17.6906 30.5278 20.0339C30.5278 20.4496 30.8652 20.787 31.281 20.787H39.3146C39.7304 20.787 40.0678 20.4496 40.0678 20.0339C40.0678 17.3296 39.5381 14.7061 38.4932 12.2357C37.484 9.85025 36.0399 7.70778 34.2002 5.86807C32.3605 4.02837 30.218 2.58382 27.8326 1.5751C25.3617 0.529718 22.7382 0 20.0339 0C17.3296 0 14.7061 0.529718 12.2357 1.57459C9.85025 2.58382 7.70778 4.02787 5.86807 5.86757C4.02837 7.70727 2.58382 9.84975 1.5751 12.2352C0.529718 14.7061 0 17.3296 0 20.0339C0 20.4496 0.337413 20.787 0.753154 20.787H8.78679C9.20254 20.787 9.53995 20.4496 9.53995 20.0339C9.53995 16.3008 11.5494 12.8187 14.7844 10.9458C16.3716 10.026 18.1867 9.53995 20.0339 9.53995ZM20.0339 22.4942C18.6772 22.4942 17.5736 21.3906 17.5736 20.0339C17.5736 18.6772 18.6772 17.5736 20.0339 17.5736C20.0977 17.5736 20.1619 17.5761 20.2292 17.5816C21.4232 17.6745 22.3938 18.6451 22.4867 19.8396C22.4917 19.9049 22.4942 19.9706 22.4942 20.0344C22.4942 21.3906 21.3906 22.4942 20.0339 22.4942ZM38.5464 19.2807H32.0105C31.8504 16.7401 30.8838 14.3054 29.2475 12.3462L31.5471 9.34363C31.7314 9.10312 31.7103 8.78579 31.4959 8.57189C31.282 8.358 30.9647 8.33691 30.7242 8.52068L27.7216 10.8203C27.3887 10.5426 27.0397 10.2816 26.6777 10.04L29.9444 4.38587C34.9212 7.54961 38.2944 13.0205 38.5464 19.2807ZM20.0339 1.50631C23.1389 1.50631 26.0682 2.27452 28.6414 3.6302L25.3743 9.28538C23.7238 8.46444 21.8927 8.03364 20.0339 8.03364C18.1751 8.03364 16.3439 8.46495 14.694 9.28538L11.4263 3.6302C13.9996 2.27452 16.9289 1.50631 20.0339 1.50631ZM9.68807 13.9504C8.73307 15.5712 8.17523 17.4004 8.05724 19.2807H1.52137C1.77343 13.0205 5.14655 7.54961 10.1234 4.38587L13.3901 10.04C11.8813 11.0453 10.6104 12.3849 9.68807 13.9504Z" fill="#5F3EED"></path>
                            </svg>';
                @endphp
                <x-theme::exam.card.single-card-one icon="{!! $icon !!}"
                    title="{{ $assignment->pass_mark }}/{{ $assignment->total_mark }}"
                    description="Minimum Passing Score" />
                @php
                    $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="31" height="24" viewBox="0 0 31 24"
                                fill="none">
                                <path
                                    d="M15.6293 14.6576C17.059 13.7062 18.1445 12.32 18.7253 10.7039C19.3061 9.08786 19.3514 7.32777 18.8545 5.68397C18.3575 4.04017 17.3447 2.59995 15.9659 1.57632C14.587 0.552687 12.9153 0 11.1981 0C9.4808 0 7.80911 0.552687 6.43027 1.57632C5.05142 2.59995 4.03863 4.04017 3.54168 5.68397C3.04473 7.32777 3.09002 9.08786 3.67084 10.7039C4.25166 12.32 5.33717 13.7062 6.76683 14.6576C4.84314 15.1141 3.12928 16.2053 1.90162 17.7551C0.673969 19.3049 0.00408621 21.223 0 23.2001C0 23.4123 0.0842711 23.6157 0.234274 23.7657C0.384278 23.9157 0.587726 24 0.799862 24H21.5963C21.8084 24 22.0119 23.9157 22.1619 23.7657C22.3119 23.6157 22.3961 23.4123 22.3961 23.2001C22.3921 21.223 21.7222 19.3049 20.4945 17.7551C19.2669 16.2053 17.553 15.1141 15.6293 14.6576ZM4.79917 8.00276C4.79917 6.73717 5.17446 5.50001 5.87758 4.44772C6.5807 3.39542 7.58007 2.57526 8.74932 2.09094C9.91857 1.60663 11.2052 1.47991 12.4464 1.72681C13.6877 1.97371 14.8279 2.58315 15.7228 3.47805C16.6177 4.37295 17.2271 5.51313 17.474 6.75439C17.7209 7.99566 17.5942 9.28226 17.1099 10.4515C16.6256 11.6208 15.8054 12.6201 14.7531 13.3232C13.7008 14.0264 12.4637 14.4017 11.1981 14.4017C9.50098 14.4017 7.87339 13.7275 6.67337 12.5275C5.47334 11.3274 4.79917 9.69985 4.79917 8.00276ZM1.59972 22.4003C1.79729 20.6328 2.64211 19.0011 3.97133 17.8196C5.30055 16.6381 7.02008 15.9904 8.79848 16.0014H13.5977C15.3761 15.9904 17.0956 16.6381 18.4248 17.8196C19.754 19.0011 20.5988 20.6328 20.7964 22.4003H1.59972Z"
                                    fill="#5F3EED" />
                                <path
                                    d="M29.5972 11.2034H27.1976V8.80377C27.1976 8.59163 27.1133 8.38818 26.9633 8.23818C26.8133 8.08818 26.6099 8.00391 26.3977 8.00391C26.1856 8.00391 25.9822 8.08818 25.8322 8.23818C25.6822 8.38818 25.5979 8.59163 25.5979 8.80377V11.2034H23.1983C22.9862 11.2034 22.7827 11.2876 22.6327 11.4376C22.4827 11.5876 22.3984 11.7911 22.3984 12.0032C22.3984 12.2154 22.4827 12.4188 22.6327 12.5688C22.7827 12.7188 22.9862 12.8031 23.1983 12.8031H25.5979V15.2027C25.5979 15.4148 25.6822 15.6183 25.8322 15.7683C25.9822 15.9183 26.1856 16.0025 26.3977 16.0025C26.6099 16.0025 26.8133 15.9183 26.9633 15.7683C27.1133 15.6183 27.1976 15.4148 27.1976 15.2027V12.8031H29.5972C29.8093 12.8031 30.0128 12.7188 30.1628 12.5688C30.3128 12.4188 30.3971 12.2154 30.3971 12.0032C30.3971 11.7911 30.3128 11.5876 30.1628 11.4376C30.0128 11.2876 29.8093 11.2034 29.5972 11.2034Z"
                                    fill="#5F3EED" />
                            </svg>';
                @endphp
                <x-theme::exam.card.single-card-one icon="{!! $icon !!}"
                    title=" {{ $userExam->attempt_number ?? 0 }}/{{ $assignment->retake_number }}"
                    description="Available Attempts" />
                @php
                    $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28"
                                fill="none">
                                <path
                                    d="M14 0C10.2864 0 6.72597 1.47467 4.10069 4.10069C1.47452 6.72571 0 10.2864 0 14C0 17.7136 1.47467 21.274 4.10069 23.8993C6.72571 26.5255 10.2864 28 14 28C17.7136 28 21.274 26.5253 23.8993 23.8993C26.5255 21.2743 28 17.7136 28 14C27.9953 10.2876 26.5195 6.72926 23.8945 4.10547C21.2707 1.48046 17.7124 0.00477867 14 0ZM14 26.1333C10.7825 26.1333 7.69545 24.8547 5.4202 22.5798C3.1452 20.3048 1.86667 17.2178 1.86667 14C1.86667 10.7822 3.14532 7.69545 5.4202 5.4202C7.69521 3.1452 10.7822 1.86667 14 1.86667C17.2178 1.86667 20.3046 3.14532 22.5798 5.4202C24.8548 7.69521 26.1333 10.7822 26.1333 14C26.1298 17.2166 24.85 20.3013 22.575 22.575C20.3012 24.85 17.2166 26.1298 14 26.1333ZM13.9333 14.0667H20.4667V15.9333H12.0667V5.66667H13.9333V14.0667Z"
                                    fill="#5F3EED" />
                            </svg>';
                    $expireStatus = dateCompare($assignment->submission_date) ? 'Deadline' : 'Expire';
                @endphp
                <x-theme::exam.card.single-card-one icon="{!! $icon !!}"
                    title="{{ customDateFormate($assignment->submission_date, format: 'd M y') }}"
                    description="{{ $expireStatus }}" class="text-danger" />
                @php
                    $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="41" height="24" viewBox="0 0 41 24"  fill="none">
                                <path d="M20.0339 9.53995C21.8811 9.53995 23.6967 10.026 25.2839 10.9458C25.7041 11.1894 26.1088 11.4635 26.4919 11.7623L20.778 16.1381C20.6354 16.111 20.4913 16.0904 20.3457 16.0793C20.2408 16.0713 20.1358 16.0668 20.0339 16.0668C17.8467 16.0668 16.0673 17.8462 16.0673 20.0334C16.0673 22.2205 17.8467 24 20.0339 24C22.2211 24 24.0005 22.2205 24.0005 20.0334C24.0005 19.9305 23.9965 19.8255 23.9879 19.7216C23.9764 19.576 23.9563 19.4319 23.9292 19.2893L28.305 13.5758C29.741 15.414 30.5278 17.6906 30.5278 20.0339C30.5278 20.4496 30.8652 20.787 31.281 20.787H39.3146C39.7304 20.787 40.0678 20.4496 40.0678 20.0339C40.0678 17.3296 39.5381 14.7061 38.4932 12.2357C37.484 9.85025 36.0399 7.70778 34.2002 5.86807C32.3605 4.02837 30.218 2.58382 27.8326 1.5751C25.3617 0.529718 22.7382 0 20.0339 0C17.3296 0 14.7061 0.529718 12.2357 1.57459C9.85025 2.58382 7.70778 4.02787 5.86807 5.86757C4.02837 7.70727 2.58382 9.84975 1.5751 12.2352C0.529718 14.7061 0 17.3296 0 20.0339C0 20.4496 0.337413 20.787 0.753154 20.787H8.78679C9.20254 20.787 9.53995 20.4496 9.53995 20.0339C9.53995 16.3008 11.5494 12.8187 14.7844 10.9458C16.3716 10.026 18.1867 9.53995 20.0339 9.53995ZM20.0339 22.4942C18.6772 22.4942 17.5736 21.3906 17.5736 20.0339C17.5736 18.6772 18.6772 17.5736 20.0339 17.5736C20.0977 17.5736 20.1619 17.5761 20.2292 17.5816C21.4232 17.6745 22.3938 18.6451 22.4867 19.8396C22.4917 19.9049 22.4942 19.9706 22.4942 20.0344C22.4942 21.3906 21.3906 22.4942 20.0339 22.4942ZM38.5464 19.2807H32.0105C31.8504 16.7401 30.8838 14.3054 29.2475 12.3462L31.5471 9.34363C31.7314 9.10312 31.7103 8.78579 31.4959 8.57189C31.282 8.358 30.9647 8.33691 30.7242 8.52068L27.7216 10.8203C27.3887 10.5426 27.0397 10.2816 26.6777 10.04L29.9444 4.38587C34.9212 7.54961 38.2944 13.0205 38.5464 19.2807ZM20.0339 1.50631C23.1389 1.50631 26.0682 2.27452 28.6414 3.6302L25.3743 9.28538C23.7238 8.46444 21.8927 8.03364 20.0339 8.03364C18.1751 8.03364 16.3439 8.46495 14.694 9.28538L11.4263 3.6302C13.9996 2.27452 16.9289 1.50631 20.0339 1.50631ZM9.68807 13.9504C8.73307 15.5712 8.17523 17.4004 8.05724 19.2807H1.52137C1.77343 13.0205 5.14655 7.54961 10.1234 4.38587L13.3901 10.04C11.8813 11.0453 10.6104 12.3849 9.68807 13.9504Z" fill="#5F3EED" />
                            </svg>';
                @endphp
                @php
                    $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="41" height="24" viewBox="0 0 41 24"  fill="none">
                                <path d="M20.0339 9.53995C21.8811 9.53995 23.6967 10.026 25.2839 10.9458C25.7041 11.1894 26.1088 11.4635 26.4919 11.7623L20.778 16.1381C20.6354 16.111 20.4913 16.0904 20.3457 16.0793C20.2408 16.0713 20.1358 16.0668 20.0339 16.0668C17.8467 16.0668 16.0673 17.8462 16.0673 20.0334C16.0673 22.2205 17.8467 24 20.0339 24C22.2211 24 24.0005 22.2205 24.0005 20.0334C24.0005 19.9305 23.9965 19.8255 23.9879 19.7216C23.9764 19.576 23.9563 19.4319 23.9292 19.2893L28.305 13.5758C29.741 15.414 30.5278 17.6906 30.5278 20.0339C30.5278 20.4496 30.8652 20.787 31.281 20.787H39.3146C39.7304 20.787 40.0678 20.4496 40.0678 20.0339C40.0678 17.3296 39.5381 14.7061 38.4932 12.2357C37.484 9.85025 36.0399 7.70778 34.2002 5.86807C32.3605 4.02837 30.218 2.58382 27.8326 1.5751C25.3617 0.529718 22.7382 0 20.0339 0C17.3296 0 14.7061 0.529718 12.2357 1.57459C9.85025 2.58382 7.70778 4.02787 5.86807 5.86757C4.02837 7.70727 2.58382 9.84975 1.5751 12.2352C0.529718 14.7061 0 17.3296 0 20.0339C0 20.4496 0.337413 20.787 0.753154 20.787H8.78679C9.20254 20.787 9.53995 20.4496 9.53995 20.0339C9.53995 16.3008 11.5494 12.8187 14.7844 10.9458C16.3716 10.026 18.1867 9.53995 20.0339 9.53995ZM20.0339 22.4942C18.6772 22.4942 17.5736 21.3906 17.5736 20.0339C17.5736 18.6772 18.6772 17.5736 20.0339 17.5736C20.0977 17.5736 20.1619 17.5761 20.2292 17.5816C21.4232 17.6745 22.3938 18.6451 22.4867 19.8396C22.4917 19.9049 22.4942 19.9706 22.4942 20.0344C22.4942 21.3906 21.3906 22.4942 20.0339 22.4942ZM38.5464 19.2807H32.0105C31.8504 16.7401 30.8838 14.3054 29.2475 12.3462L31.5471 9.34363C31.7314 9.10312 31.7103 8.78579 31.4959 8.57189C31.282 8.358 30.9647 8.33691 30.7242 8.52068L27.7216 10.8203C27.3887 10.5426 27.0397 10.2816 26.6777 10.04L29.9444 4.38587C34.9212 7.54961 38.2944 13.0205 38.5464 19.2807ZM20.0339 1.50631C23.1389 1.50631 26.0682 2.27452 28.6414 3.6302L25.3743 9.28538C23.7238 8.46444 21.8927 8.03364 20.0339 8.03364C18.1751 8.03364 16.3439 8.46495 14.694 9.28538L11.4263 3.6302C13.9996 2.27452 16.9289 1.50631 20.0339 1.50631ZM9.68807 13.9504C8.73307 15.5712 8.17523 17.4004 8.05724 19.2807H1.52137C1.77343 13.0205 5.14655 7.54961 10.1234 4.38587L13.3901 10.04C11.8813 11.0453 10.6104 12.3849 9.68807 13.9504Z" fill="#5F3EED" />
                            </svg>';
                @endphp
                <x-theme::exam.card.single-card-one icon="{!! $icon !!}"
                    title="{{ $userExam->score ?? translate('Your Score') }}" description="Your Score" />
                @php
                    $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="25" viewBox="0 0 24 25"
                                fill="none">
                                <path opacity="0.969" fill-rule="evenodd" clip-rule="evenodd"
                                    d="M10.8281 0.640381C11.4531 0.640381 12.0781 0.640381 12.7031 0.640381C12.7031 2.20288 12.7031 3.76538 12.7031 5.32788C13.1563 5.32788 13.6094 5.32788 14.0625 5.32788C14.0625 4.32788 14.0625 3.32788 14.0625 2.32788C15.4844 2.32788 16.9063 2.32788 18.3281 2.32788C18.3281 3.74975 18.3281 5.17163 18.3281 6.59351C19.2656 6.59351 20.2031 6.59351 21.1406 6.59351C21.1406 7.1404 21.1406 7.68724 21.1406 8.23413C22.0937 8.23413 23.0469 8.23413 24 8.23413C24 10.0623 24 11.8904 24 13.7185C23.3997 18.2567 21.056 21.5457 16.9688 23.5857C15.6768 24.1586 14.3331 24.5102 12.9375 24.6404C12.2969 24.6404 11.6563 24.6404 11.0156 24.6404C6.34875 24.0585 2.99717 21.6523 0.960938 17.4216C0.455879 16.2293 0.135566 14.995 0 13.7185C0 12.9998 0 12.281 0 11.5623C0.624577 6.8981 3.06208 3.56217 7.3125 1.55444C8.45025 1.09428 9.62212 0.78959 10.8281 0.640381ZM11.1094 2.09351C11.1562 2.09351 11.2031 2.09351 11.25 2.09351C11.2578 5.53104 11.25 8.96852 11.2266 12.406C9.09375 15.0466 6.96094 17.6873 4.82812 20.3279C2.3519 17.9705 1.23471 15.0799 1.47656 11.656C1.93226 8.03126 3.72132 5.28906 6.84375 3.42944C8.18386 2.70399 9.60572 2.25868 11.1094 2.09351ZM15.5156 3.78101C15.9688 3.78101 16.4219 3.78101 16.875 3.78101C16.875 6.49976 16.875 9.21851 16.875 11.9373C16.4219 11.9373 15.9688 11.9373 15.5156 11.9373C15.5156 9.21851 15.5156 6.49976 15.5156 3.78101ZM12.7031 6.78101C13.1563 6.78101 13.6094 6.78101 14.0625 6.78101C14.0625 8.49977 14.0625 10.2185 14.0625 11.9373C13.6094 11.9373 13.1563 11.9373 12.7031 11.9373C12.7031 10.2185 12.7031 8.49977 12.7031 6.78101ZM18.3281 8.04663C18.7813 8.04663 19.2344 8.04663 19.6875 8.04663C19.6875 9.34352 19.6875 10.6404 19.6875 11.9373C19.2344 11.9373 18.7813 11.9373 18.3281 11.9373C18.3281 10.6404 18.3281 9.34352 18.3281 8.04663ZM21.1406 9.68726C21.625 9.68726 22.1094 9.68726 22.5938 9.68726C22.5938 10.4373 22.5938 11.1873 22.5938 11.9373C22.1094 11.9373 21.625 11.9373 21.1406 11.9373C21.1406 11.1873 21.1406 10.4373 21.1406 9.68726ZM12.7031 13.3435C15.9844 13.3435 19.2656 13.3435 22.5469 13.3435C22.1049 17.4718 20.0268 20.4484 16.3125 22.2732C15.1631 22.789 13.9599 23.0937 12.7031 23.1873C12.7031 19.906 12.7031 16.6248 12.7031 13.3435ZM11.2031 14.7498C11.25 17.5543 11.2656 20.3668 11.25 23.1873C9.31008 23.0293 7.54444 22.3965 5.95312 21.2888C7.70916 19.112 9.45914 16.9323 11.2031 14.7498Z"
                                    fill="#5F3EED" />
                            </svg>';

                    $status = empty($userExam) ? translate('Not Submitted') : ($userExam->score === null ? translate('Pending') : ($userExam->score >= $assignment->pass_mark ? translate('Pass') : translate('Fail')));
                @endphp
                <x-theme::exam.card.single-card-one icon="{!! $icon !!}" title="{{ translate($status) }}  "
                    description="Status"
                    class="{{ $status == 'Fail' ? 'text-danger' : ($status == 'Pass' ? 'text-success' : '') }}" />
            </div>
        </div>
        <!-- ASSIGNMENT STEP FORM -->
        <div class="mt-14">
            <!-- BEFORE STARTING THE QUIZ -->
            <div class="[&>:not(:first-child)]:mt-10">
                <x-theme::exam.assignment.attach-file :assignment="$assignment" />
                <article class="bg-white p-6 border border-border rounded-xl shadow-md">
                    <h6 class="area-title text-xl">{{ translate('Assignment History') }}</h6>
                    <div class="mt-5">
                        <div class="grid grid-cols-12 gap-6">
                            <div class="col-span-full lg:col-span-5">
                                @php
                                    $userAttemptNumber = $userExam->attempt_number ?? 0;
                                @endphp
                                @if ($userAttemptNumber != $assignment->retake_number && dateCompare($assignment->submission_date))
                                    <form action="{{ route('exam.store') }}"
                                        class="border border-border rounded-xl p-4 form" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <h2 class="area-title text-xl font-semibold">
                                            {{ translate('Submit Assignment') }}</h2>
                                        @csrf
                                        <input type="hidden" name="type" value="{{ $type }}">
                                        <input type="hidden" name="assignment_id" value="{{ $assignment->id }}">
                                        <input type="hidden" name="course_id"
                                            value="{{ $assignment->topic->course_id ?? null }}">
                                        <input type="hidden" name="chapter_id"
                                            value="{{ $assignment->topic->chapter_id ?? null }}">
                                        <input type="hidden" name="topic_id"
                                            value="{{ $assignment->topic->id ?? null }}">

                                        <div class="grid grid-cols-2 gap-x-3 gap-y-4 mt-4">
                                            <div class="col-span-full">
                                                <label for="assignment-description"
                                                    class="form-label">{{ translate('Description') }}</label>
                                                <div class="relative">
                                                    <textarea id="assignment-description" rows="5" name="description" class="form-input h-auto" placeholder=""></textarea>
                                                </div>
                                                <span class="text-danger error-text description_err"></span>
                                            </div>
                                            <div class="col-span-full">
                                                <label for="assignment-file-title"
                                                    class="form-label">{{ translate('File Title') }}</label>
                                                <div class="relative">
                                                    <input type="text" id="assignment-file-title" class="form-input"
                                                        name="file_title" placeholder="{{ translate('Enter File Name') }}" autocomplete="off" />
                                                </div>
                                            </div>
                                            <div class="col-span-full">
                                                <label for="assignment-file"
                                                    class="form-label">{{ translate('Attachment File') }}</label>
                                                <div class="relative">
                                                    <input type="file" id="assignment-file" name="source[]"
                                                        class="form-input" placeholder="" />
                                                </div>
                                                <span class="text-danger error-text source_err"></span>
                                            </div>
                                            <div class="col-span-full">
                                                <button type="submit" aria-label="Submit assignment"
                                                    class="btn b-solid btn-info-solid !font-medium">
                                                    {{ translate('Submit') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                @else
                                    <!-- MISS ASSIGNMENT DEADLINE BANNER -->
                                    <div class="bg-white border border-border rounded-xl h-[400px]">
                                        <div
                                            class="flex-center flex-col gap-4 p-6 text-center max-w-screen-sm mx-auto h-full">
                                            <h2 class="area-title text-2xl text-danger">
                                                {{ translate('Submission Closed!') }}</h2>
                                            <p class="area-description">
                                                {{ translate('You missed the submission deadline for this assignment.Please contact your instructor if you need any assistance or have extenuating circumstances.') }}
                                            </p>
                                        </div>
                                    </div>
                                @endif
                                @if (isInstructor())
                                    <form
                                        action="{{ isset($userExam->id) ? route('instructor.assignment.mark', $userExam->id) : '#' }}"
                                        class="border border-border rounded-xl p-4 mt-6 form" method="POST">
                                        @csrf
                                        <h2 class="area-title text-xl font-semibold">
                                            {{ translate('Grade the Submission') }}</h2>
                                        <div class="grid grid-cols-2 gap-x-3 gap-y-4 mt-4">
                                            <div class="col-span-full">
                                                <label for="assignment-grade"
                                                    class="form-label">{{ translate('Assignment Grade') }}</label>
                                                <div class="relative">
                                                    <input type="number" id="assignment-grade" name="score"
                                                        class="form-input"
                                                        placeholder=" {{ isset($userExam->score) && $userExam->score ? translate('Current Mark is') . ' ' . $userExam->score : $assignment->pass_mark }}" />
                                                </div>
                                            </div>
                                            @if (isset($userExam->id))
                                                <div class="col-span-full">
                                                    <button type="submit" aria-label="Save assignment"
                                                        class="btn b-solid btn-info-solid !font-medium">
                                                        {{ translate('Save') }}
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </form>
                                @endif
                            </div>
                            <div class="col-span-full lg:col-span-7">
                                <x-theme::exam.assignment.student-file :userExam="$userExam" />
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
    <!-- END INNER CONTENT AREA -->
</x-frontend-layout>
