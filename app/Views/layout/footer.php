<footer class="py-4 shadow-sm">
    <div class="footerInner text-center fw-normal">
        Copyright <?= date('Y') ?> ⓒ 임승혁.  All right reserved.
    </div>
</footer>

<script>
const modal = document.getElementById('modal');

modal.addEventListener('submit', e => {
    e.preventDefault();
    if (e.target.tagName === 'FORM') {
        const _this = e.target;
		
		if (_this.id === 'putNick') {
			const oldNick = _this.querySelector('input[name="old_nick"]');
			const currentNick = _this.querySelector('input[name="nick"]');
			
			if (oldNick.value === currentNick.value) {
				alert('닉네임을 변경해주세요.');
				return false;
			}
		}
         fetch(_this.getAttribute('action'), {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'x-requested-with': 'XMLHttpRequest'
            },
            method: _this.getAttribute('method'),
            body: new URLSearchParams(serializeObject(_this))
        })
        .then(result => result.json())
        .then(d => {
            alert(d.message);
            
            if (! d.error) {
                location.reload();
            }
        });
    }

});

modal.addEventListener('show.bs.modal', (e) => {
    if (e.relatedTarget?.dataset.mypage) {
        showModal('modal', {
            title: '닉네임 변경하기',
            btns: {
                confirm: { is_used: true, text: '변경', class: ['btn', 'btn-sm', 'btn-primary'] },
                cancel:  { is_used: true, text: '닫기',  class: ['btn', 'btn-sm', 'btn-secondary'] },
            },
            body: `
                    <div class="row">
                        <div class="col">
                            <?= csrf_field() ?>
                            <label class="form-label fs-6 fw-bold">닉네임 변경</label>
							 <input type="hidden" name="old_nick" id="old_nick" value="<?= session()->has('user') && session()->get('user')->nick ? session()->get('user')->nick : ''  ?>">
                            <input class="form-control" type="text" name="nick" id="nick" value="<?= session()->has('user') && session()->get('user')->nick ? session()->get('user')->nick : ''  ?>">
                        </div>
                    </div>
                   `,
            form: {action: '/mypage/putnick', method: 'POST', id: 'putNick'}
        });
    }
});

modal.addEventListener('hidden.bs.modal', () => {
  document.body.style.overflow = 'auto';
});


</script>