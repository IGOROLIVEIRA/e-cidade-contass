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


include("libs/db_liborcamento.php");


// pesquisa a conta mae da receita

$tipo_mesini = 1;
$tipo_mesfim = 1;


$tipo_impressao = 1;
// 1 = orcamento
// 2 = balanco

include("fpdf151/pdf.php");
include("libs/db_sql.php");

include("fpdf151/assinatura.php");
$classinatura = new cl_assinatura;

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
//db_postmemory($HTTP_SERVER_VARS,2);

$xinstit = split("-", $db_selinstit);
$sInstituicoesPorVirgula = str_replace('-', ', ', $db_selinstit);

$resultinst = pg_exec("select codigo,nomeinst,nomeinstabrev from db_config where codigo in ({$sInstituicoesPorVirgula}) ");
$descr_inst = '';
$xvirg = '';
$flag_abrev = false;
for ($xins = 0; $xins < pg_numrows($resultinst); $xins++) {
    db_fieldsmemory($resultinst, $xins);
    if (strlen(trim($nomeinstabrev)) > 0) {
        $descr_inst .= $xvirg . $nomeinstabrev;
        $flag_abrev  = true;
    } else {
        $descr_inst .= $xvirg . $nomeinst;
    }

    $xvirg = ', ';
}

$head6 = "PERÍODO : " . db_formatar($dt_ini, 'd') . " A " . db_formatar($dt_fim, 'd');

$head3 = "EXECUÇÃO DO SUPERÁVIT ";
$head4 = "EXERCÍCIO: " . db_getsession("DB_anousu");

if ($flag_abrev == false) {
    if (strlen($descr_inst) > 42) {
        $descr_inst = substr($descr_inst, 0, 100);
    }
}

$head5 = "INSTITUIÇÕES : " . $descr_inst;

$pdf = new PDF();
$pdf->Open();
$pdf->AliasNbPages();
$total = 0;
$pdf->setfillcolor(235);
$pdf->setfont('arial', 'b', 8);
$troca = 1;
$alt = 4;

//$sql = "select * from work order by elemento";
//$result = pg_exec($sql);
$anousu  = db_getsession("DB_anousu");
$dataini = $dt_ini;
$datafin = $dt_fim;

$db_filtro = " o70_instit in ({$sInstituicoesPorVigula}) ";

$sql = "SELECT c241_fonte, SUM(c241_valor) valor FROM quadrosuperavitdeficit WHERE c241_ano = {$anousu} AND c241_instit IN ({$sInstituicoesPorVirgula}) GROUP BY c241_fonte ORDER BY c241_fonte";

$result = pg_exec($sql);
$arrayExcesso = array();

for ($i = 0; $i < pg_numrows($result); $i++) {
    db_fieldsmemory($result, $i);
    $fonte = fonteAgrupada($c241_fonte);
    if ($valor == 0)
        continue;

    if (array_key_exists($fonte, $arrayExcesso)) {
        $arrayExcesso[$fonte]["A"] += $valor;
        $arrayExcesso[$fonte]["D"] = 0;     
        continue;   
    } 

    $arrayExcesso[$fonte]["A"] = $valor;
    $arrayExcesso[$fonte]["D"] = 0;  
}

$sSql = "SELECT
            o58_codigo fonte,
            sum(o47_valor) as valor
        FROM
            orcsuplemval
        LEFT JOIN orcdotacao ON o47_coddot = o58_coddot
            AND o47_anousu = o58_anousu
        JOIN orcsuplem ON o47_codsup=o46_codsup
        WHERE
            o47_anousu = {$anousu}
            AND o58_instit in ({$sInstituicoesPorVirgula})
            AND o46_tiposup IN (2026, 1003, 1028, 1008, 1024)
        GROUP BY o58_codigo
        UNION
        SELECT
            o58_codigo fonte,
            sum(o136_valor) as valor
        FROM
            orcsuplemdespesappa
        LEFT JOIN orcsuplemval ON o47_codsup = o136_orcsuplem
        LEFT JOIN orcdotacao ON o47_coddot = o58_coddot
            AND o47_anousu = o58_anousu
        JOIN orcsuplem ON o47_codsup=o46_codsup
        WHERE
            o47_anousu = {$anousu}
            AND o58_instit in ({$sInstituicoesPorVirgula})
            AND o46_tiposup IN (2026, 1003, 1028, 1008, 1024)
        GROUP BY o58_codigo";

