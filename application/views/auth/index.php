<?php
use engine\classes\Translate;
?>
<div class="content__info">
    <div class="content__info-text">
        <div class="content__info-text-title"><?= Translate::t('site', 'signup_form_title') ?></div>
        <div class="content__info-description"><?= Translate::t('site', 'signup_form_description') ?></div>
    </div>
</div>
<div class="content__forms">
    <div class="content__forms-block register-form-block">
        <form action="/" class="form register-form" method="post" enctype="multipart/form-data">
            <input type="hidden" name="signup" value="1" />
            <div class="form__item-group<?= !empty($errors['phone']) ? ' error': '' ?>">
                <input type="tel" value="<?= $model->phone ?>" name="User[phone]" placeholder="e.g. +7XXXXXXXXXX" class="form__item input input-text" />
                <span class="form__item-hint"><?= Translate::t('site', 'enter_your_phone_number') ?> <icon class="required"></icon></span>
                <?php if (!empty($errors['phone'])): ?><span class="form__item-error"><?= $errors['phone'][0] ?></span><?php endif; ?>
            </div>
            <div class="form__item-group<?= !empty($errors['email']) ? ' error': '' ?>">
                <input type="email" value="<?= $model->email ?>" name="User[email]" placeholder="e.g. someuser@user.com" class="form__item input input-text" />
                <span class="form__item-hint"><?= Translate::t('site', 'enter_your_email_address') ?> <icon class="required"></icon></span>
                <?php if (!empty($errors['email'])): ?><span class="form__item-error"><?= $errors['email'][0] ?></span><?php endif; ?>
            </div>
            <div class="form__item-group<?= !empty($errors['fullname']) ? ' error': '' ?>">
                <input type="text" value="<?= $model->fullname ?>" name="Profile[fullname]" placeholder="<?= Translate::t('site', 'e.g. Ivanov Ivan') ?>" class="form__item input input-text" />
                <span class="form__item-hint"><?= Translate::t('site', 'enter_your_full_name') ?> <icon class="required"></icon></span>
                <?php if (!empty($errors['fullname'])): ?><span class="form__item-error"><?= $errors['fullname'][0] ?></span><?php endif; ?>
            </div>
            <div class="form__item-group<?= !empty($errors['avatar']) ? ' error': '' ?>">
                <button class="button form__button button-file" ref="avatar" type="button"><?= Translate::t('site', 'choose_your_avatar') ?></button>
                <input type="file" name="User[avatar]" id="avatar" class="form__item input input-file hidden" />
                <span class="form__item-hint"><?= Translate::t('site', 'avatar_file_formats_hint') ?></span>
                <?php if (!empty($errors['avatar'])): ?><span class="form__item-error"><?= $errors['avatar'][0] ?></span><?php endif; ?>
            </div>
            <div class="form__item-group<?= !empty($errors['password']) ? ' error': '' ?>">
                <input type="password" name="User[password]" placeholder="<?= Translate::t('site', 'password') ?>" class="form__item input input-text" id="register_form_password" />
                <span class="form__item-hint"><?= Translate::t('site', 'password_characters_hint') ?> <icon class="required"></icon></span>
                <span class="form__item-hint">(<?= Translate::t('site', 'password_characters_help_text') ?>)</span>
                <?php if (!empty($errors['password'])): ?><span class="form__item-error"><?= $errors['password'][0] ?></span><?php endif; ?>
            </div>
            <div class="form__item-group<?= !empty($errors['confirm_password']) ? ' error': '' ?>">
                <input type="password" name="User[confirm_password]" placeholder="<?= Translate::t('site', 'confirm_password') ?>" class="form__item input input-text" />
                <span class="form__item-hint"><?= Translate::t('site', 'confirm_pass_hint') ?> <icon class="required"></icon></span>
                <?php if (!empty($errors['confirm_password'])): ?><span class="form__item-error"><?= $errors['confirm_password'][0] ?></span><?php endif; ?>
            </div>
            <div class="form__item-group<?= !empty($errors['agreement']) ? ' error': '' ?>">
                <label class="form__item-label">
                    <input type="checkbox" name="User[agreement]" <?= $model->agreement ? ' checked ': '' ?>class="form__item input input-checkbox" />
                    <?= Translate::t('site', 'agreement_hint') ?> <icon class="required"></icon>
                </label>
                <?php if (!empty($errors['agreement'])): ?><span class="form__item-error"><?= $errors['agreement'][0] ?></span><?php endif; ?>
            </div>
            <div class="form__item-group">
                <button class="button form__button" type="submit"><?= Translate::t('site', 'sign_up') ?></button>
            </div>
        </form>
    </div>
</div>