<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Smarty\Smarty;

final class CategoryController
{
    private const POSTS_PER_PAGE = 5;

    public function __construct(
        private Smarty $smarty,
        private CategoryRepository $categoryRepository,
        private PostRepository $postRepository
    ) {
    }

    public function index(): void
    {
        $categoryId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$categoryId || $categoryId < 1) {
            $this->notFound();
            return;
        }

        $category = $this->categoryRepository->findById($categoryId);

        if ($category === null) {
            $this->notFound();
            return;
        }

        $sort = $_GET['sort'] ?? 'date';

        if (!in_array($sort, ['date', 'views'], true)) {
            $sort = 'date';
        }

        $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
        $page = $page && $page > 0 ? $page : 1;

        $totalPosts = $this->postRepository->countByCategory($categoryId);
        $totalPages = max(1, (int) ceil($totalPosts / self::POSTS_PER_PAGE));

        if ($page > $totalPages) {
            $page = $totalPages;
        }

        $offset = ($page - 1) * self::POSTS_PER_PAGE;

        $posts = $this->postRepository->findByCategory(
            $categoryId,
            $sort === 'views' ? 'views' : 'date',
            self::POSTS_PER_PAGE,
            $offset
        );

        $this->smarty->assign('title', $category['name']);
        $this->smarty->assign('category', $category);
        $this->smarty->assign('posts', $posts);
        $this->smarty->assign('sort', $sort);
        $this->smarty->assign('page', $page);
        $this->smarty->assign('totalPages', $totalPages);

        $this->smarty->display('category.tpl');
    }

    private function notFound(): void
    {
        http_response_code(404);

        $this->smarty->assign('title', 'Category not found');
        $this->smarty->display('404.tpl');
    }
}
