<script>
    $(function() {
        "use strict"
        $(document).on('change', '.discount-type', function(e) {
            e.preventDefault();
            let type = $(this).val();
            if (type == "percentage") {
                $('.couponDiscountTypeField').html(`
                        <div class="mt-4">
                            <label for="discount-percent" class="form-label"> {{ translate('Discount Percentage') }}   <span class="text-danger"
                                title="{{ translate('This field is required') }}"><b>*</b></span> </label>
                            <div class="flex">
                                <span class="form-input-group input-icon !text-gray-900 !w-10 !rounded-r-none">
                                    <i class="ri-percent-line text-inherit"></i>
                                </span>
                                <input type="number" id="discount-percent" class="form-input !rounded-l-none"
                                    autocomplete="off" name="discount_percentage"  value="{{ isset($coupon) ? $coupon->discount_percentage : '' }}"/>

                            </div>
                            <span class="text-danger error-text discount_percentage_err"></span>
                        </div>
                        <div class="mt-4">
                            <label for="max-amount" class="form-label"> {{ translate('Max Amount') }} ($) <span class="text-danger"
                                title="{{ translate('This field is required') }}"><b>*</b></span></label>
                            <input type="number" id="max-amount" name="max_amount" class="form-input" autocomplete="off"
                                placeholder="{{ translate('150') }}" value="{{ isset($coupon) ? $coupon->max_amount : '' }}" />
                                  <span class="text-danger error-text max_amount_err"></span>
                        </div>
                    `)
            }


            if (type == "fixed") {
                $('.couponDiscountTypeField').html(`
                       <div class="mt-4">
                            <label for="discount-amount" class="form-label"> {{ translate('Discount Amount') }}  <span class="text-danger"
                                title="{{ translate('This field is required') }}"><b>*</b></span></label>
                            <div class="flex">
                                <span class="form-input-group input-icon !text-gray-900 !w-10 !rounded-r-none">
                                    $
                                </span>
                                <input type="number" id="discount-amount" class="form-input !rounded-l-none"
                                    autocomplete="off" name="max_amount" value="{{ isset($coupon) ? $coupon->max_amount : '' }}" />

                            </div>
                             <span class="text-danger error-text max_amount_err"></span>
                        </div>
                    `)
            }
        })
        $('.discount-type').trigger('change')

        $('.multipleSelect').select2({
            placeholder: "Select List",
            width: "100%"
        })


    })

    function getCouponType() {
        const couponType = document.querySelector("select#couponType").value;

        document.querySelectorAll(".couponTypeField").forEach(function(field) {
            if (field.classList.contains(`${couponType}`)) {
                field.classList.remove("hidden");
            } else {
                field.classList.add("hidden");
            }
        });
    }
</script>
