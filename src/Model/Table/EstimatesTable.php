<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use App\Consts\EstimateConst;

/**
 * Estimates Model
 *
 * @property \App\Model\Table\CorpsTable&\Cake\ORM\Association\BelongsTo $Corps
 *
 * @method \App\Model\Entity\Estimate newEmptyEntity()
 * @method \App\Model\Entity\Estimate newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Estimate[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Estimate get($primaryKey, $options = [])
 * @method \App\Model\Entity\Estimate findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Estimate patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Estimate[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Estimate|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Estimate saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Estimate[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Estimate[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Estimate[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Estimate[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EstimatesTable extends Table
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

        $this->setTable('estimates');
        $this->setDisplayField('id');
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
        ->integer('corp_id')
        ->notEmptyString('corp_id');


        $validator
            ->scalar('tekiyo1')
            ->maxLength('tekiyo1', 255)
            ->allowEmptyString('tekiyo1')
            ->add('tekiyo1', 'validFormat', [
                'rule' => [
                    'custom',
                    '/^(?![0-9]+$)[a-zA-Z0-9ぁ-んァ-ヶー一-龠]+$/u',
                ],
                'message' => '摘要欄は記号や数字のみの登録はできません。',
            ]);

        $validator
            ->scalar('unit_price1')
            ->requirePresence('unit_price1', 'create', '単価を入力してください。')
            ->notEmptyString('unit_price1', '単価を入力してください。');


        $validator
            ->scalar('quantity1')
            ->requirePresence('quantity1', 'create', '数量を入力してください。')
            ->notEmptyString('quantity1', '数量を入力してください。');

        $validator
            ->scalar('amount1')
            ->requirePresence('amount1', 'create', '単価もしくは数量が入力されていません。')
            ->add('amount1', 'validFormat', [
                'rule' => [
                    'custom',
                    '/^[0-9]+$/',
                ],
                'message' => '金額は数字でのみ登録できます。',
            ]);


        $validator
            ->scalar('note1')
            ->maxLength('note1', 255, '最大入力文字数を超えています。')
            ->allowEmptyString('note1')
            ->add('note1', 'validFormat', [
                'rule' => [
                    'custom',
                    '/^(?![0-9]+$)[a-zA-Z0-9ぁ-んァ-ヶー一-龠]+$/u',
                ],
            'message' => '備考は記号や数字のみの登録はできません。',
        ]);

        for ($i = 2; $i <= EstimateConst::FORM_NOT_HOSOKU; $i++) {
            $validator
                ->scalar('tekiyo' . $i)
                ->maxLength('tekiyo' . $i, 255, '最大入力文字数を超えています。')
                ->allowEmptyString('tekiyo' . $i)
                ->add('tekiyo' . $i, 'validFormat', [
                    'rule' => [
                        'custom',
                        '/^(?![0-9]+$)[a-zA-Z0-9ぁ-んァ-ヶー一-龠]+$/u',
                    ],
                    'message' => '摘要欄は記号や数字のみの登録はできません。',
                ]);

            $validator
                ->scalar('unit_price' . $i)
                ->allowEmptyString('unit_price' . $i)
                ->add('unit_price' . $i, 'validFormat', [
                    'rule' => [
                        'custom',
                        '/^[0-9]+$/',
                    ],
                    'message' => '単価の入力は数字のみ登録できます。',
                ]);

            $validator
                ->scalar('quantity' . $i)
                ->allowEmptyString('quantity' . $i)
                ->add('quantity' . $i, 'validFormat', [
                    'rule' => [
                        'custom',
                        '/^[a-zA-Z0-9ぁ-んァ-ヶー一-龠]+$/u',
                    ],
                    'message' => '数量の入力は数字のみ登録できます。',
                ]);

            $validator
                ->scalar('amount' . $i)
                ->allowEmptyString('amount' . $i, '単価もしくは数量が入力されていません。')
                ->add('amout' . $i, 'validFormat', [
                    'rule' => [
                        'custom',
                        '/^[0-9]+$/',
                    ],
                    'message' => '金額は数字でのみ登録できます。',
                ]);


            $validator
                ->scalar('note' . $i)
                ->maxLength('note' . $i, 255, '最大入力文字数を超えています。')
                ->allowEmptyString('note' . $i)
                ->add('note' . $i, 'validFormat', [
                    'rule' => [
                        'custom',
                        '/^(?![0-9]+$)[a-zA-Z0-9ぁ-んァ-ヶー一-龠]+$/u',
                    ],
                    'message' => '備考は記号や数字のみの登録はできません。',
                ]);
        }

        for ($i = 1; $i <= EstimateConst::FORM_HOSOKU; $i++) {
            $validator
            ->scalar('hosoku' . $i)
            ->maxLength('hosoku' . $i, 255, '最大入力文字数を超えています。')
            ->allowEmptyString('hosoku' . $i)
            ->add('hosoku' . $i, 'validFormat', [
                'rule' => [
                    'custom',
                    '/^(?![0-9]+$)[a-zA-Z0-9ぁ-んァ-ヶー一-龠]+$/u',
                ],
                'message' => '補足は記号や数字のみの登録はできません。',
            ]);
        }

        $validator
            ->integer('total_amount')
            ->requirePresence('total_amount', 'create')
            ->notEmptyString('total_amount')
            ->add('total_amount', 'validFormat', [
                'rule' => [
                    'custom',
                    '/^[0-9]+$/',
                ],
                'message' => '合計金額は数字でのみ登録できます。',
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
