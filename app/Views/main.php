<?= $this->extend('layout/default') ?>

<?= $this->section('content') ?>
    <h4 class="content-title mb-5">전체글보기 <small>(<?= $postCnt ?>)</small></h4>
    
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
                <?php foreach ($posts as $post): ?>
                <tr>
                    <td><?= $post->no ?></td>
                    <td><a href="/posts/<?= $post->id ?>"><?= $post->title ?></a></td>
                    <td><?= $post->created_at ?></td>
                    <td><?= $post->views ?></td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </thead>
        </table>
        <div class="text-center d-flex justify-content-center">
            <?= $pager->links() ?>
        </div>
    </article>
<?= $this->endSection() ?>