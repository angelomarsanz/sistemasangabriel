<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MiconceptsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MiconceptsTable Test Case
 */
class MiconceptsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MiconceptsTable
     */
    public $Miconcepts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.miconcepts'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Miconcepts') ? [] : ['className' => 'App\Model\Table\MiconceptsTable'];
        $this->Miconcepts = TableRegistry::get('Miconcepts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Miconcepts);

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
