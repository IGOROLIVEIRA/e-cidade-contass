<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBselller Servicos de Informatica
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

require_once ("fpdf151/pdf.php");
require_once ("libs/db_liborcamento.php");
require_once ("libs/db_sql.php");
require_once("classes/db_orctiporec_classe.php");
require_once("model/orcamento/ReceitaContabilRepository.model.php");
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/
use model\caixa\relatorios\ReceitaPeriodoTesourariaPDF;
use repositories\caixa\relatorios\ReceitaPeriodoTesourariaRepositoryLegacy;

require_once "model/caixa/relatorios/ReceitaPeriodoTesourariaPDF.model.php";
require_once "repositories/caixa/relatorios/ReceitaPeriodoTesourariaRepositoryLegacy.php";

$sDesdobramento = $desdobrar;
$sTipo = $sinana;
$sTipoReceita = $tipo;
$iFormaArrecadacao = $formarrecadacao;
$sOrdem = $ordem;
$dDataInicial = $datai;
$dDataFinal = $dataf;
$iEmendaParlamentar = $emparlamentar;
$iRegularizacaoRepasse = 0;
$iInstituicao = db_getsession("DB_instit");
$sReceitas = $codrec;
$sEstrutura = $estrut;
$sContas = $conta;
$sContribuintes = $contribuinte;

$oReceitaPeriodoTesourariaRepository = new ReceitaPeriodoTesourariaRepositoryLegacy(
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
    $sReceitas,
    $sEstrutura,
    $sContas,
    $sContribuintes
);

$oRelatorioReceitaPeriodoTesouraria = new ReceitaPeriodoTesourariaPDF(
    $sTipo,
    $sTipoReceita,
    $iFormaArrecadacao,
    $dDataInicial,
    $dDataFinal,
    $oReceitaPeriodoTesourariaRepository);

$oRelatorioReceitaPeriodoTesouraria->processar();

/**
 * Primeiro passo de refactory
 * Mapeamento das variaveis
 * = "Data Inicial"
 * = "Data Final"
 * = "Estrutural da Receita"
 * $tipo = "Tipo de Receita"
 * $sinana = "Tipo"
 * = "Referente a Emenda Parlamentar"
 * = "Regularizacao de Repasse"
 * $formarrecadacao = "Forma de Arrecadacao"
 * = "Recurso"
 */

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
//var_dump($HTTP_SERVER_VARS['QUERY_STRING']);
// quando for emissao sintetica coloca modelo retrato
if ($sinana == 'S1' || $sinana == 'S2') {
  $pdf = new PDF();
}else {
 	$pdf = new PDF('L');
}
$pdf->Open();
$pdf->AliasNbPages();

/** Implementar */
if ($recurso != ""){
     $clorctiporec = new cl_orctiporec;

     $res_tiporec  = $clorctiporec->sql_record($clorctiporec->sql_query_file($recurso,"o15_descr"));
     if ($clorctiporec->numrows > 0){
          db_fieldsmemory($res_tiporec,0);
	  $head5 = "Recurso: ".$o15_descr;
     }

     $inner_sql = " left outer join orcreceita       on o70_codrec = o.k02_codrec and
		                                        o70_anousu = o.k02_anousu
		    left outer join conplanoreduz c1 on c1.c61_codcon = o70_codfon   and
		                                        c1.c61_anousu = o70_anousu
                    left outer join conplanoreduz c2 on c2.c61_anousu = p.k02_anousu and
                                                        c2.c61_reduz  = p.k02_reduz";

     $where    .= " and c1.c61_codigo = ".$recurso;
}


