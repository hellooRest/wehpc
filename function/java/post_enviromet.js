document.addEventListener("DOMContentLoaded", () => 
    {
    const switchBtns = document.querySelectorAll('.switch button');
    const body = document.querySelector('.body');
    const postForm = document.getElementById('post-form');

    // Xử lý chuyển đổi trạng thái giữa diendan và gopy
    switchBtns.forEach((btn) => {
        btn.addEventListener('click', () => {
            if (btn.id === 'btn-gopy') {
                body.classList.add('active');
            } else {
                body.classList.remove('active');
            }

            switchBtns.forEach((b) => b.classList.remove('active'));
            btn.classList.add('active');
        });
    });

    // Gán URL action khi gửi form
    postForm.addEventListener('submit', (e) => {
        e.preventDefault(); // Ngăn gửi form mặc định

        // Xác định URL dựa trên trạng thái
        const url = body.classList.contains('active')
            ? 'function/php/gopypost.php'
            : 'function/php/diendanpost.php';

        postForm.action = url; // Gán action động
        postForm.submit(); // Gửi form
    });
});
