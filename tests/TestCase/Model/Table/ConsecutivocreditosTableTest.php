<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ConsecutivocreditosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ConsecutivocreditosTable Test Case
 */
class ConsecutivocreditosTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ConsecutivocreditosTable
     */
    public $Consecutivocreditos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.consecutivocreditos'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Consecutivocreditos') ? [] : ['className' => 'App\Model\Table\ConsecutivocreditosTable'];
        $this->Consecutivocreditos = TableRegistry::get('Consecutivocreditos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Consecutivocreditos);

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
