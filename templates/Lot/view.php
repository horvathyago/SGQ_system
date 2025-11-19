<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Lot $lot
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Lot'), ['action' => 'edit', $lot->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Lot'), ['action' => 'delete', $lot->id], ['confirm' => __('Are you sure you want to delete # {0}?', $lot->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Lot'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Lot'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="lot view content">
            <h3><?= h($lot->lot_code) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= h($lot->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Lot Code') ?></th>
                    <td><?= h($lot->lot_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Product Family') ?></th>
                    <td><?= $lot->hasValue('product_family') ? $this->Html->link($lot->product_family->codigo, ['controller' => 'ProductFamily', 'action' => 'view', $lot->product_family->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Production Order') ?></th>
                    <td><?= $lot->hasValue('production_order') ? $this->Html->link($lot->production_order->numero_op, ['controller' => 'ProductionOrder', 'action' => 'view', $lot->production_order->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Quantidade') ?></th>
                    <td><?= $lot->quantidade === null ? '' : $this->Number->format($lot->quantidade) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created At') ?></th>
                    <td><?= h($lot->created_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Updated At') ?></th>
                    <td><?= h($lot->updated_at) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>