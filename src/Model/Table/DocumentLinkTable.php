<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DocumentLink Model
 *
 * @property \App\Model\Table\DocumentTable&\Cake\ORM\Association\BelongsTo $Documents
 *
 * @method \App\Model\Entity\DocumentLink newEmptyEntity()
 * @method \App\Model\Entity\DocumentLink newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\DocumentLink> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DocumentLink get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\DocumentLink findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\DocumentLink patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\DocumentLink> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\DocumentLink|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\DocumentLink saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\DocumentLink>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\DocumentLink>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\DocumentLink>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\DocumentLink> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\DocumentLink>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\DocumentLink>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\DocumentLink>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\DocumentLink> deleteManyOrFail(iterable $entities, array $options = [])
 */
class DocumentLinkTable extends Table
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

        $this->setTable('document_link');
        $this->setDisplayField('entity_type');
        $this->setPrimaryKey('id');

        $this->belongsTo('Documents', [
            'foreignKey' => 'document_id',
            'className' => 'Document',
            'joinType' => 'INNER',
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
            ->uuid('document_id')
            ->notEmptyString('document_id');

        $validator
            ->scalar('entity_type')
            ->maxLength('entity_type', 100)
            ->requirePresence('entity_type', 'create')
            ->notEmptyString('entity_type');

        $validator
            ->uuid('entity_id')
            ->requirePresence('entity_id', 'create')
            ->notEmptyString('entity_id');

        $validator
            ->scalar('expected_type')
            ->maxLength('expected_type', 100)
            ->allowEmptyString('expected_type');

        $validator
            ->boolean('is_required')
            ->allowEmptyString('is_required');

        $validator
            ->boolean('is_validated')
            ->allowEmptyString('is_validated');

        $validator
            ->dateTime('created_at')
            ->notEmptyDateTime('created_at');

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
        $rules->add($rules->existsIn(['document_id'], 'Documents'), ['errorField' => 'document_id']);

        return $rules;
    }
}
