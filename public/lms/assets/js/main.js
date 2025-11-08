"use strict";
var html = document.documentElement;
var body = document.querySelector("body");

// PAGE LOADER
function hideLoader() {
    const preLoader = document.getElementById("preloader");
    if (preLoader) {
        preLoader.remove();
    }
}

// ON PAGE LOADED
window.addEventListener("load", function () {
    hideLoader();

    if (this.document.getElementById("app-drawer")) {
        document
            .getElementById("app-menu-scrollbar")
            .querySelector(".scrollbar-track-x")
            .remove();
    }
});

// MOBILE MENU
/*
'mob'      = 'menu open button'
'comid'    = 'current offcanvas menu id'
'com'      = 'current offcanvs menu'
'cominner' = 'current offcanvas menu inner'
'comclose' = 'current offcanvas menu close'
*/
const mob = document.querySelectorAll("[data-offcanvas-id]");
mob.forEach(function (obtn) {
    const comid = obtn.getAttribute("data-offcanvas-id");
    const com = document.querySelector(`#${comid}`);
    const cominner = document.querySelector(`.${comid}-inner`);
    const comclose = com.querySelector(`.${comid}-close`);

    obtn.addEventListener("click", () => {
        if (com.classList.contains(...["invisible", "opacity-0"])) {
            com.classList.remove(...["invisible", "opacity-0"]);
        }

        if (
            cominner.classList.contains(
                ...["translate-x-full", "rtl:-translate-x-full"]
            )
        ) {
            cominner.classList.remove(
                ...["translate-x-full", "rtl:-translate-x-full"]
            );
        }
        body.classList.add("overflow-hidden");
    });

    if (comclose) {
        comclose.addEventListener("click", () => {
            if (!com.classList.contains(...["invisible", "opacity-0"])) {
                com.classList.add(...["invisible", "opacity-0"]);
            }

            if (
                !cominner.classList.contains(
                    ...["translate-x-full", "rtl:-translate-x-full"]
                )
            ) {
                cominner.classList.add(
                    ...["translate-x-full", "rtl:-translate-x-full"]
                );
            }

            if (body.classList.contains("overflow-hidden")) {
                body.classList.remove("overflow-hidden");
            }
        });
    }

    com.addEventListener("click", function (e) {
        if (e.target === this && e.target !== cominner) {
            if (!com.classList.contains(...["invisible", "opacity-0"])) {
                com.classList.add(...["invisible", "opacity-0"]);
            }

            if (
                !cominner.classList.contains(
                    ...["translate-x-full", "rtl:-translate-x-full"]
                )
            ) {
                cominner.classList.add(
                    ...["translate-x-full", "rtl:-translate-x-full"]
                );
            }

            if (body.classList.contains("overflow-hidden")) {
                body.classList.remove("overflow-hidden");
            }
        }
    });
});

// INTIALIZE SMOOTH SCROLLBARM
let option = {
    continuousScrolling: false,
    alwaysShowTracks: true,
};
if (document.querySelector("[data-scrollbar]")) {
    Scrollbar.initAll(option);
}

// CHECK ALL CHECKBOX WITH ONE CLICK
function allCheck(event, inputs) {
    Array.from(document.querySelectorAll(`.${inputs}`)).forEach((input) => {
        if (event.target.checked) {
            input.checked = true;
        } else {
            input.checked = false;
        }
    });
}

// REPLACE ALL EMPTY LINK WITH VOID
document.querySelectorAll('[href="#"]').forEach((link) => {
    link.addEventListener("click", (e) => e.preventDefault());
});

// CHOICE EMAIL INPUT
if (document.getElementById("choices-input")) {
    new Choices(document.getElementById("choices-input"), {
        removeItemButton: true,
        maxItemCount: 3,
        duplicateItemsAllowed: false,
        allowHTML: true,
    });
}

// COLOR PICKER
if (document.getElementById("color-picker")) {
    document.getElementById("color-picker").addEventListener("change", () => {
        document.querySelector(".color-value").textContent =
            document.getElementById("color-picker").value;
    });
}

