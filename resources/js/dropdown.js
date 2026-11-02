export function toggleDropdown(btnId, menuId) {
    const btn = document.getElementById(btnId);
    const menu = document.getElementById(menuId);

    if (!btn || !menu) return;

    const isCurrentlyHidden = menu.classList.contains("hidden");
    // Ищем стрелку внутри конкретной нажатой кнопки
    const arrow = btn.querySelector(".dropdown-arrow");

    // Закрываем все остальные открытые меню
    document.querySelectorAll(".dropdown-menu").forEach((otherMenu) => {
        if (otherMenu.id !== menuId) {
            otherMenu.classList.add("hidden");
        }
    });

    document.querySelectorAll(".dropdown-arrow").forEach((otherArrow) => {
        if (otherArrow !== arrow) {
            otherArrow.classList.remove("rotate-180");
        }
    });

    if (isCurrentlyHidden) {
        menu.classList.remove("hidden");
        arrow?.classList.add("rotate-180");
    } else {
        menu.classList.add("hidden");
        arrow?.classList.remove("rotate-180");
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const adminBtn = document.getElementById('admin-btn');

    if (adminBtn) {
        adminBtn.addEventListener('click', (event) => {
            event.stopPropagation();
            toggleDropdown('admin-btn', 'admin-menu');
        });
    }

    // Закрытие при клике мимо открытого дропдауна
    document.addEventListener('click', (event) => {
        if (!event.target.closest('.relative')) {
            document.querySelectorAll('.dropdown-menu').forEach((menu) => menu.classList.add('hidden'));
            document.querySelectorAll('.dropdown-arrow').forEach((arrow) => arrow.classList.remove('rotate-180'));
        }
    });

    // Закрытие по Escape
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            document.querySelectorAll('.dropdown-menu').forEach((menu) => menu.classList.add('hidden'));
            document.querySelectorAll('.dropdown-arrow').forEach((arrow) => arrow.classList.remove('rotate-180'));
        }
    });
});
