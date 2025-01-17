document.addEventListener("DOMContentLoaded", () => {
    const switchBtns = document.querySelectorAll('.switch button');
    const body = document.querySelector('.body');
    const postForm = document.getElementById('post-form');
    const voteButtons = document.querySelectorAll('.vote button');
    const searchInput = document.getElementById('search-input'); // Input tìm kiếm
    const successMessage = document.querySelector('.success-message');
    const errorMessage = document.querySelector('.error-message');

    // Xử lý chuyển đổi trạng thái giữa diendan và gopy
    switchBtns.forEach((btn) => {
        btn.addEventListener('click', () => {
            if (btn.id === 'btn-gopy') {
                body.classList.add('active'); // Chuyển sang trang góp ý
            } else {
                body.classList.remove('active'); // Chuyển sang trang diễn đàn
            }

            switchBtns.forEach((b) => b.classList.remove('active'));
            btn.classList.add('active');
        });
    });

    // Gán URL action khi gửi form bài viết
    postForm.addEventListener('submit', (e) => {
        e.preventDefault(); // Ngăn gửi form mặc định

        // Xác định URL dựa trên trạng thái
        const url = body.classList.contains('active')
            ? 'function/php/gopypost.php' // Nếu là trang gopy
            : 'function/php/diendanpost.php'; // Nếu là trang diễn đàn

        postForm.action = url; // Gán action động cho form
        postForm.submit(); // Gửi form
    });

    // Xử lý tìm kiếm bài viết khi nhập từ khóa
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            const activeSection = document.querySelector('.body.active'); // Kiểm tra trang đang active

            if (activeSection) {
                const searchTerm = searchInput.value.toLowerCase();
                filterPosts(searchTerm, activeSection); // Gọi hàm lọc bài viết
            }
        });
    }

    // Hàm lọc bài viết dựa trên từ khóa tìm kiếm
    function filterPosts(searchTerm, activeSection) {
        const posts = activeSection.querySelectorAll('.post-item'); // Lấy tất cả bài viết trong phần active
        posts.forEach((post) => {
            const title = post.querySelector('h3').textContent.toLowerCase(); // Tiêu đề bài viết
            const content = post.querySelector('p').textContent.toLowerCase(); // Nội dung bài viết

            // Kiểm tra xem bài viết có chứa từ khóa tìm kiếm không
            if (title.includes(searchTerm) || content.includes(searchTerm)) {
                post.style.display = ''; // Hiển thị bài viết nếu khớp
            } else {
                post.style.display = 'none'; // Ẩn bài viết nếu không khớp
            }
        });
    }

    // Xử lý vote động cho cả Diễn Đàn và Góp Ý
    voteButtons.forEach((button) => {
        button.addEventListener('click', (e) => {
            e.preventDefault();

            const postId = button.closest('.vote').dataset.postId; // Lấy ID bài viết
            const action = button.dataset.action; // Lấy hành động (upvote/downvote)

            // Xác định URL vote dựa trên trạng thái
            const url = body.classList.contains('active')
                ? 'function/php/gopyvote.php'
                : 'function/php/diendanvote.php';

            // Gửi yêu cầu vote qua Fetch API
            fetch(url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ postId, action })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const voteCount = document.getElementById(`vote-count-${postId}`);
                        voteCount.textContent = data.totalVotes; // Cập nhật số vote
                    } else {
                        alert(data.message || 'Đã xảy ra lỗi!');
                    }
                })
                
        });
    });
});
