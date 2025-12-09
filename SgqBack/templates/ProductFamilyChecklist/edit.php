<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ProductFamilyChecklist $productFamilyChecklist
 * @var string[]|\Cake\Collection\CollectionInterface $productFamilies
 * @var string[]|\Cake\Collection\CollectionInterface $checklistTemplates
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $productFamilyChecklist->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $productFamilyChecklist->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Product Family Checklist'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="productFamilyChecklist form content">
            <?= $this->Form->create($productFamilyChecklist) ?>
            <fieldset>
                <legend><?= __('Edit Product Family Checklist') ?></legend>
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
