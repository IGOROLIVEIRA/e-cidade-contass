<?php
require_once("fpdf151/pdf.php");
require_once("libs/db_sql.php");
require_once("classes/db_cgm_classe.php");
include("classes/db_termoanu_classe.php");

$cltermoanu = new cl_termoanu;
$clcgm    = new cl_cgm;
$clrotulo = new rotulocampo;
$clrotulo->label("t64_class"); //classificação

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);

if ($opcao == "cgm") {
    $where = "and arrenumcgm.k00_numcgm = $codopcao";
} else if ($opcao == "matric") {
    $where = "and arrematric.k00_matric = $codopcao";
} else if ($opcao == "inscr") {
    $where = "and arreinscr.k00_inscr = $codopcao";
} else if ($opcao == "numpre") {
    $where = "and termo.v07_numpre = $codopcao";
} else if ($opcao == "parcel") {
    $where = "and termoanu.v09_parcel = $codopcao";
}

$campos     = " distinct v07_parcel, ";
$campos    .= "          v07_numpre, ";
$campos    .= "          v07_dtlanc, ";
$campos    .= "          v07_numcgm, ";
$campos    .= "          case ";
$campos    .= "            when termoini.parcel        is not null then 'Parcelamento de inicial' ";
$campos    .= "            when termodiv.parcel        is not null then 'Parcelamento de divida' ";
$campos    .= "            when termodiver.dv10_parcel is not null then 'Parcelamento de diversos' ";
$campos    .= "            when termocontrib.parcel    is not null then 'Parcelamento de contribuicao de melhoria' ";
$campos    .= "            when termoreparc.v08_parcel is not null then 'Reparcelamento' ";
$campos    .= "          end as tipoparcel, ";
$campos    .= "          v07_valor, ";
$campos    .= "          nome, ";
$campos    .= "          v09_data, ";
$campos    .= "          v09_hora, ";
$campos    .= "          v09_motivo, ";
$campos    .= "          arrepaga.k00_numpar, ";
$campos    .= "          arrepaga.k00_dtpaga";

$rsTermoAnu = $cltermoanu->sql_record($cltermoanu->sqlQueryTermoOrigem(null, $campos, null, "termo.v07_instit = " . db_getsession('DB_instit') . " " . $where));

if ($cltermoanu->numrows == 0) {
    db_redireciona("db_erros.php?fechar=true&db_erro=Nenhum registro encontrado");
}else{
    $dbTermoAnu = db_utils::fieldsMemory($rsTermoAnu,0);
}

$sSql = "SELECT * FROM cgm WHERE z01_numcgm = " . $dbTermoAnu->v07_numcgm;
$cgm  = db_query($sSql);
$numrows = pg_numrows($cgm);

if ($numrows == 0) {
    db_redireciona("db_erros.php?fechar=true&db_erro=Nenhum registro encontrado");
}

db_fieldsmemory($cgm, 0);
$sSqlCgm    = $clcgm->sql_query_file($dbTermoAnu->v07_numcgm, "z01_nome, z01_ender, z01_munic, z01_uf, z01_cgccpf, z01_ident, z01_numero");
$result_cgm = $clcgm->sql_record($sSqlCgm);
if ($clcgm->numrows == 0) {
    db_redireciona("db_erros.php?fechar=true&db_erro=CGM não encontrado");
} else {

    db_fieldsmemory($result_cgm, 0);
    $head2 = "PARCELAMENTOS REVOGADOS";
    if (isset($dataini)) {
        $head3 = "Período entre " . db_formatar($dataini, 'd') . " e " . db_formatar($datafim, 'd');
    }
    $head5 = $numcgm1 . " - " . $z01_nome;
    $head6 = $z01_ender . ", " . $z01_numero;
    $head7 = $z01_munic . " / " . $z01_uf;
}

$pdf = new PDF();
$pdf->Open();
$pdf->AliasNbPages();
$pdf->setfillcolor(215);
$total = 0;
$troca = 1;
$p     = 1;
$alt   = 4;

for ($cont = 0; $cont < $numrows; $cont++) {

    db_fieldsmemory($result, $cont);

    if ($pdf->gety() > $pdf->h - 30 || $troca != 0) {

        $pdf->addpage("L");
        $pdf->setfont('arial', 'b', 8);

        $pdf->cell(18, $alt, "PARCELAM", 1, 0, "C", 1);
        $pdf->cell(15, $alt, "NUMPRE", 1, 0, "C", 1);
        $pdf->cell(18, $alt, "DT PARCEL", 1, 0, "C", 1);
        $pdf->cell(30, $alt, "TIPO", 1, 0, "C", 1);
        $pdf->cell(18, $alt, "VLR TOTAL", 1, 0, "C", 1);
        $pdf->cell(48, $alt, "REVOGADO POR", 1, 0, "C", 1);
        $pdf->cell(16, $alt, "DT REVOG", 1, 0, "C", 1);
        $pdf->cell(16, $alt, "HR REVOG", 1, 0, "C", 1);
        $pdf->cell(25, $alt, "ÚLT.PARC.PAGA", 1, 0, "C", 1);
        $pdf->cell(16, $alt, "DT PAGTO", 1, 0, "C", 1);
        $pdf->cell(60, $alt, "MOTIVO", 1, 1, "C", 1);
        $pdf->cell(280, 1, "", 0, 1, "C", 0);

        $troca = 0;
    }
    $pdf->setfont('arial', '', 6);
    if ($cont % 2 == 0) {
        $corfundo = 236;
    } else {
        $corfundo = 245;
    }
    $pdf->SetFillColor($corfundo);

    $pdf->Cell(18, $alt, $dbTermoAnu->v07_parcel, "0", 0, "C", 1);
    $pdf->cell(15, $alt, $dbTermoAnu->v07_numpre, "0", 0, "C", 1);
    $pdf->cell(18, $alt, db_formatar($dbTermoAnu->v07_dtlanc, "d"), "0", 0, "C", 1);
    $pdf->cell(30, $alt, $dbTermoAnu->tipoparcel, "0", 0, "C", 1);
    $pdf->cell(18, $alt, db_formatar($dbTermoAnu->v07_valor, "f"), "0", 0, "R", 1);
    $pdf->cell(48, $alt, $dbTermoAnu->nome, "0", 0, "L", 1);
    $pdf->cell(16, $alt, db_formatar($dbTermoAnu->v09_data, "d"), "0", 0, "C", 1);
    $pdf->cell(16, $alt, $dbTermoAnu->v09_hora, "0", 0, "C", 1);
    $pdf->cell(25, $alt, $dbTermoAnu->k00_numpar, "0", 0, "C", 1);
    $pdf->cell(16, $alt, db_formatar($dbTermoAnu->k00_dtpaga, "d"), "0", 0, "C", 1);
    $pdf->cell(60, $alt, $dbTermoAnu->v09_motivo, "0", 1, "L", 1);
    $total += $dbTermoAnu->v07_valor;
}

$pdf->setfont('arial', 'b', 8);
$pdf->cell(210, $alt, 'TOTAL REVOGADO', "T", 0, "L", 0);
$pdf->cell(75,  $alt, db_formatar($total, "f"), "T", 0, "R", 0);
$pdf->cell(5,  $alt, "", "T", 0, "L", 0);
$pdf->Output();
