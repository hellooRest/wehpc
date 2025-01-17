document.addEventListener("DOMContentLoaded", () => {
    const switchBtns = document.querySelectorAll('.switch button');
    const body = document.querySelector('.body');

    // Kiểm tra và áp dụng trạng thái trang từ session
    const activePage = sessionStorage.getItem('activePage') || 'diendan'; // Mặc định là 'diendan'
    if (activePage === 'gopy') {
        body.classList.add('active'); // Nếu lưu 'gopy', chuyển sang trang góp ý
        document.getElementById('btn-gopy').classList.add('active'); // Thêm class active cho nút Góp Ý
    } else {
        body.classList.remove('active'); // Nếu lưu 'diendan', chuyển sang trang diễn đàn
        document.getElementById('btn-diendan').classList.add('active'); // Thêm class active cho nút Diễn Đàn
    }

    // Lắng nghe sự kiện click để chuyển trang
    switchBtns.forEach((btn) => {
        btn.addEventListener('click', () => {
            // Toggle lớp 'active' trên body
            if (btn.id === 'btn-gopy') {
                body.classList.add('active');
                sessionStorage.setItem('activePage', 'gopy'); // Lưu trang Góp Ý vào session
            } else {
                body.classList.remove('active');
                sessionStorage.setItem('activePage', 'diendan'); // Lưu trang Diễn Đàn vào session
            }

            // Cập nhật trạng thái các nút
            switchBtns.forEach((b) => b.classList.remove('active'));
            btn.classList.add('active');
        });
    });
});