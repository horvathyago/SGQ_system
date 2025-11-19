<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProductionOrder Model
 *
 * @property \App\Model\Table\ProductFamilyTable&\Cake\ORM\Association\BelongsTo $ProductFamilies
 * @property \App\Model\Table\InspectionTable&\Cake\ORM\Association\HasMany $Inspection
 * @property \App\Model\Table\LotTable&\Cake\ORM\Association\HasMany $Lot
 *
 * @method \App\Model\Entity\ProductionOrder newEmptyEntity()
 * @method \App\Model\Entity\ProductionOrder newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ProductionOrder> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProductionOrder get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ProductionOrder findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ProductionOrder patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ProductionOrder> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProductionOrder|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ProductionOrder saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ProductionOrder>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProductionOrder>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ProductionOrder>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProductionOrder> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ProductionOrder>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProductionOrder>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ProductionOrder>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProductionOrder> deleteManyOrFail(iterable $entities, array $options = [])
 */
class ProductionOrderTable extends Table
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

        $this->setTable('production_order');
        $this->setDisplayField('numero_op');
        $this->setPrimaryKey('id');

        $this->belongsTo('ProductFamilies', [
            'foreignKey' => 'product_family_id',
            'className' => 'ProductFamily',
        ]);
        $this->hasMany('Inspection', [
            'foreignKey' => 'production_order_id',
        ]);
        $this->hasMany('Lot', [
            'foreignKey' => 'production_order_id',
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
            ->scalar('numero_op')
            ->maxLength('numero_op', 100)
            ->requirePresence('numero_op', 'create')
            ->notEmptyString('numero_op')
            ->add('numero_op', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('produto_codigo')
            ->maxLength('produto_codigo', 100)
            ->allowEmptyString('produto_codigo');

        $validator
            ->uuid('product_family_id')
            ->allowEmptyString('product_family_id');

        $validator
            ->scalar('lot_code')
            ->maxLength('lot_code', 100)
            ->allowEmptyString('lot_code');

        $validator
            ->integer('quantidade_planejada')
            ->allowEmptyString('quantidade_planejada');

        $validator
            ->dateTime('data_inicio')
            ->allowEmptyDateTime('data_inicio');

        $validator
            ->dateTime('data_fim')
            ->allowEmptyDateTime('data_fim');

        $validator
            ->scalar('status')
            ->maxLength('status', 50)
            ->allowEmptyString('status');

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
        $rules->add($rules->isUnique(['numero_op']), ['errorField' => 'numero_op']);
        $rules->add($rules->existsIn(['product_family_id'], 'ProductFamilies'), ['errorField' => 'product_family_id']);

        return $rules;
    }
}
