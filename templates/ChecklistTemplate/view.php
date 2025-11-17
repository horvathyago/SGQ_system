<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ChecklistTemplate $checklistTemplate
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Checklist Template'), ['action' => 'edit', $checklistTemplate->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Checklist Template'), ['action' => 'delete', $checklistTemplate->id], ['confirm' => __('Are you sure you want to delete # {0}?', $checklistTemplate->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Checklist Template'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Checklist Template'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="checklistTemplate view content">
            <h3><?= h($checklistTemplate->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= h($checklistTemplate->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($checklistTemplate->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tipo') ?></th>
                    <td><?= h($checklistTemplate->tipo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created At') ?></th>
                    <td><?= h($checklistTemplate->created_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Updated At') ?></th>
                    <td><?= h($checklistTemplate->updated_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= $checklistTemplate->is_active ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Descricao') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($checklistTemplate->descricao)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Checklist Template Version') ?></h4>
                <?php if (!empty($checklistTemplate->checklist_template_version)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Checklist Template Id') ?></th>
                            <th><?= __('Versao') ?></th>
                            <th><?= __('Notes') ?></th>
                            <th><?= __('Created At') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($checklistTemplate->checklist_template_version as $checklistTemplateVersion) : ?>
                        <tr>
                            <td><?= h($checklistTemplateVersion->id) ?></td>
                            <td><?= h($checklistTemplateVersion->checklist_template_id) ?></td>
                            <td><?= h($checklistTemplateVersion->versao) ?></td>
                            <td><?= h($checklistTemplateVersion->notes) ?></td>
                            <td><?= h($checklistTemplateVersion->created_at) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ChecklistTemplateVersion', 'action' => 'view', $checklistTemplateVersion->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ChecklistTemplateVersion', 'action' => 'edit', $checklistTemplateVersion->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'ChecklistTemplateVersion', 'action' => 'delete', $checklistTemplateVersion->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $checklistTemplateVersion->id),
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
                <h4><?= __('Related Inspection') ?></h4>
                <?php if (!empty($checklistTemplate->inspection)) : ?>
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
                        <?php foreach ($checklistTemplate->inspection as $inspection) : ?>
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
                <h4><?= __('Related Product Family Checklist') ?></h4>
                <?php if (!empty($checklistTemplate->product_family_checklist)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Product Family Id') ?></th>
                            <th><?= __('Checklist Template Id') ?></th>
                            <th><?= __('Tipo') ?></th>
                            <th><?= __('Created At') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($checklistTemplate->product_family_checklist as $productFamilyChecklist) : ?>
                        <tr>
                            <td><?= h($productFamilyChecklist->id) ?></td>
                            <td><?= h($productFamilyChecklist->product_family_id) ?></td>
                            <td><?= h($productFamilyChecklist->checklist_template_id) ?></td>
                            <td><?= h($productFamilyChecklist->tipo) ?></td>
                            <td><?= h($productFamilyChecklist->created_at) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ProductFamilyChecklist', 'action' => 'view', $productFamilyChecklist->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ProductFamilyChecklist', 'action' => 'edit', $productFamilyChecklist->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'ProductFamilyChecklist', 'action' => 'delete', $productFamilyChecklist->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $productFamilyChecklist->id),
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