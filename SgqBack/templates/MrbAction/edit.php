<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MrbAction $mrbAction
 * @var string[]|\Cake\Collection\CollectionInterface $nonConformities
 * @var string[]|\Cake\Collection\CollectionInterface $responsavels
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $mrbAction->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $mrbAction->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Mrb Action'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="mrbAction form content">
            <?= $this->Form->create($mrbAction) ?>
            <fieldset>
                <legend><?= __('Edit Mrb Action') ?></legend>
                <?php
                    echo $this->Form->control('non_conformity_id', ['options' => $nonConformities, 'empty' => true]);
                    echo $this->Form->control('decisao');
                    echo $this->Form->control('responsavel_id', ['options' => $responsavels, 'empty' => true]);
                    echo $this->Form->control('observacoes');
                    echo $this->Form->control('created_at');
                    echo $this->Form->control('updated_at');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
