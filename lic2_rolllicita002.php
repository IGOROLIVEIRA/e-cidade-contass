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

if ($l20_codigo != "") {

    $sWhere .= $sAnd . " l20_codigo=$l20_codigo ";
    $sAnd = " and ";
    $info1 = "Código: ".$l20_codigo;
}
if ($l03_codigo != "") {

    $sWhere .= $sAnd . " l20_codtipocom=$l03_codigo ";
    $sAnd = " and ";
    if ($l03_descr != "") {
        $info2 = "Modalidade:" . $l03_codigo . "-" . $l03_descr;
    }
}
$sCampos = " distinct l20_codigo, l20_edital as processo,
l03_descr AS modalidade, l20_numero,
l20_dtpubratificacao, l202_datahomologacao, l20_criterioadjudicacao,
l20_anousu, l20_nroedital, l03_pctipocompratribunal,
CASE WHEN l20_usaregistropreco=TRUE THEN 'SIM' ELSE 'NAO' end as usaregistropreco,
CASE WHEN l20_descontotab=1 THEN 'SIM' ELSE 'NAO' end as descontotabela,
l20_datacria as abertura,
l20_objeto as objeto ";
$sWhere .= $sAnd . " l20_instit = " . db_getsession("DB_instit");
$sAnd = ' and ';

if($exercicio){
    $sWhere .= $sAnd . " extract (year from l20_datacria) = " . $exercicio;
}

if($cgms){
    $sWhere .= $sAnd . " cgmfornecedor.z01_numcgm in (" . $cgms . ") ";
}

if($status){
    $sWhere .= $sAnd . ' l08_sequencial = ';
    switch($status){
        case '1':
        case '2':
        case '3':
        case '4':
        case '5':
        case '6':
            $sWhere .= intval($status) - 1;
        break;
        default:
            $sWhere .= $status;
        break;
    }

}

$sSqlLicLicita = $clliclicita->sql_query(null, $sCampos, "4,2", $sWhere);
$result = $clliclicita->sql_record($sSqlLicLicita);
$numrows = $clliclicita->numrows;

if ($numrows == 0) {

    db_redireciona('db_erros.php?fechar=true&db_erro=Não existe registro cadastrado.');
    exit;
}

