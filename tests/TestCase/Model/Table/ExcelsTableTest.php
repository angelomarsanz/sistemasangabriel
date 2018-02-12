<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ExcelsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ExcelsTable Test Case
 */
class ExcelsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ExcelsTable
     */
    public $Excels;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.excels'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Excels') ? [] : ['className' => 'App\Model\Table\ExcelsTable'];
        $this->Excels = TableRegistry::get('Excels', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Excels);

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