$subResult = db_query($sSql);

$valorSuplementado = 0;

for ($y = 0; $y < pg_num_rows($subResult); $y++) {
    $oFonte = db_utils::fieldsMemory($subResult, $y);
    if (substr($oFonte->fonte, 0, 1) == 2) {
        $fonte = fonteAgrupada($oFonte->fonte);
        if (array_key_exists($fonte, $arrayExcesso)) {
            $arrayExcesso[$fonte]["B"] += $oFonte->valor;
            $arrayExcesso[$fonte]["D"] = 0;
            continue;
        } 
        $arrayExcesso[$fonte]["B"] = $oFonte->valor;
        $arrayExcesso[$fonte]["D"] = 0;
    }
}

$sSql = "SELECT 
            fonte, 
            SUM(dot_ini) dot_ini, 
            SUM(suplementado) suplementado, 
            SUM(reduzido) reduzido, 
            SUM(empenhado - anulado) empenhado 
        FROM (
            SELECT
                o58_codigo fonte,
                substr(fc_dotacaosaldo, 3, 12) :: float8 as dot_ini,
                substr(fc_dotacaosaldo, 16, 12) :: float8 as saldo_anterior,
                substr(fc_dotacaosaldo, 29, 12) :: float8 as empenhado,
                substr(fc_dotacaosaldo, 42, 12) :: float8 as anulado,
                substr(fc_dotacaosaldo, 55, 12) :: float8 as liquidado,
                substr(fc_dotacaosaldo, 68, 12) :: float8 as pago,
                substr(fc_dotacaosaldo, 81, 12) :: float8 as suplementado,
                substr(fc_dotacaosaldo, 094, 12) :: float8 as reduzido,
                substr(fc_dotacaosaldo, 107, 12) :: float8 as atual,
                substr(fc_dotacaosaldo, 120, 12) :: float8 as reservado,
                substr(fc_dotacaosaldo, 133, 12) :: float8 as atual_menos_reservado,
                substr(fc_dotacaosaldo, 146, 12) :: float8 as atual_a_pagar,
                substr(fc_dotacaosaldo, 159, 12) :: float8 as atual_a_pagar_liquidado,
                substr(fc_dotacaosaldo, 172, 12) :: float8 as empenhado_acumulado,
                substr(fc_dotacaosaldo, 185, 12) :: float8 as anulado_acumulado,
                substr(fc_dotacaosaldo, 198, 12) :: float8 as liquidado_acumulado,
                substr(fc_dotacaosaldo, 211, 12) :: float8 as pago_acumulado,
                substr(fc_dotacaosaldo, 224, 12) :: float8 as suplementado_acumulado,
                substr(fc_dotacaosaldo, 237, 12) :: float8 as reduzido_acumulado,
                substr(fc_dotacaosaldo, 250, 12) :: float8 as suplemen,
                substr(fc_dotacaosaldo, 263, 12) :: float8 as suplemen_acumulado,
                substr(fc_dotacaosaldo, 276, 12) :: float8 as especial,
                substr(fc_dotacaosaldo, 289, 12) :: float8 as especial_acumulado,
                substr(fc_dotacaosaldo, 303, 12) :: float8 as transfsup,
                substr(fc_dotacaosaldo, 316, 12) :: float8 as transfsup_acumulado,
                substr(fc_dotacaosaldo, 329, 12) :: float8 as transfred,
                substr(fc_dotacaosaldo, 342, 12) :: float8 as transfred_acumulado,
                substr(fc_dotacaosaldo, 355, 12) :: float8 as reservado_manual_ate_data,
                substr(fc_dotacaosaldo, 368, 12) :: float8 as reservado_automatico_ate_data,
                substr(fc_dotacaosaldo, 381, 12) :: float8 as reservado_ate_data,
                o55_tipo,
                o15_tipo
            FROM (
                SELECT
                    *,
                    fc_dotacaosaldo({$anousu}, o58_coddot, 2,  '{$dt_ini}', '{$dt_fim}')
                FROM
                    orcdotacao w
                inner join orcelemento e on w.o58_codele = e.o56_codele
                    and e.o56_anousu = w.o58_anousu
                    and e.o56_orcado is true
                inner join orcprojativ ope on w.o58_projativ = ope.o55_projativ
                    and ope.o55_anousu = w.o58_anousu
                inner join orctiporec on orctiporec.o15_codigo = w.o58_codigo
                where
                    o58_anousu = {$anousu}
                    and w.o58_instit in ({$sInstituicoesPorVirgula})
                order by
                    o58_codigo
                ) as x
            ) as y 
        GROUP BY fonte";

