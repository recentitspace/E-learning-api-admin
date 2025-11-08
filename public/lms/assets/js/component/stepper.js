"use strict";

const stepperStepButton = document.querySelectorAll(".stepper-step-btn");
const prevStepButton = document.querySelector(".prev-step-btn");
const nextStepButton = document.querySelector(".next-step-btn");
const stepperMenu = document.querySelector(".stepper-menu");
const fieldsets = document.querySelectorAll(".fieldset");
let scrollLeftValue;
let isDragging = false;
// FOR FORM
const prevFormButton = document.querySelectorAll(".prev-form-btn");
const nextFormButton = document.querySelectorAll(".next-form-btn");
let current_fieldset, next_fieldset, previous_fieldset;

// CLICK NEXT FORM BUTTON
nextFormButton.forEach((nextBtn) => {
    nextBtn.addEventListener("click", function () {
        current_fieldset = this.closest(".fieldset");
        next_fieldset = current_fieldset.nextElementSibling;
        // Add Active Class
        let form = $(this).closest("form");
        let key = form.data("key");

        console.log(key);

        let formData = new FormData(form[0]);
        formData.append("form_key", key);
        let skill = form.find("input[name=hidden-skills").val();
        if (typeof skill != "undefined") {
            formData.append("skills", skill);
        }
        let action = form.attr("action");
        $.ajax({
            url: action,
            method: "POST",
            data: formData,
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            success: function (res) {
                console.log(res);
                if (res.status == "error") {
                    logErrorMsg(res.data);
                    if (res.data?.course_id) {
                        Command: toastr["error"](`${res.data.course_id}`);
                    }
                } else if (res.status == "success") {
                    if (
                        res.hasOwnProperty("menu_type") &&
                        res.menu_type == "bundle"
                    ) {
                        $(".bundleId").val(res.bundle_id);
                    } else {
                        $('input[name="hidden-skills"]').val("");
                        $(".courseId").val(res.course_id);
                        if (res.key == "pricing") {
                            $("#pricingId").val(res.price_id);
                        }
                    }

                    if (res.hasOwnProperty("message")) {
                        Command: toastr["success"](`${res.message}`);
                    }
                    if (res.hasOwnProperty("url")) {
                        location.replace(`${res.url}`);
                    }

                    nextFieldSet(
                        stepperStepButton,
                        fieldsets,
                        next_fieldset,
                        current_fieldset
                    );
                }
            },

            error: function (data) {
                console.log(data);
            },
        });
    });
});

// CLICK PREVIOUS FORM BUTTON
prevFormButton.forEach((previousButton) => {
    previousButton.addEventListener("click", function () {
        current_fieldset = this.closest(".fieldset");
        previous_fieldset = current_fieldset.previousElementSibling;
        // Remove active class
        nextFieldSet(
            stepperStepButton,
            fieldsets,
            previous_fieldset,
            current_fieldset
        );
    });
});

// SETTING STEPPER BUTTON VISIBILITY
function buttonActivation() {
    scrollLeftValue = Math.ceil(stepperMenu?.scrollLeft);
    let scrollableWidth = stepperMenu?.scrollWidth - stepperMenu?.clientWidth;

    if (prevStepButton) {
        prevStepButton.style.display =
            scrollableWidth > scrollLeftValue ? "block" : "none";
    }

    if (nextStepButton) {
        nextStepButton.style.display =
            scrollableWidth > scrollLeftValue ? "block" : "none";
    }

    if (prevStepButton) {
        prevStepButton.style.display = scrollLeftValue > 0 ? "block" : "none";
    }
}

nextStepButton?.addEventListener("click", () => {
    stepperMenu.scrollLeft += 200;
    buttonActivation();
});

prevStepButton?.addEventListener("click", () => {
    stepperMenu.scrollLeft -= 200;
    buttonActivation();
});

function stepActivation(currentStepperIndex) {
    stepperStepButton.forEach((stepBtn) => {
        stepBtn.classList.remove("active");
    });
    fieldsets.forEach((fieldset) => {
        fieldset.classList.remove("!block");
    });

    stepperStepButton[currentStepperIndex]?.classList.add("active");

    fieldsets[currentStepperIndex].classList.add("!block");
}

stepperStepButton.forEach((stepBtn, i) => {
    stepBtn.addEventListener("click", () => {
        stepActivation(i);
    });
});

// STEPPER DRAGGING
stepperMenu?.addEventListener("mousemove", (drag) => {
    if (!isDragging) return;

    if (stepperMenu) {
        stepperMenu.scrollLeft -= drag.movementX;
        stepperMenu.classList.add("dragging");
    }
});

document.addEventListener("mouseup", () => {
    isDragging = false;
    stepperMenu?.classList.remove("dragging");
});

stepperMenu?.addEventListener("mousedown", () => {
    isDragging = true;
});
window.onload = function () {
    buttonActivation();

    if (prevStepButton) {
        prevStepButton.style.display = scrollLeftValue > 0 ? "block" : "none";
    }
};
window.onresize = function () {
    buttonActivation();

    if (prevStepButton) {
        prevStepButton.style.display = scrollLeftValue > 0 ? "block" : "none";
    }
};

function nextFieldSet(
    stepperStepButton,
    fieldsets,
    next_fieldset,
    current_fieldset
) {
    if (next_fieldset) {
        stepperStepButton[
            Array.from(fieldsets).indexOf(next_fieldset)
        ].classList.add("active");

        current_fieldset.classList.remove("!block");

        next_fieldset.classList.add("!block");
    }
}
