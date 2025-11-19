<?php
/**
 * @var \App\View\AppView $this
 * @var array $authFields Variáveis que o Authentication passa implicitamente (email/password)
 */
?>
<div class="row">
    <div class="column column-40 column-offset-30">
        <div class="users form content">
            
            <?= $this->Form->create() ?>
            <fieldset>
                <legend><?= __('Acesso ao Sistema') ?></legend>
                
                <?php
                    // Assumindo que seu campo de login é 'email'
                    // O FormHelper injeta o nome da coluna correto no POST.
                    echo $this->Form->control('email', [
                        'required' => true,
                        'label' => 'E-mail de Acesso', // Rótulo em português
                        'type' => 'email'
                    ]);
                    
                    // O campo 'password'
                    echo $this->Form->control('password', [
                        'required' => true,
                        'label' => 'Senha',
                        'type' => 'password'
                    ]);
                ?>
            </fieldset>
            
            <?= $this->Form->button(__('Entrar'), ['class' => 'button primary']) ?>
            <?= $this->Form->end() ?>
            </p>
        </div>
    </div>
</div>