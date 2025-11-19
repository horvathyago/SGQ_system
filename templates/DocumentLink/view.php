<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\DocumentLink $documentLink
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Document Link'), ['action' => 'edit', $documentLink->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Document Link'), ['action' => 'delete', $documentLink->id], ['confirm' => __('Are you sure you want to delete # {0}?', $documentLink->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Document Link'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Document Link'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="documentLink view content">
            <h3><?= h($documentLink->entity_type) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= h($documentLink->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Document') ?></th>
                    <td><?= $documentLink->hasValue('document') ? $this->Html->link($documentLink->document->filename, ['controller' => 'Document', 'action' => 'view', $documentLink->document->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Entity Type') ?></th>
                    <td><?= h($documentLink->entity_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Entity Id') ?></th>
                    <td><?= h($documentLink->entity_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Expected Type') ?></th>
                    <td><?= h($documentLink->expected_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created At') ?></th>
                    <td><?= h($documentLink->created_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Required') ?></th>
                    <td><?= $documentLink->is_required ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Validated') ?></th>
                    <td><?= $documentLink->is_validated ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>