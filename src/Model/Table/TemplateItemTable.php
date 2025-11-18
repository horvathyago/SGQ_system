<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\RulesChecker;

class TemplateItemTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        // Força tabela singular no banco
        $this->setTable('template_item');
        $this->setPrimaryKey('id');
        $this->setDisplayField('id'); // Dica: Mude 'id' para um campo mais legível se houver (ex: 'nome')

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created_at' => 'new'
                ]
            ]
        ]);

        // --- CORREÇÃO DEFINITIVA DA ASSOCIAÇÃO ---
        // Alias: 'ChecklistTemplate' (Singular, para usar no Controller)
        // className: 'ChecklistTemplate' (Procura por ChecklistTemplateTable.php)
        // foreignKey: 'checklist_template_version_id' (O campo real no seu banco)
        $this->belongsTo('ChecklistTemplate', [
            'className' => 'ChecklistTemplate', 
            'foreignKey' => 'checklist_template_version_id',
            'joinType' => 'LEFT',
        ]);

        // Mesma lógica para ItemMaster
        $this->belongsTo('ItemMaster', [
            'className' => 'ItemMaster',
            'foreignKey' => 'item_master_id',
            'joinType' => 'LEFT',
        ]);

        $this->hasMany('InspectionItem', [
            'foreignKey' => 'template_item_id',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->uuid('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('checklist_template_version_id')
            ->maxLength('checklist_template_version_id', 36)
            ->notEmptyString('checklist_template_version_id');

        $validator
            ->scalar('item_master_id')
            ->maxLength('item_master_id', 36)
            ->notEmptyString('item_master_id');

        $validator
            ->integer('ordem')
            ->greaterThanOrEqual('ordem', 0)
            ->notEmptyString('ordem');

        $validator->boolean('acao_imediata')->allowEmptyString('acao_imediata');
        $validator->boolean('required')->allowEmptyString('required');
        $validator->allowEmptyString('notes');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        // Usa o Alias definido no initialize ('ChecklistTemplate')
        $rules->add($rules->existsIn(['checklist_template_version_id'], 'ChecklistTemplate'), ['errorField' => 'checklist_template_version_id']);
        $rules->add($rules->existsIn(['item_master_id'], 'ItemMaster'), ['errorField' => 'item_master_id']);

        return $rules;
    }
}