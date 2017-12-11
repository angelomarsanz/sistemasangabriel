<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MibillsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MibillsTable Test Case
 */
class MibillsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MibillsTable
     */
    public $Mibills;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.mibills'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Mibills') ? [] : ['className' => 'App\Model\Table\MibillsTable'];
        $this->Mibills = TableRegistry::get('Mibills', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Mibills);

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
