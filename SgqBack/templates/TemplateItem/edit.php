<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TemplateItem $templateItem
 * @var array $checklistTemplates
 * @var array $itemMasters
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>

            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $templateItem->id],
                [
                    'confirm' => __('Are you sure you want to delete # {0}?', $templateItem->id),
                    'class' => 'side-nav-item'
                ]
            ) ?>

            <?= $this->Html->link(
                __('List Template Items'),
                ['action' => 'index'],
                ['class' => 'side-nav-item']
            ) ?>
        </div>
    </aside>

    <div class="column column-80">
        <div class="templateItem form content">

            <?= $this->Form->create($templateItem) ?>

            <fieldset>
                <legend><?= __('Edit Template Item') ?></legend>

                <?= $this->Form->control('checklist_template_id', [
                    'label' => 'Checklist Template',
                    'options' => $checklistTemplates,
                    'empty' => 'Selecione...',
                    'required' => true
                ]) ?>

                <?= $this->Form->control('item_master_id', [
                    'label' => 'Item Master',
                    'options' => $itemMasters,
                    'empty' => 'Selecione...',
                    'required' => true
                ]) ?>

                <?= $this->Form->control('item_master_version') ?>

                <?= $this->Form->control('ordem', [
                    'type' => 'number',
                    'min' => 1
                ]) ?>

                <?= $this->Form->control('metodologia', [
                    'type' => 'textarea'
                ]) ?>

                <?= $this->Form->control('rigor_tecnico', [
                    'type' => 'textarea'
                ]) ?>

                <?= $this->Form->control('acao_imediata', [
                    'type' => 'textarea'
                ]) ?>

                <?= $this->Form->control('required', [
                    'type' => 'checkbox',
                    'label' => 'Required?'
                ]) ?>

                <?= $this->Form->control('notes', [
                    'type' => 'textarea'
                ]) ?>

            </fieldset>

            <?= $this->Form->button(__('Save Changes')) ?>
            <?= $this->Form->end() ?>

        </div>
    </div>
</div>
