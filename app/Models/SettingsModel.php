<?php

namespace App\Models;

use App\Orm\Table;

class SettingsModel extends Table
{
    protected $name = 'Settings';

    protected $nameColumn = 'Name';

    public function getList()
    {
        return $this->fetchPairs('Key', 'Value');
    }
}
