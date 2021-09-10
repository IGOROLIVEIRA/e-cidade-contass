<?
include("fpdf151/pdf.php");
include("classes/db_cgm_classe.php");
require_once("libs/db_utils.php");

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
//db_postmemory($HTTP_POST_VARS);

/*
 * Definindo o período em que serão selecionado os dados
 */

function extenso($valor = 0, $maiusculas = false)
{
    // verifica se tem virgula decimal
    if (strpos($valor, ",") > 0) {
        // retira o ponto de milhar, se tiver
        $valor = str_replace(".", "", $valor);

        // troca a virgula decimal por ponto decimal
        $valor = str_replace(",", ".", $valor);
    }
    $singular = array("centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
    $plural = array(
        "centavos", "reais", "mil", "milhões", "bilhões", "trilhões",
        "quatrilhões"
    );

    $c = array(
        "", "cem", "duzentos", "trezentos", "quatrocentos",
        "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos"
    );
    $d = array(
        "", "dez", "vinte", "trinta", "quarenta", "cinquenta",
        "sessenta", "setenta", "oitenta", "noventa"
    );
    $d10 = array(
        "dez", "onze", "doze", "treze", "quatorze", "quinze",
        "dezesseis", "dezesete", "dezoito", "dezenove"
    );
    $u = array(
        "", "um", "dois", "três", "quatro", "cinco", "seis",
        "sete", "oito", "nove"
    );

    $z = 0;

    $valor = number_format($valor, 2, ".", ".");
    $inteiro = explode(".", $valor);
    $cont = count($inteiro);
    for ($i = 0; $i < $cont; $i++)
        for ($ii = strlen($inteiro[$i]); $ii < 3; $ii++)
            $inteiro[$i] = "0" . $inteiro[$i];

    $fim = $cont - ($inteiro[$cont - 1] > 0 ? 1 : 2);
    for ($i = 0; $i < $cont; $i++) {
        $valor = $inteiro[$i];
        $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
        $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
        $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

        $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd &&
            $ru) ? " e " : "") . $ru;
        $t = $cont - 1 - $i;
        $r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";
        if ($valor == "000") $z++;
        elseif ($z > 0) $z--;
        if (($t == 1) && ($z > 0) && ($inteiro[0] > 0)) $r .= (($z > 1) ? " de " : "") . $plural[$t];
        if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) &&
            ($inteiro[0] > 0) && ($z < 1)) ? (($i < $fim) ? ", " : " e ") : " ") . $r;
    }

    if (!$maiusculas) {
        return ($rt ? $rt : "zero");
    } elseif ($maiusculas == "2") {
        return (strtoupper($rt) ? strtoupper($rt) : "Zero");
    } else {
        return (ucwords($rt) ? ucwords($rt) : "Zero");
    }
}

$sSql = "SELECT k00_codigo,k00_dtpagamento,k00_codord,k00_formapag,c63_banco,c63_conta,c63_dvconta,c63_agencia,c63_dvagencia,z01_nome,
pc63_banco,z01_cgccpf,k00_valorpag,pc63_conta_dig,pc63_conta,pc63_agencia_dig,pc63_agencia,
CASE WHEN k00_codord IS NULL THEN 'SL' ELSE 'OP' END AS tipo,
CASE WHEN k00_codord IS NULL THEN k00_slip ELSE k00_codord END AS codigo,k00_dtvencpag,
CASE WHEN k00_codord IS NULL THEN
  (SELECT k17_texto FROM slip WHERE k17_codigo=k00_slip and k17_instit = " . db_getsession("DB_anousu") . ")
ELSE
  (SELECT e50_obs FROM  pagordem WHERE e50_codord=k00_codord LIMIT 1)
END  AS observacao,k00_ordemauxiliar
FROM
ordembancaria
JOIN conplanoconta ON k00_ctpagadora = c63_codcon and c63_anousu = " . db_getsession("DB_anousu") . "
JOIN ordembancariapagamento ON k00_codigo =  k00_codordembancaria
JOIN cgm ON k00_cgmfornec = z01_numcgm
LEFT JOIN pcfornecon ON z01_numcgm = pc63_numcgm and k00_contabanco = pc63_contabanco
WHERE k00_codigo = {$codigo_ordem} ORDER BY z01_nome";

