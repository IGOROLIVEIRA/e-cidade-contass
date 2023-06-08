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

$xinstit = str_split("-", $db_selinstit);
$resultinst = pg_query("select codigo,nomeinst,nomeinstabrev from db_config where codigo in (" . str_replace('-', ', ', $db_selinstit) . ") ");
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

$head3 = "EXECUÇÃO DO EXCESSO DE ARRECADAÇÃO ";
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

$db_filtro = ' o70_instit in (' . str_replace('-', ', ', $db_selinstit) . ')';

$sSql = "SELECT 
        o70_codigo, 
        SUM(saldo_arrecadado - saldo_inicial) saldo_excesso 
    FROM (
        select
            o70_codigo,
            CAST(
                COALESCE(NULLIF(substr(fc_receitasaldo, 3, 12), ''), '0') AS float8
            ) AS saldo_inicial,
            CAST(
                COALESCE(NULLIF(substr(fc_receitasaldo, 16, 12), ''), '0') AS float8
            ) AS saldo_prevadic_acum,
            CAST(
                COALESCE(NULLIF(substr(fc_receitasaldo, 29, 12), ''), '0') AS float8
            ) AS saldo_inicial_prevadic,
            CAST(
                COALESCE(NULLIF(substr(fc_receitasaldo, 42, 12), ''), '0') AS float8
            ) AS saldo_anterior,
            CAST(
                COALESCE(NULLIF(substr(fc_receitasaldo, 55, 12), ''), '0') AS float8
            ) AS saldo_arrecadado,
            CAST(
                COALESCE(NULLIF(substr(fc_receitasaldo, 68, 12), ''), '0') AS float8
            ) AS saldo_a_arrecadar,
            CAST(
                COALESCE(NULLIF(substr(fc_receitasaldo, 81, 12), ''), '0') AS float8
            ) AS saldo_arrecadado_acumulado,
            CAST(
                COALESCE(NULLIF(substr(fc_receitasaldo, 94, 12), ''), '0') AS float8
            ) AS saldo_prev_anterior
        from(
                select
                    o70_codigo,
                    fc_receitasaldo({$anousu}, o70_codrec, 3, '{$dt_ini}', '{$dt_fim}')
                from
                    orcreceita d
                    inner join orcfontes e on d.o70_codfon = e.o57_codfon
                    and e.o57_anousu = d.o70_anousu
                where
                    o70_anousu = {$anousu}
                    and o70_instit in (" . str_replace('-', ', ', $db_selinstit) . ")
                order by
                    o57_fonte
            ) as X
            ) as y GROUP BY o70_codigo ORDER BY o70_codigo";

$qResult  = pg_query($sSql);
$aExcesso = array();

for ($i = 0; $i < pg_numrows($qResult); $i++) {
    db_fieldsmemory($qResult, $i);
    $iChave = fonteAgrupada($o70_codigo);

    if (array_key_exists($iChave, $aExcesso)) {
        $aExcesso[$iChave]["A"] += $saldo_excesso;
        continue;
    } 

    // Cria a posição do array
    $aExcesso[$iChave]["A"] = $saldo_excesso;
    $aExcesso[$iChave]["D"] = 0;
}

foreach ($aExcesso as $iChave => $aData) {
    if ($aData["A"] <= 0)
        unset($aExcesso[$iChave]);
}

$sSql = "SELECT
            o58_codigo,
            sum(o47_valor) as valor
                            FROM
                                orcsuplemval
                            LEFT JOIN orcdotacao ON o47_coddot = o58_coddot
                                AND o47_anousu = o58_anousu
                            JOIN orcsuplem ON o47_codsup=o46_codsup
                            WHERE
                                o47_anousu = {$anousu}
                                AND o47_valor > 0
                                AND o58_instit in (" . str_replace('-', ', ', $db_selinstit) . ")
                                AND o46_tiposup IN (1004, 1025, 1012, 1019, 1009, 1010, 1029)
                            GROUP BY o58_codigo
                            UNION
                            SELECT
                                o58_codigo fonte,
                                sum(o136_valor) as valor
                            from
                                orcsuplemdespesappa
                                LEFT JOIN orcsuplemval ON o47_codsup = o136_orcsuplem
                                LEFT JOIN orcdotacao ON o47_coddot = o58_coddot
                                AND o47_anousu = o58_anousu
                                JOIN orcsuplem ON o47_codsup=o46_codsup
                            WHERE
                                o47_anousu = {$anousu}
                                AND o58_instit in (" . str_replace('-', ', ', $db_selinstit) . ")
                                AND o46_tiposup IN (1004, 1025, 1012, 1019, 1009, 1010, 1029)
                                AND o136_valor > 0 
                            GROUP BY o58_codigo";
                            
