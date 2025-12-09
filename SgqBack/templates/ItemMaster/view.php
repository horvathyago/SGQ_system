<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ItemMaster $itemMaster
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Item Master'), ['action' => 'edit', $itemMaster->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Item Master'), ['action' => 'delete', $itemMaster->id], ['confirm' => __('Are you sure you want to delete # {0}?', $itemMaster->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Item Master'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Item Master'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="itemMaster view content">
            <h3><?= h($itemMaster->codigo_item) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= h($itemMaster->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Codigo Item') ?></th>
                    <td><?= h($itemMaster->codigo_item) ?></td>
                </tr>
                <tr>
                    <th><?= __('Titulo') ?></th>
                    <td><?= h($itemMaster->titulo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Escopo') ?></th>
                    <td><?= h($itemMaster->escopo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Versao Mestra') ?></th>
                    <td><?= $itemMaster->versao_mestra === null ? '' : $this->Number->format($itemMaster->versao_mestra) ?></td>
                </tr>
                <tr>
                    <th><?= __('Peso') ?></th>
                    <td><?= $itemMaster->peso === null ? '' : $this->Number->format($itemMaster->peso) ?></td>
                </tr>
                <tr>
                    <th><?= __('Vigente Inicio') ?></th>
                    <td><?= h($itemMaster->vigente_inicio) ?></td>
                </tr>
                <tr>
                    <th><?= __('Vigente Fim') ?></th>
                    <td><?= h($itemMaster->vigente_fim) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created At') ?></th>
                    <td><?= h($itemMaster->created_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Updated At') ?></th>
                    <td><?= h($itemMaster->updated_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Fca') ?></th>
                    <td><?= $itemMaster->is_fca ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Ativo') ?></th>
                    <td><?= $itemMaster->is_ativo ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Inspection Item') ?></h4>
                <?php if (!empty($itemMaster->inspection_item)) : ?>
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
                        <?php foreach ($itemMaster->inspection_item as $inspectionItem) : ?>
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
            <div class="related">
                <h4><?= __('Related Item Master Version') ?></h4>
                <?php if (!empty($itemMaster->item_master_version)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Item Master Id') ?></th>
                            <th><?= __('Versao') ?></th>
                            <th><?= __('Codigo Item Snapshot') ?></th>
                            <th><?= __('Titulo Snapshot') ?></th>
                            <th><?= __('Peso Snapshot') ?></th>
                            <th><?= __('Is Fca Snapshot') ?></th>
                            <th><?= __('Escopo Snapshot') ?></th>
                            <th><?= __('Created At') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($itemMaster->item_master_version as $itemMasterVersion) : ?>
                        <tr>
                            <td><?= h($itemMasterVersion->id) ?></td>
                            <td><?= h($itemMasterVersion->item_master_id) ?></td>
                            <td><?= h($itemMasterVersion->versao) ?></td>
                            <td><?= h($itemMasterVersion->codigo_item_snapshot) ?></td>
                            <td><?= h($itemMasterVersion->titulo_snapshot) ?></td>
                            <td><?= h($itemMasterVersion->peso_snapshot) ?></td>
                            <td><?= h($itemMasterVersion->is_fca_snapshot) ?></td>
                            <td><?= h($itemMasterVersion->escopo_snapshot) ?></td>
                            <td><?= h($itemMasterVersion->created_at) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ItemMasterVersion', 'action' => 'view', $itemMasterVersion->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ItemMasterVersion', 'action' => 'edit', $itemMasterVersion->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'ItemMasterVersion', 'action' => 'delete', $itemMasterVersion->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $itemMasterVersion->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
            <div class="related">
                <h4><?= __('Related Template Item') ?></h4>
                <?php if (!empty($itemMaster->template_item)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Checklist Template Version Id') ?></th>
                            <th><?= __('Item Master Id') ?></th>
                            <th><?= __('Item Master Version') ?></th>
                            <th><?= __('Ordem') ?></th>
                            <th><?= __('Required') ?></th>
                            <th><?= __('Notes') ?></th>
                            <th><?= __('Created At') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($itemMaster->template_item as $templateItem) : ?>
                        <tr>
                            <td><?= h($templateItem->id) ?></td>
                            <td><?= h($templateItem->checklist_template_version_id) ?></td>
                            <td><?= h($templateItem->item_master_id) ?></td>
                            <td><?= h($templateItem->item_master_version) ?></td>
                            <td><?= h($templateItem->ordem) ?></td>
                            <td><?= h($templateItem->required) ?></td>
                            <td><?= h($templateItem->notes) ?></td>
                            <td><?= h($templateItem->created_at) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'TemplateItem', 'action' => 'view', $templateItem->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'TemplateItem', 'action' => 'edit', $templateItem->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'TemplateItem', 'action' => 'delete', $templateItem->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $templateItem->id),
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