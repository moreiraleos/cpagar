<?php require __DIR__ . "/sidebar.php"; ?>

<section class="dash_content_app">
    <header class="dash_content_app_header">
        <h2 class="icon-flag">Planos</h2>
        <a class="icon-plus-circle btn btn-green" href="dash.php?app=control/plan-create">Novo Plano</a>
    </header>

    <div class="dash_content_app_box">
        <section class="app_control_plans">
            <?php for ($i = 0; $i < 4; $i++): ?>
                <article class="radius">
                    <div>
                        <h4 class="icon-flag">PLAN NAME</h4>
                        <p><b>Assinantes:</b> 224</p>
                        <p><b>Recorrência:</b> R$ 1.120,00</p>
                    </div>

                    <div>
                        <p><b>Período:</b> Mês</p>
                        <p><b>Preço:</b> R$ 5,00</p>
                        <p><b>Status:</b> Ativo</p>
                    </div>

                    <div class="actions">
                        <a class="icon-pencil btn btn-blue" href="" title="">Editar</a>
                        <a class="icon-ban btn btn-yellow" href="" title="">Desativar</a>
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