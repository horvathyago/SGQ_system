<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CalibrationRecord $calibrationRecord
 * @var string[]|\Cake\Collection\CollectionInterface $gauges
 * @var string[]|\Cake\Collection\CollectionInterface $laudoDocuments
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $calibrationRecord->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $calibrationRecord->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Calibration Record'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="calibrationRecord form content">
            <?= $this->Form->create($calibrationRecord) ?>
            <fieldset>
                <legend><?= __('Edit Calibration Record') ?></legend>
                <?php
                    echo $this->Form->control('gauge_id', ['options' => $gauges, 'empty' => true]);
                    echo $this->Form->control('data_calibracao');
                    echo $this->Form->control('validade');
                    echo $this->Form->control('laudo_document_id', ['options' => $laudoDocuments, 'empty' => true]);
                    echo $this->Form->control('versao');
                    echo $this->Form->control('created_at');
                    echo $this->Form->control('updated_at');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
