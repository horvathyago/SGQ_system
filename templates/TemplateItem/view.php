<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TemplateItem $templateItem
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Template Item'), ['action' => 'edit', $templateItem->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Template Item'), ['action' => 'delete', $templateItem->id], ['confirm' => __('Are you sure you want to delete # {0}?', $templateItem->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Template Item'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Template Item'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="templateItem view content">
            <h3><?= h($templateItem->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= h($templateItem->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Checklist Template Version') ?></th>
                    <td><?= $templateItem->hasValue('checklist_template_version') ? $this->Html->link($templateItem->checklist_template_version->id, ['controller' => 'ChecklistTemplateVersions', 'action' => 'view', $templateItem->checklist_template_version->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Item Master') ?></th>
                    <td><?= $templateItem->hasValue('item_master') ? $this->Html->link($templateItem->item_master->codigo_item, ['controller' => 'ItemMaster', 'action' => 'view', $templateItem->item_master->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Item Master Version') ?></th>
                    <td><?= $templateItem->item_master_version === null ? '' : $this->Number->format($templateItem->item_master_version) ?></td>
                </tr>
                <tr>
                    <th><?= __('Ordem') ?></th>
                    <td><?= $this->Number->format($templateItem->ordem) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created At') ?></th>
                    <td><?= h($templateItem->created_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Required') ?></th>
                    <td><?= $templateItem->required ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Metodologia') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($templateItem->metodologia)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Rigor Tecnico') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($templateItem->rigor_tecnico)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Acao Imediata') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($templateItem->acao_imediata)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Notes') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($templateItem->notes)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Inspection Item') ?></h4>
                <?php if (!empty($templateItem->inspection_item)) : ?>
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
                        <?php foreach ($templateItem->inspection_item as $inspectionItem) : ?>
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