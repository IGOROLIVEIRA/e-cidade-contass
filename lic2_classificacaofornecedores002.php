<?php
require_once("fpdf151/pdf.php");
require_once("libs/db_sql.php");
require_once("libs/db_utils.php");
require_once("classes/db_liclicita_classe.php");
require_once("classes/db_liclicitasituacao_classe.php");
require_once("classes/db_liclicitem_classe.php");
require_once("classes/db_empautitem_classe.php");
require_once("classes/db_pcorcamjulg_classe.php");
require_once("model/licitacao.model.php");

$clliclicita         = new cl_liclicita;
$clliclicitasituacao = new cl_liclicitasituacao;
$clliclicitem        = new cl_liclicitem;
$clempautitem        = new cl_empautitem;
$clpcorcamjulg       = new cl_pcorcamjulg;
$clrotulo            = new rotulocampo;

$clrotulo->label('');
parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
db_postmemory($HTTP_SERVER_VARS);
$sWhere = "";
$sAnd   = "";
if (($data != "--") && ($data1 != "--")) {

  $sWhere .= $sAnd . " l20_datacria  between '$data' and '$data1' ";
  $data = db_formatar($data, "d");
  $data1 = db_formatar($data1, "d");
  $info = "De $data até $data1.";
  $sAnd = " and ";
} else if ($data != "--") {

  $sWhere .= $sAnd . " l20_datacria >= '$data'  ";
  $data = db_formatar($data, "d");
  $info = "Apartir de $data.";
  $sAnd = " and ";
} else if ($data1 != "--") {

  $sWhere .= $sAnd . " l20_datacria <= '$data1'   ";
  $data1 = db_formatar($data1, "d");
  $info = "Até $data1.";
  $sAnd = " and ";
}
if ($l20_codigo != "") {

  $sWhere .= $sAnd . " l20_codigo=$l20_codigo ";
  $sAnd = " and ";
}
if ($l20_numero != "") {

  $sWhere .= $sAnd . " l20_numero=$l20_numero ";
  $sAnd = " and ";
  $info1 = "Numero: " . $l20_numero;
}
if ($l03_codigo != "") {

  $sWhere .= $sAnd . " l20_codtipocom=$l03_codigo ";
  $sAnd = " and ";
  if ($l03_descr != "") {
    $info2 = "Modalidade: " . $l03_codigo . " - " . mb_convert_encoding($l03_descr, 'ISO-8859-1', 'UTF-8');;
  }
}

$sWhere        .= $sAnd . " l20_licsituacao in (1, 10, 13) and l20_instit = " . db_getsession("DB_instit");
$sSqlLicLicita  = $clliclicita->sql_query(null, "distinct l20_codigo, l20_codtipocom,l20_edital,l20_dataaber,l20_objeto,l20_numero,l03_descr,l20_anousu,l20_datacria", "l20_codtipocom,l20_numero,l20_anousu", $sWhere);
$result         = $clliclicita->sql_record($sSqlLicLicita);
$numrows        = $clliclicita->numrows;

if ($numrows == 0) {
  db_redireciona('db_erros.php?fechar=true&db_erro=Não existe registro cadastrado.');
  exit;
}

$head2 = "Classificação de Fornecedores";
$head3 = @$info;
$head4 = @$info1;
$head5 = @$info2;

