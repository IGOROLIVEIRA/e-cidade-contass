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

$acordo = new cl_acordo();


$sSql2 = '';
$lista = '';
$where = '';
$orderBy = '';

if($iAcordo){
  $where = " ac16_sequencial = ".$iAcordo;
  $orderBy = ' ac16_sequencial ';
}

if(!$iAcordo){
  $orderBy = ' ac16_sequencial ';
}

if($orderBy)
  $orderBy .= ', ';

if($where){
  $where .= ' and ';
}

switch ($listagem) {
  case 0:
    $lista  = 'Aditivos e Apostilamentos';
    $sSql2  = " LEFT JOIN apostilamento on si03_acordo = ac16_sequencial ";
    $sSql2 .= " LEFT JOIN acordoposicaoaditamento on ac35_acordoposicao = ac26_sequencial ";

    if($data_inicial && $data_final){
      $where .= " ac35_dataassinaturatermoaditivo BETWEEN '".formataData($data_inicial, true)."' and '".formataData($data_final, true)."'";
      $where .= " OR si03_dataassinacontrato BETWEEN '".formataData($data_inicial, true)."' AND '".formataData($data_final, true)."'";
    }

    $orderBy .= 'si03_dataassinacontrato, ac35_dataassinaturatermoaditivo';

    break;

  case 1:
    $lista  = "Somente Aditivos";
    $sSql2  = " INNER JOIN acordoposicaoaditamento on ac35_acordoposicao = ac26_sequencial ";
    $where .= " ac35_dataassinaturatermoaditivo BETWEEN '".formataData($data_inicial, true)."' and '".formataData($data_final, true)."'";

    $orderBy .= 'ac35_dataassinaturatermoaditivo';

    break;

  case 2:
    $lista  = 'Somente Apostilamentos';
    $sSql2 .= " INNER JOIN apostilamento on si03_acordo = ac16_sequencial ";
    $where .= " si03_dataassinacontrato BETWEEN '".formataData($data_inicial, true)."' and '".formataData($data_final, true)."'";
    $orderBy .= 'si03_dataassinacontrato';
    break;
}


$sSql = "SELECT *
          FROM acordo
          INNER JOIN acordoposicao ON ac26_acordo = ac16_sequencial
          INNER JOIN acordoitem ON ac20_acordoposicao = ac26_sequencial
          LEFT JOIN acordoposicaotipo ON ac27_sequencial = ac20_acordoposicaotipo
          INNER JOIN cgm on z01_numcgm = ac16_contratado ".$sSql2." where ".$where. " ORDER BY ".$orderBy;


$result = $acordo->sql_record($sSql);
$numrows = $acordo->numrows;

if($numrows == 0){
  db_redireciona("db_erros.php?fechar=true&db_erro=Nenhum Registro Encontrado! Verifique.");
}

$oPdf  = new PDF();
$oPdf->Open();
$oPdf->AliasNbPages();
$oPdf->SetTextColor(0,0,0);
$oPdf->SetFillColor(220);
$oPdf->SetAutoPageBreak(false);
$oPdf->SetFont('Arial', 'B', 8);

$iFonte     = 9;
$iAlt       = 8;

$head3 .= "Relatório de Aditivos e Apostilamentos\n";
$head5 = 'Listar '.$lista;

if($data_inicial && $data_final){
  $head7 = 'Período: '.$data_inicial.' à '.$data_final;
}

setHeader($oPdf, 9);
$troca = 1;

for ($contador=0; $contador < $numrows; $contador++) {

    if($oPdf->gety() > $oPdf->h - 32 || $troca != 0 ){
      $oPdf->addpage("");
      setHeader($oPdf, 9);
    }

    $oPdf->setfont('arial', '', 7);
    $oAcordo = db_utils::fieldsMemory($result, $contador);

    $old_y = $oPdf->gety();

    if($oAcordo->ac27_sequencial && $oAcordo->ac27_descricao){
     $sequencial_descricao = "'".$oAcordo->ac27_sequencial / $oAcordo->ac27_descricao."'";
    }else $sequencial_descricao = 'Não houve alteração de valor';


    if(strlen($sequencial_descricao) > strlen($oAcordo->z01_nome)){
      $oPdf->setx(113);
      $oPdf->MultiCell(35, $iAlt, $sequencial_descricao, 1, 'C', 0, 0);
      $nova_altura = $oPdf->gety() - $old_y;
      $oPdf->sety($old_y);
      $oPdf->setx(28);
      $oPdf->MultiCell(60, $nova_altura, $oAcordo->z01_nome, 1, 'C', 0, 0);
    }else{
      $oPdf->setx(28);
      $oPdf->MultiCell(60, $iAlt, $oAcordo->z01_nome, 1, 'C', 0, 0);
      $nova_altura = $oPdf->gety() - $old_y;
      $oPdf->sety($old_y);
      $oPdf->setx(113);
      $oPdf->MultiCell(35, $nova_altura, $sequencial_descricao, 1, 'C', 0, 0);
    }

    $nova_altura = $oPdf->gety() - $old_y;
    $oPdf->sety($old_y);
    $oPdf->setx(10);
    $oPdf->Cell(18, $nova_altura, $oAcordo->ac16_sequencial.'/'.$oAcordo->ac16_anousu, 1, 0, 'C', 0);

    if($oAcordo->si03_sequencial){
      $numero_tipo = '1/Apostilamento';
    }

    if($oAcordo->ac35_sequencial){
      $numero_tipo = '3/Aditivo';
    }

    $oPdf->setx(88);
    $oPdf->Cell(25, $nova_altura, $numero_tipo, 'TB', 0, 'C', 0);
    $oPdf->setx(148);

    if($oAcordo->ac35_dataassinaturatermoaditivo){
      $assinatura = $oAcordo->ac35_dataassinaturatermoaditivo;
    }

    if($oAcordo->si03_dataassinacontrato){
      $assinatura = $oAcordo->si03_dataassinacontrato;
    }

    $oPdf->Cell(30, $nova_altura, formataData($assinatura, false), 'TB', 0, 'C', 0);
    $oPdf->Cell(23, $nova_altura, formataData($oAcordo->ac16_datafim, false), 1, 1, 'C', 0);

    $troca=0;
}

$oPdf->Output();

/**
* Insere o cabeçalho do relatório
* @param object $oPdf
* @param integer $iHeigth Altura da linha
*/
function setHeader($oPdf, $iHeigth) {
  $oPdf->setfont('arial', 'b', 8);
  $oPdf->setfillcolor(235);
  $oPdf->Cell(18,  $iHeigth, "Contrato", 1, 0, "C", 1);
  $oPdf->Cell(60,  $iHeigth, "Fornecedor", 1, 0, "C", 1);
  $oPdf->Cell(25,  $iHeigth, "Número/Tipo", 1, 0, "C", 1);
  $oPdf->Cell(35,  $iHeigth, "Tipo de Alteração", 1, 0, "C", 1);
  $oPdf->Cell(30,  $iHeigth, "Data de Assinatura", 1, 0, "C", 1);
  $oPdf->Cell(23,  $iHeigth, "Vigência Final", 1, 1, "C", 1);
}

function formataData($data, $consulta){
  if($consulta){
    $caractere_explode = '/';
    $caractere_join = '-';
  }

  if(!$consulta){
    $caractere_explode = '-';
    $caractere_join = '/';
  }

  $stringTratada = explode($caractere_explode, $data);
  $dataFinal = join($caractere_join, array_reverse($stringTratada));
  return $dataFinal;
}

?>
