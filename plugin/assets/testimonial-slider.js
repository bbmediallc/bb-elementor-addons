(function () {
	function init(root) {
		if (!root || root.dataset.bbtsReady) return;
		root.dataset.bbtsReady = '1';

		if (root.dataset.longLh !== '1') {
			const scaleLineHeight = () => {
				root.querySelectorAll('.bbts-quote--long').forEach((quote) => {
					const text = quote.querySelector('.bbts-quote-text');
					if (!text) return;
					text.style.lineHeight = '';
					const c = getComputedStyle(quote);
					const fs = parseFloat(c.fontSize);
					const lh = parseFloat(c.lineHeight);
					if (fs && lh) text.style.lineHeight = (lh / fs).toFixed(3);
				});
			};
			scaleLineHeight();
			let resizeTimer;
			window.addEventListener('resize', () => {
				clearTimeout(resizeTimer);
				resizeTimer = setTimeout(scaleLineHeight, 150);
			});
		}

		const slides = Array.from(root.querySelectorAll('.bbts-slide'));
		if (slides.length < 2) return;

		const prev = root.querySelector('.bbts-prev');
		const next = root.querySelector('.bbts-next');
		const current = root.querySelector('.bbts-current');
		const stage = root.querySelector('.bbts-stage');
		const loop = root.dataset.loop === '1';
		const speed = parseInt(root.dataset.speed, 10) || 500;
		const delay = parseInt(root.dataset.delay, 10) || 6000;
		const autoplay = root.dataset.autoplay === '1';
		const pauseOnHover = root.dataset.pause === '1';
		const reduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

		let index = 0;
		let timer = null;
		let busy = false;

		root.querySelectorAll('.bbts-content').forEach((el) => {
			el.style.transitionDuration = `${speed}ms`;
		});

		const updateArrows = () => {
			if (current) current.textContent = index + 1;
			if (loop) return;
			if (prev) prev.disabled = index === 0;
			if (next) next.disabled = index === slides.length - 1;
		};

		const goTo = (target) => {
			if (busy) return;
			if (loop) target = (target + slides.length) % slides.length;
			if (target < 0 || target >= slides.length || target === index) return;

			busy = true;
			const from = slides[index];
			const to = slides[target];

			to.classList.add('is-covering');
			to.offsetWidth;

			from.classList.add('is-leaving');
			from.classList.remove('is-active');
			from.setAttribute('aria-hidden', 'true');

			to.classList.add('is-active');
			to.removeAttribute('aria-hidden');

			requestAnimationFrame(() => {
				requestAnimationFrame(() => to.classList.remove('is-covering'));
			});

			index = target;
			updateArrows();

			setTimeout(() => {
				from.classList.remove('is-leaving');
				busy = false;
			}, reduced ? 0 : speed);
		};

		const stop = () => {
			clearInterval(timer);
			timer = null;
		};

		const start = () => {
			if (!autoplay || reduced) return;
			stop();
			timer = setInterval(() => {
				goTo(!loop && index === slides.length - 1 ? 0 : index + 1);
			}, delay);
		};

		if (prev) prev.addEventListener('click', () => { goTo(index - 1); start(); });
		if (next) next.addEventListener('click', () => { goTo(index + 1); start(); });

		root.addEventListener('keydown', (e) => {
			if (e.key === 'ArrowLeft') { goTo(index - 1); start(); }
			if (e.key === 'ArrowRight') { goTo(index + 1); start(); }
		});

		let startX = null;
		stage.addEventListener('pointerdown', (e) => { startX = e.clientX; });
		stage.addEventListener('pointerup', (e) => {
			if (startX === null) return;
			const dx = e.clientX - startX;
			startX = null;
			if (Math.abs(dx) < 40) return;
			goTo(dx < 0 ? index + 1 : index - 1);
			start();
		});
		stage.addEventListener('pointercancel', () => { startX = null; });

		if (pauseOnHover) {
			root.addEventListener('mouseenter', stop);
			root.addEventListener('mouseleave', start);
		}
		root.addEventListener('focusin', stop);
		root.addEventListener('focusout', (e) => {
			if (!root.contains(e.relatedTarget)) start();
		});

		updateArrows();
		start();
	}

	function initAll(scope) {
		(scope || document).querySelectorAll('.bbts').forEach(init);
	}

	window.addEventListener('elementor/frontend/init', () => {
		elementorFrontend.hooks.addAction('frontend/element_ready/bb-testimonial-slider.default', ($scope) => {
			initAll($scope[0]);
		});
	});

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', () => initAll());
	} else {
		initAll();
	}
})();
