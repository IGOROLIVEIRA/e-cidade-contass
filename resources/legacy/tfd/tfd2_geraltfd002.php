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

function novoCabecalho($oPdf, $sPaciente,$sTelefone,$sEndereco,$iNumero,$sBairro,$sMunicipio,$sUf,$sPrestadora) {

  $lCor = true;
  $iTam = 5;
  $oPdf->setfont('arial', 'B', 9);
  
  $oPdf->cell(130, $iTam, "Paciente: ".substr($sPaciente, 0, 35) , 1, 0, 'L', $lCor);
  $oPdf->cell(150, $iTam, "Prestadora: ".$sPrestadora , 1, 1, 'L', $lCor);
  
  $oPdf->cell(250, $iTam, "Endereço: ".
  substr($sEndereco.' '.$iNumero.' '.$sBairro.' '.$sMunicipio.' - '.$sUf,0 ,80) 
  , 1, 0, 'L', $lCor);
  $oPdf->cell(30, $iTam, "Fone: ".$sTelefone , 1, 1, 'L', $lCor);
  
  $oPdf->cell(40, $iTam, 'Tipo Tratamento', 1, 0, 'C', $lCor);
  $oPdf->cell(100, $iTam, 'Procedimento', 1, 0, 'C', $lCor);
  $oPdf->cell(80, $iTam, 'Especialidade', 1, 0, 'C', $lCor);
  $oPdf->cell(30, $iTam, 'Data e Hora', 1, 0, 'C', $lCor);
  $oPdf->cell(30, $iTam, 'Valor', 1, 1, 'C', $lCor);

}

