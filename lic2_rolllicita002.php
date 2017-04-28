<?php
require_once("fpdf151/pdf.php");
require_once("libs/db_sql.php");
require_once("libs/db_utils.php");
require_once("classes/db_liclicita_classe.php");
require_once("classes/db_liclicitasituacao_classe.php");
require_once("classes/db_liclicitem_classe.php");
require_once("classes/db_empautitem_classe.php");
require_once("classes/db_pcorcamjulg_classe.php");
require_once("classes/db_pcprocitem_classe.php");
require_once("model/licitacao.model.php");
require_once("model/licitacao/SituacaoLicitacao.model.php");

$clliclicita = new cl_liclicita;
$clliclicitasituacao = new cl_liclicitasituacao;
$clliclicitem = new cl_liclicitem;
$clempautitem = new cl_empautitem;
$clpcorcamjulg = new cl_pcorcamjulg;
$clpcprocitem = new cl_pcprocitem;
$clrotulo = new rotulocampo;

$clrotulo->label('');
parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
db_postmemory($HTTP_SERVER_VARS);
$sWhere = "";
$sAnd = "";
if (($data != "--") && ($data1 != "--")) {

    $sWhere .= $sAnd . " l20_datacria  between '$data' and '$data1' ";
    $data = db_formatar($data, "d");
    $data1 = db_formatar($data1, "d");
    $info = "De $data at� $data1.";
    $sAnd = " and ";
} else if ($data != "--") {

    $sWhere .= $sAnd . " l20_datacria >= '$data'  ";
    $data = db_formatar($data, "d");
    $info = "Apartir de $data.";
    $sAnd = " and ";
} else if ($data1 != "--") {

    $sWhere .= $sAnd . " l20_datacria <= '$data1'   ";
    $data1 = db_formatar($data1, "d");
    $info = "At� $data1.";
    $sAnd = " and ";
}
if ($l20_codigo != "") {

    $sWhere .= $sAnd . " l20_codigo=$l20_codigo ";
    $sAnd = " and ";
    $info1 = "C�digo: ".$l20_codigo;
}
if ($l20_numero != "") {

    $sWhere .= $sAnd . " l20_numero=$l20_numero ";
    $sAnd = " and ";
    $info1 = "Numero:" . $l20_numero;
}
if ($l03_codigo != "") {

    $sWhere .= $sAnd . " l20_codtipocom=$l03_codigo ";
    $sAnd = " and ";
    if ($l03_descr != "") {
        $info2 = "Modalidade:" . $l03_codigo . "-" . $l03_descr;
    }
}
$sCampos = " distinct l20_codigo, l20_edital as processo,
l03_descr||' - '||l20_numero AS modalidade,
l20_anousu,
CASE WHEN l20_usaregistropreco=TRUE THEN 'SIM' ELSE 'NAO' end as usaregistropreco,
CASE WHEN l20_descontotab=1 THEN 'SIM' ELSE 'NAO' end as descontotabela,
l20_datacria as abertura,
l20_objeto as objeto ";
$sWhere .= $sAnd . " l20_instit = " . db_getsession("DB_instit");
$sSqlLicLicita = $clliclicita->sql_query(null, $sCampos, "4,2", $sWhere);
$result = $clliclicita->sql_record($sSqlLicLicita);
$numrows = $clliclicita->numrows;

if ($numrows == 0) {

    db_redireciona('db_erros.php?fechar=true&db_erro=N�o existe registro cadastrado.');
    exit;
}

