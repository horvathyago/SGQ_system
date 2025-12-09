<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ProductFamily $productFamily
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Product Family'), ['action' => 'edit', $productFamily->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Product Family'), ['action' => 'delete', $productFamily->id], ['confirm' => __('Are you sure you want to delete # {0}?', $productFamily->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Product Family'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Product Family'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="productFamily view content">
            <h3><?= h($productFamily->codigo) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= h($productFamily->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Codigo') ?></th>
                    <td><?= h($productFamily->codigo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nome') ?></th>
                    <td><?= h($productFamily->nome) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created At') ?></th>
                    <td><?= h($productFamily->created_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Updated At') ?></th>
                    <td><?= h($productFamily->updated_at) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Descricao') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($productFamily->descricao)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Lot') ?></h4>
                <?php if (!empty($productFamily->lot)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Lot Code') ?></th>
                            <th><?= __('Product Family Id') ?></th>
                            <th><?= __('Production Order Id') ?></th>
                            <th><?= __('Quantidade') ?></th>
                            <th><?= __('Created At') ?></th>
                            <th><?= __('Updated At') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($productFamily->lot as $lot) : ?>
                        <tr>
                            <td><?= h($lot->id) ?></td>
                            <td><?= h($lot->lot_code) ?></td>
                            <td><?= h($lot->product_family_id) ?></td>
                            <td><?= h($lot->production_order_id) ?></td>
                            <td><?= h($lot->quantidade) ?></td>
                            <td><?= h($lot->created_at) ?></td>
                            <td><?= h($lot->updated_at) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Lot', 'action' => 'view', $lot->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Lot', 'action' => 'edit', $lot->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Lot', 'action' => 'delete', $lot->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $lot->id),
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
                <h4><?= __('Related Process Index') ?></h4>
                <?php if (!empty($productFamily->process_index)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Periodo') ?></th>
                            <th><?= __('Indicador') ?></th>
                            <th><?= __('Product Family Id') ?></th>
                            <th><?= __('Valor') ?></th>
                            <th><?= __('Unidade') ?></th>
                            <th><?= __('Detalhes') ?></th>
                            <th><?= __('Created At') ?></th>
                            <th><?= __('Updated At') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($productFamily->process_index as $processIndex) : ?>
                        <tr>
                            <td><?= h($processIndex->id) ?></td>
                            <td><?= h($processIndex->periodo) ?></td>
                            <td><?= h($processIndex->indicador) ?></td>
                            <td><?= h($processIndex->product_family_id) ?></td>
                            <td><?= h($processIndex->valor) ?></td>
                            <td><?= h($processIndex->unidade) ?></td>
                            <td><?= h($processIndex->detalhes) ?></td>
                            <td><?= h($processIndex->created_at) ?></td>
                            <td><?= h($processIndex->updated_at) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ProcessIndex', 'action' => 'view', $processIndex->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ProcessIndex', 'action' => 'edit', $processIndex->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'ProcessIndex', 'action' => 'delete', $processIndex->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $processIndex->id),
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
                <?php if (!empty($productFamily->product_family_checklist)) : ?>
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
                        <?php foreach ($productFamily->product_family_checklist as $productFamilyChecklist) : ?>
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
            <div class="related">
                <h4><?= __('Related Production Order') ?></h4>
                <?php if (!empty($productFamily->production_order)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Numero Op') ?></th>
                            <th><?= __('Produto Codigo') ?></th>
                            <th><?= __('Product Family Id') ?></th>
                            <th><?= __('Lot Code') ?></th>
                            <th><?= __('Quantidade Planejada') ?></th>
                            <th><?= __('Data Inicio') ?></th>
                            <th><?= __('Data Fim') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Created At') ?></th>
                            <th><?= __('Updated At') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($productFamily->production_order as $productionOrder) : ?>
                        <tr>
                            <td><?= h($productionOrder->id) ?></td>
                            <td><?= h($productionOrder->numero_op) ?></td>
                            <td><?= h($productionOrder->produto_codigo) ?></td>
                            <td><?= h($productionOrder->product_family_id) ?></td>
                            <td><?= h($productionOrder->lot_code) ?></td>
                            <td><?= h($productionOrder->quantidade_planejada) ?></td>
                            <td><?= h($productionOrder->data_inicio) ?></td>
                            <td><?= h($productionOrder->data_fim) ?></td>
                            <td><?= h($productionOrder->status) ?></td>
                            <td><?= h($productionOrder->created_at) ?></td>
                            <td><?= h($productionOrder->updated_at) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'ProductionOrder', 'action' => 'view', $productionOrder->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'ProductionOrder', 'action' => 'edit', $productionOrder->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'ProductionOrder', 'action' => 'delete', $productionOrder->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $productionOrder->id),
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