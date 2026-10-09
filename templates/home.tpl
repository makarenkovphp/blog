<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{$title}</title>
</head>
<body>

<header>
    <h1>{$title}</h1>
</header>

<main>
    {foreach $categories as $category}
        <section>
            <h2>{$category.name}</h2>

            <p>{$category.description}</p>

            <div>
                {foreach $category.posts as $post}
                    <article>
                        <h3>
                            <a href="/post.php?id={$post.id}">
                                {$post.title}
                            </a>
                        </h3>

                        <p>{$post.description}</p>

                        <small>
                            {$post.views} views |
                            {$post.published_at}
                        </small>
                    </article>
                {/foreach}
            </div>

            <p>
                <a href="/category.php?id={$category.id}">
                    All articles
                </a>
            </p>
        </section>
    {/foreach}
</main>

</body>
</html>
