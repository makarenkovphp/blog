<article>
    {if $post.image}
        <a href="/post.php?id={$post.id}">
            <img
                src="{$post.image|escape}"
                alt="{$post.title|escape}"
                loading="lazy"
                style="max-width: 300px; height: auto;"
            >
        </a>
    {/if}

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

