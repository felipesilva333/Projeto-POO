<main id="login-page">
    <section>
        <div class="container container-centered">
            <form method="post" action="<?= BASE_URL . "verify" ?>" class="delay-small card-form">
                <h2 class="delay-small">Login</h2>

                <div class="form-alert" style="display: none"></div>

                <div class="form-group interval-medium">
                    <label for="username"><i class="bi bi-person-circle"></i>Usuário</label>
                    <input type="text" id="username" name="username" placeholder="Seu nome">                    
                </div>

                <div class="form-group interval-medium">
                    <label for="password"><i class="bi bi-lock"></i>Senha</label>
                    <input type="password" id="password" name="password" placeholder="********">
                </div>

                <button class="btn-primary interval-medium" type="submit" title="Acessar conta">Entrar</button>
                <a href="<?= BASE_URL . "register" ?>" class="interval-medium link-secondary" title="Criar conta">Não possuo conta</a>
            </form>
        </div>
    </section>
</main>