<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\StudenttransactionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\StudenttransactionsTable Test Case
 */
class StudenttransactionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\StudenttransactionsTable
     */
    public $Studenttransactions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.studenttransactions',
        'app.students',
        'app.users',
        'app.employees',
        'app.positions',
        'app.studentactivities',
        'app.sections',
        'app.employees_sections',
        'app.teachingareas',
        'app.employees_teachingareas',
        'app.owners',
        'app.parentsandguardians',
        'app.activitiesannexes',
        'app.studentqualifications'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Studenttransactions') ? [] : ['className' => 'App\Model\Table\StudenttransactionsTable'];
        $this->Studenttransactions = TableRegistry::get('Studenttransactions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Studenttransactions);

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
