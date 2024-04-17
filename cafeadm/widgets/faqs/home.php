<?php require __DIR__ . "/sidebar.php"; ?>

<section class="dash_content_app">
    <header class="dash_content_app_header">
        <h2 class="icon-comments-o">FAQs</h2>
        <a class="icon-plus-circle btn btn-green" href="dash.php?app=faqs/channel-create">Novo Canal</a>
    </header>

    <div class="dash_content_app_box">
        <section class="app_faqs_home">
            <?php for ($i = 0; $i < 6; $i++): ?>
                <article class="radius">
                    <header>
                        <h3>Sobre o CaféControl</h3>
                        <p>Saiba mais sobre o CaféControl</p>

                        <div>
                            <a href=""
                               class="icon-pencil btn btn-blue">Editar Canal</a>
                        </div>
                        <a href="dash.php?app=faqs/question-create&channel=33"
                           class="icon-plus-circle btn btn-green">Nova Pergunta</a>
                    </header>
                    <div>
                        <?php
                        $edit = function ($id) {
                            return "<a href=\"\" class=\"btn btn-blue icon-pencil icon-notext\"></a>";
                        };
                        ?>
                        <div class="question radius"><?= $edit(25); ?> - O CaféControl é gratuito?</div>
                        <div class="question radius"><?= $edit(25); ?> - O que fazer com o CaféControl?</div>
                        <div class="question radius"><?= $edit(25); ?> - Como usar o CaféControl?</div>
                        <div class="question radius"><?= $edit(25); ?> - De onde surgiu o CaféControl?</div>
                        <div class="question radius"><?= $edit(25); ?> - Sobre a UpInside Treinamentos</div>
                        <div class="question radius"><?= $edit(25); ?> - Ainda com dúvidas?</div>
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