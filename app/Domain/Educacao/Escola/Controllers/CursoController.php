<?php

namespace App\Domain\Educacao\Escola\Controllers;

use App\Domain\Core\Base\Http\Response\DBJsonResponse;
use App\Http\Controllers\Controller;
use App\Domain\Educacao\Escola\Models\CursoEdu;

class CursoController extends Controller
{
    public function getCursosByEscola($escola)
    {
        $cursos = CursoEdu
            ::join('cursoescola', 'cursoescola.ed71_i_curso', '=', 'cursoedu.ed29_i_codigo')
            ->where("cursoescola.ed71_i_escola", $escola)->get();

        return new DBJsonResponse($cursos);
    }
}
