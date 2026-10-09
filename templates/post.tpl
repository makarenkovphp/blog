{extends file="layouts/main.tpl"}

{block name="content"}
    <article>
        <h2>{$post.title|escape}</h2>

        <p>{$post.description|escape}</p>

        <p>
            Published: {$post.published_at|escape} |
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

        <div>{$post.content|escape|nl2br}</div>
    </article>

    <hr>

    <h2>Similar articles</h2>
        
    <section class="post-grid">
        {if $similarPosts}
            {foreach $similarPosts as $similarPost}
                {include file="partials/post-card.tpl" post=$similarPost}
            {/foreach}
        {else}
            <p>No similar articles found.</p>
        {/if}
    </section>

    <p><a href="/">Back to home</a></p>
{/block}

