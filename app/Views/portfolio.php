<?= $this->extend('layout/default') ?>


<?= $this->section('content') ?>
<h4 class="content-title">Portfolio</h4>
<article class="p-4">
<div class="row gy-4">
    <a href="https://www.arirangsms.com" target="_blank" class="col-12 col-sm-6 col-md-4">
        <div class="card bg-nowwe text-white">
            <div class="card-header">아리랑문자</div>
            <div class="card-body">
                <p class="badge text-bg-secondary">단독신규개발</p>
            <div class="gap-1 d-flex">
                <span class="btn btn-sm btn-primary">PHP Legacy</span>
            </div>
            </div>
        </div>
    </a>
    <div class="col-12 col-sm-6 col-md-4">
        <div class="card bg-nowwe text-white">
            <div class="card-header">발송OK</div>
            <div class="card-body">
                <p class="badge text-bg-secondary">Web & BackOffice 유지보수</p>
                 <div class="gap-1 d-flex">
                    <span class="btn btn-sm btn-primary">PHP Legacy</span>
                </div>
            </div>   
        </div>
    </div>
    <div class="d-none d-md-flex col-12 col-sm-4"></div>    
    <a href="https://balsongking.com/" target="_blank" class="col-12 col-sm-6 col-md-4">
        <div class="card bg-nowwe text-white">
            <div class="card-header">발송킹</div>
            <div class="card-body">
                <p class="badge text-bg-secondary">Web & BackOffice 유지보수</p>
                <div class="gap-1 d-flex">
                    <span class="btn btn-sm btn-primary">PHP Legacy</span>
                </div>
            </div>
        </div>
    </a>
    <a href="https://balsong.com/" target="_blank" class="col-12 col-sm-6 col-md-4">
        <div class="card bg-nowwe text-white">
            <div class="card-header">발송닷컴</div>
           <div class="card-body">
                <p class="badge text-bg-secondary">Web & BackOffice 유지보수</p>
                 <div class="gap-1 d-flex">
                    <span class="btn btn-sm btn-primary">PHP Legacy</span>
                </div>
            </div>
        </div>
    </a>
     <div class="d-none d-md-flex col-12 col-sm-4">
    </div>

    <a href="https://hiddenslot-cms.net/" target="_blank" class="col-12 col-sm-6 col-md-4">
        <div class="card bg-nowwe text-white">
            <div class="card-header">히든슬롯 CMS</div>
            <div class="card-body">
                <p class="badge text-bg-secondary">단독신규개발</p>
                 <div class="gap-1 d-flex">
                    <span class="btn btn-sm btn-primary">Laravel</span>
                    <span class="btn btn-sm btn-primary">Redis</span>
                </div>
            </div>
        </div>
    </a>
    <a href="https://hidden8-cms.net/" target="_blank" class="col-12 col-sm-6 col-md-4">
        <div class="card bg-nowwe text-white">
            <div class="card-header">히든8 CMS</div>
            <div class="card-body">
                <p class="badge text-bg-secondary">단독신규개발</p>
                <div class="gap-1 d-flex">
                    <span class="btn btn-sm btn-primary">Laravel</span>
                    <span class="btn btn-sm btn-primary">Redis</span>
                </div>
            </div>
        </div>
    </a>
    <div class="d-none d-md-flex col-12 col-sm-4">
    </div>
    <a href="https://oasisfund.kr/" target="_blank" class="col-12 col-sm-6 col-md-4">
        <div class="card bg-nowwe text-white">
            <div class="card-header">오아시스펀드</div>
            <div class="card-body">
                <p class="badge text-bg-secondary">Web & BackOffice 유지보수</p>
                <div class="gap-1 d-flex">
                    <span class="btn btn-sm btn-primary">Laravel</span>
                </div>
            </div>
        </div>
    </a>
     <a href="https://www.oceanfunding.co.kr/" target="_blank" class="col-12 col-sm-6 col-md-4">
        <div class="card bg-nowwe text-white">
            <div class="card-header">오션펀딩</div>
            <div class="card-body">
                <p class="badge text-bg-secondary">Web & BackOffice 유지보수</p>
                <div class="gap-1 d-flex">
                    <span class="btn btn-sm btn-primary">Laravel</span>
                </div>
            </div>
        </div>
    </a>
    <div class="d-none d-md-flex col-12 col-sm-4">
</div>
<blockquote class="text-center text-danger">이외에도 많지만 서비스가 종료되었거나, 내부 ip로만 접근이 가능한 서비스도 많음</blockquote>

</article>
<?= $this->endSection() ?>