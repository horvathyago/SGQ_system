<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ChecklistTemplate $checklistTemplate
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Checklist Template'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="checklistTemplate form content">
            <?= $this->Form->create($checklistTemplate) ?>
            <fieldset>
                <legend><?= __('Add Checklist Template') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('tipo');
                    echo $this->Form->control('descricao');
                    echo $this->Form->control('is_active');
                    echo $this->Form->control('created_at');
                    echo $this->Form->control('updated_at');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
