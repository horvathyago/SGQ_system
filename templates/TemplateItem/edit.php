<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TemplateItem $templateItem
 * @var string[]|\Cake\Collection\CollectionInterface $checklistTemplateVersions
 * @var string[]|\Cake\Collection\CollectionInterface $itemMasters
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $templateItem->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $templateItem->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Template Item'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="templateItem form content">
            <?= $this->Form->create($templateItem) ?>
            <fieldset>
                <legend><?= __('Edit Template Item') ?></legend>
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
