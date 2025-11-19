<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AuditLog $auditLog
 * @var \Cake\Collection\CollectionInterface|string[] $users
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Audit Log'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="auditLog form content">
            <?= $this->Form->create($auditLog) ?>
            <fieldset>
                <legend><?= __('Add Audit Log') ?></legend>
                <?php
                    echo $this->Form->control('entity_type');
                    echo $this->Form->control('entity_id');
                    echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
                    echo $this->Form->control('action');
                    echo $this->Form->control('delta');
                    echo $this->Form->control('created_at');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
