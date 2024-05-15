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

if($orderBy)
  $orderBy .= ', ';

switch ($listagem) {
  case 0:
    $lista  = 'Aditivos e Apostilamentos';
    $sSql2  = " LEFT JOIN apostilamento on si03_acordo = ac16_sequencial ";
    $sSql2 .= " LEFT JOIN acordoposicaoaditamento on ac35_acordoposicao = ac26_sequencial ";

    if($data_inicial && $data_final && !$iAcordo){
      if($where){
        $where .= ' and ';
      }
      $where .= " (CASE
                    WHEN si03_dataassinacontrato IS NOT NULL
                     THEN si03_dataassinacontrato
                     ELSE ac35_dataassinaturatermoaditivo
                  END) BETWEEN '".formataData($data_inicial, true)."' and '".formataData($data_final, true)."'";

      $orderBy .= ' ac16_anousu ASC, ac16_numero, ac26_numero';
    }

    if($data_inicial && $data_final && $iAcordo){
      if($where){
        $where .= ' and ';
      }

      $where .= " (CASE
                    WHEN si03_dataassinacontrato IS NOT NULL
                     THEN si03_dataassinacontrato
                     ELSE ac35_dataassinaturatermoaditivo
                  END) BETWEEN '".formataData($data_inicial, true)."' and '".formataData($data_final, true)."' and ac16_sequencial = ".$iAcordo;
    }

    if(!$data_inicial && !$data_final && $iAcordo){
      if($where){
        $where .= ' and ';
      }
      $where .= " ac16_sequencial = ".$iAcordo;
      $where .= " and (ac35_dataassinaturatermoaditivo is not null ";
      $where .= " OR si03_dataassinacontrato is not null) ";
    }

    break;

  case 1:
    $lista  = "Somente Aditivos";
    $sSql2  = " INNER JOIN acordoposicaoaditamento on ac35_acordoposicao = ac26_sequencial ";
    $sSql2 .= " LEFT JOIN apostilamento on si03_acordo = ac16_sequencial ";
    if($data_inicial && $data_final)
      $where .= " ac35_dataassinaturatermoaditivo BETWEEN '".formataData($data_inicial, true)."' and '".formataData($data_final, true)."'";

    if($iAcordo){
      if($where)
        $where .= ' and ';
      $where .= ' ac16_sequencial = '.$iAcordo;
    }

    $orderBy .= 'ac16_anousu ASC, data_assinatura';

    break;

  case 2:
    $lista  = 'Somente Apostilamentos';
    $sSql2 .= " INNER JOIN apostilamento on si03_acordo = ac16_sequencial ";
    $sSql2 .= " LEFT JOIN acordoposicaoaditamento on ac35_acordoposicao = ac26_sequencial ";

    if($data_inicial && $data_final){
      $where .= " si03_dataassinacontrato BETWEEN '".formataData($data_inicial, true)."' and '".formataData($data_final, true)."'";
    }

    if($iAcordo){
      if($where)
        $where .= ' and ';
      $where .= ' ac16_sequencial = '.$iAcordo;
    }
    if($where){
      $where .= ' and ';
    }
    $where .= " ac35_dataassinaturatermoaditivo IS NULL ";
    $orderBy .= 'ac16_anousu ASC, data_assinatura';
    break;
}

$campos = " ac16_numero::integer,
            ac16_sequencial,
            ac16_vigenciaindeterminada,
            ac26_numero,
            (CASE
                  WHEN ac26_numeroapostilamento <> '' THEN ac26_numeroapostilamento
                  ELSE ac26_numeroaditamento
                  END) as numero,
            ac16_anousu,
            z01_nome,
            si03_sequencial,
            si03_dataassinacontrato,
            ac26_acordoposicaotipo||'-'||ac27_descricao AS tipoaditivo,
            (CASE
              WHEN ac35_dataassinaturatermoaditivo IS NOT NULL THEN ac35_dataassinaturatermoaditivo
              ELSE si03_dataapostila
            END) AS data_assinatura,
            ac18_datafim as vigencia_final,
            ac35_sequencial";

if(!$orderBy){
  $orderBy .= ' ac16_sequencial';
}

if($where){
  $where .= ' and ';
  $where .= ' ac26_acordoposicaotipo <> 1 ';
}

$sSql = "SELECT DISTINCT ".$campos."
          FROM acordo
          INNER JOIN acordoposicao ON ac26_acordo = ac16_sequencial
          INNER JOIN acordovigencia ON ac18_acordoposicao = ac26_sequencial
          INNER JOIN acordoitem ON ac20_acordoposicao = ac26_sequencial
          LEFT JOIN acordoposicaotipo ON ac27_sequencial = ac26_acordoposicaotipo
          INNER JOIN cgm on z01_numcgm = ac16_contratado ".$sSql2." where ".$where. " ORDER BY ".$orderBy;

