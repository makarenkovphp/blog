<?php

use App\Database\Connection;

final class DatabaseSeeder
{
    public function run(): void
    {
        $pdo = Connection::get();

        $pdo->beginTransaction();

        try {
            $this->clearDatabase($pdo);

            $categoryIds = $this->seedCategories($pdo);

            $this->seedPosts($pdo, $categoryIds);

            $pdo->commit();

            echo "Database seeded successfully." . PHP_EOL;
        } catch (\Throwable $exception) {
            $pdo->rollBack();

            throw $exception;
        }
    }

    private function clearDatabase(PDO $pdo): void
    {
        $pdo->exec('DELETE FROM article_categories');
        $pdo->exec('DELETE FROM posts');
        $pdo->exec('DELETE FROM categories');
    }

    private function seedCategories(PDO $pdo): array
    {
        $categories = [
            [
                'name' => 'PHP',
                'description' => 'Articles about PHP development.',
            ],
            [
                'name' => 'Symfony',
                'description' => 'Articles about Symfony framework.',
            ],
            [
                'name' => 'MySQL',
                'description' => 'Articles about MySQL and databases.',
            ],
            [
                'name' => 'Docker',
                'description' => 'Articles about Docker and containers.',
            ],
            [
                'name' => 'Web Development',
                'description' => 'General articles about web development.',
            ],
        ];

        $statement = $pdo->prepare(
            'INSERT INTO categories (name, description)
             VALUES (:name, :description)'
        );

        $categoryIds = [];

        foreach ($categories as $category) {
            $statement->execute($category);

            $categoryIds[$category['name']] = (int) $pdo->lastInsertId();
        }

        return $categoryIds;
    }

