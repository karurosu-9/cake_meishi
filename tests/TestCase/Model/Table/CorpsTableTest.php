<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CorpsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CorpsTable Test Case
 */
class CorpsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CorpsTable
     */
    protected $Corps;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
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
        $config = $this->getTableLocator()->exists('Corps') ? [] : ['className' => CorpsTable::class];
        $this->Corps = $this->getTableLocator()->get('Corps', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Corps);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CorpsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