$head2 = "Roll de Licitações";
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
    if (strlen($objeto) > 50) {
        $aObjeto = quebrar_texto($objeto, 50);
        $alt_novo = count($aObjeto);
    } else {
        $alt_novo = 1;
    }

    $troca = 1;

    $pdf->setfont('arial', 'b', 7);
    $pdf->cell(8, $alt, "Seq", 1, 0, "C", 1);
    $pdf->cell(16, $alt, "N° Processo", 1, 0, "C", 1);
    $pdf->cell(10, $alt, "Edital", 1, 0, "C", 1);
    $pdf->cell(55, $alt, 'Modalidade', 1, 0, "C", 1);
    $pdf->cell(15, $alt, 'Numeração', 1, 0, "C", 1);
    $pdf->cell(8, $alt, 'R.P.', 1, 0, "C", 1);
    $pdf->cell(30, $alt, 'Critério de Adjudicação', 1, 0, "C", 1);
    $pdf->cell(10, $alt, 'Tabela', 1, 0, "C", 1);
    $pdf->cell(22, $alt, 'Data de abertura', 1, 0, "C", 1);
    $pdf->cell(78, $alt, 'Objeto', 1, 0, "C", 1);

    if(in_array($l03_pctipocompratribunal, array(48, 50, 51, 49, 52, 53))){
        $pdf->cell(27, $alt, 'Data de Homologação', 1, 1, "C", 1);
    }elseif(in_array($l03_pctipocompratribunal, array(100, 101, 102, 103))){
        $pdf->cell(27, $alt, 'Data de Ratificação', 1, 1, "C", 1);
    }

    $pdf->setfont('arial', '', 7);

    $pdf->cell(8, $alt*$alt_novo, $l20_codigo, 1, 0, "C", 0);
    $pdf->cell(16, $alt*$alt_novo, $processo, 1, 0, "C", 0);
    $pdf->cell(10, $alt*$alt_novo, ($l20_nroedital ? $l20_nroedital : ' - '), 1, 0, "C", 0);
    $pdf->cell(55, $alt*$alt_novo, $modalidade, 1, 0, "C", 0);
    $pdf->cell(15, $alt*$alt_novo, $l20_numero, 1, 0, "C", 0);
    $pdf->cell(8, $alt*$alt_novo, $usaregistropreco, 1, 0, "C", 0);

    if(in_array($l03_pctipocompratribunal, array(100, 101, 102, 103, 106))){
        $descCriterio = ' - ';
    }else{
        switch($l20_criterioadjudicacao){
            case 1:
                 $descCriterio = "Desconto sobre tabela";
                 break;
            case 2:
                $descCriterio = 'Menor taxa ou percentual';
                break;
            default:
                $descCriterio = "Outros";
                break;
        }
    }

    $pdf->cell(30, $alt*$alt_novo, $descCriterio, 1, 0, "C", 0);
    $pdf->cell(10, $alt*$alt_novo, $descontotabela, 1, 0, "C", 0);
    $pdf->cell(22, $alt*$alt_novo, db_formatar($abertura, "d"), 1, 0, "C", 0);

    if (strlen($objeto) > 50) {

        $pos_x = $pdf->x;
        $pos_y = $pdf->y;
        $pdf->cell(78, $alt*$alt_novo, "", 1, 0, "L", 0);
        $pdf->x = $pos_x;
        $pdf->y = $pos_y;
        foreach ($aObjeto as $oObjeto) {
            $pdf->cell(50, ($alt), $oObjeto, 0, 1, "L", 0);
            $pdf->x = $pos_x;
        }
        $pdf->x = $pos_x - 50;
    } else {
        $pdf->cell(78, $alt*$alt_novo, $objeto, 1, 0, "L", 0);
    }

    if (strlen($objeto) > 50) {
        $pdf->y = $pos_y;
        $pdf->x = $pos_x + 78;
    }
    
    if(in_array($l03_pctipocompratribunal, array(48, 50, 51, 49, 52, 53))){
        $data = $l202_datahomologacao;
    }elseif(in_array($l03_pctipocompratribunal, array(100, 101, 102, 103))){
        $data = $l20_dtpubratificacao;
    }
    $pdf->cell(27, $alt*$alt_novo, $data ? db_formatar($data, 'd') : ' - ', 1, 1, "C", 0);


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
        $pdf->cell(167, $alt, "Fornecedores", 1, 0, "L", 1);
        $pdf->cell(20, $alt, "Contrato", 1, 0, "C", 1);
        $pdf->cell(32, $alt, "Data Assinatura", 1, 0, "C", 1);
        $pdf->cell(30, $alt, "Data Inicio", 1, 0, "C", 1);
        $pdf->cell(30, $alt, "Data Final", 1, 1, "C", 1);

        for ($w = 0; $w < pg_num_rows($result_fornecedores); $w++) {

            db_fieldsmemory($result_fornecedores, $w);

            $pdf->setfont('arial', '', 7);
            $pdf->cell(167, $alt, $fornecedor, 1, 0, "L", $p);
            $pdf->cell(20, $alt, $contrato, 1, 0, "C", $p);
            $pdf->cell(32, $alt, db_formatar($si172_dataassinatura, "d"), 1, 0, "C", $p);
            $pdf->cell(30, $alt, db_formatar($si172_datainiciovigencia, "d"), 1, 0, "C", $p);
            $pdf->cell(30, $alt, db_formatar($si172_datafinalvigencia, "d"), 1, 1, "C", $p);

        }
    }
    /**
     * Status da Licitação
     * @see OC 3153
     */
    $oLicitacao = new licitacao($l20_codigo);
    $pdf->setfont('arial', 'b', 7);
    $pdf->cell(279, $alt, "Status: {$oLicitacao->getSituacao()->getSDescricao()}", 1, 1, "L", 1);
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
