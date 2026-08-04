document.addEventListener('DOMContentLoaded', function () {
	var menuToggle = document.querySelector('.menu-toggle');
	var primaryNav = document.querySelector('.nav-primary');
	if (menuToggle && primaryNav) {
		menuToggle.addEventListener('click', function () {
			var expanded = menuToggle.getAttribute('aria-expanded') === 'true';
			menuToggle.setAttribute('aria-expanded', expanded ? 'false' : 'true');
			primaryNav.classList.toggle('is-open');
		});
	}
	function bindCarousel(containerSelector, prevSelector, nextSelector) {
		var container = document.querySelector(containerSelector);
		var prev = document.querySelector(prevSelector);
		var next = document.querySelector(nextSelector);
		if (!container) { return; }
		var step = function () { return Math.max(container.clientWidth * 0.85, 280); };
		if (prev) { prev.addEventListener('click', function () { container.scrollBy({ left: -step(), behavior: 'smooth' }); }); }
		if (next) { next.addEventListener('click', function () { container.scrollBy({ left: step(), behavior: 'smooth' }); }); }
	}
	bindCarousel('.destinations-carousel', '[data-destinations-prev]', '[data-destinations-next]');
	bindCarousel('.testimonials-carousel', '[data-testimonials-prev]', '[data-testimonials-next]');
	var testimonialCarousel = document.querySelector('.testimonials-carousel');
	var dots = document.querySelectorAll('.testimonial-dot');
	if (testimonialCarousel && dots.length) {
		var activateDot = function () {
			var slides = testimonialCarousel.querySelectorAll('.testimonial-card');
			if (!slides.length) { return; }
			var scrollLeft = testimonialCarousel.scrollLeft;
			var activeIndex = 0;
			slides.forEach(function (slide, index) {
				if (slide.offsetLeft - testimonialCarousel.offsetLeft <= scrollLeft + slide.clientWidth / 2) { activeIndex = index; }
			});
			dots.forEach(function (dot, index) { dot.classList.toggle('is-active', index === activeIndex); });
		};
		dots.forEach(function (dot, index) {
			dot.addEventListener('click', function () {
				var slide = testimonialCarousel.querySelectorAll('.testimonial-card')[index];
				if (slide) { testimonialCarousel.scrollTo({ left: slide.offsetLeft - testimonialCarousel.offsetLeft, behavior: 'smooth' }); }
			});
		});
		testimonialCarousel.addEventListener('scroll', activateDot, { passive: true });
		activateDot();
	}
});
