<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ProcessIndex> $processIndex
 */
?>
<div class="processIndex index content">
    <?= $this->Html->link(__('New Process Index'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Process Index') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('periodo') ?></th>
                    <th><?= $this->Paginator->sort('indicador') ?></th>
                    <th><?= $this->Paginator->sort('product_family_id') ?></th>
                    <th><?= $this->Paginator->sort('valor') ?></th>
                    <th><?= $this->Paginator->sort('unidade') ?></th>
                    <th><?= $this->Paginator->sort('created_at') ?></th>
                    <th><?= $this->Paginator->sort('updated_at') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($processIndex as $processIndex): ?>
                <tr>
                    <td><?= h($processIndex->id) ?></td>
                    <td><?= h($processIndex->periodo) ?></td>
                    <td><?= h($processIndex->indicador) ?></td>
                    <td><?= $processIndex->hasValue('product_family') ? $this->Html->link($processIndex->product_family->codigo, ['controller' => 'ProductFamily', 'action' => 'view', $processIndex->product_family->id]) : '' ?></td>
                    <td><?= $processIndex->valor === null ? '' : $this->Number->format($processIndex->valor) ?></td>
                    <td><?= h($processIndex->unidade) ?></td>
                    <td><?= h($processIndex->created_at) ?></td>
                    <td><?= h($processIndex->updated_at) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $processIndex->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $processIndex->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $processIndex->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $processIndex->id),
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