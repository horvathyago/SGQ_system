<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Inspection Model
 *
 * @property \App\Model\Table\ProductionOrderTable&\Cake\ORM\Association\BelongsTo $ProductionOrders
 * @property \App\Model\Table\ChecklistTemplateTable&\Cake\ORM\Association\BelongsTo $ChecklistTemplates
 * @property \App\Model\Table\ChecklistTemplateVersionTable&\Cake\ORM\Association\BelongsTo $ChecklistTemplateVersions
 * @property \App\Model\Table\UserAccountTable&\Cake\ORM\Association\BelongsTo $Inspectors
 * @property \App\Model\Table\InspectionItemTable&\Cake\ORM\Association\HasMany $InspectionItem
 *
 * @method \App\Model\Entity\Inspection newEmptyEntity()
 * @method \App\Model\Entity\Inspection newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Inspection> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Inspection get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Inspection findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Inspection patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Inspection> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Inspection|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Inspection saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Inspection>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Inspection>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Inspection>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Inspection> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Inspection>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Inspection>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Inspection>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Inspection> deleteManyOrFail(iterable $entities, array $options = [])
 */
class InspectionTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('inspection');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

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
