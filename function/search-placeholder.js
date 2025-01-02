// Lấy các phần tử cần thiết
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
});

// Sự kiện click cho nút Góp Ý
btnGopy.addEventListener('click', () => {
    btnGopy.classList.add('active');
    btnDiendan.classList.remove('active');
    searchInput.placeholder = 'Tìm kiếm trong góp ý...';
});

// Sự kiện click cho nút tìm kiếm
searchButton.addEventListener('click', (event) => {
    if (window.innerWidth <= 500) {
        if (searchInput.style.visibility === 'hidden') {
            // Expand the search input and hide the time bar
            searchInput.style.visibility = 'visible';
            searchInput.style.width = '30vw';
            timeBar.style.marginLeft = '0';
        } else {
            // Shrink the search input and show the time bar
            searchInput.style.visibility = 'hidden';
            searchInput.style.width = '0';
            timeBar.style.marginLeft = '2vw';
        }
    } else {
        // Submit the form if the search input is visible and has a value
        if (searchInput.style.visibility !== 'hidden' && searchInput.value.trim() !== '') {
            searchForm.submit();
        }
    }
    event.stopPropagation();
});