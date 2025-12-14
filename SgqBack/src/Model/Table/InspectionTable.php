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

        // -------------------------
        // Timestamp behavior
        // -------------------------
        // Garante que created_at e updated_at sejam preenchidos automaticamente.
        // Caso seu projeto use nomes diferentes, ajuste o mapeamento abaixo.
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

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->uuid('production_order_id')
            ->allowEmptyString('production_order_id');

        $validator
            ->uuid('checklist_template_id')
            ->allowEmptyString('checklist_template_id');

        $validator
            ->uuid('checklist_template_version_id')
            ->allowEmptyString('checklist_template_version_id');

        $validator
            ->uuid('inspector_id')
            ->allowEmptyString('inspector_id');

        $validator
            ->scalar('lot_code')
            ->maxLength('lot_code', 100)
            ->allowEmptyString('lot_code');

        $validator
            ->scalar('origem')
            ->maxLength('origem', 100)
            ->allowEmptyString('origem');

        $validator
            ->decimal('wdl_calculado')
            ->allowEmptyString('wdl_calculado');

        $validator
            ->decimal('wdl_max_utilizado')
            ->allowEmptyString('wdl_max_utilizado');

        $validator
            ->decimal('nota_final')
            ->allowEmptyString('nota_final');

        $validator
            ->scalar('status_final')
            ->maxLength('status_final', 50)
            ->allowEmptyString('status_final');

        $validator
            ->dateTime('created_at')
            ->notEmptyDateTime('created_at');

        $validator
            ->dateTime('updated_at')
            ->notEmptyDateTime('updated_at');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['production_order_id'], 'ProductionOrders'), ['errorField' => 'production_order_id']);
        $rules->add($rules->existsIn(['checklist_template_id'], 'ChecklistTemplates'), ['errorField' => 'checklist_template_id']);
        $rules->add($rules->existsIn(['checklist_template_version_id'], 'ChecklistTemplateVersions'), ['errorField' => 'checklist_template_version_id']);
        $rules->add($rules->existsIn(['inspector_id'], 'Inspectors'), ['errorField' => 'inspector_id']);

        return $rules;
    }
}
