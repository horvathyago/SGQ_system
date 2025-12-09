<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ChecklistTemplateVersion Model
 *
 * @property \App\Model\Table\ChecklistTemplateTable&\Cake\ORM\Association\BelongsTo $ChecklistTemplates
 * @property \App\Model\Table\InspectionTable&\Cake\ORM\Association\HasMany $Inspection
 * @property \App\Model\Table\TemplateItemTable&\Cake\ORM\Association\HasMany $TemplateItem
 *
 * @method \App\Model\Entity\ChecklistTemplateVersion newEmptyEntity()
 * @method \App\Model\Entity\ChecklistTemplateVersion newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ChecklistTemplateVersion> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ChecklistTemplateVersion get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ChecklistTemplateVersion findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ChecklistTemplateVersion patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ChecklistTemplateVersion> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ChecklistTemplateVersion|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ChecklistTemplateVersion saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ChecklistTemplateVersion>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ChecklistTemplateVersion>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ChecklistTemplateVersion>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ChecklistTemplateVersion> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ChecklistTemplateVersion>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ChecklistTemplateVersion>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ChecklistTemplateVersion>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ChecklistTemplateVersion> deleteManyOrFail(iterable $entities, array $options = [])
 */
class ChecklistTemplateVersionTable extends Table
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

        $this->setTable('checklist_template_version');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('ChecklistTemplates', [
            'foreignKey' => 'checklist_template_id',
            'className' => 'ChecklistTemplate',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Inspection', [
            'foreignKey' => 'checklist_template_version_id',
        ]);
        $this->hasMany('TemplateItem', [
            'foreignKey' => 'checklist_template_version_id',
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
            ->uuid('checklist_template_id')
            ->notEmptyString('checklist_template_id');

        $validator
            ->integer('versao')
            ->requirePresence('versao', 'create')
            ->notEmptyString('versao');

        $validator
            ->scalar('notes')
            ->allowEmptyString('notes');

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
        $rules->add($rules->isUnique(['checklist_template_id', 'versao']), ['errorField' => 'checklist_template_id']);
        $rules->add($rules->existsIn(['checklist_template_id'], 'ChecklistTemplates'), ['errorField' => 'checklist_template_id']);

        return $rules;
    }
}
