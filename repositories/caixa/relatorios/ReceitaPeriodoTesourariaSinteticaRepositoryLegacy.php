<?php

namespace repositories\caixa\relatorios;

use repositories\caixa\relatorios\ReceitaFormaArrecadacaoRepositoryLegacy;
use repositories\caixa\relatorios\ReceitaPeriodoTesourariaRepositoryLegacy;
use repositories\caixa\relatorios\ReceitaTipoSelecaoRepositoryLegacy;
use interfaces\caixa\relatorios\IReceitaPeriodoTesourariaRepository;
use Exception;

require_once 'repositories/caixa/relatorios/ReceitaFormaArrecadacaoRepositoryLegacy.php';
require_once 'repositories/caixa/relatorios/ReceitaPeriodoTesourariaRepositoryLegacy.php';
require_once 'repositories/caixa/relatorios/ReceitaTipoSelecaoRepositoryLegacy.php';
require_once 'interfaces/caixa/relatorios/IReceitaPeriodoTesourariaRepository.php';

class ReceitaPeriodoTesourariaSinteticaRepositoryLegacy
extends ReceitaPeriodoTesourariaRepositoryLegacy
implements IReceitaPeriodoTesourariaRepository
{
    private $iFormaArrecadacao;
    private $dDataInicial;
    private $dDataFinal;
    private $sEstrutura;
    private $sConta;
    private $iInstituicao;
    private $sql;
    private $sqlSelect;
    private $sqlWhere;
    private $sqlOrder;
    private $sqlWhereUnion;
    private $sqlGroup;

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
        $sContribuintes = NULL
    ) {
        $this->sTipo = $sTipo;
        $this->sTipoReceita = $sTipoReceita;
        $this->iFormaArrecadacao = $iFormaArrecadacao;
        $this->sOrdem = $sOrdem;
        $this->dDataInicial = $dDataInicial;
        $this->dDataFinal = $dDataFinal;
        $this->iEmendaParlamentar  = $iEmendaParlamentar;
        $this->iRegularizacaoRepasse = $iRegularizacaoRepasse;
        $this->iInstituicao = $iInstituicao;
        $this->sReceitas = $sReceitas;
        $this->sEstrutura = $sEstrutura;
        $this->sContas = $sContas;
        $this->sContribuintes = $sContribuintes;
        $this->definirSQL();
    }

    public function pegarDados()
    {
        $aDados = array();
        if (!$result = pg_query($this->sql))
            throw new Exception("Erro realizando consulta");
        while ($data = pg_fetch_object($result)) {
            $aDados[$data->tipo][] = $data;
        }
        return $aDados;
    }

    public function definirSQL()
    {
        $this->definirSQLWhereExterno();
        $this->definirSQLSelectEGroup();
        $this->sqlWhere .= $this->definirSQLWhereTipo();
        $this->sqlWhere .= $this->definirSQLWhereReceita();
        $this->sqlWhere .= $this->definirSQLWhereContribuinte();
        $this->sqlWhere .= $this->definirSQLWhereEmenda();
        $this->sqlWhere .= $this->definirSQLWhereRepasse();
        $this->sqlOrder .= $this->definirSQLOrderBy();
        $this->definirSQLInterno();

        if ($this->iFormaArrecadacao == ReceitaFormaArrecadacaoRepositoryLegacy::TODAS) {
            $this->defnirSQLFormaArrecadacaoTodas();
            return;
        }

        if ($this->iFormaArrecadacao == ReceitaFormaArrecadacaoRepositoryLegacy::ARQUIVO_BANCARIO) {
            $this->defnirSQLFormaArrecadacaoArquivoBancario();
            return;
        }

        if ($this->iFormaArrecadacao == ReceitaFormaArrecadacaoRepositoryLegacy::EXCETO_ARQUIVO_BANCARIO) {
            $this->defnirSQLFormaArrecadacaoExcetoArquivoBancario();
            return;
        }
    }

    /**
     * @return void
     */
    public function definirSQLWhereExterno()
    {
        $this->sqlWhereUnion = " valor <> 0 ";

        if ($this->sConta)
            $this->sqlWhereUnion .= " AND c61_reduz IN ({$this->sConta}) ";

        if ($this->sEstrutura)
            $this->sqlWhereUnion .= " AND estrutural LIKE '$this->sEstrutura%' ";
    }

    public function definirSQLInterno()
    {
        $this->sqlInterno = "
            SELECT 
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
			WHERE 
                1 = 1 
                {$this->sqlWhere} 
                AND f.k12_data BETWEEN '{$this->dDataInicial}' AND '{$this->dDataFinal}' 
                AND r.k12_instit = {$this->iInstituicao} ";
    }

    public function defnirSQLFormaArrecadacaoTodas()
    {
        $sqlCorNumDesconto = str_replace("cornump ", "cornumpdesconto ", $this->sqlInterno);
        $this->sql = " 
            {$this->sqlSelect}
            FROM ( 
                {$this->sqlInterno}
                UNION ALL 
                {$sqlCorNumDesconto}
            ) as xxx 
            WHERE
                {$this->sqlWhereUnion} 
            {$this->sqlGroup}
            {$this->sqlOrder} ";
    }

    public function definirSQLSelectEGroup()
    {
        if ($this->sTipo == ReceitaTipoSelecaoRepositoryLegacy::RECEITA) {
            $this->definirSQLSelectReceita();
            $this->definirSQLGroupReceita();
            return;
        }

        if ($this->sTipo == ReceitaTipoSelecaoRepositoryLegacy::ESTRUTURAL) {
            $this->definirSQLSelectEstrutural();
            $this->definirSQLGroupReceita();
            return;
        }
    }

    public function definirSQLSelectReceita()
    {
        $this->sqlSelect = "SELECT 
                k02_codigo codigo, 
                k02_tipo tipo, 
                k02_drecei descricao, 
                codrec reduzido, 
                estrutural, 
                SUM(valor) as valor ";
    }

    public function definirSQLSelectEstrutural()
    {
        $this->sqlSelect = "SELECT 
                k02_tipo tipo, 
                k02_drecei descricao, 
                estrutural, 
                SUM(valor) as valor ";
    }

    public function definirSQLGroupReceita()
    {
        $this->sqlGroup = "GROUP BY 
            k02_codigo, 
            k02_tipo, 
            k02_drecei, 
            codrec, 
            estrutural ";
    }

    public function defnirSQLFormaArrecadacaoArquivoBancario()
    {
        $this->sql  = " SELECT k02_codigo, k02_tipo, k02_drecei, codrec, estrutural, (valor) as vlrarquivobanco, ";
        $this->sql .= " round((select coalesce (sum(vlrpago), 0) ";
        $this->sql .= " from ( ";
        $this->sql .= " select distinct rc.vlrrec as vlrpago, db.idret, (select sum(vlrpago)  ";
        $this->sql .= " from disbanco  ";
        $this->sql .= " where idret = db.idret AND codret = db.codret)  ";
        $this->sql .= " from disbanco db ";
        $this->sql .= " INNER JOIN discla dc ON dc.codret = db.codret  ";
        $this->sql .= " INNER JOIN disrec rc ON rc.codcla = dc.codcla  ";
        $this->sql .= " AND db.idret = rc.idret  ";
        $this->sql .= " AND rc.k00_receit =  k02_codigo ";
        $this->sql .= " where dc.dtaute between '{$this->dDataInicial}' AND '{$this->dDataFinal}') as x ),2) as valor ";
        $this->sql .= " from ( ";
        $this->sql .= " ) as xxx {$this->sqlWhereUnion} {$this->sqlOrder} ";
        return;
    }

    public function defnirSQLFormaArrecadacaoExcetoArquivoBancario()
    {
        $this->sql  = " SELECT k02_codigo, k02_tipo, k02_drecei, codrec, estrutural, (valor - vlrarquivobanco) as valor ";
        $this->sql .= " FROM ( ";
        $this->sql .= " select k02_codigo,k02_tipo,k02_drecei,codrec,estrutural,valor, ";
        $this->sql .= " round((select coalesce(sum(vlrpago),0) from ( ";
        $this->sql .= " select distinct rc.vlrrec as vlrpago, db.idret, (select sum(vlrpago)  ";
        $this->sql .= " from disbanco  ";
        $this->sql .= " where idret = db.idret AND codret = db.codret)  ";
        $this->sql .= " from disbanco db ";
        $this->sql .= " INNER JOIN discla dc ON dc.codret = db.codret  ";
        $this->sql .= " INNER JOIN disrec rc ON rc.codcla = dc.codcla  ";
        $this->sql .= " AND db.idret = rc.idret  ";
        $this->sql .= " AND rc.k00_receit =  k02_codigo ";
        $this->sql .= " where dc.dtaute between '{$this->dDataInicial}' AND '{$this->dDataFinal}') as x ), 2) as vlrarquivobanco ";
        $this->sql .= " from ( ";
        $this->sql .= " ) as xxx {$this->sqlWhereUnion} {$this->sqlOrder} ) as x ";
        return;
    }

    /**
     * @return string
     */
    public function pegarFormatoPagina()
    {
        return "Portrait";
    }
}
