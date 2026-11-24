<?= $this->extend('layout/default') ?>

<?= $this->section('head') ?>

<!-- highlight.js 브라우저용 전체 빌드 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/highlight.js@11.9.0/styles/default.min.css">
<!-- Quill 2 (표 기능 내장) -->
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">

<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

<style>
/* 표 관련 툴바 버튼: 글자 라벨이라 기본 28px 폭보다 넓게 */
.ql-toolbar button[class*="ql-table-"] { width: auto; padding: 3px 6px; font-size: 12px; font-weight: 600; }
/* 편집기 안 표 테두리 */
#editor .ql-editor table { border-collapse: collapse; width: 100%; }
#editor .ql-editor td { border: 1px solid #ccc; padding: 4px 8px; min-width: 40px; }
.ql-snow .ql-editor .ql-code-block-container{ background-color: #f9f3f3 !important;}
.ql-snow .ql-editor .ql-code-block-container{ border: 1px solid #ccc !important;}
</style>

<?= csrf_meta() ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<h4 class="content-title">글 등록/수정</h4>
<article>
	<div class="ms-auto col-6 mb-2 col-sm-3">
		<select name="temp_post" id="temp_post" class="form-select">
			<option value="">임시 작성글 선택</option>
			<?php foreach ($tempPosts as $tempPost): ?>
			<option value="" data-idx="<?= $tempPost->id ?>" data-content="<?= esc($tempPost->content, 'attr') ?>"><?= $tempPost->updated_at . ' | ' . $tempPost->title ?></option>
			<?php endforeach; ?>
		</select>
	</div>
   <form name="postForm" id="postForm" method="POST" action="<?= $form['action'] ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="_method" value="<?= $form['method'] ?>">
        <input type="hidden" name="id" value="<?= $post->id ?>" id="id">
        <input type="hidden" name="content" id="content">
        <div class="row align-items-center">
			<div class="col">
				<div class="form-check form-switch"><input type="checkbox" name="is_secret" id="is_secret" class="form-check-input" <?= $post->is_secret ? 'checked' : '' ?>><label for="is_secret" class="form-check-label">비밀글</label></div>
			</div>
			<div class="ms-auto col-6 mb-2 col-sm-3">
				<select name="category_id" id="category_id" class="form-select">
					<option value="">카테고리 선택</option>
					<?php foreach ($categories as $category): ?>
					<option value="<?= $category->id ?>" <?= $post->category_id === $category->id ? 'selected' : '' ?> > <?= $category->name ?></option>
					<?php endforeach; ?>
				</select>
			</div>
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

<div class="toast-container position-fixed bottom-0 end-0 p-3">
	<div id="saveToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="2000">
		<div class="d-flex">
			<div class="toast-body text-white fw-bold">
				<i class="bi bi-check-circle me-1"></i> 임시저장 완료
			</div>
			<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
		</div>
	</div>
</div>
<?= $this->endSection() ?>


<?= $this->section('js') ?>
<script>
let prevContent = '';
const saveToast = bootstrap.Toast.getOrCreateInstance(document.getElementById('saveToast'));

// 표 툴바 버튼 라벨/설명
const TABLE_BUTTONS = {
    'table-insert':  ['표',   '표 삽입'],
    'table-row-add': ['행+',  '아래에 행 추가'],
    'table-col-add': ['열+',  '오른쪽에 열 추가'],
    'table-row-del': ['행-',  '현재 행 삭제'],
    'table-col-del': ['열-',  '현재 열 삭제'],
    'table-del':     ['표✕',  '표 삭제'],
};

const tableModule = () => editor.getModule('table');

// 커서가 표 안에 있는지 확인
function inTable() {
    const range = editor.getSelection(true);
    const [table] = tableModule().getTable(range);
    if (!table) {
        alert('표 안의 칸을 먼저 클릭해주세요.');
        return false;
    }
    return true;
}

// 이전에 잘못 저장된 글: 코드블록 언어 선택 박스(select.ql-ui)가 본문에 섞여 있으면 제거
function stripQuillUi(html) {
    const tmp = document.createElement('div');
    tmp.innerHTML = html || '';
    tmp.querySelectorAll('select.ql-ui').forEach(el => el.remove());
    return tmp.innerHTML;
}
document.querySelectorAll('#editor select.ql-ui').forEach(el => el.remove());

const editor = new Quill('#editor', {
    theme: 'snow',
    modules: {
        table: true,
        syntax: {
            hljs: window.hljs,
            languages: [
                { key: 'plain', label: 'Plain' },
                { key: 'php', label: 'PHP' },
                { key: 'javascript', label: 'JavaScript' },
                { key: 'c', label: 'C' },
                { key: 'sql', label: 'SQL' },
                { key: 'xml', label: 'HTML' },
                { key: 'css', label: 'CSS' },
            ]
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
                Object.keys(TABLE_BUTTONS),
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
                                // 포커스가 없어도 null이 되지 않도록 true
                                const range = editor.getSelection(true);
                                let index = range.index;
                                d.uploadedPath.forEach(path => {
                                    editor.insertEmbed(index, 'image', path, Quill.sources.USER);
                                    index++;
                                });
                                editor.setSelection(index, 0);
                            });
                    }
                },
                'table-insert': function() {
                    const size = prompt('표 크기 (행,열)', '3,3');
                    if (!size) return;
                    const [rows, cols] = size.split(',').map(n => parseInt(n, 10));
                    if (!(rows > 0 && cols > 0)) {
                        alert('예: 3,3 형식으로 입력해주세요.');
                        return;
                    }
                    editor.getSelection(true);
                    tableModule().insertTable(rows, cols);
                },
                'table-row-add': () => inTable() && tableModule().insertRowBelow(),
                'table-col-add': () => inTable() && tableModule().insertColumnRight(),
                'table-row-del': () => inTable() && tableModule().deleteRow(),
                'table-col-del': () => inTable() && tableModule().deleteColumn(),
                'table-del':     () => inTable() && confirm('표를 삭제할까요?') && tableModule().deleteTable(),
            }
        }
    }
});

