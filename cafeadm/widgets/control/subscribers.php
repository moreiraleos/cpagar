<?php require __DIR__ . "/sidebar.php"; ?>

<section class="dash_content_app">
    <header class="dash_content_app_header">
        <h2 class="icon-heartbeat">Assinantes</h2>
        <form action="" class="app_search_form">
            <input type="text" name="s" placeholder="Pesquisar Assinante:">
            <button class="icon-search icon-notext"></button>
        </form>
    </header>

    <div class="dash_content_app_box">
        <section class="app_control_subscribers">
            <?php for ($i = 0; $i < 12; $i++): ?>
                <article class="subscriber radius">
                    <div class="cover"></div>
                    <h4>Robson V. Leite</h4>
                    <p class="email">cursos@upinside.com.br</p>
                    <p class="info">Assinante do plano PRO (R$ 5,00/mês) desde 22.04.2019</p>
                    <div class="actions">
                        <a class="icon-cog btn btn-blue" href="dash.php?app=control/subscriber&s=22" title="">Gerenciar</a>
                    </div>
                </article>
            <?php endfor; ?>

            <nav class="paginator">
                <a class="paginator_item" title="Primeira página" href="">&lt;&lt;</a>
                <span class="paginator_item paginator_active">1</span>
                <a class="paginator_item" title="Página 2" href="">2</a>
                <a class="paginator_item" title="Página 3" href="">3</a>
                <a class="paginator_item" title="Página 4" href="">4</a>
                <a class="paginator_item" title="Última página" href="">&gt;&gt;</a>
            </nav>
        </section>
    </div>
</section>