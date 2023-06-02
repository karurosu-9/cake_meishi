<?php
namespace App\View\Helper;

use Cake\View\Helper;

class CommonHelper extends Helper
{

    public function initialize(array $config) :void
    {
        parent::initialize($config);
    }

    public function displayNoDataMessage($counter)
    {
        if ($counter === 0) {
            return '<span style="color: red; font-weight: bold;">※該当するデータはありません。</span>';
        }

        return;
    }
}
?>