// 표 버튼에 글자 라벨 붙이기
Object.entries(TABLE_BUTTONS).forEach(([name, [label, title]]) => {
    const btn = document.querySelector(`.ql-toolbar .ql-${name}`);
    if (btn) {
        btn.textContent = label;
        btn.title = title;
    }
});

// 저장용 HTML
// - getSemanticHTML: 편집용 UI(코드 언어 선택 박스 등) 없이 <ul>/<ol>, <pre data-language>, <table> 형태로 출력
// - 일부 버전에서 공백이 &nbsp;로 바뀌어 줄바꿈이 안 되는 문제가 있어 일반 공백으로 되돌림
function getSaveHtml() {
    return editor.getSemanticHTML()
        .replace(/&nbsp;/g, ' ')
        // 빈 줄이 <p></p>로 나와서 높이 0이 되는 문제 → 편집기와 같은 <p><br></p>로 저장
        .replace(/<(p|h[1-6])([^>]*)><\/\1>/g, '<$1$2><br></$1>');
}

// 저장된 HTML을 Quill 형식으로 변환해서 넣기 (표 포함)
function loadHtml(html) {
    editor.setContents(editor.clipboard.convert({ html: stripQuillUi(html) }), Quill.sources.SILENT);
}

<?php if (session()->has('error')): ?>
    showModal(modal, { 'buttons': { confirm: {used: false}, cancel: { used: true }}, html: `<?= session()->get('error') ?>`});
<?php endif; ?>
document.getElementById('postForm').addEventListener('submit', (e) => {
    const _this = e.target;
    e.preventDefault();
    // root.innerHTML은 편집용 UI(언어 선택 박스 등)까지 포함하므로 저장용 HTML을 사용
    _this.querySelector('input[name="content"]').value = getSaveHtml();

    _this.submit();
});

document.addEventListener('change', e => {
	if (e.target.id === 'temp_post') {
		const postForm = document.getElementById('postForm');
		const selOption = e.target.options[e.target.selectedIndex];

		postForm.querySelector('#title').value = selOption.text.split('|')[1];
		postForm.querySelector('#id').value = selOption.dataset.idx;

		loadHtml(selOption.dataset.content);
		prevContent = getSaveHtml();
	}
});
setInterval(updateTempPost, 60000);



async function updateTempPost() {
	try {

		const postForm = document.getElementById('postForm');
		const currentContent = getSaveHtml();
		postForm.querySelector('input[name="content"]').value = currentContent;

		if (
			currentContent !== prevContent
		) {

			const res = await fetch('/posts/temp/save', {headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="X-CSRF-TOKEN"]')?.content || '', 'Content-Type': 'application/json' },method: 'POST', body: JSON.stringify(serializeObject(postForm))});

			if (!res.ok) {
				throw new Error('임시저장에 실패했습니다.');
			}
			prevContent = currentContent;

			const data = await res.json();

			if (data.tempLists) {
				saveToast.show();
				const tempPost = document.getElementById('temp_post');

				tempPost.querySelectorAll('option').forEach( option => option.remove());
				postForm.querySelector('#id').value = data.newId;

				for (let temp of data.tempLists) {
					const option = document.createElement('option');
					option.text = temp.updated_at + ' | ' + temp.title;
					option.value = temp.id;
					option.dataset.content = temp.content;
					option.dataset.idx = temp.id;

					document.getElementById('temp_post').append(option);
				}
			}
		}

	} catch (err) {
		alert(err);
	}


}
</script>
<?= $this->endSection() ?>
