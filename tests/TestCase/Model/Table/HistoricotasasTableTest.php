<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\HistoricotasasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\HistoricotasasTable Test Case
 */
class HistoricotasasTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\HistoricotasasTable
     */
    public $Historicotasas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.historicotasas',
        'app.monedas'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Historicotasas') ? [] : ['className' => 'App\Model\Table\HistoricotasasTable'];
        $this->Historicotasas = TableRegistry::get('Historicotasas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Historicotasas);

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
