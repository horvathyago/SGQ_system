<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\AuditLog> $auditLog
 */
?>
<div class="auditLog index content">
    <?= $this->Html->link(__('New Audit Log'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Audit Log') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('entity_type') ?></th>
                    <th><?= $this->Paginator->sort('entity_id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('action') ?></th>
                    <th><?= $this->Paginator->sort('created_at') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($auditLog as $auditLog): ?>
                <tr>
                    <td><?= h($auditLog->id) ?></td>
                    <td><?= h($auditLog->entity_type) ?></td>
                    <td><?= h($auditLog->entity_id) ?></td>
                    <td><?= $auditLog->hasValue('user') ? $this->Html->link($auditLog->user->nome, ['controller' => 'UserAccount', 'action' => 'view', $auditLog->user->id]) : '' ?></td>
                    <td><?= h($auditLog->action) ?></td>
                    <td><?= h($auditLog->created_at) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $auditLog->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $auditLog->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $auditLog->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $auditLog->id),
                            ]
                        ) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>