<?php
declare(strict_types=1);

namespace App\Test\TestCase\View\Helper;

use App\View\Helper\ViewFormHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * App\View\Helper\ViewFormHelper Test Case
 */
class ViewFormHelperTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\View\Helper\ViewFormHelper
     */
    protected $ViewForm;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $view = new View();
        $this->ViewForm = new ViewFormHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ViewForm);

        parent::tearDown();
    }
}
