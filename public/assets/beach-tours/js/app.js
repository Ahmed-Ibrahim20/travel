// AOS
AOS.init({ duration: 1000, once: true });

const swiper = new Swiper(".trips-swiper", {
  slidesPerView: 1,
  spaceBetween: 20,
  loop: true,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  breakpoints: {
    576: { slidesPerView: 2 },
    992: { slidesPerView: 3 },
    1200: { slidesPerView: 4 },
  },
});
const tSwiper = new Swiper(".t-swiper", {
  slidesPerView: 1,
  spaceBetween: 20,
  loop: true,
  autoHeight: true,
  autoplay: { delay: 4500, disableOnInteraction: false },
  keyboard: { enabled: true },
  pagination: { el: ".swiper-pagination", clickable: true },
  navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
  breakpoints: {
    576: { slidesPerView: 1 },
    768: { slidesPerView: 1 },
    1200: { slidesPerView: 1.1 },
  },
});
type =
  "application/ld+json" >
  {
    "@context": "https://schema.org",
    "@type": "Organization",
    name: "Sun & Sea Tours",
    url: "https://example.com",
    aggregateRating: {
      "@type": "AggregateRating",
      ratingValue: "4.9",
      reviewCount: "1240",
    },
    review: [
      {
        "@type": "Review",
        author: "Ahmed M.",
        reviewBody: "Everything was smooth & professional...",
        reviewRating: { "@type": "Rating", ratingValue: "5" },
      },
      {
        "@type": "Review",
        author: "Sara K.",
        reviewBody: "Great value and perfectly organized...",
        reviewRating: { "@type": "Rating", ratingValue: "4.5" },
      },
    ],
  };

// Booking form demo handler (client-side)
document.addEventListener("DOMContentLoaded", function () {
  const alertEl = document.getElementById("bookingAlert");
  const callBtn = document.getElementById("callNowBtn");

  if (callBtn)
    callBtn.addEventListener("click", () => {
      window.location.href = "tel:+201000000000";
    });
});
/* =========================
   Footer small JS (newsletter demo)
   Put into assets/js/main.js or before </body>
   ========================= */
document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("footerNewsletter");
  const email = document.getElementById("footerEmail");
  const msg = document.getElementById("newsletterMsg");

  if (!form) return;

  form.addEventListener("submit", (e) => {
    e.preventDefault();
    msg.textContent = "";

    const val = email.value.trim();
    if (!val || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val)) {
      msg.textContent = "Please enter a valid email address.";
      msg.style.color = "#fca5a5";
      email.focus();
      return;
    }

    const btn = form.querySelector(".btn-news");
    btn.disabled = true;
    const original = btn.textContent;
    btn.textContent = "Subscribing...";

    // Replace with real fetch to your newsletter / backend endpoint
    setTimeout(() => {
      btn.disabled = false;
      btn.textContent = original;
      form.reset();
      msg.style.color = "#bbf7d0";
      msg.textContent =
        "Thanks — you are subscribed! Check your inbox for a welcome email.";
    }, 900);
  });
});
