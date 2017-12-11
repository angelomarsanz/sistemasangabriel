<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ConceptsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ConceptsTable Test Case
 */
class ConceptsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ConceptsTable
     */
    public $Concepts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.concepts',
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
        $config = TableRegistry::exists('Concepts') ? [] : ['className' => 'App\Model\Table\ConceptsTable'];
        $this->Concepts = TableRegistry::get('Concepts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Concepts);

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