if ($tipo == "PDF") {

  $pdf   = new PDF('L');
  $pdf->Open();
  $pdf->AliasNbPages();
  $total = 0;
  $pdf->setfillcolor(235);
  $pdf->setfont('arial', 'b', 8);
  $troca       = 1;
  $alt         = 4;
  $total       = 0;
  $p           = 0;
  $valortot    = 0;
  $muda        = 0;
  $mostraAndam = $mostramov;
  $oInfoLog    = array();

  for ($i = 0; $i < $numrows; $i++) {

    db_fieldsmemory($result, $i);

    $pdf->addpage();

    $pdf->setfont('arial', 'b', 8);
    $pdf->cell(30, $alt, 'Código Sequencial:', 0, 0, "R", 0);
    $pdf->setfont('arial', '', 7);
    $pdf->cell(60, $alt, $l20_codigo, 0, 1, "L", 0);

    $pdf->setfont('arial', 'b', 8);
    $pdf->cell(30, $alt, 'Processo :', 0, 0, "R", 0);
    $pdf->setfont('arial', '', 7);
    $pdf->cell(30, $alt, $l20_edital, 0, 0, "L", 0);


    $pdf->setfont('arial', 'b', 8);
    $pdf->cell(80, $alt, 'Modalidade :', 0, 0, "R", 0);
    $pdf->setfont('arial', '', 7);
    $pdf->cell(60, $alt, $l03_descr, 0, 1, "L", 0);

    $pdf->setfont('arial', 'b', 8);
    $pdf->cell(30, $alt, 'Data Abertura :', 0, 0, "R", 0);
    $pdf->setfont('arial', '', 7);
    $pdf->cell(30, $alt, db_formatar($l20_datacria, 'd'), 0, 0, "L", 0);

    $pdf->setfont('arial', 'b', 8);
    $pdf->cell(80, $alt, 'Número :', 0, 0, "R", 0);
    $pdf->setfont('arial', '', 7);
    $pdf->cell(30, $alt, $l20_numero, 0, 1, "L", 0);

    $pdf->setfont('arial', 'b', 8);
    $pdf->cell(30, $alt, 'Objeto :', 0, 0, "R", 0);
    $pdf->setfont('arial', 'b', 8);
    $pdf->multicell(250, $alt, $l20_objeto, 0, "L", 0);

    $pdf->cell(280, $alt, '', 'T', 1, "L", 0);

    $troca = 1;

    $subWhere = " WHERE l20_codigo = {$l20_codigo}";
    $subOrder = " order by l21_ordem, pc24_pontuacao";

    if ($tipo == 2) {
      $subWhere .= " and pc24_pontuacao = 1";
    }

    $sSql = "SELECT DISTINCT
          l21_ordem as codigo,
          case
            when pc01_descrmater=pc01_complmater or pc01_complmater is null then pc01_descrmater
            else pc01_descrmater || '. ' || pc01_complmater
          end as descricao,
          --pc01_descrmater as descricao,
          matunid.m61_descr,
          pc23_quant,
          pc23_vlrun,
          pc23_valor,
          z01_nome|| ' - ' ||z01_cgccpf as fornecedor,
          l21_ordem,
          pc24_pontuacao
        FROM liclicitem
          --INNER JOIN liclicitemlote on l04_liclicitem=l21_codigo
          INNER JOIN pcprocitem ON liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem
          INNER JOIN pcproc ON pcproc.pc80_codproc = pcprocitem.pc81_codproc
          INNER JOIN solicitem ON solicitem.pc11_codigo = pcprocitem.pc81_solicitem
          INNER JOIN solicita ON solicita.pc10_numero = solicitem.pc11_numero
          INNER JOIN db_depart ON db_depart.coddepto = solicita.pc10_depto
          INNER JOIN liclicita ON liclicita.l20_codigo = liclicitem.l21_codliclicita
          INNER JOIN cflicita ON cflicita.l03_codigo = liclicita.l20_codtipocom
          INNER JOIN pctipocompra ON pctipocompra.pc50_codcom = cflicita.l03_codcom
          INNER JOIN solicitemunid ON solicitemunid.pc17_codigo = solicitem.pc11_codigo
          INNER JOIN matunid ON matunid.m61_codmatunid = solicitemunid.pc17_unid
          LEFT JOIN pcorcamitemlic ON l21_codigo = pc26_liclicitem
          INNER JOIN pcorcamval ON pc26_orcamitem = pc23_orcamitem
          INNER JOIN pcorcamjulg ON pcorcamval.pc23_orcamitem = pcorcamjulg.pc24_orcamitem AND pcorcamval.pc23_orcamforne = pcorcamjulg.pc24_orcamforne
          INNER JOIN pcorcamforne ON pc21_orcamforne = pc23_orcamforne
          INNER JOIN cgm ON pc21_numcgm = z01_numcgm
          INNER JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
          INNER JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater
          INNER join pcorcamitem on pc22_orcamitem=pc26_orcamitem";

    $sSql = $sSql . $subWhere . $subOrder;

    $result_itens = $clliclicitem->sql_record($sSql);
    if ($clliclicitem->numrows > 0) {
      $ordem = 0;

      for ($w = 0; $w < $clliclicitem->numrows; $w++) {

        db_fieldsmemory($result_itens, $w);

        if ($ordem != $l21_ordem) {
          $troca = 1;
        }

        if ($pdf->gety() > $pdf->h - 30 || $troca != 0) {

          if ($pdf->gety() > $pdf->h - 30) {
            $pdf->addpage();
          }

          $pdf->cell(280, $alt * 2, "", 0, 1, "L", 0);

          $pdf->setfont('arial', 'b', 8);

          // Remove quebras de linhas
          $text = str_replace(array("\n", "\r"), ' ', $descricao);
          $text = mb_convert_encoding($text, 'UTF-8', 'ISO-8859-1');
          $text = mb_strtoupper($text, 'UTF-8');
          $text = mb_convert_encoding($text, 'ISO-8859-1', 'UTF-8');
          $pdf->setfont('arial', '', 7);

          $textWidth = $pdf->GetStringWidth($text) * 1.0339;
          $tamanho  = $textWidth > 235 ? ceil($textWidth / 235) : 1;

          $pdf->setfont('arial', 'b', 8);

          $pdf->cell(20, $alt, "ITEM", 1, 0, "C", 0);
          $pdf->cell(235, $alt, 'DESCRIÇÃO ', 1, 0, "C", 0);
          $pdf->cell(25, $alt, 'UNIDADE', 1, 1, "C", 0);



          $pdf->setfont('arial', '', 7);
          $pdf->cell(20, $alt * $tamanho, $codigo, 1, 0, "C", 0);

          // Pega o x e y antes do multicell
          $x = $pdf->GetX();
          $y = $pdf->GetY();

          $pdf->MultiCell(235, $alt, $text, 0, "J", 0);

          // Reseta o x e o y adiciona o tamanho do multicell ao y
          $pdf->SetXY($x + 235, $y);
          $pdf->cell(25, $alt * $tamanho, strtoupper($m61_descr), 1, 1, "C", 0);

          // Adiciona segundo header
          $pdf->setfont('arial', 'b', 8);
          $pdf->cell(20, $alt, 'COLOCAÇÃO', 1, 0, "C", 0);
          $pdf->cell(195, $alt, 'FORNECEDOR', 1, 0, "L", 0);
          $pdf->cell(15, $alt, 'QTDD', 1, 0, "C", 0);
          $pdf->cell(25, $alt, 'VLR UNIT.', 1, 0, "C", 0);
          $pdf->cell(25, $alt, 'VLR TOTAL', 1, 1, "C", 0);

          $troca = 0;
          $p     = 0;
        }

        $pdf->setfont('arial', '', 7);
        $pdf->cell(20, $alt, $pc24_pontuacao, 1, 0, "C", $p);
        $pdf->cell(195, $alt, $fornecedor, 1, 0, "L", $p);
        $pdf->cell(15, $alt, $pc23_quant, 1, 0, "C", 0);
        $pdf->cell(25, $alt, 'R$ ' . db_formatar($pc23_vlrun, "f"), 1, 0, "C", $p);
        $pdf->cell(25, $alt, 'R$ ' . db_formatar($pc23_valor, "f"), 1, 1, "C", $p);


        $ordem = $l21_ordem;
        $troca = 0;
      }
    }
  }
  $pdf->Output();
} else {
  /**
   * BUSCA DADOS DA INSTITUICAO
   *
   */

  $sqldados = "select 
            nomeinst,
            bairro,
            cgc,
            trim(ender)||','||trim(cast(numero as text)) as ender,
            upper(munic) as munic,
            uf,
            telef,
            email,
            url,
            logo, 
            db12_extenso
          from db_config  inner join db_uf on db12_uf = uf
          where codigo = " . db_getsession("DB_instit");
  $resultdados = db_query($sqldados);
  db_fieldsmemory($resultdados, 0);

  header("Content-type: application/vnd.ms-word; charset=UTF-8");
  header("Content-Disposition: attachment; Filename=Classificacao_de_fornecedores.doc");
  for ($i = 0; $i < $numrows; $i++) {
  }
}
?>