    private function seedPosts(PDO $pdo, array $categoryIds): void
    {
        $posts = [
            [
                'title' => 'Getting Started with PHP 8',
                'description' => 'An introduction to modern PHP development.',
                'content' => 'PHP 8 provides many useful features for modern web applications.',
                'views' => 1250,
                'published_at' => '2026-09-28 10:00:00',
                'categories' => ['PHP', 'Web Development'],
            ],
            [
                'title' => 'Understanding PHP Arrays',
                'description' => 'A practical guide to working with arrays in PHP.',
                'content' => 'Arrays are one of the most frequently used data structures in PHP.',
                'views' => 980,
                'published_at' => '2026-09-25 14:30:00',
                'categories' => ['PHP'],
            ],
            [
                'title' => 'Object-Oriented Programming in PHP',
                'description' => 'The basic principles of OOP in PHP.',
                'content' => 'Classes, objects, inheritance and interfaces are the foundation of OOP in PHP.',
                'views' => 1540,
                'published_at' => '2026-09-22 09:15:00',
                'categories' => ['PHP', 'Web Development'],
            ],
            [
                'title' => 'PHP Exceptions Explained',
                'description' => 'How to handle errors and exceptions in PHP applications.',
                'content' => 'Exceptions allow an application to handle unexpected situations in a controlled way.',
                'views' => 760,
                'published_at' => '2026-09-18 16:00:00',
                'categories' => ['PHP'],
            ],
            [
                'title' => 'Introduction to Symfony',
                'description' => 'The main concepts behind Symfony applications.',
                'content' => 'Symfony is a PHP framework built around reusable components and clear application architecture.',
                'views' => 2100,
                'published_at' => '2026-09-27 11:00:00',
                'categories' => ['Symfony', 'PHP'],
            ],
            [
                'title' => 'Symfony Controllers',
                'description' => 'Understanding controllers in Symfony.',
                'content' => 'Controllers receive HTTP requests and return appropriate responses to the client.',
                'views' => 1340,
                'published_at' => '2026-09-24 13:20:00',
                'categories' => ['Symfony', 'Web Development'],
            ],
            [
                'title' => 'Symfony Dependency Injection',
                'description' => 'How dependency injection works in Symfony.',
                'content' => 'Dependency injection helps keep application components independent and easier to test.',
                'views' => 1890,
                'published_at' => '2026-09-20 10:45:00',
                'categories' => ['Symfony', 'PHP'],
            ],
            [
                'title' => 'Working with Symfony Forms',
                'description' => 'Creating and processing forms in Symfony.',
                'content' => 'Symfony Forms provide tools for building, rendering and validating HTML forms.',
                'views' => 870,
                'published_at' => '2026-09-15 15:30:00',
                'categories' => ['Symfony'],
            ],
            [
                'title' => 'MySQL Basics',
                'description' => 'The basic concepts of relational databases and MySQL.',
                'content' => 'MySQL is a popular relational database management system used by many web applications.',
                'views' => 1650,
                'published_at' => '2026-09-26 09:00:00',
                'categories' => ['MySQL', 'Web Development'],
            ],
            [
                'title' => 'Understanding SQL JOINs',
                'description' => 'A practical explanation of SQL JOIN operations.',
                'content' => 'JOINs allow us to retrieve related data from multiple database tables.',
                'views' => 2300,
                'published_at' => '2026-09-19 12:00:00',
                'categories' => ['MySQL'],
            ],
            [
                'title' => 'MySQL Indexes',
                'description' => 'How database indexes improve query performance.',
                'content' => 'Indexes can significantly improve SELECT queries when they are used correctly.',
                'views' => 1120,
                'published_at' => '2026-09-12 17:00:00',
                'categories' => ['MySQL'],
            ],
            [
                'title' => 'Database Design for Web Applications',
                'description' => 'Basic principles of designing relational databases.',
                'content' => 'A good database structure makes applications easier to maintain and scale.',
                'views' => 1450,
                'published_at' => '2026-09-08 10:30:00',
                'categories' => ['MySQL', 'Web Development'],
            ],
            [
                'title' => 'What Is Docker?',
                'description' => 'An introduction to containers and Docker.',
                'content' => 'Docker allows applications and their dependencies to be packaged into isolated containers.',
                'views' => 2700,
                'published_at' => '2026-09-29 08:00:00',
                'categories' => ['Docker', 'Web Development'],
            ],
            [
                'title' => 'Docker Compose Basics',
                'description' => 'Running multiple services with Docker Compose.',
                'content' => 'Docker Compose makes it easier to define and run applications consisting of multiple containers.',
                'views' => 1980,
                'published_at' => '2026-09-23 18:00:00',
                'categories' => ['Docker'],
            ],
            [
                'title' => 'PHP and Docker',
                'description' => 'Running a PHP application inside a Docker container.',
                'content' => 'Docker can provide a consistent development environment for PHP applications.',
                'views' => 1750,
                'published_at' => '2026-09-17 11:30:00',
                'categories' => ['Docker', 'PHP'],
            ],
            [
                'title' => 'Building a Simple Web Application',
                'description' => 'The basic structure of a web application.',
                'content' => 'A web application usually consists of routing, business logic, data access and presentation layers.',
                'views' => 920,
                'published_at' => '2026-09-10 14:00:00',
                'categories' => ['Web Development', 'PHP'],
            ],
            [
                'title' => 'MVC Architecture Explained',
                'description' => 'Understanding the Model-View-Controller pattern.',
                'content' => 'MVC separates application data, business logic and presentation into distinct parts.',
                'views' => 2010,
                'published_at' => '2026-09-05 09:45:00',
                'categories' => ['Web Development', 'PHP', 'Symfony'],
            ],
            [
                'title' => 'How Web Applications Communicate',
                'description' => 'A simple explanation of HTTP requests and responses.',
                'content' => 'Browsers communicate with web servers using HTTP requests and responses.',
                'views' => 680,
                'published_at' => '2026-08-30 16:20:00',
                'categories' => ['Web Development'],
            ],
        ];

        $postStatement = $pdo->prepare(
            'INSERT INTO posts (
                title,
                description,
                content,
                views,
                published_at
            ) VALUES (
                :title,
                :description,
                :content,
                :views,
                :published_at
            )'
        );

        $categoryStatement = $pdo->prepare(
            'INSERT INTO article_categories (post_id, category_id)
             VALUES (:post_id, :category_id)'
        );

        foreach ($posts as $post) {
            $postStatement->execute([
                'title' => $post['title'],
                'description' => $post['description'],
                'content' => $post['content'],
                'views' => $post['views'],
                'published_at' => $post['published_at'],
            ]);

            $postId = (int) $pdo->lastInsertId();

            foreach ($post['categories'] as $categoryName) {
                $categoryStatement->execute([
                    'post_id' => $postId,
                    'category_id' => $categoryIds[$categoryName],
                ]);
            }
        }
    }
}

