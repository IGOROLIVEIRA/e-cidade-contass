<?php

namespace repositories\caixa\relatorios;

use repositories\caixa\relatorios\ReceitaFormaArrecadacaoRepositoryLegacy;
use repositories\caixa\relatorios\ReceitaPeriodoTesourariaRepositoryLegacy;
use interfaces\caixa\relatorios\IReceitaPeriodoTesourariaRepository;

require_once 'repositories/caixa/relatorios/ReceitaFormaArrecadacaoRepositoryLegacy.php';
require_once 'repositories/caixa/relatorios/ReceitaPeriodoTesourariaRepositoryLegacy.php';
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
    private $sql;
    private $sqlWhereUnion;

    public function __construct(
        $sTipo,
        $iFormaArrecadacao,
        $sOrdem,
        $dDataInicial,
        $dDataFinal,
        $iEmendaParlamentar,
        $iRegularizacaoRepasse,
        $sReceitas = NULL,
        $sEstrutura = NULL,
        $sConta = NULL,
        $sContribuintes = NULL
    ) {
        $this->sTipo = $sTipo;
        $this->iFormaArrecadacao = $iFormaArrecadacao;
        $this->sOrdem = $sOrdem;
        $this->dDataInicial = $dDataInicial;
        $this->dDataFinal = $dDataFinal;
        $this->iEmendaParlamentar  = $iEmendaParlamentar;
        $this->iRegularizacaoRepasse = $iRegularizacaoRepasse;
        $this->sEstrutura = $sEstrutura;
        $this->sConta = $sConta;
        $this->sReceitas = $sReceitas;
        $this->sContribuintes = $sContribuintes;
    }

    public function pegarDados()
    {
        $this->definirSQL();
        return $this->sql;
    }

    public function definirSQL()
    {
        $this->definirSQLWhereExterno();
        $this->definirSQLWhereReceita();
        $this->definirSQLWhereContribuinte();
        $this->definirSQLWhereEmenda();
        $this->definirSQLWhereRepasse();
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
                c2.c61_reduz,
  				CASE 
                    WHEN o.k02_codrec IS NOT NULL
                    THEN o.k02_codrec 
                    ELSE p.k02_reduz 
                END AS codrec,
				CASE 
                    WHEN p.k02_codigo IS NULL
                    THEN o.k02_estorc 
                    ELSE p.k02_estpla 
                END AS estrutural,
				ROUND(
                    SUM( 
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
			INNER JOIN tabrec g ON g.k02_codigo = f.k12_receit
				left outer join taborc o on o.k02_codigo = g.k02_codigo
                AND o.k02_anousu = extract (year from r.k12_data)
				left outer join tabplan p on p.k02_codigo = g.k02_codigo
                AND p.k02_anousu = extract (year from r.k12_data)
										 left outer join conplanoreduz c2 on r.k12_conta  	= c2.c61_reduz 
										 AND	c2.c61_anousu	= extract (year from r.k12_data)							 
				left join corplacaixa on r.k12_id 	   		= k82_id
                AND r.k12_data   	= k82_data
                AND r.k12_autent  	= k82_autent
     			left join placaixarec on k82_seqpla 		= k81_seqpla
                  left outer join orcreceita on o70_codrec = o.k02_codrec and 
                  o70_anousu = o.k02_anousu 
                  left outer join conplanoreduz c1 on c1.c61_codcon = o70_codfon   and 
                  c1.c61_anousu = o70_anousu 
                  left outer join conplanoreduz c2 on c2.c61_anousu = p.k02_anousu and 
                  c2.c61_reduz  = p.k02_reduz 
			    where {$this->sWhere} and f.k12_data between '{$this->dDataInicial}' and '{$this->dDataFinal}' and r.k12_instit = " . db_getsession("DB_instit") . "
			    group by g.k02_tipo, g.k02_codigo, g.k02_drecei, codrec, estrutural,c2.c61_reduz ";
    }

    public function defnirSQLFormaArrecadacaoTodas()
    {
        $sqlCorNumDesconto = str_replace("cornump ", "cornumpdesconto ", $this->sqlInterno);
        $this->sql = " 
            SELECT k02_codigo, k02_tipo, k02_drecei, codrec, estrutural, valor FROM ( 
                {$this->sqlInterno}
                UNION ALL 
                {$sqlCorNumDesconto}
            ) as xxx {$this->sqlWhereUnion} {$this->sqlOrder} ";
    }

    public function defnirSQLFormaArrecadacaoArquivoBancario()
    {
        $this->sql  = " SELECT k02_codigo, k02_tipo, k02_drecei, codrec, estrutural, (valor) as vlrarquivobanco, ";
        $this->sql .= " round((select coalesce (sum(vlrpago), 0) ";
        $this->sql .= " from ( ";
        $this->sql .= " select distinct rc.vlrrec as vlrpago, db.idret, (select sum(vlrpago)  ";
        $this->sql .= " from disbanco  ";
        $this->sql .= " where idret = db.idret and codret = db.codret)  ";
        $this->sql .= " from disbanco db ";
        $this->sql .= " inner join discla dc on dc.codret = db.codret  ";
        $this->sql .= " inner join disrec rc on rc.codcla = dc.codcla  ";
        $this->sql .= " and db.idret = rc.idret  ";
        $this->sql .= " and rc.k00_receit =  k02_codigo ";
        $this->sql .= " where dc.dtaute between '{$this->dDataInicial}' and '{$this->dDataFinal}') as x ),2) as valor ";
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
        $this->sql .= " where idret = db.idret and codret = db.codret)  ";
        $this->sql .= " from disbanco db ";
        $this->sql .= " inner join discla dc on dc.codret = db.codret  ";
        $this->sql .= " inner join disrec rc on rc.codcla = dc.codcla  ";
        $this->sql .= " and db.idret = rc.idret  ";
        $this->sql .= " and rc.k00_receit =  k02_codigo ";
        $this->sql .= " where dc.dtaute between '{$this->dDataInicial}' and '{$this->dDataFinal}') as x ), 2) as vlrarquivobanco ";
        $this->sql .= " from ( ";
        $this->sql .= " ) as xxx {$this->sqlWhereUnion} {$this->sqlOrder} ) as x ";
        return;
    }

    /**
     * @return string
     */
    public function pegarFormatoPagina()
    {
        return "L";
    }
}
