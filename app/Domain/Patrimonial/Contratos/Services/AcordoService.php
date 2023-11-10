<?php

namespace App\Domain\Patrimonial\Contratos\Services;

use Illuminate\Http\Request;
use App\Domain\Patrimonial\Contratos\Models\Acordo;

class AcordoService
{
    public function buscarAcordos(Request $request)
    {
        $condicoes = $this->montaCondicoesAcordo($request);
        return Acordo::with('contratado')->with('contratoPncp')->where($condicoes)->get();
    }

    private function montaCondicoesAcordo(Request $request)
    {
        $condicoes = [];

        if (!empty($request->ac16_sequencial)) {
            $condicoes['ac16_sequencial'] = $request->ac16_sequencial;
        }

        return $condicoes;
    }
}
