<div class="layoutSideNav_nav">

<ul class="profile list-unstyled mb-4">
	<li class="profileImg mb-2 d-flex justify-content-center align-items-center">
		<img class="img-fluid rounded shadow-sm" src="/assets/images/profile.png" alt="profile_img">
	</li>
	<li class="visitor-views row d-grid gap-1 mb-3 px-2">
		<div class="d-flex">
			<span>Today: </span><span class="ms-auto"><?= number_format($todayVisitors) ?></span>
		</div>
		<div class="d-flex">
			<span>Month: </span><span class="ms-auto"><?= number_format(123123) ?></span>
		</div>
	</li>
	<li class="profileIntro">
		<div class="text-center">
			<?= $_ENV['app.shortIntroduce'] ?>
		</div>
	</li>
	<li><a href="/posts/form" class="fs-6"><i class="me-2 xi-pen"></i>글쓰기</a></li>
</ul>
<div class="sb-menu">
	<ul class="nav nav-pills sb-menu-item">
		<h5 class="sb-menu-heading"><i class="xi-user me-2"></i>내 소개</h5>
		<li class="nav-item sb-menu-item-child">
			<a href="/profile" class="nav-link sb-menu-link">Profile</a>
			<a href="/portfolio" class="nav-link sb-menu-link">Portfolio</a>
		</li>
	</ul>
	<ul class="nav nav-pills sb-menu-item">
		<h5 class="sb-menu-heading"><i class="xi-view-list me-2"></i>카테고리</h5>
		<li class="nav-item sb-menu-item-child">
			<a href="/main" class="nav-link sb-menu-link active">전체보기</a>
			<?= view_cell('App\Cells\CategoryCell::subNavCategory', [], 18000, 'newSubNav') ?>
		</li>
	</ul>
</div>

</div>