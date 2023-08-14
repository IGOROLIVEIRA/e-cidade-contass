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
require_once("libs/JSON.php");
require_once("classes/db_retencaoreceitas_classe.php");

$oJson       = new Services_JSON();
$oParametros = $oJson->decode(str_replace("\\","",$_GET["sFiltros"]));
$sWhere = "e60_instit = ".db_getsession("DB_instit");
$sHeaderTipo = "Pagamento";
$sWhere .= " and corrente.k12_estorn is false ";

if ($oParametros->datainicial != "" && $oParametros->datafinal == "") {
   $dataInicial  = implode("-", array_reverse(explode("/", $oParametros->datainicial)));
   $sWhere      .= " and corrente.k12_data = '{$dataInicial}'";
   $sHeaderData  = "{$oParametros->datainicial} a {$oParametros->datainicial}";

} else if ($oParametros->datainicial != "" && $oParametros->datafinal != "") {
  $dataInicial = implode("-", array_reverse(explode("/", $oParametros->datainicial)));
  $dataFinal   = implode("-", array_reverse(explode("/", $oParametros->datafinal)));
  $sWhere     .= "and corrente.k12_data between '{$dataInicial}' and '{$dataFinal}'";
  $sHeaderData  = "{$oParametros->datainicial} a {$oParametros->datafinal}";
}
if ($oParametros->sContas != "") {
   $sWhere .= " and corrente.k12_conta in({$oParametros->sContas})";
}
$sWhere .= " and e23_recolhido is true ";

$sWhere .= " and o57_fonte LIKE '411%' ";

$sHeaderOps  = "Todas";

if ($oParametros->iTipo == 's'){
  $sGrupby = " group by  c61_reduz, o15_codigo, o15_descr, c60_descr ";

  $sSqlRetencoes  = " select distinct c61_reduz,     ";
  $sSqlRetencoes .= "                   o15_codigo,  ";
  $sSqlRetencoes .= "                   o15_descr,   ";
  $sSqlRetencoes .= "conplano.c60_descr as c60_descr,";
  $sSqlRetencoes .= " round(sum(e23_valorretencao),2) as e23_valorretencao";
}
if ($oParametros->iTipo == 'a'){
  $sGrupby = " group by  c61_reduz, o15_codigo, o15_descr, c60_descr,e21_descricao, e21_sequencial ";

  $sSqlRetencoes  = " select distinct c61_reduz,     ";
  $sSqlRetencoes .= "                   o15_codigo,  ";
  $sSqlRetencoes .= "                   o15_descr,   ";
  $sSqlRetencoes .= "conplano.c60_descr as c60_descr,";
  $sSqlRetencoes .= " round(sum(e23_valorretencao),2) as e23_valorretencao,";
  $sSqlRetencoes .= " e21_descricao, e21_sequencial ";
}
$sSqlRetencoes .= "  from retencaoreceitas retencao";
$sSqlRetencoes .= "       inner join retencaopagordem on e20_sequencial = e23_retencaopagordem ";
$sSqlRetencoes .= "       inner join pagordem         on e50_codord     = e20_pagordem         ";
$sSqlRetencoes .= "       inner join pagordemele      on e50_codord     = e53_codord           ";
$sSqlRetencoes .= "       inner join empempenho       on e60_numemp     = e50_numemp           ";
$sSqlRetencoes .= "       inner join orcdotacao       on e60_coddot     = o58_coddot           ";
$sSqlRetencoes .= "                                and o58_anousu = ".db_getsession("DB_anousu");
$sSqlRetencoes .= "       inner join cgm              on e60_numcgm     = cgm.z01_numcgm       ";
$sSqlRetencoes .= "       inner join pagordemnota     on e71_codord     = e50_codord           ";
$sSqlRetencoes .= "                                   and e71_anulado is false                 ";
$sSqlRetencoes .= "       inner join empnota          on e71_codnota    = e69_codnota          ";
$sSqlRetencoes .= "       inner join retencaotiporec  on e21_sequencial = e23_retencaotiporec  ";
$sSqlRetencoes .= "       inner join tabrec           on e21_receita = tabrec.k02_codigo       ";
$sSqlRetencoes .= "       inner join taborc ON tabrec.k02_codigo = taborc.k02_codigo           ";
$sSqlRetencoes .= "       and taborc.k02_anousu = o58_anousu                                   ";
$sSqlRetencoes .= "inner join orcreceita ON (k02_anousu, k02_codrec) = (o70_anousu, o70_codrec)";
$sSqlRetencoes .= " inner join orcfontes ON (o70_codfon, o70_anousu) = (o57_codfon, o57_anousu)";
$sSqlRetencoes .= " inner join orctiporec ON o15_codigo = o70_codigo                           ";
$sSqlRetencoes .= "       left join retencaocorgrupocorrente on e47_retencaoreceita = e23_sequencial       ";
$sSqlRetencoes .= "       left join corgrupocorrente         on k105_sequencial     = e47_corgrupocorrente ";
$sSqlRetencoes .= "       left join corrente                 on k105_id             = corrente.k12_id      ";
$sSqlRetencoes .= "                                          and k105_autent         = corrente.k12_autent  ";
$sSqlRetencoes .= "                                          and k105_data           = corrente.k12_data    ";
$sSqlRetencoes .= "       left join conplanoreduz            on corrente.k12_conta  = c61_reduz            ";
$sSqlRetencoes .= "                                          and c61_anousu          = ".db_getsession("DB_anousu");
$sSqlRetencoes .= "       left join conplano                 on c60_codcon          = c61_codcon           ";
$sSqlRetencoes .= "                                          and c60_anousu          = c61_anousu           ";
$sSqlRetencoes .= " where e23_ativo is true ";
$sSqlRetencoes .= "   and {$sWhere} ";
$sSqlRetencoes .= "   {$sGrupby} ";

