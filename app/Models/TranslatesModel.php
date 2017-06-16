<?php

namespace App\Models;

use Greg\Orm\Driver\DriverStrategy;
use Greg\Orm\Model;

class TranslatesModel extends Model
{
    protected $name = 'Translates';

    private $langModel;

    public function __construct(DriverStrategy $driver, TranslatesLangModel $langModel)
    {
        parent::__construct($driver);

        $this->langModel = $langModel;
    }

    public function getListByLang($systemName)
    {
        return $this->langModel->getListByLang($systemName);
    }

    public function lang()
    {
        return $this->hasMany($this->langModel, 'TranslateKey');
    }
}
