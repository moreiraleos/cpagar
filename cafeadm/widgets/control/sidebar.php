<div class="dash_content_sidebar">
    <h3 class="icon-asterisk">dashboard/control</h3>
    <p class="dash_content_sidebar_desc">Planos, assinaturas e gestão do CaféControl? Está tudo aqui...</p>

    <nav>
        <?php
        $nav = function ($icon, $href, $title) use ($getApp) {
            $active = ($getApp == $href ? "active" : null);
            return "<a class=\"icon-{$icon} radius {$active}\" href=\"dash.php?app={$href}\">{$title}</a>";
        };

        echo $nav("coffee", "control/home", "Control");
        echo $nav("heartbeat", "control/subscribers", "Assinantes");
        echo $nav("flag", "control/plans", "Planos");
        ?>
    </nav>
</div>