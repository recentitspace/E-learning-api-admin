(function ($) {
    "use strict";
    // multistep form start

    $(document).ready(function () {
        var currentStep = 0;
        var $msformFieldsets = $("#msform fieldset");
        var $progressbarLi = $("#progressbar li");
        function updateStep(step) {
            $msformFieldsets.removeClass("active");
            $msformFieldsets.eq(step).addClass("active");
            $progressbarLi.removeClass("processing");
            $progressbarLi.removeClass("active");
            $progressbarLi.eq(step).addClass("processing");
            $progressbarLi.slice(0, step).addClass("active");
        }

        let final = $("#final").val();

        if (final != "final") {
            $msformFieldsets.eq(0).addClass("active");
            $progressbarLi.eq(0).addClass("processing");
        }

        $(".installer-btn").on("click", function (event) {
            event.preventDefault();
            let self = $(this);
            let form = self.closest("form");
            let action = form.attr("action");
            $.ajax({
                type: "GET",
                url: action,
                dataType: "json",
                success: function (data) {
                    if (data.status == true) {
                        // currentStep++;
                        if (data.hasOwnProperty("url")) {
                            window.location.replace(`${data.url}`);
                        }
                    } else if (data.status == false) {
                        if (data.hasOwnProperty("message")) {
                            $(".server-error-message")
                                .html(`${data.message}`)
                                .fadeIn()
                                .delay(5000)
                                .fadeOut("slow");
                        }
                        $(self).addClass("remove");
                    }
                },
            });
        });

        $(".environment-btn").on("click", function (event) {
            event.preventDefault();

            let self = $(this);
            let form = self.closest("form");
            let formdata = new FormData(form[0]);
            let action = form.attr("action");

            formdata.append(
                "_token",
                $('meta[name="csrf-token"]').attr("content")
            );

            showLoader(self);

            $.ajax({
                type: "POST",
                url: action,
                data:formdata,
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data.status == true) {
                        if (data.hasOwnProperty("url")) {
                            window.location.replace(`${data.url}`);
                        }
                    } else if (data.status == false) {
                        hideLoader(self);
                        if (data.hasOwnProperty("errors")) {
                            printErrorMsg(data.errors);
                        }
                        if (data.hasOwnProperty("message")) {
                            $(".error-message")
                                .html(`${data.message}`)
                                .fadeIn()
                                .delay(5000)
                                .fadeOut("slow");
                        }
                    }
                },
                error: function (data) {
                    console.log(data);
                    hideLoader(self);
                },
            });
        });

        function showLoader(self) {
            self.find(".btn-ring").show();
            self.prop("disabled", true);
        }

        function hideLoader(self) {
            self.find(".btn-ring").hide();
            self.prop("disabled", false);
        }

        /** print error message
         * ======== printErrorMsg======
         *
         * @param msg
         *
         */
        function printErrorMsg(msg) {
            $.each(msg, function (key, value) {
                $("." + key + "_err")
                    .text(value)
                    .fadeIn()
                    .delay(30000)
                    .fadeOut("slow");
            });
        }

        $(".btn-process").on("click", function () {
            $(".btn-ring").show();
            $(".btn-process").prop("disabled", true);
            $(".btn-process").val("disabled");
            $(this).closest("form").submit();
        });
    });
})(jQuery);
