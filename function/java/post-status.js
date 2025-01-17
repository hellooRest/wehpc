document.addEventListener("DOMContentLoaded", () => {
    setTimeout(function() {
        const successMessage = document.querySelector('.success-message');
        const errorMessage = document.querySelector('.error-message');
        const body = document.querySelector('.body');

        // Kiểm tra xem trang nào đang được active
        if (body.classList.contains('active')) {
            if (successMessage) {
                successMessage.style.display = 'none';  // Ẩn thông báo thành công
            }

            if (errorMessage) {
                errorMessage.style.display = 'none';  // Ẩn thông báo lỗi
            }
        }
    }, 4000);  // Thời gian trì hoãn 4 giây
});
