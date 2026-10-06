<?php

namespace App\Repository;

use PDO;

final class CategoryRepository
{
    public function __construct(
        private PDO $pdo
    ) {
    }

    public function findAllWithPosts(): array
    {
        $sql = '
            SELECT
                c.id,
                c.name,
                c.description
            FROM categories c
            WHERE EXISTS (
                SELECT 1
                FROM article_categories ac
                WHERE ac.category_id = c.id
            )
            ORDER BY c.name
        ';

        return $this->pdo->query($sql)->fetchAll();
    }

    public function findById(int $id): ?array
    {
        $statement = $this->pdo->prepare('
            SELECT
                id,
                name,
                description
            FROM categories
            WHERE id = :id
        ');

        $statement->execute([
            'id' => $id,
        ]);

        $category = $statement->fetch();

        return $category ?: null;
    }
}

