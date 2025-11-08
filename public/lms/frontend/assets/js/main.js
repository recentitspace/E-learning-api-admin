"use strict";
var html = document.documentElement;
var body = document.querySelector("body");
let start = $("#start-quiz").val();
const loader = document.querySelector(".pre-loader-wrapper");

// ON PAGE LOADED
window.addEventListener("load", function () {
    // HIDE LOADER
    loader?.classList.add(...["opacity-0", "duration-500"]);
    setTimeout(() => {
        loader?.remove();
    }, 200);
});

// STICKY HEADER
window.addEventListener("scroll", function () {
    const header = document.querySelector(".sticky-header");

    if (header) {
        if (window.scrollY > window.innerHeight) {
            header.classList.add(
                ...["sticky", "inset-0", "shadow-md", "z-[98]"]
            );
        } else {
            header.classList.remove(
                ...["sticky", "inset-0", "shadow-md", "z-[98]"]
            );
        }
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

        if (cominner.classList.contains(...["translate-x-full", "rtl:-translate-x-full"])) {
            cominner.classList.remove(...["translate-x-full", "rtl:-translate-x-full"]);
        }
        body.classList.add("overflow-hidden");
    });

    if (comclose) {
        comclose.addEventListener("click", () => {
            if (!com.classList.contains(...["invisible", "opacity-0"])) {
                com.classList.add(...["invisible", "opacity-0"]);
            }

            if (!cominner.classList.contains(...["translate-x-full", "rtl:-translate-x-full"])) {
                cominner.classList.add(...["translate-x-full", "rtl:-translate-x-full"]);
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

            if (!cominner.classList.contains(...["translate-x-full", "rtl:-translate-x-full"])) {
                cominner.classList.add(...["translate-x-full", "rtl:-translate-x-full"]);
            }

            if (body.classList.contains("overflow-hidden")) {
                body.classList.remove("overflow-hidden");
            }
        }
    });
});

// REPLACE ALL EMPTY LINK WITH VOID
document.querySelectorAll('a[href="#"]').forEach((link) => {
    link.addEventListener("click", (e) => e.preventDefault());
});

// VIDEO PLAY PAUSE CONTROLLER
const videoWrapper = document.querySelectorAll(".video-wrapper");
videoWrapper.forEach(function (parent) {
    let controllWrapper = document.querySelector(".controll-wrapper");
    const video = parent.querySelector("video");
    const playPause = parent.querySelectorAll(".controller");

    playPause.forEach((elem) => {
        elem.addEventListener("click", function () {
            controllWrapper = this.closest(".controll-wrapper");
            video.play();
            controllWrapper.classList.add("hide");
        });
    });

    video.addEventListener("click", function () {
        video.pause();
        controllWrapper.classList.remove("hide");
    });

    video.addEventListener("ended", function () {
        video.pause();
        controllWrapper.classList.remove("hide");
    });
});

// FILTER ACCORDION
const fa = document.querySelectorAll(".lms-accordion");
fa.forEach(function (f) {
    const fab = f.querySelector(".lms-accordion-button");

    if (fab) {
        fab.addEventListener("click", function () {
            this.classList.toggle("panel-show");
        });
    }
});

// CARD LAYOUT CONTROLLER
const clb = document.querySelectorAll(".card-layout-button");
clb.forEach(function (b) {
    b.addEventListener("click", function () {
        clb.forEach((c) => c.classList.remove("active"));

        if (!this.classList.contains("active")) {
            this.classList.add("active");
        }
        const layout = this.getAttribute("data-layout");
        html.setAttribute("data-card-layout", layout);
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

// TIMER FOR QUIZ
const timerElement = document.querySelector(".quiz-time");
const getTimeAttr = timerElement
    ? timerElement.hasAttribute("data-quiz-minute")
    : false;
if (timerElement && getTimeAttr) {
    const initialMinutes = timerElement.getAttribute("data-quiz-minute");
    // Convert minutes to seconds
    let timeLeft = initialMinutes * 60;

    // Function to format time (HH:MM:SS)
    function formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        const hour = Math.floor(minutes / 60);

        const remainingSeconds = seconds % 60;
        const remainingMinute = minutes % 60;
        const remainingHour = hour % 60;
        return `${String(remainingHour).padStart(2, "0")}:${String(
            remainingMinute
        ).padStart(2, "0")}:${String(remainingSeconds).padStart(2, "0")}`;
    }

    // Update the timer every second
    const countdown = setInterval(() => {
        if (timeLeft <= 0) {
            clearInterval(countdown);
            timerElement.textContent = "00:00:00";
            if (start == true) {
                $("#final-submit").submit();
            }
        } else {
            timeLeft--;
        }

        // Initially set the timer display
        timerElement.textContent = formatTime(timeLeft);
    }, 1000);

    // Initially set the timer display
    timerElement.textContent = formatTime(timeLeft);
}

// DYNAMIC CATEGORY BACKGROUND COLOR
const cbc = document.querySelectorAll(".category-bg-color");
const colors = [
    "#F6F0E8",
    "#F6F0E8",
    "#F0F6E8",
    "#F8F2F5",
    "#FFF2F2",
    "#F0FBF5",
    "#F8F2E6",
    "#F4F9FF",
];
cbc.forEach((cat) => {
    cat.style.backgroundColor =
        colors[Math.floor(Math.random() * colors.length)];
});

// COUNTER NUMBER
(function counter() {
    const counters = document.querySelectorAll(".lms-counter");

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

// CIRCLE COURSE RATING
const circleRating = document.querySelectorAll(".circle-rating");

circleRating.forEach(function (elm) {
    const dataRating = elm.getAttribute("data-rating");
    const courseRate = dataRating ? dataRating : 0;

    const dashValue = 300 + 24 * courseRate;
    elm.setAttribute("stroke-dasharray", dashValue);
});

if (start == true) {
    document.addEventListener("visibilitychange", function () {
        if (document.hidden) {
            $("#final-submit").submit();
        }
    });
}

// LAZY IMAGE LOADER
const observer = lozad(
    document.querySelectorAll("img[data-src]"),
    {
        rootMargin: '200px 0px',
        threshold: 0.1,
    }
);
observer.observe();