<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Employeepayments Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Paysheets
 * @property \Cake\ORM\Association\BelongsTo $Employees
 *
 * @method \App\Model\Entity\Employeepayment get($primaryKey, $options = [])
 * @method \App\Model\Entity\Employeepayment newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Employeepayment[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Employeepayment|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Employeepayment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Employeepayment[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Employeepayment findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EmployeepaymentsTable extends Table
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

        $this->table('employeepayments');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Paysheets', [
            'foreignKey' => 'paysheet_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Employees', [
            'foreignKey' => 'employee_id',
            'joinType' => 'INNER'
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
            ->allowEmpty('current_position');

        $validator
            ->numeric('current_basic_salary')
            ->allowEmpty('current_basic_salary');

        $validator
            ->integer('current_monthly_hours')
            ->allowEmpty('current_monthly_hours');

        $validator
            ->numeric('monthly_salary')
            ->allowEmpty('monthly_salary');

        $validator
            ->numeric('payment_period')
            ->allowEmpty('payment_period');

        $validator
            ->numeric('years_service')
            ->allowEmpty('years_service');

        $validator
            ->numeric('bv')
            ->allowEmpty('bv');

        $validator
            ->numeric('scale')
            ->allowEmpty('scale');
            
        $validator
            ->numeric('amount_escalation')
            ->allowEmpty('amount_escalation');

        $validator
            ->numeric('integral_salary')
            ->allowEmpty('integral_salary');

        $validator
            ->numeric('trust_days')
            ->allowEmpty('trust_days');

        $validator
            ->numeric('salary_advance')
            ->allowEmpty('salary_advance');

        $validator
            ->integer('overtime')
            ->allowEmpty('overtime');

        $validator
            ->numeric('amount_overtime')
            ->allowEmpty('amount_overtime');

        $validator
            ->integer('night_overtime')
            ->allowEmpty('night_overtime');

        $validator
            ->numeric('amount_night_overtime')
            ->allowEmpty('amount_night_overtime');

        $validator
            ->allowEmpty('worked_holidays');

        $validator
            ->numeric('amount_worked_holidays')
            ->allowEmpty('amount_worked_holidays');

        $validator
            ->allowEmpty('worked_breaks');

        $validator
            ->numeric('amount_worked_break')
            ->allowEmpty('amount_worked_break');

        $validator
            ->numeric('other_income')
            ->allowEmpty('other_income');

        $validator
            ->numeric('faov')
            ->allowEmpty('faov');

        $validator
            ->numeric('ivss')
            ->allowEmpty('ivss');

        $validator
            ->numeric('trust_days')
            ->allowEmpty('trust_days');

        $validator
            ->numeric('fideicomiso')
            ->allowEmpty('fideicomiso');
			
        $validator
            ->numeric('percentage_imposed')
            ->allowEmpty('percentage_imposed');

        $validator
            ->numeric('amount_imposed')
            ->allowEmpty('amount_imposed');

        $validator
            ->boolean('repose')
            ->allowEmpty('repose');

        $validator
            ->numeric('discount_repose')
            ->allowEmpty('discount_repose');

        $validator
            ->numeric('discount_loan')
            ->allowEmpty('discount_loan');

        $validator
            ->integer('days_absence')
            ->allowEmpty('days_absence');
            
        $validator
            ->numeric('discount_absences')
            ->allowEmpty('discount_absences');

        $validator
            ->numeric('total_payment')
            ->allowEmpty('total_payment');
			
        $validator
            ->numeric('days_cesta_ticket')
            ->allowEmpty('days_cesta_ticket');
			
        $validator
            ->numeric('amount_cesta_ticket')
            ->allowEmpty('amount_cesta_ticket');
			
        $validator
            ->numeric('loan_cesta_ticket')
            ->allowEmpty('loan_cesta_ticket');

        $validator
            ->numeric('total_cesta_ticket')
            ->allowEmpty('total_cesta_ticket');
			
        $validator
            ->allowEmpty('extra_column1');
			
        $validator
            ->allowEmpty('extra_column2');
			
        $validator
            ->allowEmpty('extra_column3');
			
        $validator
            ->allowEmpty('extra_column4');
			
        $validator
            ->allowEmpty('extra_column5');
			
        $validator
            ->allowEmpty('extra_column6');
			
        $validator
            ->allowEmpty('extra_column7');
			
        $validator
            ->allowEmpty('extra_column8');
			
        $validator
            ->allowEmpty('extra_column9');
			
        $validator
            ->allowEmpty('extra_column10');
			
        $validator
            ->allowEmpty('registration_status');
			
        $validator
            ->allowEmpty('reason_status');
			
        $validator
			->dateTime('date_status')
            ->allowEmpty('date_status');

        $validator
            ->allowEmpty('responsible_user');            

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['paysheet_id'], 'Paysheets'));
        $rules->add($rules->existsIn(['employee_id'], 'Employees'));

        return $rules;
    }
    public function findPayroll(Query $query, array $options)
    {
        $arrayResult = [];
		
        $query->select(
            ['Employeepayments.id',
            'Employeepayments.current_position',
            'Employeepayments.current_basic_salary',
            'Employeepayments.current_monthly_hours',
            'Employeepayments.monthly_salary',
            'Employeepayments.payment_period',
            'Employeepayments.scale',
            'Employeepayments.amount_escalation',
            'Employeepayments.other_income',
            'Employeepayments.discount_repose',
            'Employeepayments.discount_loan',
            'Employeepayments.days_absence',
            'Employeepayments.discount_absences',
            'Employeepayments.faov',
            'Employeepayments.ivss',
            'Employeepayments.integral_salary',
            'Employeepayments.salary_advance',
			'Employeepayments.trust_days',
			'Employeepayments.fideicomiso',
            'Employeepayments.percentage_imposed',
            'Employeepayments.amount_imposed',
            'Employeepayments.total_payment',
			'Employeepayments.days_cesta_ticket',
			'Employeepayments.amount_cesta_ticket',
			'Employeepayments.loan_cesta_ticket',
			'Employeepayments.total_cesta_ticket',
            'Employees.id',
            'Employees.surname',
            'Employees.first_name',
            'Employees.type_of_identification',
            'Employees.identity_card',
			'Employees.date_of_admission',
            'Positions.type_of_salary'])
        ->contain(['Employees' => ['Positions']])
        ->where([['paysheet_id' => $options['idPaysheet']], 
            ['OR' => [['Employeepayments.registration_status IS NULL'], ['Employeepayments.registration_status !=' => "Eliminado"]]]])
        ->order(['Employees.surname' => 'ASC', 'Employees.first_name' => 'ASC']);
        
        if ($query->count() > 0)
        {
            $arrayResult['indicator'] = 0;
            $arrayResult['searchRequired'] = $query;
        }
        else
        {
            $arrayResult['indicator'] = 1;
        }
        
        return $arrayResult;
    }
    public function findSimple(Query $query, array $options)
    {
        $arrayResult = [];
		
		$query
			->contain(['Employees'])
			->where([['paysheet_id' => $options['idPaysheet']], 
            ['OR' => [['Employeepayments.registration_status IS NULL'], ['Employeepayments.registration_status !=' => "Eliminado"]]]])
			->order(['Employees.surname' => 'ASC', 'Employees.first_name' => 'ASC']);
        
        if ($query->count() > 0)
        {
            $arrayResult['indicator'] = 0;
            $arrayResult['searchRequired'] = $query;
        }
        else
        {
            $arrayResult['indicator'] = 1;
        }
        
        return $arrayResult;
    }
}