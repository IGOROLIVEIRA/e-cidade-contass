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
require_once("con2_execucaodecontratosaux.php");
require_once("con2_execcontratossemquebra.php");
require_once("con2_execcontratosquebraempenho.php");
require_once("con2_execcontratosquebraaditivo.php");
require_once("con2_execcontratosquebraaditivoempenho.php");

db_postmemory($HTTP_GET_VARS);

if(is_null($ac16_sequencial) || $ac16_sequencial=="" || is_null($iQuebra) || empty($iQuebra)){
  db_redireciona("db_erros.php?fechar=true&db_erro=Nenhum registro encontrado!");
}

$sWhere = " WHERE ac26_sequencial = (SELECT MAX(ac26_sequencial) FROM acordoposicao WHERE ac26_acordo = ac16_sequencial)
              AND ac26_sequencial =
                (SELECT MAX(ac26_sequencial)
                  FROM acordoposicao
                    WHERE ac26_acordo = '$ac16_sequencial') ";

$sOrder = " ORDER BY codigomaterial, ac16_sequencial, ac26_sequencial, ac20_ordem ";

$oAcordoItem = new cl_acordoitem();
$sSql = $oAcordoItem->sql_query_execucaoDeContratos($sWhere,$sOrder);
$aMateriais = db_utils::getColectionByRecord($oAcordoItem->sql_record($sSql));

if(pg_num_rows($oAcordoItem->sql_record($sSql)) <= 0){
  db_redireciona("db_erros.php?fechar=true&db_erro=Nenhum registro encontrado!");
}

$oPost               = db_utils::postMemory($_POST);
$sAcordo             = 'Todos';
$sDataInicio         = ' / / ';
$sDataFim            = ' / / ';
$sOrdemDescricao     = '';


$oPdf  = new PDF();
$oPdf->Open();
$oPdf->AliasNbPages();
$oPdf->SetTextColor(0,0,0);
$oPdf->SetFillColor(220);
$oPdf->SetAutoPageBreak(false);

$iFonte     = 9;
$iAlt       = 7;

$head4 .= "Relatório de Execução de Contratos\n";

switch($iQuebra){

  case '2':
    $head4 .= "Quebra: Por empenho";
    break;

  case '3':
    $head4 .= "Quebra: Por aditivo";
    break;

  case '4':
    $head4 .= "Quebra: Por aditivo e empenho";
    break;
}

if( empty($ac16_datainicio) && !empty($ac16_datafim) ){
  $head4 .= "\nPeríodo: até $ac16_datafim";
}else if( !empty($ac16_datainicio) && empty($ac16_datafim) ){
  $head4 .= "\nPeríodo: a partir de $ac16_datainicio";
}else if( !empty($ac16_datainicio) && !empty($ac16_datafim) ){
  $head4 .= "\nPeríodo: de $ac16_datainicio até $ac16_datafim";
}

$oPdf->AddPage('L');

switch($iQuebra){

  case '2':
    execucaoDeContratosQuebraPorEmpenho($aMateriais,$iFonte,$iAlt,(int)$ac16_sequencial,$oPdf,$iQuebra,$ac16_datainicio,$ac16_datafim);
    break;

  case '3':
    execucaoDeContratosQuebraPorAditivo($aMateriais,$iFonte,$iAlt,(int)$ac16_sequencial,$oPdf,$iQuebra,$ac16_datainicio,$ac16_datafim);
    break;

  case '4':
    execucaoDeContratosQuebraPorAditivoEmpenho($aMateriais,$iFonte,$iAlt,(int)$ac16_sequencial,$oPdf,$iQuebra,$ac16_datainicio,$ac16_datafim);
    break;
}