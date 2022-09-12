<?php
require_once("fpdf151/pdf.php");
require_once("libs/db_sql.php");
require_once("libs/db_utils.php");
require_once("classes/db_liclicita_classe.php");


$clliclicita = new cl_liclicita;
$clrotulo = new rotulocampo;

$clrotulo->label('');
parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
db_postmemory($HTTP_SERVER_VARS);

/*
if ($numrows == 0) {

    db_redireciona('db_erros.php?fechar=true&db_erro=Não existe registro cadastrado.');
    exit;
}
*/

$licita = db_query("select * from liclicita inner join cflicita on l03_codigo = l20_codtipocom
where  l20_codigo = $licitacao");
$licita = db_utils::fieldsMemory($licita, 0);


$oPDF = new PDF();
$oPDF->Open();
$oPDF->AliasNbPages();
$total = 0;
$oPDF->setfillcolor(235);
$oPDF->setfont('arial', 'b', 8);
$oPDF->setfillcolor(235);
$troca    = 1;
$alt      = 4;
$total    = 0;
$p        = 0;
$valortot = 0;
$cor      = 0;

$largura_ret = 195; //largura do retângulo
$altura_ret  = 21; //altura do retângulo
$recty       = 50; //retangulo
$rectx       = 5;

$head3 = "Extrato de Publicação";
$oPDF->addpage();
$oPDF->setfont('arial', 'b', 14);

$oPDF->ln(20);
$oPDF->cell(0, 5, utf8_decode($l214_tipo), 0, 1, "C", 0);
$oPDF->ln(5);
$oPDF->setfont('arial', '', 11);


$l20_edital = 55;
$licita->l03_descr = mb_strtolower($licita->l03_descr);
$licita->l03_descr = ucfirst($licita->l03_descr);
$licita->l20_recdocumentacao = implode("/", array_reverse(explode("-", $licita->l20_recdocumentacao)));
$oDepartamento = new DBDepartamento(db_getsession("DB_coddepto"));
$sDepartamento = $oDepartamento->getNomeDepartamento();
$sDepartamento = strtolower($sDepartamento);
$sDepartamento = ucwords($sDepartamento);
$licita->l03_descr = ucwords($licita->l03_descr);

$dia     = date("d", db_getsession("DB_datausu"));
$mes     = date("m", db_getsession("DB_datausu")) * 1;
$ano     = date("Y", db_getsession("DB_datausu"));
$meses = array('', 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
$mes = $meses[$mes];
$data = "$dia de $mes de $ano";

if ($licita->l20_leidalicitacao == 1) {
    $licita->l20_leidalicitacao = " Lei 14.133/2021";
}

if ($licita->l20_leidalicitacao == 2) {
    $licita->l20_leidalicitacao = " Lei 8.666/1993 e outras";
}

$arr_tipo = array(
    0 => "Selecione",
    1 => "Menor Preço",
    2 => "Melhor Técnica",
    3 => "Técnica e Preço",
    4 => "Maior Lance ou Oferta",
    5 => "Maior Oferta de Preço"
);

$licita->l20_tipliticacao = $arr_tipo[$licita->l20_tipliticacao];

$texto = str_replace('$l20_edital', "$licita->l20_edital", utf8_decode($l214_texto));
$texto = str_replace('$l20_codtipocomdescr', "$licita->l03_descr", $texto);
$texto = str_replace('$l20_numero', "$licita->l20_numero", $texto);
$texto = str_replace('$l20_tipliticacao', "$licita->l20_tipliticacao", $texto);
$texto = str_replace('$l20_leidalicitacao', "$licita->l20_leidalicitacao", $texto);
$texto = str_replace('$l20_objeto', "$licita->l20_objeto", $texto);
$texto = str_replace('$l20_recdocumentacao', "$licita->l20_recdocumentacao", $texto);
$texto = str_replace('$l20_localentrega', "$licita->l20_localentrega", $texto);

$texto = str_replace('$instituição,', "", $texto);
$texto = str_replace('data sistema (formato 01 de Janeiro de 2022.', "", $texto);

$texto = str_replace('<br />', "\n", $texto);
nl2br("One line.\nAnother line.");

$oPDF->MultiCell(0, 4, $texto, 0, 'L', false);
$oPDF->MultiCell(0, 4, $sDepartamento . ", " . $data, 0, 'L', false);

$yAtual = $oPDF->GetY();
$yAtual = ($yAtual - 65) / 2;
$altura_ret = $altura_ret + $yAtual;
$oPDF->Rect($rectx, $recty, $largura_ret, $oPDF->GetY() - 40, 'D'); //retangulo



$oPDF->Output();
