<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GuardiantransactionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GuardiantransactionsTable Test Case
 */
class GuardiantransactionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\GuardiantransactionsTable
     */
    public $Guardiantransactions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.guardiantransactions',
        'app.parentsandguardians',
        'app.users',
        'app.employees',
        'app.positions',
        'app.studentactivities',
        'app.sections',
        'app.students',
        'app.activitiesannexes',
        'app.studentqualifications',
        'app.studenttransactions',
        'app.employees_sections',
        'app.teachingareas',
        'app.employees_teachingareas',
        'app.owners'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Guardiantransactions') ? [] : ['className' => 'App\Model\Table\GuardiantransactionsTable'];
        $this->Guardiantransactions = TableRegistry::get('Guardiantransactions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Guardiantransactions);

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
