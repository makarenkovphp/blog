<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{$title|escape}</title>
</head>
<body>

<header>
    <h1><a href="/">My Blog</a></h1>
</header>

<main>
    <h2>{$category.name|escape}</h2>

    <p>{$category.description|escape}</p>

    <nav>
        Sort by:
        <a href="?id={$category.id}&sort=date">Publication date</a>
        |
        <a href="?id={$category.id}&sort=views">Views</a>
    </nav>

    {if $posts}
        {foreach $posts as $post}
            <article>
                <h3>
                    <a href="/post.php?id={$post.id}">
                        {$post.title|escape}
                    </a>
                </h3>

                <p>{$post.description|escape}</p>

                <small>
                    Views: {$post.views}
                    |
                    Published: {$post.published_at|escape}
                </small>
            </article>
        {/foreach}
    {else}
        <p>No articles in this category yet.</p>
    {/if}

    {if $totalPages > 1}
        <nav aria-label="Pagination">
            {if $page > 1}
                <a href="?id={$category.id}&sort={$sort}&page={$page - 1}">
                    Previous
                </a>
            {/if}

            Page {$page} of {$totalPages}

            {if $page < $totalPages}
                <a href="?id={$category.id}&sort={$sort}&page={$page + 1}">
                    Next
                </a>
            {/if}
        </nav>
    {/if}

    <p><a href="/">Back to home</a></p>
</main>

</body>
</html>
