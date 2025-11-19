<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Lot> $lot
 */
?>
<div class="lot index content">
    <?= $this->Html->link(__('New Lot'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Lot') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('lot_code') ?></th>
                    <th><?= $this->Paginator->sort('product_family_id') ?></th>
                    <th><?= $this->Paginator->sort('production_order_id') ?></th>
                    <th><?= $this->Paginator->sort('quantidade') ?></th>
                    <th><?= $this->Paginator->sort('created_at') ?></th>
                    <th><?= $this->Paginator->sort('updated_at') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lot as $lot): ?>
                <tr>
                    <td><?= h($lot->id) ?></td>
                    <td><?= h($lot->lot_code) ?></td>
                    <td><?= $lot->hasValue('product_family') ? $this->Html->link($lot->product_family->codigo, ['controller' => 'ProductFamily', 'action' => 'view', $lot->product_family->id]) : '' ?></td>
                    <td><?= $lot->hasValue('production_order') ? $this->Html->link($lot->production_order->numero_op, ['controller' => 'ProductionOrder', 'action' => 'view', $lot->production_order->id]) : '' ?></td>
                    <td><?= $lot->quantidade === null ? '' : $this->Number->format($lot->quantidade) ?></td>
                    <td><?= h($lot->created_at) ?></td>
                    <td><?= h($lot->updated_at) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $lot->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $lot->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $lot->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $lot->id),
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