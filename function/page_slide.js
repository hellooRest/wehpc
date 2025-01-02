document.addEventListener("DOMContentLoaded", () => {
    const switchBtns = document.querySelectorAll('.switch button');
    const body = document.querySelector('.body');

    switchBtns.forEach((btn) => {
        btn.addEventListener('click', () => {
            // Toggle lớp 'active' trên body
            if (btn.id === 'btn-gopy') {
                body.classList.add('active');
            } else {
                body.classList.remove('active');
            }

            // Cập nhật trạng thái các nút
            switchBtns.forEach((b) => b.classList.remove('active'));
            btn.classList.add('active');
        });
    });
});
