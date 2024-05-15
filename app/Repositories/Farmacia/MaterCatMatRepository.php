<?php

namespace App\Repositories\Farmacia;

use App\Models\MaterCatMat;

include("libs/PHPExcel/Classes/PHPExcel.php");
class MaterCatMatRepository
{
    /**
     *
     * @var MaterCatMat
     */
    private MaterCatMat $model;

    public function __construct()
    {
        $this->model = new MaterCatMat;
    }
}
