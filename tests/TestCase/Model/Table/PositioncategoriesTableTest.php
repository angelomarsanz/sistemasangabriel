<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PositioncategoriesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PositioncategoriesTable Test Case
 */
class PositioncategoriesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PositioncategoriesTable
     */
    public $Positioncategories;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.positioncategories'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Positioncategories') ? [] : ['className' => 'App\Model\Table\PositioncategoriesTable'];
        $this->Positioncategories = TableRegistry::get('Positioncategories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Positioncategories);

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
