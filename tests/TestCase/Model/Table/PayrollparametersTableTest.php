<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PayrollparametersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PayrollparametersTable Test Case
 */
class PayrollparametersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PayrollparametersTable
     */
    public $Payrollparameters;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.payrollparameters'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Payrollparameters') ? [] : ['className' => 'App\Model\Table\PayrollparametersTable'];
        $this->Payrollparameters = TableRegistry::get('Payrollparameters', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Payrollparameters);

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
