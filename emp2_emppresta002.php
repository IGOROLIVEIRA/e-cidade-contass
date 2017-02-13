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
include("fpdf151/assinatura.php");
include("libs/db_sql.php");
include("classes/db_emppresta_classe.php");
include("classes/db_empprestaitem_classe.php");

$clemppresta = new cl_emppresta;
$clempprestaitem = new cl_empprestaitem;
$classinatura = new cl_assinatura;

$clemppresta->rotulo->label();
$clempprestaitem->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label('e44_descr');
$clrotulo->label('z01_nome');
$clrotulo->label('e60_codemp');

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
//db_postmemory($HTTP_SERVER_VARS,2);exit;


// máscara para CPF
function mascaraCPF($sCPF)
{
  $sRegex    = "/(\d{3})(\d{3})(\d{3})(\d{2})/";
  $sReplace  = '$1.$2.$3-$4';

  $sReplaced = preg_replace($sRegex, $sReplace, $sCPF);

  return $sReplaced;
}

// máscara para CNPJ
function mascaraCNPJ($sCNPJ)
{

  $sRegex    = "/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/";
  $sReplace  = '$1.$2.$3/$4-$5';

  $sReplaced = preg_replace($sRegex, $sReplace, $sCNPJ);

  return $sReplaced;
}



$valortotal = 0;

