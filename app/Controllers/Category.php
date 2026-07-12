<?php

namespace App\Controllers;

use App\Models\Post;

class Category extends BaseController
{
    public function list($categoryName = null) 
    {
		helper('function');
		
        $db = db_connect();

        $builder = $db->table('posts');

        $builder->select('posts.id, posts.category_id, posts.title, posts.content, posts.views, posts.created_at, categories.id as category_id, categories.name')
                ->join('categories', 'posts.category_id = categories.id');

        if ($categoryName) {
            $builder->where('categories.name', $categoryName);
        }
        $builder->where('posts.deleted_at IS NULL')
                ->orderBy('posts.id', 'DESC');
        $postCnt = $builder->countAllResults(false);

        $query = $builder->get()->getResult();
		
		
		foreach ($query as  $idx => &$row) {
			$row->no = $postCnt - $idx;
			$row->created_at = timeAgoForTimeStamp(strtotime($row->created_at, $_SERVER['REQUEST_TIME']));
		}
        $data['title'] = $categoryName;

        $data['count'] = $postCnt;
        $data['posts'] = $query;

        return view('posts', $data);
    }
	
	public function edit()
	{
		helper('function');
		$categoryModel = model('Category');
		
		
		$ip = $this->request->getIPAddress();
		$whiteListIps = explode('|', $_ENV['policy.whiteListIps']);
		
		if (! isWhiteListIpAddr($ip, $whiteListIps) ) {
			throw new \CodeIgniter\Exceptions\PageNotFoundException($_ENV['error.message.404']);

		} 
		$data['categories'] = $categoryModel->get();
		// $data['categoriesAllCnt'] = sizeof($data['categories']);
		$data['title'] = '블로그 카테고리 수정';
		
		return view('categoryEdit', $data);
		
	}
	
	public function put() 
	{	
		$reqData = $this->request->getPost();
		
		$mapFields = [
			'idx' => 'id',
			'category_name' => 'name'
		];
		
		$putData = [];
		
		foreach ($reqData as $key => $val) {
			if (isset($mapFields[$key])) {
				$putData[$mapFields[$key]] = $val;
			}
		}

		$categoryModel = model('Category');
		$error = false;
		$message = '카테고리가 추가/변경되었습니다.';
		
		if (! $categoryModel->save($putData)) {
			$errMsgs = $categoryModel->errors();
			
			$firstErrMsg = array_shift($errMsgs);
			$error = true;
			
			$message = $firstErrMsg;
			
		} else {
			cache()->delete('subNavCategory');
		}
		
		return $this->response->setJson(['error' => $error, 'message' => $message]);
		
	}
	
	public function drop()
	{
		$categories = $this->request->getPost('categories');
		
		$categories = explode(',', $categories[0]);
		$categoryModel = model('Category');
		
		$error = false;
		$message = '성공적으로 삭제되었습니다.';
		
		if (! $categoryModel->delete($categories)) {
			$error = true;
			$message = '삭제가 실패하였습니다.';
			return $this->response->setJSON(compact('error', 'message'));
		} 
		
		cache()->delete('subNavCategory');
		
		return $this->response->setJSON(compact('error', 'message'));
		
	}
}