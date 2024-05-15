<?php

namespace repositories\caixa\relatorios\SQLBuilder;

use repositories\caixa\relatorios\ReceitaFormaArrecadacaoRepositoryLegacy;
use repositories\caixa\relatorios\ReceitaTipoRepositoryLegacy;
use repositories\caixa\relatorios\ReceitaTipoReceitaRepositoryLegacy;
use repositories\caixa\relatorios\ReceitaOrdemRepositoryLegacy;

require_once 'repositories/caixa/relatorios/ReceitaFormaArrecadacaoRepositoryLegacy.php';
require_once 'repositories/caixa/relatorios/ReceitaTipoRepositoryLegacy.php';
require_once 'repositories/caixa/relatorios/ReceitaTipoReceitaRepositoryLegacy.php';
require_once 'repositories/caixa/relatorios/ReceitaOrdemRepositoryLegacy.php';

class ReceitaPeriodoTesourariaSQLBuilder
{
    /**
     * @var string
     */
    private $sql;

    /**
     * @var string
     */
    private $sqlSelect;

    /**
     * @var string
     */
    private $sqlWhere;

    /**
     * @var string
     */
    private $sqlWhereUnion;

    /**
     * @var string
     */
    private $sqlReceitaOrcamentaria;

    /**
     * @var string
     */
    private $sTipo;

    /**
     * @var string
     */
    private $sTipoReceita;

    /**
     * @var int
     */
    private $iFormaArrecadacao;

    /**
     * @var string
     */
    private $sOrdem;

    /**
     * @var string
     */
    private $dDataInicial;

    /**
     * @var string
     */
    private $dDataFinal;

    /**
     * @var string
     */
    private $sDesdobramento;

    /**
     * @var int
     */
    private $iEmendaParlamentar;

    /**
     * @var int
     */
    private $iRegularizacaoRepasse;

    /**
     * @var int
     */
    private $iRecurso;

    /**
     * @var int
     */
    private $iInstituicao;

    /**
     * @var string
     */
    private $sReceitas;

    /**
     * @var string
     */
    private $sEstrutura;

    /**
     * @var string
     */
    private $sContas;

    /**
     * @var string
     */
    private $sContribuintes;

    public function __construct(
        $sTipo,
        $sTipoReceita,
        $iFormaArrecadacao,
        $sOrdem,
        $dDataInicial,
        $dDataFinal,
        $sDesdobramento,
        $iEmendaParlamentar,
        $iRegularizacaoRepasse,
        $iInstituicao,
        $sReceitas = NULL,
        $sEstrutura = NULL,
        $sContas = NULL,
        $sContribuintes = NULL,
        $iRecurso
    ) {
        $this->sTipo = $sTipo;
        $this->sTipoReceita = $sTipoReceita;
        $this->iFormaArrecadacao = $iFormaArrecadacao;
        $this->sOrdem = $sOrdem;
        $this->dDataInicial = $dDataInicial;
        $this->dDataFinal = $dDataFinal;
        $this->sDesdobramento = $sDesdobramento;
        $this->iEmendaParlamentar  = $iEmendaParlamentar;
        $this->iRegularizacaoRepasse = $iRegularizacaoRepasse;
        $this->iInstituicao = $iInstituicao;
        $this->sReceitas = $sReceitas;
        $this->sEstrutura = $sEstrutura;
        $this->sContas = $sContas;
        $this->sContribuintes = $sContribuintes;
        $this->iRecurso = $iRecurso;
        $this->definirSQL();
    }

    /**
     * @return void
     */
    public function definirSQL()
    {
        $this->definirSQLSelectEGroup();
        $this->definirSQLWhereExterno();
        $this->definirSQLWhere();
        $this->definirSQLReceitaOrcamentaria();
        $this->definirSQLExtraOrcamentaria();
        $this->definirSQLOrderBy();
        $this->definirSQLCompleta();
    }

    /**
     * @return void
     */
    public function definirSQLCompleta()
    {
        $sqlCorNumDesconto = str_replace("cornump ", "cornumpdesconto ", $this->sqlReceitaOrcamentaria);
        $this->sql = " 
            {$this->sqlSelect}
            FROM ( 
                {$this->sqlReceitaOrcamentaria}
                UNION ALL 
                {$sqlCorNumDesconto}
                UNION ALL
                {$this->sqlExtraOrcamentaria}
            ) as xxx 
            WHERE
                {$this->sqlWhereUnion} 
            {$this->sqlGroup}
            {$this->sqlOrder} ";
    }

