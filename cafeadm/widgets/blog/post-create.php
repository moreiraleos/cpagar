<?php require __DIR__ . "/sidebar.php"; ?>

<section class="dash_content_app">
    <header class="dash_content_app_header">
        <h2 class="icon-plus-circle">Novo Artigo</h2>
    </header>

    <div class="dash_content_app_box">
        <form class="app_form" action="" method="post">
            <label class="label">
                <span class="legend">*Título:</span>
                <input type="text" name="title" placeholder="A manchete do seu artigo" required/>
            </label>

            <label class="label">
                <span class="legend">*Subtítulo:</span>
                <textarea name="subtitle" placeholder="O texto de apoio da manchete" required></textarea>
            </label>

            <label class="label">
                <span class="legend">Capa: (1920x1080px)</span>
                <input type="file" name="cover" placeholder="Uma imagem de capa"/>
            </label>

            <label class="label">
                <span class="legend">Vídeo:</span>
                <input type="text" name="video" placeholder="O ID de um vídeo do YouTube"/>
            </label>

            <label class="label">
                <span class="legend">*Conteúdo:</span>
                <textarea class="mce" name="content"></textarea>
            </label>

            <div class="label_g2">
                <label class="label">
                    <span class="legend">*Categoria:</span>
                    <select name="category" required>
                        <option value="ID">Option</option>
                        <option value="ID">Option</option>
                        <option value="ID">Option</option>
                    </select>
                </label>

                <label class="label">
                    <span class="legend">*Autor:</span>
                    <select name="author" required>
                        <option value="ID">Option</option>
                        <option value="ID">Option</option>
                        <option value="ID">Option</option>
                    </select>
                </label>
            </div>

            <div class="label_g2">
                <label class="label">
                    <span class="legend">*Status:</span>
                    <select name="status" required>
                        <option value="post">Publicar</option>
                        <option value="draft">Rascunho</option>
                        <option value="trash">Lixo</option>
                    </select>
                </label>

                <label class="label">
                    <span class="legend">Data de publicação:</span>
                    <input class="mask-datetime" type="text" name="post_at" value="<?= date("d/m/Y H:i"); ?>" required/>
                </label>
            </div>

            <div class="al-right">
                <button class="btn btn-green icon-check-square-o">Publicar</button>
            </div>
        </form>
    </div>
</section>