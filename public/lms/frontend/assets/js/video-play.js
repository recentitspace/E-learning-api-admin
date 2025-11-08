$(function () {
    "use strict";
    const stopVideo = document.querySelector(".demo-course-video-stop");
    const dvm = document.querySelector("#demo-video-modal");
    var player = new Plyr("#course-demo", {
        settings: ["speed"],
        seekTime: 0,
        speed: {
            selected: 1,
            options: [0.5, 0.75, 1, 1.25, 1.5],
        },
    });
    if (dvm) {
        dvm.addEventListener("click", (e) => {
            e.preventDefault();
            if (e.target !== this && e.target == dvm) {
                player.stop();
            }
        });
    }
    if (stopVideo) {
        stopVideo.addEventListener("click", () => {
            player.stop();
        });
    }
});
