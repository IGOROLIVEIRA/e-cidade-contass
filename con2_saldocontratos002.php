<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
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

require_once("fpdf151/pdf.php");
require_once("libs/db_utils.php");
require_once("classes/db_acordo_classe.php");
require_once("model/Acordo.model.php");
require_once("model/AcordoComissao.model.php");
require_once("model/AcordoItem.model.php");
require_once("model/AcordoPosicao.model.php");
require_once("model/AcordoRescisao.model.php");
require_once("model/AcordoMovimentacao.model.php");
require_once("model/AcordoComissaoMembro.model.php");
require_once("model/AcordoGarantia.model.php");
require_once("model/AcordoHomologacao.model.php");
require_once("model/MaterialCompras.model.php");
require_once("model/CgmFactory.model.php");
db_postmemory($HTTP_GET_VARS);


$sWhere = " where ac26_sequencial = (select max(ac26_sequencial) from acordoposicao where ac26_acordo = ac16_sequencial) ";
$sOrder = " ORDER BY ac16_sequencial, ac26_sequencial, ac20_ordem, ";

if($iAgrupamento == 1){
  //selecionado o filtro acordos
  if(isset($ac16_sequencial) && $ac16_sequencial!=""){
    $sWhere .= "AND ac26_sequencial =
    (SELECT max(ac26_sequencial)
    FROM acordoposicao
    WHERE ac26_acordo = '$ac16_sequencial') ";
  }



}else{
/*
 * Filtro pelo departamento de Inclusão
 * */

    if(isset($sDepartsInclusao)){
        $sWhere .= $sWhere ? ' AND ' : ' ';
        $sWhere .= ' ac16_coddepto in ('.$sDepartsInclusao.') ';
    }

    /*
    * Filtro pelo departamento Responsável
    * */

    if(isset($sDepartsInclusao)){
        $sWhere .= $sWhere ? ' AND ' : ' ';
        $sWhere .= ' ac16_deptoresponsavel in ('.$sDepartsResponsavel.') ';
    }


}
if(isset($ac02_acordonatureza) && $ac02_acordonatureza!=""){
  $sWhere .= " AND ac16_acordogrupo = '$ac02_acordonatureza' ";
}
if(isset($ac16_datainicio) && $ac16_datainicio!=""){
  $ac16_datainicio = $ac16_datainicio_ano.'-'.$ac16_datainicio_mes.'-'.$ac16_datainicio_dia;
  $sWhere .= " AND ac16_datainicio >= '$ac16_datainicio'".'::date ';
}
if(isset($ac16_datafim) && $ac16_datafim!=""){
  $ac16_datafim = $ac16_datafim_ano.'-'.$ac16_datafim_mes.'-'.$ac16_datafim_dia;
  $sWhere .= " AND ac16_datafim <= '$ac16_datafim'".'::date ';
}
switch ($ordem) {
  case '1':
  $sOrder .= " ac16_datafim ";
  break;

  case '2':
  $sOrder .= " ac16_contratado ";
  break;

  case '3':
  $sOrder .= " ac16_numero ";
  break;

  case '4':
  $sOrder .= " ac16_sequencial ";
  break;
}

$sSql = "SELECT
ac16_sequencial as acordo,
ac26_sequencial as posicao_acordo,
ac29_acordoitem as item,
l20_edital as licitacao,
ac02_descricao as natureza,
z01_nome as nome_contratado,
descrdepto as departamento,
coddepto as codigo_dpto,
ac26_data as data_posicao,
ac16_datainicio as datainicio,
ac16_datafim as datafim,
pc01_codmater as codigomaterial,
pc01_descrmater as material,
ac20_quantidade as qtd_total,
ac20_valorunitario as vlrunitario,
ac20_valortotal as total,
ac16_valor as valor_contrato,
l20_anousu as ano_processo_licitatorio,
ac16_numero,
ac16_anousu,
ac16_dataassinatura,

