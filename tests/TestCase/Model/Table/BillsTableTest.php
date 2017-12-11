<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BillsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BillsTable Test Case
 */
class BillsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\BillsTable
     */
    public $Bills;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.bills',
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
        'app.owners',
        'app.concepts',
        'app.payments'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Bills') ? [] : ['className' => 'App\Model\Table\BillsTable'];
        $this->Bills = TableRegistry::get('Bills', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Bills);

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
