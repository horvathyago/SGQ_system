<?php
/**
 * @var \App\View\AppView $this
 * @var array $authFields
 */
?>

<?php $this->assign('title', 'Acesso ao Sistema'); ?>

<div class="row">
    <div class="column column-40 column-offset-30">
        <div class="users form content">

            <?= $this->Form->create() ?>
            <fieldset>
                <legend><?= __('Acesso ao Sistema') ?></legend>

                <?php
                    echo $this->Form->control('email', [
                        'required' => true,
                        'label' => 'E-mail de Acesso',
                        'type' => 'email'
                    ]);

                    echo $this->Form->control('password_hash', [
                        'required' => true,
                        'label' => 'Senha',
                        'type' => 'password'
                    ]);
                ?>
            </fieldset>

            <?= $this->Form->button(__('Entrar'), ['class' => 'button primary']) ?>
            <?= $this->Form->end() ?>

        </div>
    </div>
</div>
