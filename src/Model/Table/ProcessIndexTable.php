<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProcessIndex Model
 *
 * @property \App\Model\Table\ProductFamilyTable&\Cake\ORM\Association\BelongsTo $ProductFamilies
 *
 * @method \App\Model\Entity\ProcessIndex newEmptyEntity()
 * @method \App\Model\Entity\ProcessIndex newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ProcessIndex> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProcessIndex get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ProcessIndex findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ProcessIndex patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ProcessIndex> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProcessIndex|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ProcessIndex saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ProcessIndex>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProcessIndex>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ProcessIndex>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProcessIndex> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ProcessIndex>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProcessIndex>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ProcessIndex>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProcessIndex> deleteManyOrFail(iterable $entities, array $options = [])
 */
class ProcessIndexTable extends Table
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

        $this->setTable('process_index');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('ProductFamilies', [
            'foreignKey' => 'product_family_id',
            'className' => 'ProductFamily',
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
            ->date('periodo')
            ->allowEmptyDate('periodo');

        $validator
            ->scalar('indicador')
            ->maxLength('indicador', 100)
            ->allowEmptyString('indicador');

        $validator
            ->uuid('product_family_id')
            ->allowEmptyString('product_family_id');

        $validator
            ->decimal('valor')
            ->allowEmptyString('valor');

        $validator
            ->scalar('unidade')
            ->maxLength('unidade', 50)
            ->allowEmptyString('unidade');

        $validator
            ->scalar('detalhes')
            ->allowEmptyString('detalhes');

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
        $rules->add($rules->existsIn(['product_family_id'], 'ProductFamilies'), ['errorField' => 'product_family_id']);

        return $rules;
    }
}
