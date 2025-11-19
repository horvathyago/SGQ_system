<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\DocumentLink> $documentLink
 */
?>
<div class="documentLink index content">
    <?= $this->Html->link(__('New Document Link'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Document Link') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('document_id') ?></th>
                    <th><?= $this->Paginator->sort('entity_type') ?></th>
                    <th><?= $this->Paginator->sort('entity_id') ?></th>
                    <th><?= $this->Paginator->sort('expected_type') ?></th>
                    <th><?= $this->Paginator->sort('is_required') ?></th>
                    <th><?= $this->Paginator->sort('is_validated') ?></th>
                    <th><?= $this->Paginator->sort('created_at') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($documentLink as $documentLink): ?>
                <tr>
                    <td><?= h($documentLink->id) ?></td>
                    <td><?= $documentLink->hasValue('document') ? $this->Html->link($documentLink->document->filename, ['controller' => 'Document', 'action' => 'view', $documentLink->document->id]) : '' ?></td>
                    <td><?= h($documentLink->entity_type) ?></td>
                    <td><?= h($documentLink->entity_id) ?></td>
                    <td><?= h($documentLink->expected_type) ?></td>
                    <td><?= h($documentLink->is_required) ?></td>
                    <td><?= h($documentLink->is_validated) ?></td>
                    <td><?= h($documentLink->created_at) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $documentLink->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $documentLink->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $documentLink->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $documentLink->id),
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