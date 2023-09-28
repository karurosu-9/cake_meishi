<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MyCorpsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MyCorpsTable Test Case
 */
class MyCorpsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MyCorpsTable
     */
    protected $MyCorps;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.MyCorps',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('MyCorps') ? [] : ['className' => MyCorpsTable::class];
        $this->MyCorps = $this->getTableLocator()->get('MyCorps', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->MyCorps);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\MyCorpsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
