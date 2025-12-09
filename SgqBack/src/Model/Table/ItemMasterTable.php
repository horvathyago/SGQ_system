<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ItemMaster Model
 *
 * @property \App\Model\Table\InspectionItemTable&\Cake\ORM\Association\HasMany $InspectionItem
 * @property \App\Model\Table\ItemMasterVersionTable&\Cake\ORM\Association\HasMany $ItemMasterVersion
 * @property \App\Model\Table\TemplateItemTable&\Cake\ORM\Association\HasMany $TemplateItem
 *
 * @method \App\Model\Entity\ItemMaster newEmptyEntity()
 * @method \App\Model\Entity\ItemMaster newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ItemMaster> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ItemMaster get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ItemMaster findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ItemMaster patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ItemMaster> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ItemMaster|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ItemMaster saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ItemMaster>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ItemMaster>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ItemMaster>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ItemMaster> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ItemMaster>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ItemMaster>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ItemMaster>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ItemMaster> deleteManyOrFail(iterable $entities, array $options = [])
 */
class ItemMasterTable extends Table
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

        $this->setTable('item_master');
        $this->setDisplayField('codigo_item');
        $this->setPrimaryKey('id');

        $this->hasMany('InspectionItem', [
            'foreignKey' => 'item_master_id',
        ]);
        $this->hasMany('ItemMasterVersion', [
            'foreignKey' => 'item_master_id',
        ]);
        $this->hasMany('TemplateItem', [
            'foreignKey' => 'item_master_id',
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
            ->scalar('codigo_item')
            ->maxLength('codigo_item', 100)
            ->requirePresence('codigo_item', 'create')
            ->notEmptyString('codigo_item')
            ->add('codigo_item', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('titulo')
            ->maxLength('titulo', 255)
            ->allowEmptyString('titulo');

        $validator
            ->integer('versao_mestra')
            ->allowEmptyString('versao_mestra');

        $validator
            ->decimal('peso')
            ->allowEmptyString('peso');

        $validator
            ->boolean('is_fca')
            ->allowEmptyString('is_fca');

        $validator
            ->scalar('escopo')
            ->maxLength('escopo', 255)
            ->allowEmptyString('escopo');

        $validator
            ->dateTime('vigente_inicio')
            ->allowEmptyDateTime('vigente_inicio');

        $validator
            ->dateTime('vigente_fim')
            ->allowEmptyDateTime('vigente_fim');

        $validator
            ->boolean('is_ativo')
            ->allowEmptyString('is_ativo');

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
        $rules->add($rules->isUnique(['codigo_item']), ['errorField' => 'codigo_item']);

        return $rules;
    }
}
