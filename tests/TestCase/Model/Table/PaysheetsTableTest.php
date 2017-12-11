<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PaysheetsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PaysheetsTable Test Case
 */
class PaysheetsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PaysheetsTable
     */
    public $Paysheets;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.paysheets',
        'app.employeepayments'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Paysheets') ? [] : ['className' => 'App\Model\Table\PaysheetsTable'];
        $this->Paysheets = TableRegistry::get('Paysheets', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Paysheets);

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
