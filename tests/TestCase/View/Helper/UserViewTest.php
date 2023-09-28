<?php
namespace App\Test\TestCase\View;

use Cake\TestSuite\TestCase;
use Cake\View\View;

class UserViewTest extends TestCase
{
    /**
     * @var \Cake\View\View
     */
    protected $View;

    /**
     * Set up method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->View = new View();
    }

    /**
     * Tear down method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->View);
        parent::tearDown();
    }

    /**
     * Test the user view template
     *
     * @return void
     */
    public function testUserViewTemplate(): void
    {
        $this->View->set('user', [
            'id' => 1,
            'userName' => 'John Doe',
            'division' => [
                'divisionName' => 'Sales'
            ]
        ]);

        // Viewの描画結果を取得
        $output = $this->View->render('Users/view');

        // テストしたい断言（例：特定のHTML要素が存在することを確認）
        $this->assertStringContainsString('<h3>名前：　John Doe</h3>', $output);
        $this->assertStringContainsString('<p>所属部署：　Sales</p>', $output);
    }
}
