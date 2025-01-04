const menuSymbol = document.getElementById('menu_symbol');
const menu = document.getElementById('menu');
const body = document.body;
const overlay = document.getElementById('menu_overlay');

// Mở/Đóng menu và thay đổi biểu tượng ☰
menuSymbol.addEventListener('click', (event) => {
    event.stopPropagation(); // Ngăn sự kiện lan ra ngoài
    // Toggle các lớp trạng thái
    menu.classList.toggle('open');
    body.classList.toggle('menu-open');
    menuSymbol.classList.toggle('open');
    menuSymbol.classList.toggle('close');
});

// Đóng menu khi click vào overlay
overlay.addEventListener('click', (event) => 
    {
    event.stopPropagation(); // Ngăn sự kiện lan ra ngoài

    // Đóng menu và reset trạng thái biểu tượng
    menu.classList.remove('open');
    body.classList.remove('menu-open');
    menuSymbol.classList.remove('open');
    menuSymbol.classList.add('close');
});