coalesce(sum(CASE WHEN ac29_tipo = 1 THEN ac29_valor END), 0) AS valorAutorizado,
coalesce(sum(CASE WHEN ac29_tipo = 1 THEN ac29_quantidade END), 0) AS quantidadeautorizada,
coalesce(sum(CASE WHEN ac29_tipo = 1 THEN (ac20_quantidade - ac29_quantidade) END), 0) AS restante,
coalesce(sum(CASE WHEN ac29_tipo = 2 THEN ac29_valor END),0) AS valorExecutado,
coalesce(sum(CASE WHEN ac29_tipo = 2 THEN ac29_quantidade END),0) AS quantidadeexecutada,
coalesce(sum(CASE WHEN ac29_tipo = 1
AND ac29_automatico IS FALSE THEN ac29_valor END), 0) AS valorAutorizadoManual,
coalesce(sum(CASE WHEN ac29_tipo = 1
AND ac29_automatico IS FALSE THEN ac29_quantidade END), 0) AS quantidadeautorizadaManual

FROM acordoitem
LEFT JOIN acordoitemexecutado ON ac29_acordoitem = ac20_sequencial
JOIN acordoposicao ON ac20_acordoposicao = ac26_sequencial
JOIN acordo ON ac16_sequencial = ac26_acordo
JOIN pcmater ON pc01_codmater = ac20_pcmater
JOIN db_depart ON coddepto = ac16_deptoresponsavel
JOIN cgm ON ac16_contratado = z01_numcgm
LEFT JOIN liclicita ON l20_codigo = ac16_licitacao
LEFT JOIN acordogrupo ON ac16_acordogrupo = ac02_sequencial
JOIN acordocategoria ON ac16_acordocategoria = ac50_sequencial".$sWhere." GROUP BY
ac20_quantidade,
ac20_valorunitario,
ac20_valortotal,
ac16_datainicio,
ac16_valor,
ac16_dataassinatura,
ac16_licitacao,
ac16_datafim,
z01_nome,
pc01_descrmater,
descrdepto,
ac29_acordoitem,
ac16_sequencial,
ac26_sequencial,
ac26_data,
coddepto,
pc01_codmater,
l20_edital,
l20_anousu,
ac02_descricao,
ac16_numero,
ac16_anousu,
ac20_ordem ".$sOrder;

$materiais = db_utils::getColectionByRecord(db_query($sSql));

if(pg_num_rows(db_query($sSql)) > 0){
}else{
  db_redireciona("db_erros.php?fechar=true&db_erro=Nenhum registro encontrado!");
}

$oPost               = db_utils::postMemory($_POST);
$sAcordo             = 'Todos';
$sDataInicio         = ' / / ';
$sDataFim            = ' / / ';
$sOrdemDescricao     = '';
//$head2 = "Acordo: ";
$head4 = "Relatório de Saldo de Contratos";
//$head6 = "Ordem: ";
//$head7   = "CATEGORIA: ";

$oPdf  = new PDF();
$oPdf->Open();
$oPdf->AliasNbPages();
$oPdf->SetTextColor(0,0,0);
$oPdf->SetFillColor(220);
$oPdf->SetAutoPageBreak(false);

$iFonte     = 9;
$iAlt       = 6 ;
$lImprime   = true;
$lPreencher = false;
$total=0;
$i=0;
$j=0;
$valorImprime=0;
$acordo = "";
$oPdf->AddPage('L');

