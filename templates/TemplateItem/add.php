<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TemplateItem $templateItem
 * @var \Cake\Collection\CollectionInterface|string[] $checklistTemplateVersions
 * @var \Cake\Collection\CollectionInterface|string[] $itemMasters
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Template Item'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="templateItem form content">
            <?= $this->Form->create($templateItem) ?>
            <fieldset>
                <legend><?= __('Add Template Item') ?></legend>
                <?php
                    echo $this->Form->control('checklist_template_version_id', ['options' => $checklistTemplateVersions]);
                    echo $this->Form->control('item_master_id', ['options' => $itemMasters]);
                    echo $this->Form->control('item_master_version');
                    echo $this->Form->control('ordem');
                    echo $this->Form->control('metodologia');
                    echo $this->Form->control('rigor_tecnico');
                    echo $this->Form->control('acao_imediata');
                    echo $this->Form->control('required');
                    echo $this->Form->control('notes');
                    echo $this->Form->control('created_at');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
