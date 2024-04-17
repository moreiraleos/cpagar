<?php require __DIR__ . "/sidebar.php"; ?>

<section class="dash_content_app">
    <header class="dash_content_app_header">
        <h2 class="icon-plus-circle">Nova Categoria</h2>
    </header>

    <div class="dash_content_app_box">
        <form class="app_form" action="" method="post">
            <label class="label">
                <span class="legend">*Título:</span>
                <input type="text" name="title" placeholder="O nome da categoria" required/>
            </label>

            <label class="label">
                <span class="legend">*Descrição:</span>
                <textarea name="description" placeholder="Sobre esta categoria" required></textarea>
            </label>

            <label class="label">
                <span class="legend">Capa:</span>
                <input type="file" name="cover" placeholder="Uma imagem de capa"/>
            </label>

            <div class="al-right">
                <button class="btn btn-green icon-check-square-o">Criar Categoria</button>
            </div>
        </form>
    </div>
</section>