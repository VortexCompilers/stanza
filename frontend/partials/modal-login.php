<?php
/**
 * Pop-up de login.
 * Variáveis opcionais definidas por quem inclui o arquivo:
 *   $erroLogin    — mensagem de erro a exibir
 *   $loginAberto  — true para já abrir o pop-up (páginas avulsas)
 */
$erroLogin = $erroLogin ?? '';
$loginAberto = $loginAberto ?? false;
?>
<div class="modal <?= $loginAberto ? 'is-open' : '' ?>" id="modalLogin" role="dialog" aria-modal="true" aria-labelledby="tituloLogin">

    <form class="modal-card" action="/stanza/backend-basico/login.php" method="POST">

        <div class="modal-head">
            <h1 id="tituloLogin">Conectar</h1>
            <a class="modal-close" href="landing.php" data-fechar aria-label="Fechar">&times;</a>
        </div>


        <div class="modal-body">

            <?php if (!empty($erroLogin)): ?>
                <div class="erro">
                    <?= htmlspecialchars($erroLogin) ?>
                </div>
            <?php endif; ?>

            <h2 class="modal-section">Acesso</h2>

            <div class="field">
                <label for="loginUser">E-mail/Nome</label>
                <input type="text" id="loginUser" name="usernameoremail" autocomplete="username">
            </div>

            <div class="field">
                <label for="loginPassword">Senha</label>
                <input type="password" id="loginPassword" name="password" autocomplete="current-password">
            </div>

            <a class="modal-link" href="forgottt">Esqueci meu acesso</a>

        </div>


        <div class="modal-foot">
            <a class="btn-ghost" href="landing.php" data-fechar>Cancelar</a>
            <button class="btn-primary" type="submit">Entrar</button>
        </div>

    </form>

</div>
