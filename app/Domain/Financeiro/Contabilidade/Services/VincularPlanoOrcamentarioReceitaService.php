<?php

namespace App\Domain\Financeiro\Contabilidade\Services;

use App\Domain\Financeiro\Contabilidade\Mappers\PlanoContas\PlanoContas;
use App\Domain\Financeiro\Contabilidade\Models\ConplanoOrcamento;
use App\Domain\Financeiro\Contabilidade\Models\PlanoReceita;
use App\Domain\Financeiro\Contabilidade\Resources\MapaPlanoContasOrcamentarioResource;
use Illuminate\Support\Facades\DB;

class VincularPlanoOrcamentarioReceitaService extends VincularPlanoOrcamentario
{
    /**
     * @param $id
     * @return PlanoReceita
     */
    public function getPlanoOrcamentario($id)
    {
        return PlanoReceita::find($id);
    }

    public function getContasEcidade(array $filtros)
    {
        $contas = $this->getContasConplanoOrcamento($filtros);
        $tipoPlano = $filtros['tipoPlano'];
        $retornar = $contas->map(function (ConplanoOrcamento $conta) use ($tipoPlano) {
            if ($tipoPlano === PlanoContas::PLANO_UNIAO) {
                $contasVinculadas = $conta->planoUniaoReceita;
                $temVinculo = $contasVinculadas->count() > 0;
            } else {
                $contasVinculadas = $conta->planoEstadualReceita;
                $temVinculo = $contasVinculadas->count() > 0;
            }

            return MapaPlanoContasOrcamentarioResource::toData($conta, $temVinculo, $contasVinculadas);
        });

        return $retornar->toArray();
    }

    public function getContasPadrao(array $filtros)
    {
        return PlanoReceita::orderBy('conta')
            ->select('*')
            ->when(!empty($filtros['conta']), function ($query) use ($filtros) {
                $query->where('conta', 'like', "{$filtros['conta']}%");
            })
            ->when(!empty($filtros['tipoPlano']), function ($query) use ($filtros) {
                $query->where('uniao', $filtros['tipoPlano'] === PlanoContas::PLANO_UNIAO);
            })
            ->when(!empty($filtros['exercicio']), function ($query) use ($filtros) {
                $query->where('exercicio', '=', $filtros['exercicio']);
            })
            ->when(isset($filtros['apenasAnaliticas']), function ($query) {
                $query->where('sintetica', false);
            })
            ->get()
            ->map(function (PlanoReceita $planoOrcamentario) use ($filtros) {
                if (isset($filtros['comVinculos'])) {
                    $planoOrcamentario->contas_ecidade = $planoOrcamentario
                        ->contasEcidade()
                        ->get()
                        ->map(function (ConplanoOrcamento $conplanoOrcamento) {
                            return MapaPlanoContasOrcamentarioResource::toData(
                                $conplanoOrcamento,
                                true
                            );
                        });
                    $planoOrcamentario->tem_vinculo = $planoOrcamentario->contas_ecidade->count();
                }

                return $planoOrcamentario;
            })->toArray();
    }

    /**
     * Realiza o v�nculo das contas onde da um match com o estrutural das contas.
     * Para isso, pensamos na seguinte l�gica.
     *  - Removemos o n�mero 4 extra na frente das contas do e-cidade;
     *  - pegamos o tamanho da conta do governo... exemplo 8 digitos;
     *  - aplicamos um corte no estrutural do e-cidade realizamos a compara��o das contas (e-Cidade = Gov)
     * Se der match criamos o v�nculo
     * @param array $filtros
     */
    public function vinculoGeral(array $filtros)
    {
        $contasGoverno = PlanoReceita::orderBy('conta')
            ->select('*')
            ->when(!empty($filtros['tipoPlano']), function ($query) use ($filtros) {
                $query->where('uniao', $filtros['tipoPlano'] === PlanoContas::PLANO_UNIAO);
            })
            ->when(!empty($filtros['exercicio']), function ($query) use ($filtros) {
                $query->where('exercicio', '=', $filtros['exercicio']);
            })
            ->where('sintetica', false)
            ->get();

        $contasGoverno->each(function (PlanoReceita $planoOrcamentario) {
            $tamanhoConta = strlen($planoOrcamentario->conta);

            // contas de dedu��o (classe 9) deve pegar o estrutural inteiro, incluindo o 9.
            $corte = $planoOrcamentario->classe === 9 ? 1 : 2;

            $contasEcidade = DB::table('contabilidade.conplanoorcamento')
                ->select('c60_codigo')
                ->where('c60_anousu', $planoOrcamentario->exercicio)
                // procura contas com o padr�o do estrutural da conta do governo
                ->whereRaw("substring(c60_estrut, $corte, $tamanhoConta) = '$planoOrcamentario->conta'")
                // garante contas da receita contas 4 e 9
                ->whereRaw("substring(c60_estrut, 1, 1)::int = {$planoOrcamentario->classe}")
                ->get();

            if (!$contasEcidade->isEmpty()) {
                $idContasEcidade = $contasEcidade->map(function ($conta) {
                    return $conta->c60_codigo;
                })->toArray();

                $this->vincularContas($planoOrcamentario, $idContasEcidade);
            }
        });
    }


    public function vincular($planoOrcamentario, array $idsContasEcidade)
    {
        $existe = DB::table('contabilidade.planoreceitaconplanoorcamento')
            ->join('contabilidade.planoreceita', 'planoreceita.id', '=', 'planoreceita_id')
            ->whereIn('conplanoorcamento_codigo', $idsContasEcidade)
            ->where('planoreceita_id', '!=', $planoOrcamentario->id)
            ->where('uniao', $planoOrcamentario->uniao)
            ->first();

        if (!is_null($existe)) {
            $str = "Uma ou mais conta(s) do e-cidade selecionada(s), ";
            $str .= "j� est�o v�nculada(s) a uma conta do plano do Governo.";
            throw new \Exception($str);
        }

        parent::vincular($planoOrcamentario, $idsContasEcidade);
        return true;
    }
}
