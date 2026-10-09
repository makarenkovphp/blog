{extends file="layouts/main.tpl"}

{block name="content"}
    <section>
        <h2>{$category.name|escape}</h2>
        <p>{$category.description|escape}</p>
    </section>

    <nav>
        <span>Sort by:</span>
        <a href="/category.php?id={$category.id}&sort=date">Date</a>
        |
        <a href="/category.php?id={$category.id}&sort=views">Views</a>
    </nav>

    <section class="post-grid">
        {if $posts}
            {foreach $posts as $post}
                {include file="partials/post-card.tpl" post=$post}
            {/foreach}
        {else}
            <p>No articles found.</p>
        {/if}
    </section>

    <nav>
        {if $page > 1}
            <a href="/category.php?id={$category.id}&sort={$sort|escape}&page={$page - 1}">
                Previous
            </a>
        {/if}

        <span>Page {$page} of {$totalPages}</span>

        {if $page < $totalPages}
            <a href="/category.php?id={$category.id}&sort={$sort|escape}&page={$page + 1}">
                Next
            </a>
        {/if}
    </nav>

    <p><a href="/">Back to home</a></p>
{/block}

