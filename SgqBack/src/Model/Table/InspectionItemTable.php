<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * InspectionItemTable
 * Responsável pelos ITENS individuais (respostas) da inspeção.
 */
class InspectionItemTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('inspection_item');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        // Associações
        $this->belongsTo('Inspection', [
            'foreignKey' => 'inspection_id',
            'className' => 'Inspection',
        ]);

        $this->belongsTo('TemplateItem', [
            'foreignKey' => 'template_item_id',
            'className' => 'TemplateItem',
        ]);

        $this->belongsTo('ItemMaster', [
            'foreignKey' => 'item_master_id',
            'className' => 'ItemMaster',
        ]);

        // 🚨 COMENTE ESTE BLOCO ABAIXO PARA CORRIGIR O ERRO 🚨
        // O erro acontece porque o arquivo CalibrationRecordsTable.php não existe.
        /* $this->hasMany('CalibrationRecords', [
            'foreignKey' => 'inspection_item_id',
        ]);
        */
        
        $this->hasOne('NonConformity', [
            'foreignKey' => 'inspection_item_id',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->uuid('inspection_id')
            ->notEmptyString('inspection_id');

        $validator
            ->uuid('item_master_id')
            ->allowEmptyString('item_master_id');

        $validator
            ->uuid('template_item_id')
            ->allowEmptyString('template_item_id');

        $validator
            ->integer('ordem')
            ->allowEmptyString('ordem');

        $validator
            ->scalar('measured_value')
            ->maxLength('measured_value', 255)
            ->allowEmptyString('measured_value');

        $validator
            ->scalar('comentario')
            ->allowEmptyString('comentario');

        $validator
            ->boolean('is_ok')
            ->allowEmptyString('is_ok');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        // 3. Regras de integridade usando os Aliases no SINGULAR definidos no initialize
        $rules->add($rules->existsIn(['inspection_id'], 'Inspection'), ['errorField' => 'inspection_id']);
        $rules->add($rules->existsIn(['template_item_id'], 'TemplateItem'), ['errorField' => 'template_item_id']);
        
        // Opcional: só descomente se tiver certeza que ItemMaster existe sempre
        // $rules->add($rules->existsIn(['item_master_id'], 'ItemMaster'), ['errorField' => 'item_master_id']);

        return $rules;
    }
}