$rsResult = db_query($sSql);
if (pg_num_rows($rsResult) == 0) {

    $sSql = "	SELECT distinct k00_codigo,k00_dtpagamento,k00_codord,k00_formapag,c63_banco,c63_conta,c63_dvconta,c63_agencia,c63_dvagencia,z01_nome,
						pc63_banco,z01_cgccpf,k00_valorpag,pc63_conta_dig,pc63_conta,pc63_agencia_dig,pc63_agencia,
						CASE WHEN k00_codord IS NULL THEN 'SL' ELSE 'OP' END AS tipo,
						CASE WHEN k00_codord IS NULL THEN k00_slip ELSE k00_codord END AS codigo,k00_dtvencpag,
						CASE WHEN k00_codord IS NULL THEN
						  (SELECT k17_texto FROM slip WHERE k17_codigo=k00_slip and k17_instit = " . db_getsession("DB_instit") . " LIMIT 1)
						ELSE
						  (SELECT e50_obs FROM  pagordem WHERE e50_codord=k00_codord LIMIT 1)
						  END  AS observacao,k00_ordemauxiliar
						FROM
						ordembancaria JOIN conplanoreduz ON k00_ctpagadora = c61_reduz
						JOIN conplanoconta ON c61_codcon = c63_codcon and c63_anousu = (SELECT max(c63_anousu) from ordembancaria JOIN conplanoreduz ON k00_ctpagadora = c61_reduz
                         JOIN conplanoconta ON c61_codcon = c63_codcon
                         JOIN ordembancariapagamento ON k00_codigo =  k00_codordembancaria
                         WHERE k00_codigo =  {$codigo_ordem})
						JOIN ordembancariapagamento ON k00_codigo =  k00_codordembancaria
						JOIN cgm ON k00_cgmfornec = z01_numcgm
						LEFT JOIN pcfornecon ON z01_numcgm = pc63_numcgm and k00_contabanco = pc63_contabanco
						WHERE k00_codigo =  {$codigo_ordem} ORDER BY z01_nome";

    $rsResult = db_query($sSql); //db_criatabela($rsResult);echo $sSql;exit;

}
$oResult0 = db_utils::fieldsMemory($rsResult, 0);

$head3 = "Autorização de pagamento";

//$head5= "Mês de Referência: $sMes";

$head7 = "Nº: {$oResult0->k00_codigo}";
//$head8 = "Data: ";

$pdf = new PDF(); // abre a classe
$pdf->SetLeftMargin(30);

$pdf->Open(); // abre o relatorio
//$pdf->AliasNbPages(); // gera alias para as paginas

$pdf->AddPage('P'); // adiciona uma pagina
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(235);
$tam = '04';

$pdf->SetFont("", "B", "");
$pdf->Cell(175, "05", "AUTORIZAÇÃO DE PAGAMENTO", 0, 1, "C", 0);
$pdf->SetFont("", "", "");
$pdf->Cell(175, $tam, "Autorizo o pagamento das despesas descritas nas Ordens de Pagamentos relacionadas neste documento.", 0, 1, "C", 0);

//$pdf->Cell(250,$tam,"Nº: ".$oResult0->k00_codigo,1,1,"R",1);
//$pdf->Cell(250,$tam,"DATA: ".$oResult->k00_dtpagamento,1,1,"R",1);
$pdf->SetFont("", "B", "");
$pdf->Cell(25, $tam, "BANCO: " . $oResult0->c63_banco, 1, 0, "C", 1);
$pdf->Cell(30, $tam, "AGÊNCIA: " . $oResult0->c63_agencia . "-" . $oResult0->c63_dvagencia, 1, 0, "C", 1);
$pdf->Cell(120, $tam, "CONTA CORRENTE: " . $oResult0->c63_conta . "-" . $oResult0->c63_dvconta, 1, 1, "C", 1);


