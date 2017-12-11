<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ParentsandguardiansTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ParentsandguardiansTable Test Case
 */
class ParentsandguardiansTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ParentsandguardiansTable
     */
    public $Parentsandguardians;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.parentsandguardians',
        'app.users',
        'app.employees',
        'app.positions',
        'app.studentactivities',
        'app.sections',
        'app.students',
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
        $config = TableRegistry::exists('Parentsandguardians') ? [] : ['className' => 'App\Model\Table\ParentsandguardiansTable'];
        $this->Parentsandguardians = TableRegistry::get('Parentsandguardians', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Parentsandguardians);

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
