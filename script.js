document.addEventListener('DOMContentLoaded', function() {
    var hamburger = document.querySelector('.hamburger');
    var menu = document.querySelector('.menu');

    hamburger.addEventListener('click', function() {
        menu.classList.toggle('active');
    });
});

window.addEventListener('scroll', function() {
    var header = document.querySelector('header');
    if (window.scrollY > 0) {
      header.classList.add('sticky');
    } else {
      header.classList.remove('sticky');
    }
  });
  