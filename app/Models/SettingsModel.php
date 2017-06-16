<?php

namespace App\Models;

use Greg\Orm\Model;

class SettingsModel extends Model
{
    protected $name = 'Settings';

    protected $nameColumn = 'Name';

    public function getList()
    {
        return $this->fetchPairs('Key', 'Value');
    }
}
