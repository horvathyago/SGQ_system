<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ItemMaster $itemMaster
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Item Master'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="itemMaster form content">
            <?= $this->Form->create($itemMaster) ?>
            <fieldset>
                <legend><?= __('Add Item Master') ?></legend>
                <?php
                    echo $this->Form->control('codigo_item');
                    echo $this->Form->control('titulo');
                    echo $this->Form->control('versao_mestra');
                    echo $this->Form->control('peso');
                    echo $this->Form->control('is_fca');
                    echo $this->Form->control('escopo');
                    echo $this->Form->control('vigente_inicio');
                    echo $this->Form->control('vigente_fim');
                    echo $this->Form->control('is_ativo');
                    echo $this->Form->control('created_at');
                    echo $this->Form->control('updated_at');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
