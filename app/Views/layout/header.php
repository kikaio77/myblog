<nav id="topNav" class="navbar navbar-expand-lg shadow-sm bg-gradient">
	<div class="container-fluid">
		<a href="/main" class="navbar-brand d-flex align-items-center me-0"><h6 class="m-0"><?= $_ENV['app.name'] ?></h6></a>
		<a class="topNav_hamburger order-2 order-lg-1" role="button"><i class="xi-bars"></i></a>
		<div class="d-flex dropstart ms-auto me-2 order-1 order-lg-2">
			<a data-bs-toggle="dropdown" aria-expanded="false" role="button"><i class="xi-apps"></i></a>
			<ul class="dropdown-menu">
				<?php if (session()->has('user')): ?>
				<li><a class="dropdown-item d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modal" data-mypage="true"><i class="xi-user me-2 text-muted"></i><?= session()->has('user') && session()->get('user') ? session()->get('user')->nick : ''  ?>&nbsp;님</a></li>
				<li><a href="/login/out" class="dropdown-item d-inline-flex align-items-center"><i class="xi-log-in me-2 text-muted"></i>로그아웃</a></li>
				<?php else: ?>
				<li><a href="/login/form" class="dropdown-item d-inline-flex align-items-center"><i class="xi-log-in me-2 text-muted"></i>로그인</a></li>
				<li><a href="/join" class="dropdown-item d-inline-flex align-items-center"><i class="xi-user-plus me-2 text-muted"></i>회원가입</a></li>
				<?php endif; ?>
				<?php if (session()->has('user')): ?>

				<?php endif; ?>
			</ul>
		</div>
	</div>
</nav>