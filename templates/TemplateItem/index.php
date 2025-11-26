<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\TemplateItem> $templateItem
 */
?>
<div class="templateItem index content">
    <?= $this->Html->link(__('New Template Item'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Template Items') ?></h3>

    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= __('Checklist Template') ?></th>
                    <th><?= __('Item Master') ?></th>
                    <th><?= $this->Paginator->sort('item_master_version') ?></th>
                    <th><?= $this->Paginator->sort('ordem') ?></th>
                    <th><?= $this->Paginator->sort('required') ?></th>
                    <th><?= $this->Paginator->sort('created_at') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($templateItem as $item): ?>
                <tr>
                    <td><?= h($item->id) ?></td>

                    <!-- CHECKLIST TEMPLATE -->
                    <td>
                        <?php if ($item->checklist_template): ?>
                            <?= $this->Html->link(
                                h($item->checklist_template->name),
                                ['controller' => 'ChecklistTemplate', 'action' => 'view', $item->checklist_template->id]
                            ) ?>
                        <?php endif; ?>
                    </td>

                    <!-- ITEM MASTER -->
                    <td>
                        <?php if ($item->item_master): ?>
                            <?= $this->Html->link(
                                h($item->item_master->name ?? $item->item_master->title ?? '[sem nome]'),
                                ['controller' => 'ItemMaster', 'action' => 'view', $item->item_master->id]
                            ) ?>
                        <?php endif; ?>
                    </td>

                    <td><?= $item->item_master_version === null ? '' : h($item->item_master_version) ?></td>
                    <td><?= h($item->ordem) ?></td>
                    <td><?= $item->required ? __('Yes') : __('No') ?></td>
                    <td><?= h($item->created_at) ?></td>

                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $item->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $item->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $item->id],
                            [
                                'confirm' => __('Are you sure you want to delete # {0}?', $item->id),
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

        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} of {{count}} total')) ?></p>
    </div>
</div>
