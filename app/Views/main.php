<?= $this->extend('layout/default') ?>
<?= $this->section('content') ?>
<style>

@media screen and (min-width: 763px) {
	
.table tbody tr td:nth-child(2) > a {
    display: inline-block;
    text-overflow: ellipsis;
    max-width: 200px;
    overflow: hidden;
    white-space: nowrap;	
}

	
}

@media screen and (min-width: 992px) {
	
.table tbody tr td:nth-child(2) > a {
   
    max-width: 60%;
   	
}

	
}

</style>
    <h4 class="content-title mb-5">전체글보기 <small>(<?= $postCnt ?>)</small></h4>
    
    <article class="p-3 article">
        <div class="table-responsive">
            <table class="table text-nowrap">
                <thead>
                    <tr>
                        <th class="text-center">번호</th>
                        <th class="text-center">제목</th>
                        <th class="text-center">작성일</th>
                        <th class="text-center">조회수</th>
                    </tr>
                    <tbody>
                    <?php foreach ($posts as $post): ?>
                    <tr>
                        <td class="text-center"><?= $post->no ?></td>
                        <td class="text-center"><a href="/posts/<?= $post->id ?>"><?= $post->title ?></a></td>
                        <td class="text-center"><?= $post->created_at ?></td>
                        <td class="text-center"><?= $post->views ?></td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </thead>
             </table>
        </div>

    </article>
    <div class="text-center mt-3 d-flex justify-content-center">
        <?= $pager->links() ?>
    </div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    document.addEventListener('DOMContentLoaded', e => {
       
    });
</script>

<?= $this->endSection() ?>