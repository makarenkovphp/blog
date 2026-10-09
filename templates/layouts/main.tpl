<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{$title|escape}</title>
        <link rel="stylesheet" href="/css/style.css">
    </head>

    <body>
        <header>
            <h1><a href="/">My Blog</a></h1>
        </header>

        <nav class="site-nav">
            <a href="/" class="{if $isHomePage|default:false}active{/if}">
                Home
            </a>

            {foreach $navigationCategories as $navCategory}
                <a
                    href="/category.php?id={$navCategory.id}"
                    class="{if ($activeCategoryId|default:null) == $navCategory.id
                            || (isset($activeCategoryIds)
                            && in_array($navCategory.id, $activeCategoryIds))}active{/if}"
                >
                    {$navCategory.name|escape}
                </a>
            {/foreach}
        </nav>

        <main>
            {block name="content"}{/block}
        </main>
    </body>
</html>

