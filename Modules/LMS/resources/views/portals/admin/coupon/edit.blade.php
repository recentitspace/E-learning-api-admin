<x-dashboard-layout>
    <x-slot:title>{{ translate('Edit Coupon') }}</x-slot:title>
    <x-portal::admin.breadcrumb title="Coupon" page-to="Edit Coupon" back-url="{{ route('coupon.index') }}" />
    <form action="{{ route('coupon.update', $coupon->id) }}" class="mb-4 form">
        @method('PUT')
        @csrf
        <div class="grid grid-cols-12 gap-x-4">
            <div class="col-span-full lg:col-span-6 card">
                <h6 class="leading-none text-xl font-semibold text-heading">{{ translate('Edit Coupons') }}</h6>
                <div class="mt-7">
                    <div>
                        <label for="coupon-name" class="form-label">{{ translate('Coupon Name') }}<span
                                class="text-danger"
                                title="{{ translate('This field is required') }}"><b>*</b></span></label>
                        <input type="text" id="coupon-name" value="{{ $coupon->name }}" name="name"
                            class="form-input">
                        <span class="text-danger error-text name_err"></span>
                    </div>
                    <div class="mt-6">
                        <label class="form-label">{{ translate('Coupon Type') }}<span class="text-danger"
                                title="{{ translate('This field is required') }}"><b>*</b></span></label>
                        <select id="couponType" class="singleSelect" name="type" onchange="getCouponType()">
                            <option selected disabled> {{ translate('Select Coupon Type') }}</option>t
                            @foreach (get_all_coupon_type() as $couponType)
                                <option value="{{ $couponType->slug }}"
                                    {{ $coupon->type == $couponType->slug ? 'selected' : '' }}>{{ $couponType->name }}
                                </option>
                            @endforeach
                        </select>
                        <span class="text-danger error-text type_err"></span>
                    </div>
                    <div class="mt-6 couponTypeField category   {{ $coupon->type == 'category' ? '' : 'hidden' }}">
                        <label class="form-label"> {{ translate('Selected Category') }}<span class="text-danger"
                                title="{{ translate('This field is required') }}"><b>*</b></span></label>
                        <select class="multipleSelect" name="categoryId[]" multiple="multiple">
                            @foreach (get_all_category() as $category)
                                <option value="{{ $category->id }}"
                                    @foreach ($coupon->categories as $couponCategory)
                                       {{ $couponCategory->id == $category->id ? 'selected' : '' }} @endforeach>
                                    {{ $category->title }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger error-text categoryId_err"></span>
                    </div>
                    <div class="mt-6 couponTypeField course {{ $coupon->type == 'course' ? '' : 'hidden' }}">
                        <label class="form-label">{{ translate('Selected Courses') }}<span class="text-danger"
                                title="{{ translate('This field is required') }}"><b>*</b></span></label>
                        <select class="multipleSelect" name="courseId[]" multiple="multiple">
                            @foreach (get_all_course() as $course)
                                <option value="{{ $course->id }}"
                                    @foreach ($coupon->courses as $couponCourse)
                                      {{ $couponCourse->id == $course->id ? 'selected' : '' }} @endforeach>
                                    {{ $course->title }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger error-text courseId_err"></span>
                    </div>
                    <div class="mt-6">
                        <label class="form-label">{{ translate('Discount Type') }}<span class="text-danger"
                                title="{{ translate('This field is required') }}"><b>*</b></span></label>
                        <select id="couponDiscountType" class="singleSelect discount-type" name="discount_type">
                            <option value="percentage" {{ $coupon->discount_type == 'percentage' ? 'selected' : '' }}>
                                {{ translate('Percent') }}
                            </option>
                            <option value="fixed" {{ $coupon->discount_type == 'fixed' ? 'selected' : '' }}>
                                {{ translate('Fixed') }}
                            </option>
                        </select>
                        <span class="text-danger error-text discount_type_err"></span>
                    </div>
                    <!-- Discount Percent -->
                    <div class="couponDiscountTypeField">

                    </div>
                </div>
            </div>
            <div class="col-span-full lg:col-span-6 card">
                <div class="">
                    <label for="coupon-code" class="form-label">{{ translate('Coupon Code') }}<span class="text-danger"
                            title="{{ translate('This field is required') }}"><b>*</b></span></label>
                    <input type="text" id="coupon-code" placeholder="CXSDK" class="form-input" name="code"
                        value="{{ $coupon->code }}">
                    <span class="text-danger error-text code_err"></span>
                </div>
                <div class="mt-6">
                    <label for="max-useable-time" class="form-label">{{ translate('Max usable times') }}</label>
                    <input type="number" id="max-useable-time" class="form-input" name="total_useable"
                        autocomplete="off" value="{{ $coupon->total_useable }}" />
                </div>
                <div class="mt-6">
                    <label for="min-order" class="form-label">{{ translate('Minimum Order') }}</label>
                    <input type="number" id="min-order" class="form-input" autocomplete="off"
                        name="minimum_order_amount" value="{{ $coupon->minimum_order_amount }}" />
                </div>
                <div class="mt-6">
                    <label for="coupon-expire-date" class="form-label">{{ translate('Expire Date') }}</label>
                    <input type="datetime-local" class="form-input" name="expiration_date"
                        value="{{ $coupon->expiration_date }}" />
                </div>
            </div>
        </div>
        <div class="card flex-center justify-end">
            <button type="submit"
                class="next-form-btn btn b-solid btn-primary-solid dk-theme-card-square">{{ translate('Update') }}</button>
        </div>
    </form>

    @push('js')
        @include('portal::js.couponjs')
    @endpush
</x-dashboard-layout>
