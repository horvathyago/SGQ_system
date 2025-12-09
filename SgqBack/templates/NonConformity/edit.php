<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\NonConformity $nonConformity
 * @var string[]|\Cake\Collection\CollectionInterface $inspectionItems
 * @var string[]|\Cake\Collection\CollectionInterface $responsavels
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $nonConformity->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $nonConformity->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Non Conformity'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="nonConformity form content">
            <?= $this->Form->create($nonConformity) ?>
            <fieldset>
                <legend><?= __('Edit Non Conformity') ?></legend>
                <?php
                    echo $this->Form->control('inspection_item_id', ['options' => $inspectionItems, 'empty' => true]);
                    echo $this->Form->control('descricao');
                    echo $this->Form->control('severity');
                    echo $this->Form->control('is_fca_trigger');
                    echo $this->Form->control('disposition');
                    echo $this->Form->control('responsavel_id', ['options' => $responsavels, 'empty' => true]);
                    echo $this->Form->control('status');
                    echo $this->Form->control('created_at');
                    echo $this->Form->control('updated_at');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
