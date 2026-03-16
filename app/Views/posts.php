<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<h4 class="content-title mb-5"><?= $title ?> <small>(<?= $count ?>)</small></h4>
<article class="p-3 article">
 <table class="table table-border table-sm">
    <thead>
        <tr>
            <th>번호</th>
            <th>제목</th>
            <th>작성일</th>
            <th>조회수</th>
        </tr>
        <tbody>
        <?php foreach ($posts as $idx => $post): ?>
        <tr>
            <td><?= $idx + 1 ?></td>
            <td><a href="/posts/<?= $post->id ?>"><?= $post->title ?></a></td>
            <td><?= $post->created_at ?></td>
            <td><?= $post->views ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </thead>
</table>
</article>

<?= $this->endSection() ?>