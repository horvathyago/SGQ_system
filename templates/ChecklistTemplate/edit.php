<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ChecklistTemplate $checklistTemplate
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>

            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $checklistTemplate->id],
                [
                    'confirm' => __('Are you sure you want to delete # {0}?', $checklistTemplate->id),
                    'class' => 'side-nav-item'
                ]
            ) ?>

            <?= $this->Html->link(__('List Checklist Template'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>

            <!-- 🔥 BOTÃO OPCIONAL PARA CRIAR NOVA VERSÃO DIRETAMENTE -->
            <?= $this->Form->postLink(
                __('Criar Nova Versão Agora'),
                ['action' => 'criarVersao', $checklistTemplate->id],
                [
                    'confirm' => 'Tem certeza que deseja criar uma nova versão deste checklist?',
                    'class' => 'side-nav-item'
                ]
            ) ?>
        </div>
    </aside>

    <div class="column column-80">
        <div class="checklistTemplate form content">
            <?= $this->Form->create($checklistTemplate) ?>

            <fieldset>
                <legend><?= __('Edit Checklist Template') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('tipo');
                    echo $this->Form->control('descricao');
                    echo $this->Form->control('is_active');
                    echo $this->Form->control('created_at');
                    echo $this->Form->control('updated_at');

                    // ⭐ Checkbox que aciona a criação de nova versão no EDIT
                    echo $this->Form->control('criar_versao', [
                        'type' => 'checkbox',
                        'label' => 'Criar nova versão ao salvar?',
                        'hiddenField' => false
                    ]);
                ?>
            </fieldset>

            <?= $this->Form->button(__('Salvar Alterações')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
