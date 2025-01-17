const searchInput = document.getElementById('search-input');
const btnDiendan = document.getElementById('btn-diendan');
const btnGopy = document.getElementById('btn-gopy');
const searchButton = document.querySelector('#search-button');
const timeBar = document.getElementById('time');
const searchForm = document.getElementById('search-form');
const activeSection = document.getElementById("active-section");

// Hàm cập nhật placeholder dựa trên nút đang active
function setInitialPlaceholder() {
    if (btnDiendan.classList.contains('active')) {
        searchInput.placeholder = 'Tìm kiếm trong diễn đàn...';
    } else if (btnGopy.classList.contains('active')) {
        searchInput.placeholder = 'Tìm kiếm trong góp ý...';
    }
}

// Cập nhật placeholder và giá trị khi trang tải lần đầu
document.addEventListener('DOMContentLoaded', () => {
    setInitialPlaceholder();

    // Load lại giá trị tìm kiếm từ session (truyền an toàn qua data-attribute)
    const searchTerm = searchInput.dataset.searchTerm || '';
    if (searchTerm) {
        searchInput.value = searchTerm;
    }
});

// Sự kiện click cho nút Diễn Đàn
btnDiendan.addEventListener('click', () => {
    btnDiendan.classList.add('active');
    btnGopy.classList.remove('active');
    searchInput.placeholder = 'Tìm kiếm trong diễn đàn...';
    activeSection.value = 'diendan'; // Gửi giá trị "diendan"
});

// Sự kiện click cho nút Góp Ý
btnGopy.addEventListener('click', () => {
    btnGopy.classList.add('active');
    btnDiendan.classList.remove('active');
    searchInput.placeholder = 'Tìm kiếm trong góp ý...';
    activeSection.value = 'gopy'; // Gửi giá trị "gopy"
});

searchInput.addEventListener("input", () => {
    const searchTerm = searchInput.value.trim();

    if (searchTerm === "") {
        localStorage.removeItem("searchTerm");
        // Chỉ reset trang nếu không phải do người dùng xóa thủ công
        if (document.activeElement !== searchInput) {
            window.location.href = "/home.php";
        }
    } else {
        localStorage.setItem("searchTerm", searchTerm);
    }
});


// Sự kiện click cho nút tìm kiếm
searchButton.addEventListener('click', (event) => {
    if (window.innerWidth <= 500) {
        // Hiển thị hoặc thu nhỏ input tìm kiếm
        if (searchInput.style.visibility === 'hidden') {
            searchInput.style.visibility = 'visible';
            searchInput.style.width = '30vw';
            timeBar.style.marginLeft = '0';
        } else {
            searchInput.style.visibility = 'hidden';
            searchInput.style.width = '0';
            timeBar.style.marginLeft = '2vw';
        }
    } else {
        if (searchInput.value.trim() !== '') {
            // Gửi form tìm kiếm
            searchForm.submit();
        }
    }
    event.stopPropagation();
});
