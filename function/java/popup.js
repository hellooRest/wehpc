// Toggle Hiển Thị Popup
function togglePopup() 
{
    const popup = document.getElementById("login-register");
    const menu = document.getElementById("menu");
    const overlay = document.getElementById("menu_overlay");

    if (popup.classList.contains("active")) {
        popup.classList.remove("active");
        menu.style.pointerEvents = "auto"; // Cho phép tương tác với menu trái
        if (overlay) overlay.style.display = "none"; // Ẩn overlay nếu tồn tại
    } else {
        popup.classList.add("active");
        menu.style.pointerEvents = "none"; // Vô hiệu hóa tương tác với menu trái khi popup mở
        if (overlay) overlay.style.display = "block"; // Hiển thị overlay nếu tồn tại
    }
}


// Chuyển Đổi Giữa Tabs
function switchTab(tab) 
{
    const loginBtn = document.getElementById('btn-login');
    const registerBtn = document.getElementById('btn-register');
    const formWrapper = document.getElementById('form-wrapper');

    if (tab === 'login') 
        {
        loginBtn.classList.add('active');
        registerBtn.classList.remove('active');
        formWrapper.style.transform = 'translateX(0%)';
    } 
    else if (tab === 'register') 
    {
        registerBtn.classList.add('active');
        loginBtn.classList.remove('active');
        formWrapper.style.transform = 'translateX(-50%)';
    }
}

// Mở Popup Khi Click Nút Đăng Nhập/Đăng Ký
document.querySelector('form[action="#login-register"] button').addEventListener('click', function (e) 
{
    e.preventDefault();
    togglePopup();
});

function toggleAddPostPopup() 
{
    const addPostPopup = document.getElementById("add-post-popup");

    if (addPostPopup.classList.contains("active")) 
        {
        addPostPopup.classList.remove("active"); // Ẩn popup nếu đang hiển thị
    } else {
        addPostPopup.classList.add("active"); // Hiển thị popup nếu đang ẩn
    }
}
