<?= $this->extend('layout/default') ?>

<?= $this->section('head') ?>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h4 class="content-title">글 등록/수정</h4>
<article>
   <form name="postForm" id="postForm" method="POST" action="<?= $form['action'] ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="<?= $form['method'] ?>">
        <input type="hidden" name="id" value="<?= isset($post) ? $post->id : '' ?>" id="id">
        <input type="hidden" name="content" id="content" value="<?= isset($post) ? $post->content : '' ?>">
        <div class="ms-auto col-6 mb-1 col-sm-3">
            <select name="category" id="category" class="form-select-sm form-select">
                <option value="">카테고리 선택</option>
                <?php foreach ($categories as $category): ?>
                <option value="<?= $category->id ?>" <?= (isset($post) && $post->category_id == $category->id) ? 'selected' : '' ?> > <?= $category->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
       
        <div id="editor" class="border-nowwe bg-white" style="min-height: 430px;">
            <?= isset($post) ? $post->content : '' ?>
        </div>
        <div class="formButtons bg-gradient" style="border: 1px solid #599080; background-color: #599080;">
            <div class="py-1 d-flex gap-1 justify-content-center">
                <button type="submit" class="btn btn-primary">제출</button><a href="/main" class="btn btn-secondary" role="button">취소</a>
            </div>
        </div>
   </form> 
</article>
<?= $this->endSection() ?>


<?= $this->section('js') ?>
<script>
const editor = new Quill('#editor', { theme: 'snow'});

<?php if (isset($post)): ?>
editor.root.innerHTML = <?= json_encode($post->content) ?>;
<?php endif; ?>
document.getElementById('postForm').addEventListener('submit', (e) => {
    const _this = e.target;
    e.preventDefault();
    _this.querySelector('input[name="content"]').value = editor.root.innerHTML;

    _this.submit();

});
</script>
<?= $this->endSection() ?>