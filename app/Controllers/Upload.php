<?php

namespace App\Controllers;

class Upload extends BaseController
{
    public function image()
    {
       $files = $this->request->getFileMultiple('images');
	
        $data = [];
        
        foreach ($files as $file) {
            if (
                $file->isValid() 
                && ! $file->hasMoved()
            ) {
                $newName = $file->getRandomName();
                $file->move(WRITEPATH . 'uploads', $newName);
                $data['uploadedPath'][] = base_url('uploads/' . $newName); //base_url은 app.php의 baseUrl을 기준으로 url을 생성해줌
            }
        }
        
        return $this->response->setJSON($data);
    }
    
}