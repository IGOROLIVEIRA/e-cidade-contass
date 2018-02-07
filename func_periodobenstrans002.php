<?php
require_once("fpdf151/pdf.php");
require_once("libs/db_sql.php");
require_once("libs/db_utils.php");

require_once("model/patrimonio/Bem.model.php");
require_once("model/patrimonio/BemCedente.model.php");
require_once("model/patrimonio/BemClassificacao.model.php");
require_once("model/patrimonio/PlacaBem.model.php");
require_once("model/patrimonio/BemHistoricoMovimentacao.model.php");
require_once("model/patrimonio/BemDadosMaterial.model.php");
require_once("model/patrimonio/BemDadosImovel.model.php");
require_once("model/patrimonio/BemTipoAquisicao.php");
require_once("model/patrimonio/BemTipoDepreciacao.php");
require_once("model/CgmFactory.model.php");

$oGet = db_utils::postMemory($_GET, false);
$head3 = "Transferência por Período";
$head4 = "Período da Transferência: ".implode("/",array_reverse(explode("-", $oGet->dataINI)))." - ". implode("/",array_reverse(explode("-", $oGet->dataFIM)));

$pdf = new PDF(); // abre a classe

$pdf->Open(); // abre o relatorio

$pdf->AddPage('L'); // adiciona uma pagina
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(235);
$tam = '04';

$pdf->SetFont("","B","");
//$parametro = '';
switch ($oGet->ordem) {
  case 'placa':
    $parametro = 't52_ident, t93_data, t95_codtran';
    break;

  case 'usuario':
    $parametro = 'nome, t52_ident, t95_codtran, t93_data';
    break;

  case 'data':
    $parametro = 't93_data, t52_ident, t95_codtran';
    break;

  case 'origem':
    $parametro = 'origem, t93_data, t95_codtran, t52_ident';
    break;

  case 'destino':
    $parametro = 'destino, t93_data, t95_codtran, t52_ident';
    break;

  default:
    $parametro = 't95_codtran, t52_ident';
    break;
}

/**
   * pegar divisao e situacao
   */
  $sSqlDivisao = "SELECT DISTINCT dp1.descrdepto AS origem,
                dp2.descrdepto AS destino,
                db_usuarios.login AS nome,
                t52_bem,
                t52_descr,
                t64_class,
                t52_ident,
                t93_data,
                t95_codtran,
                divisaoorigem.t30_descr AS divorigem,
                divisaodestino.t30_descr AS divdestino,
                situabens.t70_descr AS situacao
        FROM benstransfcodigo
        INNER JOIN bens ON bens.t52_bem = benstransfcodigo.t95_codbem
        INNER JOIN clabens ON clabens.t64_codcla = bens.t52_codcla
        INNER JOIN benstransf ON benstransf.t93_codtran = benstransfcodigo.t95_codtran
        LEFT JOIN benstransfdiv ON benstransfdiv.t31_bem = bens.t52_bem
        AND benstransfdiv.t31_codtran = benstransf.t93_codtran
        LEFT JOIN bensdiv ON bensdiv.t33_bem = bens.t52_bem
        LEFT JOIN departdiv origem ON origem.t30_codigo = bensdiv.t33_divisao
        LEFT JOIN departdiv destino ON destino.t30_codigo = benstransfdiv.t31_divisao
        INNER JOIN situabens ON situabens.t70_situac = benstransfcodigo.t95_situac
        LEFT JOIN benstransforigemdestino ON benstransfdiv.t31_codtran = benstransforigemdestino.t34_transferencia
        AND benstransfdiv.t31_bem = benstransforigemdestino.t34_bem
        LEFT JOIN departdiv divisaoorigem ON divisaoorigem.t30_codigo = benstransforigemdestino.t34_divisaoorigem
        LEFT JOIN departdiv divisaodestino ON divisaodestino.t30_codigo = benstransforigemdestino.t34_divisaodestino
        INNER JOIN db_usuarios ON db_usuarios.id_usuario = benstransf.t93_id_usuario
        INNER JOIN db_depart AS dp1 ON benstransf.t93_depart = dp1.coddepto
        INNER JOIN benstransfdes AS btd1 ON benstransf.t93_codtran = btd1.t94_codtran
        INNER JOIN db_depart AS dp2 ON dp2.coddepto = btd1.t94_depart
        WHERE benstransf.t93_data BETWEEN '{$oGet->dataINI}' and '{$oGet->dataFIM}'
        ORDER BY {$parametro} ASC";

  $rsDivisaoSituacao = db_query($sSqlDivisao);
  // db_criatabela($rsDivisaoSituacao);die;

