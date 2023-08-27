document.addEventListener("DOMContentLoaded", function () {
    const expandableLinks = document.querySelectorAll(".expandable");

    expandableLinks.forEach(link => {
        link.addEventListener("click", function () {
            expandableLinks.forEach(otherLink => {
                if (otherLink !== this) {
                    otherLink.classList.remove("active");
                }
            });
            this.classList.toggle("active");
        });
    });
});

const toggleButton = document.getElementById("toggle-button");
const sidebar = document.getElementById("sidebar");
const content = document.getElementById("content");

toggleButton.addEventListener("click", () => {
    sidebar.classList.toggle("sidebar-hidden");
    content.classList.toggle("sidebar-hidden");
});

const openModalLinks = document.querySelectorAll(".open-modal-link");
const closeModalButton = document.getElementById("close-modal");
const modal = document.getElementById("modal");

openModalLinks.forEach(link => {
    link.addEventListener("click", () => {
        modal.style.display = "block";
    });
});

closeModalButton.addEventListener("click", () => {
    modal.style.display = "none";
});
