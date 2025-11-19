<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\CalibrationRecord> $calibrationRecord
 */
?>
<div class="calibrationRecord index content">
    <?= $this->Html->link(__('New Calibration Record'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Calibration Record') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('gauge_id') ?></th>
                    <th><?= $this->Paginator->sort('data_calibracao') ?></th>
                    <th><?= $this->Paginator->sort('validade') ?></th>
                    <th><?= $this->Paginator->sort('laudo_document_id') ?></th>
                    <th><?= $this->Paginator->sort('versao') ?></th>
                    <th><?= $this->Paginator->sort('created_at') ?></th>
                    <th><?= $this->Paginator->sort('updated_at') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($calibrationRecord as $calibrationRecord): ?>
                <tr>
                    <td><?= h($calibrationRecord->id) ?></td>
                    <td><?= $calibrationRecord->hasValue('gauge') ? $this->Html->link($calibrationRecord->gauge->id, ['controller' => 'Gauge', 'action' => 'view', $calibrationRecord->gauge->id]) : '' ?></td>
                    <td><?= h($calibrationRecord->data_calibracao) ?></td>
                    <td><?= h($calibrationRecord->validade) ?></td>
                    <td><?= $calibrationRecord->hasValue('laudo_document') ? $this->Html->link($calibrationRecord->laudo_document->filename, ['controller' => 'Document', 'action' => 'view', $calibrationRecord->laudo_document->id]) : '' ?></td>
                    <td><?= $calibrationRecord->versao === null ? '' : $this->Number->format($calibrationRecord->versao) ?></td>
                    <td><?= h($calibrationRecord->created_at) ?></td>
                    <td><?= h($calibrationRecord->updated_at) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $calibrationRecord->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $calibrationRecord->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $calibrationRecord->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $calibrationRecord->id),
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