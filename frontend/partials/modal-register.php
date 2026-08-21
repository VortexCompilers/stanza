<?php
/**
 * Pop-up de cadastro.
 * Variáveis opcionais definidas por quem inclui o arquivo:
 *   $erroRegister    — mensagem de erro a exibir
 *   $registerAberto  — true para já abrir o pop-up (páginas avulsas)
 */
$erroRegister = $erroRegister ?? '';
$registerAberto = $registerAberto ?? false;
?>
<div class="modal <?= $registerAberto ? 'is-open' : '' ?>" id="modalRegister" role="dialog" aria-modal="true" aria-labelledby="tituloRegister">

    <form class="modal-card" action="/stanza/backend/register.php" method="POST">

        <div class="modal-head">
            <h1 id="tituloRegister">Criar conta</h1>
            <a class="modal-close" href="landing.php" data-fechar aria-label="Fechar">&times;</a>
        </div>


        <div class="modal-body">

            <?php if (!empty($erroRegister)): ?>
                <div class="erro">
                    <?= htmlspecialchars($erroRegister) ?>
                </div>
            <?php endif; ?>

            <h2 class="modal-section">Seus dados</h2>

            <div class="field">
                <label for="registerName">Nome</label>
                <input type="text" id="registerName" name="username" autocomplete="nickname">
            </div>

            <div class="field-row">
                <div class="field">
                    <label for="registerGender">Gênero</label>
                    <select id="registerGender" name="gender">
                        <option value="">Selecione</option>
                        <option value="male">Masculino</option>
                        <option value="female">Feminino</option>
                        <option value="other">Outro</option>
                    </select>
                </div>

                <div class="field">
                    <label for="registerBirthdate">Data de nascimento</label>
                    <input type="date" id="registerBirthdate" name="birthdate">
                </div>
            </div>

            <h2 class="modal-section">Acesso</h2>

            <div class="field">
                <label for="registerEmail">E-mail</label>
                <input type="text" id="registerEmail" name="email" autocomplete="email">
            </div>

            <div class="field">
                <label for="registerPassword">Senha</label>
                <input type="password" id="registerPassword" name="password" autocomplete="new-password">
            </div>

            <a class="modal-link" href="login.php" data-trocar="modalLogin">Já tenho conta</a>

        </div>


        <div class="modal-foot">
            <a class="btn-ghost" href="landing.php" data-fechar>Cancelar</a>
            <button class="btn-primary" type="submit">Concluir cadastro</button>
        </div>

    </form>

</div>
