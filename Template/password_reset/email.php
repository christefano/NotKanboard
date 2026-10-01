<p><?= t('To reset your password click on this link:') ?></p>

<?php $resetUrl = $this->url->to('PasswordResetController', 'change', array('token' => $token), '', true) ?>
<p><a href="<?= $this->text->e($resetUrl) ?>"><?= $this->text->e($resetUrl) ?></a></p>

<hr>
<?= \Kanboard\Plugin\NotKanboard\Strings::linked('password_reset_sign') ?>
