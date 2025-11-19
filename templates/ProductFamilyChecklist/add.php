<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ProductFamilyChecklist $productFamilyChecklist
 * @var \Cake\Collection\CollectionInterface|string[] $productFamilies
 * @var \Cake\Collection\CollectionInterface|string[] $checklistTemplates
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Product Family Checklist'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="productFamilyChecklist form content">
            <?= $this->Form->create($productFamilyChecklist) ?>
            <fieldset>
                <legend><?= __('Add Product Family Checklist') ?></legend>
                <?php
                    echo $this->Form->control('product_family_id', ['options' => $productFamilies]);
                    echo $this->Form->control('checklist_template_id', ['options' => $checklistTemplates]);
                    echo $this->Form->control('tipo');
                    echo $this->Form->control('created_at');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