$head2 = "Roll de Licita��es";
$head3 = @$info;
$head4 = @$info1;
$head5 = @$info2;
$pdf = new PDF('Landscape', 'mm', 'A4');
$pdf->Open();
$pdf->AliasNbPages();
$total = 0;
$pdf->setfillcolor(235);
$pdf->setfont('arial', 'b', 8);
$troca = 1;
$alt = 4;
$total = 0;
$p = 0;
$valortot = 0;
$muda = 0;
$mostraAndam = $mostramov;
$oInfoLog = array();
for ($i = 0; $i < $numrows; $i++) {

    db_fieldsmemory($result, $i);


    if ($pdf->gety() > $pdf->h - 30 || $muda == 0) {

        $pdf->addpage();
        $muda = 1;
    }
    if (strlen($objeto) > 80) {
        $aObjeto = quebrar_texto($objeto, 80);
        $alt_novo = count($aObjeto);
    } else {
        $alt_novo = 1;
    }

    $troca = 1;

    $pdf->setfont('arial', 'b', 7);
    $pdf->cell(20, $alt, "Processo", 1, 0, "C", 1);
    $pdf->cell(60, $alt, 'Modalidade', 1, 0, "C", 1);
    $pdf->cell(20, $alt, 'Exerc�cio', 1, 0, "C", 1);
    $pdf->cell(20, $alt, 'R.P.', 1, 0, "C", 1);
    $pdf->cell(20, $alt, 'Tabela', 1, 0, "C", 1);
    $pdf->cell(20, $alt, 'Abertura', 1, 0, "C", 1);
    $pdf->cell(117, $alt, 'Objeto', 1, 1, "C", 1);
    $pdf->setfont('arial', '', 7);
    $pdf->cell(20, $alt*$alt_novo, $processo, 1, 0, "C", 0);
    $pdf->cell(60, $alt*$alt_novo, $modalidade, 1, 0, "C", 0);
    $pdf->cell(20, $alt*$alt_novo, $l20_anousu, 1, 0, "C", 0);
    $pdf->cell(20, $alt*$alt_novo, $usaregistropreco, 1, 0, "C", 0);
    $pdf->cell(20, $alt*$alt_novo, $descontotabela, 1, 0, "C", 0);
    $pdf->cell(20, $alt*$alt_novo, db_formatar($abertura, "d"), 1, 0, "C", 0);

    if (strlen($objeto) > 80) {

        $pos_x = $pdf->x;
        $pos_y = $pdf->y;
        $pdf->cell(117, $alt*$alt_novo, "", 1, 1, "L", 0);
        $pdf->x = $pos_x;
        $pdf->y = $pos_y;
        foreach ($aObjeto as $oObjeto) {
            $pdf->cell(117, ($alt), $oObjeto, 0, 1, "L", 0);
            $pdf->x = $pos_x;
        }
        $pdf->x = $pos_x - 160;
    } else {
        $pdf->cell(117, $alt*$alt_novo, $objeto, 1, 1, "L", 0);
    }


    $sSqlFornecedores = " select distinct
l206_fornecedor||' - '||z01_nome AS fornecedor,
si172_nrocontrato  as contrato,
si172_dataassinatura,
si172_datainiciovigencia,
si172_datafinalvigencia
 FROM contratos
 inner JOIN cgm ON si172_fornecedor=z01_numcgm
 inner join habilitacaoforn on l206_fornecedor = si172_fornecedor
where
si172_licitacao = {$l20_codigo} order by 2";
    $result_fornecedores = db_query($sSqlFornecedores) or die(pg_last_error());

    if (pg_num_rows($result_fornecedores) > 0) {

        $pdf->setfont('arial', 'b', 7);
        $pdf->cell(165, $alt, "Fornecedores", 1, 0, "L", 1);
        $pdf->cell(20, $alt, "Contrato", 1, 0, "C", 1);
        $pdf->cell(32, $alt, "Data Assinatura", 1, 0, "C", 1);
        $pdf->cell(30, $alt, "Data Inicio", 1, 0, "C", 1);
        $pdf->cell(30, $alt, "Data Final", 1, 1, "C", 1);

        for ($w = 0; $w < pg_num_rows($result_fornecedores); $w++) {

            db_fieldsmemory($result_fornecedores, $w);



            $pdf->setfont('arial', '', 7);
            $pdf->cell(165, $alt, $fornecedor, 1, 0, "L", $p);
            $pdf->cell(20, $alt, $contrato, 1, 0, "C", $p);
            $pdf->cell(32, $alt, db_formatar($si172_dataassinatura, "d"), 1, 0, "C", $p);
            $pdf->cell(30, $alt, db_formatar($si172_datainiciovigencia, "d"), 1, 0, "C", $p);
            $pdf->cell(30, $alt, db_formatar($si172_datafinalvigencia, "d"), 1, 1, "C", $p);

        }
    }
    /**
     * Status da Licita��o
     * @see OC 3153
     */
    $oLicitacao = new licitacao($l20_codigo);
    $pdf->setfont('arial', 'b', 7);
    $pdf->cell(277, $alt, "Status: {$oLicitacao->getSituacao()->getSDescricao()}", 1, 1, "L", 1);
    $pdf->ln();
}
$pdf->Output();


function quebrar_texto($texto, $tamanho)
{

    $aTexto = explode(" ", $texto);
    $string_atual = "";
    foreach ($aTexto as $word) {
        $string_ant = $string_atual;
        $string_atual .= " " . $word;
        if (strlen($string_atual) > $tamanho) {
            $aTextoNovo[] = trim($string_ant);
            $string_ant = "";
            $string_atual = $word;
        }
    }
    $aTextoNovo[] = trim($string_atual);
    return $aTextoNovo;

}

?>