$pdf->Cell(20,$tam,"COD. TRANS.",1,0,"C",1);
$pdf->Cell(15,$tam,"PLACA",1,0,"C",1);
$pdf->Cell(15,$tam,"DATA",1,0,"C",1);
$pdf->Cell(45,$tam,"DESCRIÇÃO",1,0,"C",1);
$pdf->Cell(40,$tam,"ORIGEM",1,0,"C",1);
$pdf->Cell(40,$tam,"DIVISÃO DE ORIGEM",1,0,"C",1);
$pdf->Cell(40,$tam,"DESTINO",1,0,"C",1);
$pdf->Cell(40,$tam,"DIVISÃO DE DESTINO",1,0,"C",1);
$pdf->Cell(25,$tam,"USUÁRIO",1,1,"C",1);

for ($iCont=0;$iCont < pg_num_rows($rsDivisaoSituacao); $iCont++) {
  $oDivisaoSituacao = db_utils::fieldsMemory($rsDivisaoSituacao, $iCont);
  // db_criatabela($rsDivisaoSituacao);die();
  // $dado = $oDivisaoSituacao->t52_bem;
  $oBem           = new Bem($oDivisaoSituacao->t52_bem);
  $oCodigo        = $oBem->getCodigoTransferencia();
  $oClassificacao = $oBem->getClassificacao();
  $oFornecedor    = $oBem->getFornecedor();
  $oCedente       = $oBem->getCedente();
  $oTipoAquisicao = $oBem->getTipoAquisicao();
  $oPlaca         = $oBem->getPlaca();
  $oImovel        = $oBem->getDadosImovel();
  $oMaterial      = $oBem->getDadosCompra();
  $nValorUnitario = $oBem->getValorAquisicao();
  $iValorTotal    += $oBem->getValorAquisicao();
  // $oBem->t52_descr= $oDivisaoSituacao->t52_descr;

  if (strlen($oBem->getDescricao()) > 25 || strlen($oDivisaoSituacao->divorigem) > 25 || strlen($oDivisaoSituacao->divdestino) > 25 || strlen($oDivisaoSituacao->origem) > 22 || strlen($oDivisaoSituacao->destino) > 22) {

      $aDescricao  = quebrar_texto($oBem->getDescricao(),25);
      $aDivOrigem  = quebrar_texto($oDivisaoSituacao->divorigem,25);
      $aDivDestino = quebrar_texto($oDivisaoSituacao->divdestino,25);
      $aOrigem     = quebrar_texto($oDivisaoSituacao->origem,22);
      $aDestino    = quebrar_texto($oDivisaoSituacao->destino,22);
    $aDados = array(count($aDescricao),count($aDivOrigem),count($aDivDestino),count($aOrigem),count($aDestino));
    $alt_novo = max($aDados);

  } else {
    $alt_novo = 1;
  }


  $pdf->Cell(20,$tam*$alt_novo,$oDivisaoSituacao->t95_codtran,1,0,"C",0);
  $pdf->Cell(15,$tam*$alt_novo,$oDivisaoSituacao->t52_ident,1,0,"C",0);
  $pdf->cell(15,$tam*$alt_novo,implode('/',array_reverse(explode('-',$oDivisaoSituacao->t93_data))),1,0,"C",0);

  /**
   * imprimir descricao item
   */
  if (strlen($oBem->getDescricao()) > 25) {

    $pos_x = $pdf->x;
    $pos_y = $pdf->y;
    $pdf->Cell(45,$tam*$alt_novo,"",1,0,"L",0);
    $pdf->x = $pos_x;
    $pdf->y = $pos_y;
    foreach ($aDescricao as $oDescricao) {
      $pdf->cell(45,($tam),$oDescricao,0,1,"L",0);
      $pdf->x=$pos_x;
    }
    $pdf->x = $pos_x+45;
    $pdf->y=$pos_y;
  } else {
    $pdf->Cell(45,$tam*$alt_novo,$oBem->getDescricao(),1,0,"L",0);
  }

  /**
   * imprimir  origem
   */
  if (strlen($oDivisaoSituacao->origem) > 22) {
    $pos_x = $pdf->x;
    $pos_y = $pdf->y;
    $pdf->Cell(40,$tam*$alt_novo,"",1,0,"L",0);
    $pdf->x = $pos_x;
    $pdf->y = $pos_y;
    foreach ($aOrigem as $oOrigem) {
      $pdf->cell(40,($tam),$oOrigem,0,1,"L",0);
      $pdf->x=$pos_x;
    }
    $pdf->x = $pos_x+40;
    $pdf->y=$pos_y;

  } else {
    $pdf->Cell(40,$tam*$alt_novo,$oDivisaoSituacao->origem,1,0,"L",0);
  }

  /**
   * imprimir  divorigem
   */
  if (strlen($oDivisaoSituacao->divorigem) > 25) {

    $pos_x = $pdf->x;
    $pos_y = $pdf->y;
    $pdf->Cell(40,$tam*$alt_novo,"",1,0,"L",0);
    $pdf->x = $pos_x;
    $pdf->y = $pos_y;
    foreach ($aDivorigem as $oDivorigem) {
      $pdf->cell(40,($tam),$oDivorigem,0,1,"L",0);
      $pdf->x=$pos_x;
    }
    $pdf->x = $pos_x+40;
    $pdf->y=$pos_y;

  } else {
    $pdf->Cell(40,$tam*$alt_novo,$oDivisaoSituacao->divorigem,1,0,"L",0);
  }

  /**
   * imprimir  destino
   */
  if (strlen($oDivisaoSituacao->destino) > 22) {

    $pos_x = $pdf->x;
    $pos_y = $pdf->y;
    $pdf->Cell(40,$tam*$alt_novo,"",1,0,"L",0);
    $pdf->x = $pos_x;
    $pdf->y = $pos_y;
    foreach ($aDestino as $oDestino) {
      $pdf->cell(40,($tam),$oDestino,0,1,"L",0);
      $pdf->x=$pos_x;
    }
    $pdf->x = $pos_x+40;
    $pdf->y=$pos_y;

  } else {
    $pdf->Cell(40,$tam*$alt_novo,$oDivisaoSituacao->destino,1,0,"L",0);
  }


  /**
   * imprimir  divdestino
   */
  if (strlen($oDivisaoSituacao->divdestino) > 25) {

    $pos_x = $pdf->x;
    $pos_y = $pdf->y;
    $pdf->Cell(40,$tam*$alt_novo,"",1,1,"L",0);
    $pdf->x = $pos_x;
    $pdf->y = $pos_y;
    foreach ($aDivDestino as $oDivDestino) {
      $pdf->cell(40,($tam),$oDivDestino,0,1,"L",0);
      $pdf->x=$pos_x;
    }
    $pdf->x = $pos_x+40;
    $pdf->y=$pos_y;

  } else {
    $pdf->Cell(40,$tam*$alt_novo,$oDivisaoSituacao->divdestino,1,0,"L",0);
  }

  $pdf->Cell(25,$tam*$alt_novo,$oDivisaoSituacao->nome,1,1,"C",0);

}
// die();

$pdf->Cell(20,$tam,"Total de Bens",1,0,"C",1);
$pdf->Cell(115,$tam,pg_num_rows($rsDivisaoSituacao),1,0,"C",0);

$pdf->Cell(40,$tam,"Valor Total",1,0,"C",1);
$pdf->Cell(105,$tam,db_formatar($iValorTotal,"f"),1,0,"C",0);

$pdf->output();

function quebrar_texto($texto,$tamanho) {

  $aTexto = explode(" ", $texto);
  $string_atual = "";
  foreach ($aTexto as $word) {
    $string_ant = $string_atual;
    $string_atual .= " ".$word;
    if (strlen($string_atual) > $tamanho) {
      $aTextoNovo[] = trim($string_ant);
      $string_ant   = "";
      $string_atual = $word;
    }
  }
  $aTextoNovo[] = trim($string_atual);
  return $aTextoNovo;

}
