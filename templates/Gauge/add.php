<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Gauge $gauge
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Gauge'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="gauge form content">
            <?= $this->Form->create($gauge) ?>
            <fieldset>
                <legend><?= __('Add Gauge') ?></legend>
                <?php
                    echo $this->Form->control('serial');
                    echo $this->Form->control('tipo');
                    echo $this->Form->control('localizacao');
                    echo $this->Form->control('status');
                    echo $this->Form->control('descricao');
                    echo $this->Form->control('created_at');
                    echo $this->Form->control('updated_at');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
