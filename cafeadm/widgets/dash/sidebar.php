<div class="dash_content_sidebar">
    <h3 class="icon-asterisk">dashboard</h3>
    <p class="dash_content_sidebar_desc">Tenha insights poderosos para escalar seus resultaods...</p>

    <nav>
        <?php
        $nav = function ($icon, $href, $title) use ($getApp) {
            $active = ($getApp == $href ? "active" : null);
            return "<a class=\"icon-{$icon} radius {$active}\" href=\"dash.php?app={$href}\">{$title}</a>";
        };

        echo $nav("cog", "dash/home", "Dash");
        ?>
    </nav>
</div>