$subResult = db_query($sSql);

$valorSuplementado = 0;

for ($y = 0; $y < pg_num_rows($subResult); $y++) {
    $oFonte = db_utils::fieldsMemory($subResult, $y);
    $iChave = fonteAgrupada($oFonte->o58_codigo);

    if (array_key_exists($iChave, $aExcesso)) {
        $aExcesso[$iChave]["B"] += $oFonte->valor;
        continue;
    } 

    $aExcesso[$iChave]["B"] = $oFonte->valor;
    $aExcesso[$iChave]["D"] = 0;
}

$sSql = "SELECT fonte, SUM(dot_ini) dot_ini, SUM(suplementado) suplementado, SUM(reduzido) reduzido, SUM(empenhado - anulado) empenhado FROM (select
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
from(
    select
        *,
        fc_dotacaosaldo({$anousu}, o58_coddot, 2,  '{$dt_ini}', '{$dt_fim}')
    from
        orcdotacao w
        inner join orcelemento e on w.o58_codele = e.o56_codele
        and e.o56_anousu = w.o58_anousu
        and e.o56_orcado is true
        inner join orcprojativ ope on w.o58_projativ = ope.o55_projativ
        and ope.o55_anousu = w.o58_anousu
        inner join orctiporec on orctiporec.o15_codigo = w.o58_codigo
    where
        o58_anousu = {$anousu}
        and w.o58_instit in (" . str_replace('-', ', ', $db_selinstit) . ")
    order by
        o58_codigo
) as x) as y GROUP BY fonte";

$subResult = db_query($sSql);
for ($y = 0; $y < pg_num_rows($subResult); $y++) {
    $despesa = db_utils::fieldsMemory($subResult, $y);
    $iChave = fonteAgrupada($despesa->fonte);
    if (array_key_exists($iChave, $aExcesso)) {
        $aExcesso[$iChave]["D"] += $despesa->dot_ini + $despesa->suplementado - $despesa->reduzido;
        $aExcesso[$iChave]["E"] += $despesa->empenhado;
    }
}
//db_criatabela($result);

$pagina = 1;
$tottotal = 0;
$total_a = 0;
$total_b = 0;
$total_c = 0;
$total_d = 0;
$total_e = 0;
$total_f = 0;
$total_g = 0;

ksort($aExcesso);

foreach ($aExcesso as $fonte => $data) {
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
        $pdf->multicell($largura, $alt, "EXCESSO DE ARRECADAÇÃO (A)", 1, "C", 1, 0);
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

    $data["C"] = (($data["B"] - $data["A"]) > 0) ? ($data["B"] - $data["A"]) : 0;
    $data["F"] = $data["D"] - $data["E"];
    $data["G"] = (($data["C"] - $data["F"]) > 0) ? ($data["C"] - $data["F"]) : 0;

    $pdf->setfont('arial', '', 6);

    // Condições de exibição agrupada conforme OC17997
    $fonte = $fonte == 100 ? db_formatar("100", "recurso") . " / " .
        db_formatar("101", "recurso") . " / " .
        db_formatar("102", "recurso") : $fonte;
    $fonte = $fonte == 118 ? db_formatar("118", "recurso") . " / " .
        db_formatar("119", "recurso") : $fonte;
    $fonte = $fonte == 166 ? db_formatar("166", "recurso") . " / " .
        db_formatar("167", "recurso") : $fonte;
    $fonte = $fonte == 15000000 ? db_formatar("15000000", "recurso") . " / " .
        db_formatar("15000001", "recurso") . " / " .
        db_formatar("15000002", "recurso") : $fonte;
    $fonte = $fonte == 15400007 ? db_formatar("15400007", "recurso") . " / " .
        db_formatar("15400000", "recurso") : $fonte;
    $fonte = $fonte == 15420007 ? db_formatar("15420007", "recurso") . " / " .
        db_formatar("15420000", "recurso") : $fonte;    

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



//echo $ass_pref;
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
 * Função para agrupamento de fontes
 * @author widouglas
 * @param integer $fonte
 * @return integer
 */
function fonteAgrupada($fonte) 
{
    if (in_array($fonte, array(101, 102)))
        return 100;

    if ($fonte == 119)
        return 118;

    if ($fonte == 167)
        return 166;

    if (in_array($fonte, array(15000001, 15000002)))
        return 15000000;

    if ($fonte == 15400000)
        return 15400007;

    if ($fonte == 15420000)
        return 15420007;    

    return $fonte;
}