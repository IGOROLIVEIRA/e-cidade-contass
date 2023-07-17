<?php

namespace App\Traits;

use Illuminate\Database\Capsule\Manager as DB;
use LogicException;

trait LegacyAutoIncriment
{
    public function __construct()
    {
        parent::__construct();
        $this->primaryKey = $this->getNextVal();
    }

    protected function getNextVal(): int
    {
        if (empty($this->sequenceName)) {
            throw new LogicException('Para usar a trait LegacyAutoIncriment é necessário informar a propriedade sequenceName no model.');
        }
        ['acount' => $sequence] = (array)DB::connection()
            ->selectOne("select nextval('{$this->sequenceName}') as acount");
        return $sequence;
    }
}
