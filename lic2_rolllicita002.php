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
require_once("classes/db_acordo_classe.php");
require_once("model/licitacao.model.php");
require_once("model/licitacao/SituacaoLicitacao.model.php");
require_once("classes/db_habilitacaoforn_classe.php");

$clliclicita = new cl_liclicita;
$clliclicitasituacao = new cl_liclicitasituacao;
$clliclicitem = new cl_liclicitem;
$clempautitem = new cl_empautitem;
$clpcorcamjulg = new cl_pcorcamjulg;
$clpcprocitem = new cl_pcprocitem;
$clacordo = new cl_acordo;
$clhabilitacao = new cl_habilitacaoforn;
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
extract(year from l20_datacria) l00_anocria,
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

$sSqlLicLicita = $clliclicita->sql_query(null, $sCampos, "l00_anocria,l20_edital,l20_datacria", $sWhere);
$result = $clliclicita->sql_record($sSqlLicLicita);
$numrows = $clliclicita->numrows;

if ($numrows == 0) {

    db_redireciona('db_erros.php?fechar=true&db_erro=Não existe registro cadastrado.');
    exit;
}

$head3 = @$info;
$head2 = "Rol de Licitações";
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
    if (strlen($objeto) > 56) {
        $aObjeto = quebrar_texto($objeto, 56);
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
    $pdf->cell(22, $alt, 'Data de abertura', 1, 0, "C", 1);
    $pdf->cell(88, $alt, 'Objeto', 1, 0, "C", 1);
    
    if(in_array($l03_pctipocompratribunal, array(48, 50, 51, 49, 52, 53))){
        $pdf->cell(27, $alt, 'Data de Homologação', 1, 1, "C", 1);
    }elseif(in_array($l03_pctipocompratribunal, array(100, 101, 102, 103, 106))){
        $pdf->cell(27, $alt, 'Data de Ratificação', 1, 1, "C", 1);
    }else{
        $pdf->cell(27, $alt, ' - ', 1, 1, "C", 1);
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
    $pdf->cell(22, $alt*$alt_novo, db_formatar($abertura, "d"), 1, 0, "C", 0);

    if (strlen($objeto) > 56) {

        $pos_x = $pdf->x;
        $pos_y = $pdf->y;
        $pdf->cell(88, $alt*$alt_novo, "", 1, 0, "L", 0);
        $pdf->x = $pos_x;
        $pdf->y = $pos_y;
        foreach ($aObjeto as $oObjeto) {
            $pdf->cell(56, ($alt), $oObjeto, 0, 1, "L", 0);
            $pdf->x = $pos_x;
        }
        $pdf->x = $pos_x - 56;
    } else {
        $pdf->cell(88, $alt*$alt_novo, $objeto, 1, 0, "L", 0);
    }

    if (strlen($objeto) > 56) {
        $pdf->y = $pos_y;
        $pdf->x = $pos_x + 88;
    }
    
    $data = '';
    if(in_array($l03_pctipocompratribunal, array(48, 50, 51, 49, 52, 53))){
        $data = $l202_datahomologacao;
    }elseif(in_array($l03_pctipocompratribunal, array(100, 101, 102, 103, 106))){
        $data = $l20_dtpubratificacao;
    }

    $pdf->cell(27, $alt*$alt_novo, $data ? db_formatar($data, 'd') : ' - ', 1, 1, "C", 0);

    $sSqlFornecedores = " select distinct
                            l206_fornecedor||' - '||z01_nome AS fornecedor,
                            si172_nrocontrato  as contrato,
                            si172_dataassinatura as ac16_dataassinatura,
                            si172_datainiciovigencia as ac16_datainicio,
                            si172_datafinalvigencia as ac16_datafim
                        FROM contratos
                        INNER JOIN cgm ON si172_fornecedor = z01_numcgm
                        INNER JOIN habilitacaoforn ON l206_fornecedor = si172_fornecedor
                        WHERE si172_licitacao = {$l20_codigo}";

    $result_fornecedores = db_query($sSqlFornecedores) or die(pg_last_error());

    if(!pg_numrows($result_fornecedores)){
        $sSqlFornecedores = "
            SELECT DISTINCT 
                ac16_contratado||' - '||z01_nome AS fornecedor,
                ac16_numero  as contrato,
                ac16_dataassinatura,
                ac16_datainicio,
                ac16_datafim
            FROM acordo
            INNER JOIN cgm ON ac16_contratado = z01_numcgm
            INNER JOIN habilitacaoforn ON l206_fornecedor = ac16_contratado
            WHERE ac16_licitacao = {$l20_codigo}";

        $result_fornecedores = db_query($sSqlFornecedores) or die(pg_last_error());                
    }

    
    if(!pg_numrows($result_fornecedores)){
        $sSqlFornecedores = $clacordo->sql_queryLicitacoesVinculadas(null, 
        "z01_numcgm||' - '||z01_nome as fornecedor, ac16_numero as contrato, ac16_dataassinatura, ac16_datainicio, ac16_datafim", null, " AND l21_codliclicita=$l20_codigo and l20_instit = " . db_getsession("DB_instit"));
        $result_fornecedores = db_query($sSqlFornecedores) or die(pg_last_error());
    }

    if($usaregistropreco == 'SIM'){
        $sSqlFornecedores = $clhabilitacao->sql_query(null,"z01_numcgm||' - '||z01_nome as fornecedor","z01_nome","l206_licitacao = {$l20_codigo}");
        $result_fornecedores = db_query($sSqlFornecedores) or die(pg_last_error());
    }

    if (pg_num_rows($result_fornecedores) > 0) {

        $pdf->setfont('arial', 'b', 7);
        $pdf->cell(167, $alt, "Fornecedores", 1, 0, "L", 1);
        $pdf->cell(20, $alt, "Contrato", 1, 0, "C", 1);
        $pdf->cell(32, $alt, "Data Assinatura", 1, 0, "C", 1);
        $pdf->cell(30, $alt, "Data Inicio", 1, 0, "C", 1);
        $pdf->cell(30, $alt, "Data Final", 1, 1, "C", 1);

        for ($w = 0; $w < pg_num_rows($result_fornecedores); $w++) {

            $oFornecedor = db_utils::fieldsMemory($result_fornecedores, $w);

            $pdf->setfont('arial', '', 7);
            $pdf->cell(167, $alt, $oFornecedor->fornecedor, 1, 0, "L", $p);
            $pdf->cell(20, $alt, $oFornecedor->contrato ? $oFornecedor->contrato : ' - ', 1, 0, "C", $p);
            $pdf->cell(32, $alt, $oFornecedor->ac16_dataassinatura ? db_formatar($oFornecedor->ac16_dataassinatura, "d") : ' - ', 1, 0, "C", $p);
            $pdf->cell(30, $alt, $oFornecedor->ac16_datainicio ? db_formatar($oFornecedor->ac16_datainicio, "d") : ' - ', 1, 0, "C", $p);
            $pdf->cell(30, $alt, $oFornecedor->ac16_datafim ? db_formatar($oFornecedor->ac16_datafim, "d") : ' - ', 1, 1, "C", $p);

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
