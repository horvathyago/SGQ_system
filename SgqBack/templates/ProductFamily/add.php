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
            <?= $this->Html->link(__('List Product Family'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="productFamily form content">
            <?= $this->Form->create($productFamily) ?>
            <fieldset>
                <legend><?= __('Add Product Family') ?></legend>
                <?php
                    echo $this->Form->control('codigo');
                    echo $this->Form->control('nome');
                    echo $this->Form->control('descricao');
                    echo $this->Form->control('created_at');
                    echo $this->Form->control('updated_at');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
