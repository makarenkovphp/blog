<article>
    <h3>
        <a href="/post.php?id={$post.id}">
            {$post.title|escape}
        </a>
    </h3>

    <p>{$post.description|escape}</p>

    <small>
        Views: {$post.views} |
        Published: {$post.published_at|escape}
    </small>
</article>

