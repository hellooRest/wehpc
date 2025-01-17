document.querySelectorAll('.vote').forEach(voteContainer => {
    const upvoteButton = voteContainer.querySelector('.upvote');
    const downvoteButton = voteContainer.querySelector('.downvote');
    const voteCount = voteContainer.querySelector('.vote-count');
    const postId = voteContainer.getAttribute('data-post-id');
    const body = document.querySelector('.body'); // Kiểm tra phần diễn đàn hay góp ý

    // Hàm gửi yêu cầu vote
    function sendVote(action) {
        const isGopy = body.classList.contains('active'); // Xác định phần góp ý hay diễn đàn
        
        // Cập nhật giao diện ngay khi nhấn nút
        if (action === 'upvote') {
            upvoteButton.classList.add('chose');
            downvoteButton.classList.remove('chose');
        } else if (action === 'downvote') {
            downvoteButton.classList.add('chose');
            upvoteButton.classList.remove('chose');
        } else if (action === 'remove') {
            upvoteButton.classList.remove('chose');
            downvoteButton.classList.remove('chose');
        }

        fetch('function/php/vote.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                id: postId,
                action: action,
                is_gopy: isGopy
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Cập nhật tổng số vote từ server
                voteCount.textContent = data.total_votes;
            } else {
                alert(data.message); // Thông báo lỗi nếu có
            }
        })
        .catch(error => {
            console.error('Lỗi:', error);
            alert('Không thể gửi yêu cầu. Vui lòng thử lại.');
        });
    }

    // Gán sự kiện click cho nút upvote
    upvoteButton.addEventListener('click', function () {
        if (this.classList.contains('chose')) {
            // Nếu đã chọn, gửi yêu cầu xóa vote
            sendVote('remove');
        } else {
            sendVote('upvote');
        }
    });

    // Gán sự kiện click cho nút downvote
    downvoteButton.addEventListener('click', function () {
        if (this.classList.contains('chose')) {
            // Nếu đã chọn, gửi yêu cầu xóa vote
            sendVote('remove');
        } else {
            sendVote('downvote');
        }
    });
});