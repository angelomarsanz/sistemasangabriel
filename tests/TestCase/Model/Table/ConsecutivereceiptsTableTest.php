<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ConsecutivereceiptsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ConsecutivereceiptsTable Test Case
 */
class ConsecutivereceiptsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ConsecutivereceiptsTable
     */
    public $Consecutivereceipts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.consecutivereceipts'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Consecutivereceipts') ? [] : ['className' => 'App\Model\Table\ConsecutivereceiptsTable'];
        $this->Consecutivereceipts = TableRegistry::get('Consecutivereceipts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Consecutivereceipts);

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
