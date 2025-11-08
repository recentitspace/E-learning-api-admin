<x-dashboard-layout>
    <x-slot:title>
        {{ translate('Review ') }}
    </x-slot:title>
    <!-- BREADCRUMB -->
    <x-portal::admin.breadcrumb back-url="{{ route('student.course-review.index') }}" title="{{ 'Review' }}"
        page-to="Review" />


    <form action="{{ route('student.course-review.store') }}" class="form" method="POST">
        @csrf


        <div class="grid grid-cols-2 gap-x-3 gap-y-4  card">


            <div class="col-span-full xl:col-auto leading-none mb-3">
                <label class="form-label"> {{ translate('Course') }} <span class="text-danger">*</span></label>
                <select class="singleSelect" name="course_id" required>
                    <option selected disabled> {{ translate('Select Course Type') }} </option>
                    @foreach (purchase_enrolled_courses() as $purchaseCourse)
                        @php
                            $courseTranslations = parse_translation($purchaseCourse?->course);
                        @endphp
                        <option value="{{ $purchaseCourse?->course?->id }}">
                            {{ $courseTranslations['title'] ?? $purchaseCourse?->course?->title }}</option>
                    @endforeach
                </select>
                <span class="text-danger error-text course_id_err"></span>
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
                                class="cursor-pointer text-gray-300 peer-checked:text-warning hover:text-warning">
                                <i class="ri-star-fill text-base text-inherit"></i>
                            </label>
                            <!-- Star 2 -->
                            <input type="radio" name="content_quality" id="con_star2" value="4"
                                class="hidden peer">
                            <label for="con_star2"
                                class="cursor-pointer text-gray-300 peer-checked:text-warning hover:text-warning">
                                <i class="ri-star-fill text-base text-inherit"></i>
                            </label>
                            <!-- Star 3 -->
                            <input type="radio" name="content_quality" id="con_star3" value="3"
                                class="hidden peer">
                            <label for="con_star3"
                                class="cursor-pointer text-gray-300 peer-checked:text-warning hover:text-warning">
                                <i class="ri-star-fill text-base text-inherit"></i>
                            </label>
                            <!-- Star 4 -->
                            <input type="radio" name="content_quality" id="con_star4" value="2"
                                class="hidden peer">
                            <label for="con_star4"
                                class="cursor-pointer text-gray-300 peer-checked:text-warning hover:text-warning">
                                <i class="ri-star-fill text-base text-inherit"></i>
                            </label>
                            <!-- Star 5 -->
                            <input type="radio" name="content_quality" id="con_star5" value="1"
                                class="hidden peer">
                            <label for="con_star5"
                                class="cursor-pointer text-gray-300 peer-checked:text-warning hover:text-warning">
                                <i class="ri-star-fill text-base text-inherit"></i>
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
                                class="cursor-pointer text-gray-300 peer-checked:text-warning hover:text-warning">
                                <i class="ri-star-fill text-base text-inherit"></i>
                            </label>
                            <!-- Star 2 -->
                            <input type="radio" name="instructor_skills" id="ins_star2" value="4"
                                class="hidden peer">
                            <label for="ins_star2"
                                class="cursor-pointer text-gray-300 peer-checked:text-warning hover:text-warning">
                                <i class="ri-star-fill text-base text-inherit"></i>
                            </label>
                            <!-- Star 3 -->
                            <input type="radio" name="instructor_skills" id="ins_star3" value="3"
                                class="hidden peer">
                            <label for="ins_star3"
                                class="cursor-pointer text-gray-300 peer-checked:text-warning hover:text-warning">
                                <i class="ri-star-fill text-base text-inherit"></i>
                            </label>
                            <!-- Star 4 -->
                            <input type="radio" name="instructor_skills" id="ins_star4" value="2"
                                class="hidden peer">
                            <label for="ins_star4"
                                class="cursor-pointer text-gray-300 peer-checked:text-warning hover:text-warning">
                                <i class="ri-star-fill text-base text-inherit"></i>
                            </label>
                            <!-- Star 5 -->
                            <input type="radio" name="instructor_skills" id="ins_star5" value="1"
                                class="hidden peer">
                            <label for="ins_star5"
                                class="cursor-pointer text-gray-300 peer-checked:text-warning hover:text-warning">
                                <i class="ri-star-fill text-base text-inherit"></i>
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
                                class="cursor-pointer text-gray-300 peer-checked:text-warning hover:text-warning">
                                <i class="ri-star-fill text-base text-inherit"></i>
                            </label>
                            <!-- Star 2 -->
                            <input type="radio" name="support_quality" id="sup_star2" value="4"
                                class="hidden peer">
                            <label for="sup_star2"
                                class="cursor-pointer text-gray-300 peer-checked:text-warning hover:text-warning">
                                <i class="ri-star-fill text-base text-inherit"></i>
                            </label>
                            <!-- Star 3 -->
                            <input type="radio" name="support_quality" id="sup_star3" value="3"
                                class="hidden peer">
                            <label for="sup_star3"
                                class="cursor-pointer text-gray-300 peer-checked:text-warning hover:text-warning">
                                <i class="ri-star-fill text-base text-inherit"></i>
                            </label>
                            <!-- Star 4 -->
                            <input type="radio" name="support_quality" id="sup_star4" value="2"
                                class="hidden peer">
                            <label for="sup_star4"
                                class="cursor-pointer text-gray-300 peer-checked:text-warning hover:text-warning">
                                <i class="ri-star-fill text-base text-inherit"></i>
                            </label>
                            <!-- Star 5 -->
                            <input type="radio" name="support_quality" id="sup_star5" value="1"
                                class="hidden peer">
                            <label for="sup_star5"
                                class="cursor-pointer text-gray-300 peer-checked:text-warning hover:text-warning">
                                <i class="ri-star-fill text-base text-inherit"></i>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-full">
                <div class="relative">
                    <textarea id="instructor-education" rows="10" class="form-input rounded-2xl h-auto peer" name="content"
                        placeholder=" {{ translate('Write your message') }}"> </textarea>
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
</x-dashboard-layout>
