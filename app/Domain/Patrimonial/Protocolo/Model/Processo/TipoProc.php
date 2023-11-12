<?php

namespace App\Domain\Patrimonial\Protocolo\Model\Processo;

use App\Domain\Patrimonial\Ouvidoria\Model\TipoprocPersona;
use App\Domain\Patrimonial\Protocolo\Model\Persona;
use Illuminate\Database\Eloquent\Model;

class TipoProc extends Model
{
    protected $table = 'protocolo.tipoproc';
    protected $primaryKey = 'p51_codigo';
    public $timestamps = false;

    public function personas()
    {
        return $this->belongsToMany(
            Persona::class,
            "ouvidoria.tipoprocpersona",
            "ov34_tipoproc",
            "ov34_persona"
        )->withPivot('ov34_sequencial');
    }
}
