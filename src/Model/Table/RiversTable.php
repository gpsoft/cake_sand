<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Rivers Model
 *
 * @method \App\Model\Entity\River newEmptyEntity()
 * @method \App\Model\Entity\River newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\River[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\River get($primaryKey, $options = [])
 * @method \App\Model\Entity\River findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\River patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\River[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\River|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\River saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\River[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\River[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\River[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\River[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class RiversTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('rivers');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
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
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('source')
            ->maxLength('source', 255)
            ->requirePresence('source', 'create')
            ->notEmptyString('source');

        $validator
            ->scalar('mouse')
            ->maxLength('mouse', 255)
            ->requirePresence('mouse', 'create')
            ->notEmptyString('mouse');

        return $validator;
    }
}
