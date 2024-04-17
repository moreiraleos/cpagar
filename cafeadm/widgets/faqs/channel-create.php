<?php require __DIR__ . "/sidebar.php"; ?>

<section class="dash_content_app">
    <header class="dash_content_app_header">
        <h2 class="icon-plus-circle">Novo Canal</h2>
    </header>

    <div class="dash_content_app_box">
        <form class="app_form" action="" method="post">
            <label class="label">
                <span class="legend">*Canal:</span>
                <input type="text" name="channel" placeholder="Nome do canal" required/>
            </label>

            <label class="label">
                <span class="legend">*Descrição:</span>
                <textarea name="description" rows="3" placeholder="Sobre esse canal" required></textarea>
            </label>

            <div class="al-right">
                <button class="btn btn-green icon-check-square-o">Criar Canal</button>
            </div>
        </form>
    </div>
</section>