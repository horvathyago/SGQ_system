<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ChecklistTemplateVersion $checklistTemplateVersion
 * @var \Cake\Collection\CollectionInterface|string[] $checklistTemplates
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Checklist Template Version'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="checklistTemplateVersion form content">
            <?= $this->Form->create($checklistTemplateVersion) ?>
            <fieldset>
                <legend><?= __('Add Checklist Template Version') ?></legend>
                <?php
                    echo $this->Form->control('checklist_template_id', ['options' => $checklistTemplates]);
                    echo $this->Form->control('versao');
                    echo $this->Form->control('notes');
                    echo $this->Form->control('created_at');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
