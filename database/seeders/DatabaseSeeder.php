<?php

use App\Database\Connection;

final class DatabaseSeeder
{
    public function run(): void
    {
        $pdo = Connection::get();

        $pdo->exec('SET FOREIGN_KEY_CHECKS = 0');

        try {
            $pdo->exec('TRUNCATE TABLE article_categories');
            $pdo->exec('TRUNCATE TABLE posts');
            $pdo->exec('TRUNCATE TABLE categories');
        } finally {
            $pdo->exec('SET FOREIGN_KEY_CHECKS = 1');
        }

        $pdo->beginTransaction();

        try {
            $categoryIds = $this->seedCategories($pdo);

            $this->seedPosts($pdo, $categoryIds);

            $pdo->commit();

            echo "Database seeded successfully." . PHP_EOL;
        } catch (\Throwable $exception) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }

            throw $exception;
        }
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
            // --- 11 Постов в категории 'PHP' ---
            [
                'title' => 'Getting Started with PHP 8',
                'image' => '/images/web-dev.jpg',
                'description' => 'An introduction to modern PHP development.',
                'content' => 'PHP 8 provides many useful features for modern web applications.',
                'views' => 1250,
                'published_at' => '2026-09-28 10:00:00',
                'categories' => ['PHP', 'Web Development'],
            ],
            [
                'title' => 'Understanding PHP Arrays',
                'image' => '/images/php.jpg',
                'description' => 'A practical guide to working with arrays in PHP.',
                'content' => 'Arrays are one of the most frequently used data structures in PHP.',
                'views' => 980,
                'published_at' => '2026-09-25 14:30:00',
                'categories' => ['PHP'],
            ],
            [
                'title' => 'Object-Oriented Programming in PHP',
                'image' => '/images/architecture.jpg',
                'description' => 'The basic principles of OOP in PHP.',
                'content' => 'Classes, objects, inheritance and interfaces are the foundation of OOP in PHP.',
                'views' => 1540,
                'published_at' => '2026-09-22 09:15:00',
                'categories' => ['PHP'],
            ],
            [
                'title' => 'PHP Exceptions Explained',
                'image' => '/images/php.jpg',
                'description' => 'How to handle errors and exceptions in PHP applications.',
                'content' => 'Exceptions allow an application to handle unexpected situations in a controlled way.',
                'views' => 760,
                'published_at' => '2026-09-18 16:00:00',
                'categories' => ['PHP'],
            ],
            [
                'title' => 'PHP and Docker',
                'image' => '/images/php.jpg',
                'description' => 'Running a PHP application inside a Docker container.',
                'content' => 'Docker can provide a consistent development environment for PHP applications.',
                'views' => 1750,
                'published_at' => '2026-09-17 11:30:00',
                'categories' => ['Docker', 'PHP'],
            ],
            [
                'title' => 'PHP String Processing',
                'image' => '/images/php.jpg',
                'description' => 'Functions and strategies for string manipulation in PHP.',
                'content' => 'Working efficiently with strings is a core skill for any PHP developer.',
                'views' => 890,
                'published_at' => '2026-09-16 09:00:00',
                'categories' => ['PHP'],
            ],
            [
                'title' => 'Working with Files in PHP',
                'image' => '/images/php.jpg',
                'description' => 'Reading, writing and managing files with PHP.',
                'content' => 'Learn how to handle filesystem operations securely and efficiently.',
                'views' => 640,
                'published_at' => '2026-09-14 12:15:00',
                'categories' => ['PHP'],
            ],
            [
                'title' => 'PHP Security Best Practices',
                'image' => '/images/architecture.jpg',
                'description' => 'Securing PHP applications against common vulnerabilities.',
                'content' => 'Sanitizing input, escaping output, and preventing SQL injection and XSS.',
                'views' => 2200,
                'published_at' => '2026-09-11 15:45:00',
                'categories' => ['PHP'],
            ],
            [
                'title' => 'Building a Simple Web Application',
                'description' => 'The basic structure of a web application.',
                'content' => 'A web application usually consists of routing, business logic, data access and presentation layers.',
                'views' => 920,
                'published_at' => '2026-09-10 14:00:00',
                'categories' => ['PHP'],
            ],
            [
                'title' => 'MVC Architecture Explained',
                'image' => '/images/architecture.jpg',
                'description' => 'Understanding the Model-View-Controller pattern.',
                'content' => 'MVC separates application data, business logic and presentation into distinct parts.',
                'views' => 2010,
                'published_at' => '2026-09-05 09:45:00',
                'categories' => ['PHP'],
            ],
            [
                'title' => 'PHP Type System Overview',
                'description' => 'Understanding strict typing and union types in PHP.',
                'content' => 'Modern PHP features strong typing capabilities that improve code quality.',
                'views' => 1100,
                'published_at' => '2026-09-01 10:00:00',
                'categories' => ['PHP'],
            ],

            // --- Посты в категории 'MySQL' ---
            [
                'title' => 'MySQL Basics',
                'image' => '/images/mysql.jpg',
                'description' => 'The basic concepts of relational databases and MySQL.',
                'content' => 'MySQL is a popular relational database management system used by many web applications.',
                'views' => 1650,
                'published_at' => '2026-09-26 09:00:00',
                'categories' => ['MySQL'],
            ],
            [
                'title' => 'Understanding SQL JOINs',
                'image' => '/images/database.jpg',
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
                'image' => '/images/database.jpg',
                'description' => 'Basic principles of designing relational databases.',
                'content' => 'A good database structure makes applications easier to maintain and scale.',
                'views' => 1450,
                'published_at' => '2026-09-08 10:30:00',
                'categories' => ['MySQL'],
            ],

            // --- Посты в категории 'Docker' ---
            [
                'title' => 'What Is Docker?',
                'image' => '/images/docker.jpg',
                'description' => 'An introduction to containers and Docker.',
                'content' => 'Docker allows applications and their dependencies to be packaged into isolated containers.',
                'views' => 2700,
                'published_at' => '2026-09-29 08:00:00',
                'categories' => ['Docker'],
            ],
            [
                'title' => 'Docker Compose Basics',
                'image' => '/images/docker.jpg',
                'description' => 'Running multiple services with Docker Compose.',
                'content' => 'Docker Compose makes it easier to define and run applications consisting of multiple containers.',
                'views' => 1980,
                'published_at' => '2026-09-23 18:00:00',
                'categories' => ['Docker'],
            ],

            // --- Категория 'Web Development' (ровно 1 пост: самый верхний) ---
        ];

        $postStatement = $pdo->prepare(
            'INSERT INTO posts (
                image,
                title,
                description,
                content,
                views,
                published_at
            ) VALUES (
                :image,
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
                'image' => $post['image'] ?? null,
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

