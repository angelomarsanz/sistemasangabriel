<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MiclientsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MiclientsTable Test Case
 */
class MiclientsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MiclientsTable
     */
    public $Miclients;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.miclients'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Miclients') ? [] : ['className' => 'App\Model\Table\MiclientsTable'];
        $this->Miclients = TableRegistry::get('Miclients', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Miclients);

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
