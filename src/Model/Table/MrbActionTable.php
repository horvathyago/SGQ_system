<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MrbAction Model
 *
 * @property \App\Model\Table\NonConformityTable&\Cake\ORM\Association\BelongsTo $NonConformities
 * @property \App\Model\Table\UserAccountTable&\Cake\ORM\Association\BelongsTo $Responsavels
 *
 * @method \App\Model\Entity\MrbAction newEmptyEntity()
 * @method \App\Model\Entity\MrbAction newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\MrbAction> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MrbAction get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\MrbAction findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\MrbAction patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\MrbAction> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\MrbAction|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\MrbAction saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\MrbAction>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\MrbAction>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\MrbAction>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\MrbAction> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\MrbAction>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\MrbAction>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\MrbAction>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\MrbAction> deleteManyOrFail(iterable $entities, array $options = [])
 */
class MrbActionTable extends Table
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

        $this->setTable('mrb_action');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('NonConformities', [
            'foreignKey' => 'non_conformity_id',
            'className' => 'NonConformity',
        ]);
        $this->belongsTo('Responsavels', [
            'foreignKey' => 'responsavel_id',
            'className' => 'UserAccount',
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
            ->uuid('non_conformity_id')
            ->allowEmptyString('non_conformity_id');

        $validator
            ->scalar('decisao')
            ->maxLength('decisao', 255)
            ->allowEmptyString('decisao');

        $validator
            ->uuid('responsavel_id')
            ->allowEmptyString('responsavel_id');

        $validator
            ->scalar('observacoes')
            ->allowEmptyString('observacoes');

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
        $rules->add($rules->existsIn(['non_conformity_id'], 'NonConformities'), ['errorField' => 'non_conformity_id']);
        $rules->add($rules->existsIn(['responsavel_id'], 'Responsavels'), ['errorField' => 'responsavel_id']);

        return $rules;
    }
}
