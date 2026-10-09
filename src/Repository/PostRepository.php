<?php

namespace App\Repository;

use PDO;

final class PostRepository
{
    public function __construct(
        private PDO $pdo
    ) {
    }

    public function findLatestByCategory(int $categoryId, int $limit = 3): array
    {
        $statement = $this->pdo->prepare('
            SELECT
                p.id,
                p.image,
                p.title,
                p.description,
                p.views,
                p.published_at
            FROM posts p
            INNER JOIN article_categories ac
                ON ac.post_id = p.id
            WHERE ac.category_id = :category_id
            ORDER BY p.published_at DESC, p.id DESC
            LIMIT :limit
        ');

        $statement->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);

        $statement->execute();

        return $statement->fetchAll();
    }

    public function findByCategory(
        int $categoryId,
        string $sort,
        int $limit,
        int $offset
    ): array {
        $orderBy = match ($sort) {
            'views' => 'p.views DESC, p.id DESC',
            default => 'p.published_at DESC, p.id DESC',
        };

        $sql = "
            SELECT
                p.id,
                p.image,
                p.title,
                p.description,
                p.views,
                p.published_at
            FROM posts p
            INNER JOIN article_categories ac
                ON ac.post_id = p.id
            WHERE ac.category_id = :category_id
            ORDER BY {$orderBy}
            LIMIT :limit OFFSET :offset
        ";

        $statement = $this->pdo->prepare($sql);

        $statement->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->bindValue(':offset', $offset, PDO::PARAM_INT);

        $statement->execute();

        return $statement->fetchAll();
    }

    public function countByCategory(int $categoryId): int
    {
        $statement = $this->pdo->prepare('
            SELECT COUNT(*)
            FROM article_categories
            WHERE category_id = :category_id
        ');

        $statement->execute([
            'category_id' => $categoryId,
        ]);

        return (int) $statement->fetchColumn();
    }

    public function findById(int $id): ?array
    {
        $statement = $this->pdo->prepare('
            SELECT
                p.id,
                p.image,
                p.title,
                p.description,
                p.content,
                p.views,
                p.published_at
            FROM posts p
            WHERE p.id = :id
        ');

        $statement->execute([
            'id' => $id,
        ]);

        $post = $statement->fetch();

        return $post ?: null;
    }

    public function findSimilar(
        int $postId,
        int $limit = 3
    ): array {
        $statement = $this->pdo->prepare('
            SELECT DISTINCT
                p.id,
                p.image,
                p.title,
                p.description,
                p.views,
                p.published_at
            FROM posts p
            INNER JOIN article_categories ac
                ON ac.post_id = p.id
            WHERE ac.category_id IN (
                SELECT category_id
                FROM article_categories
                WHERE post_id = :post_id
            )
            AND p.id != :post_id
            ORDER BY p.published_at DESC, p.id DESC
            LIMIT :limit
        ');

        $statement->bindValue(':post_id', $postId, PDO::PARAM_INT);
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);

        $statement->execute();

        $similar = $statement->fetchAll();

        if (count($similar) >= $limit) {
            return $similar;
        }

        $excludeIds = array_merge(
            [$postId],
            array_column($similar, 'id')
        );

        $fill = $this->findLatestExcluding(
            $excludeIds,
            $limit - count($similar)
        );

        return array_merge($similar, $fill);
    }

    /**
     * @param list<int> $excludeIds
     */
    private function findLatestExcluding(array $excludeIds, int $limit): array
    {
        if ($limit < 1 || $excludeIds === []) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($excludeIds), '?'));

        $statement = $this->pdo->prepare("
            SELECT
                p.id,
                p.image,
                p.title,
                p.description,
                p.views,
                p.published_at
            FROM posts p
            WHERE p.id NOT IN ({$placeholders})
            ORDER BY p.published_at DESC, p.id DESC
            LIMIT ?
        ");

        $parameterIndex = 1;

        foreach ($excludeIds as $excludeId) {
            $statement->bindValue($parameterIndex, $excludeId, PDO::PARAM_INT);
            $parameterIndex++;
        }

        $statement->bindValue($parameterIndex, $limit, PDO::PARAM_INT);

        $statement->execute();

        return $statement->fetchAll();
    }

    public function incrementViews(int $id): void
    {
        $statement = $this->pdo->prepare('
            UPDATE posts
            SET views = views + 1
            WHERE id = :id
        ');

        $statement->execute([
            'id' => $id,
        ]);
    }
}

