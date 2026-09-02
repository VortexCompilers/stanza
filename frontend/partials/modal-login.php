<?php
/**
 * Login pop-up.
 * Optionals variables writed by who include this file:
 *   $erroLogin    —   error message to show in the pop-up (if any)
 *   $loginAberto  — true to open the pop-up, false to keep it closed
 */
require_once __DIR__ . '/../lang/load.php';

$erroLogin = $erroLogin ?? '';
$loginAberto = $loginAberto ?? false;
?>
<div class="modal <?= $loginAberto ? 'is-open' : '' ?>" id="modalLogin" role="dialog" aria-modal="true" aria-labelledby="tituloLogin">

    <form class="modal-card" action="/stanza/backend/login.php" method="POST">

        <div class="modal-head">
            <h1 id="tituloLogin"><?= translator('auth_login_title') ?></h1>
            <a class="modal-close" href="landing.php" data-fechar aria-label="<?= translator('action_close') ?>">&times;</a>
        </div>


        <div class="modal-body">

            <?php if (!empty($erroLogin)): ?>
                <div class="erro">
                    <?= $erroLogin // already HTML-safe: comes from translator() ?>
                </div>
            <?php endif; ?>

            <h2 class="modal-section"><?= translator('auth_login_section') ?></h2>

            <div class="field">
                <label for="loginUser"><?= translator('auth_field_email_or_name') ?></label>
                <input type="text" id="loginUser" name="usernameoremail" autocomplete="username">
            </div>

            <div class="field">
                <label for="loginPassword"><?= translator('auth_field_password') ?></label>
                <input type="password" id="loginPassword" name="password" autocomplete="current-password">
            </div>

            <a class="modal-link" href="forgottt"><?= translator('auth_forgot') ?></a>

        </div>


        <div class="modal-foot">
            <a class="btn-ghost" href="landing.php" data-fechar><?= translator('action_cancel') ?></a>
            <button class="btn-primary" type="submit"><?= translator('auth_submit_login') ?></button>
        </div>

    </form>

</div>
