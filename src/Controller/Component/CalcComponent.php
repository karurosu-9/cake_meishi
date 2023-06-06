<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

/**
 * Calc component
 */
class CalcComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected $_defaultConfig = [];

    public function add(int $num1, int $num2): int
    {
        return $num1 + $num2;
    }

    public function diff(int $num1, int $num2): int
    {
        return $num1 -$num2;
    }
}
