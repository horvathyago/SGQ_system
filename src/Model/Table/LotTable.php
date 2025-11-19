<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Lot Model
 *
 * @property \App\Model\Table\ProductFamilyTable&\Cake\ORM\Association\BelongsTo $ProductFamilies
 * @property \App\Model\Table\ProductionOrderTable&\Cake\ORM\Association\BelongsTo $ProductionOrders
 *
 * @method \App\Model\Entity\Lot newEmptyEntity()
 * @method \App\Model\Entity\Lot newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Lot> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Lot get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Lot findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Lot patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Lot> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Lot|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Lot saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Lot>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Lot>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Lot>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Lot> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Lot>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Lot>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Lot>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Lot> deleteManyOrFail(iterable $entities, array $options = [])
 */
class LotTable extends Table
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

        $this->setTable('lot');
        $this->setDisplayField('lot_code');
        $this->setPrimaryKey('id');

        $this->belongsTo('ProductFamilies', [
            'foreignKey' => 'product_family_id',
            'className' => 'ProductFamily',
        ]);
        $this->belongsTo('ProductionOrders', [
            'foreignKey' => 'production_order_id',
            'className' => 'ProductionOrder',
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
            ->scalar('lot_code')
            ->maxLength('lot_code', 100)
            ->requirePresence('lot_code', 'create')
            ->notEmptyString('lot_code');

        $validator
            ->uuid('product_family_id')
            ->allowEmptyString('product_family_id');

        $validator
            ->uuid('production_order_id')
            ->allowEmptyString('production_order_id');

        $validator
            ->integer('quantidade')
            ->allowEmptyString('quantidade');

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
        $rules->add($rules->isUnique(['lot_code', 'production_order_id'], ['allowMultipleNulls' => true]), ['errorField' => 'lot_code']);
        $rules->add($rules->existsIn(['product_family_id'], 'ProductFamilies'), ['errorField' => 'product_family_id']);
        $rules->add($rules->existsIn(['production_order_id'], 'ProductionOrders'), ['errorField' => 'production_order_id']);

        return $rules;
    }
}
