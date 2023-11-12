<?php

namespace App\Domain\Financeiro\Contabilidade\Services;

use App\Domain\Configuracao\Instituicao\Model\DBConfig;
use App\Domain\Financeiro\Contabilidade\Models\ConplanoOrcamento;
use App\Domain\Financeiro\Contabilidade\Services\Relatorios\RelatorioBalanceteDespesaService;
use App\Domain\Financeiro\Orcamento\Models\Dotacao;
use App\Domain\Financeiro\Planejamento\Models\DetalhamentoDespesa;
use App\Domain\Financeiro\Planejamento\Models\Valor;
use ECidade\Financeiro\Contabilidade\PlanoDeContas\Estrutural;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use JSON;

class ManutencaoPlanoOrcamentarioDespesaService extends ManutencaoPlanoOrcamentarioService
{
    /**
     * Valida as contas or�ament�rias da despesa que n�o possuem uso no exerc�cio atual
     * @param string $estrutural
     * @param int $exercicio
     * @return Collection
     */
    public function buscarDespesasParaExcluisao($estrutural, $exercicio)
    {
        $contas = $this->getContas(['estrutural' => $estrutural, "exercicio" => $exercicio]);
        $balancete = $this->executaBalanceteDespesa($exercicio);

        // exclui da lista contas que n�o tem o sexto n�vel
        $despesasExcluir = $contas->reject(function (ConplanoOrcamento $conta) {
            $estrutural = new Estrutural($conta->c60_estrut);
            return $estrutural->getNivel() !== 6;
        });

        // remove da lista contas com previs�o de despesa
        $despesasExcluir = $despesasExcluir->reject(function (ConplanoOrcamento $conta) use ($balancete) {
            //localiza no balancete a conta
            return $this->temMovimentacao($balancete, $conta);
        });

        $elementosComEstimativa = DetalhamentoDespesa::query()
            ->where('pl20_anoorcamento', $exercicio)
            ->get()
            ->filter(function (DetalhamentoDespesa $detalhamentoDespesa) {
                $valores = $detalhamentoDespesa->getValores()->filter(function (Valor $valor) {
                    return $valor->pl10_valor > 0;
                });

                return !$valores->isEmpty();
            })->map(function (DetalhamentoDespesa $detalhamentoDespesa) {
                return $detalhamentoDespesa->getNaturezaDespesa()->o56_elemento;
            })
            ->toArray();

        // filtra se a receita foi usada no planejamento
        $despesasExcluir = $despesasExcluir->reject(function (ConplanoOrcamento $plano) use ($elementosComEstimativa) {
            return in_array($plano->c60_estrut, $elementosComEstimativa);
        });

        return $despesasExcluir;
    }

    /**
     * @param $exercicio
     * @return array
     */
    public function executaBalanceteDespesa($exercicio)
    {
        $instituicoes = DBConfig::select(['codigo', 'nomeinst', 'prefeitura'])->get();
        $prefeitura = $instituicoes->filter(function (DBConfig $config) {
            return $config->prefeitura;
        })->shift();

        $filtros = [
            "instituicoes" => JSON::create()->stringify($instituicoes->toArray()),
            "dataInicio" => sprintf('01/01/%s', $exercicio),
            "dataFinal" => sprintf('31/12/%s', $exercicio),
            "modelo" => "sintetico",
            "nivel" => ["elemento"],
            "filtros" => JSON::create()->stringify([]),
            "DB_instit" => $prefeitura->codigo,
        ];

        $service = new RelatorioBalanceteDespesaService();
        $service->setFiltrosRequest($filtros);
        return $service->getDadosProcessados();
    }

    public function excluirContas($contas)
    {
        $this->exercicio = $contas[0]->c60_anousu;

        $contasSelecionadas = [];
        foreach ($contas as $conta) {
            $estruturalConta = new Estrutural($conta->c60_estrut);
            $estruturalAteNivel = $estruturalConta->getEstruturalAteNivel();
            ConplanoOrcamento::where('c60_anousu', '=', $conta->c60_anousu)
                ->where('c60_codcon', '!=', $conta->c60_codcon)
                ->where('c60_estrut', 'like', "$estruturalAteNivel%")
                ->get()
                ->each(function (ConplanoOrcamento $contaAnalitica) {
                    $this->contasAnaliticas[] = $contaAnalitica->c60_codcon;
                });
            $contasSelecionadas[] = $conta->c60_codcon;
        }

        //remove os desdobramentos dos elementos de despesa
        $this->removerVinculos($this->contasAnaliticas);
        $this->removerVinculos($contasSelecionadas);

        $this->removerContasPai($contas);
    }

