<x-dashboard-layout>
    <x-slot:title> {{ translate('My Wishlist') }} </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb title="My Wishlist" page-to="wishlist" />
    <!-- Start Main Content -->
    <div class="card overflow-hidden">
        <div class="overflow-x-auto scrollbar-table">

            @if (count($wishlists) > 0)
                <table
                    class="table-auto w-full whitespace-nowrap text-left text-gray-500 dark:text-dark-text font-medium leading-none">
                    <thead class="text-primary-500">
                        <tr>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right">
                                {{ translate('Course Title') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right w-10">
                                {{ translate('Course Level') }}
                            </th>
                            <th
                                class="px-3.5 py-4 bg-[#F2F4F9] dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg first:dk-theme-card-square-left last:dk-theme-card-square-right w-10">
                                {{ translate('Action') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-dark-border-three">
                        @foreach ($wishlists as $wishlist)
                            @php
                                $translations = parse_translation($wishlist?->course);
                                $title = $translations['title'] ?? ($wishlist?->course->title ?? '');
                                $instructors = $wishlist?->course->instructors ?? [];
                                $thumbnail =
                                    fileExists(
                                        $folder = 'lms/courses/thumbnails',
                                        $fileName = $wishlist?->course->thumbnail,
                                    ) == true
                                        ? asset("storage/lms/courses/thumbnails/{$wishlist?->course->thumbnail}")
                                        : asset('lms/assets/images/placeholder/thumbnail612.jpg');

                            @endphp
                            <tr>
                                <td class="px-3.5 py-4">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('course.detail', $wishlist?->course?->slug) }}"
                                            class="size-[70px] rounded-50 overflow-hidden dk-theme-card-square">
                                            <img src="{{ $thumbnail }}" alt="thumb"
                                                class="size-full object-cover">
                                        </a>
                                        <div>
                                            <h6 class="text-lg leading-none text-heading dark:text-white font-bold mb-1.5 line-clamp-1"
                                                title="{{ $title }}">
                                                <a
                                                    href="{{ route('course.detail', $wishlist?->course?->slug) }}">{{ substr($title, 0, 30) . '...' }}</a>
                                            </h6>
                                            @if (count($instructors) > 0)
                                                <div class="flex items-center gap-2">
                                                    <p class="font-normal text-xs text-gray-900">
                                                        {{ translate('Instructors') }}
                                                        -
                                                        @foreach ($instructors as $instructor)
                                                            @php
                                                                $userInfo = $instructor->userable ?? null;
                                                                $userTranslations = parse_translation($userInfo);
                                                            @endphp
                                                            {{ $userTranslations['first_name'] ?? $userInfo?->first_name }}
                                                            {{ $userTranslations['last_name'] ?? $userInfo?->last_name }}
                                                        @endforeach
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-3.5 py-4">
                                    @if ($wishlist?->course?->levels?->count() > 0)
                                        @foreach ($wishlist?->course?->levels as $level)
                                            @php
                                                $levelTranslations = parse_translation($level);
                                            @endphp
                                            {{ $levelTranslations['name'] ?? $level->name }}
                                            @if (!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    @endif
                                </td>
                                <td class="px-3.5 py-4">
                                    <div class="flex items-center gap-1">
                                        <button class="btn-icon btn-danger-icon-light size-8 delete-btn-cs"
                                            data-action="{{ route('student.remove.wishlist', $wishlist->id) }}"
                                            data-title="Do you want to remove">
                                            <i class="ri-delete-bin-line text-inherit text-base"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <x-portal::admin.empty-card title="No Wishlist" />
            @endif
        </div>
    </div>
</x-dashboard-layout>
