{extends file="layouts/main.tpl"}

{block name="content"}
    {foreach $categories as $category}
        <section>
            <h2>{$category.name|escape}</h2>
            <p>{$category.description|escape}</p>

            <div class="post-grid">
                {foreach $category.posts as $post}
                    {include file="partials/post-card.tpl" post=$post}
                {/foreach}
            </div>

            <p>
                <a href="/category.php?id={$category.id}">
                    All articles
                </a>
            </p>
        </section>
    {/foreach}
{/block}

