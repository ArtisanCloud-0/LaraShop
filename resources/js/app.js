import "@tailwindplus/elements";

// Initialize Alpine store immediately when Alpine boots
document.addEventListener("alpine:init", () => {
    Alpine.store("toasts", {
        items: [],

        add({ message, type = "success", timeout = 4000 }) {
            const id = Date.now() + Math.random();
            this.items.push({ id, message, type });

            if (timeout) {
                setTimeout(() => {
                    this.remove(id);
                }, timeout);
            }
        },

        remove(id) {
            this.items = this.items.filter((item) => item.id !== id);
        },
    });
});

// Global listener for Livewire event dispatches
window.addEventListener("toast", (event) => {
    const data = event.detail[0] || event.detail;
    if (window.Alpine) {
        // 1. Trigger the toast notification
        Alpine.store("toasts").add(data);

        // 2. If a redirect URL is passed, wait for the timeout then navigate
        if (data.redirect) {
            const delay = data.timeout || 4000;
            setTimeout(() => {
                if (window.Livewire) {
                    Livewire.navigate(data.redirect);
                } else {
                    window.location.href = data.redirect;
                }
            }, delay);
        }
    }
});

document.addEventListener("DOMContentLoaded", () => {
    const themeToggleBtn = document.getElementById("theme-toggle");
    const sunIcon = document.getElementById("theme-toggle-sun");
    const moonIcon = document.getElementById("theme-toggle-moon");

    function updateIcons() {
        if (!sunIcon || !moonIcon) return;
        if (document.documentElement.classList.contains("dark")) {
            sunIcon.classList.remove("hidden");
            moonIcon.classList.add("hidden");
        } else {
            sunIcon.classList.add("hidden");
            moonIcon.classList.remove("hidden");
        }
    }
    updateIcons();

    if (themeToggleBtn) {
        themeToggleBtn.addEventListener("click", () => {
            if (document.documentElement.classList.contains("dark")) {
                document.documentElement.classList.remove("dark");
                localStorage.setItem("theme", "light");
            } else {
                document.documentElement.classList.add("dark");
                localStorage.setItem("theme", "dark");
            }
            updateIcons();
        });
    }
});
