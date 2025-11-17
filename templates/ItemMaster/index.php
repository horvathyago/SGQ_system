<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ItemMaster> $itemMaster
 */
?>
<div class="itemMaster index content">
    <?= $this->Html->link(__('New Item Master'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Item Master') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('codigo_item') ?></th>
                    <th><?= $this->Paginator->sort('titulo') ?></th>
                    <th><?= $this->Paginator->sort('versao_mestra') ?></th>
                    <th><?= $this->Paginator->sort('peso') ?></th>
                    <th><?= $this->Paginator->sort('is_fca') ?></th>
                    <th><?= $this->Paginator->sort('escopo') ?></th>
                    <th><?= $this->Paginator->sort('vigente_inicio') ?></th>
                    <th><?= $this->Paginator->sort('vigente_fim') ?></th>
                    <th><?= $this->Paginator->sort('is_ativo') ?></th>
                    <th><?= $this->Paginator->sort('created_at') ?></th>
                    <th><?= $this->Paginator->sort('updated_at') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($itemMaster as $itemMaster): ?>
                <tr>
                    <td><?= h($itemMaster->id) ?></td>
                    <td><?= h($itemMaster->codigo_item) ?></td>
                    <td><?= h($itemMaster->titulo) ?></td>
                    <td><?= $itemMaster->versao_mestra === null ? '' : $this->Number->format($itemMaster->versao_mestra) ?></td>
                    <td><?= $itemMaster->peso === null ? '' : $this->Number->format($itemMaster->peso) ?></td>
                    <td><?= h($itemMaster->is_fca) ?></td>
                    <td><?= h($itemMaster->escopo) ?></td>
                    <td><?= h($itemMaster->vigente_inicio) ?></td>
                    <td><?= h($itemMaster->vigente_fim) ?></td>
                    <td><?= h($itemMaster->is_ativo) ?></td>
                    <td><?= h($itemMaster->created_at) ?></td>
                    <td><?= h($itemMaster->updated_at) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $itemMaster->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $itemMaster->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $itemMaster->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $itemMaster->id),
                            ]
                        ) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>