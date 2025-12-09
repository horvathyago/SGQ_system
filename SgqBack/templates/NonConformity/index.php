<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\NonConformity> $nonConformity
 */
?>
<div class="nonConformity index content">
    <?= $this->Html->link(__('New Non Conformity'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Non Conformity') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('inspection_item_id') ?></th>
                    <th><?= $this->Paginator->sort('severity') ?></th>
                    <th><?= $this->Paginator->sort('is_fca_trigger') ?></th>
                    <th><?= $this->Paginator->sort('disposition') ?></th>
                    <th><?= $this->Paginator->sort('responsavel_id') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('created_at') ?></th>
                    <th><?= $this->Paginator->sort('updated_at') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($nonConformity as $nonConformity): ?>
                <tr>
                    <td><?= h($nonConformity->id) ?></td>
                    <td><?= $nonConformity->hasValue('inspection_item') ? $this->Html->link($nonConformity->inspection_item->codigo_item_snapshot, ['controller' => 'InspectionItem', 'action' => 'view', $nonConformity->inspection_item->id]) : '' ?></td>
                    <td><?= h($nonConformity->severity) ?></td>
                    <td><?= h($nonConformity->is_fca_trigger) ?></td>
                    <td><?= h($nonConformity->disposition) ?></td>
                    <td><?= $nonConformity->hasValue('responsavel') ? $this->Html->link($nonConformity->responsavel->nome, ['controller' => 'UserAccount', 'action' => 'view', $nonConformity->responsavel->id]) : '' ?></td>
                    <td><?= h($nonConformity->status) ?></td>
                    <td><?= h($nonConformity->created_at) ?></td>
                    <td><?= h($nonConformity->updated_at) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $nonConformity->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $nonConformity->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $nonConformity->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $nonConformity->id),
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