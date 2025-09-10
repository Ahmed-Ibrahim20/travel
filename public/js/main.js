let swiper = new Swiper(".slider-wrapper", {    // slider
  loop: true,
  //   grabCursor: true,
  spaceBetween: 20,
  pagination: {
      el: ".swiper-pagination",
      clickable: true,
      dynamicBullets: true,
  },
  autoplay: {
      delay: 3000,
      disableOnInteraction: false,
  },
  speed: 500,
  breakpoints: {
      0: {
          slidesPerView: 1,
      },
      480: {
          slidesPerView: 2,
      },
      991: {
          slidesPerView: 2,
      },
      1024: {
          slidesPerView: 3,
      },
  },
  centeredSlides: false,
});
let swiper2 = new Swiper(".slider-wrapper2", {    // slider2
  loop: true,
  //   grabCursor: true,
  spaceBetween: 20,
  pagination: {
      el: ".swiper-pagination",
      clickable: true,
      dynamicBullets: true,
  },
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
  speed: 500,
  breakpoints: {
      0: {
          slidesPerView: 1,
      },
      480: {
          slidesPerView: 2,
      },
      991: {
          slidesPerView: 2,
      },
      1024: {
          slidesPerView: 3,
      },
  },
  centeredSlides: false,
});



document.addEventListener("DOMContentLoaded", () => {  // fade in , fade in left
    const fadeInElements = document.querySelectorAll(".fade-in, .fade-in-left");
  
    const observer = new IntersectionObserver(
      (entries, observer) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add("visible");
            observer.unobserve(entry.target);
          }
        });
      },
      {
        threshold: 0.1,
      }
    );
    fadeInElements.forEach((el) => {
      observer.observe(el);
    });
  });
  


document.addEventListener("DOMContentLoaded", function() {  // navbar
  const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
  navLinks.forEach(function(link) {
    link.addEventListener('click', function() {
      navLinks.forEach(function(navLink) {
        navLink.classList.remove('active');
      });
        link.classList.add('active');
    });
  });
});


window.addEventListener("load", function () {  // load in nav , carousel
  const navbar = document.querySelector(".navbar");
  const carousel = document.querySelector(".carousel");
  const carousel_caption = document.querySelector(".carousel-caption");
  navbar.classList.add("visible");
  carousel.classList.add("visible");
  carousel_caption.classList.add("visible");
});


let div = document.querySelector(".up"); //scrool
window.onscroll = function () {
    if (this.scrollY >= 300) {
        div.classList.add("show");
    } else {
        div.classList.remove("show");
    }
};
div.onclick = function () {
    window.scrollTo({
        top: 0,
    });
};


