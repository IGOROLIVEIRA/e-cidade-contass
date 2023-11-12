<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2009  DBSeller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

namespace App\Domain\Financeiro\Contabilidade\Services\Relatorios\LRF;

use App\Domain\Configuracao\Instituicao\Model\DBConfig;
use App\Domain\Configuracao\Services\AssinaturaService;
use App\Domain\Financeiro\Contabilidade\Services\BalanceteDespesaService;
use Carbon\Carbon;
use cl_empresto;
use db_utils;
use DBDate;
use DBDepartamento;
use ECidade\Configuracao\RelatorioLegal\Servico\ParseConfiguracaoXml;
use ECidade\Financeiro\Contabilidade\Relatorio\DemonstrativoFiscal;
use Exception;
use Illuminate\Support\Facades\DB;
use Periodo;
use stdClass;

/**
 * Class AnexosService
 * @package App\Domain\Financeiro\Contabilidade\Services\Relatorios\LRF
 */
abstract class AnexosService
{
    const SEM_ORIGEM = 0;
    const ORIGEM_RECEITA = 1;
    const ORIGEM_DESPESA = 2;
    const ORIGEM_VERIFICACAO = 3;
    const ORIGEM_RP = 4;

    const TIPO_PREFEITURA = 1;

    /**
     * @var DBConfig[]
     */
    protected $instituicoes;
    /**
     * @var integer[]
     */
    protected $listaInstituicoes;

    /**
     * @var AssinaturaService
     */
    protected $assinatura;

    /**
     * @var integer
     */
    protected $exercicio;
    /**
     * @var Periodo
     */
    protected $periodo;
    /**
     * @var DBDate
     */
    protected $dataIncio;
    /**
     * @var DBDate
     */
    protected $dataFim;

    /**
     * Linhas do relat�rio legal
     * @var StdClass[]
     */
    protected $linhas;

    /**
     * Quando haver necessidade de processar linhas fora do padr�o,
     * informar a ordem das linhas no array $linhasNaoProcessar
     * essas linhas n�o ser�o processadas.
     * @var array
     */
    protected $linhasNaoProcessar = [];

    /**
     * Processamento do balancete da receita
     * @var array
     */
    protected $balanceteReceita = [];

    /**
     * Processamento do balancete da despesa
     * @var array
     */
    protected $balanceteDespesa = [];

    /**
     * Processamento do balancete da verificacao
     * @var array
     */
    protected $balanceteVerificacao = [];

    /**
     * Processamento dos Restos a Pagar
     * @var array
     */
    protected $restosPagar = [];

    /**
     * @var int
     */
    protected $idRelatorio;

    /**
     * Array com um mapa das linhas totalizadoras que devem ser somadas
     * Exemplo:
     *  linha1 = linha2 + linha2 + linha5
     *  [1 => [2, 3, 5]]
     * @var array
     */
    protected $totalizarSoma = [];
    /**
     * Array com um mapa das linhas totalizadoras que devem ser subtra�das
     * Exemplo:
     *  linha1 = linha2 - linha2 - linha5
     *  [1 => [2, 3, 5]]
     * @var array
     */
    protected $totalizarSubtracao = [];

    protected $colunasReceita = [
        'valor_inicial' => 'valor_inicial',
        'previsao_adicional_acumulado' => 'previsao_adicional_acumulado',
        'previsao_atualizada' => 'previsao_atualizada',
        'arrecadado_anterior' => 'arrecadado_anterior',
        'arrecadado_periodo' => 'arrecadado_periodo',
        'valor_a_arrecadar' => 'valor_a_arrecadar',
        'arrecadado_acumulado' => 'arrecadado_acumulado',
        'previsao_adicional' => 'previsao_adicional',
    ];

    protected $colunasDespesa = [
        'saldo_inicial' => 'saldo_inicial',
        'saldo_anterior' => 'saldo_anterior',
        'saldo_disponivel' => 'saldo_disponivel',
        'total_creditos' => 'total_creditos',
        'suplementado' => 'suplementado',
        'suplementado_especial' => 'suplementado_especial',
        'reducoes' => 'reducoes',
        'saldo_alteracoes_orcamentarias' => 'saldo_alteracoes_orcamentarias',
        'empenhado' => 'empenhado',
        'empenhado_liquido' => 'empenhado_liquido',
        'anulado' => 'anulado',
        'liquidado' => 'liquidado',
        'pago' => 'pago',
        'empenhado_acumulado' => 'empenhado_acumulado',
        'empenhado_liquido_acumulado' => 'empenhado_liquido_acumulado',
        'anulado_acumulado' => 'anulado_acumulado',
        'liquidado_acumulado' => 'liquidado_acumulado',
        'pago_acumulado' => 'pago_acumulado',
        'a_liquidar' => 'a_liquidar',
        'a_pagar' => 'a_pagar',
        'a_pagar_liquidado' => 'a_pagar_liquidado',
    ];

    protected $colunasVerificacao = [
        'saldo_anterior_acumulado' => 'saldo_anterior_acumulado',
        'saldo_debito_acumulado' => 'saldo_debito_acumulado',
        'saldo_credito_acumulado' => 'saldo_credito_acumulado',
        'saldo_final_acumulado' => 'saldo_final_acumulado',
        'saldo_anterior_no_periodo' => 'saldo_anterior_no_periodo',
        'saldo_debito_no_periodo' => 'saldo_debito_no_periodo',
        'saldo_credito_no_periodo' => 'saldo_credito_no_periodo',
        'saldo_final_no_periodo' => 'saldo_final_no_periodo',
    ];

