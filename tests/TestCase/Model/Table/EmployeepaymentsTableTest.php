<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmployeepaymentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmployeepaymentsTable Test Case
 */
class EmployeepaymentsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EmployeepaymentsTable
     */
    public $Employeepayments;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.employeepayments',
        'app.paysheets',
        'app.employees',
        'app.users',
        'app.owners',
        'app.parentsandguardians',
        'app.students',
        'app.sections',
        'app.studentactivities',
        'app.employees_sections',
        'app.activitiesannexes',
        'app.studentqualifications',
        'app.studenttransactions',
        'app.positions',
        'app.teachingareas',
        'app.employees_teachingareas'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Employeepayments') ? [] : ['className' => 'App\Model\Table\EmployeepaymentsTable'];
        $this->Employeepayments = TableRegistry::get('Employeepayments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Employeepayments);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
