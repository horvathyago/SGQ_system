<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ProcessIndex $processIndex
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Process Index'), ['action' => 'edit', $processIndex->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Process Index'), ['action' => 'delete', $processIndex->id], ['confirm' => __('Are you sure you want to delete # {0}?', $processIndex->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Process Index'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Process Index'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="processIndex view content">
            <h3><?= h($processIndex->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= h($processIndex->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Indicador') ?></th>
                    <td><?= h($processIndex->indicador) ?></td>
                </tr>
                <tr>
                    <th><?= __('Product Family') ?></th>
                    <td><?= $processIndex->hasValue('product_family') ? $this->Html->link($processIndex->product_family->codigo, ['controller' => 'ProductFamily', 'action' => 'view', $processIndex->product_family->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Unidade') ?></th>
                    <td><?= h($processIndex->unidade) ?></td>
                </tr>
                <tr>
                    <th><?= __('Valor') ?></th>
                    <td><?= $processIndex->valor === null ? '' : $this->Number->format($processIndex->valor) ?></td>
                </tr>
                <tr>
                    <th><?= __('Periodo') ?></th>
                    <td><?= h($processIndex->periodo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created At') ?></th>
                    <td><?= h($processIndex->created_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Updated At') ?></th>
                    <td><?= h($processIndex->updated_at) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Detalhes') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($processIndex->detalhes)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>