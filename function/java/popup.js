// Toggle Hiển Thị Popup
function togglePopup() {
    const popup = document.getElementById('login-register');
    popup.classList.toggle('active');
    document.body.classList.toggle('menu-open');
}

// Chuyển Đổi Giữa Tabs
function switchTab(tab) {
    const formWrapper = document.getElementById('form-wrapper');
    const loginTab = document.getElementById('btn-login');
    const registerTab = document.getElementById('btn-register');

    if (tab === 'login') {
        formWrapper.style.transform = 'translateX(0)';
        loginTab.classList.add('active');
        registerTab.classList.remove('active');
    } else {
        formWrapper.style.transform = 'translateX(-50%)';
        loginTab.classList.remove('active');
        registerTab.classList.add('active');
    }
}

// Mở Popup Khi Click Nút Đăng Nhập/Đăng Ký
document.querySelector('form[action="#login-register"] button').addEventListener('click', function (e) {
    e.preventDefault();
    togglePopup();
});
