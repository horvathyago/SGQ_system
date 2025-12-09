<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ChecklistTemplateVersion> $checklistTemplateVersion
 */
?>
<div class="checklistTemplateVersion index content">
    <?= $this->Html->link(__('New Checklist Template Version'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Checklist Template Version') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('checklist_template_id') ?></th>
                    <th><?= $this->Paginator->sort('versao') ?></th>
                    <th><?= $this->Paginator->sort('created_at') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($checklistTemplateVersion as $checklistTemplateVersion): ?>
                <tr>
                    <td><?= h($checklistTemplateVersion->id) ?></td>
                    <td><?= $checklistTemplateVersion->hasValue('checklist_template') ? $this->Html->link($checklistTemplateVersion->checklist_template->name, ['controller' => 'ChecklistTemplate', 'action' => 'view', $checklistTemplateVersion->checklist_template->id]) : '' ?></td>
                    <td><?= $this->Number->format($checklistTemplateVersion->versao) ?></td>
                    <td><?= h($checklistTemplateVersion->created_at) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $checklistTemplateVersion->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $checklistTemplateVersion->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $checklistTemplateVersion->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $checklistTemplateVersion->id),
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