// print_r($sSql);die();
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
$iAlt       = 6;
$nova_altura = 6;

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
      $old_y = $oPdf->gety();
    }

    $oPdf->setfont('arial', '', 7);
    $oAcordo = db_utils::fieldsMemory($result, $contador);
    $oPdf->sety($old_y);

    $oPdf->sety($old_y);
    $old_y = $oPdf->gety();
    $oAcordo->tipoaditivo = formataAcento($oAcordo->tipoaditivo);


    $tamanhoAditivo = strlen($oAcordo->tipoaditivo);
    $tamanhoNome = strlen($oAcordo->z01_nome);

    $nome = trataString($oAcordo->z01_nome);

    if($tamanhoAditivo >= 32){
      $oPdf->sety($old_y);
      $oPdf->setx(116);
      $oPdf->MultiCell(35, $iAlt, $oAcordo->tipoaditivo, 1, 'C', 0, 0);
      $nova_altura = $oPdf->gety() - $old_y;
      $oPdf->sety($old_y);
      $oPdf->setx(26);
      if(strlen($nome) > 36){
        $oPdf->MultiCell(68, $iAlt, $oAcordo->z01_nome, 1, 'C', 0, 0);
      }
      else $oPdf->MultiCell(68, $nova_altura, $oAcordo->z01_nome, 1, 'C', 0, 0);
      $nova_altura = $oPdf->gety() - $old_y;
    }else {
      $oPdf->sety($old_y);
      $oPdf->setx(26);
      $oPdf->MultiCell(68, $iAlt, $oAcordo->z01_nome, 1, 'C', 0, 0);
      $nova_altura = $oPdf->gety() - $old_y;
      $oPdf->sety($old_y);
      $oPdf->setx(116);
      $oPdf->MultiCell(35, $nova_altura, $oAcordo->tipoaditivo, 1, 'C', 0, 0);
      $nova_altura = $oPdf->gety() - $old_y;
    }

    $oPdf->sety($old_y);
    $oPdf->setx(10);
    $oPdf->Cell(16, $nova_altura, $oAcordo->ac16_numero.'/'.$oAcordo->ac16_anousu, 'TLB', 0, 'C', 0);

    if($oAcordo->ac35_sequencial){
      $numero_tipo = $oAcordo->numero.'/Aditivo';
    }else {
      $numero_tipo = $oAcordo->numero.'/Apostilamento';
    }
    $data_assinatura = formataData($oAcordo->data_assinatura, false);

    $oPdf->setx(94);
    $oPdf->Cell(22, $nova_altura, $numero_tipo, 'TB', 0, 'C', 0);
    $oPdf->setx(151);

    $oPdf->Cell(28, $nova_altura, ($data_assinatura == '' ? '-' : $data_assinatura), 'TB', 0, 'C', 0);
    $dataVigencia = $oAcordo->ac16_vigenciaindeterminada == "t" ? "-" : formataData($oAcordo->vigencia_final,false);
    $oPdf->Cell(20, $nova_altura, $dataVigencia, 1, 1, 'C', 0);
    $old_y = $oPdf->gety();
    $nova_altura = $iAlt;
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
  $oPdf->Cell(16,  $iHeigth, "Contrato", 1, 0, "C", 1);
  $oPdf->Cell(68,  $iHeigth, "Fornecedor", 1, 0, "C", 1);
  $oPdf->Cell(22,  $iHeigth, "Número/Tipo", 1, 0, "C", 1);
  $oPdf->Cell(35,  $iHeigth, "Tipo de Alteração", 1, 0, "C", 1);
  $oPdf->Cell(28,  $iHeigth, "Data de Assinatura", 1, 0, "C", 1);
  $oPdf->Cell(20,  $iHeigth, "Vigência Final", 1, 1, "C", 1);
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

function trataString($nome){
  $nome = str_replace(' ', '', $nome);
  $buscados = array('Á', 'Ã', 'Â', 'À', 'É', 'Ê', 'È', 'Í', 'Ì', 'Ô', 'Ó', 'Ò', 'Ú', 'Ù', 'Ç');
  $realocados = array('A', 'A', 'A', 'A', 'E', 'E', 'E', 'I', 'I', 'O', 'O', 'O', 'U', 'U', 'C');
  $nome = preg_replace('/\./', '', $nome);
  $nomeTratado = str_replace("$buscados", $realocados, $nome);
  $resultado = preg_replace('/[a-z]/gi', '', $nomeTratado);

  if($resultado){
    return $resultado;
  }
  else {
    return $nome;
  }
}

function formataAcento($palavra){
  $palavra_formatada = str_replace('crêsc', 'crésc', $palavra);
  return $palavra_formatada;
}

?>
