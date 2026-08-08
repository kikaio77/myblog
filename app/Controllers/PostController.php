<?php

namespace App\Controllers;

use App\Models\Post;
use App\Models\Category;
use HTMLPurifier;
use stdClass;

class PostController extends BaseController
{
    public function list($id = null)
    {   
        $postModel = model('Post');

        $session = session();
        $data = [];
        if ($id) {
            
			$userIp = $this->request->getIPAddress();
			
            $redis = \Config\Services::redis();
			
			$accessKey = "$userIp:blog_views";
			
            $views = $redis->hget($accessKey, $id);
            
            $data['post'] = $postModel->find($id);
			
			if (! $data['post']) {
				throw new \CodeIgniter\Exceptions\PageNotFoundException($_ENV['error.message.404']);
			}
            $data['pager'] = null;
		
			$tomorrowMidnight = strtotime('tomorrow midnight +2 minutes');
			
			$expireSec = $tomorrowMidnight - $_SERVER['REQUEST_TIME'];
			
            if (! $views) {
                $redis->hset($accessKey, $id, 1);
                $postModel->update($id, ['views' => $data['post']->views + 1]);
				$redis->expire($accessKey, $expireSec);
            }

            $commentModel = model('Comment');

            $data['comments'] = $commentModel->listByPost($id);

            $returnView = 'postDetail';
        } else {
			$postCnt = $postModel->countAllResults();
			
			$offset = $_ENV['app.pagination.offset'];
			$page = $this->request->getGet('page') ?? 1;
			
            $data['posts'] = $postModel->paginate($offset);
            $data['pager'] = $postModel->pager;
			
			foreach ($data['posts'] as $idx => &$post) {
				$post->no = $postCnt - (($page - 1) * $offset) - $idx;
				$post->title = mb_substr($post->title, 0, 10);
			}
           

            $returnView = 'main'; 
        }

        return view($returnView, $data);
    }


    public function form($id = '')
    {   
        $categoryModel = model('Category');
        $postModel = model('Post');
		$tempPostModel = model('TemporaryPost');
        $columns = ['id', 'category_id', 'title', 'content', 'views', 'created_at'];

        $data = [];

        if ($id) {
            $data['post'] = $postModel->select($columns)->find($id); 
            $data['form']['method'] = 'PUT';
            $data['form']['action'] = "/posts/{$id}";

        } else {
            $data['post'] = new stdClass();
            foreach ($columns as $column) {
				$data['post']->{$column} = '';
			}
                
            
            $data['form']['method'] = 'POST';
            $data['form']['action'] = "/posts";
        }
		$data['tempPosts'] = $tempPostModel->withDeleted(false)->orderBy('updated_at', 'DESC')->findAll();
        $data['categories'] = $categoryModel->withDeleted(false)->findAll();
        
        return view('writeForm', $data);
    }

    public function update($id)
    {
        $purifier = new HTMLPurifier();

        $data = $this->request->getVar();
        $data['title'] = empty($data['title']) ? '제목없음' : $data['title'];
		$data['content'] = strtr($data['content'], ['<img' => '<img class=\'img-fluid\'']);
        $data['content'] = $purifier->purify($data['content']);
        
        $postModel = model('Post');

        $postModel->save($data);

        return redirect()->route("posts.list", [$id]);

    }

    public function new()
    {
        $rules = [
            'title' => 'required|max_length[200]',
            'content' => 'required',
            'category_id' => 'required|integer'
        ];

        $messages = [
            'title' => [
                'required' => '제목을 입력해주세요.',
                'max' => '제목은 최대 200자 까지 입니다.'
            ],
            'content' => ['required' => '내용은 반드시 입력해야합니다.'],
            'category_id' => [
                'required' => '카테고리를 반드시 선택해주세요.',
                'integer' => '반드시 숫자여야 합니다.'
            ],
        ];
	
	    $data = $this->request->getPost(['title', 'content', 'category_id']);

        if (! $this->validateData($data, $rules, $messages)) {
            $firstErrKey = array_key_first($this->validator->getErrors());
			log_message('info', $this->validator->getErrors()[$firstErrKey]);
            return redirect()->back()->with('error', $this->validator->getErrors()[$firstErrKey])->withInput();
            exit;
        }
        $purifier = new HTMLPurifier();

		
		$data['content'] = strtr($data['content'], ['<img' => '<img class=\'img-fluid\'']);
        $data['content'] = $purifier->purify($data['content']);
		
        $postModel = model('Post');

        $postModel->insert($data);

		cache()->delete('subNavCategory');

        return redirect()->to('/main');

    }
	
	public function delete($id) {
		
		$postModel = model('Post');
		
		if (! $postModel->delete($id)) {
			return $this->response->setJSON(['error' =>  true, 'message' => '삭제에 실패했습니다.']);
		}
		
		return $this->response->setJSON(['error' =>  false, 'message' => '삭제 성공!']);
	}
	
	public function tempSave() {
		$reqData = $this->request->getJSON();
		
		$tempPostModel = model('TemporaryPost');
		
		$purifier = new HTMLPurifier;

		$saveData = [
			'title' => $reqData->title,
			'content' => $purifier->purify($reqData->content),
		];
		
		
		if (!empty($reqData->id)) {
			$saveData['id'] = $reqData->id;
			if (! $tempPostModel->save($saveData)) {
				return $this->response->setJSON(['error' => false]);
			}
			$newId = $reqData->id;
		} else {
			if (! $tempPostModel->save($saveData)) {
				return $this->response->setJSON(['error' => false]);
			}
			$newId = $tempPostModel->getInsertId();
		}		
		
		return $this->response->setJSON(['error' => false , 'newId' => $newId, 'tempLists' =>  $tempPostModel->orderBy('updated_at', 'DESC')->findAll()]);
	}
}
