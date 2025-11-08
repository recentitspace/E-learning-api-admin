$(function () {
    "use strict";

    $(".multipleSelect").select2({
        placeholder: selectCourse,
        width: "100%",
    });
    $("#courseCategory").select2({
        placeholder: selectCategory,
        width: "100%",
    });
    $("#bundleLevel").select2({
        placeholder: selectLevel,
        width: "100%",
    });
    $("#instructorOption").select2({
        placeholder: selectInstructor,
        width: "100%",
    });

    // ==================  add-faq ;

    $(document).on("click", ".add-faq", function () {
        let key = $(this).closest(".faq-item").find(".faq-area").data("length");
        key++;
        $(".faq-area").append(
            ` <div class="flex gap-4">
            <div class="grow flex flex-col gap-2">
                <input type="text" placeholder="${FaqQuestion}" name="faqs[${key}][title]" class="form-input">
                <textarea name="faqs[${key}][answer]" placeholder="${FaqAnswer}" class="form-input summernote"></textarea>
            </div>
            <button type="button" class="btn-icon btn-danger-icon-light shrink-0 delete-btn">
                <i class="ri-delete-bin-line text-inherit"></i>
            </button>
        </div>
     `
        );
        $(this).closest(".faq-item").find(".faq-area").data("length", key);
    });

    $(document).on("click", ".add-outcomes", function () {
        let key = $(this)
            .closest(".outcome-item")
            .find(".outcomes-area")
            .data("length");
        key++;
        $(".outcomes-area").append(
            ` <div class="flex gap-4">
            <div class="grow flex flex-col gap-2 relative">
                <input type="text" placeholder="${bundleOutcome}" id="searchInput" data-search-type="outcomes" autocomplete="off" name="outcomes[${key}][title]" class="form-input outcomes search-suggestion">
                 <div class="search-show"></div>
            </div>
            <button type="button" class="btn-icon btn-danger-icon-light shrink-0 delete-btn">
                <i class="ri-delete-bin-line text-inherit"></i>
            </button>
        </div>
     `
        );
        $(this)
            .closest(".outcome-item")
            .find(".outcomes-area")
            .data("length", key);
    });

    // ==================  add-requirement ;

    $(document).on("click", ".delete-btn", function (e) {
        let self = $(this);
        if ($(self).data("id")) {
            let id = $(self).data("id");
            let key = $(self).data("key");
            let action = baseUrl + "/course/bundle/delete-information";
            $.ajax({
                url: action,
                method: "GET",
                data: {
                    id: id,
                    key: key,
                },
                dataType: "json",
                success: function (data) {
                    if (data.status == "success") {
                        $(self).parent().remove();
                    }
                },
                error: function (data) {
                    Command: toastr["error"](`Not Found`);
                },
            });
        } else {
            $(this).parent().remove();
        }
    });

    //================ delete pareent button

    $(document).on("click", ".remove-parent-button", function () {
        $(this).parent().parent().remove();
    });
});