$subResult = db_query($sSql);
for ($y = 0; $y < pg_num_rows($subResult); $y++) {
    $despesa = db_utils::fieldsMemory($subResult, $y);
    if (substr($despesa->fonte, 0, 1) == 2) {
        $fonte = fonteAgrupada($despesa->fonte);
        if (array_key_exists($fonte, $arrayExcesso)) {
            $arrayExcesso[$fonte]["D"] += $despesa->dot_ini + $despesa->suplementado - $despesa->reduzido;
            $arrayExcesso[$fonte]["E"] += $despesa->empenhado;
            $arrayExcesso[$fonte]["F"] += $arrayExcesso[$fonte]["D"] - $arrayExcesso[$fonte]["E"];
        }
    }
}
//db_criatabela($result);

$pagina  = 1;
$total_a = 0;
$total_b = 0;
$total_c = 0;
$total_d = 0;
$total_e = 0;
$total_f = 0;
$total_g = 0;

foreach ($arrayExcesso as $fonte => $data) {
    if ($pdf->gety() > $pdf->h - 30 || $pagina == 1) {
        $pagina = 0;
        $pdf->addpage();
        $pdf->setfont('arial', 'b', 6);

        $largura = ($pdf->w) / 9 + 1;
        $posicaoInicial = $largura;
        $pos = $pdf->gety();
        $pdf->multicell($largura, $alt * 2, "FONTE DE RECURSO", 1, "C", 1, 0);
        $pdf->setxy($posicaoInicial + 10, $pos);
        $posicaoInicial += $largura + 10;
        $pdf->multicell($largura, $alt * 2, "SUPERÁVIT (A)", 1, "C", 1, 0);
        $pdf->setxy($posicaoInicial, $pos);
        $posicaoInicial += $largura;
        $pdf->multicell($largura, $alt, "CRÉDITOS ABERTOS (B)", 1, "C", 1, 0);
        $pdf->setxy($posicaoInicial, $pos);
        $posicaoInicial += $largura;
        $pdf->multicell($largura, $alt, "ABERTOS SEM RECURSOS (C=B-A)",1, "C", 1, 0);
        $pdf->setxy($posicaoInicial, $pos);
        $posicaoInicial += $largura;
        $pdf->multicell($largura, $alt, "DOTAÇÃO ATUALIZADA (D)", 1, "C", 1, 0);
        $pdf->setxy($posicaoInicial, $pos);
        $posicaoInicial += $largura;
        $pdf->multicell($largura, $alt, "DESPESA EMPENHADA (E)", 1, "C", 1, 0);
        $pdf->setxy($posicaoInicial, $pos);
        $posicaoInicial += $largura;
        $pdf->multicell($largura, $alt, "SALDO A EMPENHAR (F=D-E)", 1, "C", 1, 0);
        $pdf->setxy($posicaoInicial, $pos);
        $posicaoInicial += $largura;
        $pdf->multicell($largura, $alt, "EMPENHADA SEM RECURSOS (G=C-F)", 1, "C", 1, 0);
        $pdf->setxy($posicaoInicial, $pos);

        $pdf->ln(9);
    }

    $data = tratarColunas($data);
    $fonte = tratarAgrupamentoDescricaoFonte($fonte);

    $pdf->setfont('arial', '', 6);
    $pdf->cell(24, $alt, db_formatar($fonte, 'recurso'), 0, 0, "C", 0);
    $pdf->cell(24, $alt, db_formatar($data["A"], 'f'), 0, 0, "R", 0);
    $pdf->cell(24, $alt, db_formatar($data["B"], 'f'), 0, 0, "R", 0);
    $pdf->cell(24, $alt, db_formatar($data["C"], 'f'), 0, 0, "R", 0);
    $pdf->cell(24, $alt, db_formatar($data["D"], 'f'), 0, 0, "R", 0);
    $pdf->cell(24, $alt, db_formatar($data["E"], 'f'), 0, 0, "R", 0);
    $pdf->cell(24, $alt, db_formatar($data["F"], 'f'), 0, 0, "R", 0);
    $pdf->cell(24, $alt, db_formatar($data["G"], 'f'), 0, 1, "R", 0);

    $total_a += $data["A"];
    $total_b += $data["B"];
    $total_c += $data["C"];
    $total_d += $data["D"];
    $total_e += $data["E"];
    $total_f += $data["F"];
    $total_g += $data["G"];
}

