(function () {
	const touch = window.matchMedia('(hover: none)');

	function init(root) {
		if (!root || root.dataset.rhsReady) return;
		root.dataset.rhsReady = '1';

		const items = root.querySelectorAll('.rhs-item');
		const images = root.querySelectorAll('.rhs-img');

		const activate = (index) => {
			items.forEach((el) => el.classList.toggle('is-active', +el.dataset.index === index));
			images.forEach((el) => el.classList.toggle('is-active', +el.dataset.index === index));
			root.dataset.active = index;
		};

		const list = root.querySelector('.rhs-list');

		if (root.dataset.reset === '1' && list) {
			list.addEventListener('mouseleave', () => {
				if (!touch.matches) activate(-1);
			});
			list.addEventListener('focusout', (e) => {
				if (!list.contains(e.relatedTarget)) activate(-1);
			});
		}

		items.forEach((item) => {
			const index = +item.dataset.index;

			item.addEventListener('mouseenter', () => {
				if (!touch.matches) activate(index);
			});

			item.addEventListener('focus', () => activate(index));

			item.addEventListener('click', (e) => {
				if (touch.matches && !item.classList.contains('is-active')) {
					e.preventDefault();
					activate(index);
				}
			});

			item.addEventListener('keydown', (e) => {
				if (item.tagName !== 'A' && (e.key === 'Enter' || e.key === ' ')) {
					e.preventDefault();
					activate(index);
				}
			});
		});
	}

	function initAll(scope) {
		(scope || document).querySelectorAll('.rhs').forEach(init);
	}

	window.addEventListener('elementor/frontend/init', () => {
		elementorFrontend.hooks.addAction('frontend/element_ready/hover-reveal-list.default', ($scope) => {
			initAll($scope[0]);
		});
	});

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', () => initAll());
	} else {
		initAll();
	}
})();