<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html xmlns:office="urn:schemas-microsoft-com:office:office" xmlns:word="urn:schemas-microsoft-com:office:word" xmlns="http://www.w3.org/TR/REC-html40">

<head>
  <title><?= $head2 ?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <style>
    @page WordSection1 {
      size: 11.0in 8.5in;
      mso-page-orientation: landscape;
      margin: 1.0in 1.0in 1.0in 1.0in;
      mso-header-margin: .5in;
      mso-footer-margin: .5in;
      mso-paper-source: 0;
      /* Additional styles for headers and footers */
      mso-header: "Header content here";
      mso-footer: "Footer content here";
    }

    div.WordSection1 {
      page: WordSection1;
      color: #333333;
    }

    body {
      font-family: Arial, sans-serif;
      font-size: 8pt;
    }

    div {
      text-align: center;
      border: 1px solid black;
    }

    .table-header {
      border: 0;
      padding: 1px;
    }

    .table-header th {
      font-weight: bold;
      text-align: right;
    }

    .table-header tr {
      text-align: left;
    }

    .table-item {
      border-collapse: collapse;
      width: 100%;
    }

    .table-item tr,
    .table-item td,
    .table-item th {
      border: 1px solid black;
      padding: 8px;
      text-align: center;
    }

    .table-item th {
      font-weight: bold;
      text-align: center;
      border: 1px solid black;
    }

    .headertr {
      margin-top: 10px;
      font-size: 11px;
      width: auto;
    }

    .page-break {
      page-break-after: always;
    }
  </style>
