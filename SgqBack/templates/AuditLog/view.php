<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AuditLog $auditLog
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Audit Log'), ['action' => 'edit', $auditLog->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Audit Log'), ['action' => 'delete', $auditLog->id], ['confirm' => __('Are you sure you want to delete # {0}?', $auditLog->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Audit Log'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Audit Log'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="auditLog view content">
            <h3><?= h($auditLog->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= h($auditLog->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Entity Type') ?></th>
                    <td><?= h($auditLog->entity_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Entity Id') ?></th>
                    <td><?= h($auditLog->entity_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $auditLog->hasValue('user') ? $this->Html->link($auditLog->user->nome, ['controller' => 'UserAccount', 'action' => 'view', $auditLog->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Action') ?></th>
                    <td><?= h($auditLog->action) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created At') ?></th>
                    <td><?= h($auditLog->created_at) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Delta') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($auditLog->delta)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>