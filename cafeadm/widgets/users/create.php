<?php require __DIR__ . "/sidebar.php"; ?>

<section class="dash_content_app">
    <header class="dash_content_app_header">
        <h2 class="icon-plus-circle">Novo Usuário</h2>
    </header>

    <div class="dash_content_app_box">
        <form class="app_form" action="" method="post">
            <div class="label_g2">
                <label class="label">
                    <span class="legend">*Nome:</span>
                    <input type="text" name="first_name" placeholder="Primeiro nome" required/>
                </label>

                <label class="label">
                    <span class="legend">*Sobrenome:</span>
                    <input type="text" name="last_name" placeholder="Último nome" required/>
                </label>
            </div>

            <label class="label">
                <span class="legend">Genero:</span>
                <select name="genre">
                    <option value="male">Masculino</option>
                    <option value="female">Feminino</option>
                    <option value="other">Outros</option>
                </select>
            </label>

            <label class="label">
                <span class="legend">Foto: (600x600px)</span>
                <input type="file" name="photo"/>
            </label>

            <div class="label_g2">
                <label class="label">
                    <span class="legend">Nascimento:</span>
                    <input type="text" class="mask-date" name="last_name" placeholder="dd/mm/yyyy"/>
                </label>

                <label class="label">
                    <span class="legend">Documento:</span>
                    <input class="mask-doc" type="text" name="document" placeholder="CPF do usuário"/>
                </label>
            </div>

            <div class="label_g2">
                <label class="label">
                    <span class="legend">*E-mail:</span>
                    <input type="email" name="email" placeholder="Melhor e-mail" required/>
                </label>

                <label class="label">
                    <span class="legend">*Senha:</span>
                    <input type="password" name="password" placeholder="Senha de acesso" required/>
                </label>
            </div>

            <label class="label">
                <span class="legend">*Status:</span>
                <select name="status" required>
                    <option value="registered">Registrado</option>
                    <option value="confirmed">Confirmado</option>
                </select>
            </label>

            <div class="al-right">
                <button class="btn btn-green icon-check-square-o">Criar Usuário</button>
            </div>
        </form>
    </div>
</section>