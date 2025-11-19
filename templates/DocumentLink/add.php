<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DocumentLink $documentLink
 * @var \Cake\Collection\CollectionInterface|string[] $documents
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Document Link'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="documentLink form content">
            <?= $this->Form->create($documentLink) ?>
            <fieldset>
                <legend><?= __('Add Document Link') ?></legend>
                <?php
                    echo $this->Form->control('document_id', ['options' => $documents]);
                    echo $this->Form->control('entity_type');
                    echo $this->Form->control('entity_id');
                    echo $this->Form->control('expected_type');
                    echo $this->Form->control('is_required');
                    echo $this->Form->control('is_validated');
                    echo $this->Form->control('created_at');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
