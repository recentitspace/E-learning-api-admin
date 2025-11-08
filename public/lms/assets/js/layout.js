"use strict";
var html = document.documentElement;

// INITIALIZE SIDEBAR SIZE
function setSidebarSize() {
    if (localStorage.getItem("data-sidebar-size")) {
        html.setAttribute(
            "data-sidebar-size",
            localStorage.getItem("data-sidebar-size")
        );
    } else {
        localStorage.setItem("data-sidebar-size", "lg");
    }
}
setSidebarSize();

// TOGGLE SIDEBAR SIZE
function toggleAppMenuSize() {
    if (localStorage.getItem("data-sidebar-size") != "lg") {
        localStorage.setItem("data-sidebar-size", "lg");
    } else {
        localStorage.setItem("data-sidebar-size", "sm");
    }

    // UPDATE SIDEBAR SIZE ATTRIBUTE
    setSidebarSize();

    // DESTROY AND UPDATE SMOOTH SCROLLBAR
    if (html.getAttribute("data-sidebar-size") != "lg") {
        Scrollbar.destroy(document.querySelector("#app-menu-scrollbar"));
    } else {
        let option = {
            continuousScrolling: false,
            alwaysShowTracks: true,
        };
        Scrollbar.initAll(option);
    }
}

function windowResize() {
    let windowSize = document.documentElement.clientWidth;

    if (windowSize >= 1280) {
        if (document.getElementById("app-menu-hamburger")) {
            document
                .getElementById("app-menu-hamburger")
                .addEventListener("click", toggleAppMenuSize);
        }

        document.getElementById("app-drawer").classList.add("z-backdrop");
        document.getElementById("app-drawer").classList.remove("z-[151]");
    }

    if (windowSize < 1280 && document.getElementById("app-drawer")) {
        localStorage.setItem("data-sidebar-size", "lg");
        html.setAttribute(
            "data-sidebar-size",
            localStorage.getItem("data-sidebar-size")
        );

        document.getElementById("app-drawer").classList.remove("z-backdrop");
        document.getElementById("app-drawer").classList.add("z-[151]");
    }

    // UPDATE SCROLL BAR
    if (windowSize < 1280 && html.getAttribute("data-sidebar-size") == "lg") {
        if (document.querySelector("[data-scrollbar]")) {
            let option = {
                continuousScrolling: false,
                alwaysShowTracks: true,
            };
            Scrollbar.initAll(option);
        }
    }
}
windowResize();

// ON WINDOW RESIZE
window.addEventListener("resize", windowResize, true);
