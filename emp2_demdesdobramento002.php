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

require_once('fpdf151/pdf.php');
require_once('libs/db_utils.php');

function novoCabecalho($oPdf, $sElemento) {

  $lCor = true;
  $iTam = 5;
  $oPdf->setfont('arial', 'B', 9);
  
  $oPdf->cell(280, $iTam, substr($sElemento, 0, 100) , 1, 1, 'L', $lCor);
  
  $oPdf->cell(94, $iTam, 'Desdobramento', 1, 0, 'C', $lCor);
  $oPdf->cell(80, $iTam, 'Fornecedor', 1, 0, 'C', $lCor);
  $oPdf->cell(16, $iTam, 'Empenho', 1, 0, 'C', $lCor);
  $oPdf->cell(30, $iTam, 'Empenhado', 1, 0, 'C', $lCor);
  $oPdf->cell(30, $iTam, 'Liquidado', 1, 0, 'C', $lCor);
  $oPdf->cell(30, $iTam, 'Pago', 1, 1, 'C', $lCor);

}

function novaLinha($oPdf, $sDesdobramento, $sFornecedor,$sEmpenho ,$nTotEmpenhado, $nTotLiquidado,$nTotPago) {

  $lCor = false;
  $iTamFixo = 5;
  $oPdf->setfont('arial', '', 9);
  
  $aDesdobramento = quebrar_texto($sDesdobramento,50);
  $aFornecedor = quebrar_texto($sFornecedor, 41);
  if (count($aDesdobramento) > count($aFornecedor)) {
    $iTam = $iTamFixo*(count($aDesdobramento));
  } else {
  	$iTam = $iTamFixo*(count($aFornecedor));
  }
  
  if (strlen($sDesdobramento) > 50) {
		multiCell($oPdf, $aDesdobramento, $iTamFixo, $iTam, 94);
  } else {
	  $oPdf->cell(94, $iTam, $sDesdobramento, 1, 0, 'L', $lCor);
	}
  
  if (strlen($sFornecedor) > 41) {
		multiCell($oPdf, $aFornecedor, $iTamFixo, $iTam, 80);
  } else {
	  $oPdf->cell(80, $iTam, substr($sFornecedor, 0, 41), 1, 0, 'L', $lCor);
	}
  
  $oPdf->cell(16, $iTam, $sEmpenho, 1, 0, 'L', $lCor);
  $oPdf->cell(30, $iTam, $nTotEmpenhado != '' ? "R$ ".db_formatar($nTotEmpenhado, "f") : '', 1, 0, 'C', $lCor);
  $oPdf->cell(30, $iTam, $nTotLiquidado != '' ? "R$ ".db_formatar($nTotLiquidado, "f") : '', 1, 0, 'C', $lCor);
  $oPdf->cell(30, $iTam, $nTotPago != '' ? "R$ ".db_formatar($nTotPago, "f") : '', 1, 1, 'C', $lCor);

}

function novoRodapeElemento($oPdf, $nEmLiq,$nLiq,$nPagto) {

  $lCor = true;
  $iTam = 5;
  $oPdf->setfont('arial', 'B', 9);
  
  $oPdf->cell(190, $iTam, "TOTAL DO ELEMENTO"  , 1, 0, 'R', $lCor);
  $oPdf->cell(30, $iTam, "R$ ".db_formatar($nEmLiq, "f")  , 1, 0, 'L', $lCor);
  $oPdf->cell(30, $iTam, "R$ ".db_formatar($nLiq, "f") , 1, 0, 'L', $lCor);
  $oPdf->cell(30, $iTam, "R$ ".db_formatar($nPagto, "f") , 1, 1, 'L', $lCor);

}

function novoRodapeDesdobramento($oPdf, $nEmLiq,$nLiq,$nPagto) {

  $lCor = true;
  $iTam = 5;
  $oPdf->setfont('arial', 'B', 9);
  
  $oPdf->cell(190, $iTam, "TOTAL DO DESDOBRAMENTO"  , 1, 0, 'R', $lCor);
  $oPdf->cell(30, $iTam, "R$ ".db_formatar($nEmLiq, "f")  , 1, 0, 'L', $lCor);
  $oPdf->cell(30, $iTam, "R$ ".db_formatar($nLiq, "f") , 1, 0, 'L', $lCor);
  $oPdf->cell(30, $iTam, "R$ ".db_formatar($nPagto, "f") , 1, 1, 'L', $lCor);

}

