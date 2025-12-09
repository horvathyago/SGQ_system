<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ProductionOrder> $productionOrder
 */
?>
<div class="productionOrder index content">
    <?= $this->Html->link(__('New Production Order'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Production Order') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('numero_op') ?></th>
                    <th><?= $this->Paginator->sort('produto_codigo') ?></th>
                    <th><?= $this->Paginator->sort('product_family_id') ?></th>
                    <th><?= $this->Paginator->sort('lot_code') ?></th>
                    <th><?= $this->Paginator->sort('quantidade_planejada') ?></th>
                    <th><?= $this->Paginator->sort('data_inicio') ?></th>
                    <th><?= $this->Paginator->sort('data_fim') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('created_at') ?></th>
                    <th><?= $this->Paginator->sort('updated_at') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productionOrder as $productionOrder): ?>
                <tr>
                    <td><?= h($productionOrder->id) ?></td>
                    <td><?= h($productionOrder->numero_op) ?></td>
                    <td><?= h($productionOrder->produto_codigo) ?></td>
                    <td><?= $productionOrder->hasValue('product_family') ? $this->Html->link($productionOrder->product_family->codigo, ['controller' => 'ProductFamily', 'action' => 'view', $productionOrder->product_family->id]) : '' ?></td>
                    <td><?= h($productionOrder->lot_code) ?></td>
                    <td><?= $productionOrder->quantidade_planejada === null ? '' : $this->Number->format($productionOrder->quantidade_planejada) ?></td>
                    <td><?= h($productionOrder->data_inicio) ?></td>
                    <td><?= h($productionOrder->data_fim) ?></td>
                    <td><?= h($productionOrder->status) ?></td>
                    <td><?= h($productionOrder->created_at) ?></td>
                    <td><?= h($productionOrder->updated_at) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $productionOrder->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $productionOrder->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $productionOrder->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $productionOrder->id),
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