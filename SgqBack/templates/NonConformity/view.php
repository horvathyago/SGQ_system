<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\NonConformity $nonConformity
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Non Conformity'), ['action' => 'edit', $nonConformity->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Non Conformity'), ['action' => 'delete', $nonConformity->id], ['confirm' => __('Are you sure you want to delete # {0}?', $nonConformity->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Non Conformity'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Non Conformity'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="nonConformity view content">
            <h3><?= h($nonConformity->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= h($nonConformity->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Inspection Item') ?></th>
                    <td><?= $nonConformity->hasValue('inspection_item') ? $this->Html->link($nonConformity->inspection_item->codigo_item_snapshot, ['controller' => 'InspectionItem', 'action' => 'view', $nonConformity->inspection_item->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Severity') ?></th>
                    <td><?= h($nonConformity->severity) ?></td>
                </tr>
                <tr>
                    <th><?= __('Disposition') ?></th>
                    <td><?= h($nonConformity->disposition) ?></td>
                </tr>
                <tr>
                    <th><?= __('Responsavel') ?></th>
                    <td><?= $nonConformity->hasValue('responsavel') ? $this->Html->link($nonConformity->responsavel->nome, ['controller' => 'UserAccount', 'action' => 'view', $nonConformity->responsavel->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($nonConformity->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created At') ?></th>
                    <td><?= h($nonConformity->created_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Updated At') ?></th>
                    <td><?= h($nonConformity->updated_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Fca Trigger') ?></th>
                    <td><?= $nonConformity->is_fca_trigger ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Descricao') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($nonConformity->descricao)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Mrb Action') ?></h4>
                <?php if (!empty($nonConformity->mrb_action)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Non Conformity Id') ?></th>
                            <th><?= __('Decisao') ?></th>
                            <th><?= __('Responsavel Id') ?></th>
                            <th><?= __('Observacoes') ?></th>
                            <th><?= __('Created At') ?></th>
                            <th><?= __('Updated At') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($nonConformity->mrb_action as $mrbAction) : ?>
                        <tr>
                            <td><?= h($mrbAction->id) ?></td>
                            <td><?= h($mrbAction->non_conformity_id) ?></td>
                            <td><?= h($mrbAction->decisao) ?></td>
                            <td><?= h($mrbAction->responsavel_id) ?></td>
                            <td><?= h($mrbAction->observacoes) ?></td>
                            <td><?= h($mrbAction->created_at) ?></td>
                            <td><?= h($mrbAction->updated_at) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'MrbAction', 'action' => 'view', $mrbAction->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'MrbAction', 'action' => 'edit', $mrbAction->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'MrbAction', 'action' => 'delete', $mrbAction->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $mrbAction->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>