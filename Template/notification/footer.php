<hr/>
<?= \Kanboard\Plugin\NotKanboard\Strings::linked('footer_name') ?>

<?php if ($this->app->config('application_url') != ''): ?>
    <?php if (isset($task['id'])): ?>
        - <?= $this->url->absoluteLink($this->text->e(\Kanboard\Plugin\NotKanboard\Strings::get('footer_task_link')), 'TaskViewController', 'show', array('task_id' => $task['id'])) ?>
    <?php endif ?>
    <?php if (isset($task['project_id'])): ?>
        - <?= $this->url->absoluteLink($this->text->e(\Kanboard\Plugin\NotKanboard\Strings::get('footer_board_link')), 'BoardViewController', 'show', array('project_id' => $task['project_id'])) ?>
    <?php endif ?>
<?php endif ?>
