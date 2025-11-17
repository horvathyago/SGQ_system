<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TemplateItem Model
 *
 * @property \App\Model\Table\ChecklistTemplateVersionTable&\Cake\ORM\Association\BelongsTo $ChecklistTemplateVersions
 * @property \App\Model\Table\ItemMasterTable&\Cake\ORM\Association\BelongsTo $ItemMasters
 * @property \App\Model\Table\InspectionItemTable&\Cake\ORM\Association\HasMany $InspectionItem
 *
 * @method \App\Model\Entity\TemplateItem newEmptyEntity()
 * @method \App\Model\Entity\TemplateItem newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\TemplateItem> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TemplateItem get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\TemplateItem findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\TemplateItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\TemplateItem> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\TemplateItem|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\TemplateItem saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\TemplateItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\TemplateItem>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\TemplateItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\TemplateItem> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\TemplateItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\TemplateItem>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\TemplateItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\TemplateItem> deleteManyOrFail(iterable $entities, array $options = [])
 */
class TemplateItemTable extends Table
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

        $this->setTable('template_item');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('ChecklistTemplateVersions', [
            'foreignKey' => 'checklist_template_version_id',
            'className' => 'ChecklistTemplateVersion',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('ItemMasters', [
            'foreignKey' => 'item_master_id',
            'className' => 'ItemMaster',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('InspectionItem', [
            'foreignKey' => 'template_item_id',
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
            ->uuid('checklist_template_version_id')
            ->notEmptyString('checklist_template_version_id');

        $validator
            ->uuid('item_master_id')
            ->notEmptyString('item_master_id');

        $validator
            ->integer('item_master_version')
            ->allowEmptyString('item_master_version');

        $validator
            ->integer('ordem')
            ->requirePresence('ordem', 'create')
            ->notEmptyString('ordem');

        $validator
            ->boolean('required')
            ->allowEmptyString('required');

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
        $rules->add($rules->isUnique(['checklist_template_version_id', 'ordem']), ['errorField' => 'checklist_template_version_id']);
        $rules->add($rules->existsIn(['checklist_template_version_id'], 'ChecklistTemplateVersions'), ['errorField' => 'checklist_template_version_id']);
        $rules->add($rules->existsIn(['item_master_id'], 'ItemMasters'), ['errorField' => 'item_master_id']);

        return $rules;
    }
}
