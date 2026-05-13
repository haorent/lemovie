const menu = document.querySelector('#mobile-menu');
const menuLinks = document.querySelector('.navbar__menu');

if (menu && menuLinks) {
  menu.addEventListener('click', function () {
    menu.classList.toggle('is-active');
    menuLinks.classList.toggle('active');
  });

  menuLinks.addEventListener('click', function() {
    menu.classList.remove('is-active');
    menuLinks.classList.remove('active');
  });
}

let slideIndex = 1;
let timer; 

showSlides(slideIndex);
startAutoPlay();

function changeSlide(n) {
  clearInterval(timer); 
  showSlides(slideIndex += n);
  startAutoPlay();
}

function showSlides(n) {
  let slides = document.getElementsByClassName("slide");
  if (slides.length === 0) return; 
  if (n > slides.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = slides.length}
  for (let i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";  
  }
  slides[slideIndex - 1].style.display = "block";  
}
function startAutoPlay() {
  timer = setInterval(function() {
    showSlides(slideIndex += 1);
  }, 4000); 
}

const watchBtns = document.querySelectorAll('.watch-btn');

watchBtns.forEach(btn => {
  btn.addEventListener('click', () => {
    window.location.href = 'booking.php';
  });
});