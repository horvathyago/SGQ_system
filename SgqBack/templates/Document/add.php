<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Document $document
 * @var \Cake\Collection\CollectionInterface|string[] $uploaders
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Document'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="document form content">
            <?= $this->Form->create($document) ?>
            <fieldset>
                <legend><?= __('Add Document') ?></legend>
                <?php
                    echo $this->Form->control('filename');
                    echo $this->Form->control('mime_type');
                    echo $this->Form->control('storage_path');
                    echo $this->Form->control('uploader_id', ['options' => $uploaders, 'empty' => true]);
                    echo $this->Form->control('tamanho_bytes');
                    echo $this->Form->control('doc_hash');
                    echo $this->Form->control('tipo');
                    echo $this->Form->control('descricao');
                    echo $this->Form->control('is_validated');
                    echo $this->Form->control('created_at');
                    echo $this->Form->control('updated_at');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
