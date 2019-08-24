<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EventosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EventosTable Test Case
 */
class EventosTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EventosTable
     */
    public $Eventos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.eventos',
        'app.users',
        'app.employees',
        'app.positions',
        'app.positioncategories',
        'app.paysheets',
        'app.employeepayments',
        'app.studentactivities',
        'app.sections',
        'app.students',
        'app.parentsandguardians',
        'app.activitiesannexes',
        'app.studentqualifications',
        'app.studenttransactions',
        'app.employees_sections',
        'app.teachingareas',
        'app.employees_teachingareas',
        'app.owners',
        'app.messages'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Eventos') ? [] : ['className' => 'App\Model\Table\EventosTable'];
        $this->Eventos = TableRegistry::get('Eventos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Eventos);

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
