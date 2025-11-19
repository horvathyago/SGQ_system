<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * InspectionItem Model
 *
 * @property \App\Model\Table\InspectionTable&\Cake\ORM\Association\BelongsTo $Inspections
 * @property \App\Model\Table\ItemMasterTable&\Cake\ORM\Association\BelongsTo $ItemMasters
 * @property \App\Model\Table\TemplateItemTable&\Cake\ORM\Association\BelongsTo $TemplateItems
 * @property \App\Model\Table\CalibrationRecordTable&\Cake\ORM\Association\BelongsTo $CalibrationRecords
 * @property \App\Model\Table\NonConformityTable&\Cake\ORM\Association\HasMany $NonConformity
 *
 * @method \App\Model\Entity\InspectionItem newEmptyEntity()
 * @method \App\Model\Entity\InspectionItem newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\InspectionItem> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\InspectionItem get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\InspectionItem findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\InspectionItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\InspectionItem> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\InspectionItem|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\InspectionItem saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\InspectionItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\InspectionItem>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\InspectionItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\InspectionItem> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\InspectionItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\InspectionItem>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\InspectionItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\InspectionItem> deleteManyOrFail(iterable $entities, array $options = [])
 */
class InspectionItemTable extends Table
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

        $this->setTable('inspection_item');
        $this->setDisplayField('codigo_item_snapshot');
        $this->setPrimaryKey('id');

        $this->belongsTo('Inspections', [
            'foreignKey' => 'inspection_id',
            'className' => 'Inspection',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ItemMasters', [
            'foreignKey' => 'item_master_id',
            'className' => 'ItemMaster',
        ]);
        $this->belongsTo('TemplateItems', [
            'foreignKey' => 'template_item_id',
            'className' => 'TemplateItem',
        ]);
        $this->belongsTo('CalibrationRecords', [
            'foreignKey' => 'calibration_record_id',
            'className' => 'CalibrationRecord',
        ]);
        $this->hasMany('NonConformity', [
            'foreignKey' => 'inspection_item_id',
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

        $validator
            ->scalar('codigo_item_snapshot')
            ->maxLength('codigo_item_snapshot', 100)
            ->requirePresence('codigo_item_snapshot', 'create')
            ->notEmptyString('codigo_item_snapshot');

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

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['inspection_id'], 'Inspections'), ['errorField' => 'inspection_id']);
        $rules->add($rules->existsIn(['item_master_id'], 'ItemMasters'), ['errorField' => 'item_master_id']);
        $rules->add($rules->existsIn(['template_item_id'], 'TemplateItems'), ['errorField' => 'template_item_id']);
        $rules->add($rules->existsIn(['calibration_record_id'], 'CalibrationRecords'), ['errorField' => 'calibration_record_id']);

        return $rules;
    }
}
