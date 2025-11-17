<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Document> $document
 */
?>
<div class="document index content">
    <?= $this->Html->link(__('New Document'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Document') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('filename') ?></th>
                    <th><?= $this->Paginator->sort('mime_type') ?></th>
                    <th><?= $this->Paginator->sort('storage_path') ?></th>
                    <th><?= $this->Paginator->sort('uploader_id') ?></th>
                    <th><?= $this->Paginator->sort('tamanho_bytes') ?></th>
                    <th><?= $this->Paginator->sort('doc_hash') ?></th>
                    <th><?= $this->Paginator->sort('tipo') ?></th>
                    <th><?= $this->Paginator->sort('is_validated') ?></th>
                    <th><?= $this->Paginator->sort('created_at') ?></th>
                    <th><?= $this->Paginator->sort('updated_at') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($document as $document): ?>
                <tr>
                    <td><?= h($document->id) ?></td>
                    <td><?= h($document->filename) ?></td>
                    <td><?= h($document->mime_type) ?></td>
                    <td><?= h($document->storage_path) ?></td>
                    <td><?= $document->hasValue('uploader') ? $this->Html->link($document->uploader->nome, ['controller' => 'UserAccount', 'action' => 'view', $document->uploader->id]) : '' ?></td>
                    <td><?= $document->tamanho_bytes === null ? '' : $this->Number->format($document->tamanho_bytes) ?></td>
                    <td><?= h($document->doc_hash) ?></td>
                    <td><?= h($document->tipo) ?></td>
                    <td><?= h($document->is_validated) ?></td>
                    <td><?= h($document->created_at) ?></td>
                    <td><?= h($document->updated_at) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $document->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $document->id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $document->id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $document->id),
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