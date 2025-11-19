<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\InspectionItem> $inspectionItem
 */
?>
<div class="inspectionItem index content">
    <?= $this->Html->link(__('New Inspection Item'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Inspection Item') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('inspection_id') ?></th>
                    <th><?= $this->Paginator->sort('item_master_id') ?></th>
                    <th><?= $this->Paginator->sort('item_master_version') ?></th>
                    <th><?= $this->Paginator->sort('template_item_id') ?></th>
                    <th><?= $this->Paginator->sort('ordem') ?></th>
                    <th><?= $this->Paginator->sort('codigo_item_snapshot') ?></th>
                    <th><?= $this->Paginator->sort('titulo_snapshot') ?></th>
                    <th><?= $this->Paginator->sort('peso_snapshot') ?></th>
                    <th><?= $this->Paginator->sort('is_fca_snapshot') ?></th>
                    <th><?= $this->Paginator->sort('escopo_snapshot') ?></th>
                    <th><?= $this->Paginator->sort('nota_inspector') ?></th>
                    <th><?= $this->Paginator->sort('is_nsa') ?></th>
                    <th><?= $this->Paginator->sort('measured_value') ?></th>
                    <th><?= $this->Paginator->sort('wdl_calculado') ?></th>
                    <th><?= $this->Paginator->sort('requires_evidence') ?></th>
                    <th><?= $this->Paginator->sort('has_evidence') ?></th>
                    <th><?= $this->Paginator->sort('calibration_record_id') ?></th>
                    <th><?= $this->Paginator->sort('created_at') ?></th>
                    <th><?= $this->Paginator->sort('updated_at') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($inspectionItem as $inspectionItem): ?>
                <tr>
                    <td><?= h($inspectionItem->id) ?></td>
                    <td><?= $inspectionItem->hasValue('inspection') ? $this->Html->link($inspectionItem->inspection->id, ['controller' => 'Inspection', 'action' => 'view', $inspectionItem->inspection->id]) : '' ?></td>
                    <td><?= $inspectionItem->hasValue('item_master') ? $this->Html->link($inspectionItem->item_master->codigo_item, ['controller' => 'ItemMaster', 'action' => 'view', $inspectionItem->item_master->id]) : '' ?></td>
                    <td><?= $inspectionItem->item_master_version === null ? '' : $this->Number->format($inspectionItem->item_master_version) ?></td>
                    <td><?= $inspectionItem->hasValue('template_item') ? $this->Html->link($inspectionItem->template_item->id, ['controller' => 'TemplateItem', 'action' => 'view', $inspectionItem->template_item->id]) : '' ?></td>
                    <td><?= $inspectionItem->ordem === null ? '' : $this->Number->format($inspectionItem->ordem) ?></td>
                    <td><?= h($inspectionItem->codigo_item_snapshot) ?></td>
                    <td><?= h($inspectionItem->titulo_snapshot) ?></td>
                    <td><?= $inspectionItem->peso_snapshot === null ? '' : $this->Number->format($inspectionItem->peso_snapshot) ?></td>
                    <td><?= h($inspectionItem->is_fca_snapshot) ?></td>
                    <td><?= h($inspectionItem->escopo_snapshot) ?></td>
                    <td><?= $inspectionItem->nota_inspector === null ? '' : $this->Number->format($inspectionItem->nota_inspector) ?></td>
                    <td><?= h($inspectionItem->is_nsa) ?></td>
                    <td><?= h($inspectionItem->measured_value) ?></td>
                    <td><?= $inspectionItem->wdl_calculado === null ? '' : $this->Number->format($inspectionItem->wdl_calculado) ?></td>
                    <td><?= h($inspectionItem->requires_evidence) ?></td>
                    <td><?= h($inspectionItem->has_evidence) ?></td>
                    <td><?= $inspectionItem->hasValue('calibration_record') ? $this->Html->link($inspectionItem->calibration_record->id, ['controller' => 'CalibrationRecord', 'action' => 'view', $inspectionItem->calibration_record->id]) : '' ?></td>
                    <td><?= h($inspectionItem->created_at) ?></td>
                    <td><?= h($inspectionItem->updated_at) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $inspectionItem->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $inspectionItem->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $inspectionItem->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $inspectionItem->id),
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