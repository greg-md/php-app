<?php

namespace App\Models;

use Greg\Orm\Model;

class LanguagesModel extends Model
{
    protected $name = 'Languages';

    protected $nameColumn = 'Name';

    protected $customColumnsTypes = [
        'Base'   => 'boolean',
        'Active' => 'boolean',
    ];

    public function getActiveItems()
    {
        return $this->where('Active', 1)->orderDesc('Rank')->fetchRows();
    }

    public function locales()
    {
        return array_map('trim', array_filter(explode(',', $this['Locale'])));
    }
}
