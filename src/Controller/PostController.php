<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Smarty\Smarty;

final class PostController
{
    public function __construct(
        private Smarty $smarty,
        private PostRepository $postRepository,
        private CategoryRepository $categoryRepository
    ) {
    }

    public function show(): void
    {
        $postId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$postId || $postId < 1) {
            $this->notFound();
            return;
        }

        $post = $this->postRepository->findById($postId);

        if ($post === null) {
            $this->notFound();
            return;
        }

        $this->postRepository->incrementViews($postId);
        $post['views']++;

        $categories = $this->categoryRepository->findByPostId($postId);
        $similarPosts = $this->postRepository->findSimilar($postId);

        $this->smarty->assign('title', $post['title']);
        $this->smarty->assign('post', $post);
        $this->smarty->assign('categories', $categories);
        $this->smarty->assign(
            'activeCategoryIds',
            array_map('intval', array_column($categories, 'id'))
        );
        $this->smarty->assign('similarPosts', $similarPosts);
        $this->smarty->assign(
            'navigationCategories',
            $this->categoryRepository->findAllWithPosts()
        );
        $this->smarty->assign('isHomePage', false);

        $this->smarty->display('post.tpl');
    }

    private function notFound(): void
    {
        http_response_code(404);

        $this->smarty->assign('title', 'Page not found');
        $this->smarty->display('404.tpl');
    }
}

