<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Paysheets Model
 *
 * @property \Cake\ORM\Association\HasMany $Employeepayments
 *
 * @method \App\Model\Entity\Paysheet get($primaryKey, $options = [])
 * @method \App\Model\Entity\Paysheet newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Paysheet[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Paysheet|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Paysheet patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Paysheet[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Paysheet findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PaysheetsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('paysheets');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Employeepayments', [
            'foreignKey' => 'paysheet_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->allowEmpty('year_paysheet');

        $validator
            ->allowEmpty('month_paysheet');

        $validator
            ->allowEmpty('fortnight');

        $validator
            ->date('date_from')
            ->allowEmpty('date_from');

        $validator
            ->date('date_until')
            ->allowEmpty('date_until');

        $validator
            ->integer('weeks_social_security')
            ->allowEmpty('weeks_social_security');
            
        $validator
            ->numeric('cesta_ticket_month')
            ->allowEmpty('cesta_ticket_month');
			
        $validator
            ->allowEmpty('registration_status');
			
        $validator
            ->allowEmpty('reason_status');
			
        $validator
			->dateTime('date_status')
            ->allowEmpty('date_status');
			
        $validator
            ->allowEmpty('deleted_record');
            
        $validator
            ->allowEmpty('responsible_user');

        return $validator;
    }
}
