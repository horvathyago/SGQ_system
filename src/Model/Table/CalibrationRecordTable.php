<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CalibrationRecord Model
 *
 * @property \App\Model\Table\GaugeTable&\Cake\ORM\Association\BelongsTo $Gauges
 * @property \App\Model\Table\DocumentTable&\Cake\ORM\Association\BelongsTo $LaudoDocuments
 * @property \App\Model\Table\InspectionItemTable&\Cake\ORM\Association\HasMany $InspectionItem
 *
 * @method \App\Model\Entity\CalibrationRecord newEmptyEntity()
 * @method \App\Model\Entity\CalibrationRecord newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\CalibrationRecord> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CalibrationRecord get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\CalibrationRecord findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\CalibrationRecord patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\CalibrationRecord> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\CalibrationRecord|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\CalibrationRecord saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\CalibrationRecord>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CalibrationRecord>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CalibrationRecord>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CalibrationRecord> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CalibrationRecord>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CalibrationRecord>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\CalibrationRecord>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\CalibrationRecord> deleteManyOrFail(iterable $entities, array $options = [])
 */
class CalibrationRecordTable extends Table
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

        $this->setTable('calibration_record');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Gauges', [
            'foreignKey' => 'gauge_id',
            'className' => 'Gauge',
        ]);
        $this->belongsTo('LaudoDocuments', [
            'foreignKey' => 'laudo_document_id',
            'className' => 'Document',
        ]);
        $this->hasMany('InspectionItem', [
            'foreignKey' => 'calibration_record_id',
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
            ->uuid('gauge_id')
            ->allowEmptyString('gauge_id');

        $validator
            ->dateTime('data_calibracao')
            ->allowEmptyDateTime('data_calibracao');

        $validator
            ->dateTime('validade')
            ->allowEmptyDateTime('validade');

        $validator
            ->uuid('laudo_document_id')
            ->allowEmptyString('laudo_document_id');

        $validator
            ->integer('versao')
            ->allowEmptyString('versao');

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
        $rules->add($rules->existsIn(['gauge_id'], 'Gauges'), ['errorField' => 'gauge_id']);
        $rules->add($rules->existsIn(['laudo_document_id'], 'LaudoDocuments'), ['errorField' => 'laudo_document_id']);

        return $rules;
    }
}
