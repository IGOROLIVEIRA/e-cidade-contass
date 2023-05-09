<?php

namespace App\Models;

use App\Traits\LegacyAccount;

class Arretipo extends LegacyModel
{
    use LegacyAccount;
    /**
     * @var string
     */
    protected $table = 'caixa.arretipo';

    /**
     * @var string
     */
    protected $primaryKey = 'k00_tipo';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    public $timestamps = false;
}