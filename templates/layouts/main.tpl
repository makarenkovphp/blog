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
            {block name="content"}{/block}
        </main>
    </body>
</html>

