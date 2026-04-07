<!DOCTYPE html>
<html lang="kr" data-bs-theme="dark">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" as="style" crossorigin href="https://cdn.jsdelivr.net/gh/orioncactus/pretendard@v1.3.9/dist/web/variable/pretendardvariable.min.css" />
	<link rel="stylesheet" href="/assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/xpressengine/XEIcon@2.3.3/xeicon.min.css">
	<link rel="stylesheet" href="/assets/css/style.css">
	<script src="/assets/js/common.js"></script>
	<script src="/assets/js/bootstrap.bundle.min.js"></script>
	<title> <?= $_ENV['app.title'] ?></title>
	<?= $this->renderSection('head') ?>
</head>
<body>
	<?= $this->include('layout/header') ?>
	<div class="layoutWrap">
		<div class="layoutSideNav p-3 shadow-sm">
			<?= $this->include('layout/sideNav') ?>
		</div>
		<div class="layoutContent">
			<main>
				<div class="container-fluid p-3 p-md-4 p-lg-5">
				<?= $this->renderSection('content') ?>
				</div>
			</main>
			<?= $this->include('layout/footer') ?>
		</div>
	</div>
<?= $this->renderSection('js') ?>
</body>
</html>