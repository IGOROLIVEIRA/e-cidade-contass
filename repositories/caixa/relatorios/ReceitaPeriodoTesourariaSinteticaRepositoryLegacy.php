<?php

namespace repositories\caixa\relatorios;

use repositories\caixa\relatorios\ReceitaFormaArrecadacaoRepositoryLegacy;
use repositories\caixa\relatorios\ReceitaPeriodoTesourariaRepositoryLegacy;
use interfaces\caixa\relatorios\IReceitaPeriodoTesourariaRepository;

require_once 'repositories/caixa/relatorios/ReceitaFormaArrecadacaoRepositoryLegacy.php';
require_once 'repositories/caixa/relatorios/ReceitaPeriodoTesourariaRepositoryLegacy.php';
require_once 'interfaces/caixa/relatorios/IReceitaPeriodoTesourariaRepository.php';

class ReceitaPeriodoTesourariaSinteticaRepositoryLegacy extends ReceitaPeriodoTesourariaRepositoryLegacy implements IReceitaPeriodoTesourariaRepository
{
    private $sTipo;
    private $iFormaArrecadacao;
    private $sOrdem;
    private $dDataInicial;
    private $dDataFinal;
    private $iEmendaParlamentar;
    private $iRegularizacaoRepasse;
    private $sEstrutura;
    private $sConta;
    private $sContribuintes;
    private $sSql;
    private $sWhere;
    private $sWhereExterna;
    private $sInnerJoin;

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
        $sContribuintes = NULL)
    {
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
        $this->definirSQLDesconto();
        $this->definirSQLInnerJoin();
        $this->definirSQLWhereExterno();
        $this->definirSQLWhere();
        $this->definirSQLCampos();
        return array();
    }

    public function definirSQLWhere()
    {
        $this->definirSQLWhereReceita();
        $this->definirSQLWhereContribuinte();
        $this->definirSQLWhereEmenda();
        $this->definirSQLWhereRepasse();
    }

    public function definirSQLCampos()
    {
        if ($this->sTipo == "S1") {
            $this->definirSQLCamposReceitaSintetica();
            return;
        }
    }

    public function definirSQLCamposReceitaSintetica()
    {
        if ($this->iFormaArrecadacao == ReceitaFormaArrecadacaoRepositoryLegacy::TODAS) {
            $this->sSql = " SELECT k02_codigo, k02_tipo, k02_drecei, codrec, estrutural, valor FROM ( ";
            $this->definirSQLInternoReceitaSintetica();
            $this->sSql .= " ) as xxx {$this->sWhereExterna} {$this->sOrder} ";
            return;
        }

        if ($this->iFormaArrecadacao == ReceitaFormaArrecadacaoRepositoryLegacy::ARQUIVO_BANCARIO) {
            $this->sSql  = " SELECT k02_codigo, k02_tipo, k02_drecei, codrec, estrutural, (valor) as vlrarquivobanco, ";
            $this->sSql .= " round((select coalesce (sum(vlrpago),0) ";
            $this->sSql .= " from ( ";
            $this->sSql .= " select distinct rc.vlrrec as vlrpago, db.idret, (select sum(vlrpago)  ";
            $this->sSql .= " from disbanco  ";
            $this->sSql .= " where idret = db.idret and codret = db.codret)  ";
            $this->sSql .= " from disbanco db ";
            $this->sSql .= " inner join discla dc on dc.codret 	  = db.codret  ";
            $this->sSql .= " inner join disrec rc on rc.codcla 	  = dc.codcla  ";
            $this->sSql .= " and db.idret 	  = rc.idret  ";
            $this->sSql .= " and rc.k00_receit =  k02_codigo ";
            $this->sSql .= " where dc.dtaute between '{$this->dDataInicial}' and '{$this->dDataFinal}') as x ),2) as valor ";
            $this->sSql .= " from ( ";
            $this->sSql .= " ) as xxx {$this->sWhereExterna} {$this->sOrder} ";
            return;
        }

        if ($this->iFormaArrecadacao == ReceitaFormaArrecadacaoRepositoryLegacy::EXCETO_ARQUIVO_BANCARIO) {
            $this->sSql  = " SELECT k02_codigo, k02_tipo, k02_drecei, codrec, estrutural, (valor - vlrarquivobanco) as valor ";
            $this->sSql .= " FROM ( ";
            $this->sSql .= " select k02_codigo,k02_tipo,k02_drecei,codrec,estrutural,valor, ";
            $this->sSql .= " round((select coalesce(sum(vlrpago),0) from ( ";
            $this->sSql .= " select distinct rc.vlrrec as vlrpago, db.idret, (select sum(vlrpago)  ";
            $this->sSql .= " from disbanco  ";
            $this->sSql .= " where idret = db.idret and codret = db.codret)  ";
            $this->sSql .= " from disbanco db ";
            $this->sSql .= " inner join discla dc on dc.codret 	  = db.codret  ";
            $this->sSql .= " inner join disrec rc on rc.codcla 	  = dc.codcla  ";
            $this->sSql .= " and db.idret 	  = rc.idret  ";
            $this->sSql .= " and rc.k00_receit =  k02_codigo ";
            $this->sSql .= " where dc.dtaute between '{$this->dDataInicial}' and '{$this->dDataFinal}') as x ),2) as vlrarquivobanco ";
            $this->sSql .= " from ( ";
            $this->sSql .= " ) as xxx {$this->sWhereExterna} {$this->sOrder} ) as x ";
            return;
        }
    }

    public function definirSQLDesconto()
    {
        $this->sSubQueryDesconto  = " - COALESCE (( SELECT CASE ";
        $this->sSubQueryDesconto .= " WHEN r.k12_estorn is true ";
        $this->sSubQueryDesconto .= "  then sum(d.k12_valor) ";
        $this->sSubQueryDesconto .= "  else sum(d.k12_valor) ";
        $this->sSubQueryDesconto .= " end ";
        $this->sSubQueryDesconto .= " from cornumpdesconto d ";
        $this->sSubQueryDesconto .= " where d.k12_id               = f.k12_id ";
        $this->sSubQueryDesconto .= "  and d.k12_data             = f.k12_data ";
        $this->sSubQueryDesconto .= "  and d.k12_autent           = f.k12_autent ";
        $this->sSubQueryDesconto .= "  and d.k12_numpre           = f.k12_numpre ";
        $this->sSubQueryDesconto .= "  and d.k12_numpar           = f.k12_numpar ";
        $this->sSubQueryDesconto .= "  and d.k12_receitaprincipal = f.k12_receit ";
        $this->sSubQueryDesconto .= "  and d.k12_numnov           = f.k12_numnov ),0 ) ";
    }

    public function definirSQLInnerJoin()
    {
        $this->sInnerJoin  = " left outer join orcreceita on o70_codrec = o.k02_codrec and ";
        $this->sInnerJoin .= " o70_anousu = o.k02_anousu ";
        $this->sInnerJoin .= " left outer join conplanoreduz c1 on c1.c61_codcon = o70_codfon   and ";
        $this->sInnerJoin .= " c1.c61_anousu = o70_anousu ";
        $this->sInnerJoin .= " left outer join conplanoreduz c2 on c2.c61_anousu = p.k02_anousu and ";
        $this->sInnerJoin .= " c2.c61_reduz  = p.k02_reduz ";
    }

    public function definirSQLInternoReceitaSintetica()
    {
        $this->sSqlInterno = "select g.k02_codigo, g.k02_tipo, g.k02_drecei,c2.c61_reduz,
  				case when o.k02_codrec is not null 	then o.k02_codrec else p.k02_reduz end as codrec,
				case when p.k02_codigo is null 	then o.k02_estorc else p.k02_estpla end as estrutural,
				round(sum( f.k12_valor #subquery_desconto#) ,2) as valor
				from cornump f
				inner join corrente r on r.k12_id     		= f.k12_id
									 and r.k12_data   		= f.k12_data
									 and r.k12_autent 		= f.k12_autent
				inner join tabrec g on g.k02_codigo 		= f.k12_receit
				left outer join taborc o on o.k02_codigo	= g.k02_codigo
										and o.k02_anousu	= extract (year from r.k12_data)
				left outer join tabplan p on p.k02_codigo	= g.k02_codigo
										 and p.k02_anousu 	= extract (year from r.k12_data)
										 left outer join conplanoreduz c2 on r.k12_conta  	= c2.c61_reduz 
										 and	c2.c61_anousu	= extract (year from r.k12_data)							 
				left join corplacaixa on r.k12_id 	   		= k82_id
										 and r.k12_data   	= k82_data
										 and r.k12_autent  	= k82_autent
     			left join placaixarec on k82_seqpla 		= k81_seqpla
                {$this->sInnerJoin}
			    where {$this->sWhere} and f.k12_data between '{$this->dDataInicial}' and '{$this->dDataFinal}' and r.k12_instit = " . db_getsession("DB_instit") . "
			    group by g.k02_tipo, g.k02_codigo, g.k02_drecei, codrec, estrutural,c2.c61_reduz ";

        $this->sSql .= str_replace("#subquery_desconto#", $this->sSubQueryDesconto, $this->sSqlInterno) .
            " union all " .
            str_replace("#subquery_desconto#", "", str_replace("cornump ", "cornumpdesconto ", $this->sSqlInterno));
    }

    public function definirSQLWhereExterno()
    {
        $this->sWhereExterno = " valor <> 0 ";
        if ($this->sConta)
            $this->sWhereExterno .= " AND c61_reduz IN ({$this->sConta}) ";
        if ($this->sEstrutura)
            $this->sWhereExterno .= " AND estrutural LIKE '$this->sEstrutura%' ";
    }

    public function pegarTipoConstrutor()
    {
        return "L";
    }
}
