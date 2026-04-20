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
        <span class="mb-2">덧글을 작성하시려면 로그인을 해주세요</span>
    <?php endif; ?>

    <div id="commentList">
    </div>
</div>

<script>
const list = document.getElementById('commentList');

document.addEventListener('DOMContentLoaded', e => {
    const commentsData = loadCommentData(<?= $post->id ?>);
    
    commentsData
        .then(
          rows => {
            printComments(list, rows);  
          }
        )
});
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
        if (d.error) {
            alert(d.message);
            return false;
        }
        
        const rows = d.comments;
        
        list.innerHTML = ''; 
        printComments(list, rows);

    })
});
function loadCommentData(postId) {
    return new Promise(function(resolve, reject) {
        fetch(`/comment/list/${postId}`, { method: 'GET', headers: { 'Content-Type': 'appplication/json', 'x-requested-with': 'XMLHttpRequest'}})
        .then( res => res.json())
        .then( d => resolve(d.comments))
        .catch( e => console.log(e.error));                       
    });
}
function printComments(listDom,rows) {
     rows.forEach( row => {
            const div = document.createElement('div');
            div.classList.add('commentItem');
            console.log(div);
            if (row.depth > 0) {
                const replyIcon = document.createElement('div');
                replyIcon.classList.add('p-1');
                replyIcon.innerText = 'ㄴ';
                div.append(replyIcon);
            }
            const itemCont = document.createElement('div');
            itemCont.classList.add('card', 'mb-1', 'w-100');
            const itemBody = document.createElement('div');
            itemBody.classList.add('card-body');
            const bodyInner = document.createElement('div');
            bodyInner.classList.add('row', 'mb-1');
            const leftPart = document.createElement('div');
            leftPart.classList.add('col-8');
            const nick = document.createElement('strong');
            nick.classList.add('me-2');
            nick.innerText = row.nick;
            const writtenTime =  document.createElement('span');
            writtenTime.classList.add('text-secondary');
            writtenTime.innerText = row.created_at;
            leftPart.append(nick);
            leftPart.append(writtenTime)
            const rightPart = document.createElement('div');
            rightPart.classList.add('col-4', 'd-flex', 'justify-content-end', 'gap-1');
            

            if (<?= session()->has('user') ?>) {

                if (row.isWriter) {

                    if (! row.deleted_at) {

                        const submitBtn = document.createElement('button');
                        submitBtn.classList.add('btn', 'btn-sm', 'btn-primary');
                        submitBtn.innerText = '제출';
                        submitBtn.dataset.idx = row.cid;
                        submitBtn.style.display = 'none';

                        submitBtn.addEventListener('click', e => {
                            fetch('/comment/modify', {'method': 'POST', 'headers': { 'Content-Type': 'application/json', 'x-requested-with': 'XMLHttpRequest', 'X-CSRF-TOKEN': document.querySelector('meta[name="X-CSRF-TOKEN"]').content}, 'body': JSON.stringify({'idx': e.target.dataset.idx, 'text':  itemBody.querySelector('textarea').value})})
                                .then(res => res.json())
                                .then(d => {
                                    if (d.error) {
                                        alert(d.message);
                                        return false;
                                    }
                                    itemBody.querySelector('.py-2').innerText = d.text;
                                    itemBody.querySelector('.py-2').style.display = 'block';
                                    itemBody.querySelector('textarea').innerText = d.text;
                                    itemBody.querySelector('textarea').style.display = 'none';

                                    e.target.style.display =  'none';
                                    cancelBtn.style.display =  'none';
                                    modifyBtn.style.display =  'block';
                                    delBtn.style.display =  'block';
                                });
                        });
                        const cancelBtn = document.createElement('button');
                        cancelBtn.classList.add('btn', 'btn-sm', 'btn-secondary');
                        cancelBtn.innerText = '취소';
                        cancelBtn.style.display = 'none';

                        cancelBtn.addEventListener('click', e => {
                            modifyBtn.style.display = 'block';
                            delBtn.style.display = 'block';
                            submitBtn.style.display = 'none';
                            cancelBtn.style.display = 'none';
                           
                            itemBody.querySelector('.py-2').style.display = 'block';
                            itemBody.querySelector('textarea').style.display = 'none';
                        });
                        const modifyBtn = document.createElement('button');
                        modifyBtn.classList.add('btn', 'btn-sm', 'btn-warning');
                        modifyBtn.innerText = '수정';
                        modifyBtn.dataset.idx = row.cid;
                        modifyBtn.addEventListener('click', e => {
                           
                            itemBody.querySelector('.py-2').style.display = 'none';
                            itemBody.querySelector('textarea').style.display = 'block';
                            modifyBtn.style.display = 'none';
                            delBtn.style.display = 'none';
                            submitBtn.style.display = 'block';
                            cancelBtn.style.display = 'block';
                        });
                        rightPart.append(modifyBtn);
                        const delBtn = document.createElement('button');
                        delBtn.classList.add('btn', 'btn-sm', 'btn-danger');
                        delBtn.innerHTML = '삭제';
                        delBtn.dataset.idx = row.cid;
                        delBtn.addEventListener('click', e => {
                            fetch('/comment/drop',
                            {
                                'method': 'POST',
                                'headers': {
                                    'Content-Type': 'Application/json',
                                    'x-requested-with': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="X-CSRF-TOKEN"]').content
                                },
                                'body': JSON.stringify({idx: row.cid})
                            })
                            .then(res => res.json())    
                            .then(d => {
                                alert(d.message);
                          

                            itemBody.querySelector('strong').innerText = '';
                            itemBody.querySelector('.py-2').innerText = '삭제된 덧글입니다.';
                            });
                        });
                        rightPart.append(delBtn, submitBtn, cancelBtn);
                    }
                    
                } else {
                    const replyBtn = document.createElement('button');
                    replyBtn.classList.add('btn', 'btn-sm', 'btn-secondary');
                    replyBtn.innerText = '답글';

                    rightPart.append(replyBtn);
                }
            }
            bodyInner.append(leftPart, rightPart);

            const content = document.createElement('div');
            const textarea = document.createElement('textarea');
            textarea.classList.add('form-control', 'w-100');
            textarea.style.display = 'none';
            textarea.innerText = row.text;
            content.classList.add('py-2');
            content.innerText =  row.text;
            
            itemBody.append(bodyInner, content, textarea);
            itemCont.append(itemBody);
            div.style.width = `calc(100% - (${row.depth}*20px))`;
            div.append(itemCont);
            listDom.append(div);
    });
}
</script>
<?= $this->endSection() ?>