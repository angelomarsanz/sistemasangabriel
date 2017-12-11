<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MiparentsandguardiansTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MiparentsandguardiansTable Test Case
 */
class MiparentsandguardiansTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MiparentsandguardiansTable
     */
    public $Miparentsandguardians;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.miparentsandguardians',
        'app.users',
        'app.employees',
        'app.positions',
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
        'app.mis'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Miparentsandguardians') ? [] : ['className' => 'App\Model\Table\MiparentsandguardiansTable'];
        $this->Miparentsandguardians = TableRegistry::get('Miparentsandguardians', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Miparentsandguardians);

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
