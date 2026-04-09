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
        <form action="comment/new" method="POST" id="newCommentForm" class="newCommentForm card mb-2">
            <div class="card-body">
                <div class="input-group">
                    <?= csrf_field() ?>
                    <input type="hidden" name="post_id" id="post_id" value="<?= $post->id ?>">
                    <input type="text" name="text" id="" placeholder="해당 게시글에 대한 느낌을 이야기하세요..." class="form-control"/>
                    <button class="btn btn-primary">등록</button>
                </div>
            </div>
        </form>
    <?php else: ?>
        <span>덧글을 작성하시려면 로그인을 해주세요</span>
    <?php endif; ?>

    <?php foreach ($comments as $comment): ?>
    <div class="card mb-1">
        <div class="card-body">
            <div class="row">
                <div class="col-8">
                    <strong class="me-2"><?= $comment->nick ?></strong>
                    <span class="text-secondary"><?= $comment->created_at ?></span>
                </div>
                <div class="col-4 d-flex justify-content-end">
                    <button class="btn btn-sm btn-secondary me-1">답글</button>
                    <?php if (session()->get('user')->id === $comment->uid): ?>
                    <button class="btn btn-sm btn-danger">삭제</button>
                    <?php endif; ?>
                </div>
            </div>
            <div class="py-2">
                <?= $comment->text ?>
            </div>
        </div>
    </div>
        
    <?php endforeach; ?>
   
</div>

<script>
document.getElementById('newCommentForm').addEventListener('submit', (e) => {
    e.preventDefault();
    const _this = e.target;

    const option = {
        'method': 'POST',
        'headers': {
            'Content-Type': 'Application/json',
            'x-requested-with': 'XMLHttpRequest'
        },
        'body': JSON.stringify(serializeObject(_this))
    };

    fetch('/comment/new', option)
    .then( (res) => res.json())
    .then(d => {
        console.log(d);
    })
});
</script>
<?= $this->endSection() ?>