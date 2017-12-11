<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TeachingareasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TeachingareasTable Test Case
 */
class TeachingareasTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TeachingareasTable
     */
    public $Teachingareas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.teachingareas',
        'app.studentactivities',
        'app.employees',
        'app.users',
        'app.owners',
        'app.parentsandguardians',
        'app.students',
        'app.positions',
        'app.sections',
        'app.employees_sections',
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
        $config = TableRegistry::exists('Teachingareas') ? [] : ['className' => 'App\Model\Table\TeachingareasTable'];
        $this->Teachingareas = TableRegistry::get('Teachingareas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Teachingareas);

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
}
