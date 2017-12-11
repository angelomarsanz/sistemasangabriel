<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ConsecutiveinvoicesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ConsecutiveinvoicesTable Test Case
 */
class ConsecutiveinvoicesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ConsecutiveinvoicesTable
     */
    public $Consecutiveinvoices;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.consecutiveinvoices'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Consecutiveinvoices') ? [] : ['className' => 'App\Model\Table\ConsecutiveinvoicesTable'];
        $this->Consecutiveinvoices = TableRegistry::get('Consecutiveinvoices', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Consecutiveinvoices);

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
