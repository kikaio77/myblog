<?= $this->extend('layout/default') ?>


<?= $this->section('content') ?>
<h4 class="content-title"><?= $post->title ?></h4>

<div class="row align-items-center justify-content-between mb-1">
    <div class="col-2">
      <?php if (session()->has('user') && session()->get('user')->is_admin === 1 ): ?>
      <a href="/posts/<?= $post->id ?>/form" class="btn btn-warning me-auto" role="button">수정</a>
      <?php endif; ?>
    </div>
    <div class="col-9 text-end">
        <span class="text-secondary"><?= $post->created_at ?></span>
    </div>
</div>

<article class="p-3 article">
    <?= $post->content ?>
</article>

<div class="commentArea mt-3">
    <hr>
    <?php if (session()->has('user')): ?>
        <form action="" class="newCommentForm card">
            <div class="card-body">
                <div class="input-group">
                    <input type="text" name="comment_text" id="" placeholder="해당 게시글에 대한 느낌을 이야기하세요..." class="form-control"/>
                    <button class="btn btn-primary">등록</button>
                </div>
            </div>
        </form>
    <?php else: ?>
        <span>덧글을 작성하시려면 로그인을 해주세요</span>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>