$sValorCompararQuebra = "";
$sValorCompararFonte  = "";
$sCampoQuebrar        = "";
$sNomeQuebra          = "";
$sCampoQuebrar        = "c61_reduz";
$sNomeQuebra          = "c60_descr";
$rsRetencoes          = db_query($sSqlRetencoes);
$iTotalRetencoes      = pg_num_rows($rsRetencoes);

if ($iTotalRetencoes  == 0 || !$rsRetencoes) {
  db_redireciona("db_erros.php?fechar=true&db_erro=Nenhum foram encontradas retenções.");
}

$aRetencoes          = array();
$iTotalRetencoes     = pg_num_rows($rsRetencoes);

for ($i = 0; $i < $iTotalRetencoes; $i++) {

   $oRetencao = db_utils::fieldsMemory($rsRetencoes, $i);
   
   if ($sValorCompararQuebra == $oRetencao->$sCampoQuebrar) {
       $aRetencoes[$oRetencao->$sCampoQuebrar]->total    += $oRetencao->e23_valorretencao;
       $aRetencoes[$oRetencao->$sCampoQuebrar]->itens[]   = $oRetencao;
   } else {
       $aRetencoes[$oRetencao->$sCampoQuebrar]->texto    = $oRetencao->$sCampoQuebrar." - ".$oRetencao->$sNomeQuebra;
       $aRetencoes[$oRetencao->$sCampoQuebrar]->total    = $oRetencao->e23_valorretencao;
       $aRetencoes[$oRetencao->$sCampoQuebrar]->itens[]  = $oRetencao;
   }
     $sValorCompararQuebra = $oRetencao->$sCampoQuebrar;
}

$oPdf  = new PDF("L","mm","A4");
$oPdf->Open();
$oPdf->SetAutoPageBreak(false);
$oPdf->AliasNbPages();
$oPdf->SetFillColor(240);