if ($sinana == 'S4') {
	/**
	 *  analitico
	 *  baixas de banco n�o tem numpre, porque gera um total no caixa
	*/
	if($tipo == "O"){
		$where2 .= " and k02_tipo = 'O' ";
	}elseif($tipo == "E"){
		$where2 .= " and k02_tipo = 'E' ";
	}
	$sql = "select *
            from ( ";

	if ($formarrecadacao == 0){
		$sql = "select *
            	from ( ";
	}elseif ($formarrecadacao == 1) {
		$sql = "select distinct k02_codigo, k02_tipo, k02_drecei, codrec, estrutural, k12_data, k12_numpre, k12_numpar,
				c61_reduz, c60_descr, k12_conta,
				0 as vlrarquivobanco,
				round((select coalesce (sum(vlrpago),0) 
					from (
						select distinct rc.vlrrec as vlrpago, db.idret, (select sum(vlrpago) 
						from disbanco 
						where idret = db.idret and codret = db.codret) 
						from disbanco db
						inner join cadban cb on cb.k15_codbco 	= db.k15_codbco 
											and cb.k15_conta  	= k12_conta
						inner join discla dc on dc.codret 	 	= db.codret 
						inner join disrec rc on rc.codcla 	  	= dc.codcla 
						and rc.idret 	  = db.idret 
						and rc.k00_receit =  k02_codigo
						where dc.dtaute = k12_data) as x ),2) as valor
						from (
							select * from
								( ";
	}elseif ($formarrecadacao == 2) {
		$sql = "select k02_codigo, k02_tipo, k02_drecei, codrec, estrutural, k12_data, k12_numpre, k12_numpar, 
				c61_reduz, c60_descr, k12_conta,
				(sum(valor)-vlrarquivobanco)as valor
				from(
					select k02_codigo, k02_tipo, k02_drecei, codrec, estrutural,k12_data, k12_numpre, k12_numpar,
					c61_reduz, c60_descr,k12_conta, 
					valor,
					round((select coalesce (sum(vlrpago),0) 
						from (
							select distinct rc.vlrrec as vlrpago, db.idret, (select sum(vlrpago) 
							from disbanco 
							where idret = db.idret and codret = db.codret) 
							from disbanco db
							inner join cadban cb on cb.k15_codbco = db.k15_codbco 
												and cb.k15_conta  = k12_conta
							inner join discla dc on dc.codret 	  = db.codret 
							inner join disrec rc on rc.codcla 	  = dc.codcla 
												and rc.idret 	  = db.idret 
												and rc.k00_receit =  k02_codigo
							where dc.dtaute = k12_data) as x ),2) as vlrarquivobanco
								from (
									select * from
										( ";		
	}
  	$sSqlInterno =" select g.k02_codigo, g.k02_tipo, g.k02_drecei,
	  				case when o.k02_codrec is not null 	then o.k02_codrec else p.k02_reduz end as codrec,
					case when p.k02_codigo is null 	then o.k02_estorc else p.k02_estpla end as estrutural,
					f.k12_data, f.k12_numpre, f.k12_numpar, c61_reduz, c60_descr, k12_conta,
				    round( f.k12_valor #subquery_desconto# ,2) as valor
					from cornump f
					inner join corrente r on r.k12_id        		= f.k12_id
                                         and r.k12_data      		= f.k12_data
                                         and r.k12_autent    		= f.k12_autent
  					inner join conplanoreduz c1	on r.k12_conta  	= c1.c61_reduz
                                               and c1.c61_anousu	= extract (year from r.k12_data)
					inner join conplano on c1.c61_codcon 			= c60_codcon
                                       and c60_anousu    			= extract (year from r.k12_data)
					inner join tabrec g on g.k02_codigo  			= f.k12_receit
					left outer join taborc o on o.k02_codigo  		= g.k02_codigo
                                            and o.k02_anousu  		= extract (year from r.k12_data)
					left outer join tabplan p on p.k02_codigo  		= g.k02_codigo
                                             and p.k02_anousu  		= extract (year from r.k12_data)
					left join corhist hist on hist.k12_id     		= f.k12_id
                                          and hist.k12_data   		= f.k12_data
										  and hist.k12_autent 		= f.k12_autent
					left  join corplacaixa on r.k12_id 	   			= k82_id
										  and r.k12_data   			= k82_data
										  and r.k12_autent 			= k82_autent
					left  join placaixarec on k82_seqpla 			= k81_seqpla
					where $where and f.k12_data between '$datai' and '$dataf'
		           	and r.k12_instit = ".db_getsession("DB_instit");

     $sql .= str_replace("#subquery_desconto#","$sSubQueryDesconto",$sSqlInterno).
             " union all " .
             str_replace("#subquery_desconto#","",str_replace("cornump ", "cornumpdesconto ",$sSqlInterno));

	if ($formarrecadacao == 0){
		$sql .=	" ) as xxx $where2 $orderby";
	}elseif ($formarrecadacao == 1) {
		$sql .=	" ) as xxx $where2 $orderby)as x";
	}elseif ($formarrecadacao == 2) {
		$sql .=	" ) as xxx $where2 $orderby)as x)as xx 
				group by k02_codigo, k02_tipo, k02_drecei, codrec, estrutural, k12_data, k12_numpre, k12_numpar,  
						 c61_reduz, c60_descr, k12_conta, vlrarquivobanco";
	}
//die($sql);
} elseif ($sinana == 'S3') {
	if ($formarrecadacao == 0){
		$sql = "select k02_codigo, k02_tipo, k02_drecei, codrec, estrutural, c61_reduz, c60_descr, 
				sum(valor)as valor
				from (
					select * from
						( ";
	}elseif ($formarrecadacao == 1) {
		$sql = "select k02_codigo, k02_tipo, k02_drecei, codrec, estrutural, c61_reduz, c60_descr,k12_conta, 
				sum(valor) as vlrarquivobanco,
				round((select coalesce (sum(vlrpago),0) 
				from (
					select distinct rc.vlrrec as vlrpago, db.idret, (select sum(vlrpago) 
					from disbanco 
					where idret = db.idret and codret = db.codret) 
					from disbanco db
					inner join cadban cb on cb.k15_codbco = db.k15_codbco 
										and cb.k15_conta  = k12_conta
					inner join discla dc on dc.codret 	  = db.codret 
					inner join disrec rc on rc.codcla 	  = dc.codcla 
					and rc.idret 	  = db.idret 
					and rc.k00_receit =  k02_codigo
					where dc.dtaute between '$datai' and '$dataf') as x ),2) as valor
					from (
						select * from
							( ";
				}
				elseif ($formarrecadacao == 2) {
					$sql = "select k02_codigo, k02_tipo, k02_drecei, codrec, estrutural, c61_reduz, c60_descr,k12_conta,
							(valor-vlrarquivobanco)as valor
							from(
								select k02_codigo, k02_tipo, k02_drecei, codrec, estrutural, c61_reduz, c60_descr,k12_conta, 
								sum(valor) as valor,
								round((select coalesce (sum(vlrpago),0) 
								from (
									select distinct rc.vlrrec as vlrpago, db.idret, (select sum(vlrpago) 
									from disbanco 
									where idret = db.idret and codret = db.codret) 
									from disbanco db
									inner join cadban cb on cb.k15_codbco = db.k15_codbco 
														and cb.k15_conta  = k12_conta
									inner join discla dc on dc.codret 	  = db.codret 
									inner join disrec rc on rc.codcla 	  = dc.codcla 
									and rc.idret 	  = db.idret 
									and rc.k00_receit =  k02_codigo
									where dc.dtaute between '$datai' and '$dataf'
									) as x ),2) as vlrarquivobanco
									from (
										select * from
											( ";		
		}
				
 	$sSqlInterno = " select g.k02_codigo, g.k02_tipo, g.k02_drecei,
	 				case when o.k02_codrec is not null 	then o.k02_codrec else p.k02_reduz end as codrec,
				    case when p.k02_codigo is null 	then o.k02_estorc else p.k02_estpla end as estrutural,
				    k12_histcor as k00_histtxt, f.k12_data, f.k12_numpre, f.k12_numpar, c61_reduz, c60_descr, k12_conta,
				    round( f.k12_valor #subquery_desconto#, 2) as valor
			    	from cornump f
					inner join corrente r on r.k12_id        	= f.k12_id
										 and r.k12_data      	= f.k12_data
										 and r.k12_autent    	= f.k12_autent
					inner join conplanoreduz c1	on r.k12_conta	= c1.c61_reduz
											   and c1.c61_anousu= extract (year from r.k12_data)
					inner join conplano on c1.c61_codcon 		= c60_codcon
									   and c60_anousu    		= extract (year from r.k12_data)
				 	inner join tabrec g on g.k02_codigo  		= f.k12_receit
				 	left outer join taborc o on o.k02_codigo    = g.k02_codigo
					 						and o.k02_anousu    = extract (year from r.k12_data)
				 	left outer join tabplan p on p.k02_codigo   = g.k02_codigo 
					 						 and p.k02_anousu   = extract (year from r.k12_data)
					left join corhist hist on hist.k12_id     	= f.k12_id
										  and hist.k12_data   	= f.k12_data
										  and hist.k12_autent 	= f.k12_autent
					left join corplacaixa on r.k12_id 	   		= k82_id
										 and r.k12_data   		= k82_data
										 and r.k12_autent 		= k82_autent
					left join placaixarec on k82_seqpla 		= k81_seqpla
			    	where $where and f.k12_data between '$datai' and '$dataf'
			      	and r.k12_instit = ".db_getsession("DB_instit");

    $sql .= str_replace("#subquery_desconto#","$sSubQueryDesconto",$sSqlInterno).
             " union all" .
             str_replace("#subquery_desconto#","",str_replace("cornump ", "cornumpdesconto ",$sSqlInterno));

		if ($formarrecadacao == 0){
			$sql .= " ) as xxx $where2 $orderby, k12_data) as zzz
					group by k02_codigo, k02_tipo, k02_drecei, codrec, estrutural, c61_reduz, c60_descr, k12_conta
					$orderby ";
		}elseif ($formarrecadacao == 1) {
			$sql .= " ) as xxx $where2 $orderby, k12_data) as zzz
					group by k02_codigo, k02_tipo, k02_drecei, codrec, estrutural, c61_reduz, c60_descr, k12_conta
					$orderby ";
		}elseif ($formarrecadacao == 2) {
			$sql .=  " ) as xxx $where2 $orderby, k12_data) as zzz
					group by k02_codigo, k02_tipo, k02_drecei, codrec, estrutural, c61_reduz, c60_descr, k12_conta
					$orderby )as x";
		}
//die($sql);
}

//$sql = "select x.* from ($sql) as x
//		inner join conplanoreduz on c61_reduz = x.codrec and c61_instit = " . db_getsession("DB_instit") .
//              " inner join conplanoexe on c62_reduz = c61_reduz and c62_anousu = " . db_getsession("DB_anousu") .
//	      " where k02_tipo = 'O'
//	      union
//	select y.* from ($sql) as y
//		inner join orcreceita on o70_codrec = codrec and o70_instit = " . db_getsession("DB_instit");
// echo $sql;exit;
//die($sql);

// die($sql);
$result = db_query($sql) or die("Erro realizando consulta : ".$sql);

$xxnum = pg_numrows($result);
if ($xxnum == 0) {
	db_redireciona('db_erros.php?fechar=true&db_erro=N�o existem lan�amentos para a receita '.$codrec.' no per�odo de '.db_formatar($datai, 'd').' a '.db_formatar($dataf, 'd'));
}
$linha = 0;
$pre = 0;
$total_reco = 0;
$total_rece = 0;
$pagina = 0;
$valatu = array (); /// array que guarda o recursos

if ($sinana == 'S1' or $sinana == 'S3') {
	// relat�rio sint�tico ( sem hist�rico )

	if ($tipo == 'T' || $tipo == 'O') {
		$pdf->ln(2);
		$pdf->AddPage();
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetFillColor(220);
		$pdf->SetFont('Arial', 'B', 9);
		//   $pdf->Cell(185,6,"RECEITAS OR�AMENTARIAS",1,1,"C",1);
		$pdf->Cell(10, 6, "COD", 1, 0, "C", 1);
		$pdf->Cell(10, 6, "RED", 1, 0, "C", 1);
		$pdf->Cell(40, 6, "ESTRUTURAL", 1, 0, "C", 1);
		$pdf->Cell(100, 6, "RECEITA OR�AMENT�RIA", 1, 0, "C", 1);
        if ($sinana == 'S3') {
        $pdf->Cell(15, 6, "CONTA", 1, 0, "C", 1);
        $pdf->Cell(60, 6, "DESCRI��O CONTA", 1, 0, "C", 1);
        }
		$pdf->Cell(25, 6, "VALOR", 1, 1, "C", 1);
		$pdf->SetFont('Arial', 'B', 9);
		for ($i = 0; $i < $xxnum; $i ++) {
			db_fieldsmemory($result, $i);
			if ($k02_tipo == 'E')
				continue;

			// verifica se receita tem desdobramento

			$tem_desdobramento = false;

			if ($desdobrar == 'S') {
				if ($k02_tipo == 'O') {
					if ($codrec == '')
						continue;

					$sql = "select o57_fonte, o70_codigo
												 from orcreceita
												      inner join orcfontes on o57_codfon = o70_codfon and o57_anousu = o70_anousu
												      inner join orcfontesdes on o60_anousu = o70_anousu and o60_codfon = o70_codfon
												 where o70_anousu = ".db_getsession("DB_anousu")." and o70_codrec = $codrec";
					$result1 = db_query($sql) or die($sql);
					if ($result1 != false && pg_numrows($result1) > 0) {
						$fonte = pg_result($result1, 0, 0);
						$o70_codigo = pg_result($result1, 0, 1);
						$contamae = db_le_mae_rec_sin($fonte, false);

						if ($o70_codigo == 1) {

							$sql = "select o70_codrec,o57_fonte,o57_descr,o60_perc,o15_codigo,o15_descr
																 from orcreceita
																inner join orcfontes on o57_codfon = o70_codfon and o57_anousu = o70_anousu
																inner join orcfontesdes on o60_anousu = o70_anousu and o60_codfon = o70_codfon
																left join orctiporec on o70_codigo = o15_codigo
																 where o57_fonte like '$contamae%'
																			 and orcreceita.o70_anousu =".db_getsession("DB_anousu")."
																 order by o57_fonte";
							$result1 = db_query($sql);
							//	   db_criatabela($result1);
							if ($result1 != false && pg_numrows($result1) > 0) {
								$tem_desdobramento = true;
							}
						}
					}
				}
			}
			if ($pdf->gety() > $pdf->h - 30) {
				$pdf->addpage();
				$pdf->SetFont('Arial', 'B', 9);
				$pdf->Cell(10, 6, "COD", 1, 0, "C", 1);
				$pdf->Cell(10, 6, "RED", 1, 0, "C", 1);
				$pdf->Cell(40, 6, "ESTRUTURAL", 1, 0, "C", 1);
				$pdf->Cell(100, 6, "RECEITA", 1, 0, "C", 1);
        if ($sinana == 'S3') {
          $pdf->Cell(15, 6, "CONTA", 1, 0, "C", 1);
          $pdf->Cell(60, 6, "DESCRI��O CONTA", 1, 0, "C", 1);
        }
				$pdf->Cell(25, 6, "VALOR", 1, 1, "C", 1);
			}
			$pdf->setfont('arial', '', 7);
			$pdf->cell(10, 4, $k02_codigo, 1, 0, "C", $pre);
			$pdf->cell(10, 4, $codrec, 1, 0, "C", $pre);
			$pdf->cell(40, 4, $estrutural, 1, 0, "C", $pre);
			$pdf->cell(100, 4, strtoupper($k02_drecei), 1, 0, "L", $pre);
      if ($sinana == 'S3') {
        $pdf->cell(15, 4, $c61_reduz, 1, 0, "C", $pre);
        $pdf->cell(60, 4, $c60_descr, 1, 0, "L", $pre);
      }
			$pdf->cell(25, 4, db_formatar($valor, 'f'), 1, 1, "R", $pre);
			$total_reco += $valor;

			if ($tem_desdobramento) {

				unset ($dbperc);
				unset ($dbrec);
				unset ($dbrecde);
				unset ($dbreces);
				unset ($dbcodigo);
				unset ($dbdescr);
				$vlrsoma = 0;
				$multiplica = false;
				if ($valor < 0) {
					$multiplica = true;
					$valor = $valor * -1;
				}
				for ($recc = 0; $recc < pg_numrows($result1); $recc ++) {
					db_fieldsmemory($result1, $recc);
					// aplica o percentual sobre o valor
					if($o60_perc==0)
					  continue;
					$vlrperc = round($valor * ($o60_perc / 100),2);
					$vlrsoma = $vlrsoma + $vlrperc;
					if ($vlrsoma > $valor) {
						// arredonda no ultimo desdobramento
						$vlrperc = $vlrperc - ($vlrsoma - $valor);
					}
					$dbperc[$o70_codrec] = $o60_perc;
					$dbrec[$o70_codrec] = $vlrperc;
					$dbrecde[$o70_codrec] = $o57_descr;
					$dbreces[$o70_codrec] = $o57_fonte;
					$dbcodigo[$o70_codrec] = $o15_codigo;
					$dbdescr[$o70_codrec] = $o15_descr;
				}
				if ($vlrsoma < $valor) {
					$vlrperc = $vlrperc + ($valor - $vlrsoma);
					$dbrec[$o70_codrec] = $vlrperc;
				}
				if ($multiplica) {
					reset($dbrec);
					for ($arrr = 0; $arrr < sizeof($dbrec); $arrr ++) {
						$dbrec[key($dbrec)] = $dbrec[key($dbrec)] * -1;
						next($dbrec);
					}
				}
				reset($dbperc);
				reset($dbrec);
				reset($dbrecde);
				reset($dbreces);
				reset($dbcodigo);
				reset($dbdescr);
				for ($d = 0; $d < sizeof($dbrec); $d ++) {
					$pdf->cell(20, 4, '', 1, 0, "C", $pre);
					$pdf->cell(30, 4, $dbreces[key($dbrec)], 1, 0, "C", $pre);
					//          $pdf->cell(80,4,strtoupper($dbrecde[key($dbrec)]),1,0,"L",$pre);
					$pdf->cell(80, 4, substr(strtoupper($dbrecde[key($dbrec)]).'-'.$dbcodigo[key($dbrec)].'-'.$dbdescr[key($dbrec)],0,50), 1, 0, "L", $pre);
					$aa = $dbrec[key($dbrec)];
					if ($aa < 0)
						$aa = $aa * -1;

					$pdf->cell(25, 4, db_formatar($aa, 'f'), 1, 0, "R", $pre);
					$pdf->cell(10, 4, db_formatar($dbperc[key($dbrec)], 'p') . "%", 1, 1, "R", $pre);

					//$pdf->cell(25,4,db_formatar($dbrec[key($dbrec)],'f'),1,1,"R",$pre);
					$xrecurso = $dbcodigo[key($dbrec)].'-'.$dbdescr[key($dbrec)];
					// $xvalor   = $dbrec[key($dbrec)];
					$xvalor = $aa;
					if (array_key_exists($xrecurso, $valatu)) {
						$valatu[$xrecurso] += $xvalor;
					} else {
						$valatu[$xrecurso] = $xvalor;
					}
					next($dbrec);
					next($dbrecde);
					next($dbreces);
					next($dbcodigo);
					next($dbdescr);
				}

			}

		}
		$pdf->setfont('arial', 'B', 7);
    if ($sinana == 'S1') {
      $pdf->cell(160, 4, "TOTAL ...", 1, 0, "L", 0);
    } elseif ($sinana == 'S3') {
      $pdf->cell(235, 4, "TOTAL ...", 1, 0, "L", 0);
    }
    $pdf->cell(25, 4, db_formatar($total_reco, 'f'), 1, 1, "R", 0);
	} 

	if ($tipo == 'T' || $tipo == 'E') {
  	$pdf->ln(2);
    if($tipo == 'E') {
		  $pdf->AddPage();
    } else {
	  	if ($pdf->gety() > $pdf->h - 30) {
		  	$pdf->AddPage();
		  }
    }
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetFillColor(220);
		//   $pdf->SetFont('Arial','B',9);
		//   $pdf->Cell(185,6,"RECEITAS EXTRA-OR�AMENTARIAS",1,1,"C",1);
		$pdf->SetFont('Arial', 'B', 9);
		$pdf->Cell(10, 6, "COD", 1, 0, "C", 1);
		$pdf->Cell(10, 6, "RED", 1, 0, "C", 1);
		$pdf->Cell(40, 6, "ESTRUTURAL", 1, 0, "C", 1);
		$pdf->Cell(100, 6, "RECEITA EXTRA-OR�AMENT�RIA", 1, 0, "C", 1);
    if ($sinana == 'S3') {
      $pdf->Cell(15, 6, "CONTA", 1, 0, "C", 1);
      $pdf->Cell(60, 6, "DESCRI��O CONTA", 1, 0, "L", 1);
    }
		$pdf->Cell(25, 6, "VALOR", 1, 1, "C", 1);
		$pdf->SetFont('Arial', 'B', 9);
		for ($i = 0; $i < $xxnum; $i ++) {
			db_fieldsmemory($result, $i);
			if ($k02_tipo == 'O')
				continue;
			if ($pdf->gety() > $pdf->h - 30) {
				$pdf->addpage();
				$pdf->SetFont('Arial', 'B', 9);
				$pdf->Cell(10, 6, "COD", 1, 0, "C", 1);
				$pdf->Cell(10, 6, "RED", 1, 0, "C", 1);
				$pdf->Cell(40, 6, "ESTRUTURAL", 1, 0, "C", 1);
				$pdf->Cell(100, 6, "RECEITA", 1, 0, "C", 1);
        if ($sinana == 'S3') {
          $pdf->Cell(15, 6, "CONTA", 1, 0, "C", 1);
          $pdf->Cell(60, 6, "DESCRI��O CONTA", 1, 0, "L", 1);
        }
				$pdf->Cell(25, 6, "VALOR", 1, 1, "C", 1);
			}
			$pdf->setfont('arial', '', 7);
			$pdf->cell(10, 4, $k02_codigo, 1, 0, "C", $pre);
			$pdf->cell(10, 4, $codrec, 1, 0, "C", $pre);
			$pdf->cell(40, 4, $estrutural, 1, 0, "C", $pre);
			$pdf->cell(100, 4, strtoupper($k02_drecei), 1, 0, "L", $pre);
      if ($sinana == 'S3') {
        $pdf->cell(15, 4, $c61_reduz, 1, 0, "C", $pre);
        $pdf->cell(60, 4, $c60_descr, 1, 0, "L", $pre);
      }
			$pdf->cell(25, 4, db_formatar($valor, 'f'), 1, 1, "R", $pre);
			$total_rece += $valor;
		}
		$pdf->setfont('arial', 'B', 7);
    if ($sinana == 'S1') {
      $pdf->cell(160, 4, "TOTAL ...", 1, 0, "L", 0);
    } elseif ($sinana == 'S3') {
      $pdf->cell(235, 4, "TOTAL ...", 1, 0, "L", 0);
    }
    $pdf->cell(25, 4, db_formatar($total_rece, 'f'), 1, 1, "R", 0);

	}

  if ($sinana == 'S1') {
	  $pdf->cell(160, 4, "TOTAL GERAL", 1, 0, "L", 0);
  } elseif ($sinana == 'S3') {
	  $pdf->cell(235, 4, "TOTAL GERAL", 1, 0, "L", 0);
  }
	$pdf->cell(25, 4, db_formatar($total_rece + $total_reco, 'f'), 1, 1, "R", 0);
	$pdf->ln(5);

	$pdf->cell(110, 4, "DEMONSTRATIVO DO DESDOBRAMENTO DA RECEITA LIVRE", 1, 1, "L", 0);

	$totalrecursos=0;
	while (list ($key, $valor) = each($valatu)) {
		$totalrecursos += $valor;
	}

  reset($valatu);

	while (list ($key, $valor) = each($valatu)) {
		$pdf->cell(70, 5, $key, 0, 0, "L", 0, 0, ".");
		$pdf->cell(20, 5, db_formatar($valor, 'f'), 0, 0, "R", 0);
		$pdf->cell(20, 5, db_formatar($valor / $totalrecursos * 100, 'p') . "%", 0, 1, "R", 0);
	}
	$pdf->setfont('arial', 'B', 7);
	$pdf->cell(110, 5, db_formatar($totalrecursos, 'f'), 1, 1, "R", 0);

// FINAL DA PRIMEIRA CONDICAO IF SINANA S1 OU S3
} elseif ($sinana == 'S2') {
	////// sintetico por estrutural
	$troca = 1;
	$pdf->ln(2);
	$pdf->SetTextColor(0, 0, 0);
	$pdf->SetFillColor(220);
	for ($i = 0; $i < $xxnum; $i ++) {
		db_fieldsmemory($result, $i);
		if ($tipo == "O" && $k02_tipo == "E") {
			continue;
		}
		elseif ($tipo == "E" && $k02_tipo == "O") {
			continue;
		}
		if ($pdf->gety() > $pdf->h - 30 || $troca == 1) {
			$pdf->addpage();
			$pdf->SetFont('Arial', 'B', 9);
			$pdf->Cell(40, 6, "ESTRUTURAL", 1, 0, "C", 1);
			$pdf->Cell(100, 6, "DESCRI��O", 1, 0, "C", 1);
			$pdf->Cell(25, 6, "VALOR", 1, 1, "C", 1);
			$troca = 0;
		}
		$pdf->setfont('arial', '', 7);
		$pdf->cell(40, 4, $estrutural, 1, 0, "C", $pre);
		$pdf->cell(100, 4, $descr, 1, 0, "L", $pre);
		$pdf->cell(25, 4, db_formatar($valor, 'f'), 1, 1, "R", $pre);
		$total_reco += $valor;
	}
	$pdf->setfont('arial', '', 7);
	$pdf->cell(140, 4, 'TOTAL GERAL', 1, 0, "C", $pre);
	$pdf->cell(25, 4, db_formatar($total_reco, 'f'), 1, 1, "R", $pre);

} else if($sinana == 'S4'){
	//Di�rio
	$pdf->ln(2);
	$pdf->AddPage();
	$pdf->SetTextColor(0, 0, 0);
	$pdf->SetFillColor(220);
	$pdf->SetFont('Arial', 'B', 9);
	$pdf->Cell(10, 6, "COD", 1, 0, "C", 1);
	$pdf->Cell(10, 6, "RED", 1, 0, "C", 1);
	$pdf->Cell(15, 6, "DATA", 1, 0, "C", 1);
	$pdf->Cell(15, 6, "GUIA N�", 1, 0, "C", 1);
	$pdf->Cell(25, 6, "ESTRUTURAL", 1, 0, "C", 1);
	$pdf->Cell(15, 6, "FONTE", 1, 0, "C", 1);
	$pdf->Cell(80, 6, "DESC DA RECEITA", 1, 0, "C", 1);
	$pdf->Cell(15, 6, "CONTA", 1, 0, "L", 1);
	$pdf->Cell(69, 6, "DESCRI��O", 1, 0, "L", 1);
	$pdf->Cell(25, 6, "VALOR", 1, 1, "C", 1);
	$pdf->SetFont('Arial', 'B', 9);
	$pre = 1;
	$aDadosAgrupados = array();
	for ($i = 0; $i < $xxnum; $i ++) {
		db_fieldsmemory($result, $i);
		$oDadosAgrupados = new stdClass();
		$oDadosAgrupados->k02_codigo = $k02_codigo;
		$oDadosAgrupados->codrec = $codrec;
		$oDadosAgrupados->k02_tipo = $k02_tipo;
		$oDadosAgrupados->k12_data = $k12_data;
		$oDadosAgrupados->k12_numpre = $k12_numpre;
		$oDadosAgrupados->estrutural = $estrutural;
		$oDadosAgrupados->fonte = $recurso;
		$oDadosAgrupados->k02_drecei = $k02_drecei;
		$oDadosAgrupados->valor = $valor;
		$oDadosAgrupados->c61_reduz = $c61_reduz;
		$oDadosAgrupados->c60_descr = $c60_descr;
		$aDadosAgrupados[$k12_data][] = $oDadosAgrupados;
	}
	$total_geral = 0;
	foreach($aDadosAgrupados as $aDados) {
		$total_nadata = 0;
		foreach ($aDados as $oValores) {
			$tem_desdobramento = false;
			if ($pdf->gety() > $pdf->h - 30) {
				$pdf->addpage("L");
				$pdf->SetFont('Arial', 'B', 9);
				$pdf->Cell(10, 6, "COD", 1, 0, "C", 1);
				$pdf->Cell(10, 6, "RED", 1, 0, "C", 1);
				$pdf->Cell(15, 6, "DATA", 1, 0, "C", 1);
				$pdf->Cell(15, 6, "GUIA N�", 1, 0, "C", 1);
				$pdf->Cell(25, 6, "ESTRUTURAL", 1, 0, "C", 1);
				$pdf->Cell(15, 6, "FONTE", 1, 0, "C", 1);
				$pdf->Cell(80, 6, "DESC DA RECEITA", 1, 0, "C", 1);
				$pdf->Cell(15, 6, "CONTA", 1, 0, "L", 1);
				$pdf->Cell(69, 6, "DESCRI��O", 1, 0, "L", 1);
				$pdf->Cell(25, 6, "VALOR", 1, 1, "C", 1);
				$pre = 1;
			}
			if ($pre == 1)
				$pre = 0;
			else
				$pre = 1;

			$pdf->setfont('arial', '', 7);
			$pdf->cell(10, 4, $oValores->k02_codigo, 1, 0, "C", $pre);
			$pdf->cell(10, 4, $oValores->codrec, 1, 0, "C", $pre);
			$pdf->Cell(15, 4, db_formatar($oValores->k12_data, 'd'), 1, 0, "C", $pre);
			$pdf->Cell(15, 4, $oValores->k12_numpre, 1, 0, "C", $pre);
			$pdf->cell(25, 4, $oValores->estrutural, 1, 0, "C", $pre);
			$pdf->Cell(15, 4, getFonteRecurso($oValores->k02_tipo == 'O' ? $oValores->codrec : $oValores->c61_reduz,db_getsession('DB_anousu'),$oValores->k02_tipo,$oValores->fonte), 1, 0, "C", $pre);
			$pdf->cell(80, 4, strtoupper($oValores->k02_drecei), 1, 0, "L", $pre);
			$pdf->cell(15, 4, $oValores->c61_reduz, 1, 0, "C", $pre);
			$pdf->cell(69, 4, $oValores->c60_descr, 1, 0, "L", $pre);
			$pdf->cell(25, 4, db_formatar($oValores->valor, 'f'), 1, 1, "R", $pre);
			$total_nadata += $oValores->valor;

		}
		$total_geral += $total_nadata;
		$pdf->setfont('arial', 'B', 7);
		$pdf->cell(254, 4, "SubTotal:", 1, 0, "R", 1);
        $pdf->cell(25, 4, db_formatar($total_nadata, 'f'), 1, 1, "R", 1);
		$pdf->ln(5);
	}
	$pdf->cell(254, 4, "Total Geral....:", 1, 0, "R", 1);
	$pdf->cell(25, 4, db_formatar($total_geral, 'f'), 1, 1, "R", 1);
	$pdf->ln(5);
} else {

	// relatorio analitico ( com hist�rico )
	if ($tipo == 'T' || $tipo == 'O') {
		$pdf->ln(2);
		$pdf->AddPage();
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetFillColor(220);
		$pdf->SetFont('Arial', 'B', 9);
		//   $pdf->Cell(185,6,"RECEITAS OR�AMENTARIAS",1,1,"C",1);
		$pdf->Cell(10, 6, "COD", 1, 0, "C", 1);
		$pdf->Cell(10, 6, "RED", 1, 0, "C", 1);
		$pdf->Cell(15, 6, "DATA", 1, 0, "C", 1);
		$pdf->Cell(15, 6, "NUMPRE", 1, 0, "C", 1);
		$pdf->Cell(25, 6, "ESTRUTURAL", 1, 0, "C", 1);
		$pdf->Cell(80, 6, "RECEITA OR�AMENT�RIA", 1, 0, "C", 1);
		$pdf->Cell(25, 6, "VALOR", 1, 0, "C", 1);
		$pdf->Cell(15, 6, "CONTA", 1, 0, "L", 1);
		$pdf->Cell(65, 6, "DESCRI��O", 1, 1, "L", 1);
		$pdf->SetFont('Arial', 'B', 9);
		$pre = 1;
		for ($i = 0; $i < $xxnum; $i ++) {
			db_fieldsmemory($result, $i);
			if ($k02_tipo == 'E')
				continue;

			// verifica se receita tem desdobramento

			$tem_desdobramento = false;

			if ($pdf->gety() > $pdf->h - 30) {
				$pdf->addpage("L");
				$pdf->SetFont('Arial', 'B', 9);
				$pdf->Cell(10, 6, "COD", 1, 0, "C", 1);
				$pdf->Cell(10, 6, "RED", 1, 0, "C", 1);
				$pdf->Cell(15, 6, "DATA", 1, 0, "C", 1);
				$pdf->Cell(15, 6, "NUMPRE", 1, 0, "C", 1);
				$pdf->Cell(25, 6, "ESTRUTURAL", 1, 0, "C", 1);
				$pdf->Cell(80, 6, "RECEITA", 1, 0, "C", 1);
				$pdf->Cell(25, 6, "VALOR", 1, 0, "C", 1);
				$pdf->Cell(15, 6, "CONTA", 1, 0, "C", 1);
				$pdf->Cell(65, 6, "DESCRI��O", 1, 1, "C", 1);
				$pre = 1;
			}
			if ($pre == 1)
				$pre = 0;
			else
				$pre = 1;

			$pdf->setfont('arial', '', 7);
			$pdf->cell(10, 4, $k02_codigo, 1, 0, "C", $pre);
			$pdf->cell(10, 4, $codrec, 1, 0, "C", $pre);
			$pdf->Cell(15, 4, $k12_data, 1, 0, "C", $pre);
			$pdf->Cell(15, 4, $k12_numpre, 1, 0, "C", $pre);
			$pdf->cell(25, 4, $estrutural, 1, 0, "C", $pre);
			$pdf->cell(80, 4, strtoupper($k02_drecei), 1, 0, "L", $pre);
			$pdf->cell(25, 4, db_formatar($valor, 'f'), 1, 0, "R", $pre);
			$pdf->cell(15, 4, $c61_reduz, 1, 0, "C", $pre);
			$pdf->cell(65, 4, $c60_descr, 1, 1, "L", $pre);
			if (trim($k00_histtxt) != '') {
				$pdf->multicell(245, 4, 'HIST�RICO :  '.$k00_histtxt, 1, "L", $pre);
			}
			$total_reco += $valor;

		}
		$pdf->setfont('arial', 'B', 7);
		$pdf->cell(140, 4, "TOTAL ...", 1, 0, "L", 0);
		$pdf->cell(25, 4, db_formatar($total_reco, 'f'), 1, 1, "R", 0);
	}

	//for($dd=0;$dd<sizeof($valatu);$dd++){
	//  echo "<pre>";
	//  print_r($valatu);
	//  echo "</pre>";
	if ($tipo == 'T' || $tipo == 'E') {
		$pdf->ln(2);
		if ($pdf->gety() > $pdf->h - 30) {
			$pdf->AddPage("L");
		}
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetFillColor(220);
		//   $pdf->SetFont('Arial','B',9);
		//   $pdf->Cell(185,6,"RECEITAS EXTRA-OR�AMENTARIAS",1,1,"C",1);
		$pdf->SetFont('Arial', 'B', 9);
		$pdf->Cell(10, 6, "COD", 1, 0, "C", 1);
		$pdf->Cell(10, 6, "RED", 1, 0, "C", 1);
		$pdf->Cell(15, 6, "DATA", 1, 0, "C", 1);
		$pdf->Cell(25, 6, "ESTRUTURAL", 1, 0, "C", 1);
		$pdf->Cell(80, 6, "RECEITA EXTRA-OR�AMENT�RIA", 1, 0, "C", 1);
		$pdf->Cell(25, 6, "VALOR", 1, 0, "C", 1);
		$pdf->Cell(0, 6, "HIST�RICO", 1, 1, "C", 1);
		$pdf->SetFont('Arial', 'B', 9);
		for ($i = 0; $i < $xxnum; $i ++) {
			db_fieldsmemory($result, $i);
			if ($k02_tipo == 'O')
				continue;
			if ($pdf->gety() > $pdf->h - 30) {
				$pdf->addpage("L");
				$pdf->SetFont('Arial', 'B', 9);
				$pdf->Cell(10, 6, "COD", 1, 0, "C", 1);
				$pdf->Cell(10, 6, "RED", 1, 0, "C", 1);
				$pdf->Cell(15, 6, "DATA", 1, 0, "C", 1);
				$pdf->Cell(40, 6, "ESTRUTURAL", 1, 0, "C", 1);
				$pdf->Cell(100, 6, "RECEITA", 1, 0, "C", 1);
				$pdf->Cell(25, 6, "VALOR", 1, 0, "C", 1);
				$pdf->Cell(0, 6, "HIST�RICO", 1, 1, "C", 1);
			}
			$pdf->setfont('arial', '', 7);
			$pdf->cell(10, 4, $k02_codigo, 1, 0, "C", $pre);
			$pdf->cell(10, 4, $codrec, 1, 0, "C", $pre);
			$pdf->Cell(15, 4, $k12_data, 1, 0, "C", $pre);
			$pdf->cell(40, 4, $estrutural, 1, 0, "C", $pre);
			$pdf->cell(100, 4, strtoupper($k02_drecei), 1, 0, "L", $pre);
			$pdf->cell(25, 4, db_formatar($valor, 'f'), 1, 0, "R", $pre);
			$pdf->multicell(0, 4, $k00_histtxt, 1, "L", $pre);
			$total_rece += $valor;
		}
		$pdf->setfont('arial', 'B', 7);
		$pdf->cell(140, 4, "TOTAL ...", 1, 0, "L", 0);
		$pdf->cell(25, 4, db_formatar($total_rece, 'f'), 1, 1, "R", 0);
	}
	$pdf->cell(140, 4, "TOTAL GERAL", 1, 0, "L", 0);
	$pdf->cell(25, 4, db_formatar($total_rece + $total_reco, 'f'), 1, 1, "R", 0);
	$pdf->ln(5);

}

$pdf->Output();

/**
 * Busca a fonte de recurso pela Receita.
 * Quando for extra, busca da OP vinculada a conta arrecadadadora
 * @param $iConta
 * @param $iAno
 * @param $sTipo
 * @return mixed|string
 */
function getFonteRecurso($iConta, $iAno,$sTipo,$iRecurso){
	switch($sTipo){
		case "O":
			$oReceita = ReceitaContabilRepository::getReceitaByCodigo($iConta,$iAno);
			if($iRecurso == 0) {
                $oFonteRecurso = new Recurso($oReceita->getTipoRecurso());
            }else{
                $oFonteRecurso = new Recurso($iRecurso);
            }
			return $oFonteRecurso->getEstrutural();
			break;
		case "E":
            if($iRecurso == 0) {
                $oFonteRecurso = new Recurso(ContaPlanoPCASPRepository::getContaPorReduzido($iConta, $iAno, InstituicaoRepository::getInstituicaoByCodigo(db_getsession('DB_instit')))->getRecurso());
            }else{
                $oFonteRecurso = new Recurso($iRecurso);
            }
			return $oFonteRecurso->getEstrutural();
			break;
	}

}
?>