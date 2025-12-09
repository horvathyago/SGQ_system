<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CalibrationRecord $calibrationRecord
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Calibration Record'), ['action' => 'edit', $calibrationRecord->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Calibration Record'), ['action' => 'delete', $calibrationRecord->id], ['confirm' => __('Are you sure you want to delete # {0}?', $calibrationRecord->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Calibration Record'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Calibration Record'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="calibrationRecord view content">
            <h3><?= h($calibrationRecord->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= h($calibrationRecord->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Gauge') ?></th>
                    <td><?= $calibrationRecord->hasValue('gauge') ? $this->Html->link($calibrationRecord->gauge->id, ['controller' => 'Gauge', 'action' => 'view', $calibrationRecord->gauge->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Laudo Document') ?></th>
                    <td><?= $calibrationRecord->hasValue('laudo_document') ? $this->Html->link($calibrationRecord->laudo_document->filename, ['controller' => 'Document', 'action' => 'view', $calibrationRecord->laudo_document->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Versao') ?></th>
                    <td><?= $calibrationRecord->versao === null ? '' : $this->Number->format($calibrationRecord->versao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Data Calibracao') ?></th>
                    <td><?= h($calibrationRecord->data_calibracao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Validade') ?></th>
                    <td><?= h($calibrationRecord->validade) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created At') ?></th>
                    <td><?= h($calibrationRecord->created_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Updated At') ?></th>
                    <td><?= h($calibrationRecord->updated_at) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Inspection Item') ?></h4>
                <?php if (!empty($calibrationRecord->inspection_item)) : ?>
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
                        <?php foreach ($calibrationRecord->inspection_item as $inspectionItem) : ?>
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