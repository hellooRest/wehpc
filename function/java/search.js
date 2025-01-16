const searchInput = document.getElementById('search-input');
const btnDiendan = document.getElementById('btn-diendan');
const btnGopy = document.getElementById('btn-gopy');
const searchButton = document.querySelector('#search-button');
const timeBar = document.getElementById('time');
const searchForm = document.getElementById('search-form');

// Hàm cập nhật placeholder dựa trên nút đang active
function setInitialPlaceholder() {
    if (btnDiendan.classList.contains('active')) {
        searchInput.placeholder = 'Tìm kiếm trong diễn đàn...';
    } else if (btnGopy.classList.contains('active')) {
        searchInput.placeholder = 'Tìm kiếm trong góp ý...';
    }
}

// Cập nhật placeholder khi trang tải lần đầu
document.addEventListener('DOMContentLoaded', setInitialPlaceholder);

// Sự kiện click cho nút Diễn Đàn
btnDiendan.addEventListener('click', () => {
    btnDiendan.classList.add('active');
    btnGopy.classList.remove('active');
    searchInput.placeholder = 'Tìm kiếm trong diễn đàn...';
    document.getElementById('active-section').value = 'diendan';  // Gửi giá trị "diendan"
    console.log(document.getElementById('active-section').value); // Kiểm tra
});

// Sự kiện click cho nút Góp Ý
btnGopy.addEventListener('click', () => {
    btnGopy.classList.add('active');
    btnDiendan.classList.remove('active');
    searchInput.placeholder = 'Tìm kiếm trong góp ý...';
    document.getElementById('active-section').value = 'gopy';  // Gửi giá trị "gopy"
    console.log(document.getElementById('active-section').value); // Kiểm tra
});

// Sự kiện click cho nút tìm kiếm
searchButton.addEventListener('click', (event) => {
    if (window.innerWidth <= 500) {
        if (searchInput.style.visibility === 'hidden') {
            // Mở rộng input tìm kiếm và ẩn thanh thời gian
            searchInput.style.visibility = 'visible';
            searchInput.style.width = '30vw';
            timeBar.style.marginLeft = '0';
        } else {
            // Thu nhỏ input tìm kiếm và hiển thị thanh thời gian
            searchInput.style.visibility = 'hidden';
            searchInput.style.width = '0';
            timeBar.style.marginLeft = '2vw';
        }
    } else {
        if (searchInput.style.visibility !== 'hidden' && searchInput.value.trim() !== '') {
            // Gửi form tìm kiếm tới server
            searchForm.submit();
        }
    }
    event.stopPropagation();
});
