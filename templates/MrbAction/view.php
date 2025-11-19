<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\MrbAction $mrbAction
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Mrb Action'), ['action' => 'edit', $mrbAction->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Mrb Action'), ['action' => 'delete', $mrbAction->id], ['confirm' => __('Are you sure you want to delete # {0}?', $mrbAction->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Mrb Action'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Mrb Action'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="mrbAction view content">
            <h3><?= h($mrbAction->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= h($mrbAction->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Non Conformity') ?></th>
                    <td><?= $mrbAction->hasValue('non_conformity') ? $this->Html->link($mrbAction->non_conformity->id, ['controller' => 'NonConformity', 'action' => 'view', $mrbAction->non_conformity->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Decisao') ?></th>
                    <td><?= h($mrbAction->decisao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Responsavel') ?></th>
                    <td><?= $mrbAction->hasValue('responsavel') ? $this->Html->link($mrbAction->responsavel->nome, ['controller' => 'UserAccount', 'action' => 'view', $mrbAction->responsavel->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Created At') ?></th>
                    <td><?= h($mrbAction->created_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Updated At') ?></th>
                    <td><?= h($mrbAction->updated_at) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Observacoes') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($mrbAction->observacoes)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>