    protected function removerVinculos(array $contas)
    {
        $this->removeVinculosDespesa($contas);
        $this->removeVinculosPlanejamento($contas);
        $this->removeVinculosOrcamento($contas);
        $this->removeVinculosContabilidade($contas);
    }

    protected function removeVinculosOrcamento(array $codigosContas)
    {
        parent::removeVinculosOrcamento($codigosContas);

        DB::table('orcamento.orcdotacao')
            ->where('o58_anousu', '>=', $this->exercicio)
            ->whereIn('o58_codele', $codigosContas)
            ->delete();

        DB::table('orcamento.orcelemento')
            ->where('o56_anousu', '>=', $this->exercicio)
            ->whereIn('o56_codele', $codigosContas)
            ->delete();
    }

    protected function removeVinculosPlanejamento(array $contas)
    {
        DB::table('planejamento.detalhamentoiniciativa')
            ->where('pl20_anoorcamento', '>=', $this->exercicio)
            ->whereIn('pl20_orcelemento', $contas)
            ->delete();

        DB::table('planejamento.fatorcorrecaodespesa')
            ->where('pl7_anoorcamento', '>=', $this->exercicio)
            ->whereIn('pl7_orcelemento', $contas)
            ->delete();
    }

    private function removeVinculosDespesa(array $contas)
    {
        $codigosPPA = DB::table('orcamento.ppadotacao')
            ->where('o08_ano', '>=', $this->exercicio)
            ->whereIn('o08_elemento', $contas)
            ->get()
            ->map(function ($ppadotacao) {
                return $ppadotacao->o08_sequencial;
            })->toArray();

        DB::table('orcamento.ppadotacaoorcdotacao')
            ->whereIn('o19_ppadotacao', $codigosPPA)
            ->delete();

        DB::table('orcamento.ppadotacao')
            ->whereIn('o08_sequencial', $codigosPPA)
            ->delete();
    }

    private function removerContasPai($contas)
    {
        foreach ($contas as $conta) {
            $estruturalConta = new Estrutural($conta->c60_estrut);
            $continua = true;
            while ($continua) {
                $estruturalConta = $this->buscaContaPai($estruturalConta->getEstrutural());
                $filtros = ['estrutural' => $estruturalConta->getEstrutural(), "exercicio" => $this->exercicio];
                $contasOrcamento = $this->getContas($filtros);
                if ($contasOrcamento->count() === 1) {
                    $contaOrcamento = $contasOrcamento->shift();
                    $this->removerVinculos([$contaOrcamento->c60_codcon]);
                } else {
                    $continua = false;
                }
            }
        }
    }


    private function buscaContaPai($estrutural)
    {
        $estruturalConta = new Estrutural($estrutural);
        return $estruturalConta->getEstruturalPai();
    }

    /**
     * @param array $balancete
     * @param ConplanoOrcamento $conta
     * @return bool
     */
    public function temMovimentacao(array $balancete, ConplanoOrcamento $conta)
    {
        $dadoBalancete = collect($balancete)->filter(function ($bal) use ($conta) {
            $estruturalBalancete = new Estrutural($bal->codigo);
            $estruturalConta = new Estrutural($conta->c60_estrut);
            return $estruturalConta->getEstruturalAteNivel() === $estruturalBalancete->getEstruturalAteNivel();
        })->shift();

        // se possui execu��o, n�o pode excluir
        if (!is_null($dadoBalancete)) {
            $temSaldo = (
                $dadoBalancete->valores->saldo_inicial != 0 ||
                $dadoBalancete->valores->saldo_disponivel != 0 ||
                $dadoBalancete->valores->suplementado != 0 ||
                $dadoBalancete->valores->suplementado_especial != 0 ||
                $dadoBalancete->valores->reducoes != 0 ||
                $dadoBalancete->valores->empenhado_liquido != 0 ||
                $dadoBalancete->valores->empenhado_liquido_acumulado != 0 ||
                $dadoBalancete->valores->liquidado_acumulado != 0 ||
                $dadoBalancete->valores->pago_acumulado != 0
            );
            return $temSaldo;
        }
        return false;
    }
}
