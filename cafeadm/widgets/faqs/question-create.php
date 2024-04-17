<?php require __DIR__ . "/sidebar.php"; ?>

<section class="dash_content_app">
    <header class="dash_content_app_header">
        <h2 class="icon-plus-circle">Pergunta em: Sobre o CaféControl</h2>
    </header>

    <div class="dash_content_app_box">
        <form class="app_form" action="" method="post">
            <label class="label">
                <span class="legend">*Pergunta:</span>
                <input type="text" name="question" placeholder="Pergunta frequente" required/>
            </label>

            <label class="label">
                <span class="legend">*Resposta:</span>
                <textarea name="response" rows="3" placeholder="Resolver a pergunta" required></textarea>
            </label>

            <label class="label">
                <span class="legend">*Ordem:</span>
                <input type="number" name="order_by" value="1" required/>
            </label>

            <div class="al-right">
                <button class="btn btn-green icon-check-square-o">Criar FAQ</button>
            </div>
        </form>
    </div>
</section>