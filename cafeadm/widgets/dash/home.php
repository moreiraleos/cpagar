<?php require __DIR__ . "/sidebar.php"; ?>

<section class="dash_content_app">
    <header class="dash_content_app_header">
        <h2 class="icon-home">Dash</h2>
    </header>

    <div class="dash_content_app_box">
        <section class="app_dash_home_stats">
            <article class="control radius">
                <h4 class="icon-coffee">Control</h4>
                <p><b>Assinantes:</b> 244</p>
                <p><b>Planos:</b> 4</p>
                <p><b>Recorrencia:</b> R$ 20.500,00</p>
            </article>

            <article class="blog radius">
                <h4 class="icon-pencil-square-o">Blog</h4>
                <p><b>Artigos:</b> 112</p>
                <p><b>Rascunhos:</b> 0</p>
                <p><b>Categorias:</b> 4</p>
            </article>

            <article class="users radius">
                <h4 class="icon-user">Usuários</h4>
                <p><b>Usuários:</b> 455</p>
                <p><b>Reg./Conf.:</b> 425/30</p>
                <p><b>Admins:</b> 4</p>
            </article>
        </section>

        <section class="app_dash_home_trafic">
            <h3 class="icon-bar-chart">Online agora: 10</h3>
            <?php for ($i = 0; $i < 10; $i++): ?>
            <article>
                <h4>[20h23 - 21h01] Guest User</h4>
                <p>34 page views</p>
                <p><a target="_blank" href="">/blog/lorem-ipsum-dolor-sit-amet-dolom-lipsum</a> </p>
            </article>
            <?php endfor; ?>
        </section>
    </div>
</section>