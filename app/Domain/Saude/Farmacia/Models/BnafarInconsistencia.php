<?php

namespace App\Domain\Saude\Farmacia\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $fa71_id
 * @property integer $fa71_bnafarenvio
 * @property string $fa71_content
 */
class BnafarInconsistencia extends Model
{
    public $timestamps = false;
    protected $table = 'farmacia.bnafarinconsistencias';
    protected $primaryKey = 'fa71_id';
}
