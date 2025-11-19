<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ProcessIndex $processIndex
 * @var string[]|\Cake\Collection\CollectionInterface $productFamilies
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $processIndex->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $processIndex->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Process Index'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="processIndex form content">
            <?= $this->Form->create($processIndex) ?>
            <fieldset>
                <legend><?= __('Edit Process Index') ?></legend>
                <?php
                    echo $this->Form->control('periodo', ['empty' => true]);
                    echo $this->Form->control('indicador');
                    echo $this->Form->control('product_family_id', ['options' => $productFamilies, 'empty' => true]);
                    echo $this->Form->control('valor');
                    echo $this->Form->control('unidade');
                    echo $this->Form->control('detalhes');
                    echo $this->Form->control('created_at');
                    echo $this->Form->control('updated_at');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
