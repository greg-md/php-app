<?php

namespace App\Models;

use App\Orm\Table;

class LanguagesModel extends Table
{
    protected $name = 'Languages';

    protected $nameColumn = 'Name';

    protected $customColumnsTypes = [
        'Base'   => 'boolean',
        'Active' => 'boolean',
    ];

    public function getActiveItems()
    {
        return $this->where('Active', 1)->orderDesc('Rank')->rows();
    }

    public function locales()
    {
        return array_map('trim', array_filter(explode(',', $this['Locale'])));
    }
}
