<?= $this->extend('layout/default') ?>


<?= $this->section('content') ?>
<h4 class="content-title"><?= $post->title ?></h4>

<div class="row align-items-center justify-content-between mb-1">
    <div class="col-2">
      <a href="/posts/<?= $post->id ?>/form" class="btn btn-warning me-auto" role="button">수정</a>
    </div>
    <div class="col-9 text-end">
        <span class="text-secondary"><?= $post->created_at ?></span>
    </div>
</div>

<article class="p-3 article">
    <?= $post->content ?>
</article>
<?= $this->endSection() ?>