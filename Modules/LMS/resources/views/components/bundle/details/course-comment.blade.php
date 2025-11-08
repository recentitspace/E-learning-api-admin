@if ($course->reviews->count() > 0)
    <article>
        <h2 class="area-title xl:text-3xl mb-5">
            {{ translate('Comments') }}
        </h2>
        <ul class="flex flex-col gap-5">
            @foreach ($course->reviews as $review)
                <!-- single comment -->
                @php
                    $user = $review?->user?->userable ?? null;
                    $profile_img = $user?->profile_img ?? '';

                    $imgSrc =
                        $profile_img && fileExists('lms/students', $profile_img) == true
                            ? asset("storage/lms/students/{$profile_img}")
                            : asset('lms/frontend/assets/images/placeholder/profile.jpg');
                    $userTransData = parse_translation($user);
                    $firstName = $userTransData['first_name'] ?? ($user->first_name ?? '');
                    $lastName = $userTransData['last_name'] ?? ($user->last_name ?? '');

                @endphp
                <li class="border border-border rounded-2xl p-7">
                    <div class="flex items-center gap-3.5">
                        <div class="size-12 overflow-hidden rounded-50 shrink-0">
                            <img data-src="{{ $imgSrc }}" alt="Student profile image" class="size-full object-cover">
                        </div>
                        <div>
                            <h6 class="area-title text-base !leading-none font-bold">
                                @if (isset($user->first_name, $user->last_name))
                                    {{ $firstName . '' . $lastName }}
                                @else
                                    {{ $userTransData['name'] ?? ($user->name ?? '') }}
                                @endif
                            </h6>
                            @php
                                $totalRating = user_review_rating($review->course_id, $review->user_id);
                            @endphp
                            <div class="flex items-center gap-2 mt-2">
                                <div class="flex items-center gap-0.5 text-secondary">
                                    {!! show_rating($totalRating) !!}
                                </div>
                                <div class="text-heading/60 text-sm leading-none">
                                    {{ customDateFormate($review->created_at) }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="text-heading/70 font-semibold leading-[1.55] mt-6 grow">
                        <p>
                            {!! clean($review->content) !!}
                        </p>
                    </div>
                </li>
            @endforeach
        </ul>
    </article>
@endif

@if ($auth && $purchaseCheck == true)
    <article>
        <h2 class="area-title xl:text-3xl mb-5">
            {{ translate('Share Your Feedback') }}
        </h2>
        <form action="{{ route('review') }}" class="form" method="POST">
            @csrf

            @php
                $user = $auth->userable;
                $name = $user->name ?? $user->first_name . ' ' . $user->last_name;
            @endphp

            <input type="hidden" value="{{ $course->id }}" name="course_id">

            <div class="grid grid-cols-2 gap-x-3 gap-y-4">
                <div class="col-span-full lg:col-auto">
                    <div class="relative">
                        <input type="text" id="user-full-name" class="form-input rounded-full peer"
                            value="{{ $name }}" />
                        <label for="user-full-name" class="form-label floating-form-label">
                            {{ translate('Full Name') }}
                        </label>
                    </div>
                </div>
                <div class="col-span-full lg:col-auto">
                    <div class="relative">
                        <input type="email" id="user-email" class="form-input rounded-full peer"
                            value="{{ $auth->email }}" />
                        <label for="user-email" class="form-label floating-form-label"> {{ translate('Email') }}
                        </label>
                    </div>
                </div>
                <div class="col-span-full grid grid-cols-3 gap-x-3 gap-y-4">
                    <!-- REVIEW FOR CONTENT -->
                    <div class="col-span-full xl:col-auto">
                        <div class="form-input rounded-full flex items-center gap-2">
                            <label class="form-label !m-0"> {{ translate('Content') }} :</label>
                            <div class="flex items-center flex-row-reverse gap-2">
                                <!-- Star 1 -->
                                <input type="radio" name="content_quality" id="con_star1" value="5"
                                    class="hidden peer">
                                <label for="con_star1"
                                    class="cursor-pointer text-gray-300 peer-checked:text-secondary hover:text-secondary">
                                    <i class="ri-star-fill text-base"></i>
                                </label>
                                <!-- Star 2 -->
                                <input type="radio" name="content_quality" id="con_star2" value="4"
                                    class="hidden peer">
                                <label for="con_star2"
                                    class="cursor-pointer text-gray-300 peer-checked:text-secondary hover:text-secondary">
                                    <i class="ri-star-fill text-base"></i>
                                </label>
                                <!-- Star 3 -->
                                <input type="radio" name="content_quality" id="con_star3" value="3"
                                    class="hidden peer">
                                <label for="con_star3"
                                    class="cursor-pointer text-gray-300 peer-checked:text-secondary hover:text-secondary">
                                    <i class="ri-star-fill text-base"></i>
                                </label>
                                <!-- Star 4 -->
                                <input type="radio" name="content_quality" id="con_star4" value="2"
                                    class="hidden peer">
                                <label for="con_star4"
                                    class="cursor-pointer text-gray-300 peer-checked:text-secondary hover:text-secondary">
                                    <i class="ri-star-fill text-base"></i>
                                </label>
                                <!-- Star 5 -->
                                <input type="radio" name="content_quality" id="con_star5" value="1"
                                    class="hidden peer">
                                <label for="con_star5"
                                    class="cursor-pointer text-gray-300 peer-checked:text-secondary hover:text-secondary">
                                    <i class="ri-star-fill text-base"></i>
                                </label>
                            </div>
                        </div>
                    </div>
                    <!-- REVIEW FOR INSTRUCTOR -->
                    <div class="col-span-full xl:col-auto">
                        <div class="form-input rounded-full flex items-center gap-2">
                            <label class="form-label !m-0"> {{ translate('Instructor') }} :</label>
                            <div class="flex items-center flex-row-reverse gap-2">
                                <!-- Star 1 -->
                                <input type="radio" name="instructor_skills" id="ins_star1" value="5"
                                    class="hidden peer">
                                <label for="ins_star1"
                                    class="cursor-pointer text-gray-300 peer-checked:text-secondary hover:text-secondary">
                                    <i class="ri-star-fill text-base"></i>
                                </label>
                                <!-- Star 2 -->
                                <input type="radio" name="instructor_skills" id="ins_star2" value="4"
                                    class="hidden peer">
                                <label for="ins_star2"
                                    class="cursor-pointer text-gray-300 peer-checked:text-secondary hover:text-secondary">
                                    <i class="ri-star-fill text-base"></i>
                                </label>
                                <!-- Star 3 -->
                                <input type="radio" name="instructor_skills" id="ins_star3" value="3"
                                    class="hidden peer">
                                <label for="ins_star3"
                                    class="cursor-pointer text-gray-300 peer-checked:text-secondary hover:text-secondary">
                                    <i class="ri-star-fill text-base"></i>
                                </label>
                                <!-- Star 4 -->
                                <input type="radio" name="instructor_skills" id="ins_star4" value="2"
                                    class="hidden peer">
                                <label for="ins_star4"
                                    class="cursor-pointer text-gray-300 peer-checked:text-secondary hover:text-secondary">
                                    <i class="ri-star-fill text-base"></i>
                                </label>
                                <!-- Star 5 -->
                                <input type="radio" name="instructor_skills" id="ins_star5" value="1"
                                    class="hidden peer">
                                <label for="ins_star5"
                                    class="cursor-pointer text-gray-300 peer-checked:text-secondary hover:text-secondary">
                                    <i class="ri-star-fill text-base"></i>
                                </label>
                            </div>
                        </div>
                    </div>
                    <!-- REVIEW FOR SUPPORT -->
                    <div class="col-span-full xl:col-auto">
                        <div class="form-input rounded-full flex items-center gap-2">
                            <label class="form-label !m-0"> {{ translate('Support') }}:</label>
                            <div class="flex items-center flex-row-reverse gap-2">
                                <!-- Star 1 -->
                                <input type="radio" name="support_quality" id="sup_star1" value="5"
                                    class="hidden peer">
                                <label for="sup_star1"
                                    class="cursor-pointer text-gray-300 peer-checked:text-secondary hover:text-secondary">
                                    <i class="ri-star-fill text-base"></i>
                                </label>
                                <!-- Star 2 -->
                                <input type="radio" name="support_quality" id="sup_star2" value="4"
                                    class="hidden peer">
                                <label for="sup_star2"
                                    class="cursor-pointer text-gray-300 peer-checked:text-secondary hover:text-secondary">
                                    <i class="ri-star-fill text-base"></i>
                                </label>
                                <!-- Star 3 -->
                                <input type="radio" name="support_quality" id="sup_star3" value="3"
                                    class="hidden peer">
                                <label for="sup_star3"
                                    class="cursor-pointer text-gray-300 peer-checked:text-secondary hover:text-secondary">
                                    <i class="ri-star-fill text-base"></i>
                                </label>
                                <!-- Star 4 -->
                                <input type="radio" name="support_quality" id="sup_star4" value="2"
                                    class="hidden peer">
                                <label for="sup_star4"
                                    class="cursor-pointer text-gray-300 peer-checked:text-secondary hover:text-secondary">
                                    <i class="ri-star-fill text-base"></i>
                                </label>
                                <!-- Star 5 -->
                                <input type="radio" name="support_quality" id="sup_star5" value="1"
                                    class="hidden peer">
                                <label for="sup_star5"
                                    class="cursor-pointer text-gray-300 peer-checked:text-secondary hover:text-secondary">
                                    <i class="ri-star-fill text-base"></i>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-full">
                    <div class="relative">
                        <textarea id="instructor-education" rows="10" class="form-input rounded-2xl h-auto peer" name="content"
                            placeholder=""></textarea>
                        <label for="instructor-education" class="form-label floating-form-label">
                            {{ translate('Write your message') }}
                        </label>
                    </div>
                    <span class="text-danger error-text content_err"></span>

                </div>
                <div class="col-span-full">
                    <button type="submit" class="btn b-solid btn-primary-solid !rounded-full"
                        aria-label="Submit review">
                        {{ translate('Submit Now') }}
                    </button>
                </div>
            </div>
        </form>
    </article>
@endif