function novoRodape($oPdf, $nTotalEmLiq,$nTotalLiq,$nTotalPagto) {

  $lCor = true;
  $iTam = 5;
  $oPdf->setfont('arial', 'B', 9);
  
  $oPdf->cell(91, $iTam, ""  , 0, 0, 'L', 0);
  $oPdf->cell(64, $iTam, "Total Empenhado: R$ ".db_formatar($nTotalEmLiq, "f")  , 0, 0, 'L', 0);
  $oPdf->cell(63, $iTam, "Total Liquidado: R$ ".db_formatar($nTotalLiq, "f") , 0, 0, 'L', 0);
  $oPdf->cell(63, $iTam, "Total Pago: R$ ".db_formatar($nTotalPagto, "f") , 0, 1, 'L', 0);

}

function multiCell($oPdf,$aTexto,$iTamFixo,$iTam,$iTamCampo) {
	  $pos_x = $oPdf->x;
		$pos_y = $oPdf->y;
		$oPdf->cell($iTamCampo, $iTam, "", 1, 0, 'L', $lCor);
		$oPdf->x = $pos_x;
		$oPdf->y = $pos_y;
		foreach ($aTexto as $sProcedimento) {
			$sProcedimento=ltrim($sProcedimento);
			$oPdf->cell($iTamCampo, $iTamFixo, $sProcedimento, 0, 1, 'L', $lCor);
			$oPdf->x=$pos_x;
		}
		$oPdf->x = $pos_x+$iTamCampo;
		$oPdf->y = $pos_y;
}

function quebrar_texto($texto,$tamanho){

	$aTexto = explode(" ", $texto);
	$string_atual = "";
	foreach ($aTexto as $word) {
		$string_ant = $string_atual;
		$string_atual .= " ".$word;
		if (strlen($string_atual) > $tamanho) {
			$aTextoNovo[] = $string_ant;
			$string_ant   = "";
			$string_atual = $word;
		}
	}
	$aTextoNovo[] = $string_atual;
	return $aTextoNovo;

}

$dDataIni = implode("-", array_reverse(explode("/", $dIni)));
$dDataFim = implode("-", array_reverse(explode("/", $dFim)));

$where = '';
if ($dIni != ''){
	$where = " and ( conlancam.c70_data >= '{$dDataIni}' and conlancam.c70_data <= '{$dDataFim}' ) ";
}
if ($aFornecedor != ''){
	$where .= " and z01_numcgm in ({$aFornecedor})";
}
if ($iUnidade != ''){
	$where .= " and (orcunidade.o41_orgao = {$iOrgao} and orcunidade.o41_unidade = {$iUnidade}) ";
}

$sql = "select *  from (
select orcdotacao.o58_codele||'-'||substr(ele.o56_elemento||'00',1,15)||'-'||ele.o56_descr as Desdobramento,
conplanoorcamento.c60_estrut||'-'||conplanoorcamento.c60_descr as Elemento,
z01_nome,e60_codemp,
sum(case when c53_tipo = 10 then c70_valor else 0 end ) as empenhado,
sum(case when c53_tipo = 20 then c70_valor else 0 end ) as liquidado,
sum(case when c53_tipo = 30 then c70_valor else 0 end ) as pagamento,
sum(case when c53_tipo = 11 then c70_valor else 0 end ) as anulempenhado,
sum(case when c53_tipo = 21 then c70_valor else 0 end ) as anulliquidado,
sum(case when c53_tipo = 31 then c70_valor else 0 end ) as anulpagamento,
sum(case when c53_tipo = 10 then c70_valor else 0 end )-sum(case when c53_tipo = 11 then c70_valor else 0 end ) as totalemp,
sum(case when c53_tipo = 20 then c70_valor else 0 end )-sum(case when c53_tipo = 21 then c70_valor else 0 end ) as totalliq,
sum(case when c53_tipo = 30 then c70_valor else 0 end )-sum(case when c53_tipo = 31 then c70_valor else 0 end ) as totalpag
from conlancamele
inner join conlancam on c67_codlan=c70_codlan
inner join conlancamemp on c75_codlan = c70_codlan
inner join empempenho on e60_numemp = c75_numemp and e60_anousu=date_part('year',c70_data)
inner join orcdotacao on o58_coddot = empempenho.e60_coddot and o58_anousu = e60_anousu
inner join orcunidade on orcdotacao.o58_orgao=orcunidade.o41_orgao  
AND orcdotacao.o58_anousu=orcunidade.o41_anousu 
AND orcdotacao.o58_unidade=orcunidade.o41_unidade
inner join conplanoorcamento on c60_codcon = orcdotacao.o58_codele and c60_anousu=date_part('year',c70_data)
inner join conlancamdoc on c71_codlan=c70_codlan inner join conhistdoc on c71_coddoc=c53_coddoc
inner join cgm on cgm.z01_numcgm = empempenho.e60_numcgm
inner join orcelemento ele on ele.o56_codele=conlancamele.c67_codele and ele.o56_anousu = o58_anousu
where o58_instit=".db_getsession("DB_instit")."
and empempenho.e60_instit=".db_getsession("DB_instit")."
{$where}
and conhistdoc.c53_tipo in (10,20,30,11,21,31)
and o58_anousu=date_part('year',c70_data)
group by o58_codele, c60_estrut, c60_descr, o56_elemento, o56_descr, z01_nome,e60_codemp
order by o56_elemento
) x order by Elemento
";

