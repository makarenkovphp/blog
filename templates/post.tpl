<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title|escape}</title>
</head>
<body>

<header>
    <h1><a href="/">My Blog</a></h1>
</header>

<main>
    <article>
        <h2>{$post.title|escape}</h2>

        <p>{$post.description|escape}</p>

        <p>
            Published: {$post.published_at|escape}
            |
            Views: {$post.views}
        </p>

        {if $categories}
            <p>
                Categories:
                {foreach $categories as $category}
                    <a href="/category.php?id={$category.id}">
                        {$category.name|escape}
                    </a>{if !$category@last}, {/if}
                {/foreach}
            </p>
        {/if}

        {if $post.image}
            <img
                src="{$post.image|escape}"
                alt="{$post.title|escape}"
                style="max-width: 100%; height: auto;"
            >
        {/if}

        <div>
            {$post.content|escape|nl2br}
        </div>
    </article>

    <hr>

    <section>
        <h2>Similar articles</h2>

        {if $similarPosts}
            {foreach $similarPosts as $similarPost}
                <article>
                    <h3>
                        <a href="/post.php?id={$similarPost.id}">
                            {$similarPost.title|escape}
                        </a>
                    </h3>

                    <p>{$similarPost.description|escape}</p>

                    <small>
                        Views: {$similarPost.views}
                        |
                        Published: {$similarPost.published_at|escape}
                    </small>
                </article>
            {/foreach}
        {else}
            <p>No similar articles found.</p>
        {/if}
    </section>

    <p><a href="/">Back to home</a></p>
</main>

</body>
</html>