$pdf->Cell(83, $tam, "NOME DO FAVORECIDO", 1, 0, "C", 1);
$pdf->Cell(30, $tam, "CPF/CNPJ", 1, 0, "C", 1);
$pdf->Cell(20, $tam, "Nº Documento", 1, 0, "C", 1);
$pdf->Cell(10, $tam, "OP Aux", 1, 0, "C", 1);
$pdf->Cell(10, $tam, "Tipo", 1, 0, "C", 1);
$pdf->Cell(22, $tam, "VALOR:", 1, 1, "L", 1);
$valor_total = 0;
for ($iCont = 0; $iCont < pg_num_rows($rsResult); $iCont++) {

    $oResult = db_utils::fieldsMemory($rsResult, $iCont);

    $sSqlDescForma = "select max(e86_codmov) as movimento
	from empageconf
	where e86_correto = true
	       and e86_codmov = (select e82_codmov from empord where e82_codord = {$oResult->k00_codord})";
    $rsResultDescForma = db_query($sSqlDescForma);
    $e86_codmov = db_utils::fieldsMemory($rsResultDescForma, 0)->movimento;

    $sSqlDescForma = "select e96_descr from empagemovforma join empageforma on e97_codforma  = e96_codigo where e97_codmov = {$e86_codmov}";
    $rsResultDescForma = db_query($sSqlDescForma);
    $e96_descr = db_utils::fieldsMemory($rsResultDescForma, 0)->e96_descr;

    $pdf->SetFont("", "", "");
    if (strlen($oResult->z01_cgccpf) == 11) {
        $tipo = "cpf";
    } else {
        $tipo = "cnpj";
    }
    /* - Contass Consultoria -
        * Ocorrência 803 - Relatório da Autorização de Pagamentos apresenta sobreposição de informações;
        * Problema: Tesouraria>Procedimentos>Ordem bancária>; quando se gera a Ordem bancária (Autorização de Pagamento) ocorre de nomes se sobreporem ao CNPJ, e falta um espaço entre o cifrão $ e o valor.
        * Soluçao:  inserir quebra de texto para o nome do credor e também um espaço entre o cifrão $ e o valor, para melhor visualização;
        * Linha(s) alterada: 172
        * Linha original: $pdf->Cell(83,$tam,substr($oResult->z01_nome,0,60),0,0,"L",0);
        */
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    //$pdf->Cell(83,$tam,substr($oResult->z01_nome,0,60),0,0,"L",0);
    $pdf->MultiCell(83, $tam, $oResult->z01_nome, 0, "L", 0);
    $pdf->SetX($x + 83);
    $pdf->SetY($y);
    $pdf->SetX($x + 83);
    $pdf->Cell(30, $tam, db_formatar($oResult->z01_cgccpf, $tipo), 0, 0, "C", 0);
    $pdf->Cell(20, $tam, $oResult->tipo . " " . $oResult->codigo, 0, 0, "C", 0);
    $pdf->Cell(10, $tam, $oResult->k00_ordemauxiliar, 0, 0, "C", 0);
    $pdf->Cell(10, $tam, $e96_descr, 0, 0, "C", 0);
    $pdf->Cell(22, $tam, "R$ " . number_format($oResult->k00_valorpag, 2, ",", "."), 0, 1, "L", 0);
    $pdf->Cell(83, $tam, "Forma de Pag: " . $oResult->k00_formapag, 0, 0, "L", 0);
    $pdf->Cell(30, $tam, "Banco: " . $oResult->pc63_banco, 0, 0, "C", 0);
    $pdf->Cell(30, $tam, "Agência: " . $oResult->pc63_agencia . "-" . $oResult->pc63_agencia_dig, 0, 0, "C", 0);
    $pdf->Cell(22, $tam, "C.C: " . $oResult->pc63_conta . "-" . $oResult->pc63_conta_dig, 0, 1, "C", 0);

    $sSQL = "SELECT k29_exibeobservacao FROM caiparametro WHERE k29_instit = " . db_getsession('DB_instit');
    $rsResult = db_query($sSQL);

    if (db_utils::fieldsMemory($rsResult, 0)->k29_exibeobservacao == 't') {
        $pos_x = $pdf->x;
        $pos_y = $pdf->y;
        $pdf->SetFont("", "B", "");
        $pdf->Cell(175, $tam, "OBSERVAÇÃO:", 0, 1, "L", 1);
        $pdf->SetFont("", "", "");
        $pdf->MultiCell(175, $tam, $oResult->observacao, 0, "L", 1);
        $dif = $pdf->y - $pos_y - 4;
        $pdf->y = $pos_y;
        $pdf->x = $pos_x;
        $pdf->Cell(175, $tam + $dif, "", 1, 1, "L", 0);
    }

    $pdf->Cell(22, $tam, "Vencimento: " . date("d/m/Y", strtotime($oResult->k00_dtvencpag)), 0, 1, "L", 0); //Ocorrência 756 - Incluído o Vencimento no relatório

    if ($pdf->GetY() > 250) {
        $pdf->AddPage();
    } else {
        $pdf->Cell(175, "0.01", "", 1, 1, "C", 0);
    }

    $valor_total += $oResult->k00_valorpag;
}
$pdf->SetFont("", "B", "08");
$pdf->SetRightMargin("0");
$pdf->Cell(175, "0.01", "", 1, 1, "C", 0);
$pdf->Cell(50, "07", "TOTAL: ", 0, 0, "L", 0);
$pdf->Cell(125, "07", "R$ " . number_format($valor_total, 2, ",", "."), 0, 1, "R", 0);
$pdf->Cell(175, "0.01", "", 1, 1, "C", 0);

