<?= $this->extend('layout/default') ?>
<?= $this->section('content') ?>
<style>
.form-check .form-check-input{ float: none;}
</style>
<h4 class="content-title mb-5"><?= $title ?></h4>
<div class="my-2 d-flex justify-content-end gap-1"><button class="btn btn-primary btn-sm" data-put="true">추가 / 변경</button><button class="btn btn-danger btn-sm" data-delete="true">삭제</button></div>

<article class="p-3 article">
 <table class="table table-border">
    <thead>
        <tr>
            <th class="text-center"><input type="checkbox" name="allChk" id="allChk" class="form-check-input"></th>
            <th class="text-center">제목</th>
            <th class="text-center">작성일</th>
        </tr>
        <tbody>
        <?php if ($categories): ?>
             <?php foreach ($categories as $idx => $category): ?>
                <tr>
                    <td class="text-center">
						<div class="form-check text-center"><input type="checkbox" name="categories[]" value="<?= $category->id ?>" class="form-check-input"></div></td>
                    <td class="text-center"><?= $category->name ?></td>
                    <td class="text-center"><?= $category->created_at ?></td>
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
<script>
document.addEventListener('click', e => {
	const categoryChks = document.querySelectorAll('input[name="categories[]"]');
	
	if (e.target.dataset.put) {
		
		let body = `<div class="row">
						<div class="col">
							<?= csrf_field() ?>`;					
		const selCategories = document.querySelectorAll('input[name="categories[]"]:checked');
		
		if (selCategories.length === 1) {
			const selCategoryName = selCategories[0].closest('tr').querySelectorAll('td')[1].innerText;
			body += `<input type="hidden" name="idx" id="idx" value="${selCategories[0].value}">
					<input class="form-control" type="text" name="category_name" id="category_name" value="${selCategoryName}">`;
		} else {
			body += `<input class="form-control" type="text" name="category_name" id="category_name" value="">`;
		}
		
		body += `	</div>
					</div>`;
		
		showModal(modal, {
							title: '카테고리 추가/변경', 
							btns: { 
								confirm: 
									{
										is_used: true, 
										class: ['btn', 'btn-sm', 'btn-primary'], 
										text: '적용'
									}
							},
							body: body,
							form: {action: '/category/put', method: 'POST', id: 'putCategory'}
		});
	}
	
	if (e.target.dataset.delete) {
		
		const selCategories = document.querySelectorAll('input[name="categories[]"]:checked');
		
		let deleteFields = ``;
		
		selCategories.forEach(chk => {
			deleteFields += `<input type="hidden" name="categories[]" value="${chk.value}">`;
		});
		
		console.log(deleteFields);
		showModal(modal, {
							title: '카테고리 삭제', 
							btns: { 
								confirm: 
									{
										is_used: true, 
										class: ['btn', 'btn-sm', 'btn-primary'], 
										text: '확인'
									}
							},
							body: `
									<?= csrf_field() ?>
									${deleteFields}
									<p>정말 해당 카테고리를 삭제하시겠습니까?</p>
								`,
							form: {action: '/category/delete', method: 'POST', id: 'delCategory'}
		});
	}
	
	if (e.target.name === 'allChk') {
		
		
		categoryChks.forEach( chk => chk.checked = e.target.checked );
	
	}

});

document.addEventListener('submit', e => {
	e.preventDefault();
	const _this = e.target;
    if (_this.id === 'newCategory') {
       fetch(_this.action, {
			   headers: { 
					'Content-Type': 'x-www-form-urlencoded', 
					'x-requested-with': 'XMLHttpRequest'
				},
				method: _this.method,
				body: new URLSearchParams(serializeObject(_this))
			})
			.then(result => result.json())
			.then(d => {
				alert(d.message);
				if (! d.error) {
					
					window.location.reload();
				}
			});
    }
});

</script>
<?= $this->endSection() ?>