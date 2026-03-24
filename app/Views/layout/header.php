<nav id="topNav" class="navbar navbar-expand-lg shadow-sm bg-gradient">
	<div class="container-fluid d-flex justify-content-start align-items-center">
		<a href="/main" class="navbar-brand d-flex align-items-center me-0"><i class="xi-php me-2"></i><h6 class="m-0"><?= $_ENV['app.name'] ?></h6></a>
		<a class="topNav_hamburger ms-auto ms-md-0" role="button"><i class="xi-bars"></i></a>
		<div class="d-none d-md-block ms-md-auto dropstart">
			<a data-bs-toggle="dropdown" aria-expanded="false" role="button"><i class="xi-ellipsis-h"></i></a>
			<ul class="dropdown-menu">
				<?php if (session()->has('user')): ?>
				<li><a class="dropdown-item d-inline-flex align-items-center"><i class="xi-user me-2 text-muted"></i><?= session()->get('user')->nickname ?>님</a></li>
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