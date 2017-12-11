<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SalesbooksTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SalesbooksTable Test Case
 */
class SalesbooksTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SalesbooksTable
     */
    public $Salesbooks;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.salesbooks'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Salesbooks') ? [] : ['className' => 'App\Model\Table\SalesbooksTable'];
        $this->Salesbooks = TableRegistry::get('Salesbooks', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Salesbooks);

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
