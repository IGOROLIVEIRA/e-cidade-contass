<?php

namespace App\Domain\Financeiro\Contabilidade\Builder;

use App\Domain\Financeiro\Contabilidade\Contracts\PlanoContasOrcamentarioInterface;
use App\Domain\Financeiro\Contabilidade\Mappers\PlanoContas\PlanoContas;
use Carbon\Carbon;
use Exception;

class PlanoOrcamentarioReceitaBuilder extends PlanoOrcamentarioBuilder
{
    public function build()
    {
        $dados = [];
        $dado = [];
        $colunasMapeadas = $this->layout->colunasMapper();
        foreach ($this->layout->colunasImportar() as $indexColuna) {
            $dado[$colunasMapeadas[$indexColuna]] = $this->linha[$indexColuna];
        }

        $dado['exercicio'] = $this->exercicio;
        $dado['uniao'] = $this->plano === PlanoContas::PLANO_UNIAO;
        $dado['conta'] = str_replace('.', '', $dado['conta']);
        $dado['nome'] = str_replace("\n", '', $dado['nome']);

        $dado['desdobramento4'] = $dado['desdobramento4'] === '' ? '00' : $dado['desdobramento4'];
        $dado['desdobramento5'] = $dado['desdobramento5'] === '' ? '00' : $dado['desdobramento5'];
        $dado['desdobramento6'] = $dado['desdobramento6'] === '' ? '00' : $dado['desdobramento6'];
        if (isset($dado['funcao'])) {
            $dado['funcao'] = str_replace("\n", '', $dado['funcao']);
        }
        if (isset($dado['sintetica'])) {
            $dado['sintetica'] = $this->sintetica($dado['sintetica']);
        }
        $dado['created_at'] = Carbon::now();
        $dado['updated_at'] = Carbon::now();

        $dado['classe'] = 4;
        $dados[] = $dado;
        if ($dado['categoria'] != 9) {
            $intra = $this->criaIntra($dado);
            $dados[] = $intra;
        }
        return $dados;
    }

    protected function criaIntra(array $dado)
    {
        $categoria = $dado['categoria'] == 1 ? 7 : 8;
        $copia = $dado;
        $copia['categoria'] = $categoria;
        $copia['conta'][0] = $categoria;
        $copia['nome'] = $copia['nome'] . ' - Intra OFSS';
        return $copia;
    }

    protected function criaDeducao(array $dado)
    {
        $copia = $dado;
        $copia['classe'] = 9;
        $copia['conta'] = "9{$copia['conta']}";
        $copia['nome'] = '(R) - ' . $copia['nome'];
        return $copia;
    }
}
