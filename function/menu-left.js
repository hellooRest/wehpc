const menuSymbol = document.getElementById('menu_symbol');
const menu = document.getElementById('menu');
const body = document.body;

// Mở/Đóng menu và điều chỉnh layout
menuSymbol.addEventListener('click', (event) => {
    requestAnimationFrame(() => {
        menu.classList.toggle('open');
        body.classList.toggle('menu-open');
    });
    event.stopPropagation();
});

// Ẩn menu khi click ra ngoài
document.addEventListener('click', (event) => {
    if (!menu.contains(event.target) && !menuSymbol.contains(event.target)) {
        requestAnimationFrame(() => {
            menu.classList.remove('open');
            body.classList.remove('menu-open');
        });
    }
});
