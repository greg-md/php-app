<?php

namespace App\Models;

use Greg\Orm\Model;

class TranslatesLangModel extends Model
{
    protected $name = 'TranslatesLang';

    public function getListByLang($systemName)
    {
        return $this
            ->where('LangSystemName', $systemName)
            ->selectOnly('TranslateKey', 'Text')
            ->fetchPairs();
    }
}
