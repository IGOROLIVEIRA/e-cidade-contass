<?php

namespace App\Models;

use App\Traits\LegacyAccount;
use Illuminate\Database\Eloquent\Builder;

class Discla extends LegacyModel
{
    use LegacyAccount;

    /**
     * @var string
     */
    protected $table = 'caixa.discla';

    /**
     * @var string
     */
    protected $primaryKey = 'codcla';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    public $timestamps = false;

    public function getByCodret(int $codret)
    {
        return $this->newQuery()->where('codret', $codret)->first();
    }
}