$head2           = "Transferências de Retenções Orçamentárias";
$head4           = "Período  : {$sHeaderData}";
$sFonte          = "Arial";
$lEscreverHeader = true;
$lAddPage        = false;
$nTamanhoTotalCelulas = 255;
$nTotalGeralRetido = 0;
$nTotalGeralTransf = 0;
$nSaldoGeralaTransf = 0;
$nValorTotalTransferido = 0;
$nSaldoTotalTransfer = 0;
$nImprimirFonte = 0;

$oPdf->AddPage();

$iTamCell  = 0;
$iTamFonte = 5;
$iTamCell  = (39/5);
$iTamFonte = 6;
foreach ($aRetencoes as $oQuebra) {

  $oPdf->SetFont($sFonte, "b",$iTamFonte+2);
  $lEscreverHeader     = true;
  $sValorCompararFonte = '';
  $aRetencoes[$oRetencaoAtiva->c61_reduz.$oRetencaoAtiva->o15_codigo]->totalfonte = 0;
  foreach ($oQuebra->itens as $oRetencaoAtiva) {
      if ($sValorCompararFonte == $oRetencaoAtiva->o15_codigo){
        $aRetencoes[$oRetencaoAtiva->c61_reduz.$oRetencaoAtiva->o15_codigo]->totalfonte  += $oRetencaoAtiva->e23_valorretencao;
      } else {
        $aRetencoes[$oRetencaoAtiva->c61_reduz.$oRetencaoAtiva->o15_codigo]->totalfonte = $oRetencaoAtiva->e23_valorretencao;
      }
      $sValorCompararFonte = $oRetencaoAtiva->o15_codigo;
  }
  foreach ($oQuebra->itens as $oRetencaoAtiva) {
  
    $sSqlSlip   = " select round(sum(k17_valor),2) as k17_valor from slip where k17_credito = $oRetencaoAtiva->c61_reduz  
                  and k17_tiposelect = '04' and
                  k17_data between '{$dataInicial}' and '{$dataFinal}' ";
    $rsSlip     = db_query($sSqlSlip);
    $iTotalSlip = pg_num_rows($rsSlip); 
    if ($iTotalSlip > 0) {
      $oSlip = db_utils::fieldsMemory($rsSlip, 0);             
    }  
   
    if ($oPdf->Gety() > $oPdf->h - 27 || $lEscreverHeader) {

      if ($oPdf->Gety() > $oPdf->h - 27) {
        $oPdf->AddPage();
      }

      if ($oQuebra->texto != "") {
          
        $oPdf->SetFont('Times', "",$iTamFonte+4);
        $oPdf->cell(0,5, 'CONTA : '.$oQuebra->texto,0,1);
        $nValorTotalTransferido = 0;
        $nSaldoTotalTransfer = 0;
      }

      $oPdf->SetFont($sFonte, "b",$iTamFonte+1);
      $oPdf->cell(143+$iTamCell,5,"FONTE DE RECURSOS",1,0,"C",1);
      $oPdf->cell(35+$iTamCell,5,"VALOR RETIDO",1,0,"C",1);
      $oPdf->cell(35+$iTamCell,5,"VALOR TRANSFERIDO",1,0,"C",1);
      $oPdf->cell(35+$iTamCell,5,"SALDO A TRANSFERIR",1,1,"C",1);
      
      $lEscreverHeader = false;
      $nImprimirFonte = 0;
    }
  
    if ($oParametros->iTipo == 'a'){
      $nValorTotalTransferido = $oSlip->k17_valor;
      $nSaldoTotalTransfer = $oQuebra->total - $oSlip->k17_valor;
      if ($nImprimirFonte != $oRetencaoAtiva->o15_codigo || $nImprimirFonte == 0){
        $oPdf->SetFont($sFonte, "b",$iTamFonte+1);
        $oPdf->cell(143+$iTamCell,5,$oRetencaoAtiva->o15_codigo ." - ". $oRetencaoAtiva->o15_descr,1,0,"L");
        $oPdf->cell(35+$iTamCell,5,"R$ ".db_formatar($aRetencoes[$oRetencaoAtiva->c61_reduz.$oRetencaoAtiva->o15_codigo]->totalfonte,"f"),1,0,"C");
        $oPdf->cell(35+$iTamCell,5,"R$ ".db_formatar($oSlip->k17_valor,"f"),1,0,"C");
        $oPdf->cell(35+$iTamCell,5,"R$ ".db_formatar($aRetencoes[$oRetencaoAtiva->c61_reduz.$oRetencaoAtiva->o15_codigo]->totalfonte - $oSlip->k17_valor,"f"),1,1,"C");
        $nTotalGeralTransf  += $oSlip->k17_valor;
      }
      $oPdf->SetFont($sFonte, "",$iTamFonte);
      $oPdf->cell(143+$iTamCell,5,$oRetencaoAtiva->e21_sequencial ." - ". $oRetencaoAtiva->e21_descricao,1,0,"L"); 
      $oPdf->cell(35+$iTamCell,5,"R$ ".db_formatar($oRetencaoAtiva->e23_valorretencao,"f"),1,0,"C");
      $oPdf->cell(35+$iTamCell,5," - ",1,0,"C");
      $oPdf->cell(35+$iTamCell,5," - ",1,1,"C");
      $nTotalGeralRetido  += $oRetencaoAtiva->e23_valorretencao;
      $nSaldoGeralaTransf = $nTotalGeralRetido - $nTotalGeralTransf;
    } 
    if ($oParametros->iTipo == 's'){
      $nValorTotalTransferido += $oSlip->k17_valor;
      $nSaldoTotalTransfer += $oRetencaoAtiva->e23_valorretencao - $oSlip->k17_valor;
      $oPdf->SetFont($sFonte, "",$iTamFonte);
      $oPdf->cell(143+$iTamCell,5,$oRetencaoAtiva->o15_codigo ." - ". $oRetencaoAtiva->o15_descr,1,0,"L");
      $oPdf->cell(35+$iTamCell,5,"R$ ".db_formatar($oRetencaoAtiva->e23_valorretencao,"f"),1,0,"C");
      $oPdf->cell(35+$iTamCell,5,"R$ ".db_formatar($oSlip->k17_valor,"f"),1,0,"C");
      $oPdf->cell(35+$iTamCell,5,"R$ ".db_formatar($oRetencaoAtiva->e23_valorretencao - $oSlip->k17_valor,"f"),1,1,"C");
      $nTotalGeralRetido += $oRetencaoAtiva->e23_valorretencao;
      $nTotalGeralTransf += $nValorTotalTransferido;
      $nSaldoGeralaTransf = $nTotalGeralRetido - $nTotalGeralTransf;
    }   
    $nImprimirFonte = $oRetencaoAtiva->o15_codigo;
  }
  $oPdf->SetFont($sFonte, "b",$iTamFonte);
  $oPdf->cell(143+$iTamCell, 5, 'Total:', 1, 0, "R");
  $oPdf->cell(35+$iTamCell, 5,"R$ ". db_formatar($oQuebra->total, "f"), 1, 0, "C");
  $oPdf->cell(35+$iTamCell, 5,"R$ ". db_formatar($nValorTotalTransferido, "f"), 1, 0, "C");
  $oPdf->cell(35+$iTamCell, 5,"R$ ". db_formatar($nSaldoTotalTransfer, "f"), 1, 1, "C");
}
$oPdf->SetFont($sFonte, "b",$iTamFonte);
$oPdf->cell(143+$iTamCell,5,"Total Geral:",1,0,"R");
$oPdf->cell(35+$iTamCell, 5,"R$ ".db_formatar($nTotalGeralRetido,"f"),1,0,"C");
$oPdf->cell(35+$iTamCell, 5,"R$ ".db_formatar($nTotalGeralTransf,"f"),1,0,"C");
$oPdf->cell(35+$iTamCell, 5,"R$ ".db_formatar($nSaldoGeralaTransf,"f"),1,1,"C");
$oPdf->Output();

