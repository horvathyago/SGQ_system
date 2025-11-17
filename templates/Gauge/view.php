<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Gauge $gauge
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Gauge'), ['action' => 'edit', $gauge->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Gauge'), ['action' => 'delete', $gauge->id], ['confirm' => __('Are you sure you want to delete # {0}?', $gauge->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Gauge'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Gauge'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="gauge view content">
            <h3><?= h($gauge->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= h($gauge->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Serial') ?></th>
                    <td><?= h($gauge->serial) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tipo') ?></th>
                    <td><?= h($gauge->tipo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Localizacao') ?></th>
                    <td><?= h($gauge->localizacao) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($gauge->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created At') ?></th>
                    <td><?= h($gauge->created_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Updated At') ?></th>
                    <td><?= h($gauge->updated_at) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Descricao') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($gauge->descricao)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Calibration Record') ?></h4>
                <?php if (!empty($gauge->calibration_record)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Gauge Id') ?></th>
                            <th><?= __('Data Calibracao') ?></th>
                            <th><?= __('Validade') ?></th>
                            <th><?= __('Laudo Document Id') ?></th>
                            <th><?= __('Versao') ?></th>
                            <th><?= __('Created At') ?></th>
                            <th><?= __('Updated At') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($gauge->calibration_record as $calibrationRecord) : ?>
                        <tr>
                            <td><?= h($calibrationRecord->id) ?></td>
                            <td><?= h($calibrationRecord->gauge_id) ?></td>
                            <td><?= h($calibrationRecord->data_calibracao) ?></td>
                            <td><?= h($calibrationRecord->validade) ?></td>
                            <td><?= h($calibrationRecord->laudo_document_id) ?></td>
                            <td><?= h($calibrationRecord->versao) ?></td>
                            <td><?= h($calibrationRecord->created_at) ?></td>
                            <td><?= h($calibrationRecord->updated_at) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'CalibrationRecord', 'action' => 'view', $calibrationRecord->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'CalibrationRecord', 'action' => 'edit', $calibrationRecord->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'CalibrationRecord', 'action' => 'delete', $calibrationRecord->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $calibrationRecord->id),
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