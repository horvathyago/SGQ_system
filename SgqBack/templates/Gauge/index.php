<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Gauge> $gauge
 */
?>
<div class="gauge index content">
    <?= $this->Html->link(__('New Gauge'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Gauge') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('serial') ?></th>
                    <th><?= $this->Paginator->sort('tipo') ?></th>
                    <th><?= $this->Paginator->sort('localizacao') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('created_at') ?></th>
                    <th><?= $this->Paginator->sort('updated_at') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($gauge as $gauge): ?>
                <tr>
                    <td><?= h($gauge->id) ?></td>
                    <td><?= h($gauge->serial) ?></td>
                    <td><?= h($gauge->tipo) ?></td>
                    <td><?= h($gauge->localizacao) ?></td>
                    <td><?= h($gauge->status) ?></td>
                    <td><?= h($gauge->created_at) ?></td>
                    <td><?= h($gauge->updated_at) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $gauge->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $gauge->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $gauge->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $gauge->id),
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