<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ConsecutivodebitosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ConsecutivodebitosTable Test Case
 */
class ConsecutivodebitosTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ConsecutivodebitosTable
     */
    public $Consecutivodebitos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.consecutivodebitos'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Consecutivodebitos') ? [] : ['className' => 'App\Model\Table\ConsecutivodebitosTable'];
        $this->Consecutivodebitos = TableRegistry::get('Consecutivodebitos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Consecutivodebitos);

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
