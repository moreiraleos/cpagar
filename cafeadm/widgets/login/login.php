<div class="login">
    <article class="login_box radius">
        <h1 class="hl icon-coffee">Login</h1>
        <form action="dash.php?app=dash/home" method="post">
            <label>
                <span class="field icon-envelope">E-mail:</span>
                <input type="email" placeholder="Informe seu e-mail" required/>
            </label>

            <label>
                <span class="field icon-unlock-alt">Senha:</span>
                <input type="password" placeholder="Informe sua senha:" required/>
            </label>

            <button class="radius gradient gradient-green gradient-hover icon-sign-in">Entrar</button>
        </form>

        <footer>
            <p>Desenvolvido por www.<b>fsphp</b>.com.br</p>
            <p>&copy; <?= date("Y"); ?> - todos os direitos reservados</p>
            <a target="_blank"
               class="icon-whatsapp transition"
               href="https://api.whatsapp.com/send?phone=554833715879&text=Olá, preciso de ajuda com o login."
            >WhatsApp: (48) 3371 5879</a>
        </footer>
    </article>
</div>