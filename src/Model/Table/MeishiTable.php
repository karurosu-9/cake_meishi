<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Meishi Model
 *
 * @property \App\Model\Table\CorpsTable&\Cake\ORM\Association\BelongsTo $Corps
 *
 * @method \App\Model\Entity\Meishi newEmptyEntity()
 * @method \App\Model\Entity\Meishi newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Meishi[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Meishi get($primaryKey, $options = [])
 * @method \App\Model\Entity\Meishi findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Meishi patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Meishi[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Meishi|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Meishi saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Meishi[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Meishi[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Meishi[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Meishi[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MeishiTable extends Table
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

        $this->setTable('meishi');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Corps', [
            'foreignKey' => 'corp_id',
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
            ->notEmptyString('corp_id');

        $validator
            ->scalar('division')
            ->maxLength('division', 255)
            ->requirePresence('division', 'create')
            ->notEmptyString('division', '所属部署を入力してください。')
            ->add('division', 'validFormat', [
                'rule' => [
                    'custom',
                    '/^(?![0-9]+$)[a-zA-Z0-9ぁ-んァ-ヶー一-龠]+$/u',
                ],
                'message' => '所属部署は記号を入力したり、数字のみでは登録できません。',
            ]);
        $validator
            ->scalar('title')
            ->maxLength('title', 50)
            ->allowEmptyString('title')
            ->add('title', 'validFormat', [
                'rule' => [
                    'custom',
                    '/^(?![0-9]+$)[a-zA-Z0-9ぁ-んァ-ヶー一-龠]+$/u',
                ],
                'message' => '役職は記号を入力したり、数字のみでは登録できません。',
            ]);

        $validator
            ->scalar('employee_name')
            ->maxLength('employee_name', 50)
            ->requirePresence('employee_name', 'create')
            ->notEmptyString('employee_name')
            ->add('employee_name', 'validFormat', [
                'rule' => [
                    'custom',
                    '/^[a-zA-Zぁ-んァ-ヶー一-龠]+$/u',
                ],
                'message' => '名前は記号や数字を入れると登録できません。',
            ]);

        $validator
            ->scalar('address')
            ->maxLength('address', 255)
            ->requirePresence('address', 'create')
            ->notEmptyString('address')
            ->add('address', 'validFormat', [
                'rule' => [
                    'custom',
                    '/^(?![0-9]+$)[a-zA-Z0-9ぁ-んァ-ヶー一-龠]+$/u',
                ],
                'message' => '住所は記号を入力したり、数字のみでは登録できません。',
            ]);

        $validator
            ->scalar('tel')
            ->maxLength('tel', 13)
            ->allowEmptyString('tel')
            ->add('tel', 'validFormat', [
                'rule' => [
                    'custom',
                    '/^[0-9]+$/',
                ],
                'message' => '電話番号は数字のみでしか登録できません。',
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
        $rules->add($rules->existsIn('corp_id', 'Corps'), ['errorField' => 'corp_id']);

        return $rules;
    }
}
