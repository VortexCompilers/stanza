<?php
/**
 * Register pop-up.
 * Optionals variables writed by who include this file:
 *   $erroRegister    —   error message to show in the pop-up (if any)
 *   $registerAberto  — true to open the pop-up, false to keep it closed
 */
require_once __DIR__ . '/../lang/load.php';

$erroRegister = $erroRegister ?? '';
$registerAberto = $registerAberto ?? false;
?>
<div class="modal <?= $registerAberto ? 'is-open' : '' ?>" id="modalRegister" role="dialog" aria-modal="true" aria-labelledby="tituloRegister">

    <form class="modal-card" action="/stanza/backend/register.php" method="POST">

        <div class="modal-head">
            <h1 id="tituloRegister"><?= translator('auth_register_title') ?></h1>
            <a class="modal-close" href="landing.php" data-fechar aria-label="<?= translator('action_close') ?>">&times;</a>
        </div>


        <div class="modal-body">

            <?php if (!empty($erroRegister)): ?>
                <div class="erro">
                    <?= $erroRegister // already HTML-safe: comes from translator() ?>
                </div>
            <?php endif; ?>

            <h2 class="modal-section"><?= translator('auth_register_section_details') ?></h2>

            <div class="field">
                <label for="registerName"><?= translator('auth_field_name') ?></label>
                <input type="text" id="registerName" name="username" autocomplete="nickname">
            </div>

            <div class="field-row">
                <div class="field">
                    <label for="registerGender"><?= translator('auth_field_gender') ?></label>
                    <select id="registerGender" name="gender">
                        <option value=""><?= translator('gender_select') ?></option>
                        <option value="male"><?= translator('gender_male') ?></option>
                        <option value="female"><?= translator('gender_female') ?></option>
                        <option value="other"><?= translator('gender_other') ?></option>
                    </select>
                </div>

                <div class="field">
                    <label for="registerBirthdate"><?= translator('auth_field_birthdate') ?></label>
                    <input type="date" id="registerBirthdate" name="birthdate">
                </div>
            </div>

            <h2 class="modal-section"><?= translator('auth_register_section_access') ?></h2>

            <div class="field">
                <label for="registerEmail"><?= translator('auth_field_email') ?></label>
                <input type="text" id="registerEmail" name="email" autocomplete="email">
            </div>

            <div class="field">
                <label for="registerPassword"><?= translator('auth_field_password') ?></label>
                <input type="password" id="registerPassword" name="password" autocomplete="new-password">
            </div>

            <a class="modal-link" href="login.php" data-trocar="modalLogin"><?= translator('auth_link_have_account') ?></a>

        </div>


        <div class="modal-foot">
            <a class="btn-ghost" href="landing.php" data-fechar><?= translator('action_cancel') ?></a>
            <button class="btn-primary" type="submit"><?= translator('auth_submit_register') ?></button>
        </div>

    </form>

</div>
