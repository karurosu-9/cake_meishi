<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\LoginUserComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\LoginUserComponent Test Case
 */
class LoginUserComponentTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Controller\Component\LoginUserComponent
     */
    protected $LoginUser;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->LoginUser = new LoginUserComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->LoginUser);

        parent::tearDown();
    }
}
