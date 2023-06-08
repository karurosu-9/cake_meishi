<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MyCorps Model
 *
 * @method \App\Model\Entity\MyCorp newEmptyEntity()
 * @method \App\Model\Entity\MyCorp newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\MyCorp[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MyCorp get($primaryKey, $options = [])
 * @method \App\Model\Entity\MyCorp findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\MyCorp patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MyCorp[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\MyCorp|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MyCorp saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MyCorp[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\MyCorp[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\MyCorp[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\MyCorp[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class MyCorpsTable extends Table
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

        $this->setTable('my_corps');
        $this->setDisplayField('id');
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
            ->scalar('corp')
            ->maxLength('corp', 50)
            ->requirePresence('corp', 'create')
            ->notEmptyString('corp');

        $validator
            ->scalar('post_code')
            ->maxLength('post_code', 7)
            ->requirePresence('post_code', 'create')
            ->notEmptyString('post_code');

        $validator
            ->scalar('address')
            ->maxLength('address', 100)
            ->requirePresence('address', 'create')
            ->notEmptyString('address');

        $validator
            ->scalar('tel')
            ->maxLength('tel', 13)
            ->requirePresence('tel', 'create')
            ->notEmptyString('tel');

        $validator
            ->scalar('fax')
            ->maxLength('fax', 13)
            ->requirePresence('fax', 'create')
            ->notEmptyString('fax');

        $validator
            ->scalar('place')
            ->maxLength('place', 10)
            ->requirePresence('place', 'create')
            ->notEmptyString('place');

        $validator
            ->scalar('conditions')
            ->maxLength('conditions', 10)
            ->requirePresence('conditions', 'create')
            ->notEmptyString('conditions');

        $validator
            ->scalar('deadline')
            ->maxLength('deadline', 10)
            ->requirePresence('deadline', 'create')
            ->notEmptyString('deadline');

        return $validator;
    }
}