    protected $colunasRp = [
        'valor_empenhado' => 'valor_empenhado',
        'valor_anulado_empenho' => 'valor_anulado_empenho',
        'valor_liquidado_empenho' => 'valor_liquidado_empenho',
        'valor_pago_empenho' => 'valor_pago_empenho',
        'inscricao_rp_nao_processado' => 'inscricao_rp_nao_processado',
        // inscricao_menos_anulacao_rp_nao_processado � = inscricao_rp_nao_processado - o que foi anulado no exerc�cio
        'inscricao_menos_anulacao_rp_nao_processado' => 'inscricao_menos_anulacao_rp_nao_processado',
        'inscricao_rp_processado' => 'inscricao_rp_processado',
        'inscricao_total_rp' => 'inscricao_total_rp',
        'total_anulacoes' => 'total_anulacoes',
        'anulacao_rp_processado' => 'anulacao_rp_processado',
        'anulacao_rp_nao_processado' => 'anulacao_rp_nao_processado',
        'liquidacoes_rp' => 'liquidacoes_rp',
        'pagamento_rp_processado' => 'pagamento_rp_processado',
        'pagamento_rp_nao_processado' => 'pagamento_rp_nao_processado',
        'total_pagamentos_rp' => 'total_pagamentos_rp',
        'saldo_a_liquidar' => 'saldo_a_liquidar',
        'saldo_liquidados' => 'saldo_liquidados',
    ];

    /**
     * @var \Instituicao
     */
    protected $emissor;
    /**
     * @var string
     */
    protected $enteFederativo;

    /**
     * quando relat�rio organizado por se��es, nesse array armazer
     * @var array
     */
    protected $linhasOrganizadas = [];