// COUNTER NUMBER
(function counter() {
    const counters = document.querySelectorAll(".counter-value");
    if (counters.length) {
        counters.forEach((counter) => {
            const value = counter.getAttribute("data-value");
            const inc = value / 300;
            let count = 0;
            function pad(toPad, padChar, length) {
                return String(toPad).length < length
                    ? new Array(length - String(toPad).length + 1).join(
                          padChar
                      ) + String(toPad)
                    : toPad;
            }
            function numberWithCommas(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
            const updateCount = () => {
                count += inc;
                if (count < value) {
                    counter.innerText = pad(
                        numberWithCommas(count.toFixed(0)),
                        "0",
                        "2"
                    );
                    setTimeout(updateCount, 1);
                } else {
                    counter.innerText = pad(numberWithCommas(value), "0", "2");
                }
            };
            updateCount();
        });
    }
})();

// FILE INPUT
function uploadFile() {
    document.querySelectorAll(".file-src").forEach(function (fileInput) {
        fileInput.onchange = function () {
            const reader = new FileReader();

            fileInput
                .closest(".file-container")
                .querySelector(
                    ".file-name"
                ).innerHTML = `${fileInput.files.length} ${fileUploadedText}`;
        };
    });
}
uploadFile();

// FILE UPLOAD WITH NAME
document.querySelectorAll(".file-src-name").forEach(function (fileInput) {
    fileInput.addEventListener("change", function () {
        const nameBox = fileInput
            .closest(".file-container")
            .querySelector(".file-name-name");
        if (fileInput.files.length > 0) {
            nameBox.textContent = fileInput.files[0].name;
        } else {
            nameBox.textContent = "";
        }
    });
});

// TOGGLE PASSWORD
const inputTypeToggler = document.querySelectorAll(".inputTypeToggle");
inputTypeToggler.forEach(function (checkbox) {
    checkbox.addEventListener("change", function () {
        let passwordInput = this.parentElement.parentElement.children[0];

        passwordInput.type = this.checked ? "text" : "password";
    });
});

//=================== single fille ===============

$(document).on("change", ".dropzone-image", function () {
    readFile(this);
});

// ===================  readFile  ====================

function readFile(self) {
    if (self.files && self.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            let htmlPreview = `
            <div class="img-thumb-wrapper">
                <img class="img-thumb" width="100" src="${e.target.result}"/>
            </div>`;
            let parent = $(self).parent().parent();
            let boxZone = $(parent).find(".preview-zone");
            boxZone = $(boxZone).find(".box").find(".box-body").html("");
            boxZone.append(htmlPreview);
            $(".remove").click(function () {
                $(this).parent(".img-thumb-wrapper").remove();
            });
        };
        // <button class="remove">
        //     <i class="ri-close-line text-inherit text-[13px]"></i>
        // </button>

        reader.readAsDataURL(self.files[0]);
    }
}

$(".img-thumb-wrapper .remove").click(function () {
    $(this).parent(".img-thumb-wrapper").remove();
});

// ===================== Multiple image upload ====================

$(function () {
    if (window.File && window.FileList && window.FileReader) {
        $(".multiple-image").on("change", function (e) {
            let self = $(this);
            let parent = $(self).parent().parent();
            var files = e.target.files;
            let filesLength = files.length;
            let boxZone = $(parent).find(".gallery-preview-zone");
            boxZone = $(boxZone).find(".box").find(".box-body");
            for (var i = 0; i < filesLength; i++) {
                var f = files[i];
                var fileReader = new FileReader();
                fileReader.onload = function (e) {
                    var file = e.target;
                    $(`<div class="img-thumb-wrapper">
                        <button class="remove">
                            <i class="ri-close-line text-inherit text-[13px]"></i>
                        </button>
                       <img class="img-thumb" width="100" src="${e.target.result}" title="${file.name}"/>
                    </div>
                    `).appendTo(boxZone);

                    $(".remove").click(function () {
                        $(this).parent(".img-thumb-wrapper").remove();
                    });
                };
                fileReader.readAsDataURL(f);
            }
        });
    } else {
        alert("Your browser doesn't support to File API");
    }

    /// gallery image remove

    $(document).on("click", ".multiple-image-remove", function () {
        let self = $(this);
        let action = $(this).data("action");
        $.ajax({
            url: action,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                if (data.status == "success") {
                    $(self).parent(".img-thumb-wrapper").remove();
                }
            },
            error: function (data) {
                Command: toastr["error"](`Not Found`);
            },
        });
    });

    $(".singleSelect").select2({
        width: "100%",
        id: "-1",
    });

    $(".selectFilterCategory").select2({
        placeholder: selectCategory,
        width: "100%",
    });

    $(".selectFilterInstructor").select2({
        placeholder: selectInstructor,
        width: "100%",
    });

    $(".permission-list").select2({
        width: "100%",
        placeholder: selectPermission,
    });

    $(".role-list").select2({
        width: "100%",
        placeholder: selectRole,
    });
});