$result = db_query($sql);
//db_criatabela($result);echo $sql;exit;

if (pg_num_rows($result) == 0) {
?>
  <table width='100%'>
    <tr>
      <td align='center'>
        <font color='#FF0000' f$dIniace='arial'>
          <b>Nenhum registro encontrado.<br>
            <input type='button' value='Fechar' onclick='window.close()'>
          </b>
        </font>
      </td>
    </tr>
  </table>
<?
  exit;
}

$sql = "select o40_orgao,o40_descr,o41_unidade,o41_descr from orcunidade
inner join orcorgao on o41_anousu=o40_anousu and o41_orgao=o40_orgao
where o41_anousu = ".db_getsession("DB_anousu")." and o41_orgao={$iOrgao} and o41_unidade={$iUnidade}";
$resultUnidade = db_query($sql);
$oUnidade = db_utils::fieldsMemory($resultUnidade, 0);

$head1 = 'Demonstrativo mensal por desdobramento';
$head2 = '';
if ($dIni != ''){
  $head3 = 'Período: '.$dIni.' a '.$dFim;
}

if ($iUnidade != ''){
  $head4 = '';
  $head5 = "Orgão: {$oUnidade->o40_orgao} - {$oUnidade->o40_descr}";
  $head6 = "Unidade: {$oUnidade->o41_unidade} - {$oUnidade->o41_descr}";
}

$oPdf  = new PDF();
$oPdf->Open();
$oPdf->AliasNbPages();
//$oPdf->Addpage('L');

$oPdf->setfillcolor(223);
$oPdf->setfont('arial','',11);
$iTotal = 0;
$sElemento      = '';
$sDesdobramento = '';

$nTdEmLiq    = 0;
$nTdLiq      = 0;
$nTdPagto    = 0;

$nEmLiq      = 0;
$nLiq        = 0;
$nPagto      = 0;

$nTotalEmLiq = 0;
$nTotalLiq   = 0;
$nTotalPagto = 0;

for ($iCont = 0; $iCont < pg_num_rows($result); $iCont++) {

  $oDados = db_utils::fieldsmemory($result, $iCont);
  
  if ($oDados->desdobramento != $sDesdobramento && $sDesdobramento != '') {
  	
  	if ($oPdf->getY() >$oPdf->h - 35) {
      $oPdf->Addpage('L');
  	}
  	novoRodapeDesdobramento($oPdf, $nTdEmLiq, $nTdLiq, $nTdPagto);
    $nTdEmLiq      = 0;
    $nTdLiq        = 0;
    $nTdPagto      = 0;	
  }
  
  if ($oPdf->getY() >$oPdf->h - 40 || $iTotal == 0) {

    $oPdf->Addpage('L');
    if ($iTotal > 0 || $sElemento == '') {
    	novoCabecalho($oPdf,$oDados->elemento);
    }

  } else if ($oDados->elemento != $sElemento) {
  	
    novoRodapeElemento($oPdf, $nEmLiq, $nLiq, $nPagto);
    $nEmLiq      = 0;
    $nLiq        = 0;
    $nPagto      = 0;
    if ($iTotal > 0) $oPdf->ln();
    novoCabecalho($oPdf,$oDados->elemento);
    
  }

  if ($oPdf->getY() >$oPdf->h - 35) {
    $oPdf->Addpage('L');
  }
  novaLinha($oPdf, $oDados->desdobramento,$oDados->z01_nome,$oDados->e60_codemp,$oDados->totalemp,$oDados->totalliq,$oDados->totalpag);
  
  $nTdEmLiq += $oDados->totalemp;
  $nTdLiq   += $oDados->totalliq;
  $nTdPagto += $oDados->totalpag;
  
  $nEmLiq += $oDados->totalemp;
  $nLiq   += $oDados->totalliq;
  $nPagto += $oDados->totalpag;
  
  $iTotal += 1;
  
  $nTotalEmLiq += $oDados->totalemp;
  $nTotalLiq   += $oDados->totalliq;
  $nTotalPagto += $oDados->totalpag;
   
  $sElemento      = $oDados->elemento;
  $sDesdobramento = $oDados->desdobramento;

}
novoRodapeDesdobramento($oPdf, $nTdEmLiq, $nTdLiq, $nTdPagto);
novoRodapeElemento($oPdf, $nEmLiq, $nLiq, $nPagto);

$oPdf->ln();
novoRodape($oPdf, $nTotalEmLiq, $nTotalLiq, $nTotalPagto);

$oPdf->Output();