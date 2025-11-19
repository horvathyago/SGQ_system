<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ChecklistTemplateVersion $checklistTemplateVersion
 * @var string[]|\Cake\Collection\CollectionInterface $checklistTemplates
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $checklistTemplateVersion->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $checklistTemplateVersion->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Checklist Template Version'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="checklistTemplateVersion form content">
            <?= $this->Form->create($checklistTemplateVersion) ?>
            <fieldset>
                <legend><?= __('Edit Checklist Template Version') ?></legend>
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
