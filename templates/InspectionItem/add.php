<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InspectionItem $inspectionItem
 * @var \Cake\Collection\CollectionInterface|string[] $inspections
 * @var \Cake\Collection\CollectionInterface|string[] $itemMasters
 * @var \Cake\Collection\CollectionInterface|string[] $templateItems
 * @var \Cake\Collection\CollectionInterface|string[] $calibrationRecords
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Inspection Item'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="inspectionItem form content">
            <?= $this->Form->create($inspectionItem) ?>
            <fieldset>
                <legend><?= __('Add Inspection Item') ?></legend>
                <?php
                    echo $this->Form->control('inspection_id', ['options' => $inspections]);
                    echo $this->Form->control('item_master_id', ['options' => $itemMasters, 'empty' => true]);
                    echo $this->Form->control('item_master_version');
                    echo $this->Form->control('template_item_id', ['options' => $templateItems, 'empty' => true]);
                    echo $this->Form->control('ordem');
                    echo $this->Form->control('codigo_item_snapshot');
                    echo $this->Form->control('titulo_snapshot');
                    echo $this->Form->control('peso_snapshot');
                    echo $this->Form->control('is_fca_snapshot');
                    echo $this->Form->control('escopo_snapshot');
                    echo $this->Form->control('nota_inspector');
                    echo $this->Form->control('is_nsa');
                    echo $this->Form->control('measured_value');
                    echo $this->Form->control('comentario');
                    echo $this->Form->control('wdl_calculado');
                    echo $this->Form->control('requires_evidence');
                    echo $this->Form->control('has_evidence');
                    echo $this->Form->control('calibration_record_id', ['options' => $calibrationRecords, 'empty' => true]);
                    echo $this->Form->control('created_at');
                    echo $this->Form->control('updated_at');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
