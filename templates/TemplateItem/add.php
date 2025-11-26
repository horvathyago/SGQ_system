<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TemplateItem $templateItem
 * @var array $checklistTemplateVersions
 * @var array $itemMasters
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Template Items'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>

    <div class="column column-80">
        <div class="templateItem form content">
            <?= $this->Form->create($templateItem) ?>
            <fieldset>
                <legend><?= __('Add Template Item') ?></legend>

                <?= $this->Form->control('checklist_template_id', [
                    'label' => 'Checklist Template',
                    'options' => !empty($checklistTemplateVersions) ? $checklistTemplateVersions : [],
                    'empty' => 'Selecione...',
                    'required' => true,
                    'class' => 'form-select'
                ]) ?>

                <?= $this->Form->control('item_master_id', [
                    'label' => 'Item Master',
                    'options' => !empty($itemMasters) ? $itemMasters : [],
                    'empty' => 'Selecione...',
                    'required' => true,
                    'class' => 'form-select'
                ]) ?>

                <?= $this->Form->control('item_master_version', ['label' => 'Versão do Item Master']) ?>
                <?= $this->Form->control('ordem', ['type' => 'number', 'min' => 1]) ?>
                <?= $this->Form->control('metodologia') ?>
                <?= $this->Form->control('rigor_tecnico') ?>
                <?= $this->Form->control('acao_imediata') ?>
                <?= $this->Form->control('required', ['type' => 'checkbox']) ?>
                <?= $this->Form->control('notes') ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
