"use strict";
document.addEventListener("DOMContentLoaded", () => {
    const openModalButtons = document.querySelectorAll("[data-modal-id]");
    const closeModalButtons = document.querySelectorAll(".close-modal-btn");

    openModalButtons.forEach((button) => {
        button.addEventListener("click", () => {
            const modalId = button.getAttribute("data-modal-id");
            const modal = document.getElementById(modalId);
            if (!modal) {
                return;
            }
            const modalContent = modal.querySelector(".modal-content");

            modal.classList.remove("!hidden");
            setTimeout(() => {
                modalContent.classList.remove("opacity-0", "-translate-y-10");
                modalContent.classList.add("opacity-100", "translate-y-0");
            }, 10);
        });
    });

    closeModalButtons.forEach((button) => {
        button.addEventListener("click", () => {
            const modal = button.closest(".modal");
            const modalContent = modal.querySelector(".modal-content");

            modalContent.classList.remove("opacity-100", "translate-y-0");
            modalContent.classList.add("opacity-0", "-translate-y-10");
            setTimeout(() => {
                modal.classList.add("!hidden");
            }, 300);
        });
    });

    // Close modal when clicking outside the modal content
    document.querySelectorAll(".modal").forEach((modal) => {
        modal.addEventListener("click", (e) => {
            if (e.target === modal) {
                const modalContent = modal.querySelector(".modal-content");
                modalContent.classList.remove("opacity-100", "translate-y-0");
                modalContent.classList.add("opacity-0", "-translate-y-10");
                setTimeout(() => {
                    modal.classList.add("!hidden");
                }, 300);
            }
        });
    });
});
