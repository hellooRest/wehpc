// Toggle Hiển Thị Popup
function togglePopup() 
{
    const popup = document.getElementById('login-register');
    popup.classList.toggle('active');
    document.body.classList.toggle('menu-open');
}

// Chuyển Đổi Giữa Tabs
function switchTab(tab) 
{
    const loginBtn = document.getElementById('btn-login');
    const registerBtn = document.getElementById('btn-register');
    const formWrapper = document.getElementById('form-wrapper');

    if (tab === 'login') {
        loginBtn.classList.add('active');
        registerBtn.classList.remove('active');
        formWrapper.style.transform = 'translateX(0%)';
    } else if (tab === 'register') {
        registerBtn.classList.add('active');
        loginBtn.classList.remove('active');
        formWrapper.style.transform = 'translateX(-50%)';
    }
}

// Mở Popup Khi Click Nút Đăng Nhập/Đăng Ký
document.querySelector('form[action="#login-register"] button').addEventListener('click', function (e) {
    e.preventDefault();
    togglePopup();
});
