<?php

namespace App\Models;

use App\Orm\Table;

class TranslatesModel extends Table
{
    protected $name = 'Translates';

    public function getListByLang($systemName)
    {
        return $this->app()->scope(function (TranslatesLangModel $model) use ($systemName) {
            return $model->getListByLang($systemName);
        });
    }

    /**
     * @return TranslatesLangModel
     */
    public function lang()
    {
        return $this->hasMany(TranslatesLangModel::class, 'TranslateKey');
    }
}
