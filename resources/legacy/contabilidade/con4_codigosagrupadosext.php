<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2009  DBselller Servicos de Informatica
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

include("fpdf151/pdf.php");
include("libs/db_sql.php");

$head3 = "CÓDIGOS EXT AGRUPADOS SICOM";

$aFontesEncerradas = array('148', '149', '150', '151', '152', '248', '249', '250', '251', '252');

/*
 * SQL RETORNA TODAS AS CONTAS EXTRAS EXISTENTES NO SISTEMA
 *
 */
if(db_getsession("DB_anousu") < 2016) {
    $sSqlExt = "select 10 as tiporegistro,c61_codcon,
				       c61_reduz as codext,
				       c61_codtce as codtce,
				       si09_codorgaotce as codorgao,
				       (select CASE
									    WHEN o41_subunidade != 0
									         OR NOT NULL THEN lpad((CASE WHEN o40_codtri = '0'
									            OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
									              OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)||lpad(o41_subunidade::integer,3,0)
									    ELSE lpad((CASE WHEN o40_codtri = '0'
									         OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
									           OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)
					             end as unidade
					  from orcunidade
					  join orcorgao on o41_anousu = o40_anousu and o41_orgao = o40_orgao
					  where o41_instit = " . db_getsession("DB_instit") . " and o40_anousu = " . db_getsession("DB_anousu") . " order by o40_orgao limit 1) as codUnidadeSub,
				       substr(c60_tipolancamento::varchar,1,2) as tipolancamento,
				       case when c60_tipolancamento = 1 and c60_subtipolancamento not in (1,2,3,4) then c61_reduz
				            when c60_tipolancamento = 2 then 1
				            when c60_tipolancamento = 3 and c60_subtipolancamento not in (1,2,3) then c61_reduz
				            when c60_tipolancamento = 4 and c60_subtipolancamento not in (1,2,3,4,5,6,7) then c61_reduz
				            when (c60_tipolancamento = 99 OR c60_tipolancamento = 9999) and c60_subtipolancamento = 9999 then c61_reduz
				            else c60_subtipolancamento
				       end as subtipo,
				       case when c60_tipolancamento = 1 and c60_subtipolancamento not in (1,2,3,4) then 0
				            when c60_tipolancamento = 2 then 0
				            when c60_tipolancamento = 3 then 0
				            when c60_tipolancamento = 4 and c60_subtipolancamento not in (1,2,3,4,5,6,7) then c61_reduz
				            else c60_desdobramneto
				       end as desdobrasubtipo,
				       substr(c60_descr,1,50) as descextraorc,
					   o15_codtri as recurso
				  from conplano
				  join conplanoreduz on c60_codcon = c61_codcon and c60_anousu = c61_anousu
				  left join infocomplementaresinstit on si09_instit = c61_instit
				  join orctiporec on c61_codigo = o15_codigo
				  where c60_anousu = " . db_getsession("DB_anousu") . " and c60_codsis = 7 and c61_instit = " . db_getsession("DB_instit") . "
  				order by c61_reduz  ";
} else {
    $sSqlExt = "select 10 as tiporegistro,c61_codcon,
				       c61_reduz as codext,
				       c61_codtce as codtce,
				       si09_codorgaotce as codorgao,
				       (select CASE
									    WHEN o41_subunidade != 0
									         OR NOT NULL THEN lpad((CASE WHEN o40_codtri = '0'
									            OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
									              OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)||lpad(o41_subunidade::integer,3,0)
									    ELSE lpad((CASE WHEN o40_codtri = '0'
									         OR NULL THEN o40_orgao::varchar ELSE o40_codtri END),2,0)||lpad((CASE WHEN o41_codtri = '0'
									           OR NULL THEN o41_unidade::varchar ELSE o41_codtri END),3,0)
					             end as unidade
					  from orcunidade
					  join orcorgao on o41_anousu = o40_anousu and o41_orgao = o40_orgao
					  where o41_instit = " . db_getsession("DB_instit") . " and o40_anousu = " . db_getsession("DB_anousu") . " order by o40_orgao limit 1) as codUnidadeSub,
				       substr(c60_tipolancamento::varchar,1,2) as tipolancamento,
				       c60_subtipolancamento as subtipo,
				       case when (c60_tipolancamento = 1 and c60_subtipolancamento in (1,2,3,4) ) or
				                 (c60_tipolancamento = 4 and c60_subtipolancamento in (1,2) ) or
				                 (c60_tipolancamento = 9999 and c60_desdobramneto is not null) then c60_desdobramneto
				            else 0
				       end as desdobrasubtipo,
				       substr(c60_descr,1,50) as descextraorc,
					   o15_codtri as recurso
				  from conplano
				  join conplanoreduz on c60_codcon = c61_codcon and c60_anousu = c61_anousu
				  left join infocomplementaresinstit on si09_instit = c61_instit
				  join orctiporec on c61_codigo = o15_codigo
				  where c60_anousu = " . db_getsession("DB_anousu") . " and c60_codsis = 7 and c61_instit = " . db_getsession("DB_instit") . "
  				order by c61_reduz  ";
}
$rsContasExtra = db_query($sSqlExt);//echo pg_last_error();db_criatabela($rsContasExtra);


/*
 * PERCORRE OS SQL NOVAMENTE PARA INSERIR NA BASE DE DADOS OS REGISTROS
 */

$aExt10Agrupado = array();
for ($iCont10 = 0;$iCont10 < pg_num_rows($rsContasExtra); $iCont10++) {

    $oContaExtra = db_utils::fieldsMemory($rsContasExtra,$iCont10);

    $aHash  = $oContaExtra->codorgao;
    $aHash .= $oContaExtra->codunidadesub;
    $aHash .= $oContaExtra->tipolancamento;
    $aHash .= $oContaExtra->subtipo;
    $aHash .= $oContaExtra->desdobrasubtipo;

    if(!isset($aExt10Agrupado[$aHash])){
        $cExt10 = new stdClass();

        $cExt10->codext = $oContaExtra->codtce != 0 ? $oContaExtra->codtce : $oContaExtra->codext;
        $cExt10->codtce = $oContaExtra->codtce;
		$cExt10->recurso = in_array($oContaExtra->recurso, $aFontesEncerradas) ? substr($oContaExtra->recurso, 0, 1).'59' : $oContaExtra->recurso;
        $cExt10->extras	= array();

		$oCodExt = new stdClass();
		$oCodExt->codext = $oContaExtra->codext;
		$oCodExt->recurso = in_array($oContaExtra->recurso, $aFontesEncerradas) ? substr($oContaExtra->recurso, 0, 1).'59' : $oContaExtra->recurso;

        $cExt10->extras[]= $oCodExt;
        $aExt10Agrupado[$aHash] = $cExt10;
    }else{
		$oCodExt = new stdClass();
		$oCodExt->codext = $oContaExtra->codext;
		$oCodExt->recurso = in_array($oContaExtra->recurso, $aFontesEncerradas) ? substr($oContaExtra->recurso, 0, 1).'59' : $oContaExtra->recurso;

        $aExt10Agrupado[$aHash]->extras[] = $oCodExt;
    }

}
//echo "<pre>";print_r($aExt10Agrupado);exit;

$pdf = new PDF();
$pdf->Open();
$pdf->AliasNbPages();
$total = 0;
$pdf->setfillcolor(235);
$pdf->setfont('arial','b',8);
$troca = 1;
$alt = 4;
foreach($aExt10Agrupado as $oCodigos)
{
    if ($pdf->gety() > $pdf->h - 30 || $troca != 0 )
    {
        $pdf->addpage();
        $pdf->setfont('arial','b',8);
        $pdf->cell(35,$alt,"Reduzido",1,0,"C",1);
        $pdf->cell(35,$alt,"Código TCE",1,0,"C",1);
        $pdf->cell(110,$alt,"Reduzidos Agrupados",1,1,"C",1);
        $troca = 0;
    }
    $pdf->setfont('arial','',7);
    $pdf->cell(35,$alt,$oCodigos->codext.' ('.$oCodigos->recurso.')',1,0,"C",0);
    $pdf->cell(35,$alt,$oCodigos->codtce,1,0,"C",0);

	$sCoditosAgrup = '';
    $iCount = count($oCodigos->extras);
    
    foreach($oCodigos->extras as $index => $oExt) {

        $sCoditosAgrup .= $oExt->codext.' ('.$oExt->recurso.')';
        
        if ($index < ($iCount-1)) {
            $sCoditosAgrup .= ', ';
        }
        
    }

    $pdf->cell(110,$alt,$sCoditosAgrup,1,1,"C",0);
    $total ++;
}
$pdf->setfont('arial','b',8);
$pdf->cell(0,$alt,"TOTAL DE REGISTROS  :  $total",'T',0,"L",0);
$pdf->output();
?>