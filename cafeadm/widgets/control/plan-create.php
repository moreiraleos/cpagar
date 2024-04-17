<?php require __DIR__ . "/sidebar.php"; ?>

<section class="dash_content_app">
    <header class="dash_content_app_header">
        <h2 class="icon-plus-circle">Novo Plano</h2>
    </header>

    <div class="dash_content_app_box">
        <form class="app_form" action="" method="post">
            <label class="label">
                <span class="legend">*Plano:</span>
                <input type="text" name="name" placeholder="Nome do plano" required/>
            </label>

            <div class="label_g2">
                <label class="label">
                    <span class="legend">*Preço:</span>
                    <input class="mask-money"  type="text" name="price" required/>
                </label>

                <label class="label">
                    <span class="legend">*Status:</span>
                    <select name="status" required>
                        <option value="active">Ativa</option>
                        <option value="inactive">Inativa</option>
                    </select>
                </label>
            </div>

            <div class="label_g2">
                <label class="label">
                    <span class="legend">*Período:</span>
                    <select name="period" required>
                        <option value="1month">Mensal</option>
                        <option value="1year">Anual</option>
                    </select>
                </label>

                <label class="label">
                    <span class="legend">*Inf. de período:</span>
                    <select name="period_str" required>
                        <option value="mês">Mês</option>
                        <option value="ano">Ano</option>
                    </select>
                </label>
            </div>

            <div class="al-right">
                <button class="btn btn-green icon-check-square-o">Criar Plano</button>
            </div>
        </form>
    </div>
</section>