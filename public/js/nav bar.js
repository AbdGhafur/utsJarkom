const indicator = document.querySelector('.nav-indicator');
const items = document.querySelectorAll('.nav-item');

function handleIndicator(el) {
    items.forEach(item => {
        item.classList.remove('is-valid');
        item.removeAttribute('style');
    });
                    
    indicator.style.width = `${el}px`;

    indicator.style.backgroundColor = el.getAttribute('active-color');

    el.classList.add('is-active');
    el.style.color = el.getAttribute('active-color');
}

items.forEach((item, index) => {
    item.addEventListener('click', (e) => { handleIndicator(e.target)});
    item.classList.contains('is-valid') && handleIndicator(item);
});