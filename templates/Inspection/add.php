<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Inspection $inspection
 * @var \Cake\Collection\CollectionInterface|string[] $productionOrders
 * @var \Cake\Collection\CollectionInterface|string[] $checklistTemplates
 * @var \Cake\Collection\CollectionInterface|string[] $checklistTemplateVersions
 * @var \Cake\Collection\CollectionInterface|string[] $inspectors
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Inspection'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="inspection form content">
            <?= $this->Form->create($inspection) ?>
            <fieldset>
                <legend><?= __('Add Inspection') ?></legend>
                <?php
                    echo $this->Form->control('production_order_id', ['options' => $productionOrders, 'empty' => true]);
                    echo $this->Form->control('checklist_template_id', ['options' => $checklistTemplates, 'empty' => true]);
                    echo $this->Form->control('checklist_template_version_id', ['options' => $checklistTemplateVersions, 'empty' => true]);
                    echo $this->Form->control('inspector_id', ['options' => $inspectors, 'empty' => true]);
                    echo $this->Form->control('lot_code');
                    echo $this->Form->control('origem');
                    echo $this->Form->control('wdl_calculado');
                    echo $this->Form->control('wdl_max_utilizado');
                    echo $this->Form->control('nota_final');
                    echo $this->Form->control('status_final');
                    echo $this->Form->control('created_at');
                    echo $this->Form->control('updated_at');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
