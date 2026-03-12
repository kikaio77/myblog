<?= $this->extend('layout/default') ?>


<?= $this->section('content') ?>
<h4 class="content-title">Profile</h4>
<article class="p-3 article">
<h6 class="display-6">임승혁(IM SEUNG HYUK)</h6>
<img class="img-fluid border mb-3" src="assets/images/profile.png" alt="profile_photo">
<ul class="mb-5">
    <li>출생: 1994.10.30 (33세)</li>
    <li>거주지: 서울시 은평구</li>
    <li><u title="풀 스택 PHP 개발자">풀 스택 PHP 개발자</u>이자 <u>누군가의 새 신랑</u></li>
    <li>장점: 포기하지않는 근성!</li>
    <li>단점: 다소 고지식한 면이 있다.</li>
</ul>

<h6 class="pointer-lg fs-5 mb-3">관련 링크</h6>
<div class="mb-5 d-flex gap-1 flex-wrap">
    <a href="https://github.com/?locale=ko-KR" target="_blank" title="깃허브 링크" class="btn btn-primary btn-sm">Github</a>
    <a href="https://blog.naver.com/kikaio77" target="_blank"  title="아이티마스터 네이버블로그"class="btn btn-primary btn-sm">NaverBlog</a>
</div>

<h6 class="pointer-lg fs-5 mb-3">기술스택</h6>
<p><span class="pointer primary me-3">: 아주잘함</span><span class="pointer secondary">: 잘함</span></p>
<div class="mb-5 d-flex gap-1 flex-wrap">
    <span class="btn btn-primary btn-sm">HTML</span>
    <span class="btn btn-primary btn-sm">CSS</span>
    <span class="btn btn-primary btn-sm">JavaScript</span>
    <span class="btn btn-primary btn-sm">Jquery</span>
    <span class="btn btn-primary btn-sm">PHP</span>
    <span class="btn btn-primary btn-sm">Java</span>
    <span class="btn btn-primary btn-sm">Spring</span>
    <span class="btn btn-primary btn-sm">MYSQL</span>
    <span class="btn btn-secondary btn-sm">MSSQL</span>
    <span class="btn btn-secondary btn-sm">Github</span>
    <span class="btn btn-primary btn-sm">CodeIgniter4</span>
    <span class="btn btn-primary btn-sm">Laravel</span>
    <span class="btn btn-primary btn-sm">Bootstrap5</span>
    <span class="btn btn-secondary btn-sm">NodeJS</span>
    <span class="btn btn-secondary btn-sm">Redis</span>
    <span class="btn btn-secondary btn-sm">Ubuntu</span>
    <span class="btn btn-secondary btn-sm">CentOS</span>
    <span class="btn btn-secondary btn-sm">Docker</span>
    <span class="btn btn-secondary btn-sm">NGINX</span>
</div>

<h6 class="pointer-lg fs-5 mb-3">경력사항</h6>
<dl class="row mb-5">
    <dt class="col-5 col-md-2 text-primary">2025</dt>
    <dd class="col-7 col-md-9 text-success">(주)씨앤에이커뮤니케이션즈</dd>
    <dt class="col-5 col-md-2 text-primary"></dt>
    <dd class="col-7 col-md-9 text-danger">(축)결혼</dd>
    <dt class="col-5 col-md-2 text-primary">2024</dt>
    <dd class="col-7 col-md-9 text-success">넥스넷</dd>
    <dt class="col-5 col-md-2 text-primary">2022 - 2023</dt>
    <dd class="col-7 col-md-9 text-success">웨인테크놀로지</dd>
    <dt class="col-5 col-md-2 text-primary">2022</dt>
    <dd class="col-7 col-md-9 text-success">구디아카데미 SPRING 과정 수료</dd>
    <dt class="col-5 col-md-2 text-primary">2019 - 2022</dt>
    <dd class="col-7 col-md-9 text-success">(주)라인업시스템</dd>
    <dt class="col-5 col-md-2 text-primary">2013</dt>
    <dd class="col-7 col-md-9 text-success">경복대학교 임베디드과</dd>
</dl>


<h6 class="pointer-lg fs-5 mb-3">블로그 소개</h6>
<blockquote class="fs-6">
    주니어 개발자의 눈물겨운 웹 개발 생존기
</blockquote>
</article>
<?= $this->endSection() ?>