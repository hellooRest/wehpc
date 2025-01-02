const menuSymbol = document.getElementById('menu_symbol');
const menu = document.getElementById('menu');

// Mở/Đóng menu và điều chỉnh layout
menuSymbol.addEventListener('click', (event) => {
    menu.classList.toggle('open');
    document.body.classList.toggle('menu-open');
    event.stopPropagation();
});

// Ẩn menu khi click ra ngoài
document.addEventListener('click', (event) => {
    if (!menu.contains(event.target) && !menuSymbol.contains(event.target)) {
        menu.classList.remove('open');
        document.body.classList.remove('menu-open');
    }
});
