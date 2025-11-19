<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ProductFamilyChecklist $productFamilyChecklist
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Product Family Checklist'), ['action' => 'edit', $productFamilyChecklist->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Product Family Checklist'), ['action' => 'delete', $productFamilyChecklist->id], ['confirm' => __('Are you sure you want to delete # {0}?', $productFamilyChecklist->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Product Family Checklist'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Product Family Checklist'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="productFamilyChecklist view content">
            <h3><?= h($productFamilyChecklist->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= h($productFamilyChecklist->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Product Family') ?></th>
                    <td><?= $productFamilyChecklist->hasValue('product_family') ? $this->Html->link($productFamilyChecklist->product_family->codigo, ['controller' => 'ProductFamily', 'action' => 'view', $productFamilyChecklist->product_family->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Checklist Template') ?></th>
                    <td><?= $productFamilyChecklist->hasValue('checklist_template') ? $this->Html->link($productFamilyChecklist->checklist_template->name, ['controller' => 'ChecklistTemplate', 'action' => 'view', $productFamilyChecklist->checklist_template->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Tipo') ?></th>
                    <td><?= h($productFamilyChecklist->tipo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created At') ?></th>
                    <td><?= h($productFamilyChecklist->created_at) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>