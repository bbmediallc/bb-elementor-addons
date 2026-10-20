(function () {
	function debounce(fn, delay) {
		let t;
		return function () {
			clearTimeout(t);
			t = setTimeout(fn, delay);
		};
	}

	function createSwiper(el, options) {
		if (window.elementorFrontend && elementorFrontend.utils && elementorFrontend.utils.swiper) {
			return Promise.resolve(new elementorFrontend.utils.swiper(el, options));
		}
		if (window.Swiper) {
			return Promise.resolve(new window.Swiper(el, options));
		}
		return Promise.reject(new Error('Swiper not available'));
	}

	function init(root) {
		if (!root || root.dataset.bbgsReady) return;
		root.dataset.bbgsReady = '1';

		let config = {};
		try {
			config = JSON.parse(root.dataset.config || '{}');
		} catch (e) {}

		const swiperEl = root.querySelector('.bbgs-swiper');
		const thumbsWrap = root.querySelector('.bbgs-thumbs');
		const thumbs = thumbsWrap ? Array.from(thumbsWrap.querySelectorAll('.bbgs-thumb')) : [];
		const total = root.querySelectorAll('.bbgs-slide').length;
		const prev = root.querySelector('.bbgs-prev');
		const next = root.querySelector('.bbgs-next');
		const dots = root.querySelector('.bbgs-dots');

		let swiper = null;
		let bypass = false;

		const setActiveThumb = (index) => {
			thumbs.forEach((t, i) => t.classList.toggle('is-active', i === index));
		};

		const openLightbox = (index) => {
			const thumb = thumbs[index];
			if (!thumb || !config.lightbox) return;
			bypass = true;
			thumb.click();
			bypass = false;
		};

		const goTo = (index) => {
			if (!swiper) return;
			if (config.loop && typeof swiper.slideToLoop === 'function') {
				swiper.slideToLoop(index);
			} else {
				swiper.slideTo(index);
			}
		};

		const visibleCount = () => {
			if (!thumbsWrap || thumbsWrap.classList.contains('bbgs-thumbs--hidden')) return 0;
			const cols = getComputedStyle(thumbsWrap).gridTemplateColumns;
			if (!cols || cols === 'none') return thumbs.length;
			return cols.trim().split(/\s+/).length;
		};

		const applyMore = () => {
			thumbsWrap && thumbsWrap.querySelectorAll('.bbgs-more').forEach((el) => el.remove());
			if (!config.more || !thumbs.length) return;
			const show = Math.min(visibleCount(), thumbs.length);
			if (!show || thumbs.length <= show) return;
			const last = thumbs[show - 1];
			const overlay = document.createElement('span');
			overlay.className = 'bbgs-more';
			const count = document.createElement('span');
			count.className = 'bbgs-more-count';
			count.textContent = '+' + (thumbs.length - show + 1);
			overlay.appendChild(count);
			if (config.label) {
				const label = document.createElement('span');
				label.className = 'bbgs-more-label';
				label.textContent = config.label;
				overlay.appendChild(label);
			}
			last.appendChild(overlay);
		};

		if (thumbsWrap) {
			thumbsWrap.addEventListener('click', (e) => {
				if (bypass) return;
				const thumb = e.target.closest('.bbgs-thumb');
				if (!thumb) return;
				if (e.target.closest('.bbgs-more')) return;
				e.preventDefault();
				e.stopPropagation();
				const index = parseInt(thumb.dataset.index, 10) || 0;
				goTo(index);
				setActiveThumb(index);
			}, true);
		}

		[prev, next].forEach((btn) => {
			if (!btn) return;
			btn.addEventListener('keydown', (e) => {
				if (e.key === 'Enter' || e.key === ' ') {
					e.preventDefault();
					btn.click();
				}
			});
		});

		const options = {
			effect: config.effect === 'slide' ? 'slide' : 'fade',
			fadeEffect: { crossFade: true },
			speed: config.speed || 500,
			loop: !!config.loop && total > 1,
			slidesPerView: 1,
			autoHeight: false,
			grabCursor: total > 1,
			keyboard: { enabled: true, onlyInViewport: true },
			a11y: { enabled: true },
			on: {
				slideChange: function () {
					setActiveThumb(typeof this.realIndex === 'number' ? this.realIndex : this.activeIndex);
				}
			}
		};

		if (config.autoplay) {
			options.autoplay = { delay: config.autoplay, disableOnInteraction: false, pauseOnMouseEnter: true };
		}
		if (prev && next) {
			options.navigation = { prevEl: prev, nextEl: next };
		}
		if (dots) {
			options.pagination = { el: dots, clickable: true };
		}

		if (swiperEl && config.mainLb) {
			swiperEl.addEventListener('click', (e) => {
				if (swiper && swiper.allowClick === false) return;
				e.preventDefault();
				e.stopPropagation();
				const index = swiper ? (typeof swiper.realIndex === 'number' ? swiper.realIndex : swiper.activeIndex) : 0;
				setTimeout(() => openLightbox(index), 0);
			});
		}

		if (total > 1 && swiperEl) {
			createSwiper(swiperEl, options).then((instance) => {
				swiper = instance;
			}).catch(() => {});
		}

		applyMore();
		window.addEventListener('resize', debounce(applyMore, 150));
		if (window.elementorFrontend && elementorFrontend.elements && elementorFrontend.elements.$window) {
			elementorFrontend.elements.$window.on('elementor/frontend/device-mode/change', applyMore);
		}
	}

	function initAll(scope) {
		(scope || document).querySelectorAll('.bbgs').forEach(init);
	}

	window.addEventListener('elementor/frontend/init', () => {
		elementorFrontend.hooks.addAction('frontend/element_ready/bb-gallery-slider.default', ($scope) => {
			initAll($scope[0]);
		});
	});

	window.addEventListener('load', () => initAll());
})();
