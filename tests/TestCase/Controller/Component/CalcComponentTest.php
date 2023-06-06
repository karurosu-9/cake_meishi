<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\CalcComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\CalcComponent Test Case
 */
class CalcComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Controller\Component\CalcComponent
     */
    protected $Calc;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->Calc = new CalcComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Calc);

        parent::tearDown();
    }

    public function testAdd()
    {
        $this->assertEquals($this->Calc->add(1,2), 3);
    }
}