//$pdf->Cell(175,"07","VALOR EXTENSO: ".extenso($valor_total,TRUE)."***************************",0,1,"C",0);
$pdf->MultiCell(175, "05", "VALOR EXTENSO: " . extenso($valor_total, TRUE) . "***************************", 0, "L", 0);
$pdf->Cell(175, "0.01", "", 1, 1, "C", 0);
$pdf->Cell(175, "07", "", 0, 1, "C", 0);
$pdf->Cell(175, "07", "", 0, 1, "C", 0);
$pdf->Cell(175, "0.01", "", 1, 1, "C", 0);
//$pdf->Cell(175,"09","Fica esse banco autorizado a creditar as importâncias mencionadas ao(s) favorecido(s) a debito de nossa Conta Corrente: Nº 2-2, Agência: 2333.",1,1,"C",0);
$pdf->MultiCell(175, 5, "Fica esse banco autorizado a creditar as importâncias mencionadas ao(s) favorecido(s) a débito de nossa Conta Corrente: Nº " . $oResult0->c63_conta . "-" . $oResult0->c63_dvconta . ", Agência: " . $oResult0->c63_agencia . "-" . $oResult0->c63_dvagencia . ".", 1);
$pdf->Cell(175, "0.01", "", 1, 1, "C", 0);

$sql    = "select munic,uf from db_config where codigo = " . db_getsession("DB_instit");
$result = db_query($sql);
$munic  = db_utils::fieldsMemory($result, 0)->munic;
$uf     = db_utils::fieldsMemory($result, 0)->uf;

$pdf->Cell(175, "07", "", 0, 1, "C", 0);
$pdf->Cell(175, "07", "", 0, 1, "C", 0);
$pdf->Cell(175, "09", "{$munic} - {$uf} - DATA: ____/____/________", 0, 1, "L", 0);
$pdf->Cell(175, "07", "", 0, 1, "C", 0);
$pdf->Cell(175, "07", "", 0, 1, "C", 0);
$pdf->Cell(80, "0.01", "", 1, 0, "C", 0);
$pdf->Cell(10, "0.01", "", 0, 0, "C", 0);
$pdf->Cell(80, "0.01", "", 1, 1, "C", 0);

/* FEITO ISSO PARA QUE A CAMARA DE BELO HORIZONTE TENHA UMA FORMA DE ASSINATURA EXCLUSIVA
   AUTOR: IGOR OLIVEIRA
  */
$sSqlCnpjCliente = "select cgc from db_config where codigo= " . db_getsession("DB_instit");
$CnpjCliente = db_utils::fieldsMemory(db_query($sSqlCnpjCliente), 0)->cgc;

if ($CnpjCliente == '17316563000196') {
    $pdf->Cell(80, $tam, "Presidente", 0, 0, "C", 0);
    $pdf->Cell(10, "0.01", "", 0, 0, "C", 0);
    $pdf->Cell(80, $tam, "Diretor de Adm. e Finanças", 0, 1, "C", 0);
} else {
    $pdf->Cell(80, $tam, "Assinatura/Responsável", 0, 0, "C", 0);
    $pdf->Cell(10, "0.01", "", 0, 0, "C", 0);
    $pdf->Cell(80, $tam, "Assinatura/Responsável", 0, 1, "C", 0);
}

$pdf->output();
