<?= $this->extend('layout/default') ?>

<?= $this->section('head') ?>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
<?= csrf_meta() ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h4 class="content-title">글 등록/수정</h4>
<article>
   <form name="postForm" id="postForm" method="POST" action="<?= $form['action'] ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="<?= $form['method'] ?>">
        <input type="hidden" name="id" value="<?= $post->id ?>" id="id">
        <input type="hidden" name="content" id="content" value="">
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
        toolbar: {
            container: [
                ['bold', 'italic', 'underline'],
                ['image']
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

document.getElementById('postForm').addEventListener('submit', (e) => {
    const _this = e.target;
    e.preventDefault();
    _this.querySelector('input[name="content"]').value = editor.root.innerHTML;

    _this.submit();
});
</script>
<?= $this->endSection() ?>