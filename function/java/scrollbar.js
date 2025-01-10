const trending = document.querySelector('.trending');

// Khi chuột vào, bật thanh cuộn
trending.addEventListener('mouseenter', () => {
    trending.style.overflowY = 'scroll';
});

// Khi chuột ra, ẩn thanh cuộn
trending.addEventListener('mouseleave', () => {
    trending.style.overflowY = 'hidden';
});
