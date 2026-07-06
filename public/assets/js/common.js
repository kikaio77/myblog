

window.addEventListener('DOMContentLoaded', () => {

	const sidebarToggle = document.body.querySelector('#topNav .topNav_hamburger');

	if (sidebarToggle) {
		sidebarToggle.addEventListener('click', e => {
			e.preventDefault();
			document.body.classList.toggle('sidenav-toggled');
			localStorage.setItem('sidenav-toggle', document.body.classList.contains('sidenav-toggled'));
		});
	}
	if (localStorage.getItem('sidenav-toggle')) {

		document.body.classList.add('sidenav-toggled');
	} else {
		document.body.classList.remove('sidenav-toggled');
	}
	const sidebarMenuItems = document.querySelectorAll('.layoutSideNav_nav .sb-menu .sb-menu-link');

	for (let i = 0; i < sidebarMenuItems.length; i++) {
		const currentURL = window.location.href;
		const menuPath = sidebarMenuItems[i].getAttribute('href');
		sidebarMenuItems[i].classList.remove('active');

		if (currentURL.includes(menuPath)) {
			sidebarMenuItems[i].classList.add('active');
		}
	}

	window.addEventListener('resize', () => {
		if (window.innerWidth >= 992 && localStorage.getItem('sidenav-toggle')) {
			// document.body.classList.add('sidenav-toggled');
		} else {
			// document.body.classList.remove('sidenav-toggled');
		}
	});

	function getCsrfToken() {
		return document.querySelector('meta[name="X-CSRF-TOKEN"]')?.content || '';
	}

});

function serializeObject(form) {
const obj = {};
const formData = new FormData(form);

for (const [key, value] of formData.entries()) {
	// 같은 name이 여러 개일 경우 배열로 처리
	if (obj[key]) {
	if (Array.isArray(obj[key])) {
		obj[key].push(value);
	} else {
		obj[key] = [obj[key], value];
	}
	} else {
	obj[key] = value;
	}
}

return obj;
}

function showModal(modalId, config = {}) {
	const modalEl = document.getElementById(modalId);
	if (! modalEl) {
		return;
	}

	if (Object.keys(config).length === 0) {
		config = {
			'title': `안내`,
			'body': `<p>정말 그렇게 하시겠습니까?</p>`,
			'btns': {
				'confirm': { 'is_used': true, 'class': ['btn', 'btn-sm', 'btn-primary'], 'text': '확인', 'type': 'submit'},
				'cancel': {'is_used': true, 'class': ['btn', 'btn-sm', 'btn-secondary'], 'text': '닫기', 'type': 'button'}
			},
		};
	}

	if (config.title) {
		modalEl.querySelector('.modal-header h5').innerText = config.title;
	}

	if (config.body) {
		modalEl.querySelector('.modal-body').innerHTML = config.body;
	}

	const form = modalEl.querySelector('form');

	if (config.form) {
		form.action = config['form']['action'] || '';
		form.method = config['form']['method'] || 'POST';
	}

	const confirmBtn = modalEl.querySelector('.modal-footer .btn-primary');
	const cancelBtn = modalEl.querySelector('.modal-footer .btn-secondary');

	if (config.btns.confirm) {
		confirmBtn.style.display = config.btns.confirm.used ? 'block' : 'none';
		confirmBtn.innerText = config.btns.confirm.text || '';
		// confirmBtn.type = config.btns.confirm.type || 'button';
		confirmBtn.className = config.btns.confirm.class.join(' ');

	}
		
	if (config.btns.cancel) {
		cancelBtn.style.display = config.btns.cancel.used ? 'block' : 'none';
		cancelBtn.innerText = config.btns.cancel.text || '';
		cancelBtn.type = config.btns.cancel.type || 'button';
		cancelBtn.className = config.btns.cancel.class.join(' ');

	}
	const modal = bootstrap.Modal.getOrCreateInstance(modalEl);

	modal.show();

}

function closeModal(modalId) {
	const modalEl = document.getElementById(modalId);
	const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
	modal.hide();
}

