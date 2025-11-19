<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ProductFamilyChecklist> $productFamilyChecklist
 */
?>
<div class="productFamilyChecklist index content">
    <?= $this->Html->link(__('New Product Family Checklist'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Product Family Checklist') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('product_family_id') ?></th>
                    <th><?= $this->Paginator->sort('checklist_template_id') ?></th>
                    <th><?= $this->Paginator->sort('tipo') ?></th>
                    <th><?= $this->Paginator->sort('created_at') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productFamilyChecklist as $productFamilyChecklist): ?>
                <tr>
                    <td><?= h($productFamilyChecklist->id) ?></td>
                    <td><?= $productFamilyChecklist->hasValue('product_family') ? $this->Html->link($productFamilyChecklist->product_family->codigo, ['controller' => 'ProductFamily', 'action' => 'view', $productFamilyChecklist->product_family->id]) : '' ?></td>
                    <td><?= $productFamilyChecklist->hasValue('checklist_template') ? $this->Html->link($productFamilyChecklist->checklist_template->name, ['controller' => 'ChecklistTemplate', 'action' => 'view', $productFamilyChecklist->checklist_template->id]) : '' ?></td>
                    <td><?= h($productFamilyChecklist->tipo) ?></td>
                    <td><?= h($productFamilyChecklist->created_at) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $productFamilyChecklist->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $productFamilyChecklist->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $productFamilyChecklist->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $productFamilyChecklist->id),
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