</head>

<body>
  <div class=WordSection1>
    <table>
      <tr>
        <td width=641>
          <? echo "<b>".$nomeinst . "</b><br>" . $ender . "<br>" . $munic . " - " . $uf . "<br>" . $telef . " - CNPJ : " . $cgc . "<br>" . $email . "<br>" . $url . "</p>"; ?>
        </td>
        <td width=221 colspan=4 style="text-align: right;">
          <?= $head2 ?><br />
          <?= $head3 ?><br />
          <?= $head4 ?><br />
          <?= $head5 ?><br />
        </td>
      <tr>
    </table>
    <hr style="border: 6px solid #000000;">
    <? for ($i = 0; $i < $numrows; $i++) { ?>
      <? db_fieldsmemory($result, $i); ?>
      <? if ($i > 0) {
        echo "<br clear=all style='page-break-before:always'>";
      } ?>
      <table width="100%" class="table-header">
        <tr>
          <th width=115>Código Sequencial:</th>
          <td width=743 colspan=3 style="text-align: left;"><?= $l20_codigo ?></td>
        </tr>
        <tr>
          <th width=115>Processo:</th>
          <td width=312 style="text-align: left;"><?= $l20_edital ?></td>
          <th width=115>Modalidade:</th>
          <td width=312 style="text-align: left;"><?= $l03_descr ?></td>
        </tr>
        <tr>
          <th width="115">Data Abertura:</th>
          <td width="312" style="text-align: left;"><?= db_formatar($l20_datacria, 'd') ?></td>
          <th width="115">Número:</th>
          <td width="312" style="text-align: left;"><?= $l20_numero ?></td>
        </tr>
        <tr>
          <th width=115>Objeto:</th>
          <td width=743 colspan="3" style="font-weight: bold; text-align: left;"><?= $l20_objeto ?></td>
        </tr>
      </table>
      <hr style="border: 6px solid #000000;">
      <?

      $troca = 1;

      $subWhere = " WHERE l20_codigo = {$l20_codigo}";
      $subOrder = " order by l21_ordem, pc24_pontuacao";

      if ($tipo == 2) {
        $subWhere .= " and pc24_pontuacao = 1";
      }

      $sSql = "SELECT DISTINCT
          l21_ordem as codigo,
          case
            when pc01_descrmater=pc01_complmater or pc01_complmater is null then pc01_descrmater
            else pc01_descrmater || '. ' || pc01_complmater
          end as descricao,
          --pc01_descrmater as descricao,
          matunid.m61_descr,
          pc23_quant,
          pc23_vlrun,
          pc23_valor,
          z01_nome|| ' - ' ||z01_cgccpf as fornecedor,
          l21_ordem,
          pc24_pontuacao
        FROM liclicitem
          --INNER JOIN liclicitemlote on l04_liclicitem=l21_codigo
          INNER JOIN pcprocitem ON liclicitem.l21_codpcprocitem = pcprocitem.pc81_codprocitem
          INNER JOIN pcproc ON pcproc.pc80_codproc = pcprocitem.pc81_codproc
          INNER JOIN solicitem ON solicitem.pc11_codigo = pcprocitem.pc81_solicitem
          INNER JOIN solicita ON solicita.pc10_numero = solicitem.pc11_numero
          INNER JOIN db_depart ON db_depart.coddepto = solicita.pc10_depto
          INNER JOIN liclicita ON liclicita.l20_codigo = liclicitem.l21_codliclicita
          INNER JOIN cflicita ON cflicita.l03_codigo = liclicita.l20_codtipocom
          INNER JOIN pctipocompra ON pctipocompra.pc50_codcom = cflicita.l03_codcom
          INNER JOIN solicitemunid ON solicitemunid.pc17_codigo = solicitem.pc11_codigo
          INNER JOIN matunid ON matunid.m61_codmatunid = solicitemunid.pc17_unid
          LEFT JOIN pcorcamitemlic ON l21_codigo = pc26_liclicitem
          INNER JOIN pcorcamval ON pc26_orcamitem = pc23_orcamitem
          INNER JOIN pcorcamjulg ON pcorcamval.pc23_orcamitem = pcorcamjulg.pc24_orcamitem AND pcorcamval.pc23_orcamforne = pcorcamjulg.pc24_orcamforne
          INNER JOIN pcorcamforne ON pc21_orcamforne = pc23_orcamforne
          INNER JOIN cgm ON pc21_numcgm = z01_numcgm
          INNER JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
          INNER JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater
          INNER join pcorcamitem on pc22_orcamitem=pc26_orcamitem";

      $sSql = $sSql . $subWhere . $subOrder;

      $result_itens = $clliclicitem->sql_record($sSql);
      if ($clliclicitem->numrows > 0) {
        $ordem = 0;

        for ($w = 0; $w < $clliclicitem->numrows; $w++) {

          db_fieldsmemory($result_itens, $w);

          if ($ordem != $l21_ordem) {
            $troca = 1;
          }

          if ($troca != 0) {

            if ($w > 0) {
              echo "<br clear=all style='page-break-before:always'>";
            }

            $text = str_replace(array("\n", "\r"), ' ', $descricao);
            $text = mb_convert_encoding($text, 'UTF-8', 'ISO-8859-1');
            $text = mb_strtoupper($text, 'UTF-8');
            $text = mb_convert_encoding($text, 'ISO-8859-1', 'UTF-8');

            if ($w > 0) {
              echo "</table>";
            }

      ?>
            <br /><br />
            <table class="table-item" border="1">
              <tr>
                <td width="100" style="font-weight: bold;">ITEM</td>
                <td colspan=3 style="font-weight: bold;">DESCRIÇÃO</td>
                <td width="100" style="font-weight: bold;">UNIDADE</td>
              </tr>
              <tr>
                <td width="100"><?= $codigo ?></td>
                <td width="665" colspan=3 style="text-align: justify;"><?= $text ?></td>
                <td width="100"><?= strtoupper($m61_descr) ?></td>
              </tr>
              <tr>
                <th width="100">COLOCAÇÃO</th>
                <th width=515 style="text-align: left; font-weight: bold;">FORNECEDOR</th>
                <th width="50" style="font-weight: bold;">QTDD</th>
                <th width="100" style="font-weight: bold;">VLR UNIT.</th>
                <th width="100" style="font-weight: bold;">VLR TOTAL</th>
              </tr>
            <?
          }
            ?>
            <tr>
              <td width="100"><?= $pc24_pontuacao ?></td>
              <td width=515 style="text-align: left;"><?= $fornecedor ?></td>
              <td width="50"><?= $pc23_quant ?></td>
              <td width="100" style="text-align: right;"><?= 'R$' . db_formatar($pc23_vlrun, "f") ?></td>
              <td width="100" style="text-align: right;"><?= 'R$' . db_formatar($pc23_valor, "f") ?></td>
            </tr>
        <?
          $ordem = $l21_ordem;
          $troca = 0;
        }
        echo "</table>";
      }
        ?>

      <? } ?>
  </div>
</body>

</html>