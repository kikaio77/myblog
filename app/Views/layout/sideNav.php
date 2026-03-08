<div class="layoutSideNav_nav">

<ul class="profile list-unstyled mb-4">
	<li class="profileImg mb-2 d-flex justify-content-center align-items-center">
		<img class="img-fluid rounded shadow-sm" src="/assets/images/profile.png" alt="profile_img">
	</li>
	<li class="profileIntro">
		<div class="text-center">
			<?= $_ENV['app.shortIntroduce'] ?>
		</div>
	</li>
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
			<a href="/posts/category/1" class="nav-link sb-menu-link">PHP <span class="ms-1 badge text-bg-warning">15</span></a>
			<a href="#" class="nav-link sb-menu-link">CodeIgniter4<span class="ms-1 badge text-bg-warning">15</span></a>
		</li>
	</ul>
</div>

</div>