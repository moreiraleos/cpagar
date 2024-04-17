<div class="dash_content_sidebar">
    <h3 class="icon-asterisk">dashboard/blog</h3>
    <p class="dash_content_sidebar_desc">Aqui você gerencia todos os artigos e categorias do blog...</p>

    <nav>
        <?php
        $nav = function ($icon, $href, $title) use ($getApp) {
            $active = ($getApp == $href ? "active" : null);
            return "<a class=\"icon-{$icon} radius {$active}\" href=\"dash.php?app={$href}\">{$title}</a>";
        };

        echo $nav("pencil-square-o", "blog/home", "Blog");
        echo $nav("bookmark", "blog/categories", "Categorias");
        echo $nav("plus-circle", "blog/post-create", "Novo Artigo");
        ?>
    </nav>
</div>