<?php require __DIR__ . "/sidebar.php"; ?>

<section class="dash_content_app">
    <header class="dash_content_app_header">
        <h2 class="icon-pencil-square-o">Categorias</h2>
        <a class="icon-plus-circle btn btn-green" href="dash.php?app=blog/category-create">Nova Categoria</a>
    </header>

    <div class="dash_content_app_box">
        <section class="app_blog_categories">
            <?php for ($i = 0; $i < 5; $i++): ?>
                <article class="radius">
                    <div class="thumb">
                        <div class="cover embed radius"></div>
                    </div>
                    <div class="info">
                        <h3 class="title">Finanças [ <b>23 artigos aqui</b> ]</h3>
                        <p class="desc">Dicas e sacadas sobre como controlar suas contas com CaféControl. Vamos tomar um
                            ótimo café?</p>

                        <div class="actions">
                            <a class="icon-pencil btn btn-blue" href="" title="">Editar</a>
                            <a class="icon-trash-o btn btn-red" href="" title="">Deletar</a>
                        </div>
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