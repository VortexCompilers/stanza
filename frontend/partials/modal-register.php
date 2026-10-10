<?php
/**
 * Register pop-up.
 * Optionals variables writed by who include this file:
 *   $erroRegister      —   error message to show in the pop-up (if any)
 *   $registerAberto    — true to open the pop-up, false to keep it closed
 *   $registerStartStep — 1 or 2, which step to show first (2 when reopening
 *                         after a backend error about the avatar upload)
 */
require_once __DIR__ . '/../lang/load.php';

$erroRegister = $erroRegister ?? '';
$registerAberto = $registerAberto ?? false;
$registerStartStep = $registerStartStep ?? 1;
?>
<div class="modal <?= $registerAberto ? 'is-open' : '' ?>" id="modalRegister" role="dialog" aria-modal="true" aria-labelledby="tituloRegister">

    <form class="modal-card" action="/stanza/backend/register.php" method="POST" enctype="multipart/form-data" data-start-step="<?= (int) $registerStartStep ?>">

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

            <div class="modal-step" data-step="1">

                <h2 class="modal-section"><?= translator('auth_register_section_details') ?></h2>

                <div class="field">
                    <label for="registerName"><?= translator('auth_field_name') ?></label>
                    <input type="text" id="registerName" name="username" autocomplete="nickname" required>
                </div>

                <div class="field-row">
                    <div class="field">
                        <label for="registerGender"><?= translator('auth_field_gender') ?></label>
                        <select id="registerGender" name="gender" required>
                            <option value=""><?= translator('gender_select') ?></option>
                            <option value="male"><?= translator('gender_male') ?></option>
                            <option value="female"><?= translator('gender_female') ?></option>
                            <option value="other"><?= translator('gender_other') ?></option>
                        </select>
                    </div>

                    <div class="field">
                        <label for="registerBirthdate"><?= translator('auth_field_birthdate') ?></label>
                        <input type="date" id="registerBirthdate" name="birthdate" required>
                    </div>
                </div>

                <h2 class="modal-section"><?= translator('auth_register_section_access') ?></h2>

                <div class="field">
                    <label for="registerEmail"><?= translator('auth_field_email') ?></label>
                    <input type="text" id="registerEmail" name="email" autocomplete="email" required>
                </div>

                <div class="field">
                    <label for="registerPassword"><?= translator('auth_field_password') ?></label>
                    <input type="password" id="registerPassword" name="password" autocomplete="new-password" required>
                </div>

                <a class="modal-link" href="login.php" data-trocar="modalLogin"><?= translator('auth_link_have_account') ?></a>

            </div>

            <div class="modal-step" data-step="2">

                <div class="field">
                    <label for="registerAvatar"><?= translator('settings_profile_picture') ?></label>
                    <input type="file" id="registerAvatar" name="avatar_image" accept="image/png,image/jpeg,image/webp">
                </div>

            </div>

        </div>


        <div class="modal-foot">
            <a class="btn-ghost" href="landing.php" data-fechar data-step="1"><?= translator('action_cancel') ?></a>
            <button class="btn-primary" type="button" data-step="1" data-goto="2" hidden><?= translator('action_next') ?></button>
            <button class="btn-primary" type="submit" data-step="2"><?= translator('auth_submit_register') ?></button>
        </div>

    </form>

</div>

<script>
(function () {
    var modal = document.getElementById('modalRegister');
    if (!modal) return;

    var form = modal.querySelector('form');
    if (!form) return;

    var steps = form.querySelectorAll('.modal-step');
    var footControls = form.querySelectorAll('.modal-foot [data-step]');

    function showStep(step) {
        steps.forEach(function (el) {
            el.hidden = el.dataset.step !== step;
        });
        footControls.forEach(function (el) {
            el.hidden = el.dataset.step !== step;
        });
    }

    function stepIsValid(step) {
        var valid = true;

        form.querySelectorAll('.modal-step[data-step="' + step + '"] input, .modal-step[data-step="' + step + '"] select').forEach(function (field) {
            if (valid && !field.checkValidity()) {
                field.reportValidity();
                valid = false;
            }
        });

        return valid;
    }

    form.querySelectorAll('[data-goto]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            if (!stepIsValid(btn.dataset.step)) return;
            showStep(btn.dataset.goto);
        });
    });

    // Reopening the pop-up (close button, backdrop click, Escape — all handled
    // by js/modal.js) always goes back to step 1, unless the backend sent us
    // straight to step 2 (see $registerStartStep above).
    modal.addEventListener('click', function (evento) {
        if (evento.target.closest('[data-fechar]') || evento.target === modal) {
            showStep('1');
        }
    });

    showStep(form.dataset.startStep || '1');
})();
</script>