    /**
     * @return void
     */
    public function definirSQLSelectEGroup()
    {
        $this->definirSQLSelectEstrutural();
        $this->definirSQLGroupEstrutural();

        if ($this->sOrdem == ReceitaOrdemRepositoryLegacy::CONTRIBUINTE) {
            $this->definirSQLSelectContribuinte();
            $this->definirSQLGroupContribuinte();
        } 

        if ($this->sOrdem == ReceitaOrdemRepositoryLegacy::OPERACAO_CREDITO) {
            $this->definirSQLSelectOperacaoCredito();
            $this->definirSQLGroupOperacaoCredito();
        } 

        if ($this->sTipo == ReceitaTipoRepositoryLegacy::RECEITA) {
            $this->definirSQLSelectReceita();
            $this->definirSQLGroupReceita();
            return;
        }

        if ($this->sTipo == ReceitaTipoRepositoryLegacy::ANALITICO || $this->sTipo == ReceitaTipoRepositoryLegacy::ANALITICO_RECEITA) {
            $this->definirSQLSelectAnalitico();
            $this->definirSQLGroupAnalitico();
            return;
        }

        if ($this->sTipo == ReceitaTipoRepositoryLegacy::CONTA) {
            $this->definirSQLSelectConta();
            $this->definirSQLGroupConta();
            return;
        }

        if ($this->sTipo == ReceitaTipoRepositoryLegacy::DIARIO) {
            $this->definirSQLSelectAnalitico();
            $this->definirSQLGroupAnalitico();
            return;
        }
    }

    /**
     * @return void
     */
    public function definirSQLSelectEstrutural()
    {
        if ($this->iFormaArrecadacao == ReceitaFormaArrecadacaoRepositoryLegacy::TODAS) {
            $this->definirSQLSelectEstruturalTodas();
            return;
        }

        $this->definirSQLSelectEstruturalOutros();
        return;
    }

    /**
     * @return void
     */
    public function definirSQLSelectEstruturalTodas()
    {
        $this->sqlSelect = "
            SELECT 
                k02_tipo tipo, 
                k02_drecei descricao, 
                estrutural, 
                SUM(valor) as valor ";
    }

    /**
     * @return void
     */
    public function definirSQLSelectEstruturalOutros()
    {
        $this->sqlSelect = " 
            SELECT 
                k02_tipo tipo, 
                k02_drecei descricao, 
                estrutural, 
                codrec reduzido, 
                k02_codigo codigo,
                arquivo,
                SUM(valor) as valor ";
    }

