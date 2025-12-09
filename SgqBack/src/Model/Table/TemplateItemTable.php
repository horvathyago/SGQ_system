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

        $this->setTable('template_item');
        $this->setPrimaryKey('id');
        $this->setDisplayField('id');

        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created_at' => 'new'
                ]
            ]
        ]);

        $this->belongsTo('ChecklistTemplate', [
            'className' => 'ChecklistTemplate',
            'foreignKey' => 'checklist_template_id',
            'joinType' => 'INNER'
        ]);

        $this->belongsTo('ItemMaster', [
            'className' => 'ItemMaster',
            'foreignKey' => 'item_master_id',
            'joinType' => 'INNER'
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->uuid('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->uuid('checklist_template_id', 'Formato inválido de UUID')
            ->requirePresence('checklist_template_id', 'create')
            ->notEmptyString('checklist_template_id', 'Checklist Template é obrigatório');

        $validator
            ->uuid('item_master_id', 'Formato inválido de UUID')
            ->requirePresence('item_master_id', 'create')
            ->notEmptyString('item_master_id', 'Item Master é obrigatório');

        $validator
            ->integer('ordem')
            ->requirePresence('ordem', 'create')
            ->notEmptyString('ordem', 'Informe a ordem do item.');

        $validator->allowEmptyString('item_master_version');
        $validator->allowEmptyString('metodologia');
        $validator->allowEmptyString('rigor_tecnico');
        $validator->allowEmptyString('acao_imediata');
        $validator->boolean('required')->allowEmptyString('required');
        $validator->allowEmptyString('notes');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['checklist_template_id'], 'ChecklistTemplate'), ['errorField' => 'checklist_template_id', 'message' => 'Checklist template inválido.']);
        $rules->add($rules->existsIn(['item_master_id'], 'ItemMaster'), ['errorField' => 'item_master_id', 'message' => 'Item master inválido.']);

        return $rules;
    }
}
