<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ChecklistTemplateVersion $checklistTemplateVersion
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Checklist Template Version'), ['action' => 'edit', $checklistTemplateVersion->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Checklist Template Version'), ['action' => 'delete', $checklistTemplateVersion->id], ['confirm' => __('Are you sure you want to delete # {0}?', $checklistTemplateVersion->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Checklist Template Version'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Checklist Template Version'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="checklistTemplateVersion view content">
            <h3><?= h($checklistTemplateVersion->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= h($checklistTemplateVersion->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Checklist Template') ?></th>
                    <td><?= $checklistTemplateVersion->hasValue('checklist_template') ? $this->Html->link($checklistTemplateVersion->checklist_template->name, ['controller' => 'ChecklistTemplate', 'action' => 'view', $checklistTemplateVersion->checklist_template->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Versao') ?></th>
                    <td><?= $this->Number->format($checklistTemplateVersion->versao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created At') ?></th>
                    <td><?= h($checklistTemplateVersion->created_at) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Notes') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($checklistTemplateVersion->notes)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Inspection') ?></h4>
                <?php if (!empty($checklistTemplateVersion->inspection)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Production Order Id') ?></th>
                            <th><?= __('Checklist Template Id') ?></th>
                            <th><?= __('Checklist Template Version Id') ?></th>
                            <th><?= __('Inspector Id') ?></th>
                            <th><?= __('Lot Code') ?></th>
                            <th><?= __('Origem') ?></th>
                            <th><?= __('Wdl Calculado') ?></th>
                            <th><?= __('Wdl Max Utilizado') ?></th>
                            <th><?= __('Nota Final') ?></th>
                            <th><?= __('Status Final') ?></th>
                            <th><?= __('Created At') ?></th>
                            <th><?= __('Updated At') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($checklistTemplateVersion->inspection as $inspection) : ?>
                        <tr>
                            <td><?= h($inspection->id) ?></td>
                            <td><?= h($inspection->production_order_id) ?></td>
                            <td><?= h($inspection->checklist_template_id) ?></td>
                            <td><?= h($inspection->checklist_template_version_id) ?></td>
                            <td><?= h($inspection->inspector_id) ?></td>
                            <td><?= h($inspection->lot_code) ?></td>
                            <td><?= h($inspection->origem) ?></td>
                            <td><?= h($inspection->wdl_calculado) ?></td>
                            <td><?= h($inspection->wdl_max_utilizado) ?></td>
                            <td><?= h($inspection->nota_final) ?></td>
                            <td><?= h($inspection->status_final) ?></td>
                            <td><?= h($inspection->created_at) ?></td>
                            <td><?= h($inspection->updated_at) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Inspection', 'action' => 'view', $inspection->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Inspection', 'action' => 'edit', $inspection->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Inspection', 'action' => 'delete', $inspection->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $inspection->id),
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
                <?php if (!empty($checklistTemplateVersion->template_item)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Checklist Template Version Id') ?></th>
                            <th><?= __('Item Master Id') ?></th>
                            <th><?= __('Item Master Version') ?></th>
                            <th><?= __('Ordem') ?></th>
                            <th><?= __('Metodologia') ?></th>
                            <th><?= __('Rigor Tecnico') ?></th>
                            <th><?= __('Acao Imediata') ?></th>
                            <th><?= __('Required') ?></th>
                            <th><?= __('Notes') ?></th>
                            <th><?= __('Created At') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($checklistTemplateVersion->template_item as $templateItem) : ?>
                        <tr>
                            <td><?= h($templateItem->id) ?></td>
                            <td><?= h($templateItem->checklist_template_version_id) ?></td>
                            <td><?= h($templateItem->item_master_id) ?></td>
                            <td><?= h($templateItem->item_master_version) ?></td>
                            <td><?= h($templateItem->ordem) ?></td>
                            <td><?= h($templateItem->metodologia) ?></td>
                            <td><?= h($templateItem->rigor_tecnico) ?></td>
                            <td><?= h($templateItem->acao_imediata) ?></td>
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