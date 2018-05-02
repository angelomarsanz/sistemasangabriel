<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BinnaclesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BinnaclesTable Test Case
 */
class BinnaclesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\BinnaclesTable
     */
    public $Binnacles;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.binnacles'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Binnacles') ? [] : ['className' => 'App\Model\Table\BinnaclesTable'];
        $this->Binnacles = TableRegistry::get('Binnacles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Binnacles);

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
