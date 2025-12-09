<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ChecklistTemplate> $checklistTemplate
 */
?>
<div class="checklistTemplate index content">
    <?= $this->Html->link(__('New Checklist Template'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Checklist Template') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('tipo') ?></th>
                    <th><?= $this->Paginator->sort('is_active') ?></th>
                    <th><?= $this->Paginator->sort('created_at') ?></th>
                    <th><?= $this->Paginator->sort('updated_at') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($checklistTemplate as $checklistTemplate): ?>
                <tr>
                    <td><?= h($checklistTemplate->id) ?></td>
                    <td><?= h($checklistTemplate->name) ?></td>
                    <td><?= h($checklistTemplate->tipo) ?></td>
                    <td><?= h($checklistTemplate->is_active) ?></td>
                    <td><?= h($checklistTemplate->created_at) ?></td>
                    <td><?= h($checklistTemplate->updated_at) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $checklistTemplate->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $checklistTemplate->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $checklistTemplate->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $checklistTemplate->id),
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