$pdf->setfont('arial', 'B', 6);
$pdf->cell(24, $alt, 'TOTAL ', 0, 0, "C", 0);

$pdf->cell(24, $alt, db_formatar($total_a, 'f'), 0, 0, "R", 0);
$pdf->cell(24, $alt, db_formatar($total_b, 'f'), 0, 0, "R", 0);
$pdf->cell(24, $alt, db_formatar($total_c, 'f'), 0, 0, "R", 0);
$pdf->cell(24, $alt, db_formatar($total_d, 'f'), 0, 0, "R", 0);
$pdf->cell(24, $alt, db_formatar($total_e, 'f'), 0, 0, "R", 0);
$pdf->cell(24, $alt, db_formatar($total_f, 'f'), 0, 0, "R", 0);
$pdf->cell(24, $alt, db_formatar($total_g, 'f'), 0, 1, "R", 0);

if ($pdf->gety() > ($pdf->h - 30))
    $pdf->addpage();

$largura = ($pdf->w) / 2;
$pdf->ln(10);
$pos = $pdf->gety();
$pdf->multicell($largura, 2, $ass_pref, 0, "C", 0, 0);
$pdf->setxy($largura, $pos);
$pdf->multicell($largura, 2, $ass_cont, 0, "C", 0, 0);

$pdf->Output();

/**
 * Função para agrupamento de fontes desconsiderando o primeiro digito
 * @author widouglas
 * @param integer $fonte
 * @return integer
 */
function fonteAgrupada($fonte) 
{
    if (db_getsession("DB_anousu") > 2022)
        return 2 . substr($fonte, 1, 6);

    $fonte = substr($fonte, 1, 2);

    if (in_array($fonte, array("01", "02")))
        return "200";

    if ($fonte == "19")
        return "218";

    if ($fonte == "67")
        return "266";

    return 2 . $fonte;
}

/**
 * Controla o fluxo e modificações necessárias na coluna Superávit (A)
 */
function tratarNegativados($valor)
{
    if ($valor < 0)
        return 0;
    return $valor;
}

/**
 * Desmembramento da tratativa de colunas para melhor visualização do código
 */
function tratarColunas($data)
{
    $data["A"] = tratarNegativados($data["A"]);
    $data["B"] = tratarNegativados($data["B"]);
    $data["C"] = (($data["B"] - $data["A"]) > 0) ? ($data["B"] - $data["A"]) : 0;
    $data["G"] = (($data["C"] - $data["F"]) > 0) ? ($data["C"] - $data["F"]) : 0;
    $data["G"] = $data["E"] == 0 ? 0 : $data["G"];
    return $data;
}

/**
 * Desmembramento da tratativa de fontes para melhor visualização do código
 */
function tratarAgrupamentoDescricaoFonte($fonte)
{
    // Condições de exibição agrupada conforme OC17997
    $fonte = $fonte == 200 ? db_formatar("200", "recurso") . " / " .
        db_formatar("201", "recurso") . " / " .
        db_formatar("202", "recurso") : $fonte;
    $fonte = $fonte == 218 ? db_formatar("218", "recurso") . " / " .
        db_formatar("219", "recurso") : $fonte;
    $fonte = $fonte == 266 ? db_formatar("266", "recurso") . " / " .
        db_formatar("267", "recurso") : $fonte;
    return $fonte;
}