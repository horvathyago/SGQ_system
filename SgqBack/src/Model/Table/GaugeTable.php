<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Gauge Model
 *
 * @property \App\Model\Table\CalibrationRecordTable&\Cake\ORM\Association\HasMany $CalibrationRecord
 *
 * @method \App\Model\Entity\Gauge newEmptyEntity()
 * @method \App\Model\Entity\Gauge newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Gauge> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Gauge get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Gauge findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Gauge patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Gauge> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Gauge|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Gauge saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Gauge>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Gauge>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Gauge>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Gauge> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Gauge>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Gauge>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Gauge>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Gauge> deleteManyOrFail(iterable $entities, array $options = [])
 */
class GaugeTable extends Table
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

        $this->setTable('gauge');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('CalibrationRecord', [
            'foreignKey' => 'gauge_id',
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
            ->scalar('serial')
            ->maxLength('serial', 100)
            ->allowEmptyString('serial')
            ->add('serial', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('tipo')
            ->maxLength('tipo', 100)
            ->allowEmptyString('tipo');

        $validator
            ->scalar('localizacao')
            ->maxLength('localizacao', 255)
            ->allowEmptyString('localizacao');

        $validator
            ->scalar('status')
            ->maxLength('status', 50)
            ->allowEmptyString('status');

        $validator
            ->scalar('descricao')
            ->allowEmptyString('descricao');

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
        $rules->add($rules->isUnique(['serial'], ['allowMultipleNulls' => true]), ['errorField' => 'serial']);

        return $rules;
    }
}
