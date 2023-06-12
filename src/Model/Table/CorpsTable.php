<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Corps Model
 *
 * @property \App\Model\Table\MeishiTable&\Cake\ORM\Association\HasMany $Meishi
 *
 * @method \App\Model\Entity\Corp newEmptyEntity()
 * @method \App\Model\Entity\Corp newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Corp[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Corp get($primaryKey, $options = [])
 * @method \App\Model\Entity\Corp findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Corp patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Corp[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Corp|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Corp saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Corp[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Corp[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Corp[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Corp[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CorpsTable extends Table
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

        $this->setTable('corps');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Meishi', [
            'foreignKey' => 'corp_id',
            //企業名が削除されたら、関連する名刺のデータも削除される
            'dependent' => true,
        ]);

        $this->hasMany('Estimates', [
            'foreignKey' => 'corp_id',
            //企業名が削除されたら、関連する見積データも削除される
            'dependent' => false,
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
            ->scalar('corp_name')
            ->maxLength('corp_name', 255)
            ->requirePresence('corp_name', 'create')
            ->notEmptyString('corp_name', '企業名を入力しいてください。')
            ->add('corp_name', 'validFormat', [
                'rule' => [
                    'custom',
                    '/^(?![0-9]+$)[a-zA-Z0-9ぁ-んァ-ヶー一-龠]+$/u',
                ],
                'message' => '企業名は記号の入力や数字のみでの登録はできません。',
            ])
            ->add('corp_name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('address')
            ->maxLength('address', 255)
            ->requirePresence('address', 'create')
            ->notEmptyString('address', '住所を入力してください。')
            ->add('address', 'validFormat', [
                'rule' => [
                    'custom',
                    '/^(?![0-9]+$)[a-zA-Z0-9ぁ-んァ-ヶー一-龠]+$/u',
                ],
                'message' => '住所は記号の入力や数字のみでの登録はできません。',
            ]);

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
        $rules->add($rules->isUnique(['corp_name']), ['errorField' => 'corp_name']);

        return $rules;
    }
}
