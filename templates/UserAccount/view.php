<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UserAccount $userAccount
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit User Account'), ['action' => 'edit', $userAccount->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete User Account'), ['action' => 'delete', $userAccount->id], ['confirm' => __('Are you sure you want to delete # {0}?', $userAccount->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List User Account'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New User Account'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="userAccount view content">
            <h3><?= h($userAccount->nome) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= h($userAccount->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nome') ?></th>
                    <td><?= h($userAccount->nome) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($userAccount->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Role') ?></th>
                    <td><?= h($userAccount->role) ?></td>
                </tr>
                <tr>
                    <th><?= __('Password Hash') ?></th>
                    <td><?= h($userAccount->password_hash) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created At') ?></th>
                    <td><?= h($userAccount->created_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Updated At') ?></th>
                    <td><?= h($userAccount->updated_at) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>