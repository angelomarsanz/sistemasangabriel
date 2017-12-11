<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MistudentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MistudentsTable Test Case
 */
class MistudentsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MistudentsTable
     */
    public $Mistudents;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.mistudents'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Mistudents') ? [] : ['className' => 'App\Model\Table\MistudentsTable'];
        $this->Mistudents = TableRegistry::get('Mistudents', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Mistudents);

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
