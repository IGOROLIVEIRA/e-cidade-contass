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

function novoCabecalho($oPdf, $sFornecedor) {

  $lCor = true;
  $iTam = 5;
  $oPdf->setfont('arial', 'B', 9);
  
  $oPdf->cell(280, $iTam, "Fornecedor: ".substr($sFornecedor, 0, 35) , 1, 1, 'L', $lCor);
  
  $oPdf->cell(30, $iTam, 'Empenho', 1, 0, 'C', $lCor);
  $oPdf->cell(30, $iTam, 'Ordem de Compra', 1, 0, 'C', $lCor);
  $oPdf->cell(30, $iTam, 'Nota Fiscal', 1, 0, 'C', $lCor);
  $oPdf->cell(32, $iTam, 'Valor em Liquidação', 1, 0, 'C', $lCor);
  $oPdf->cell(32, $iTam, 'Data em Liquidação', 1, 0, 'C', $lCor);
  $oPdf->cell(32, $iTam, 'Valor Liquidado', 1, 0, 'C', $lCor);
  $oPdf->cell(31, $iTam, 'Data Liquidado', 1, 0, 'C', $lCor);
  $oPdf->cell(32, $iTam, 'Valor Pago', 1, 0, 'C', $lCor);
  $oPdf->cell(31, $iTam, 'Data Pagamento', 1, 1, 'C', $lCor);

}

function novaLinha($oPdf, $sEmpenho, $iOrdemCompra,$sNotaFiscal, $nVlEmLiquid,$dDtEmLiquid,$nVlLiquid,$dDtLiquid,$nVlPagto,$dDtPagto) {

  $lCor = false;
  $iTam = 5;
  $oPdf->setfont('arial', '', 9);

  $dDtEmLiquid = implode("/", array_reverse(explode("-", $dDtEmLiquid)));
  $dDtLiquid   = implode("/", array_reverse(explode("-", $dDtLiquid)));
  $dDtPagto    = implode("/", array_reverse(explode("-", $dDtPagto)));
  
  $oPdf->cell(30, $iTam, $sEmpenho, 1, 0, 'C', $lCor);
  $oPdf->cell(30, $iTam, $iOrdemCompra, 1, 0, 'C', $lCor);
  $oPdf->cell(30, $iTam, $sNotaFiscal, 1, 0, 'C', $lCor);
  $oPdf->cell(32, $iTam, $nVlEmLiquid != '' ? "R$ ".db_formatar($nVlEmLiquid, "f") : '', 1, 0, 'C', $lCor);
  $oPdf->cell(32, $iTam, $dDtEmLiquid, 1, 0, 'C', $lCor);
  $oPdf->cell(32, $iTam, $nVlLiquid != '' ? "R$ ".db_formatar($nVlLiquid, "f") : '', 1, 0, 'C', $lCor);
  $oPdf->cell(31, $iTam, $dDtLiquid, 1, 0, 'C', $lCor);
  $oPdf->cell(32, $iTam, $nVlPagto != '' ? "R$ ".db_formatar($nVlPagto, "f") : '', 1, 0, 'C', $lCor);
  $oPdf->cell(31, $iTam, $dDtPagto, 1, 1, 'C', $lCor);

}

function novoRodapeFornecedor($oPdf, $nEmLiq,$nLiq,$nPagto) {

  $lCor = true;
  $iTam = 5;
  $oPdf->setfont('arial', 'B', 9);
  
  $oPdf->cell(90, $iTam, ""  , 1, 0, 'L', $lCor);
  $oPdf->cell(64, $iTam, "Em Liquidação: R$ ".db_formatar($nEmLiq, "f")  , 1, 0, 'L', $lCor);
  $oPdf->cell(63, $iTam, "Liquidado: R$ ".db_formatar($nLiq, "f") , 1, 0, 'L', $lCor);
  $oPdf->cell(63, $iTam, "Pago: R$ ".db_formatar($nPagto, "f") , 1, 1, 'L', $lCor);

}

function novoRodape($oPdf, $nTotalEmLiq,$nTotalLiq,$nTotalPagto) {

  $lCor = true;
  $iTam = 5;
  $oPdf->setfont('arial', 'B', 9);
  
  $oPdf->cell(91, $iTam, ""  , 0, 0, 'L', 0);
  $oPdf->cell(64, $iTam, "Total Em Liquidação: R$ ".db_formatar($nTotalEmLiq, "f")  , 0, 0, 'L', 0);
  $oPdf->cell(63, $iTam, "Total Liquidado: R$ ".db_formatar($nTotalLiq, "f") , 0, 0, 'L', 0);
  $oPdf->cell(63, $iTam, "Total Pago: R$ ".db_formatar($nTotalPagto, "f") , 0, 1, 'L', 0);

}

$dDataIni = implode("-", array_reverse(explode("/", $dIni)));
$dDataFim = implode("-", array_reverse(explode("/", $dFim)));
$aDataFim = explode("-", $dDataFim);
$aDataIni = explode("-", $dDataIni);
$iMesFim  = $aDataFim['1'];
$iAnoFim  = $aDataFim['0'];
$iMesIni  = $aDataIni['1'];
$iAnoIni  = $aDataIni['0'];

$where = "1=1";
if ($dIni != ''){
	$where .= " and ((k12_data >= '{$dDataIni}' and k12_data <= '{$dDataFim}')";
	$where .= " or (e50_data >= '{$dDataIni}' and e50_data <= '{$dDataFim}')";
	$where .= " or (e69_dtrecebe >= '{$dDataIni}' and e69_dtrecebe <= '{$dDataFim}'))";
}
if ($aFornecedor != ''){
	$where .= " and z01_numcgm in ({$aFornecedor})";
}

