<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Lot $lot
 * @var \Cake\Collection\CollectionInterface|string[] $productFamilies
 * @var \Cake\Collection\CollectionInterface|string[] $productionOrders
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Lot'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="lot form content">
            <?= $this->Form->create($lot) ?>
            <fieldset>
                <legend><?= __('Add Lot') ?></legend>
                <?php
                    echo $this->Form->control('lot_code');
                    echo $this->Form->control('product_family_id', ['options' => $productFamilies, 'empty' => true]);
                    echo $this->Form->control('production_order_id', ['options' => $productionOrders, 'empty' => true]);
                    echo $this->Form->control('quantidade');
                    echo $this->Form->control('created_at');
                    echo $this->Form->control('updated_at');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