//======== summmernote
$(".summernote").summernote({
    placeholder: `${textAreaPlaceholder}...`,
    tabsize: 2,
    height: 220,
    toolbar: [
        ["style", ["style"]],
        ["fontsize", ["fontsize"]],
        ["font", ["bold", "italic", "underline", "clear"]],
        ["fontname", ["fontname"]],
        ["color", ["color"]],
        ["para", ["paragraph"]],
        ["height", ["height"]],
        ["insert", ["hr", "link"]],
    ],
    styleTags: ["p", "h1", "h2", "h3", "h4", "h5", "h6"],
    lineHeights: ["0.5", "1.0", "1.1", "1.2", "1.3", "1.4"],
    fontSizes: [
        "8",
        "9",
        "10",
        "11",
        "12",
        "13",
        "14",
        "15",
        "16",
        "18",
        "24",
        "36",
        "48",
        "64",
        "82",
        "150",
    ],
});

/** print error message
 * ======== logErrorMsg======
 *
 * @param msg
 *
 */
function logErrorMsg(msg) {
    $.each(msg, function (key, value) {
        $("." + key + "_err")
            .text(value)
            .fadeIn()
            .delay(5000)
            .fadeOut("slow");
    });
}

//==================  search suggestion

$(document).on("keyup", ".search-suggestion", function () {
    let self = $(this);
    let query = $(this).val();
    let searchType = $(self).data("search-type");
    let action = baseUrl + "/searching-suggestion";
    if (query != "") {
        ajaxSearchSuggestion(query, self, action, searchType);
    }
    $(self).parent().find(".search-show").html("");
});

//================ ajaxSearchSuggestion

function ajaxSearchSuggestion(query, self, action, searchType) {
    $.ajax({
        url: action,
        method: "GET",
        data: {
            key: query,
            search_type: searchType,
        },
        success: function (data) {
            $(self).parent().find(".search-show").fadeIn();
            $(self).parent().find(".search-show").html(data);
        },
    });
}

$(document).on("click", ".search-data li", function (e) {
    e.preventDefault();
    let self = $(this);
    self.parent().parent().parent().find("#searchInput").val($(this).text());
    self.parent().parent().parent().find(".search-show").fadeOut();
});

function openStep(evt, stepName) {
    let i;
    const tabcontent = document.getElementsByClassName("tabcontent");
    const tablinks = document.getElementsByClassName("tablinks");

    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    document.getElementById(stepName).style.display = "block";
    evt.currentTarget.className += " active";
}

// ADD PROFILE SOCIAL MEDIA LINK
function addProfileSocialMedia() {
    const courseOutcomeContainer = document.querySelector(
        ".profile-social-media-container"
    );
    const newChild = `
    <div class="flex gap-4 removeable-parent">
      <div class="grow flex flex-col gap-2">
        <input type="text" placeholder="Facebook" class="form-input">
        <input type="url" placeholder="https://www.facebook.com/" class="form-input">
      </div>
      <button type="button" class="btn-icon btn-danger-icon-light size-10 shrink-0 dk-theme-card-square remove-parent-button">
          <i class="ri-delete-bin-line text-inherit"></i>
      </button>
    </div>
    `;

    courseOutcomeContainer.insertAdjacentHTML("beforeend", newChild);
    removeInfoItem();
}

// REMOVE CHILDREN
function removeInfoItem() {
    document.querySelectorAll(".remove-parent-button").forEach((removeBtn) => {
        removeBtn.addEventListener("click", function () {
            this.closest(".removeable-parent").remove();
        });
    });
}
removeInfoItem();

// TEXT EDITOR BUTTON
const textEditorButton = document.querySelectorAll("[data-editor-class]");
textEditorButton.forEach((button) => {
    const editorClass = button.getAttribute("data-editor-class");
    button.addEventListener("click", () => {
        const editor = document.querySelector(`.${editorClass}`);
        try {
            button.classList.toggle("active");
            editor.readOnly = !editor.readOnly;
            editor.focus();
        } catch (error) {
            alert(`Can not find editor with '${editorClass}' class.`);
        }
    });
});

// COPY TO CLIPBOARD BUTTON
const copyButton = document.querySelectorAll("[data-copy-button]");
copyButton.forEach((button) => {
    button.addEventListener("click", () => {
        const initText = button.querySelector(".text").innerText;
        button.classList.toggle("active");
        button.querySelector(".text").innerText = "Copied!";
        setTimeout(() => {
            button.setAttribute("disabled", "disabled");
        }, 100);
        setTimeout(() => {
            button.classList.toggle("active");
            button.querySelector(".text").innerText = initText;
            button.removeAttribute("disabled");
        }, 1500);
    });
});
