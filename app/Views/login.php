<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" as="style" crossorigin href="https://cdn.jsdelivr.net/gh/orioncactus/pretendard@v1.3.9/dist/web/variable/pretendardvariable.min.css" />
	<link rel="stylesheet" href="/assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/xpressengine/XEIcon@2.3.3/xeicon.min.css">
	<link rel="stylesheet" href="/assets/css/style.css">
	<script src="/assets/js/common.js"></script>
	<script src="/assets/js/bootstrap.bundle.min.js"></script>
	<title>로그인</title>
</head>
<body>
    <div id="wrapLoginFm" class="d-flex align-items-center justify-content-center" style="background-color: #599080;">
        <div class="col-9 col-sm-6 col-md-3">
            <form class="loginFm card" action="/login/in" id="loginFm" method="POST">
                <?= csrf_field() ?>
                <div class="card-header fs-5 fw-semibold"><?= $_ENV['app.name'] ?>&nbsp;&nbsp;로그인</div>
                <div class="card-body">
                    <div class="form-floating mb-3">
                        <input type="text" name="email" id="email" class="form-control form-control-sm" placeholder="Enter your email!!"required="required">
                        <label for="">이메일</label>
                        <div class="invalid-feedback">이메일을 입력해주세요</div>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" name="password" id="password" class="form-control form-control-sm" placeholder="Enter your password!!"required="required">
                        <label for="password">비밀번호</label>
                        <div class="invalid-feedback">비밀번호를 입력해주세요</div>
                    </div>

                    <div class="d-grid mb-3">
                        <button class="btn btn-primary">로그인</button>
                    </div>
                    <div class="mb-3">
                        <input type="checkbox" name="agree_store_id" id="agree_store_id" class="form-check-input">
                        <label for="agree_store_id" class="form-check-label me-1">아이디 저장</label>
                    </div> 
                    <hr>
                    <div class="d-grid">
                        <button class="button btn btn-success">네이버 로그인</button>
                    </div>
                </div> 
            </form>
        </div>
    </div>
<?php if (session()->has('error')): ?>
<script>
alert(`<?= session()->get('error') ?>`);
</script>
<?php endif; ?>
<script>
document.getElementById('loginFm').addEventListener('submit', (e) => {
    // e.preventDefault();
    const _this = e.target;

    if (_this.checkValidity()) {
         _this.classList.add('was-validated');
        e.preventDefault();
    }

    _this.submit();
    
});
</script>
</body>
</html>