    /**
     * @param $idPeriodo
     * @throws Exception
     */
    protected function constructPeriodo($idPeriodo)
    {
        $this->periodo = new Periodo($idPeriodo);
        $this->dataIncio = $this->periodo->getDataInicial($this->exercicio);
        $this->dataFim = $this->periodo->getDataFinal($this->exercicio);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Collection $instituicoes
     */
    protected function constructInstituicoes(\Illuminate\Database\Eloquent\Collection $instituicoes)
    {
        $this->instituicoes = $instituicoes;
        $this->listaInstituicoes = $instituicoes->map(function (DBConfig $instituicao) {
            return $instituicao->codigo;
        });
    }

    protected function constructAssinaturas($idInstituicao)
    {
        $this->assinatura = new AssinaturaService($idInstituicao);
    }

    /**
     * Busca todos dados do relat�rio... linhas, colunas, configura��o.
     * @param integer $idRelatorio
     */
    protected function constructRelatorio($idRelatorio)
    {
        $this->idRelatorio = $idRelatorio;
        $this->constructLinhasRelatorio();
    }

    private function constructLinhasRelatorio()
    {
        $sql = "
        select o69_codparamrel as codigo,
               o69_codseq as linha,
               o69_ordem as ordem,
               o69_descr as descricao,
               o69_manual as manual,
               o69_totalizador as totalizadora,
               o69_nivellinha as nivel,
               o69_origem as origem
          from orcparamseq
         where o69_codparamrel = {$this->idRelatorio}
            order by o69_ordem
        ";

        collect(DB::select($sql))->each(function ($linha) {
            $linha->colunas = $this->buscaColunas($linha);
            $linha->configuracao = $this->processaConfiguracaoLinha($linha);

            $this->linhas[$linha->ordem] = $linha;
        });
    }

    protected function buscaColunas($linha)
    {
        $sql = "
            select o116_sequencial as codigo_coluna,
                   o116_ordem as ordem,
                   o115_descricao as descricao,
                   o115_nomecoluna as coluna,
                   o116_formula as formula,
                   o115_tipo as tipo
             from orcparamseqorcparamseqcoluna
             join orcparamseqcoluna on o115_sequencial = o116_orcparamseqcoluna
            where o116_codparamrel = {$linha->codigo}
              and o116_codseq = {$linha->linha}
              and o116_periodo = {$this->periodo->getCodigo()}
            order by o116_ordem
        ";

        return collect(DB::select($sql))->map(function ($coluna) {
            $coluna->valor = $coluna->tipo == 1 ? 0 : '';
            $coluna->valoManual = $this->getValorManual($coluna);
            return $coluna;
        })->toArray();
    }

    /**
     * @param $coluna
     * @return int
     */
    private function getValorManual($coluna)
    {
        if ($coluna->tipo === 1) {
            $valor = DB::table('configuracoes.orcparamseqorcparamseqcolunavalor')
                ->selectRaw('coalesce(sum(o117_valor::float), 0) as valor')
                ->where('o117_orcparamseqorcparamseqcoluna', '=', $coluna->codigo_coluna)
                ->where('o117_periodo', '=', $this->periodo->getCodigo())
                ->whereIn('o117_instit', $this->listaInstituicoes)
                ->first();

            return $valor->valor;
        }

        return 0;
    }

    /**
     * Busca os valores manuais da linha informada
     * @param $ordemLinha
     * @return stdClass
     */
    public function getValoresManualLinha($ordemLinha)
    {
        $instituicoes = $this->listaInstituicoes->implode(',');
        $sql = "
        select o116_sequencial as codigo_coluna,
               o116_ordem as ordem,
               o115_nomecoluna as coluna,
               o115_tipo as tipo,
               o117_valor as valor
          from orcparamseqorcparamseqcoluna
          join orcparamseq on o69_codparamrel = o116_codparamrel
                          and o69_codseq = o116_codseq
          join orcparamseqcoluna on o115_sequencial = o116_orcparamseqcoluna
          join orcparamseqorcparamseqcolunavalor on o117_orcparamseqorcparamseqcoluna = o116_sequencial

         where o69_ordem = {$ordemLinha}
           and o69_codparamrel = {$this->idRelatorio}
           and o116_periodo = {$this->periodo->getCodigo()}
           and o117_instit in ($instituicoes)
         order by o116_ordem
        ";

        return DB::select($sql);
    }

    /**
     * Busca a configura��o da linha no banco
     * @param $linha
     * @return string|null
     */
    protected function buscaConfiguracao($linha)
    {
        if ($linha->totalizadora) {
            return null;
        }

        $configuracao = DB::table('orcamento.orcparamseqfiltroorcamento')
            ->select('o133_filtro')
            ->where('o133_orcparamrel', '=', $linha->codigo)
            ->where('o133_orcparamseq', '=', $linha->linha)
            ->where('o133_anousu', '=', $this->exercicio)
            ->first();
        if (!is_null($configuracao)) {
            return $configuracao->o133_filtro;
        }

        $configuracaoPadrao = DB::table('orcamento.orcparamseqfiltropadrao')
            ->select('o132_filtro')
            ->where('o132_orcparamrel', '=', $linha->codigo)
            ->where('o132_orcparamseq', '=', $linha->linha)
            ->where('o132_anousu', '=', $this->exercicio)
            ->first();

        if (!is_null($configuracaoPadrao)) {
            return $configuracaoPadrao->o132_filtro;
        }

        return null;
    }

    /**
     * Retorna a configura��o da linha.
     * Se o cliente configurou retora a configura��o do cliente.
     * Se n�o retorna a padr�o. N�o havendo configura��o retorna null.
     * @param $linha
     * @return stdClass|null
     */
    protected function processaConfiguracaoLinha($linha)
    {
        $stringXml = $this->buscaConfiguracao($linha);
        if (empty($stringXml)) {
            return null;
        }

        $parse = new ParseConfiguracaoXml($linha, $this->exercicio);
        return $parse->parse($stringXml);
    }

    protected function buscarLinhasPorOrdem($buscar)
    {
        $ordemLinhas = implode(', ', $buscar);
        $where = implode(' and ', [
            "o69_codparamrel = {$this->idRelatorio}",
            "o69_ordem in ({$ordemLinhas})"
        ]);

        $sql = "
        select o69_codparamrel as codigo,
               o69_codseq as linha,
               o69_ordem as ordem,
               o69_labelrel as descricao,
               o69_manual as manual,
               o69_totalizador as totalizadora,
               o69_nivellinha as nivel,
               o69_origem as origem
          from orcparamseq
         where {$where}
            order by o69_ordem
        ";

        $linhas = [];
        collect(DB::select($sql))->each(function ($linha) use (&$linhas) {
            $linha->colunas = $this->buscaColunas($linha);
            $linha->configuracao = $this->processaConfiguracaoLinha($linha);

            $linhas[$linha->ordem] = $linha;
        });

        return $linhas;
    }

    /**
     * Busca os dados do Balancete de Receita
     * @param $exercicio
     * @param $dataInicio data no formato banco
     * @param $dataFim data no formato banco
     * @return array
     */
    protected function executarBalanceteReceita($exercicio, $dataInicio, $dataFim)
    {
        $instituicoes = $this->listaInstituicoes->implode(',');
        $filtrarMovimentacao = sprintf(
            "(%s or %s or %s or %s)",
            'previsao_adicional_acumulado != 0',
            'valor_a_arrecadar != 0',
            'arrecadado_periodo != 0',
            'arrecadado_acumulado != 0'
        );
        $where = [
            "o70_anousu = {$exercicio}",
            " instituicao in ($instituicoes)",
            $filtrarMovimentacao
        ];

        $sql = $this->sqlBalanceteReceita($where, $dataInicio, $dataFim);
        return DB::select($sql);
    }

    /**
     * retorna o sql para busar os dados da receita
     * @param array $where com filtros da receita
     * @param string $dataInicio
     * @param string $dataFim
     * @return string sql
     */
    protected function sqlBalanceteReceita(array $where, $dataInicio, $dataFim)
    {
        $where = implode(' and ', $where);
        return "
            select balancete_receita_complemento.*,
                   substr(natureza,1,1)::int4 as classe,
                   substr(natureza, 2)::varchar as resto
              from orcreceita
              join balancete_receita_complemento(
                     o70_anousu, o70_codfon, o70_concarpeculiar, '{$dataInicio}', '{$dataFim}'
                   ) on o70_codfon = fonte and o70_anousu = ano
             where {$where}
             order by resto, natureza;
        ";
    }

    /**
     * Busca os dados do Balancete de Despesa
     * @param $exercicio
     * @param $dataInicio data no formato banco
     * @param $dataFim data no formato banco
     * @return array
     */
    protected function executarBalanceteDespesa($exercicio, $dataInicio, $dataFim)
    {
        $service = new BalanceteDespesaService();
        $sql = $service->setAno($exercicio)
            ->setFiltrarInstituicoes($this->listaInstituicoes)
            ->setFiltroDataInicio(Carbon::createFromFormat('Y-m-d', $dataInicio))
            ->setFiltroDataFinal(Carbon::createFromFormat('Y-m-d', $dataFim))
            ->sqlPrincipal();

        return $service->execute($sql);
    }

    /**
     * Busca os dados do Balancete de Verifica��o
     * @param $exercicio
     * @param $dataInicio data no formato banco
     * @param $dataFim data no formato banco
     * @return array
     */
    protected function executarBalanceteVerificacao($exercicio, $dataInicio, $dataFim)
    {
        $instituicoes = $this->listaInstituicoes->implode(',');
        $where = [
            "c61_instit in ($instituicoes)",
            "c62_anousu = {$exercicio}"
        ];

        $sql = $this->sqlBalanceteVerificacao($where, $exercicio, $dataInicio, $dataFim);

        return DB::select($sql);
    }

    /**
     * @param array $where
     * @param integer $exercicio
     * @param string $dataInicio
     * @param string $dataFim
     * @return string
     */
    public function sqlBalanceteVerificacao(array $where, $exercicio, $dataInicio, $dataFim)
    {
        $inicoAno = "$exercicio-01-01";
        $where = implode(' and ', $where);
        return "
        SELECT estrutural,
               c61_reduz,
               c61_codcon,
               recurso,
               fonte_recurso,
               c61_instit,
               round(acumulado[1]::float8, 2)::float8 as saldo_anterior_acumulado,
               round(acumulado[2]::float8, 2)::float8 as saldo_debito_acumulado,
               round(acumulado[3]::float8, 2)::float8 as saldo_credito_acumulado,
               round(acumulado[4]::float8, 2)::float8 as saldo_final_acumulado,
               acumulado[5]::varchar(1) as sinal_anterior_acumulado,
               acumulado[6]::varchar(1) AS sinal_final_acumulado,

               round(no_periodo[1]::float8, 2)::float8 as saldo_anterior_no_periodo,
               round(no_periodo[2]::float8, 2)::float8 as saldo_debito_no_periodo,
               round(no_periodo[3]::float8, 2)::float8 as saldo_credito_no_periodo,
               round(no_periodo[4]::float8, 2)::float8 as saldo_final_no_periodo,
               no_periodo[5]::varchar(1) as sinal_anterior_no_periodo,
               no_periodo[6]::varchar(1) AS sinal_final_no_periodo,
               c60_identificadorfinanceiro,
               c60_consistemaconta
          FROM (
              SELECT p.c60_estrut AS estrutural,
                     c61_reduz,
                     c61_codcon,
                     o15_codigo as recurso,
                     o15_recurso as fonte_recurso,
                     p.c60_descr,
                     p.c60_finali,
                     r.c61_instit,
                     fc_planosaldonovo_array($exercicio, c61_reduz, '{$inicoAno}', '{$dataFim}', false) as acumulado,
                     fc_planosaldonovo_array($exercicio, c61_reduz, '{$dataInicio}', '{$dataFim}', false) as no_periodo,
                     p.c60_identificadorfinanceiro,
                     c60_consistemaconta
                FROM conplanoexe e
                JOIN conplanoreduz r ON r.c61_anousu = c62_anousu
                      AND r.c61_reduz = c62_reduz
                JOIN conplano p ON r.c61_codcon = c60_codcon
                      AND r.c61_anousu = c60_anousu
                join orcamento.orctiporec on orctiporec.o15_codigo = r.c61_codigo
                LEFT OUTER JOIN consistema ON c60_codsis = c52_codsis
               WHERE {$where}
         ) AS x
        ";
    }

    /**
     * Busca os dados de restos a pagar
     * @param $exercicio
     * @param $dataInicio data no formato banco
     * @param $dataFim data no formato banco
     *
     * Legenda das colunas
     *  - saldo_liquidados: � o saldo a pagar liquidado dos RP inscritos como processados e sa�do a pagar dos
     *    RP liquidados no exerc�cio
     *  - saldo_rp_processado: � o saldo dos RP inscritos como processados no exerc�cio
     *
     * @return array
     */
    protected function executarRestosPagar($exercicio, $dataInicio, $dataFim)
    {
        $where = "e60_instit in ({$this->listaInstituicoes->implode(',')})";
        $dao = new cl_empresto();
        $sqlRp = $dao->sqlRpRecursoLancamento($exercicio, $where, $dataInicio, $dataFim);

        $sql = "
        select *,
               (inscricao_rp_nao_processado - anulacao_rp_nao_processado - liquidacoes_rp)::numeric(15,2)
                   as saldo_a_liquidar,
               ((inscricao_rp_processado - anulacao_rp_processado - pagamento_rp_processado) +
                (liquidacoes_rp - pagamento_rp_nao_processado)
               )::numeric(15,2) as saldo_liquidados,
              (inscricao_rp_processado  - anulacao_rp_processado - pagamento_rp_processado)
                  ::numeric(15,2) as saldo_rp_processado
          from (
             select
                    sum(e91_vlremp) as valor_empenhado,
                    sum(e91_vlranu) as valor_anulado_empenho,
                    sum(e91_vlrliq) as valor_liquidado_empenho,
                    sum(e91_vlrpag) as valor_pago_empenho,
                    (sum(e91_vlremp) - sum(e91_vlranu) - sum(e91_vlrliq))::numeric(15,2) as inscricao_rp_nao_processado,
                    (sum(e91_vlrliq) - sum(e91_vlrpag))::numeric(15,2) as inscricao_rp_processado,
                    (sum(e91_vlremp) - sum(e91_vlranu) - sum(e91_vlrpag))::numeric(15,2) as inscricao_total_rp,
                    (sum(e91_vlremp) - sum(e91_vlranu) - sum(e91_vlrliq) - sum(vlranuliqnaoproc))::numeric(15,2)
                        as inscricao_menos_anulacao_rp_nao_processado,
                    sum(vlranu) as total_anulacoes,
                    sum(vlranuliq) as anulacao_rp_processado,
                    sum(vlranuliqnaoproc) as anulacao_rp_nao_processado,
                    sum(vlrliq) as liquidacoes_rp,
                    sum(vlrpag) as pagamento_rp_processado,
                    sum(vlrpagnproc) as pagamento_rp_nao_processado,
                    (sum(vlrpag) + sum(vlrpagnproc))::numeric(15,2) as total_pagamentos_rp,
                    o58_orgao as orgao,
                    o58_unidade as unidade,
                    o58_funcao as funcao,
                    o58_subfuncao as subfuncao,
                    o56_elemento as elemento,
                    o58_programa as programa,
                    o58_projativ as projeto,
                    rec.o15_codigo as recurso,
                    rec.o15_recurso as fonte_recurso,
                    rec.o15_complemento as complemento
              from ($sqlRp) as y
              join orcamento.orctiporec as rec on rec.o15_codigo = y.recurso_lancamento
             group by o58_orgao,
             o58_unidade,
             o58_funcao,
             o58_subfuncao,
             o56_elemento,
             o58_programa,
             o58_projativ,
             rec.o15_codigo,
             rec.o15_recurso,
             rec.o15_complemento
        ) as xy
        ";

        return DB::select($sql);
    }

    /**
     * @return array
     */
    public function getDadosReceita()
    {
        if (empty($this->balanceteReceita)) {
            $dataInicio = $this->dataIncio->getDate();
            $dataFim = $this->dataFim->getDate();
            $this->balanceteReceita = $this->executarBalanceteReceita($this->exercicio, $dataInicio, $dataFim);
        }
        return $this->balanceteReceita;
    }

    /**
     * @return array
     */
    protected function getBalanceteReceitaExercicioAnterior()
    {
        $exercicioAnterior = $this->exercicio - 1;

        $dataInicialAnoAnterior = $this->periodo->getDataInicial($exercicioAnterior)->getDate();
        $dataFinalAnoAnterior = $this->periodo->getDataFinal($exercicioAnterior)->getDate();

        $balanceteUmAnoAntes = $this->executarBalanceteReceita(
            $exercicioAnterior,
            $dataInicialAnoAnterior,
            $dataFinalAnoAnterior
        );

        return $balanceteUmAnoAntes;
    }

    /**
     * @return array
     */
    public function getDadosDespesa()
    {
        if (empty($this->balanceteDespesa)) {
            $dataInicio = $this->dataIncio->getDate();
            $dataFim = $this->dataFim->getDate();
            $this->balanceteDespesa = $this->executarBalanceteDespesa($this->exercicio, $dataInicio, $dataFim);
        }
        return $this->balanceteDespesa;
    }

    /**
     * @return array
     */
    protected function getBalanceteDespesaExercicioAnterior()
    {
        $exercicioAnterior = $this->exercicio - 1;

        $dataInicialAnoAnterior = $this->periodo->getDataInicial($exercicioAnterior)->getDate();
        $dataFinalAnoAnterior = $this->periodo->getDataFinal($exercicioAnterior)->getDate();
        $balanceteUmAnoAntes = $this->executarBalanceteDespesa(
            $exercicioAnterior,
            $dataInicialAnoAnterior,
            $dataFinalAnoAnterior
        );

        return $balanceteUmAnoAntes;
    }

    /**
     * @return array
     */
    public function getDadosVerificacao()
    {
        if (empty($this->balanceteVerificacao)) {
            $dataInicio = $this->dataIncio->getDate();
            $dataFim = $this->dataFim->getDate();
            $this->balanceteVerificacao = $this->executarBalanceteVerificacao($this->exercicio, $dataInicio, $dataFim);
        }
        return $this->balanceteVerificacao;
    }

    /**
     * @return array
     */
    public function getDadosRestosPagar()
    {
        if (empty($this->restosPagar)) {
            $dataInicio = "{$this->exercicio}-01-01";
            $dataFim = $this->dataFim->getDate();
            $this->restosPagar = $this->executarRestosPagar($this->exercicio, $dataInicio, $dataFim);
        }
        return $this->restosPagar;
    }

    protected function processaLinhas(&$linhas)
    {
        foreach ($linhas as $linha) {
            if (in_array($linha->ordem, $this->linhasNaoProcessar)) {
                continue;
            }

            if ((int)$linha->origem === self::ORIGEM_RECEITA) {
                $this->processaReceita($this->getDadosReceita(), $linha);
            }
            if ((int)$linha->origem === self::ORIGEM_DESPESA) {
                $this->processaDespesa($this->getDadosDespesa(), $linha);
            }
            if ((int)$linha->origem === self::ORIGEM_VERIFICACAO) {
                $this->processaBalanceteVerificacao($this->getDadosVerificacao(), $linha);
            }
            if ((int)$linha->origem === self::ORIGEM_RP) {
                $this->processaRestoPagar($this->getDadosRestosPagar(), $linha);
            }
        }

        $this->processaValoresManuais($linhas);
    }

    protected function processaReceita(array $receitas, stdClass $linha)
    {
        foreach ($receitas as $receita) {
            if (!$this->matchReceita($receita, $linha)) {
                continue;
            }

            foreach ($linha->colunas as $coluna) {
                $colunaReceita = array_search($coluna->coluna, $this->colunasReceita);
                if (empty($colunaReceita)) {
                    continue;
                }
                $coluna->valor += $receita->{$colunaReceita};
            }
        }
    }

    protected function processaDespesa(array $despesas, stdClass $linha)
    {
        foreach ($despesas as $despesa) {
            if (!$this->matchDespesa($despesa, $linha)) {
                continue;
            }

            foreach ($linha->colunas as $coluna) {
                $colunaDespena = array_search($coluna->coluna, $this->colunasDespesa);
                if (empty($colunaDespena)) {
                    continue;
                }
                $coluna->valor += $despesa->{$colunaDespena};
            }
        }
    }

    protected function processaBalanceteVerificacao($contas, stdClass $linha)
    {
        foreach ($contas as $conta) {
            if (!$this->matchBalanceteVerificacao($conta, $linha)) {
                continue;
            }

            $this->ajustaSaldosBalanceteVerificacao($conta);

            foreach ($linha->colunas as $coluna) {
                $colunaDespena = array_search($coluna->coluna, $this->colunasVerificacao);
                if (empty($colunaDespena)) {
                    continue;
                }
                $coluna->valor += $conta->{$colunaDespena};
            }
        }
    }

    /**
     * Essa fun��o negativa o valor da conta quando o sinal da conta est� invertida conforme a sua natureza.
     * @param $verificacao
     */
    protected function ajustaSaldosBalanceteVerificacao($verificacao)
    {
        $digito = substr($verificacao->estrutural, 0, 1);
        if (in_array($digito, [1, 3, 5, 7])) {
            if ($verificacao->sinal_anterior_acumulado === 'C') {
                $verificacao->saldo_anterior_acumulado *= -1;
            }
            if ($verificacao->sinal_final_acumulado === 'C') {
                $verificacao->saldo_final_acumulado *= -1;
            }
            if ($verificacao->sinal_anterior_no_periodo === 'C') {
                $verificacao->saldo_anterior_no_periodo *= -1;
            }
            if ($verificacao->sinal_final_no_periodo === 'C') {
                $verificacao->saldo_final_no_periodo *= -1;
            }
        }

        if (in_array($digito, [2, 4, 6, 8])) {
            if ($verificacao->sinal_anterior_acumulado === 'D') {
                $verificacao->saldo_anterior_acumulado *= -1;
            }
            if ($verificacao->sinal_final_acumulado === 'D') {
                $verificacao->saldo_final_acumulado *= -1;
            }
            if ($verificacao->sinal_anterior_no_periodo === 'D') {
                $verificacao->saldo_anterior_no_periodo *= -1;
            }
            if ($verificacao->sinal_final_no_periodo === 'D') {
                $verificacao->saldo_final_no_periodo *= -1;
            }
        }
    }

    /**
     *
     * @param array $restos
     * @param stdClass $linha
     */
    protected function processaRestoPagar(array $restos, stdClass $linha)
    {
        foreach ($restos as $resto) {
            if (!$this->matchResto($resto, $linha)) {
                continue;
            }

            foreach ($linha->colunas as $coluna) {
                $colunaDespena = array_search($coluna->coluna, $this->colunasRp);
                if (empty($colunaDespena)) {
                    continue;
                }
                $coluna->valor += $resto->{$colunaDespena};
            }
        }
    }

    /**
     * Valida se o item da receita deve ser contabilizado na linha
     * @param stdClass $receita item da receita (balancete da receita)
     * @param stdClass $linha linha do relat�rio
     * @return bool
     */
    protected function matchReceita($receita, stdClass $linha)
    {
        // se n�o tem configura��o, ou n�o foi informado nenhuma conta para somar, retorna false
        if (is_null($linha->configuracao) || empty($linha->configuracao->contas)) {
            return false;
        }
        if (!empty($linha->configuracao->contas) && !in_array($receita->natureza, $linha->configuracao->contas)) {
            return false;
        }
        // match no �rg�o
        if (!$this->matchVinculoOrcamento($linha->configuracao->orgao, $receita->orgao)) {
            return false;
        }
        // match na unidade
        if (!$this->matchVinculoOrcamento($linha->configuracao->unidade, $receita->unidade)) {
            return false;
        }
        // match no c�digo do recurso (id)
        if (!$this->matchVinculoOrcamento($linha->configuracao->codigoRecurso, $receita->recurso_lancamento)) {
            return false;
        }
        // match na fonte de recurso
        if (!$this->matchVinculoOrcamento($linha->configuracao->fonteRecurso, $receita->fonte_recurso)) {
            return false;
        }
        // da match no complemento
        if (!$this->matchVinculoOrcamento($linha->configuracao->complemento, $receita->complemento_lancamento)) {
            return false;
        }

        return true;
    }

    /**
     * @param $resto
     * @param stdClass $linha
     * @return bool
     */
    protected function matchResto($resto, stdClass $linha)
    {
        return $this->matchDespesa($resto, $linha);
    }

    /**
     * @param stdClass $configuracao item da configura��o da linha.
     * @param mixed $valor
     * @return bool
     */
    private function matchVinculoOrcamento($configuracao, $valor)
    {
        if (!empty($configuracao->valores)) {
            if ($configuracao->operador === 'in' && !in_array($valor, $configuracao->valores)) {
                return false;
            } elseif ($configuracao->operador === 'notin' && in_array($valor, $configuracao->valores)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Valida se o item da despesa deve ser contabilizado na linha
     * @param stdClass $despesa item da despesa (balancete da despesa)
     * @param stdClass $linha linha do relat�rio
     * @return bool
     */
    protected function matchDespesa(stdClass $despesa, stdClass $linha)
    {
        // se n�o tem configura��o, ou n�o foi informado nenhuma conta para somar, retorna false
        if (is_null($linha->configuracao) || empty($linha->configuracao->contas)) {
            return false;
        }
        if (!empty($linha->configuracao->contas) && !in_array($despesa->elemento, $linha->configuracao->contas)) {
            return false;
        }
        // match no �rg�o
        if (!$this->matchVinculoOrcamento($linha->configuracao->orgao, $despesa->orgao)) {
            return false;
        }

        // match na unidade
        if (!$this->matchVinculoOrcamento($linha->configuracao->unidade, $despesa->unidade)) {
            return false;
        }

        // match na fun��o
        if (!$this->matchVinculoOrcamento($linha->configuracao->funcao, $despesa->funcao)) {
            return false;
        }
        // match na subfun��o
        if (!$this->matchVinculoOrcamento($linha->configuracao->subfuncao, $despesa->subfuncao)) {
            return false;
        }
        // match no programa
        if (!$this->matchVinculoOrcamento($linha->configuracao->programa, $despesa->programa)) {
            return false;
        }

        // match no projeto
        if (!$this->matchVinculoOrcamento($linha->configuracao->projativ, $despesa->projeto)) {
            return false;
        }
        // match no c�digo do recurso (id)
        if (!$this->matchVinculoOrcamento($linha->configuracao->codigoRecurso, $despesa->recurso)) {
            return false;
        }
        // match na fonte de recurso
        if (!$this->matchVinculoOrcamento($linha->configuracao->fonteRecurso, $despesa->fonte_recurso)) {
            return false;
        }
        // da match no complemento
        if (!$this->matchVinculoOrcamento($linha->configuracao->complemento, $despesa->complemento)) {
            return false;
        }

        return true;
    }

    /**
     *
     * @param stdClass $conta do balancete de verifica��o
     * @param stdClass $linha configura��o da linha
     * @return bool
     */
    protected function matchBalanceteVerificacao(stdClass $conta, stdClass $linha)
    {
        // se n�o tem configura��o, ou n�o foi informado nenhuma conta para somar, retorna false
        if (is_null($linha->configuracao) || empty($linha->configuracao->contas)) {
            return false;
        }
        if (!empty($linha->configuracao->contas) && !in_array($conta->estrutural, $linha->configuracao->contas)) {
            return false;
        }
        // match no c�digo do recurso (id)
        if (!$this->matchVinculoOrcamento($linha->configuracao->codigoRecurso, $conta->recurso)) {
            return false;
        }
        // match na fonte de recurso
        if (!$this->matchVinculoOrcamento($linha->configuracao->fonteRecurso, $conta->fonte_recurso)) {
            return false;
        }

        return true;
    }

    protected function processaValoresManuais(&$linhas)
    {
        foreach ($linhas as $linha) {
            foreach ($linha->colunas as $coluna) {
                $coluna->valor += $coluna->valoManual;
            }
        }
    }

    protected function processaEnteFederativo()
    {
        $this->enteFederativo = DemonstrativoFiscal::getEnteFederativo($this->emissor);
        if ($this->emissor->getTipo() != self::TIPO_PREFEITURA) {
            $this->enteFederativo .= "\n" . $this->emissor->getDescricao();
        }
    }

    /**
     * Antes de mandar as linhas para o xml, deve-se mapear as colunas de valores no mesmo objeto da linha.
     */
    protected function criaProriedadesValor()
    {
        foreach ($this->linhas as $linha) {
            foreach ($linha->colunas as $coluna) {
                $linha->{$coluna->coluna} = $coluna->valor;
            }
        }
    }

    /**
     * Retorna a fonte e nota explicatica do periodo
     *
     * @return string
     * @throws Exception
     * @todo refatorar isso
     *
     * metodo copiado e colado  da classe RelatoriosLegaisBase
     *
     *
     */
    public function getNotaExplicativa()
    {
        $texto = '';
        $sSqlNotaPadrao = "select o42_notapadrao ";
        $sSqlNotaPadrao .= "  from orcparamrel ";
        $sSqlNotaPadrao .= " where o42_codparrel = {$this->idRelatorio}";

        $rsNotaPadrao = db_query($sSqlNotaPadrao);
        $oNotaPadrao = db_utils::fieldsMemory($rsNotaPadrao, 0);
        $iDepartamento = db_getsession("DB_coddepto");
        $oDepartamento = new DBDepartamento($iDepartamento);
        /*
         * nas notas explicativas, fonte, sera possivel colocar variaveis de se��o se necessario
         * inicial teremos 3
         * [nome_departamento]
         * [data_emissao]
         * [hora_emissao]
        */
        $sDepartamento = $oDepartamento->getNomeDepartamento();
        $dtEmissao = date("d/m/Y", db_getsession("DB_datausu"));
        $hEmissao = date("H:i:s");
        $aParseVariaveis = array('[nome_departamento]' => $sDepartamento,
            '[data_emissao]' => $dtEmissao,
            '[hora_emissao]' => $hEmissao
        );

        if (isset($oNotaPadrao->o42_notapadrao) && trim($oNotaPadrao->o42_notapadrao) != "") {
            $sNotaPadrao = $oNotaPadrao->o42_notapadrao;
            foreach ($aParseVariaveis as $sIndiceValores => $oParseVariaveis) {
                if (str_replace($sIndiceValores, $oParseVariaveis, $sNotaPadrao)) {
                    $sNotaPadrao = str_replace($sIndiceValores, $oParseVariaveis, $sNotaPadrao);
                }
            }
            $texto .= $sNotaPadrao;
        }

        $sSqlNota = "select orcparamrelnota.*";
        $sSqlNota .= "  from orcparamrelnota  ";
        $sSqlNota .= "       inner join  orcparamrelnotaperiodo on o42_sequencial = o118_orcparamrelnota";
        $sSqlNota .= " where o42_codparrel = {$this->idRelatorio}";
        $sSqlNota .= "   and o42_anousu = " . db_getsession("DB_anousu");
        $sSqlNota .= "   and o42_instit = " . db_getsession("DB_instit");
        $sSqlNota .= "   and o118_periodo = {$this->periodo->getCodigo()}";
        $rsNota = db_query($sSqlNota);
        $oNotas = db_utils::fieldsMemory($rsNota, 0);
        /**
         * Seta os tamanhos das fontes setada na tabela orcparamrelnota se ela for maior que zero,
         * Para as Notas Explicativas
         */
        if (isset($oNotas->o42_fonte) && trim($oNotas->o42_fonte) != "") {
            $sFonte = "Fonte: " . $oNotas->o42_fonte;

            /*
             * aqui criamos o array com as variaveis que estarao disponiveis
             * percorremos ele, fazendo um parse pelos valores correto
             */

            $sDepartamento = $oDepartamento->getNomeDepartamento();
            $dtEmissao = date("d/m/Y", db_getsession("DB_datausu"));
            $hEmissao = date("H:i:s");
            $aParseVariaveis = array('[nome_departamento]' => $sDepartamento,
                '[data_emissao]' => $dtEmissao,
                '[hora_emissao]' => $hEmissao
            );
            foreach ($aParseVariaveis as $sIndiceValores => $oParseVariaveis) {
                if (str_replace($sIndiceValores, $oParseVariaveis, $sFonte)) {
                    $sFonte = str_replace($sIndiceValores, $oParseVariaveis, $sFonte);
                }
            }
            $texto .= "\n$sFonte";
        }

        if (isset($oNotas->o42_nota) && trim($oNotas->o42_nota) != "") {
            $sNotaExplicativa = "Nota Explicativa: " . $oNotas->o42_nota;
            if (!empty($texto)) {
                $sNotaExplicativa = "\n{$sNotaExplicativa}";
            }
            $texto .= $sNotaExplicativa;
        }
        return $texto;
    }

    /**
     * Quando template � por session, esse metodo joga as linhas dentro de cada sess�o
     */
    protected function organizaLinhas()
    {
        foreach ($this->sections as $section => $deAte) {
            $linhasSection = range($deAte[0], $deAte[1]);
            foreach ($linhasSection as $ordemLinha) {
                $this->linhasOrganizadas[$section][] = $this->linhas[$ordemLinha];
            }
        }
    }

    /**
     * @return bool
     */
    protected function isSextoBimestre()
    {
        return (int)$this->periodo->getCodigo() === Periodo::SEXTO_BIMESTRE;
    }

    /**
     * Aplica a soma das linhas...
     */
    protected function calcularSoma()
    {
        foreach ($this->totalizarSoma as $linha => $somar) {
            $this->somarLinha($linha, $somar);
        }
    }

    /**
     * Realiza a soma dos valores presente nas linhas
     *
     * @param integer $ordemLinha Ordem da linha a ser somada
     * @param array $somar Ordens das linhas que tem que somar
     */
    protected function somarLinha($ordemLinha, array $somar)
    {
        $linhaTotalizar = $this->linhas[$ordemLinha];
        $colunas = $linhaTotalizar->colunas;

        foreach ($somar as $idLinhaSoma) {
            $linhaSomar = $this->linhas[$idLinhaSoma];

            foreach ($colunas as $dadoColuna) {
                $linhaTotalizar->{$dadoColuna->coluna} += $linhaSomar->{$dadoColuna->coluna};
            }
        }
    }

    /**
     * Aplica a subtra��o das linhas
     */
    protected function calcularSubtracao()
    {
        foreach ($this->totalizarSubtracao as $linha => $subtrair) {
            $this->subtraiLinha($linha, $subtrair);
        }
    }

    /**
     * @param $ordemLinha Ordem da linha a ser subitra�da
     * @param array $subtrair Ordens das linhas que tem que subtrair
     */
    protected function subtraiLinha($ordemLinha, array $subtrair)
    {
        $linhaTotalizar = $this->linhas[$ordemLinha];
        $colunas = $linhaTotalizar->colunas;
        $ordem = array_shift($subtrair); // extrai a ordem da primeira coluna a ser subtra�da
        foreach ($colunas as $dadoColuna) {
            // define o valor inicial da coluna para ap�s aplicar a subtra��o das demais
            $linhaTotalizar->{$dadoColuna->coluna} = $this->linhas[$ordem]->{$dadoColuna->coluna};
            foreach ($subtrair as $ordemSubtrai) {
                $linhaTotalizar->{$dadoColuna->coluna} -= $this->linhas[$ordemSubtrai]->{$dadoColuna->coluna};
            }
        }
    }
}