foreach ($materiais as $material) {
  /*if($acordo!=$material->acordo){
    $lImprime = true;
  }else{
    $lImprime = false;
  }

  if($oPdf->GetY() > 190){
    $lImprime = true;
    $oPdf->AddPage('L');
  }else{
    $lImprime = false;
  }
  if($acordo!=$material->acordo){
    $lImprime = true;
  }else if($oPdf->GetY() < 190){
    $lImprime = false;
  }*/
  if($acordo!=$material->acordo){

    $lImprime = true;
    if($oPdf->GetY() > 190 || ($oPdf->GetY() + 50) > $oPdf->h){
      $oPdf->AddPage('L');
    }
  }else{
    if($oPdf->GetY() > 190){
      $oPdf->AddPage('L');
      $lImprime = true;
    }
    if($i==0){
      $lImprime = true;
    }
    else{
     $lImprime = false;
    }
  }
  imprimirCabecalhoAcordos($oPdf, $iFonte, $iAlt, $lImprime, $material, $total, $i, $j);
  if($acordo!=$material->acordo){
    $total=($material->total-$material->valorautorizado);
    $acordo = $material->acordo;
    $j=0;
  }else{
    $total = $total+($material->total-$material->valorautorizado);
  }

  if ($lPreencher == true) {

    $lPreencher   = false;
    $iCorFundo    = 1;
    $oPdf->SetFillColor(240);
  } else {

    $lPreencher   = true;
    $iCorFundo    = 0;
    $oPdf->SetFillColor(220);
  }

  $oPdf->SetFont('Arial','',$iFonte-1);
  $ivalorTotal = 'R$' . number_format($material->total, 2, ',', '.');
  if($material->valorautorizado < ($material->vlrunitario*$material->quantidadeautorizada)){
    if(($material->valorautorizado/$material->vlrunitario)<1){
      $iquantidadeDisponivel = $material->qtd_total;
    }else{
      $iquantidadeDisponivel = $material->qtd_total - floor(($material->valorautorizado/$material->vlrunitario));

    }
  }else{

    $iquantidadeDisponivel = ($material->qtd_total - $material->quantidadeautorizada);
  }
  $ivalorDisponivel = 'R$' . number_format(($material->total-$material->valorautorizado),2,',','.');
  $oPdf->Cell(25 ,$iAlt,$material->codigomaterial,'TBR',0,'C',$iCorFundo);
  $oPdf->Cell(150 ,$iAlt,$material->material,'TBR',0,'C',$iCorFundo);
  $oPdf->Cell(25 ,$iAlt,$material->qtd_total,'TBR',0,'C',$iCorFundo);
  $oPdf->Cell(25 ,$iAlt,$ivalorTotal,'TBR',0,'C',$iCorFundo);
  $oPdf->Cell(30 ,$iAlt,$iquantidadeDisponivel,'TBR',0,'C',$iCorFundo);
  $oPdf->Cell(25 ,$iAlt,$ivalorDisponivel,'TBR',0,'C',$iCorFundo);
  $oPdf->Ln();
  $i++;
  $j++;

}

$oPdf->SetFont('Arial','B',$iFonte);
$oPdf->Cell(225 ,$iAlt,'',0,0,'L',0);
$oPdf->Cell(30 ,$iAlt,'Total: ',1,0,'C',0);
$oPdf->Cell(25 ,$iAlt,'R$' . number_format($total, 2, ',', '.'),1,0,'C',0);
$oPdf->Ln();
$oPdf->Cell(278 ,$iAlt-3,'',0,1,'C',0);
$oPdf->Cell(34 ,$iAlt,'Total de Registros:',0,0,'L',0);
$oPdf->Cell(30 ,$iAlt,''.count($materiais).'',0,0,'L',0);
$oPdf->Ln();
$oPdf->SetFont('Arial','',9);
$Espaco = $oPdf->w - 80 ;
$margemesquerda = $oPdf->lMargin;
$oPdf->setleftmargin($Espaco+5);
$oPdf->sety(6);
$oPdf->setfillcolor(235);
$oPdf->roundedrect($Espaco - 3,5,75,28,2,'DF','123');
$oPdf->line(10,33,$comprim,33);
$oPdf->setfillcolor(255);

