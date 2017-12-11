<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ControlnumbersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ControlnumbersTable Test Case
 */
class ControlnumbersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ControlnumbersTable
     */
    public $Controlnumbers;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.controlnumbers'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Controlnumbers') ? [] : ['className' => 'App\Model\Table\ControlnumbersTable'];
        $this->Controlnumbers = TableRegistry::get('Controlnumbers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Controlnumbers);

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
