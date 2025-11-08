(function ($) {
    "use strict";

    $(document).on("keyup", ".search-keyword", function () {
        filterSearchJob();
    });
    $(document).on("change", ".courseType", function () {
        if ($(this).is(":checked")) {
            $("#courseType").val($(this).val());
        }
        filterSearchJob();
    });

    function showLoader() {
        $("#eg-overlay").show();
    }

    function hideLoader() {
        $("#eg-overlay").hide();
    }

    $(document).on("click", ".page-item .page-link", function (e) {
        e.preventDefault();
        var page = $(this).attr("href").split("page=")[1];
        filterSearchJob(page);
    });

    $(document).on("change", ".filter-option", function (e) {
        filterSearchJob();
    });

    $(document).on("change", "#filterSort", function (e) {
        e.preventDefault();
        var $option = $(this).find("option:selected");
        sort.value = $option.val();
        filterSearchJob();
    });

    $(document).on("click", ".pagination", function (e) {
        e.preventDefault();
        $(".pagination").removeClass("active");
        $(this).addClass("active");
        var page = $(this).attr("href").split("page=")[1];
        filterSearchJob(page);
    });

    $(document).on("click", "#refreshPage", function () {
        location.reload();
    });

    function filterSearchJob(page = null) {
        const category = getFilterData("category");
        const instructors = getFilterData("instructors");
        const designations = getFilterData("designation");
        const timeZones = getFilterData("timeZone");
        const levels = getFilterData("level");
        const languages = getFilterData("language");
        const courseTitle = $("#search_title").val() ?? null;
        const courseType = $("#courseType").val() ?? null;

        let url = window.location.origin + "" + window.location.pathname;
        let action =
            url +
            "?page=" +
            page +
            "&categories=" +
            category +
            "&instructors=" +
            instructors +
            "&levels=" +
            levels +
            "&languages=" +
            languages +
            "&courseType=" +
            courseType +
            "&title=" +
            courseTitle +
            "&designations=" +
            designations +
            "&timeZones=" +
            timeZones;

        $.ajax({
            url: action,
            type: "GET",
            dataType: "json",
            beforeSend: showLoader,
            success: function (data) {
                $("#total-item").html(data.total);
                $("#first-item").html(data.first_item);
                $("#last-item").html(data.last_item);
                $("#outputItemList").html(data.data);
                hideLoader();
                // LAZY IMAGE LOADER
                const observer = lozad(
                    document.querySelectorAll("img[data-src]")
                );
                observer.observe();
            },
            error: function (data) {
                Command: toastr["error"](`Not Found`);
            },
        });
    }

    function getFilterData(className) {
        var filter = [];
        $("." + className + ":checked").each(function () {
            filter.push($(this).val());
        });
        return filter;
    }
})(jQuery);
