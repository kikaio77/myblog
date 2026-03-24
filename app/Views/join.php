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
            <form class="joinFm card" action="/join/submit" id="joinFm" method="POST">
                <?= csrf_field() ?>
                <div class="card-header fs-5 fw-semibold">회원가입</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="">이메일</label>
                        <input type="text" name="email" id="email" class="form-control form-control-sm" required="required">
                        <div class="invalid-feedback">이메일을 입력해주세요</div>
                    </div>

                    <div class="mb-3">
                        <label for="password">비밀번호</label>
                        <input type="password" name="password" id="password" class="form-control form-control-sm" required="required">
                        <div class="invalid-feedback">비밀번호를 입력해주세요</div>
                    </div>

                     <div class="mb-3">
                        <label for="password_verify">비밀번호 확인</label>
                        <input type="password" name="password_verify" id="password_verify" class="form-control form-control-sm" required="required">
                        <div class="invalid-feedback">비밀번호 확인을 입력해주세요</div>
                    </div>

                        <div class="mb-3">
                        <label for="password_verify">닉네임</label>
                        <input type="text" name="nickname" id="nickname" class="form-control form-control-sm" required="required">
                        <div class="invalid-feedback">닉네임을 입력해주세요.</div>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" id="login" class="btn btn-primary" role="button">가입하기</button>
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

function validateForm() {

}
document.getElementById('joinFm').addEventListener('submit', (e) => {
    const _this = e.target;

    // if (_this.checkValidity()) {
    //     _this.classList.add('was-validated');
    //     e.preventDefault();
    // }
    _this.submit();
});
</script>
</body>
</html>