$oPdf->multicell(0,3,@$GLOBALS["head1"],0,"J",0);
$oPdf->multicell(0,3,@$GLOBALS["head2"],0,"J",0);
$oPdf->multicell(0,3,@$GLOBALS["head3"],0,"J",0);
$oPdf->multicell(0,3,@$GLOBALS["head4"],0,"J",0);
$oPdf->multicell(0,3,@$GLOBALS["head5"],0,"J",0);
$oPdf->multicell(0,3,@$GLOBALS["head6"],0,"J",0);
$oPdf->multicell(0,3,@$GLOBALS["head7"],0,"J",0);
$oPdf->multicell(0,3,@$GLOBALS["head8"],0,"J",0);
$oPdf->multicell(0,3,@$GLOBALS["head9"],0,"J",0);

$oPdf->setleftmargin($margemesquerda);
$oPdf->SetY(35);
$oPdf->Output();

/*
 * Monta Cabecalho dos Arcordos
 */
function imprimirCabecalhoAcordos($oPdf, $iFonte, $iAlt, $lImprime, $material, $total,$i,$j) {

  if ($lImprime) {

    $oPdf->SetFont('Arial','B',$iFonte);
    $oPdf->SetFillColor(220);

    if($i!=0){
      $oPdf->Cell(225 ,$iAlt,'Total de itens: '.$j,0,0,'L',0);
      $oPdf->Cell(30 ,$iAlt,'Total: ',1,0,'C',0);
      $oPdf->Cell(25 ,$iAlt,'R$' . number_format($total, 2, ',', '.'),1,0,'C',0);
      $oPdf->Ln();
      $oPdf->Ln();

    }

    $oPdf->Cell(50 ,$iAlt,'Cód. do Acordo: '.$material->acordo,0,0,'L',0);
    $oPdf->Cell(150 ,$iAlt,'Departamento Responsável: '.$material->departamento,0,0,'L',0);
    $oPdf->Cell(80 ,$iAlt,'Data de Assinatura: '.(($material->ac16_dataassinatura != null && $material->ac16_dataassinatura != "") ? date("d/m/Y", strtotime($material->ac16_dataassinatura)):'Não informado'),0,0,'L',0);

    $oPdf->Ln();
    $oPdf->Cell(50 ,$iAlt,'Nº Contrato: '.$material->ac16_numero.'/'.$material->ac16_anousu/*date("m/Y", strtotime($material->data_posicao))*/,0,0,'L',0);

    $oPdf->Cell(150 ,$iAlt,'Vigência: '.date("d/m/Y", strtotime($material->datainicio)).' a '.date("d/m/Y", strtotime($material->datafim)),0,0,'L',0);

    $oPdf->Cell(100 ,$iAlt,'Natureza: '.$material->natureza,0,0,'L',0);

    $oPdf->Ln();
    $oPdf->Cell(200 ,$iAlt,'Contratado: '.$material->nome_contratado,0,0,'L',0);
    if($material->licitacao != ""){
      $oPdf->Cell(50 ,$iAlt,'Processo Licitatorio: '.$material->licitacao.'/'.$material->ano_processo_licitatorio,0,0,'L',0);
    }

    $oPdf->Ln();
    $oPdf->Ln();
    if($oPdf->GetY() > 190){
      $oPdf->AddPage('L');
    }
    $oPdf->Cell(25 ,$iAlt,'Código',1,0,'C',1);
    $oPdf->Cell(150 ,$iAlt,'Descrição',1,0,'C',1);
    $oPdf->Cell(25 ,$iAlt,'Quantidade',1,0,'C',1);
    $oPdf->Cell(25 ,$iAlt,'Vlr. Total',1,0,'C',1);
    $oPdf->Cell(30 ,$iAlt,'Qtd. Disponível',1,0,'C',1);
    $oPdf->Cell(25 ,$iAlt,'Vlr. Disponível',1,0,'C',1);
    $oPdf->Ln();

  }
}
?>
