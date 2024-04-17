<div class="dash_content_sidebar">
    <h3 class="icon-asterisk">dashboard/usuários</h3>
    <p class="dash_content_sidebar_desc">Gerencie, monitore e acompanhe os usuários do seu site aqui...</p>

    <nav>
        <?php
        $nav = function ($icon, $href, $title) use ($getApp) {
            $active = ($getApp == $href ? "active" : null);
            return "<a class=\"icon-{$icon} radius {$active}\" href=\"dash.php?app={$href}\">{$title}</a>";
        };

        echo $nav("user", "users/home", "Usuários");
        echo $nav("plus-circle", "users/create", "Novo usuário");
        ?>
    </nav>
</div>