<?= $this->extend('layout/default') ?>

<?= $this->section('head') ?>

<!-- highlight.js 브라우저용 전체 빌드 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/highlight.js@11.9.0/styles/default.min.css">
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
<!-- Quill CSS & JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<?= csrf_meta() ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h4 class="content-title">글 등록/수정</h4>
<article>
   <form name="postForm" id="postForm" method="POST" action="<?= $form['action'] ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="<?= $form['method'] ?>">
        <input type="hidden" name="id" value="<?= $post->id ?>" id="id">
        <input type="hidden" name="content" id="content">
        <div class="ms-auto col-6 mb-2 col-sm-3">
            <select name="category_id" id="category_id" class="form-select">
                <option value="">카테고리 선택</option>
                <?php foreach ($categories as $category): ?>
                <option value="<?= $category->id ?>" <?= $post->category_id === $category->id ? 'selected' : '' ?> > <?= $category->name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col mb-2">
          <input type="text" class="form-control" name="title" id="title" placeholder="제목을 입력해주세요" value="<?= $post->title ?>">
        </div>
        <div id="editor" class="border-nowwe bg-white" style="min-height: 430px;">
            <?= $post->content ?>
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

const editor = new Quill('#editor', { 
    theme: 'snow',
    modules: {
        syntax: {
        highlight: text => hljs.highlightAuto(text).value
         },
        toolbar: {
            container: [
                [{ 'header': [1, 2, 3, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                ['blockquote', 'code-block'],
                ['link', 'image', 'video'],
                [{ 'align': [] }],
                [{ 'color': [] }, { 'background': [] }],
                ['clean']
            ],
            handlers: {
                image: function() {
                    const input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('multiple', true);
                    input.setAttribute('accept', 'image/*');
                    input.click();

                    input.onchange = () => {
                        const files = input.files;
                        const formData = new FormData();
                        for (let i = 0; i < files.length; i++) {
                            formData.append('images[]', files[i]);
                        }
                        fetch('/upload/image', {headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="X-CSRF-TOKEN"]')?.content || '' },method: 'POST', body: formData})
                            .then(res => res.json())
                            .then(d => {
								console.log(d);
                                let range = editor.getSelection();
                                d.uploadedPath.forEach (path => {
                                    editor.insertEmbed(range.index, 'image', path);
                                    range.index++;
                                });
                            });
                    }
                }
            }
        }
    }
});
<?php if (session()->has('error')): ?>
    showModal(modal, { 'buttons': { confirm: {used: false}, cancel: { used: true }}, html: `<?= session()->get('error') ?>`});
<?php endif; ?>
document.getElementById('postForm').addEventListener('submit', (e) => {
    const _this = e.target;
    e.preventDefault();
    _this.querySelector('input[name="content"]').value = editor.root.innerHTML;

    _this.submit();
});
</script>
<?= $this->endSection() ?>