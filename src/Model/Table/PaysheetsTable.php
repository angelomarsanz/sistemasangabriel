<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;
use ArrayObject;

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

        $this->belongsTo('Positioncategories', [
            'foreignKey' => 'positioncategory_id',
            'joinType' => 'INNER'
        ]);
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
            ->requirePresence('payroll_name', 'create')
            ->notEmpty('payroll_name', 'El nombre de la nómina no debe estar en blanco');
			
        $validator
            ->date('date_from')
            ->allowEmpty('date_from');

        $validator
            ->date('date_until')
            ->allowEmpty('date_until');

        $validator
            ->numeric('salary_days')
            ->allowEmpty('salary_days');
			
        $validator
            ->integer('weeks_social_security')
            ->allowEmpty('weeks_social_security');
            
        $validator
            ->numeric('cesta_ticket_month')
            ->allowEmpty('cesta_ticket_month');
			
        $validator
            ->numeric('days_cesta_ticket')
            ->allowEmpty('days_cesta_ticket');
			
        $validator
            ->numeric('days_utilities')
            ->allowEmpty('days_utilities');

        $validator
            ->numeric('collective_holidays')
            ->allowEmpty('collective_holidays');
			
        $validator
            ->numeric('collective_vacation_bonus_days')
            ->allowEmpty('collective_vacation_bonus_days');
			
        $validator
            ->allowEmpty('table_configuration');

        $validator
            ->allowEmpty('table_categories');		

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
	public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
	{
		if (isset($data['salary_days'])) 
		{
			if (substr($data['salary_days'], -3, 1) == ',')
			{
				$replace1= str_replace('.', '', $data['salary_days']);
				$replace2 = str_replace(',', '.', $replace1);
				$data['salary_days'] = $replace2;				
			}	
		}
		
		if (isset($data['cesta_ticket_month']))
		{			
			if (substr($data['cesta_ticket_month'], -3, 1) == ',')
			{
				$replace1= str_replace('.', '', $data['cesta_ticket_month']);
				$replace2 = str_replace(',', '.', $replace1);
				$data['cesta_ticket_month'] = $replace2;
			}
		}
			
		if (isset($data['days_cesta_ticket']))	
		{			
			if (substr($data['days_cesta_ticket'], -3, 1) == ',')
			{
				$replace1= str_replace('.', '', $data['days_cesta_ticket']);
				$replace2 = str_replace(',', '.', $replace1);
				$data['days_cesta_ticket'] = $replace2;
			}
		}
			
		if (isset($data['days_utilities']))
		{
			if (substr($data['days_utilities'], -3, 1) == ',')
			{
				$replace1= str_replace('.', '', $data['days_utilities']);
				$replace2 = str_replace(',', '.', $replace1);
				$data['days_utilities'] = $replace2;
			}
		}	
		
		if (isset($data['collective_holidays']))
		{
			if (substr($data['collective_holidays'], -3, 1) == ',')
			{
				$replace1= str_replace('.', '', $data['collective_holidays']);
				$replace2 = str_replace(',', '.', $replace1);
				$data['collective_holidays'] = $replace2;
			}
		}
			
		if (isset($data['collective_vacation_bonus_days']))		
		{
			if (substr($data['collective_vacation_bonus_days'], -3, 1) == ',')
			{
				$replace1= str_replace('.', '', $data['collective_vacation_bonus_days']);
				$replace2 = str_replace(',', '.', $replace1);
				$data['collective_vacation_bonus_days'] = $replace2;
			}
		}
	}
    public function buildRules(RulesChecker $rules)
    {		
		$rules->add(
			function($paysheet, $options) 
			{
				if ($paysheet->salary_days > 360)
				{
					return 'Días base cálculo para la nómina no debe ser mayor a 360';
				}

				if ($paysheet->days_cesta_ticket > 360)
				{
					return 'Días base cálculo cesta ticket no debe ser mayor a 360';
				}
				
				if ($paysheet->days_utilities > 360)
				{
					return 'Días base cálculo utilidades no debe ser mayor a 360';
				}
				
				if ($paysheet->collective_holidays > 360)
				{
					return 'Días base cálculo vacaciones no debe ser mayor a 360';
				}
				
				if ($paysheet->collective_vacation_bonus_days > 360)
				{
					return 'Días base cálculo bono vacacional no debe ser mayor a 360';
				}
				
				return true;
			}, 
			'topDays', 
			['errorField' => 'status',
			'message' => 'Error en los datos introducidos']
			);

        return $rules;
    }
}