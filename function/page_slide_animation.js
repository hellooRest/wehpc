const switchBtns = document.querySelectorAll('.switch button');
const body = document.querySelector('.body');

switchBtns.forEach((btn) => {
    btn.addEventListener('click', () => {
        if (btn.id === 'btn-gopy') {
            body.classList.add('active');
        } else {
            body.classList.remove('active');
        }
    });
});
