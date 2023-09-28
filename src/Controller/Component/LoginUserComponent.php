<?php
declare(strict_types=1);

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

/**
 * LoginUser component
 */
class LoginUserComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected $_defaultConfig = [];

    public function getLoginUser()
    {
        $loginUser = $this->getController()->Authentication->getIdentity();
        
        return $loginUser;
    }
}
