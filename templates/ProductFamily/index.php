<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ProductFamily> $productFamily
 */
?>
<div class="productFamily index content">
    <?= $this->Html->link(__('New Product Family'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Product Family') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('codigo') ?></th>
                    <th><?= $this->Paginator->sort('nome') ?></th>
                    <th><?= $this->Paginator->sort('created_at') ?></th>
                    <th><?= $this->Paginator->sort('updated_at') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productFamily as $productFamily): ?>
                <tr>
                    <td><?= h($productFamily->id) ?></td>
                    <td><?= h($productFamily->codigo) ?></td>
                    <td><?= h($productFamily->nome) ?></td>
                    <td><?= h($productFamily->created_at) ?></td>
                    <td><?= h($productFamily->updated_at) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $productFamily->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $productFamily->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $productFamily->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $productFamily->id),
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