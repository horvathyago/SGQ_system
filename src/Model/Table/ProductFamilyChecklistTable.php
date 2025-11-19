<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProductFamilyChecklist Model
 *
 * @property \App\Model\Table\ProductFamilyTable&\Cake\ORM\Association\BelongsTo $ProductFamilies
 * @property \App\Model\Table\ChecklistTemplateTable&\Cake\ORM\Association\BelongsTo $ChecklistTemplates
 *
 * @method \App\Model\Entity\ProductFamilyChecklist newEmptyEntity()
 * @method \App\Model\Entity\ProductFamilyChecklist newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ProductFamilyChecklist> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProductFamilyChecklist get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ProductFamilyChecklist findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ProductFamilyChecklist patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ProductFamilyChecklist> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProductFamilyChecklist|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ProductFamilyChecklist saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ProductFamilyChecklist>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProductFamilyChecklist>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ProductFamilyChecklist>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProductFamilyChecklist> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ProductFamilyChecklist>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProductFamilyChecklist>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ProductFamilyChecklist>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProductFamilyChecklist> deleteManyOrFail(iterable $entities, array $options = [])
 */
class ProductFamilyChecklistTable extends Table
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

        $this->setTable('product_family_checklist');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('ProductFamilies', [
            'foreignKey' => 'product_family_id',
            'className' => 'ProductFamily',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ChecklistTemplates', [
            'foreignKey' => 'checklist_template_id',
            'className' => 'ChecklistTemplate',
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
            ->uuid('product_family_id')
            ->notEmptyString('product_family_id');

        $validator
            ->uuid('checklist_template_id')
            ->notEmptyString('checklist_template_id');

        $validator
            ->scalar('tipo')
            ->maxLength('tipo', 50)
            ->allowEmptyString('tipo');

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
        $rules->add($rules->isUnique(['product_family_id', 'checklist_template_id']), ['errorField' => 'product_family_id']);
        $rules->add($rules->existsIn(['product_family_id'], 'ProductFamilies'), ['errorField' => 'product_family_id']);
        $rules->add($rules->existsIn(['checklist_template_id'], 'ChecklistTemplates'), ['errorField' => 'checklist_template_id']);

        return $rules;
    }
}
