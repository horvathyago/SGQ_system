<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Document $document
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Document'), ['action' => 'edit', $document->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Document'), ['action' => 'delete', $document->id], ['confirm' => __('Are you sure you want to delete # {0}?', $document->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Document'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Document'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="document view content">
            <h3><?= h($document->filename) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= h($document->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Filename') ?></th>
                    <td><?= h($document->filename) ?></td>
                </tr>
                <tr>
                    <th><?= __('Mime Type') ?></th>
                    <td><?= h($document->mime_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Storage Path') ?></th>
                    <td><?= h($document->storage_path) ?></td>
                </tr>
                <tr>
                    <th><?= __('Uploader') ?></th>
                    <td><?= $document->hasValue('uploader') ? $this->Html->link($document->uploader->nome, ['controller' => 'UserAccount', 'action' => 'view', $document->uploader->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Doc Hash') ?></th>
                    <td><?= h($document->doc_hash) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tipo') ?></th>
                    <td><?= h($document->tipo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tamanho Bytes') ?></th>
                    <td><?= $document->tamanho_bytes === null ? '' : $this->Number->format($document->tamanho_bytes) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created At') ?></th>
                    <td><?= h($document->created_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Updated At') ?></th>
                    <td><?= h($document->updated_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Validated') ?></th>
                    <td><?= $document->is_validated ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Descricao') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($document->descricao)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Document Link') ?></h4>
                <?php if (!empty($document->document_link)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Document Id') ?></th>
                            <th><?= __('Entity Type') ?></th>
                            <th><?= __('Entity Id') ?></th>
                            <th><?= __('Expected Type') ?></th>
                            <th><?= __('Is Required') ?></th>
                            <th><?= __('Is Validated') ?></th>
                            <th><?= __('Created At') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($document->document_link as $documentLink) : ?>
                        <tr>
                            <td><?= h($documentLink->id) ?></td>
                            <td><?= h($documentLink->document_id) ?></td>
                            <td><?= h($documentLink->entity_type) ?></td>
                            <td><?= h($documentLink->entity_id) ?></td>
                            <td><?= h($documentLink->expected_type) ?></td>
                            <td><?= h($documentLink->is_required) ?></td>
                            <td><?= h($documentLink->is_validated) ?></td>
                            <td><?= h($documentLink->created_at) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'DocumentLink', 'action' => 'view', $documentLink->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'DocumentLink', 'action' => 'edit', $documentLink->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'DocumentLink', 'action' => 'delete', $documentLink->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $documentLink->id),
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