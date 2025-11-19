<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InspectionItem $inspectionItem
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Inspection Item'), ['action' => 'edit', $inspectionItem->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Inspection Item'), ['action' => 'delete', $inspectionItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $inspectionItem->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Inspection Item'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Inspection Item'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="inspectionItem view content">
            <h3><?= h($inspectionItem->codigo_item_snapshot) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= h($inspectionItem->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Inspection') ?></th>
                    <td><?= $inspectionItem->hasValue('inspection') ? $this->Html->link($inspectionItem->inspection->id, ['controller' => 'Inspection', 'action' => 'view', $inspectionItem->inspection->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Item Master') ?></th>
                    <td><?= $inspectionItem->hasValue('item_master') ? $this->Html->link($inspectionItem->item_master->codigo_item, ['controller' => 'ItemMaster', 'action' => 'view', $inspectionItem->item_master->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Template Item') ?></th>
                    <td><?= $inspectionItem->hasValue('template_item') ? $this->Html->link($inspectionItem->template_item->id, ['controller' => 'TemplateItem', 'action' => 'view', $inspectionItem->template_item->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Codigo Item Snapshot') ?></th>
                    <td><?= h($inspectionItem->codigo_item_snapshot) ?></td>
                </tr>
                <tr>
                    <th><?= __('Titulo Snapshot') ?></th>
                    <td><?= h($inspectionItem->titulo_snapshot) ?></td>
                </tr>
                <tr>
                    <th><?= __('Escopo Snapshot') ?></th>
                    <td><?= h($inspectionItem->escopo_snapshot) ?></td>
                </tr>
                <tr>
                    <th><?= __('Measured Value') ?></th>
                    <td><?= h($inspectionItem->measured_value) ?></td>
                </tr>
                <tr>
                    <th><?= __('Calibration Record') ?></th>
                    <td><?= $inspectionItem->hasValue('calibration_record') ? $this->Html->link($inspectionItem->calibration_record->id, ['controller' => 'CalibrationRecord', 'action' => 'view', $inspectionItem->calibration_record->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Item Master Version') ?></th>
                    <td><?= $inspectionItem->item_master_version === null ? '' : $this->Number->format($inspectionItem->item_master_version) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ordem') ?></th>
                    <td><?= $inspectionItem->ordem === null ? '' : $this->Number->format($inspectionItem->ordem) ?></td>
                </tr>
                <tr>
                    <th><?= __('Peso Snapshot') ?></th>
                    <td><?= $inspectionItem->peso_snapshot === null ? '' : $this->Number->format($inspectionItem->peso_snapshot) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nota Inspector') ?></th>
                    <td><?= $inspectionItem->nota_inspector === null ? '' : $this->Number->format($inspectionItem->nota_inspector) ?></td>
                </tr>
                <tr>
                    <th><?= __('Wdl Calculado') ?></th>
                    <td><?= $inspectionItem->wdl_calculado === null ? '' : $this->Number->format($inspectionItem->wdl_calculado) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created At') ?></th>
                    <td><?= h($inspectionItem->created_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Updated At') ?></th>
                    <td><?= h($inspectionItem->updated_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Fca Snapshot') ?></th>
                    <td><?= $inspectionItem->is_fca_snapshot ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Nsa') ?></th>
                    <td><?= $inspectionItem->is_nsa ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Requires Evidence') ?></th>
                    <td><?= $inspectionItem->requires_evidence ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Has Evidence') ?></th>
                    <td><?= $inspectionItem->has_evidence ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Comentario') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($inspectionItem->comentario)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Non Conformity') ?></h4>
                <?php if (!empty($inspectionItem->non_conformity)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Inspection Item Id') ?></th>
                            <th><?= __('Descricao') ?></th>
                            <th><?= __('Severity') ?></th>
                            <th><?= __('Is Fca Trigger') ?></th>
                            <th><?= __('Disposition') ?></th>
                            <th><?= __('Responsavel Id') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Created At') ?></th>
                            <th><?= __('Updated At') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($inspectionItem->non_conformity as $nonConformity) : ?>
                        <tr>
                            <td><?= h($nonConformity->id) ?></td>
                            <td><?= h($nonConformity->inspection_item_id) ?></td>
                            <td><?= h($nonConformity->descricao) ?></td>
                            <td><?= h($nonConformity->severity) ?></td>
                            <td><?= h($nonConformity->is_fca_trigger) ?></td>
                            <td><?= h($nonConformity->disposition) ?></td>
                            <td><?= h($nonConformity->responsavel_id) ?></td>
                            <td><?= h($nonConformity->status) ?></td>
                            <td><?= h($nonConformity->created_at) ?></td>
                            <td><?= h($nonConformity->updated_at) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'NonConformity', 'action' => 'view', $nonConformity->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'NonConformity', 'action' => 'edit', $nonConformity->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'NonConformity', 'action' => 'delete', $nonConformity->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $nonConformity->id),
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