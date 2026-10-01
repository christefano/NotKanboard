<p>
    <?= $this->text->e(\Kanboard\Plugin\NotKanboard\Strings::get('invite_text')) ?>
</p>

<p>
    <?= $this->url->absoluteLink($this->text->e(\Kanboard\Plugin\NotKanboard\Strings::get('invite_link')), 'UserInviteController', 'signup', array('token' => $token)) ?>
</p>

<?php if ($this->app->config('application_url')): ?>
    <hr>
    <a href="<?= $this->text->e($this->app->config('application_url')) ?>"><?= $this->text->e(\Kanboard\Plugin\NotKanboard\Strings::get('invite_footer_link')) ?></a>
<?php endif ?>
