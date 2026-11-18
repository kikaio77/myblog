<?php

namespace App\Controllers;

use App\Models\SynIp;

class SynIps extends BaseController
{
	public function index() {
		$result = [ 'title' => 'SYN IP 리스트'];
		$model = model('App\Models\SynIp');
		
		$offset = $_ENV['app.pagination.offset'];
		$page = $this->request->getGet('page') ?? 1;
		
		$result['count'] = $model->where('deleted_at IS NULL')->countAllResults();
		
		$result['list'] = $model->paginate($offset);
		
		$result['pager'] = $model->pager;
		
		foreach ($result['list'] as $idx => &$row) {
			$row->no = $result['count'] - (($page - 1) * $offset) - $idx;
		}
		
		return view('synIps', $result);
	}
}