function novaLinha($oPdf, $sTipo, $sEspecialidade,$dData, $tHora,$nNalor,$sProcedimento) {

  $lCor = false;
  $iTamFixo = 5;
  $oPdf->setfont('arial', '', 9);

  $aProcedimento = quebrar_texto($sProcedimento,48);
  $aEspecialidade = quebrar_texto($sEspecialidade, 40);
  if (count($aProcedimento) > count($aEspecialidade)) {
    $iTam = $iTamFixo*(count($aProcedimento));
  } else {
  	$iTam = $iTamFixo*(count($aEspecialidade));
  }
  
  $nNalor != '' ? $nNalor = "R$".db_formatar($nNalor, "f") : '';
  $dData = implode("/", array_reverse(explode("-", $dData)));
  $oPdf->cell(40, $iTam, substr($sTipo,0,25), 1, 0, 'L', $lCor);
  
  if (strlen($sProcedimento) > 48) {
		multiCell($oPdf, $aProcedimento, $iTamFixo, $iTam, 100);
  } else {
	  $oPdf->cell(100, $iTam, $sProcedimento, 1, 0, 'L', $lCor);
	}
  
  if (strlen($sEspecialidade) > 40) {
		multiCell($oPdf, $aEspecialidade, $iTamFixo, $iTam, 80);
  } else {
	  $oPdf->cell(80, $iTam, $sEspecialidade, 1, 0, 'L', $lCor);
	}
  
  $oPdf->cell(30, $iTam, "{$dData} / {$tHora}", 1, 0, 'L', $lCor);
  $oPdf->cell(30, $iTam, $nNalor, 1, 1, 'L', $lCor);

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

function novoRodape($oPdf, $nTotalValor,$iTotal) {

  $lCor = true;
  $iTam = 5;
  $oPdf->setfont('arial', 'B', 9);
  
  $oPdf->cell(130, $iTam, "Total de Registros: {$iTotal}" , 1, 0, 'L', $lCor);
  $oPdf->cell(150, $iTam, "Total de Valores: R$ ".db_formatar($nTotalValor, "f") , 1, 1, 'L', $lCor);

}

$dDataIni = implode("-", array_reverse(explode("/", $dIni)));
$dDataFim = implode("-", array_reverse(explode("/", $dFim)));
$where = "1=1";
if ($dIni != ''){
	$where .= " and tf16_d_dataagendamento >= '{$dDataIni}'";
}
if ($dFim != ''){
	$where .= " and tf16_d_dataagendamento <= '{$dDataFim}'";
}
if ($iPrestadora != ''){
	$where .= " and tf10_i_prestadora = {$iPrestadora}";
}
if ($iEspecialidade != ''){
	$where .= " and tf01_i_rhcbo = {$iEspecialidade}";
}
if ($iTipo != 0){
	$where .= " and tf01_i_tipotratamento = {$iTipo}";
}
if ($aProcedimento != 'null') {
	$where .= " and tf23_i_procedimento in ({$aProcedimento})";
}
if ($sFaturaBPA == 't' || $sFaturaBPA == 'f') {
	$where .= " and tf12_faturabpa = '{$sFaturaBPA}'";
}
if ($iPaciente != '') {
	$where .= " and tf01_i_cgsund = $iPaciente";
}

$sql = "select
tf04_c_descr,
z01_v_nome,
rh70_descr,
tf16_d_dataagendamento,
tf16_c_horaagendamento,
z01_v_telef,
z01_v_ender,
z01_i_numero,
z01_v_bairro,
z01_v_munic,
z01_v_uf,
(select round(tf15_f_valoremitido, 2) AS tf15_f_valoremitido 
from tfd_beneficiadosajudacusto 
join tfd_ajudacusto ON tfd_ajudacusto.tf12_i_codigo = tfd_beneficiadosajudacusto.tf15_i_ajudacusto
where tfd_beneficiadosajudacusto.tf15_i_ajudacustopedido = tfd_ajudacustopedido.tf14_i_codigo
AND tfd_ajudacusto.tf12_i_procedimento = sau_procedimento.sd63_i_codigo limit 1) AS tf15_f_valoremitido,
sd63_c_nome,
z01_nome
from sau_procedimento 
join tfd_procpedidotfd on tfd_procpedidotfd.tf23_i_procedimento = sau_procedimento.sd63_i_codigo
join tfd_pedidotfd on tfd_pedidotfd.tf01_i_codigo = tfd_procpedidotfd.tf23_i_pedidotfd
join tfd_tipotratamento on tfd_pedidotfd.tf01_i_tipotratamento = tfd_tipotratamento.tf04_i_codigo
join cgs_und on tfd_pedidotfd.tf01_i_cgsund = cgs_und.z01_i_cgsund
join rhcbo on tf01_i_rhcbo = rhcbo.rh70_sequencial
join tfd_agendamentoprestadora on tfd_agendamentoprestadora.tf16_i_pedidotfd = tfd_pedidotfd.tf01_i_codigo
join tfd_prestadoracentralagend on tfd_prestadoracentralagend.tf10_i_codigo = tfd_agendamentoprestadora.tf16_i_prestcentralagend
join tfd_prestadora on tfd_prestadora.tf25_i_codigo = tfd_prestadoracentralagend.tf10_i_prestadora
join cgm on cgm.z01_numcgm = tfd_prestadora.tf25_i_cgm
LEFT JOIN tfd_ajudacustopedido ON tfd_pedidotfd.tf01_i_codigo = tfd_ajudacustopedido.tf14_i_pedidotfd
 where {$where}
order by z01_v_nome";

if ($iZerados == 'f') {
	$sql = "select * FROM ( $sql ) as x where tf15_f_valoremitido > 0 ";
} else if ($iZerados == 't') {
	$sql = "select * FROM ( $sql ) as x where tf15_f_valoremitido = 0 OR tf15_f_valoremitido IS NULL ";
}

$result = db_query($sql);//echo $sql;exit;
//db_criatabela($result);

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

$head1 = 'Relatório Geral TFD';
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
$nTotalValor = 0;
$sNome = '';
for ($iCont = 0; $iCont < pg_num_rows($result); $iCont++) {

  $oDados = db_utils::fieldsmemory($result, $iCont);
  
  if ($oPdf->getY() >$oPdf->h - 35 || $iTotal == 0) {

    $oPdf->Addpage('L');
    if ($iTotal > 0 || $sNome == '') {
    	novoCabecalho($oPdf,$oDados->z01_v_nome,$oDados->z01_v_telef,$oDados->z01_v_ender,
      $oDados->z01_i_numero,$oDados->z01_v_bairro,$oDados->z01_v_munic,$oDados->z01_v_uf,$oDados->z01_nome);
    }

  } else if ($oDados->z01_v_nome != $sNome) {
  	if ($iTotal > 0) $oPdf->ln();
    novoCabecalho($oPdf,$oDados->z01_v_nome,$oDados->z01_v_telef,$oDados->z01_v_ender,
    $oDados->z01_i_numero,$oDados->z01_v_bairro,$oDados->z01_v_munic,$oDados->z01_v_uf,$oDados->z01_nome);
  }
    
  novaLinha($oPdf, $oDados->tf04_c_descr, $oDados->rh70_descr,$oDados->tf16_d_dataagendamento, $oDados->tf16_c_horaagendamento, 
  $oDados->tf15_f_valoremitido,$oDados->sd63_c_nome);
  
  $iTotal += 1;
  $nTotalValor += $oDados->tf15_f_valoremitido; 
  $sNome   = $oDados->z01_v_nome;

}
$oPdf->ln();
novoRodape($oPdf, $nTotalValor, $iTotal);

$oPdf->Output();
