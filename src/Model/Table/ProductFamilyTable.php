<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProductFamily Model
 *
 * @property \App\Model\Table\LotTable&\Cake\ORM\Association\HasMany $Lot
 * @property \App\Model\Table\ProcessIndexTable&\Cake\ORM\Association\HasMany $ProcessIndex
 * @property \App\Model\Table\ProductFamilyChecklistTable&\Cake\ORM\Association\HasMany $ProductFamilyChecklist
 * @property \App\Model\Table\ProductionOrderTable&\Cake\ORM\Association\HasMany $ProductionOrder
 *
 * @method \App\Model\Entity\ProductFamily newEmptyEntity()
 * @method \App\Model\Entity\ProductFamily newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ProductFamily> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProductFamily get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ProductFamily findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ProductFamily patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ProductFamily> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProductFamily|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ProductFamily saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ProductFamily>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProductFamily>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ProductFamily>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProductFamily> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ProductFamily>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProductFamily>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ProductFamily>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProductFamily> deleteManyOrFail(iterable $entities, array $options = [])
 */
class ProductFamilyTable extends Table
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

        $this->setTable('product_family');
        $this->setDisplayField('codigo');
        $this->setPrimaryKey('id');

        $this->hasMany('Lot', [
            'foreignKey' => 'product_family_id',
        ]);
        $this->hasMany('ProcessIndex', [
            'foreignKey' => 'product_family_id',
        ]);
        $this->hasMany('ProductFamilyChecklist', [
            'foreignKey' => 'product_family_id',
        ]);
        $this->hasMany('ProductionOrder', [
            'foreignKey' => 'product_family_id',
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
            ->scalar('codigo')
            ->maxLength('codigo', 50)
            ->requirePresence('codigo', 'create')
            ->notEmptyString('codigo')
            ->add('codigo', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('nome')
            ->maxLength('nome', 100)
            ->requirePresence('nome', 'create')
            ->notEmptyString('nome');

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
        $rules->add($rules->isUnique(['codigo']), ['errorField' => 'codigo']);

        return $rules;
    }
}
