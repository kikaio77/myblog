<?= $this->extend('layout/default') ?>


<?= $this->section('content') ?>
<h4 class="content-title"><?= $post->title ?></h4>
<h6 class="text-end text-secondary"><?= $post->created_at ?></h6>

<article class="p-3">
    <?= $post->content ?>
</article>
<?= $this->endSection() ?>