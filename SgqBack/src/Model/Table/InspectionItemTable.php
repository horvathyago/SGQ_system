<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class InspectionTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('inspection');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        // Timestamp behavior: popula created_at / updated_at automaticamente
        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created_at' => 'new',
                    'updated_at' => 'always'
                ]
            ]
        ]);

        $this->belongsTo('ProductionOrders', [
            'foreignKey' => 'production_order_id',
            'className' => 'ProductionOrder',
        ]);
        $this->belongsTo('ChecklistTemplates', [
            'foreignKey' => 'checklist_template_id',
            'className' => 'ChecklistTemplate',
        ]);
        $this->belongsTo('ChecklistTemplateVersions', [
            'foreignKey' => 'checklist_template_version_id',
            'className' => 'ChecklistTemplateVersion',
        ]);
        $this->belongsTo('Inspectors', [
            'foreignKey' => 'inspector_id',
            'className' => 'UserAccount',
        ]);
        $this->hasMany('InspectionItem', [
            'foreignKey' => 'inspection_id',
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
            ->integer('item_master_version')
            ->allowEmptyString('item_master_version');

        $validator
            ->uuid('template_item_id')
            ->allowEmptyString('template_item_id');

        $validator
            ->integer('ordem')
            ->allowEmptyString('ordem');

        // Ajuste: codigo_item_snapshot não é mais obrigatório na criação via API batch.
        // Se a regra de negócio exigir, reforce no frontend para enviar esse campo.
        $validator
            ->scalar('codigo_item_snapshot')
            ->maxLength('codigo_item_snapshot', 100)
            ->allowEmptyString('codigo_item_snapshot');

        $validator
            ->scalar('titulo_snapshot')
            ->maxLength('titulo_snapshot', 255)
            ->allowEmptyString('titulo_snapshot');

        $validator
            ->decimal('peso_snapshot')
            ->allowEmptyString('peso_snapshot');

        $validator
            ->boolean('is_fca_snapshot')
            ->allowEmptyString('is_fca_snapshot');

        $validator
            ->scalar('escopo_snapshot')
            ->maxLength('escopo_snapshot', 255)
            ->allowEmptyString('escopo_snapshot');

        $validator
            ->integer('nota_inspector')
            ->allowEmptyString('nota_inspector');

        $validator
            ->boolean('is_nsa')
            ->allowEmptyString('is_nsa');

        // Observação: O nome do campo no modelo é 'measured_value' — certifique-se de enviar este campo do frontend.
        $validator
            ->scalar('measured_value')
            ->maxLength('measured_value', 255)
            ->allowEmptyString('measured_value');

        $validator
            ->scalar('comentario')
            ->allowEmptyString('comentario');

        $validator
            ->decimal('wdl_calculado')
            ->allowEmptyString('wdl_calculado');

        $validator
            ->boolean('requires_evidence')
            ->allowEmptyString('requires_evidence');

        $validator
            ->boolean('has_evidence')
            ->allowEmptyString('has_evidence');

        $validator
            ->uuid('calibration_record_id')
            ->allowEmptyString('calibration_record_id');

        $validator
            ->dateTime('created_at')
            ->notEmptyDateTime('created_at');

        $validator
            ->dateTime('updated_at')
            ->notEmptyDateTime('updated_at');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['inspection_id'], 'Inspections'), ['errorField' => 'inspection_id']);
        $rules->add($rules->existsIn(['item_master_id'], 'ItemMasters'), ['errorField' => 'item_master_id']);
        $rules->add($rules->existsIn(['template_item_id'], 'TemplateItems'), ['errorField' => 'template_item_id']);
        $rules->add($rules->existsIn(['calibration_record_id'], 'CalibrationRecords'), ['errorField' => 'calibration_record_id']);

        return $rules;
    }
}
