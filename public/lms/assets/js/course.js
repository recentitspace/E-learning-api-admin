$(function () {
    "use strict";

    $(".sniper-loader").hide();

    $("#scheduleDate").flatpickr({
        enableTime: true,
        dateFormat: "Y-m-d",
    });

    $("#scheduleTime").flatpickr({
        enableTime: true,
        noCalendar: true,
        time_24hr: true,
        dateFormat: "H:i",
    });

    let courseTags = $("#courseTags").val();
    courseTags = courseTags ? JSON.parse(courseTags) : "";

    $(".js-example-basic-single").select2({
        placeholder: `${selectInstructor}`,
        width: "100%",
    });

    $(".instructor-list").select2({
        placeholder: `${selectInstructor}`,
        width: "100%",
        allowClear: true, // Ensures you can clear the selected values
        closeOnSelect: false,
    });

    $(".level-list").select2({
        placeholder: `${selectLevel}`,
        width: "100%",
    });
    $(".language-list").select2({
        placeholder: `${selectLanguage}`,
        width: "100%",
        dropdownAutoWidth: true,
        multiple: true,
        width: "100%",
        height: "30px",
        allowClear: true,
    });
    $(".zone-list").select2({
        placeholder: `${selectTimezone}`,
        width: "100%",
    });
    $("#courseCategory").select2({
        placeholder: `${selectCategory}`,
        width: "100%",
    });
    $("#subject").select2({
        placeholder: `${selectSubject}`,
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
                    <input type="text" placeholder="${courseOutcome}" id="searchInput" data-search-type="outcomes" autocomplete="off" name="outcomes[${key}][title]" class="form-input outcomes search-suggestion">
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
            let action = baseUrl + "/course/delete-information";
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

    // ==================  add-requirement ;

    $(document).on("click", ".add-requirement", function () {
        let key = $(this)
            .closest(".requirement-item")
            .find(".requirement-area")
            .data("length");
        key++;
        $(".requirement-area").append(
            ` <div class="flex gap-4">
                <div class="grow flex flex-col gap-2 relative">
                    <input type="text" placeholder="${courseRequirement}" id="searchInput" autocomplete="off" data-search-type="requirement" name="requirements[${key}][title]" class="form-input requirement search-suggestion">
                     <div class="search-show"></div>
                </div>
                <button type="button" class="btn-icon btn-danger-icon-light shrink-0 delete-btn">
                    <i class="ri-delete-bin-line text-inherit"></i>
                </button>
            </div>
         `
        );
        $(this)
            .closest(".requirement-item")
            .find(".requirement-area")
            .data("length", key);
    });

    $(".tag-list").select2({
        placeholder: `${selectCourseTag}`,
        width: "100%",
        ajax: {
            url: baseUrl + "/course/tag-search",
            dataType: "json",
            width: "element",
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page,
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    results: data.items,
                    pagination: {
                        more: params.page * 30 < data.total_count,
                    },
                };
            },
        },
        language: {
            noResults: function () {
                return `<label for="courseTagButton" class="btn b-solid btn-primary-solid btn-sm my-2">${addNewTag}</label>`;
            },
        },
        escapeMarkup: function (markup) {
            return markup;
        },
        minimumInputLength: 1,
        templateResult: formatRepo,
        templateSelection: formatRepoSelection,
    });

    function formatRepo(repo) {
        if (repo.loading) {
            return repo.text;
        }
        var $container = $(
            "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__title'></div>" +
                "</div>" +
                "</div>" +
                "</div>"
        );
        $container.find(".select2-result-repository__title").text(repo.name);
        return $container;
    }

    function formatRepoSelection(repo) {
        return repo.name || repo.text || repo.id;
    }

    if (courseTags !== "") {
        $.each(courseTags, function (index, data) {
            var newOption = new Option(data.name, data.id, true, true);
            setTimeout(() => {
                $(
                    ".tag-list  ul.select2-selection__rendered li span.select2-selection__choice__display"
                )
                    .eq(index)
                    .text(`${data.name}`);
            }, 300);

            $(".tag-list").append(newOption).trigger("change");
        });
    }

    //============chapter sortable js

    new Sortable(chapterList, {
        animation: 150,
        ghostClass: "bg-primary-important",
        handle: ".dragable-btn",
        onSort: function (ui) {
            let item = $(ui.from).find(".chapter-item");
            let action = baseUrl + "/course/chapter-sorted";
            sortableAjax(action, item);
        },
    });

    //============ Topic sortable js

    const topicList = document.querySelectorAll(".topicList");
    $.each(topicList, function (key, topic) {
        new Sortable(topic, {
            animation: 150,
            ghostClass: "bg-primary-important",
            onSort: function (ui) {
                let item = $(ui.from).find(".topic-item");
                let action = baseUrl + "/course/topic-sorted";
                sortableAjax(action, item);
            },
        });
    });

    //=================== Add Chapter

    $(document).on("click", ".add-chapter", function () {
        $("#model-header").html(addChapter);
        $("#modal-btn").html(saveText);
        $("#chapterId").val("");
        $("#chapterTitle").val("");
    });

    //====================== Edit Chapter

    $(document).on("click", ".edit-chapter", function () {
        let action = $(this).data("action");
        $("#model-header").html(`${editChapter}`);
        $("#modal-btn").html("Update");
        $.ajax({
            url: action,
            method: "GET",
            dataType: "json",
            success: function (data) {
                if (data.status == "success") {
                    $("#chapterId").val(`${data.data.id}`);
                    $("#chapterTitle").val(`${data.data.title}`);
                }
            },
            error: function (data) {
                Command: toastr["error"](`Not Found`);
            },
        });
    });

    //==================== Topic Type List

    $(document).on("change", ".topic-type-list", function (e) {
        let type = $(this).val();
        let action = baseUrl + "/course/chapter-topic-type/" + type;
        let courseId = $(".courseId").val();
        let topicId = "";
        let chapterId = "";
        let action_type = "";
        let fieldDatas = {
            course_id: courseId,
            topic_id: topicId,
            chapter_id: chapterId,
            action_type: action_type,
        };

        let locationContent = $(".form-field-area");
        appendData(action, locationContent, fieldDatas);
    });

    //======================= topic-edit

    $(document).on("click", ".topic-edit", function () {
        let topicId = $(this).data("topic-id");
        let topicType = $(this).data("topic-type");
        let chapterId = $(this).data("chapter-id");
        let action = baseUrl + "/course/chapter-topic-type/" + topicType;
        let courseId = $(".courseId").val();
        $("#topic-header-modal").html(`${editTopic}`);
        $("#topicTypeList").hide();

        let fieldDatas = {
            course_id: courseId,
            topic_id: topicId,
            chapter_id: chapterId,
            action_type: "edit",
        };
        let locationContent = $(".form-field-area");
        appendData(action, locationContent, fieldDatas);
    });

    //====================   add-topic-form

    $(document).on("click", ".add-topic-form", function () {
        $(".form-field-area").html("");
        $("#topic-header-modal").html(`${addNewTopic}`);
        $("#topicTypeList").show();
        $(".topic-type-list").val("");
    });

    //=====================  add-question

    $(document).on("click", ".add-question", function () {
        let quizId = $(this).data("id");
        $("#quizId").val(quizId);
        $(".answer-list-area").html("");
    });

    $(document).on("change", ".quiz-type-list", function () {
        let ansList = $(".answer-list-area").html("");
        let quizType = $(this).val();
        if (quizType == "multiple-choice" || quizType == "single-choice") {
            $(ansList).html(`<div class="mt-10">
                <button type="button" class="btn b-solid btn-primary-solid addQuizAns" data-quiztype="${quizType}">${addAnswer}</button>
                <ul class="flex flex-col gap-2 mt-5 quiz-ans-container" data-length="1">
                    <li class="border border-input-border rounded-lg p-2 removeable-parent">
                        <div class="flex gap-2 relative">
                            <textarea name="answers[0][name]" placeholder="${answerOption}" id="searchInput" data-search-type="answer" class="form-input search-suggestion" rows="1"></textarea>
                            
                            <button type="button"
                                class="btn b-outline btn-danger-outline btn-sm max-h-10 remove-parent-button">
                                <i class="ri-close-line text-inherit text-[13px]"></i>
                            </button>
                            <div class="search-show"></div>
                        </div>
                        <div class="leading-none flex items-center gap-2 mt-2">
                            <label for="correntans1" class="inline-flex items-center cursor-pointer">
                                ${
                                    quizType == "multiple-choice"
                                        ? '<input type="checkbox" id="correntans1" name="answers[0][correct]" class="appearance-none peer"> <div class="switcher switcher-primary-solid"></div>'
                                        : '<input type="radio" id="correntans1" name="answers[0][correct]" class="radio radio-primary question-type-single">'
                                }
                            
                            </label>
                            <div class="text-gray-500 dark:text-dark-text font-medium inline-block">${checkIfCorrect}</div>
                        </div>
                    </li>
                </ul>
            </div>`);
        } else if (quizType == "fill-in-blank") {
            $(ansList).html(`
            <div class="mt-10 mb-11">
                <label for="quiz-grade" class="form-label">${writeCorrectWord} (_______).</label>
                <input type="text" class="form-input choices-input" name=answers[]" >
            </div>`);
            choicesInput();
        }
    });

    //======================= add quiz ans

    $(document).on("click", ".addQuizAns", function () {
        let quiztype = $(this).data("quiztype");
        let index = $(this).parent().find(".quiz-ans-container").data("length");
        index++;
        $(".quiz-ans-container").append(`
            <li class="border border-input-border rounded-lg p-2 removeable-parent">
                <div class="flex gap-2 relative">
                    <textarea name="answers[${index}][name]" placeholder="${answerOption}" id="searchInput" data-search-type="answer" class="form-input search-suggestion" rows="1"></textarea>
                    <button type="button"
                        class="btn b-outline btn-danger-outline btn-sm max-h-10 remove-parent-button">
                        <i class="ri-close-line text-inherit text-[13px]"></i>
                    </button>
                  <div class="search-show"></div>
                </div>
                <div class="leading-none flex items-center gap-2 mt-2">
                    <label for="correntans${index}" class="inline-flex items-center cursor-pointer">
                        ${
                            quiztype == "multiple-choice"
                                ? `<input type="checkbox" id="correntans${index}" name="answers[${index}][correct]" class="appearance-none peer"> <div class="switcher switcher-primary-solid"></div>`
                                : `<input type="radio" id="correntans${index}" name="answers[${index}][correct]" class="radio radio-primary question-type-single">`
                        }
                    </label>
                    <div class="text-gray-500 dark:text-dark-text font-medium inline-block">Check if this is Correct</div>
                </div>
            </li>
         `);
        $(this).parent().find(".quiz-ans-container").data("length", index);
    });

    //======================= choices js

    function choicesInput() {
        const choiseInput = document.querySelectorAll(".choices-input");
        choiseInput.forEach((input) => {
            var example = new Choices(input, {
                removeItemButton: true,
                maxItemCount: 3,
                duplicateItemsAllowed: false,
                allowHTML: true,
                searchEnabled: true,
            });
        });
    }

    //================ delete pareent button

    $(document).on("click", ".remove-parent-button", function () {
        $(this).parent().parent().remove();
    });

    //============== view question

    $(document).on("click", ".view-question", function () {
        let quizId = $(this).data("id");
        let action = baseUrl + "/quizzes/quiz-question/" + quizId;
        let locationContent = $("#questionItem");
        appendData(action, locationContent);
    });

    //============== Edit question

    $(document).on("click", ".edit-question", function () {
        let action = $(this).data("action");
        let locationContent = $("#questionItem");
        appendData(action, locationContent);
    });

    $(document).on("change", "#source-type-select", function (e) {
        if ($(this).val() !== "local") {
            $("#courseVideoFile").html(`
              <label class="form-label">${embedVideoUrl}</label>  
              <input type="text" id="v-url" class="form-input" placeholder="${embedVideoUrl}" name="demo_url" value="" autocomplete="off" />
             `);
        } else {
            $("#courseVideoFile").html(
                `<label class="form-label">${uploadFileText}</label>
                <div class="border border-input-border rounded-md px-2 py-1.5">
                    <input type="file" id="v-url" class="w-full" name="short_video"> 
                    <span class="text-danger error-text short_video_err"></span>
                </div> 
                `
            );
        }
    });

    // =========== appendData

    function appendData(action, locationContent, fieldDatas = null) {
        $.ajax({
            url: action,
            method: "GET",
            data: fieldDatas,
            dataType: "json",
            beforeSend: function () {
                $(".sniper-loader").show();
            },
            success: function (data) {
                if (data.status == "success") {
                    $(locationContent).html(data.data);
                    $(".sniper-loader").hide();
                }
            },
            error: function (data) {
                Command: toastr["error"](`Not Found`);
            },
        });
    }

    // ============ sortableAjax

    function sortableAjax(action, item) {
        let itemIds = [];
        $.each(item, function (key, val) {
            let id = $(val).data("item-id");
            itemIds.push(id);
        });
        $.ajax({
            url: action,
            method: "GET",
            data: {
                itemIds: itemIds,
            },
            dataType: "json",
            success: function (data) {
                if (data.status == "success")
                    Command: toastr["success"](`${data.data}`);
            },
            error: function (data) {
                Command: toastr["error"](`Not Found`);
            },
        });
    }

    $(document).on("click", ".question-type-single", function () {
        $(".question-type-single").not(this).prop("checked", false);
        $(this).prop("checked", true);
    });

    $(document).on("change", ".course-price-cal", function () {
        let self = $(this);
        let price = self.val();

        let platformFee = $("#platform_fee").val();
        var x = Number(platformFee);
        platformFee = parseInt(platformFee, 10);
        price = Number(price);
        let totalPrice = x + price;
        let totalPriceValue = self
            .parent()
            .parent()
            .find("#total_price")
            .val(totalPrice);
    });

    function calculateSum() {
        let total = 0;
        $(".percentage-calculate").each(function () {
            const value = parseFloat($(this).val()) || 0;
            total += value;
        });

        if (100 < total) {
            alert("warning! You value is gether thant 100");
        }
    }
    $(document).on("input", ".percentage-calculate", calculateSum);
});
