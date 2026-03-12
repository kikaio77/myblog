<?php

namespace App\Cells;

use App\Models\Post;

class CategoryCell 
{
    public static function subNavCategory(): string
    {
        $postModel = model('post');

        $categories = $postModel->getPostCountByCategory();

        $html = [];

        foreach ($categories as $category) {
            $html[] = "<a href='/posts/category/{$category->id}' class='nav-link sb-menu-link'>{$category->name}</a>";
        }
        return implode(' ', $html);
    }   
}