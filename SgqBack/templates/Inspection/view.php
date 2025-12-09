<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Inspection $inspection
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Inspection'), ['action' => 'edit', $inspection->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Inspection'), ['action' => 'delete', $inspection->id], ['confirm' => __('Are you sure you want to delete # {0}?', $inspection->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Inspection'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Inspection'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="inspection view content">
            <h3><?= h($inspection->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= h($inspection->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Production Order') ?></th>
                    <td><?= $inspection->hasValue('production_order') ? $this->Html->link($inspection->production_order->numero_op, ['controller' => 'ProductionOrder', 'action' => 'view', $inspection->production_order->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Checklist Template') ?></th>
                    <td><?= $inspection->hasValue('checklist_template') ? $this->Html->link($inspection->checklist_template->name, ['controller' => 'ChecklistTemplate', 'action' => 'view', $inspection->checklist_template->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Checklist Template Version') ?></th>
                    <td><?= $inspection->hasValue('checklist_template_version') ? $this->Html->link($inspection->checklist_template_version->id, ['controller' => 'ChecklistTemplateVersions', 'action' => 'view', $inspection->checklist_template_version->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Inspector') ?></th>
                    <td><?= $inspection->hasValue('inspector') ? $this->Html->link($inspection->inspector->nome, ['controller' => 'UserAccount', 'action' => 'view', $inspection->inspector->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Lot Code') ?></th>
                    <td><?= h($inspection->lot_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Origem') ?></th>
                    <td><?= h($inspection->origem) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status Final') ?></th>
                    <td><?= h($inspection->status_final) ?></td>
                </tr>
                <tr>
                    <th><?= __('Wdl Calculado') ?></th>
                    <td><?= $inspection->wdl_calculado === null ? '' : $this->Number->format($inspection->wdl_calculado) ?></td>
                </tr>
                <tr>
                    <th><?= __('Wdl Max Utilizado') ?></th>
                    <td><?= $inspection->wdl_max_utilizado === null ? '' : $this->Number->format($inspection->wdl_max_utilizado) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nota Final') ?></th>
                    <td><?= $inspection->nota_final === null ? '' : $this->Number->format($inspection->nota_final) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created At') ?></th>
                    <td><?= h($inspection->created_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Updated At') ?></th>
                    <td><?= h($inspection->updated_at) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Inspection Item') ?></h4>
                <?php if (!empty($inspection->inspection_item)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Inspection Id') ?></th>
                            <th><?= __('Item Master Id') ?></th>
                            <th><?= __('Item Master Version') ?></th>
                            <th><?= __('Template Item Id') ?></th>
                            <th><?= __('Ordem') ?></th>
                            <th><?= __('Codigo Item Snapshot') ?></th>
                            <th><?= __('Titulo Snapshot') ?></th>
                            <th><?= __('Peso Snapshot') ?></th>
                            <th><?= __('Is Fca Snapshot') ?></th>
                            <th><?= __('Escopo Snapshot') ?></th>
                            <th><?= __('Nota Inspector') ?></th>
                            <th><?= __('Is Nsa') ?></th>
                            <th><?= __('Measured Value') ?></th>
                            <th><?= __('Comentario') ?></th>
                            <th><?= __('Wdl Calculado') ?></th>
                            <th><?= __('Requires Evidence') ?></th>
                            <th><?= __('Has Evidence') ?></th>
                            <th><?= __('Calibration Record Id') ?></th>
                            <th><?= __('Created At') ?></th>
                            <th><?= __('Updated At') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($inspection->inspection_item as $inspectionItem) : ?>
                        <tr>
                            <td><?= h($inspectionItem->id) ?></td>
                            <td><?= h($inspectionItem->inspection_id) ?></td>
                            <td><?= h($inspectionItem->item_master_id) ?></td>
                            <td><?= h($inspectionItem->item_master_version) ?></td>
                            <td><?= h($inspectionItem->template_item_id) ?></td>
                            <td><?= h($inspectionItem->ordem) ?></td>
                            <td><?= h($inspectionItem->codigo_item_snapshot) ?></td>
                            <td><?= h($inspectionItem->titulo_snapshot) ?></td>
                            <td><?= h($inspectionItem->peso_snapshot) ?></td>
                            <td><?= h($inspectionItem->is_fca_snapshot) ?></td>
                            <td><?= h($inspectionItem->escopo_snapshot) ?></td>
                            <td><?= h($inspectionItem->nota_inspector) ?></td>
                            <td><?= h($inspectionItem->is_nsa) ?></td>
                            <td><?= h($inspectionItem->measured_value) ?></td>
                            <td><?= h($inspectionItem->comentario) ?></td>
                            <td><?= h($inspectionItem->wdl_calculado) ?></td>
                            <td><?= h($inspectionItem->requires_evidence) ?></td>
                            <td><?= h($inspectionItem->has_evidence) ?></td>
                            <td><?= h($inspectionItem->calibration_record_id) ?></td>
                            <td><?= h($inspectionItem->created_at) ?></td>
                            <td><?= h($inspectionItem->updated_at) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'InspectionItem', 'action' => 'view', $inspectionItem->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'InspectionItem', 'action' => 'edit', $inspectionItem->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'InspectionItem', 'action' => 'delete', $inspectionItem->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $inspectionItem->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>