<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ChecklistTemplate Model
 *
 * @property \App\Model\Table\ChecklistTemplateVersionTable&\Cake\ORM\Association\HasMany $ChecklistTemplateVersion
 * @property \App\Model\Table\InspectionTable&\Cake\ORM\Association\HasMany $Inspection
 * @property \App\Model\Table\ProductFamilyChecklistTable&\Cake\ORM\Association\HasMany $ProductFamilyChecklist
 *
 * @method \App\Model\Entity\ChecklistTemplate newEmptyEntity()
 * @method \App\Model\Entity\ChecklistTemplate newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ChecklistTemplate> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ChecklistTemplate get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ChecklistTemplate findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ChecklistTemplate patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ChecklistTemplate> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ChecklistTemplate|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ChecklistTemplate saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ChecklistTemplate>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ChecklistTemplate>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ChecklistTemplate>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ChecklistTemplate> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ChecklistTemplate>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ChecklistTemplate>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ChecklistTemplate>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ChecklistTemplate> deleteManyOrFail(iterable $entities, array $options = [])
 */
class ChecklistTemplateTable extends Table
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

        $this->setTable('checklist_template');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('ChecklistTemplateVersion', [
            'foreignKey' => 'checklist_template_id',
        ]);
        $this->hasMany('Inspection', [
            'foreignKey' => 'checklist_template_id',
        ]);
        $this->hasMany('ProductFamilyChecklist', [
            'foreignKey' => 'checklist_template_id',
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
            ->scalar('name')
            ->maxLength('name', 150)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('tipo')
            ->maxLength('tipo', 50)
            ->allowEmptyString('tipo');

        $validator
            ->scalar('descricao')
            ->allowEmptyString('descricao');

        $validator
            ->boolean('is_active')
            ->allowEmptyString('is_active');

        $validator
            ->dateTime('created_at')
            ->notEmptyDateTime('created_at');

        $validator
            ->dateTime('updated_at')
            ->notEmptyDateTime('updated_at');

        return $validator;
    }
}