if (isset($e60_codemp)) {
  $codemp = split("/", $e60_codemp);
  if (count($codemp) == 1) {
    $ano = db_getsession("DB_anousu");
  } else {
    $ano = $codemp[1];
  }
  $codemp = $codemp[0];
  $result = $clemppresta->sql_record($clemppresta->sql_query(null, 'e45_numemp,e45_data,e45_obs,e45_tipo,e45_acerta,
                              e45_conferido,z01_nome,e44_descr,
                              e60_codemp,
                              e60_vlremp,
                              e60_vlranu,
                              e60_vlrliq,
                              e60_coddot,
                              fc_estruturaldotacao(e60_anousu,e60_coddot) as dl_estrutural', null, " e60_codemp = '$codemp' and e60_anousu = $ano and e60_instit = " . db_getsession("DB_instit")));

} else {
  //echo $clemppresta->sql_query(null,'e45_numemp,e45_data,e45_obs,e45_tipo,e45_acerta,e45_conferido,z01_nome,e44_descr,e60_codemp,e60_coddot,fc_estruturaldotacao(e60_anousu,e60_coddot) as dl_estrutural',null,"e45_numemp=$e60_numemp");exit;
  $result = $clemppresta->sql_record($clemppresta->sql_query(null, 'e45_numemp,e45_data,e45_obs,e45_tipo,e45_acerta,
                            e45_conferido,z01_nome,e44_descr,
                            e60_codemp, e60_vlremp, e60_vlranu, e60_vlrliq, e60_coddot,
                            fc_estruturaldotacao(e60_anousu,e60_coddot) as dl_estrutural', null, "e45_numemp=$e60_numemp and e60_instit = " . db_getsession("DB_instit")));
}

if ($clemppresta->numrows == 0) {
  db_redireciona('db_erros.php?fechar=true&db_erro=Não existem registros cadastrados.');
}

db_fieldsmemory($result, 0);

$sql1 = "select distinct
                k13_conta,
		k13_descr,
		k12_codord
         from coremp p
	      inner join corrente r on r.k12_id = p.k12_id
	                           and r.k12_data = p.k12_data
				   and r.k12_autent = p.k12_autent
	      inner join  saltes on k13_conta = k12_conta
	 where k12_empen = $e45_numemp";

///// quando for pelo codemp e exercicio atualiza o numemp
$e60_numemp = $e45_numemp;

$result1 = pg_query($sql1);
db_fieldsmemory($result1, 0);
if (pg_num_rows($result1) == 0) {
  db_redireciona('db_erros.php?fechar=true&db_erro=Empenho não foi pago - não é possível emitir a prestação');
}


$head3 = "PLANILHA DE PRESTAÇÃO DE CONTAS";
$head4 = "EMPENHO : $e60_codemp ";
$head5 = "NÚMERO : $e60_numemp ";
$head6 = "DATA : " . date("d/m/Y", db_getsession('DB_datausu'));

$pdf = new PDF('L');
$pdf->Open();
$pdf->AliasNbPages();
$pdf->addpage();
$total = 0;
$pdf->setfillcolor(235);
$pdf->setfont('arial', 'b', 8);
$troca = 1;
$alt = 4;
$total = 0;

for ($x = 0; $x < $clemppresta->numrows; $x++) {

  // 24: altura das informações
  if (($pdf->gety() + 24) > ($pdf->h - 20)) {
    $pdf->addpage();
  }

  $nColLabelEsquerda  = 50;
  $nColValorEsquerda  = 90;

  $nColLabelDireita   = 35;
  $nColValorDireita   = 90;

  db_fieldsmemory($result, $x);
  $pdf->setfont('arial', 'b', 8);
  $pdf->cell($nColLabelEsquerda, $alt, $RLe60_codemp . " : ", 0, 0, "R", 0);

  $pdf->setfont('arial', '', 8);
  $pdf->cell($nColValorEsquerda, $alt, $e60_codemp, 0, 0, "L", 0);

  $pdf->setfont('arial', 'b', 8);
  $pdf->cell($nColLabelDireita, $alt, "Sequencial do Empenho : ", 0, 0, "R", 0);
  // $pdf->cell($nColLabelDireita, $alt, $RLe45_numemp . " : ", 0, 0, "R", 0);

  $pdf->setfont('arial', '', 8);
  $pdf->cell($nColValorDireita, $alt, $e45_numemp, 0, 1, "L", 0);

  $pdf->setfont('arial', 'b', 8);
  $pdf->cell($nColLabelEsquerda, $alt, $RLz01_nome . " : ", 0, 0, "R", 0);

  $pdf->setfont('arial', '', 8);
  $pdf->cell($nColValorEsquerda, $alt, $z01_nome, 0, 1, "L", 0);

  $pdf->setfont('arial', 'b', 8);
  $pdf->cell($nColLabelEsquerda, $alt, $RLe45_data . ' : ', 0, 0, "R", 0);

  $pdf->setfont('arial', '', 8);
  $pdf->cell($nColValorEsquerda, $alt, db_formatar($e45_data, 'd'), 0, 0, "L", 0);

  $pdf->setfont('arial', 'b', 8);
  $pdf->cell($nColLabelDireita, $alt, 'Dotação : ', 0, 0, "R", 0);

  $pdf->setfont('arial', '', 8);
  $pdf->cell($nColValorDireita, $alt, "$e60_coddot -  $dl_estrutural", 0, 1, "L", 0);

  $pdf->setfont('arial', 'b', 8);
  $pdf->cell($nColLabelEsquerda, $alt, $RLe45_tipo . " : ", 0, 0, "R", 0);

  $pdf->setfont('arial', '', 8);
  $pdf->cell($nColValorEsquerda, $alt, $e45_tipo, 0, 0, "L", 0);

  $pdf->setfont('arial', 'b', 8);
  $pdf->cell($nColLabelDireita, $alt, $RLe44_descr . " : ", 0, 0, "R", 0);

  $pdf->setfont('arial', '', 8);
  $pdf->cell($nColValorDireita, $alt, $e44_descr, 0, 1, "L", 0);

  $pdf->setfont('arial', 'b', 8);
  $pdf->cell($nColLabelEsquerda, $alt, $RLe45_acerta . " : ", 0, 0, "R", 0);

  $pdf->setfont('arial', '', 8);
  $pdf->cell($nColValorEsquerda, $alt, db_formatar($e45_acerta, 'd'), 0, 0, "L", 0);

  $pdf->setfont('arial', 'b', 8);
  $pdf->cell($nColLabelDireita, $alt, $RLe45_conferido . " : ", 0, 0, "R", 0);

  $pdf->setfont('arial', '', 8);
  $pdf->cell($nColValorDireita, $alt, db_formatar($e45_conferido, 'd'), 0, 1, "L", 0);

  $pdf->setfont('arial', 'b', 8);
  $pdf->cell($nColLabelEsquerda, $alt, 'Conta : ', 0, 0, "R", 0);

  $pdf->setfont('arial', '', 8);
  $pdf->cell($nColValorEsquerda, $alt, $k13_conta . ' - ' . $k13_descr, 0, 0, "L", 0);

  $pdf->setfont('arial', 'b', 8);
  $pdf->cell($nColLabelDireita, $alt, 'Ordem de Pagamento : ', 0, 0, "R", 0);

  $pdf->setfont('arial', '', 8);
  $pdf->cell($nColValorDireita, $alt, $k12_codord, 0, 1, "L", 0);

  $pdf->setfont('arial', 'b', 8);
  $pdf->cell($nColLabelEsquerda, $alt, $RLe45_obs . " : ", 0, 0, "R", 0);

  $pdf->setfont('arial', '', 8);
  $pdf->multicell(180, $alt, $e45_obs, 0, "L", 0);
  $pdf->ln();

  $result_itens = $clempprestaitem->sql_record($clempprestaitem->sql_query(null, '*', null, "e46_numemp=$e60_numemp"));

  $troca = 1;
  for ($y = 0; $y < $clempprestaitem->numrows; $y++) {
    db_fieldsmemory($result_itens, $y);

    $iLarguraNF = 22;
    $iLarguraNm = 47;
    $iLarguraDP = 58;
    $iLarguraDI = 58;

    // 12: altura das informações
    if (($pdf->gety() + 12) > ($pdf->h - 20)) {
      $pdf->addpage();
    }


    /*===========================================================
    =                         Cabeçalho                         =
    ===========================================================*/

    if ($pdf->gety() > $pdf->h - 30 || $troca != 0) {

      if ($troca == 0) {
        $pdf->addpage();
      }

      $pdf->setfont('arial', 'b', 8);

      // Código
      $largura = 15;
      $_x = $pdf->getX();
      $_y = $pdf->getY();
      $pdf->multicell($largura, ($alt * 2), $RLe46_codigo, 1, "C", 1);

      // Nota Fiscal
      $pdf->setxy(($_x + $largura), $_y);
      $_x = $pdf->getX();
      $_y = $pdf->getY();
      $pdf->multicell($iLarguraNF, ($alt * 2), trim($RLe46_nota), 1, "C", 1);

      // Nome
      $pdf->setxy(($_x + $iLarguraNF), $_y);
      $_x = $pdf->getX();
      $_y = $pdf->getY();
      $pdf->multicell($iLarguraNm, ($alt * 2), $RLe46_nome, 1, "C", 1);

      // CPF/CNPJ
      $pdf->setxy(($_x + $iLarguraNm), $_y);
      $_x = $pdf->getX();
      $_y = $pdf->getY();
      $largura = 25;
      $pdf->multicell($largura, ($alt * 2), "{$RLe46_cpf}/{$RLe46_cnpj}", 1, "C", 1);

      // Descrição da Prestação de Contas
      $pdf->setxy(($_x + $largura), $_y);
      $_x = $pdf->getX();
      $_y = $pdf->getY();
      $pdf->multicell($iLarguraDP, $alt, "Descrição da\nPrestação de Contas", 1, "C", 1);

      // Descrição do Item
      $pdf->setxy(($_x + $iLarguraDP), $_y);
      $_x = $pdf->getX();
      $_y = $pdf->getY();
      $pdf->multicell($iLarguraDI, ($alt * 2), "Descrição do Item", 1, "C", 1);

      // Quantidade
      $pdf->setxy(($_x + $iLarguraDI), $_y);
      $_x = $pdf->getX();
      $_y = $pdf->getY();
      $largura = 15;
      $pdf->multicell($largura, ($alt * 2), "Quant.", 1, "C", 1);

      // Valores
      $pdf->setxy(($_x + $largura), $_y);
      $_x = $pdf->getX();
      $_y = $pdf->getY();
      $largura = 35;
      $pdf->multicell($largura, $alt, "Valor", 1, "C", 1);

      // Valor Unitário
      $pdf->setxy($_x, ($_y + $alt));
      $_x = $pdf->getX();
      $_y = $pdf->getY();
      $pdf->multicell($largura/2, $alt, "Unit.", 1, "C", 1);

      // Valor Total
      $pdf->setxy(($_x + ($largura / 2)), $_y);
      $_x = $pdf->getX();
      $_y = $pdf->getY();
      $pdf->multicell($largura/2, $alt, "Total", 1, "C", 1);

      $troca = 0;

    }

    /*==================  End of Cabeçalho  ===================*/


    $troca = 0;
    $pdf->setfont('arial', '', 7);
    $alt = 4;


    /*======================================================
    =            Tratamento de altura de linhas            =
    ======================================================*/

    $nNumRows = 0;

    $nQtdRowsNome = $pdf->nQtdRows($e46_nome, 50);
    $nQtdRowsDsPC = $pdf->nQtdRows($e46_descr, 60);
    $nQtdRowsDsIT = $pdf->nQtdRows($pc01_descrmater, 60);

    if ($nQtdRowsNome > $nNumRows) {
      $nNumRows = $nQtdRowsNome;
    }
    if ($nQtdRowsDsPC > $nNumRows) {
      $nNumRows = $nQtdRowsDsPC;
    }
    if ($nQtdRowsDsIT > $nNumRows) {
      $nNumRows = $nQtdRowsDsIT;
    }

    $altMCell = $alt * $nNumRows;

    /*=====  End of Tratamento de altura de linhas  ======*/


    /*===============================
    =            Valores            =
    ===============================*/

    // Código
    $largura = 15;
    $_x = $pdf->getX();
    $_y = $pdf->getY();
    $pdf->multicell($largura, $altMCell, $e46_codigo, 0, "C");

    // Nota Fiscal
    $pdf->setxy(($_x + $largura), $_y);
    $_x = $pdf->getX();
    $_y = $pdf->getY();
    $pdf->multicell($iLarguraNF, $altMCell, substr($e46_nota, 0, 8), 0, "C");

    // Nome
    $pdf->setxy(($_x + $iLarguraNF), $_y);
    $_x = $pdf->getX();
    $_y = $pdf->getY();
    $pdf->multicell($iLarguraNm, ($altMCell / $nQtdRowsNome), $e46_nome, 0, "L");

    // CPF/CNPJ
    $pdf->setxy(($_x + $iLarguraNm), $_y);
    $_x = $pdf->getX();
    $_y = $pdf->getY();
    $largura = 25;
    $sCPF_CNPJ = !empty($e46_cnpj) ? mascaraCNPJ($e46_cnpj) : mascaraCPF($e46_cpf);
    $pdf->multicell($largura, $altMCell, $sCPF_CNPJ, 0, "C");

    // Descrição da Prestação de Contas
    $pdf->setxy(($_x + $largura), $_y);
    $_x = $pdf->getX();
    $_y = $pdf->getY();
    $pdf->multicell($iLarguraDP, ($altMCell / $nQtdRowsDsPC), $e46_descr, 0, "L");

    // Descrição do Item
    $pdf->setxy(($_x + $iLarguraDI), $_y);
    $_x = $pdf->getX();
    $_y = $pdf->getY();
    $largura = 60;
    $pdf->multicell($largura, ($altMCell / $nQtdRowsDsIT), $pc01_descrmater, 0, "L");

    // Quantidade
    $pdf->setxy(($_x + $iLarguraDI), $_y);
    $_x = $pdf->getX();
    $_y = $pdf->getY();
    $largura = 15;
    $pdf->multicell($largura, $altMCell, $e46_quantidade, 0, "C");


    // Valor Unitário
    $pdf->setxy(($_x + $largura), $_y);
    $largura = 35/2;
    $_x = $pdf->getX();
    $_y = $pdf->getY();
    $pdf->multicell($largura, $altMCell, db_formatar($e46_valorunit, 'f'), 0, "C");

    // Valor Total
    $pdf->setxy(($_x + $largura), $_y);
    $_x = $pdf->getX();
    $_y = $pdf->getY();
    $pdf->multicell($largura, $altMCell, db_formatar($e46_valor, 'f'), 0, "C");
    $sObsItem = substr($e46_obs, 0, 250);
    $pdf->multicell(275, $alt, "Observação:\n{$sObsItem}", 0, "L");

    // separa
    $pdf->Line($pdf->getX(), $pdf->getY(), 285, $pdf->getY());

    /*=====  End of Valores  ======*/

    $valortotal += $e46_valor;
  }

} // end FOR


// 35: altura das informações
if (($pdf->gety() + 35) > ($pdf->h - 20)) {
  $pdf->addpage();
}



$pdf->setfont('arial', 'b', 8);
$pdf->cell(275, $alt, 'TOTAL :' . db_formatar($valortotal, 'f'), "TB", 1, "R", 1);
$pdf->cell(257.5, $alt, 'VALOR DO EMPENHO : ', 0, 0, "R", 0);
$pdf->cell(30, $alt, db_formatar($e60_vlremp, 'f'), 0, 1, "L", 0);

$valor_diferenca = $e60_vlremp - $e60_vlranu - $valortotal;

if ($valor_diferenca < 0) {

  $sLabel = "DESPESA GLOSADA: ";

} else {

  $sLabel = "ANULAR DE DESPESA: ";

}

$pdf->cell(257.5, $alt, $sLabel, 0, 0, "R", 0);
$pdf->cell(30, $alt, db_formatar($valor_diferenca, 'f'), 0, 1, "L", 0);


/*===================================
=            Assinaturas            =
===================================*/

$aTitulosAssinaturas[] = $classinatura->assinatura(9002, '', '0');
$aTitulosAssinaturas[] = $classinatura->assinatura(9002, '', '1');
$aTitulosAssinaturas[] = $classinatura->assinatura(9002, '', '2');
$aTitulosAssinaturas[] = $classinatura->assinatura(9002, '', '3');
$aTitulosAssinaturas[] = $classinatura->assinatura(9002, '', '4');

$aTitulosAssinaturas = array_filter($aTitulosAssinaturas, function($sStr) {
  return !empty($sStr);
});

// largura da 'coluna' que cada assinatura vai ocupar
$largura = ($pdf->w) / count($aTitulosAssinaturas);

$pdf->ln(10);
$pos = $pdf->gety();

// Imprime os campos de assinaturas
foreach ($aTitulosAssinaturas as $key => $sLegenda) {

  $sLegenda = "______________________________\n" . $sLegenda;

  $pdf->setxy(($largura * $key), $pos);
  $pdf->multicell($largura, 4, $sLegenda, 0, "C", 0, 0);

}

/*=====  End of Assinaturas  ======*/

$pdf->Output();

?>
