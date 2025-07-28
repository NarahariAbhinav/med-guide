const items = document.querySelectorAll('.item');
const controls = document.querySelectorAll('.control');

let current = 0;

function nextSlide() {
  items[current].classList.remove('active');
  controls[current].classList.remove('active');

  current = (current + 1) % items.length;

  items[current].classList.add('active');
  controls[current].classList.add('active');
}

function selectSlide(e) {
  const control = e.target;
  const index = Number(control.getAttribute('data-index'));

  if (index !== current) {
    items[current].classList.remove('active');
    controls[current].classList.remove('active');

    current = index;

    items[current].classList.add('active');
    controls[current].classList.add('active');
  }
}

controls.forEach(control => control.addEventListener('click', selectSlide));

setInterval(nextSlide, 5000);
