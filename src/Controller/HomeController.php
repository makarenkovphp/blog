<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Smarty\Smarty;

final class HomeController
{
    public function __construct(
        private Smarty $smarty,
        private CategoryRepository $categoryRepository,
        private PostRepository $postRepository
    ) {
    }

    public function index(): void
    {
        $categories = $this->categoryRepository->findAllWithPosts();

        foreach ($categories as &$category) {
            $category['posts'] = $this->postRepository->findLatestByCategory(
                (int) $category['id']
            );
        }

        $this->smarty->assign('title', 'My Blog');
        $this->smarty->assign('categories', $categories);

        $this->smarty->display('home.tpl');
    }
}
