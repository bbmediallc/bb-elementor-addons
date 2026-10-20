(function () {
	const ORDER = ['mobile', 'mobile_extra', 'tablet', 'tablet_extra', 'laptop'];

	function debounce(fn, delay) {
		let t;
		return function () {
			clearTimeout(t);
			t = setTimeout(fn, delay);
		};
	}

	function imagesReady(root) {
		const imgs = Array.from(root.querySelectorAll('img'));
		return Promise.all(imgs.map((img) => (img.complete ? null : new Promise((r) => { img.addEventListener('load', r, { once: true }); img.addEventListener('error', r, { once: true }); }))));
	}

	function initMarquee(root, config) {
		const viewport = root.querySelector('.bblc-viewport');
		const track = root.querySelector('.bblc-track');
		const original = track && track.querySelector('.bblc-group');
		if (!viewport || !track || !original) return;

		original.querySelectorAll('img').forEach((img) => { img.loading = 'eager'; });

		const clone = () => {
			const c = original.cloneNode(true);
			c.setAttribute('aria-hidden', 'true');
			c.querySelectorAll('a').forEach((a) => a.setAttribute('tabindex', '-1'));
			return c;
		};

		const build = () => {
			track.querySelectorAll('.bblc-group[aria-hidden="true"]').forEach((g) => g.remove());
			const groupWidth = original.getBoundingClientRect().width;
			if (!groupWidth) return;
			const needed = Math.max(2, Math.ceil((viewport.clientWidth * 2) / groupWidth));
			const total = needed % 2 ? needed + 1 : needed;
			for (let i = 1; i < total; i++) track.appendChild(clone());
			const loopWidth = track.scrollWidth / 2;
			track.style.animationDuration = (loopWidth / (config.pxPerSec || 40)) + 's';
			track.style.animationDirection = config.direction === 'right' ? 'reverse' : 'normal';
			root.classList.add('bblc--ready');
		};

		imagesReady(original).then(build);

		let lastWidth = viewport.clientWidth;
		window.addEventListener('resize', debounce(() => {
			if (viewport.clientWidth === lastWidth) return;
			lastWidth = viewport.clientWidth;
			build();
		}, 200));
	}

	function breakpointsConfig(perView) {
		const active = (window.elementorFrontend && elementorFrontend.config && elementorFrontend.config.responsive && elementorFrontend.config.responsive.activeBreakpoints) || {};
		const maxDevices = ORDER.filter((d) => active[d]).map((d) => ({ name: d, value: active[d].value }));
		maxDevices.sort((a, b) => a.value - b.value);

		const resolved = {};
		resolved.desktop = perView.desktop || null;
		let carry = resolved.desktop;
		for (let i = maxDevices.length - 1; i >= 0; i--) {
			const d = maxDevices[i].name;
			carry = perView[d] || carry;
			resolved[d] = carry;
		}

		const toSwiper = (v) => (v ? v : 'auto');
		const base = maxDevices.length ? resolved[maxDevices[0].name] : resolved.desktop;
		const breakpoints = {};
		maxDevices.forEach((d, i) => {
			const next = maxDevices[i + 1] ? resolved[maxDevices[i + 1].name] : resolved.desktop;
			breakpoints[d.value + 1] = { slidesPerView: toSwiper(next) };
		});
		if (active.widescreen) {
			breakpoints[active.widescreen.value] = { slidesPerView: toSwiper(perView.widescreen || resolved.desktop) };
		}

		const allEmpty = Object.keys(perView).every((k) => !perView[k]);
		return { base: toSwiper(base), breakpoints, auto: allEmpty, max: Math.max(1, ...Object.values(resolved).filter(Boolean)) };
	}

	function initSlider(root, config) {
		const el = root.querySelector('.bblc-swiper');
		if (!el) return;
		const count = el.querySelectorAll('.bblc-slide').length;
		const bp = breakpointsConfig(config.perView || {});
		if (bp.auto) root.classList.add('bblc--auto');

		const options = {
			slidesPerView: bp.base,
			breakpoints: bp.breakpoints,
			spaceBetween: 0,
			speed: config.speed || 600,
			loop: !!config.loop && count > bp.max,
			grabCursor: true,
			a11y: { enabled: true },
			watchOverflow: true
		};
		if (config.delay > 0) {
			options.autoplay = { delay: config.delay, disableOnInteraction: false, pauseOnMouseEnter: !!config.pause };
		}
		const prev = root.querySelector('.bblc-prev');
		const next = root.querySelector('.bblc-next');
		if (prev && next) {
			options.navigation = { prevEl: prev, nextEl: next };
			[prev, next].forEach((btn) => btn.addEventListener('keydown', (e) => {
				if (e.key === 'Enter' || e.key === ' ') {
					e.preventDefault();
					btn.click();
				}
			}));
		}
		const dots = root.querySelector('.bblc-dots');
		if (dots) {
			options.pagination = { el: dots, clickable: true };
		}

		let ctor = null;
		if (window.elementorFrontend && elementorFrontend.utils && elementorFrontend.utils.swiper) {
			ctor = elementorFrontend.utils.swiper;
		} else if (window.Swiper) {
			ctor = window.Swiper;
		}
		if (!ctor) return;
		Promise.resolve(new ctor(el, options)).then(() => root.classList.add('bblc--ready')).catch(() => {});
	}

	function init(root) {
		if (!root || root.dataset.bblcReady) return;
		root.dataset.bblcReady = '1';
		let config = {};
		try {
			config = JSON.parse(root.dataset.config || '{}');
		} catch (e) {}
		if (config.mode === 'slider') {
			initSlider(root, config);
		} else {
			initMarquee(root, config);
		}
	}

	function initAll(scope) {
		(scope || document).querySelectorAll('.bblc').forEach(init);
	}

	window.addEventListener('elementor/frontend/init', () => {
		elementorFrontend.hooks.addAction('frontend/element_ready/bb-logo-carousel.default', ($scope) => {
			initAll($scope[0]);
		});
		elementorFrontend.hooks.addAction('frontend/element_ready/bb-photo-carousel.default', ($scope) => {
			initAll($scope[0]);
		});
	});

	window.addEventListener('load', () => initAll());
})();
