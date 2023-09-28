<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MeishiDataTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MeishiDataTable Test Case
 */
class MeishiDataTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MeishiDataTable
     */
    protected $MeishiData;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.MeishiData',
        'app.Corps',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('MeishiData') ? [] : ['className' => MeishiDataTable::class];
        $this->MeishiData = $this->getTableLocator()->get('MeishiData', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->MeishiData);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\MeishiDataTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\MeishiDataTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
