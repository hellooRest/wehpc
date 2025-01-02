const menuSymbol = document.getElementById('menu_symbol');
const menu = document.getElementById('menu');
const body = document.body;

// Mở/Đóng menu và thay đổi biểu tượng
menuSymbol.addEventListener('click', (event) => {
    event.stopPropagation();  // Ngừng sự kiện click truyền lên để tránh ẩn menu khi nhấn vào menu_symbol
    
    // Mở/Đóng menu và thay đổi trạng thái biểu tượng
    menu.classList.toggle('open');
    body.classList.toggle('menu-open');
    menuSymbol.classList.toggle('open');  // Thêm lớp 'open' khi menu mở
    menuSymbol.classList.toggle('close'); // Thêm lớp 'close' khi menu đóng
});
