<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $consecutivodebito->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $consecutivodebito->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Consecutivodebitos'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="consecutivodebitos form large-9 medium-8 columns content">
    <?= $this->Form->create($consecutivodebito) ?>
    <fieldset>
        <legend><?= __('Edit Consecutivodebito') ?></legend>
        <?php
            echo $this->Form->input('usuario_solicitante');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
