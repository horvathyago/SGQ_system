<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ProductionOrder $productionOrder
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Production Order'), ['action' => 'edit', $productionOrder->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Production Order'), ['action' => 'delete', $productionOrder->id], ['confirm' => __('Are you sure you want to delete # {0}?', $productionOrder->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Production Order'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Production Order'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="productionOrder view content">
            <h3><?= h($productionOrder->numero_op) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= h($productionOrder->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Numero Op') ?></th>
                    <td><?= h($productionOrder->numero_op) ?></td>
                </tr>
                <tr>
                    <th><?= __('Produto Codigo') ?></th>
                    <td><?= h($productionOrder->produto_codigo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Product Family') ?></th>
                    <td><?= $productionOrder->hasValue('product_family') ? $this->Html->link($productionOrder->product_family->codigo, ['controller' => 'ProductFamily', 'action' => 'view', $productionOrder->product_family->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Lot Code') ?></th>
                    <td><?= h($productionOrder->lot_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($productionOrder->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Quantidade Planejada') ?></th>
                    <td><?= $productionOrder->quantidade_planejada === null ? '' : $this->Number->format($productionOrder->quantidade_planejada) ?></td>
                </tr>
                <tr>
                    <th><?= __('Data Inicio') ?></th>
                    <td><?= h($productionOrder->data_inicio) ?></td>
                </tr>
                <tr>
                    <th><?= __('Data Fim') ?></th>
                    <td><?= h($productionOrder->data_fim) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created At') ?></th>
                    <td><?= h($productionOrder->created_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Updated At') ?></th>
                    <td><?= h($productionOrder->updated_at) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Inspection') ?></h4>
                <?php if (!empty($productionOrder->inspection)) : ?>
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
                        <?php foreach ($productionOrder->inspection as $inspection) : ?>
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
                <h4><?= __('Related Lot') ?></h4>
                <?php if (!empty($productionOrder->lot)) : ?>
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
                        <?php foreach ($productionOrder->lot as $lot) : ?>
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
        </div>
    </div>
</div>