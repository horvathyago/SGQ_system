<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ItemMaster $itemMaster
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>

            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $itemMaster->id],
                [
                    'confirm' => __('Are you sure you want to delete # {0}?', $itemMaster->id),
                    'class' => 'side-nav-item'
                ]
            ) ?>

            <?= $this->Html->link(__('List Item Master'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>

            <!-- 🔥 Botão separado: Criar versão imediatamente -->
            <?= $this->Form->postLink(
                __('Criar Nova Versão Agora'),
                ['action' => 'criarVersao', $itemMaster->id],
                [
                    'confirm' => 'Tem certeza que deseja criar uma nova versão deste item?',
                    'class' => 'side-nav-item'
                ]
            ) ?>

        </div>
    </aside>

    <div class="column column-80">
        <div class="itemMaster form content">

            <?= $this->Form->create($itemMaster) ?>

            <fieldset>
                <legend><?= __('Edit Item Master') ?></legend>

                <?php
                    echo $this->Form->control('codigo_item');
                    echo $this->Form->control('titulo');
                    echo $this->Form->control('versao_mestra');
                    echo $this->Form->control('peso');
                    echo $this->Form->control('is_fca');
                    echo $this->Form->control('escopo');
                    echo $this->Form->control('vigente_inicio');
                    echo $this->Form->control('vigente_fim');
                    echo $this->Form->control('is_ativo');
                    echo $this->Form->control('created_at');
                    echo $this->Form->control('updated_at');

                    // ⭐ Checkbox para decidir se cria nova versão
                    echo $this->Form->control('criar_versao', [
                        'type' => 'checkbox',
                        'label' => 'Criar nova versão deste item?',
                        'hiddenField' => false
                    ]);
                ?>
            </fieldset>

            <?= $this->Form->button(__('Salvar Alterações')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
