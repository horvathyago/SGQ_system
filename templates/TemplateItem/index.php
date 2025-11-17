<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\TemplateItem> $templateItem
 */
?>
<div class="templateItem index content">
    <?= $this->Html->link(__('New Template Item'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Template Item') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('checklist_template_version_id') ?></th>
                    <th><?= $this->Paginator->sort('item_master_id') ?></th>
                    <th><?= $this->Paginator->sort('item_master_version') ?></th>
                    <th><?= $this->Paginator->sort('ordem') ?></th>
                    <th><?= $this->Paginator->sort('required') ?></th>
                    <th><?= $this->Paginator->sort('created_at') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($templateItem as $templateItem): ?>
                <tr>
                    <td><?= h($templateItem->id) ?></td>
                    <td><?= $templateItem->hasValue('checklist_template_version') ? $this->Html->link($templateItem->checklist_template_version->id, ['controller' => 'ChecklistTemplateVersions', 'action' => 'view', $templateItem->checklist_template_version->id]) : '' ?></td>
                    <td><?= $templateItem->hasValue('item_master') ? $this->Html->link($templateItem->item_master->codigo_item, ['controller' => 'ItemMaster', 'action' => 'view', $templateItem->item_master->id]) : '' ?></td>
                    <td><?= $templateItem->item_master_version === null ? '' : $this->Number->format($templateItem->item_master_version) ?></td>
                    <td><?= $this->Number->format($templateItem->ordem) ?></td>
                    <td><?= h($templateItem->required) ?></td>
                    <td><?= h($templateItem->created_at) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $templateItem->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $templateItem->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $templateItem->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $templateItem->id),
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