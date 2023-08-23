jQuery(window).on("pluginSwiperReady", function () {
	var sliderTop = new Swiper(".slider-top", {
		spaceBetween: 10,
		slidesPerView: "auto",
		centeredSlides: true,
		navigation: {
			nextEl: ".slider-arrow-right",
			prevEl: ".slider-arrow-left",
		},
		loop: true,
		loopedSlides: 4,
	});
	var sliderThumbs = new Swiper(".slider-thumbs", {
		spaceBetween: 10,
		centeredSlides: true,
		slidesPerView: "auto",
		touchRatio: 0.2,
		slideToClickedSlide: true,
		loop: true,
		loopedSlides: 4,
	});

	sliderTop.controller.control = sliderThumbs;
	sliderThumbs.controller.control = sliderTop;
});
