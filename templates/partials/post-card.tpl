<article>
    {if $post.image}
        <a href="/post.php?id={$post.id}">
            <img
                class="post-card-image"
                src="{$post.image|escape}"
                alt="{$post.title|escape}"
                loading="lazy"
            >
        </a>
    {/if}

    <h3 class="post-card-title">
        <a href="/post.php?id={$post.id}">
            {$post.title|escape}
        </a>
    </h3>

    <p>{$post.description|escape}</p>

    <small class="post-meta">
        Views: {$post.views} |
        Published: {$post.published_at|escape}
    </small>
</article>