$sql = "select *  from (
select distinct on (e69_numero)
z01_nome as fornecedor,
m51_codordem as numerodaordem,
e60_codemp as numeroempenho,
e69_numero as numnota,
(case when (date_part('MONTH', e69_dtrecebe) between {$iMesIni} and {$iMesFim}) and (date_part('YEAR', e69_dtrecebe) between {$iAnoIni} and {$iAnoFim}) then 
(select sum(m52_valor) from matordemitem where m52_codordem=matordem.m51_codordem) 
else null end) as vlemliquidacao,
(case when (date_part('MONTH', e69_dtrecebe) between {$iMesIni} and {$iMesFim}) and (date_part('YEAR', e69_dtrecebe) between {$iAnoIni} and {$iAnoFim}) then e69_dtrecebe else null end) as dataemliquidacao, 
(case when (date_part('MONTH', e50_data) between {$iMesIni} and {$iMesFim}) and (date_part('YEAR', e50_data) between {$iAnoIni} and {$iAnoFim}) then e70_vlrliq else null end) as valorliquidado,
(case when (date_part('MONTH', e50_data) between {$iMesIni} and {$iMesFim}) and (date_part('YEAR', e50_data) between {$iAnoIni} and {$iAnoFim}) then e50_data else null end) as dataliquidacao, 
(case when (date_part('MONTH', k12_data) between {$iMesIni} and {$iMesFim}) and (date_part('YEAR', k12_data) between {$iAnoIni} and {$iAnoFim}) then e53_vlrpag else null end) as valorpago,
(case when (date_part('MONTH', k12_data) between {$iMesIni} and {$iMesFim}) and (date_part('YEAR', k12_data) between {$iAnoIni} and {$iAnoFim}) then k12_data else null end) as datapagamento 
from matordem
inner join empnotaord on empnotaord.m72_codordem = matordem.m51_codordem
inner join empnota on empnota.e69_codnota = empnotaord.m72_codnota
inner join cgm on cgm.z01_numcgm=matordem.m51_numcgm
left join empnotaele on empnotaele.e70_codnota = empnota.e69_codnota
left join pagordemnota on e70_codnota = e71_codnota and e71_anulado is false
left join pagordemele on e71_codord = e53_codord 
left join pagordem on e50_codord = e53_codord
left join empord on empord.e82_codord = pagordem.e50_codord
left join empagemov on empagemov.e81_codmov = empord.e82_codmov
left join empage on empage.e80_codage = empagemov.e81_codage
left join corempagemov on corempagemov.k12_codmov = empagemov.e81_codmov
inner join matordemitem on matordemitem.m52_codordem = matordem.m51_codordem
left join conlancamord on conlancamord.c80_codord = pagordem.e50_codord
left join conlancam on conlancam.c70_codlan = conlancamord.c80_codlan
left join conlancamdoc on conlancamdoc.c71_codlan = conlancam.c70_codlan
left join conhistdoc on conhistdoc.c53_coddoc = conlancamdoc.c71_coddoc
inner join empempenho on empempenho.e60_numemp = empnota.e69_numemp
where {$where}
and ((e70_vlranu!=e70_vlrliq and e53_vlranu!=e53_vlrpag) OR e53_vlranu=0)
) x order by fornecedor
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

$head1 = 'Movimentação de Notas';
$head2 = '';
if ($dIni != ''){
  $head3 = 'Período: '.$dIni.' a '.$dFim;
}

$oPdf  = new PDF();
$oPdf->Open();
$oPdf->AliasNbPages();
//$oPdf->Addpage('L');

$oPdf->setfillcolor(223);
$oPdf->setfont('arial','',11);
$iTotal = 0;
$sNome = '';

$nEmLiq      = 0;
$nLiq        = 0;
$nPagto      = 0;
$nTotalEmLiq = 0;
$nTotalLiq   = 0;
$nTotalPagto = 0;

for ($iCont = 0; $iCont < pg_num_rows($result); $iCont++) {

  $oDados = db_utils::fieldsmemory($result, $iCont);
  
  if ($oPdf->getY() >$oPdf->h - 35 || $iTotal == 0) {

    $oPdf->Addpage('L');
    if ($iTotal > 0 || $sNome == '') {
    	novoCabecalho($oPdf,$oDados->fornecedor);
    }

  } else if ($oDados->fornecedor != $sNome) {
  	
    novoRodapeFornecedor($oPdf, $nEmLiq, $nLiq, $nPagto);
    $nEmLiq      = 0;
    $nLiq        = 0;
    $nPagto      = 0;
    if ($iTotal > 0) $oPdf->ln();
    novoCabecalho($oPdf,$oDados->fornecedor);
    
  }
    
  novaLinha($oPdf, $oDados->numeroempenho,$oDados->numerodaordem,
    $oDados->numnota,$oDados->vlemliquidacao,$oDados->dataemliquidacao,$oDados->valorliquidado,$oDados->dataliquidacao,$oDados->valorpago,$oDados->datapagamento);
  
  $nEmLiq += $oDados->vlemliquidacao;
  $nLiq   += $oDados->valorliquidado;
  $nPagto += $oDados->valorpago;
  $iTotal += 1;
  $nTotalEmLiq += $oDados->vlemliquidacao;
  $nTotalLiq   += $oDados->valorliquidado;
  $nTotalPagto += $oDados->valorpago;
   
  $sNome   = $oDados->fornecedor;

}
novoRodapeFornecedor($oPdf, $nEmLiq, $nLiq, $nPagto);

$oPdf->ln();
novoRodape($oPdf, $nTotalEmLiq, $nTotalLiq, $nTotalPagto);

$oPdf->Output();