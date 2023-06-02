<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MeishiData Model
 *
 * @property \App\Model\Table\CorpsTable&\Cake\ORM\Association\BelongsTo $Corps
 *
 * @method \App\Model\Entity\MeishiData newEmptyEntity()
 * @method \App\Model\Entity\MeishiData newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\MeishiData[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MeishiData get($primaryKey, $options = [])
 * @method \App\Model\Entity\MeishiData findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\MeishiData patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MeishiData[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\MeishiData|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MeishiData saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MeishiData[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\MeishiData[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\MeishiData[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\MeishiData[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MeishiDataTable extends Table
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

        $this->setTable('meishi_data');
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
            ->notEmptyString('division', '部署名を入力してください。')
            ->add('division', 'validFormat', [
                'rule' => [
                    'custom',
                    '/^(?![0-9]+$)[a-zA-Z0-9]+$/',
                ],
                'message' => '部署名の登録に数字だけの登録はできません。',
            ]);

        $validator
            ->scalar('title')
            ->maxLength('title', 50)
            ->allowEmptyString('title');

        $validator
            ->scalar('employee_name')
            ->maxLength('employee_name', 50)
            ->requirePresence('employee_name', 'create')
            ->notEmptyString('employee_name', '名前を入力してください。')
            ->add('employee_name', 'validFormat', [
                'rule' => [
                    'regex',
                    '/^[a-zA-Z]+$/',
                ],
                'message' => '名前に数字は入れられません。',
            ]);

        $validator
            ->scalar('address')
            ->maxLength('address', 255)
            ->requirePresence('address', 'create')
            ->notEmptyString('address');

        $validator
            ->scalar('tel')
            ->maxLength('tel', 13)
            ->allowEmptyString('tel')
            ->add('tel', 'validFormat', [
                'rule' => [
                    'custom',
                    '/^[0-9]+$/',
                ],
                'message' => '数字以外の入力はできません。',
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
