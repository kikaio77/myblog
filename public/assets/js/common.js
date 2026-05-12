

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

function showModal(bsModalEl, config = {}, callback = {}) {
	
	return new Promise((resolve, reject) => {
		if (! bsModalEl) {
			return reject('No Modal Element');
		}

		if (Object.keys(config).length === 0) {
			config = {
			'buttons': {
				'confirm': {
					'used': true,
					'text': '확인',
					'class': ['btn', 'btn-sm', 'btn-primary']
				},
				'cancel': {
					'used': true,
					'text': '닫기',
					'class': ['btn', 'btn-sm', 'btn-secondary']
				},
			},
			'html': `정말 그렇게 하시겠습니까?`
			};
		};
		const confirmConf = config.buttons.confirm ?? null;
		const cancelConf = config.buttons.cancel ?? null;

		if (confirmConf) {
			const confirmBtn = bsModalEl.querySelectorAll('.modal-footer > button')[0];
			confirmBtn.style.display = confirmConf.used  ? 'block' : 'none';
			if (confirmConf.class) {
				confirmBtn.classList.add(...confirmConf.class);
			}
			confirmBtn.onclick = e => {
				resolve({ action: 'confirm', event: e});
				bsModalObj.hide();
			};
		}

		if (cancelConf) {
			const cancelBtn = bsModalEl.querySelectorAll('.modal-footer > button')[1];
			cancelBtn.style.display = cancelConf.used  ? 'block' : 'none';
			if (cancelConf.class) {
				cancelBtn.classList.add(...cancelConf.class);
			}
			cancelBtn.onclick = e => {
				resolve({ action: 'cancel', event: e});
				bsModalObj.hide();
			};
		}
			
		if (config.html) {
			bsModalEl.querySelector('.modal-body > form').innerHTML = config.html;
		}
		const bsModalObj = new bootstrap.Modal(bsModalEl);

		bsModalObj.show();
	});
}

function closeModal(bsModal, callback) {
	bsModal.hide();
	
	return new Promise(function(resolve, reject){
		resolve(callback);
	});
}

