<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Inspection> $inspection
 */
?>
<div class="inspection index content">
    <?= $this->Html->link(__('New Inspection'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Inspection') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('production_order_id') ?></th>
                    <th><?= $this->Paginator->sort('checklist_template_id') ?></th>
                    <th><?= $this->Paginator->sort('checklist_template_version_id') ?></th>
                    <th><?= $this->Paginator->sort('inspector_id') ?></th>
                    <th><?= $this->Paginator->sort('lot_code') ?></th>
                    <th><?= $this->Paginator->sort('origem') ?></th>
                    <th><?= $this->Paginator->sort('wdl_calculado') ?></th>
                    <th><?= $this->Paginator->sort('wdl_max_utilizado') ?></th>
                    <th><?= $this->Paginator->sort('nota_final') ?></th>
                    <th><?= $this->Paginator->sort('status_final') ?></th>
                    <th><?= $this->Paginator->sort('created_at') ?></th>
                    <th><?= $this->Paginator->sort('updated_at') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($inspection as $inspection): ?>
                <tr>
                    <td><?= h($inspection->id) ?></td>
                    <td><?= $inspection->hasValue('production_order') ? $this->Html->link($inspection->production_order->numero_op, ['controller' => 'ProductionOrder', 'action' => 'view', $inspection->production_order->id]) : '' ?></td>
                    <td><?= $inspection->hasValue('checklist_template') ? $this->Html->link($inspection->checklist_template->name, ['controller' => 'ChecklistTemplate', 'action' => 'view', $inspection->checklist_template->id]) : '' ?></td>
                    <td><?= $inspection->hasValue('checklist_template_version') ? $this->Html->link($inspection->checklist_template_version->id, ['controller' => 'ChecklistTemplateVersions', 'action' => 'view', $inspection->checklist_template_version->id]) : '' ?></td>
                    <td><?= $inspection->hasValue('inspector') ? $this->Html->link($inspection->inspector->nome, ['controller' => 'UserAccount', 'action' => 'view', $inspection->inspector->id]) : '' ?></td>
                    <td><?= h($inspection->lot_code) ?></td>
                    <td><?= h($inspection->origem) ?></td>
                    <td><?= $inspection->wdl_calculado === null ? '' : $this->Number->format($inspection->wdl_calculado) ?></td>
                    <td><?= $inspection->wdl_max_utilizado === null ? '' : $this->Number->format($inspection->wdl_max_utilizado) ?></td>
                    <td><?= $inspection->nota_final === null ? '' : $this->Number->format($inspection->nota_final) ?></td>
                    <td><?= h($inspection->status_final) ?></td>
                    <td><?= h($inspection->created_at) ?></td>
                    <td><?= h($inspection->updated_at) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $inspection->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $inspection->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $inspection->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $inspection->id),
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