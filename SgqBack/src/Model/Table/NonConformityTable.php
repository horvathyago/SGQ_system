<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * NonConformity Model
 *
 * @property \App\Model\Table\InspectionItemTable&\Cake\ORM\Association\BelongsTo $InspectionItems
 * @property \App\Model\Table\UserAccountTable&\Cake\ORM\Association\BelongsTo $Responsavels
 * @property \App\Model\Table\MrbActionTable&\Cake\ORM\Association\HasMany $MrbAction
 *
 * @method \App\Model\Entity\NonConformity newEmptyEntity()
 * @method \App\Model\Entity\NonConformity newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\NonConformity> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\NonConformity get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\NonConformity findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\NonConformity patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\NonConformity> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\NonConformity|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\NonConformity saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\NonConformity>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\NonConformity>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\NonConformity>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\NonConformity> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\NonConformity>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\NonConformity>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\NonConformity>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\NonConformity> deleteManyOrFail(iterable $entities, array $options = [])
 */
class NonConformityTable extends Table
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

        $this->setTable('non_conformity');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('InspectionItems', [
            'foreignKey' => 'inspection_item_id',
            'className' => 'InspectionItem',
        ]);
        $this->belongsTo('Responsavels', [
            'foreignKey' => 'responsavel_id',
            'className' => 'UserAccount',
        ]);
        $this->hasMany('MrbAction', [
            'foreignKey' => 'non_conformity_id',
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
            ->uuid('inspection_item_id')
            ->allowEmptyString('inspection_item_id');

        $validator
            ->scalar('descricao')
            ->allowEmptyString('descricao');

        $validator
            ->scalar('severity')
            ->maxLength('severity', 50)
            ->allowEmptyString('severity');

        $validator
            ->boolean('is_fca_trigger')
            ->allowEmptyString('is_fca_trigger');

        $validator
            ->scalar('disposition')
            ->maxLength('disposition', 100)
            ->allowEmptyString('disposition');

        $validator
            ->uuid('responsavel_id')
            ->allowEmptyString('responsavel_id');

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
        $rules->add($rules->existsIn(['inspection_item_id'], 'InspectionItems'), ['errorField' => 'inspection_item_id']);
        $rules->add($rules->existsIn(['responsavel_id'], 'Responsavels'), ['errorField' => 'responsavel_id']);

        return $rules;
    }
}
