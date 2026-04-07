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
            $html[] = "<a href='/category/{$category->name}/post' class='nav-link sb-menu-link'>{$category->name} <span class='badge round-pill bg-danger ms-auto'>{$category->count}</span></a>";
        }
        return implode(' ', $html);
    }   
}