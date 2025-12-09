<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\MrbAction> $mrbAction
 */
?>
<div class="mrbAction index content">
    <?= $this->Html->link(__('New Mrb Action'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Mrb Action') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('non_conformity_id') ?></th>
                    <th><?= $this->Paginator->sort('decisao') ?></th>
                    <th><?= $this->Paginator->sort('responsavel_id') ?></th>
                    <th><?= $this->Paginator->sort('created_at') ?></th>
                    <th><?= $this->Paginator->sort('updated_at') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($mrbAction as $mrbAction): ?>
                <tr>
                    <td><?= h($mrbAction->id) ?></td>
                    <td><?= $mrbAction->hasValue('non_conformity') ? $this->Html->link($mrbAction->non_conformity->id, ['controller' => 'NonConformity', 'action' => 'view', $mrbAction->non_conformity->id]) : '' ?></td>
                    <td><?= h($mrbAction->decisao) ?></td>
                    <td><?= $mrbAction->hasValue('responsavel') ? $this->Html->link($mrbAction->responsavel->nome, ['controller' => 'UserAccount', 'action' => 'view', $mrbAction->responsavel->id]) : '' ?></td>
                    <td><?= h($mrbAction->created_at) ?></td>
                    <td><?= h($mrbAction->updated_at) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $mrbAction->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $mrbAction->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $mrbAction->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $mrbAction->id),
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