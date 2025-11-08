(function ($) {
    "use strict";
    $(".cancel-button").hide();
    $(document).on("submit", ".form", function (e) {
        e.preventDefault();

        let form = $(this);
        let formData = new FormData(form[0]);
        let action = form.attr("action");
        let submitButton = $(form).find("button[type='submit']");
        let btnText = submitButton.text();
        $.ajax({
            url: action,
            method: "POST",
            data: formData,
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                submitButton.html(`<div class="animate-spin text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 512 512">
                        <path fill="currentColor" d="M304 48a48 48 0 1 0-96 0a48 48 0 1 0 96 0m0 416a48 48 0 1 0-96 0a48 48 0 1 0 96 0M48 304a48 48 0 1 0 0-96a48 48 0 1 0 0 96m464-48a48 48 0 1 0-96 0a48 48 0 1 0 96 0M142.9 437A48 48 0 1 0 75 369.1a48 48 0 1 0 67.9 67.9m0-294.2A48 48 0 1 0 75 75a48 48 0 1 0 67.9 67.9zM369.1 437a48 48 0 1 0 67.9-67.9a48 48 0 1 0-67.9 67.9"/>
                        </svg>
                        
                    </div> ${btnText}`);
                submitButton.attr("disabled", true);
            },

            success: function (data) {
                if (data.status == "error") {
                    submitButton.attr("disabled", false);
                    submitButton.html(`${btnText}`);
                    if (data.hasOwnProperty("message")) {
                        Command: toastr["error"](`${data.message}`);
                    }
                    if (data.errors !== "") {
                        logErrorMsg(data.errors);
                    }

                    if (data.data !== "") {
                        logErrorMsg(data.data);
                    }
                } else if (data.status == "success") {
                    submitButton.removeAttr("disabled", "false");
                    $(form).find("button[type='submit']").html(`${btnText}`);
                    if (data.hasOwnProperty("url")) {
                        location.replace(`${data.url}`);
                    }
                    if (
                        data.hasOwnProperty("modal_hide") &&
                        data.modal_hide == "yes"
                    ) {
                        $(".fixed.inset-0").removeClass("flex");
                        $(".fixed.inset-0").addClass("hidden");
                    }
                    if (data.hasOwnProperty("message")) {
                        Command: toastr["success"](`${data.message}`);
                    }
                    if (data.hasOwnProperty("type")) {
                        location.reload();
                    }

                    resetForm(form);
                }
            },
        });
    });

    $(document).on("click", ".reply-btn", function () {
        $("#replyId").val($(this).data("id"));
        $(".comment-button").html("Replying");
        $(".cancel-button").show();
        $("html, body").animate({ scrollTop: $(document).height() }, "slow");
    });

    $(document).on("click", ".cancel-button", function () {
        $("#replyId").val("");
        $(".comment-button").html("Comment");
        $(".cancel-button").hide();
    });

    $(document).on("click", ".add-to-cart", function (e) {
        e.preventDefault();
        let courseID = $(this).data("course-id");
        let courseType = $(this).data("type");
        let action = baseUrl + "/add-to-cart";
        let dataFormat = {
            id: courseID,
            type: courseType,
        };
        getAjaxRequest(action, dataFormat);
    });

    $(document).on("click", ".remove-cart", function () {
        let id = $(this).data("id");
        let action = $(this).data("action");
        let dataFormat = { id: id };
        getAjaxRequest(action, dataFormat);
        $(this).parent().parent().remove();
    });

    $(document).on("submit", ".get-form", function (e) {
        e.preventDefault();
        let form = $(this);
        let action = form.attr("action");
        let coupon_code = $("#coupon_code").val();
        let dataFormat = { coupon_code: coupon_code };
        getAjaxRequest(action, dataFormat);
    });

    //wishlist

    $(document).on("click", ".add-wishlist", function (e) {
        e.preventDefault();
        let self = $(this);
        let courseId = self.data("id");
        let action = baseUrl + "/add-wishlist";
        let dataFormat = { course_id: courseId };
        self.toggleClass("active");
        getAjaxRequest(action, dataFormat);
    });
    /**
     * Coupon Information
     *
     */
    function couponInformation(data) {
        if (data.total_amount == null) {
            location.reload();
        }

        let { total_amount, coupon_amount } = data;
        coupon_amount = parseFloat(data.coupon_amount) ?? 0;
        total_amount = parseFloat(data.total_amount) ?? 0;

        coupon_amount = coupon_amount.toFixed(2);
        total_amount = total_amount.toFixed(2);

        $("#discount-area").html("");
        $("#discount-area").html(`
                <td class="px-1 py-4 text-left">
                    <div
                        class="flex items-center gap-2 area-description text-heading/70 !leading-none shrink-0">
                        <span class="text-heading dark:text-white mb-0.5">${discountText} (-)</span>
                    </div>
                </td>
                <td class="px-1 py-4 text-right" id="discount-area">
                    <div class="text-heading/70 font-semibold leading-none">$${coupon_amount}</div>
                </td>

           `);
        $("#total").html(`$${total_amount}`);
        $("#subTotal").html(`$${total_amount}`);
        $("#grand_total").html(`$${total_amount - coupon_amount}`);

        $(".total-qty").html(`${data.total_qty}`);
    }
    $(document).on("click", ".payment-item", function (e) {
        e.preventDefault();
        $(".payment-item").removeClass("active");
        $(this).addClass("active");
        let self = $(this);
        let method = self.data("method");
        let action = self.data("action");
        let dataFormat = { payment_method: method };
        getAjaxRequest(action, dataFormat);
    });

    $(document).on("click", ".video-lesson-item", function (e) {
        e.preventDefault();
        let self = $(this);
        let type = self.data("type");
        let id = self.data("id");
        let action = self.data("action");
        let dataFormat = { type: type, id: id };
        getAjaxRequest(action, dataFormat);
    });

    $(document).on("click", ".auth-login", function () {
        Command: toastr["error"](`Please Login`);
    });
    /** Get Ajax Request
     *
     */
    let getAjaxRequest = (action, dataFormat) => {
        $.ajax({
            url: action,
            method: "GET",
            data: dataFormat,
            dataType: "json",
            success: function (data) {
                if (data.status == "error") {
                    if (data.hasOwnProperty("message")) {
                        Command: toastr["error"](`${data.message}`);
                    }
                } else if (data.status == "success") {
                    if (data.hasOwnProperty("message")) {
                        Command: toastr["success"](`${data.message}`);
                    }
                    if (data.hasOwnProperty("coupon")) {
                        couponInformation(data);
                    }
                    if (data.hasOwnProperty("learn")) {
                        learnTopic(data);
                    }

                    if (data.hasOwnProperty("payment")) {
                        paymentForm(data);
                    }
                    if (data.hasOwnProperty("url")) {
                        location.replace(`${data.url}`);
                    }
                    if (data.hasOwnProperty("type")) {
                        location.reload();
                    }

                    if (data.hasOwnProperty("wishlist")) {
                        $(".total-wishlist").html(`${data.total}`);
                    }
                }
            },
        });
    };

    $(document).on("change", ".quizSelectAnswer", function (e) {
        let form = $(this).closest("form");
        let action = form.attr("action");
        let courseId = $("#courseId").val();
        let chapterId = $("#chapterId").val();
        let topicId = $("#topicId").val();
        let formData = new FormData(form[0]);
        formData.append("course_id", courseId);
        formData.append("chapter_id", chapterId);
        formData.append("topic_id", topicId);

        $.ajax({
            url: action,
            method: "POST",
            data: formData,
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {},
        });
    });

    $(document).on("blur", ".fill-in-blank", function () {
        let form = $(this).closest("form");
        let action = form.attr("action");

        let courseId = $("#courseId").val();
        let chapterId = $("#chapterId").val();
        let topicId = $("#topicId").val();

        let formData = new FormData(form[0]);
        formData.append("course_id", courseId);
        formData.append("chapter_id", chapterId);
        formData.append("topic_id", topicId);

        $.ajax({
            url: action,
            method: "POST",
            data: formData,
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
        });
    });

    /** print error message
     * @param msg
     */
    let logErrorMsg = (msg) => {
        $.each(msg, function (key, value) {
            $("." + key + "_err")
                .text(value)
                .fadeIn()
                .delay(5000)
                .fadeOut("slow");
        });
    };

    let learnTopic = (data) => {
        $(".curriculum-content").html(`${data.view}`);
    };
    let paymentForm = (data) => {
        $("#card-payment").html(`${data.data.form}`);
        $("#pay-button").html(`${data.data.button}`);
    };
    /** Reset
     */
    let resetForm = (form) => {
        $(form).trigger("reset");
    };
})(jQuery);

/**
 * Get Ajax Request
 *
 */
function numberOnly(id) {
    let element = document.getElementById(id);
    if (id == "expire") {
        let { value } = element;
        if (value.length == 2) {
            value.concat("/");
        }
    } else {
        value.replace(/[^0-9]/gi, "");
    }
}
