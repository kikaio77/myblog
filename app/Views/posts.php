<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
<h4 class="content-title mb-5"><?= $title ?> <small>(<?= $count ?>)</small></h4>
<article class="p-3 article">
 <table class="table table-border">
    <thead>
        <tr>
            <th class="text-center">번호</th>
            <th class="text-center">제목</th>
            <th class="text-center">작성일</th>
            <th class="text-center">조회수</th>
        </tr>
        <tbody>
        <?php if ($posts): ?>
             <?php foreach ($posts as $post): ?>
                <tr>
                    <td class="text-center"><?= $post->no ?></td>
                    <td class="text-center"><a href="/posts/<?= $post->id ?>"><?= $post->title ?></a></td>
                    <td class="text-center"><?= $post->created_at ?></td>
                    <td class="text-center"><?= $post->views ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td class="text-center" colspan="999">검색 결과가 존재하지 않습니다</td>
            </tr>
        <?php endif; ?>

        </tbody>
    </thead>
</table>
</article>

<?= $this->endSection() ?>