    /**
     * @return string
     */
    public function definirSQLValorArquivoBancario()
    {
        return "ROUND((
            SELECT COALESCE(SUM(vlrpago), 0) FROM ( 
                SELECT 
                    DISTINCT rc.vlrrec AS vlrpago,
                    db.idret, 
                    (
                        SELECT sum(vlrpago) 
                        FROM disbanco  
                        WHERE idret = db.idret 
                        AND codret = db.codret
                    ) 
                FROM disbanco db 
                INNER JOIN discla dc ON dc.codret = db.codret 
                INNER JOIN disrec rc ON rc.codcla = dc.codcla 
                    AND db.idret = rc.idret 
                    AND rc.k00_receit = k02_codigo
                WHERE dc.dtaute BETWEEN '{$this->dDataInicial}' AND '{$this->dDataFinal}') AS x ), 2) ";
    }

    /**
     * @return void
     */
    public function definirSQLSelectReceita()
    {
        $this->sqlSelect .= " , codrec reduzido, k02_codigo codigo ";
    }

    /**
     * @return void
     */
    public function definirSQLSelectAnalitico()
    {
        $this->sqlSelect .= " , codrec reduzido, k02_codigo codigo, k00_histtxt historico, k12_data as data, k12_numpre numpre, k12_numpar numpar, c61_reduz conta, c60_descr conta_descricao ";
    }

    /**
     * @return void
     */
    public function definirSQLSelectConta()
    {
        $this->sqlSelect .= " , codrec reduzido, k02_codigo codigo, c61_reduz conta, c60_descr conta_descricao  ";
    }

    /**
     * @return void
     */
    public function definirSQLSelectContribuinte()
    {
        $this->sqlSelect .= " , z01_numcgm cgm, z01_cgccpf cpfcnpj, z01_nome nome";
    }

    /**
     * @return void
     */
    public function definirSQLSelectOperacaoCredito()
    {
        $this->sqlSelect .= " , op01_sequencial operacao, op01_numerocontratoopc numcontrato, op01_dataassinaturacop dtassinatura";
    }

    /**
     * @return void
     */
    public function definirSQLGroupOperacaoCredito()
    {
        $this->sqlGroup .= " , op01_sequencial, op01_numerocontratoopc, op01_dataassinaturacop ";
    }

    /**
     * @return void
     */
    public function definirSQLGroupContribuinte()
    {
        $this->sqlGroup .= " , z01_numcgm, z01_cgccpf, z01_nome ";
    }

    /**
     * @return void
     */
    public function definirSQLGroupReceita()
    {
        $this->sqlGroup .= " , arquivo, codrec, k02_codigo ";
    }

    /**
     * @return void
     */
    public function definirCondicoesSQLGroup()
    {
        if ($this->iFormaArrecadacao != ReceitaFormaArrecadacaoRepositoryLegacy::TODAS)
            $this->sqlGroup .= " , arquivo ";
    }

    /**
     * @return void
     */
    public function definirSQLGroupAnalitico()
    {
        $this->definirCondicoesSQLGroup();
        $this->sqlGroup .= " , codrec, k02_codigo, k00_histtxt, k12_data, k12_numpre, k12_numpar, c61_reduz, c60_descr ";
    }

    /**
     * @return void
     */
    public function definirSQLGroupConta()
    {
        $this->definirCondicoesSQLGroup();
        $this->sqlGroup .= " , codrec, k02_codigo, c61_reduz, c60_descr ";
    }

    /**
     * @return void
     */
    public function definirSQLGroupEstrutural()
    {
        $this->sqlGroup .= "
            GROUP BY 
                k02_tipo,
                codrec,
                k02_codigo,
                k02_drecei,
                estrutural ";
        $this->definirCondicoesSQLGroup();
    }

    /**
     * @return void
     */
    public function definirSQLWhereExterno()
    {
        $this->sqlWhereUnion = " valor <> 0 ";

        if ($this->sContas)
            $this->sqlWhereUnion .= " AND c61_reduz IN ({$this->sContas}) ";

        if ($this->sEstrutura)
            $this->sqlWhereUnion .= " AND estrutural LIKE '$this->sEstrutura%' ";

        if ($this->iFormaArrecadacao == ReceitaFormaArrecadacaoRepositoryLegacy::RETENCAO)
            $this->sqlWhereUnion .= " AND arquivo = 2 ";

        if ($this->iFormaArrecadacao == ReceitaFormaArrecadacaoRepositoryLegacy::ARQUIVO_BANCARIO)
            $this->sqlWhereUnion .= " AND arquivo = 1 ";

        if ($this->iFormaArrecadacao == ReceitaFormaArrecadacaoRepositoryLegacy::EXCETO_ARQUIVO_BANCARIO)
            $this->sqlWhereUnion .= " AND arquivo = 0 ";
    }

    /**
     * @return void
     */
    public function definirSQLWhere()
    {
        $this->definirSQLWhereTipo();
        $this->definirSQLWhereReceita();
        $this->definirSQLWhereContribuinte();
        $this->definirSQLWhereEmenda();
        $this->definirSQLWhereRepasse();
        $this->definirSQLWhereRecurso();
    }

    /**
     * @return void
     */
    public function definirSQLWhereTipo()
    {
        if ($this->sTipoReceita != ReceitaTipoReceitaRepositoryLegacy::TODOS) {
            $this->sqlWhere .= " AND g.k02_tipo = '{$this->sTipoReceita}' ";
        }
    }

    /**
     * @return void
     */
    public function definirSQLWhereReceita()
    {
        if ($this->sReceitas) {
            $this->sqlWhere .= " AND g.k02_codigo in ({$this->sReceitas}) ";
        }
    }

    /**
     * @return void
     */
    public function definirSQLWhereContribuinte()
    {
        if ($this->sContribuintes) {
            $this->sqlWhere .= " AND z01_numcgm in ({$this->sContribuintes}) ";
        }
    }

    /**
     * @return void
     */
    public function definirSQLWhereEmenda()
    {
        if ($this->iEmendaParlamentar != 0) {
            $this->sqlWhere .= " AND k81_emparlamentar = {$this->iEmendaParlamentar} ";
        }
    }

    /**
     * @return void
     */
    public function definirSQLWhereRepasse()
    {
        if ($this->iRegularizacaoRepasse != 0) {
            if ($this->iRegularizacaoRepasse == 1) {
                $this->sqlWhere .= " and k81_regrepasse = {$this->iRegularizacaoRepasse} ";
                return; 
            }
            $this->sqlWhere .= " and (k81_regrepasse = {$this->iRegularizacaoRepasse} OR k81_regrepasse IS NULL) ";
        }
    }

    public function definirSQLWhereRecurso()
    {
        if ($this->iRecurso != 0) {
            $this->sqlWhere .= " AND c61_codigo = {$this->iRecurso} ";
        }
    }

    /**
     * @return void
     */
    public function definirSQLReceitaOrcamentaria()
    {
        $this->sqlReceitaOrcamentaria = "
            SELECT 
                CASE
                    WHEN k82_id IS NOT NULL THEN 0
                    WHEN k12_histcor LIKE '%Em contrapartida %' THEN 2
                    ELSE 1
                END as arquivo,
                g.k02_codigo,
                g.k02_tipo,
                g.k02_drecei,
                case
                    when o.k02_codrec is not null then o.k02_codrec
                    else p.k02_reduz
                end as codrec,
                case
                    when p.k02_codigo is null then o.k02_estorc
                    else p.k02_estpla
                end as estrutural,
                k12_histcor as k00_histtxt,
                f.k12_data,
                f.k12_numpre,
                f.k12_numpar,
                c61_reduz,
                c60_descr,
                k12_conta,
                z01_numcgm, 
                z01_cgccpf,
                z01_nome,
                op01_sequencial,
                op01_numerocontratoopc,
                op01_dataassinaturacop,
				ROUND(
                        ( 
                        f.k12_valor - COALESCE((
                            SELECT 
                                CASE
                                    WHEN r.k12_estorn IS TRUE
                                    THEN SUM(d.k12_valor) 
                                    ELSE SUM(d.k12_valor) 
                                END
                            FROM cornumpdesconto d 
                            WHERE d.k12_id = f.k12_id
                                AND d.k12_data = f.k12_data 
                                AND d.k12_autent = f.k12_autent 
                                AND d.k12_numpre = f.k12_numpre 
                                AND d.k12_numpar = f.k12_numpar
                                AND d.k12_receitaprincipal = f.k12_receit
                                AND d.k12_numnov = f.k12_numnov
                        ), 0) 
                ), 2) AS valor
			FROM cornump f
            INNER JOIN corrente r ON r.k12_id = f.k12_id
                AND r.k12_data = f.k12_data
                AND r.k12_autent = f.k12_autent
            INNER JOIN conplanoreduz c1 ON r.k12_conta = c1.c61_reduz
                AND c1.c61_anousu = EXTRACT(YEAR FROM r.k12_data)
            INNER JOIN conplano ON c1.c61_codcon = c60_codcon
                AND c60_anousu = EXTRACT(YEAR FROM r.k12_data)
            INNER JOIN tabrec g ON g.k02_codigo = f.k12_receit
            LEFT OUTER JOIN taborc o ON o.k02_codigo = g.k02_codigo
                AND o.k02_anousu = EXTRACT(YEAR FROM r.k12_data)
            LEFT OUTER JOIN tabplan p ON p.k02_codigo = g.k02_codigo
                AND p.k02_anousu = EXTRACT(YEAR FROM r.k12_data)
            LEFT JOIN corhist hist ON hist.k12_id = f.k12_id
                AND hist.k12_data = f.k12_data
                AND hist.k12_autent = f.k12_autent
            LEFT JOIN corplacaixa ON r.k12_id = k82_id
                AND r.k12_data = k82_data
                AND r.k12_autent = k82_autent
            LEFT JOIN placaixarec ON k82_seqpla = k81_seqpla
            LEFT JOIN cgm ON z01_numcgm = k81_numcgm
            LEFT JOIN conplanocontabancaria ON c60_codcon = c56_codcon AND c60_anousu = c56_anousu
            LEFT JOIN contabancaria ON c56_contabancaria = db83_sequencial
            LEFT JOIN db_operacaodecredito ON db83_codigoopcredito = op01_sequencial
			WHERE 
                1 = 1 
                {$this->sqlWhere} 
                AND f.k12_data BETWEEN '{$this->dDataInicial}' AND '{$this->dDataFinal}' 
                AND r.k12_instit = {$this->iInstituicao} ";
    }

    /**
     * @return void
     */
    public function definirSQLExtraOrcamentaria()
    {
        $this->sqlExtraOrcamentaria = "
            SELECT
                CASE
                    WHEN k82_id IS NOT NULL THEN 0
                    WHEN k12_histcor LIKE '%Em contrapartida %' THEN 2
                    ELSE 1
                END as arquivo,
                g.k02_codigo,
                g.k02_tipo,
                g.k02_drecei,
                CASE
                    WHEN taborc.k02_codrec IS NOT NULL 
                    THEN taborc.k02_codrec
                    ELSE tabplan.k02_reduz
                END AS codrec,
                CASE
                    WHEN tabplan.k02_codigo IS NULL 
                    THEN taborc.k02_estorc
                    ELSE tabplan.k02_estpla
                END AS estrutural,
                k12_histcor AS k00_histtxt,
                corrente.k12_data,
                0 AS k12_numpre,
                0 AS k12_numpar,
                c61_reduz,
                c60_descr,
                corrente.k12_conta,
                z01_numcgm, 
                z01_cgccpf,
                z01_nome,
                op01_sequencial,
                op01_numerocontratoopc,
                op01_dataassinaturacop,
                corrente.k12_valor AS valor
            FROM
                corlanc
            INNER JOIN corrente ON corrente.k12_id = corlanc.k12_id
                AND corrente.k12_data = corlanc.k12_data
                AND corrente.k12_autent = corlanc.k12_autent
            INNER JOIN slip ON slip.k17_codigo = corlanc.k12_codigo
            INNER JOIN conplanoreduz ON c61_reduz = slip.k17_credito
                AND c61_anousu = EXTRACT(YEAR FROM corrente.k12_data)
            INNER JOIN conplano ON c60_codcon = c61_codcon
                AND c60_anousu = c61_anousu
            INNER JOIN tabplan ON tabplan.k02_anousu = conplanoreduz.c61_anousu
                AND tabplan.k02_reduz = conplanoreduz.c61_reduz
            INNER JOIN tabrec AS g ON g.k02_codigo = tabplan.k02_codigo
            LEFT OUTER JOIN taborc ON taborc.k02_codigo = g.k02_codigo
                AND taborc.k02_anousu = EXTRACT(YEAR FROM corrente.k12_data)
            LEFT JOIN corhist ON corhist.k12_id = corrente.k12_id
                AND corhist.k12_data = corrente.k12_data
                AND corhist.k12_autent = corrente.k12_autent
            LEFT JOIN corplacaixa ON corrente.k12_id = k82_id
                AND corrente.k12_data = k82_data
                AND corrente.k12_autent = k82_autent
            LEFT JOIN placaixarec ON k82_seqpla = k81_seqpla
            LEFT JOIN cgm ON z01_numcgm = k81_numcgm 
            LEFT JOIN conplanocontabancaria ON c60_codcon = c56_codcon AND c60_anousu = c56_anousu
            LEFT JOIN contabancaria ON c56_contabancaria = db83_sequencial
            LEFT JOIN db_operacaodecredito ON db83_codigoopcredito = op01_sequencial
            WHERE 
                1 = 1 
                {$this->sqlWhere} 
                AND corlanc.k12_data BETWEEN '{$this->dDataInicial}' AND '{$this->dDataFinal}' 
                AND k12_instit = {$this->iInstituicao} ";
    }

    /**
     * @return void
     */
    public function definirSQLOrderBy()
    {
        if ($this->sTipo == ReceitaTipoRepositoryLegacy::ESTRUTURAL) {
            $this->sqlOrder = " ORDER BY k02_tipo, estrutural ";
            return;
        }

        if ($this->sOrdem == ReceitaOrdemRepositoryLegacy::CODIGO) {
            $this->sqlOrder = " ORDER BY k02_tipo, k02_codigo ";
            return;
        }

        if ($this->sOrdem == ReceitaOrdemRepositoryLegacy::ESTRUTURAL) {
            $this->sqlOrder = " ORDER BY k02_tipo, estrutural ";
            return;
        }

        if ($this->sOrdem == ReceitaOrdemRepositoryLegacy::ALFABETICA) {
            $this->sqlOrder = " ORDER BY k02_tipo, k02_drecei ";
            return;
        }

        if ($this->sOrdem == ReceitaOrdemRepositoryLegacy::REDUZIDO_ORCAMENTO) {
            $this->sqlOrder = " ORDER BY k02_tipo, codrec ";
            return;
        }

        if ($this->sOrdem == ReceitaOrdemRepositoryLegacy::REDUZIDO_CONTA) {
            if ($this->sTipo == ReceitaTipoRepositoryLegacy::RECEITA) {
                $this->sqlOrder = " ORDER BY k02_tipo, codrec ";
                return;
            }
            $this->sqlOrder = " ORDER BY k02_tipo, c61_reduz ";
            return;
        }

        if ($this->sOrdem == ReceitaOrdemRepositoryLegacy::CONTRIBUINTE) {
            $this->sqlOrder = " ORDER BY k02_tipo, z01_numcgm, z01_cgccpf ";
            return;
        }

        if ($this->sOrdem == ReceitaOrdemRepositoryLegacy::OPERACAO_CREDITO) {
            $this->sqlOrder = " ORDER BY k02_tipo, op01_sequencial ";
            return;
        }
    }

    /**
     * @return string
     */
    public function pegarSQL()
    {
        return $this->sql;
    }
}
