<div class="dash_content_sidebar">
    <h3 class="icon-asterisk">dashboard/faqs</h3>
    <p class="dash_content_sidebar_desc">Gerenciamento completo do seu APP de perguntas frequentes...</p>

    <nav>
        <?php
        $nav = function ($icon, $href, $title) use ($getApp) {
            $active = ($getApp == $href ? "active" : null);
            return "<a class=\"icon-{$icon} radius {$active}\" href=\"dash.php?app={$href}\">{$title}</a>";
        };

        echo $nav("comments-o", "faqs/home", "FAQs");
        ?>
    </nav>
</div>