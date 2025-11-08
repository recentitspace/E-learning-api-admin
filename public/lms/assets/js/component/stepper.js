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

        // Check if form has thumbnail file input
        let thumbnailInput = form.find('input[name="thumbnail"], input[type="file"][id*="thumbnail"]')[0];
        let hasThumbnailFile = thumbnailInput && thumbnailInput.files && thumbnailInput.files[0];
        
        // If thumbnail file exists, convert to base64 and send as JSON
        if (hasThumbnailFile) {
            let thumbnailFile = thumbnailInput.files[0];
            
            // Validate file type
            let allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp', 'image/gif'];
            if (!allowedTypes.includes(thumbnailFile.type)) {
                Command: toastr["error"]('Invalid file type. Please upload jpg, png, webp, or gif.');
                return false;
            }
            
            // Validate file size (max 5MB)
            if (thumbnailFile.size > 5 * 1024 * 1024) {
                Command: toastr["error"]('File size must be less than 5MB.');
                return false;
            }
            
            // Convert file to base64
            let reader = new FileReader();
            reader.onload = function(e) {
                let base64String = e.target.result;
                
                // Helper function to convert FormData to object, handling array fields
                function formDataToObject(formData) {
                    let obj = {};
                    let arrayKeys = new Set();
                    
                    // First pass: collect all keys and identify array fields
                    for (let key of formData.keys()) {
                        // Check if key ends with [] or if it appears multiple times
                        if (key.endsWith('[]')) {
                            arrayKeys.add(key);
                        }
                    }
                    
                    // Second pass: build the object
                    for (let [key, value] of formData.entries()) {
                        if (key === 'thumbnail' || value instanceof File) {
                            continue; // Skip file inputs
                        }
                        
                        // Handle array fields (keys ending with [])
                        if (key.endsWith('[]')) {
                            let arrayKey = key.slice(0, -2); // Remove '[]' suffix
                            if (!obj[arrayKey]) {
                                obj[arrayKey] = [];
                            }
                            // Only add non-empty values
                            if (value !== null && value !== undefined && value !== '') {
                                obj[arrayKey].push(value);
                            }
                        } else {
                            // Handle regular fields
                            // If key already exists and it's not an array, convert to array
                            if (obj.hasOwnProperty(key)) {
                                if (!Array.isArray(obj[key])) {
                                    obj[key] = [obj[key], value];
                                } else {
                                    obj[key].push(value);
                                }
                            } else {
                                obj[key] = value;
                            }
                        }
                    }
                    
                    // Convert single-item arrays to single values for non-array fields
                    // But keep arrays for fields that should be arrays (like instructors, levels, languages)
                    let arrayFieldNames = ['instructors', 'levels', 'languages', 'tags', 'requirements', 'outcomes', 'faqs'];
                    for (let key in obj) {
                        if (Array.isArray(obj[key]) && obj[key].length === 1 && !arrayFieldNames.includes(key)) {
                            obj[key] = obj[key][0];
                        }
                    }
                    
                    return obj;
                }
                
                // Build request data object
                let requestData = {};
                
                // Get all form fields except file inputs
                let formData = new FormData(form[0]);
                requestData = formDataToObject(formData);
                
                // Add form_key and skills
                requestData.form_key = key;
                let skill = form.find("input[name=hidden-skills").val();
                if (typeof skill != "undefined") {
                    requestData.skills = skill;
                }
                
                // Add base64 thumbnail
                requestData.thumbnail = base64String;
                
                let action = form.attr("action");
                $.ajax({
                    url: action,
                    method: "POST",
                    data: JSON.stringify(requestData),
                    dataType: "json",
                    cache: false,
                    contentType: "application/json",
                    processData: false,
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function (res) {
                        handleStepperSuccess(res, form);
                    },
                    error: function (data) {
                        console.log(data);
                        Command: toastr["error"]('Request failed. Please try again.');
                    }
                });
            };
            reader.onerror = function(error) {
                Command: toastr["error"]('Error reading file. Please try again.');
                console.error('FileReader error:', error);
            };
            reader.readAsDataURL(thumbnailFile);
            return;
        }
        
        // No thumbnail file, submit normally with FormData
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
                handleStepperSuccess(res, form);
            },

            error: function (data) {
                console.log(data);
                Command: toastr["error"]('Request failed. Please try again.');
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

// Handle stepper form success response
function handleStepperSuccess(res, form) {
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
}
