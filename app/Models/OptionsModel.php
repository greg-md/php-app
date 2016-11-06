<?php

namespace App\Models;

use App\Orm\Table;

class OptionsModel extends Table
{
    protected $name = 'Options';

    protected $nameColumn = 'Name';

    protected $customColumnsTypes = [
        'Required' => 'boolean',
        'Active'   => 'boolean',
    ];

    public function getActiveList()
    {
        return $this
            ->where('Active', 1)
            ->orderDesc('Rank')
            ->fetchPairs('Key', 'Value');
    }
}
