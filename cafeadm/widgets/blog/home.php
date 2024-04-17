<?php require __DIR__ . "/sidebar.php"; ?>

<section class="dash_content_app">
    <header class="dash_content_app_header">
        <h2 class="icon-pencil-square-o">Blog</h2>
    </header>

    <div class="dash_content_app_box">
        <section class="app_blog_home">
            <?php for ($i = 0; $i < 12; $i++): ?>
                <article>
                    <div class="cover embed radius"></div>
                    <h3 class="tittle">
                        <a target="_blank" href="../">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</a>
                    </h3>

                    <div class="info">
                        <p class="icon-clock-o">22.10.19 às 14h22</p>
                        <p class="icon-bookmark">Fincanças</p>
                        <p class="icon-user">Robson V. Leite</p>
                        <p class="icon-bar-chart">22580</p>
                    </div>

                    <div class="actions">
                        <a class="icon-pencil btn btn-blue" href="" title="">Editar</a>
                        <a class="icon-trash-o btn btn-red" href="" title="">Deletar</a>
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