"use strict";
class DraggableModal {
    constructor(modalSelector, draggerSelector, toggleBtnSelector, closeBtnSelector, positionStorageKey, visibilityStorageKey) {
        this.modal = document.querySelector(modalSelector);
        this.dragger = document.querySelector(draggerSelector);
        this.toggleBtn = document.querySelector(toggleBtnSelector);
        this.closeBtn = document.querySelector(closeBtnSelector);
        this.positionStorageKey = positionStorageKey;
        this.visibilityStorageKey = visibilityStorageKey;

        // Initialize
        this.init();
    }

    init() {
        this.restoreVisibility();
        this.restorePosition();
        this.addEventListeners();
    }

    static saveToSession(key, value) {
        sessionStorage.setItem(key, JSON.stringify(value));
    }

    static getFromSession(key, defaultValue = null) {
        const value = sessionStorage.getItem(key);
        return value ? JSON.parse(value) : defaultValue;
    }

    /**
     * Toggle modal visibility and save the state.
     */
    toggleVisibility() {
        const isVisible = this.modal.getAttribute("data-visibility") === "true";
        const newState = isVisible ? "false" : "true";

        this.modal.setAttribute("data-visibility", newState);
        DraggableModal.saveToSession(this.visibilityStorageKey, newState);
    }

    /**
     * Restore modal visibility on page load.
     */
    restoreVisibility() {
        const savedVisibility = DraggableModal.getFromSession(this.visibilityStorageKey, "false");
        this.modal.setAttribute("data-visibility", savedVisibility);
    }

    /**
     * Restore modal position from session storage.
     */
    restorePosition() {
        const savedPosition = DraggableModal.getFromSession(this.positionStorageKey);
        if (savedPosition) {
            this.modal.style.left = `${savedPosition.left}px`;
            this.modal.style.top = `${savedPosition.top}px`;
        }
    }

    /**
     * Add drag functionality to the modal.
     */
    enableDragging() {
        let isDragging = false;
        let offsetX, offsetY;

        const dragStart = (e) => {
            offsetX = e.clientX - this.modal.offsetLeft;
            offsetY = e.clientY - this.modal.offsetTop;
            isDragging = true;
            document.body.style.userSelect = "none";
        };

        const dragMove = (e) => {
            if (!isDragging) return;

            requestAnimationFrame(() => {
                const viewportWidth = window.innerWidth;
                const viewportHeight = window.innerHeight;
                const modalWidth = this.modal.offsetWidth;
                const modalHeight = this.modal.offsetHeight;

                let newLeft = e.clientX - offsetX;
                let newTop = e.clientY - offsetY;

                // Clamp to viewport
                newLeft = Math.max(0, Math.min(newLeft, viewportWidth - modalWidth));
                newTop = Math.max(0, Math.min(newTop, viewportHeight - modalHeight));

                this.modal.style.left = `${newLeft}px`;
                this.modal.style.top = `${newTop}px`;

                DraggableModal.saveToSession(this.positionStorageKey, { left: newLeft, top: newTop });
            });
        };

        const dragEnd = () => {
            isDragging = false;
            document.body.style.userSelect = "auto";
        };

        this.dragger.addEventListener("mousedown", dragStart);
        document.addEventListener("mousemove", dragMove);
        document.addEventListener("mouseup", dragEnd);
    }

    /**
     * Ensure modal stays within the viewport on window resize.
     */
    handleResize() {
        const viewportWidth = window.innerWidth;
        const viewportHeight = window.innerHeight;
        const modalWidth = this.modal.offsetWidth;
        const modalHeight = this.modal.offsetHeight;

        const currentLeft = this.modal.offsetLeft;
        const currentTop = this.modal.offsetTop;

        const clampedLeft = Math.max(0, Math.min(currentLeft, viewportWidth - modalWidth));
        const clampedTop = Math.max(0, Math.min(currentTop, viewportHeight - modalHeight));

        this.modal.style.left = `${clampedLeft}px`;
        this.modal.style.top = `${clampedTop}px`;
    }

    /**
     * Add event listeners to buttons and window events.
     */
    addEventListeners() {
        this.toggleBtn?.addEventListener("click", this.toggleVisibility.bind(this));
        this.closeBtn?.addEventListener("click", this.toggleVisibility.bind(this));
        this.enableDragging();

        window.addEventListener("resize", this.handleResize.bind(this));
    }
}

// Instantiate the modal class
const draggableModal = new DraggableModal(
    "#ai-modal-generate",       // Modal selector
    "#ai-content-modal-dragger", // Dragger selector
    ".ai-content-modal-btn",    // Toggle button selector
    ".ai-content-modal-close-btn", // Close button selector
    "modalPosition",            // Session storage key for position
    "modalVisibility"           // Session storage key for visibility
);

// Additional example: For the button wrapper (vertical drag only)
class VerticalDraggable {
    constructor(elementSelector, draggerSelector) {
        this.element = document.querySelector(elementSelector);
        this.dragger = document.querySelector(draggerSelector);
        this.init();
    }

    init() {
        this.enableVerticalDragging();
    }

    enableVerticalDragging() {
        let isDragging = false;
        let offsetY;

        const dragStart = (e) => {
            offsetY = e.clientY - this.element.offsetTop;
            isDragging = true;
            document.body.style.userSelect = "none";
        };

        const dragMove = (e) => {
            if (!isDragging) return;

            requestAnimationFrame(() => {
                const viewportHeight = window.innerHeight;
                const elementHeight = this.element.offsetHeight;
                let newTop = e.clientY - offsetY;

                newTop = Math.max(0, Math.min(newTop, viewportHeight - elementHeight));
                this.element.style.top = `${newTop}px`;
            });
        };

        const dragEnd = () => {
            isDragging = false;
            document.body.style.userSelect = "auto";
        };

        this.dragger.addEventListener("mousedown", dragStart);
        document.addEventListener("mousemove", dragMove);
        document.addEventListener("mouseup", dragEnd);
    }
}

// Instantiate the vertical draggable for the button wrapper
new VerticalDraggable("#ai-content-modal-btn-wrapper", "#ai-content-modal-btn-dragger");
