window.addEventListener('DOMContentLoaded', () => {
    const sidebarToggle = document.body.querySelector('#topNav .topNav_hamburger');

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', e => {
            e.preventDefault();
            document.body.classList.toggle('sidenav-toggled');
            localStorage.setItem('sidenav-toggle', document.body.classList.contains('sidenav-toggled'));
        });
    }
    console.log(localStorage.getItem('sidenav-toggle'));
    if (localStorage.getItem('sidenav-toggle')) {
        console.log('이거타지?');
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
