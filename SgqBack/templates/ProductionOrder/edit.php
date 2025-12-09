<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ProductionOrder $productionOrder
 * @var string[]|\Cake\Collection\CollectionInterface $productFamilies
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $productionOrder->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $productionOrder->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Production Order'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="productionOrder form content">
            <?= $this->Form->create($productionOrder) ?>
            <fieldset>
                <legend><?= __('Edit Production Order') ?></legend>
                <?php
                    echo $this->Form->control('numero_op');
                    echo $this->Form->control('produto_codigo');
                    echo $this->Form->control('product_family_id', ['options' => $productFamilies, 'empty' => true]);
                    echo $this->Form->control('lot_code');
                    echo $this->Form->control('quantidade_planejada');
                    echo $this->Form->control('data_inicio');
                    echo $this->Form->control('data_fim');
                    echo $this->Form->control('status');
                    echo $this->Form->control('created_at');
                    echo $this->Form->control('updated_at');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
