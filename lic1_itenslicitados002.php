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
include("libs/db_sql.php");

db_postmemory($HTTP_SERVER_VARS);
$sWhere = "";
$sAnd = "";
$sOrder = "";

if ($exercicio) {
    $sWhere .= $sAnd . " and l20_anousu = " . $exercicio;
}
if($opselect == "2"){
    if ($procselect){
        $sWhere .= $sAnd . " and l20_codigo not in (" . $procselect . ")";
    }
}else{
    if ($procselect){
        $sWhere .= $sAnd . " and l20_codigo in (" . $procselect . ")";
    }
}

if($orderselect == "1"){
    $sOrder = " order by l202_datahomologacao";
}

if($orderselect == "2"){
    $sOrder = " order by descricao";
}

if($orderselect == "3"){
    $sOrder = " order by pc21_numcgm,pc01_codmater";
}

/*
 * busca dados da instituição atual
 */
$sqlInst = "SELECT codigo inst,
                    nomeinst nome
             FROM db_config
             WHERE codigo = " .db_getsession('DB_instit');

$resultInst = db_query($sqlInst);

db_fieldsmemory($resultInst,0);

/*
 * construção do relatório
 */
$head1 = "Itens Licitados (Novo)";
$head3 = $inst ." - ". $nome;

$pdf = new PDF('Landscape', 'mm', 'A4');
$pdf->Open();
$pdf->AliasNbPages();
$alt = 5;
$pdf->setfillcolor(235);
$pdf->addpage("C");
$pdf->setfont('arial', 'b', 10);

if($impforne == "true" && $impproc == false && $impaco == "true" && $impvlrunit == false){

    $sql = "SELECT DISTINCT pc01_codmater AS codigo,
                CASE
                    WHEN pc01_descrmater = NULL
                         OR pc01_descrmater = pc01_complmater THEN pc01_descrmater
                    ELSE pc01_descrmater||'. '||pc01_complmater
                END AS descricao,
                pc11_quant AS quantidade,
                pc23_vlrun AS valorUnitario,
                pc21_numcgm AS Fornecedor,
                l20_codigo AS Licitacao,
                CASE
                    WHEN pc11_reservado ='t' THEN 'Cota exclusiva'
                    ELSE 'Normal'
                END AS tipoitem,
                l20_edital||' / '||l20_anousu AS processo,
                ac16_sequencial AS Contrato,
                l202_datahomologacao,
                z01_nome
        FROM pcorcamitem
        INNER JOIN pcorcam ON pcorcam.pc20_codorc = pcorcamitem.pc22_codorc
        LEFT JOIN pcorcamforne ON pcorcamforne.pc21_codorc = pcorcam.pc20_codorc
        LEFT JOIN cgm ON cgm.z01_numcgm = pcorcamforne.pc21_numcgm
        INNER JOIN pcorcamitemlic ON pcorcamitemlic.pc26_orcamitem = pcorcamitem.pc22_orcamitem
        INNER JOIN liclicitem ON pcorcamitemlic.pc26_liclicitem = liclicitem.l21_codigo
        INNER JOIN liclicita ON liclicita.l20_codigo = liclicitem.l21_codliclicita
        INNER JOIN pcprocitem ON pcprocitem.pc81_codprocitem = liclicitem.l21_codpcprocitem
        INNER JOIN solicitem ON solicitem.pc11_codigo = pcprocitem.pc81_solicitem
        INNER JOIN solicita ON solicita.pc10_numero = solicitem.pc11_numero
        LEFT JOIN solicitaregistropreco ON solicitaregistropreco.pc54_solicita = solicita.pc10_numero
        LEFT JOIN solicitemunid ON solicitemunid.pc17_codigo = solicitem.pc11_codigo
        LEFT JOIN matunid ON matunid.m61_codmatunid = solicitemunid.pc17_unid
        LEFT JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
        LEFT JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater
        LEFT JOIN pcorcamval ON pcorcamval.pc23_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamval.pc23_orcamforne = pcorcamforne.pc21_orcamforne
        LEFT JOIN pcorcamdescla ON pcorcamdescla.pc32_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamdescla.pc32_orcamforne = pcorcamforne.pc21_orcamforne
        LEFT JOIN liclicitemlote ON liclicitemlote.l04_liclicitem = liclicitem.l21_codigo
        LEFT JOIN licsituacao ON liclicita.l20_licsituacao = licsituacao.l08_sequencial
        LEFT JOIN pcproc ON pcproc.pc80_codproc = pcprocitem.pc81_codproc
        LEFT JOIN pcorcamjulg ON pcorcamjulg.pc24_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamforne.pc21_orcamforne = pcorcamjulg.pc24_orcamforne
        LEFT JOIN acordo ON ac16_licitacao=l20_codigo
        left join homologacaoadjudica on l202_licitacao=l20_codigo
        WHERE pc24_pontuacao= 1
        and l202_datahomologacao is not null
        $sWhere
        AND l20_instit = ". db_getsession("DB_instit") . "
        $sOrder
        ";

    $result = db_query($sql);

    $pdf->cell(14, $alt, "Código", 1, 0, "C",1);
    $pdf->cell(185, $alt, "Descrição", 1, 0, "C",1);
    $pdf->cell(15, $alt, "Qtd.", 1, 0, "C",1);
    $pdf->cell(30, $alt, "Fornecedor", 1, 0, "C",1);
    $pdf->cell(30, $alt, "Contrato", 1, 1, "C",1);

    for($i = 0; $i < pg_num_rows($result); $i++){

        db_fieldsmemory($result,$i);

        $pdf->setfont('arial', '', 8);
        $pdf->cell(14, $alt, substr($codigo,0,164), 1, 0, "C",0);
        $pdf->cell(185, $alt, $descricao, 1, 0, "L",0);
        $pdf->cell(15, $alt, $quantidade, 1, 0, "C",0);
        $pdf->cell(30, $alt, $fornecedor, 1, 0, "C",0);
        $pdf->cell(30, $alt, $contrato, 1, 1, "C",0);

    }
}

if($impforne == "true" && $impproc == "true" && $impaco=="true" && $impvlrunit == "true"){

    /*
 * query de busca de todos os itens licitados no ano
 */
    $sql = "SELECT DISTINCT pc01_codmater AS codigo,
                CASE
                    WHEN pc01_descrmater = NULL
                         OR pc01_descrmater = pc01_complmater THEN pc01_descrmater
                    ELSE pc01_descrmater||'. '||pc01_complmater
                END AS descricao,
                pc11_quant AS quantidade,
                pc23_vlrun AS valorUnitario,
                pc21_numcgm AS Fornecedor,
                l20_codigo AS Licitacao,
                ac16_sequencial AS Contrato,
                CASE
                    WHEN pc11_reservado ='t' THEN 'Cota exclusiva'
                    ELSE 'Normal'
                END AS tipoitem,
                l20_edital||' / '||l20_anousu AS processo,
                l202_datahomologacao,
                z01_nome
        FROM pcorcamitem
        INNER JOIN pcorcam ON pcorcam.pc20_codorc = pcorcamitem.pc22_codorc
        LEFT JOIN pcorcamforne ON pcorcamforne.pc21_codorc = pcorcam.pc20_codorc
        LEFT JOIN cgm ON cgm.z01_numcgm = pcorcamforne.pc21_numcgm
        INNER JOIN pcorcamitemlic ON pcorcamitemlic.pc26_orcamitem = pcorcamitem.pc22_orcamitem
        INNER JOIN liclicitem ON pcorcamitemlic.pc26_liclicitem = liclicitem.l21_codigo
        INNER JOIN liclicita ON liclicita.l20_codigo = liclicitem.l21_codliclicita
        INNER JOIN pcprocitem ON pcprocitem.pc81_codprocitem = liclicitem.l21_codpcprocitem
        INNER JOIN solicitem ON solicitem.pc11_codigo = pcprocitem.pc81_solicitem
        INNER JOIN solicita ON solicita.pc10_numero = solicitem.pc11_numero
        LEFT JOIN solicitaregistropreco ON solicitaregistropreco.pc54_solicita = solicita.pc10_numero
        LEFT JOIN solicitemunid ON solicitemunid.pc17_codigo = solicitem.pc11_codigo
        LEFT JOIN matunid ON matunid.m61_codmatunid = solicitemunid.pc17_unid
        LEFT JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
        LEFT JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater
        LEFT JOIN pcorcamval ON pcorcamval.pc23_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamval.pc23_orcamforne = pcorcamforne.pc21_orcamforne
        LEFT JOIN pcorcamdescla ON pcorcamdescla.pc32_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamdescla.pc32_orcamforne = pcorcamforne.pc21_orcamforne
        LEFT JOIN liclicitemlote ON liclicitemlote.l04_liclicitem = liclicitem.l21_codigo
        LEFT JOIN licsituacao ON liclicita.l20_licsituacao = licsituacao.l08_sequencial
        LEFT JOIN pcproc ON pcproc.pc80_codproc = pcprocitem.pc81_codproc
        LEFT JOIN pcorcamjulg ON pcorcamjulg.pc24_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamforne.pc21_orcamforne = pcorcamjulg.pc24_orcamforne
        LEFT JOIN acordo ON ac16_licitacao=l20_codigo
        left join homologacaoadjudica on l202_licitacao=l20_codigo
        WHERE pc24_pontuacao= 1
        and l202_datahomologacao is not null
        $sWhere
        AND l20_instit = ". db_getsession("DB_instit") . "
        $sOrder
        ";

    $result = db_query($sql);

    if (pg_num_rows(db_query($sql)) == 0) {
        db_redireciona('db_erros.php?fechar=true&db_erro=Não foi encontrado nenhum item licitado para essa instituição.');
    }

    $pdf->cell(14, $alt, "Código", 1, 0, "C",1);
    $pdf->cell(165, $alt, "Descrição", 1, 0, "C",1);
    $pdf->cell(15, $alt, "Qtd.", 1, 0, "C",1);
    $pdf->cell(15, $alt, "Vlr Unit.", 1, 0, "C",1);
    $pdf->cell(30, $alt, "Fornecedor", 1, 0, "C",1);
    $pdf->cell(16, $alt, "Licitação", 1, 0, "C",1);
    $pdf->cell(16, $alt, "Contrato", 1, 1, "C",1);

    for($i = 0; $i < pg_num_rows($result); $i++){

        db_fieldsmemory($result,$i);

        $pdf->setfont('arial', '', 8);
        $pdf->cell(14, $alt, substr($codigo,0,164), 1, 0, "C",0);
        $pdf->cell(165, $alt, $descricao, 1, 0, "L",0);
        $pdf->cell(15, $alt, $quantidade, 1, 0, "C",0);
        $pdf->cell(15, $alt, $valorunitario, 1, 0, "C",0);
        $pdf->cell(30, $alt, $fornecedor, 1, 0, "C",0);
        $pdf->cell(16, $alt, $licitacao, 1, 0, "C",0);
        $pdf->cell(16, $alt, $contrato, 1, 1, "C",0);
    }
}

if($impforne == "true" && $impproc == "true" && $impaco==null && $impvlrunit == "true"){

    /*
     * query de busca de todos os itens licitados no ano
     */
    $sql = "SELECT DISTINCT pc01_codmater AS codigo,
                CASE
                    WHEN pc01_descrmater = NULL
                         OR pc01_descrmater = pc01_complmater THEN pc01_descrmater
                    ELSE pc01_descrmater||'. '||pc01_complmater
                END AS descricao,
                pc11_quant AS quantidade,
                pc23_vlrun AS valorUnitario,
                pc21_numcgm AS Fornecedor,
                l20_codigo AS Licitacao,
                CASE
                    WHEN pc11_reservado ='t' THEN 'Cota exclusiva'
                    ELSE 'Normal'
                END AS tipoitem,
                l20_edital||' / '||l20_anousu AS processo,
                l202_datahomologacao,
                z01_nome
        FROM pcorcamitem
        INNER JOIN pcorcam ON pcorcam.pc20_codorc = pcorcamitem.pc22_codorc
        LEFT JOIN pcorcamforne ON pcorcamforne.pc21_codorc = pcorcam.pc20_codorc
        LEFT JOIN cgm ON cgm.z01_numcgm = pcorcamforne.pc21_numcgm
        INNER JOIN pcorcamitemlic ON pcorcamitemlic.pc26_orcamitem = pcorcamitem.pc22_orcamitem
        INNER JOIN liclicitem ON pcorcamitemlic.pc26_liclicitem = liclicitem.l21_codigo
        INNER JOIN liclicita ON liclicita.l20_codigo = liclicitem.l21_codliclicita
        INNER JOIN pcprocitem ON pcprocitem.pc81_codprocitem = liclicitem.l21_codpcprocitem
        INNER JOIN solicitem ON solicitem.pc11_codigo = pcprocitem.pc81_solicitem
        INNER JOIN solicita ON solicita.pc10_numero = solicitem.pc11_numero
        LEFT JOIN solicitaregistropreco ON solicitaregistropreco.pc54_solicita = solicita.pc10_numero
        LEFT JOIN solicitemunid ON solicitemunid.pc17_codigo = solicitem.pc11_codigo
        LEFT JOIN matunid ON matunid.m61_codmatunid = solicitemunid.pc17_unid
        LEFT JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
        LEFT JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater
        LEFT JOIN pcorcamval ON pcorcamval.pc23_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamval.pc23_orcamforne = pcorcamforne.pc21_orcamforne
        LEFT JOIN pcorcamdescla ON pcorcamdescla.pc32_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamdescla.pc32_orcamforne = pcorcamforne.pc21_orcamforne
        LEFT JOIN liclicitemlote ON liclicitemlote.l04_liclicitem = liclicitem.l21_codigo
        LEFT JOIN licsituacao ON liclicita.l20_licsituacao = licsituacao.l08_sequencial
        LEFT JOIN pcproc ON pcproc.pc80_codproc = pcprocitem.pc81_codproc
        LEFT JOIN pcorcamjulg ON pcorcamjulg.pc24_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamforne.pc21_orcamforne = pcorcamjulg.pc24_orcamforne
        LEFT JOIN acordo ON ac16_licitacao=l20_codigo
        left join homologacaoadjudica on l202_licitacao=l20_codigo
        WHERE pc24_pontuacao= 1
        and l202_datahomologacao is not null
        $sWhere
        AND l20_instit = ". db_getsession("DB_instit") . "
        $sOrder
        ";

    $result = db_query($sql);


    $pdf->cell(14, $alt, "Código", 1, 0, "C",1);
    $pdf->cell(185, $alt, "Descrição", 1, 0, "C",1);
    $pdf->cell(15, $alt, "Qtd.", 1, 0, "C",1);
    $pdf->cell(15, $alt, "Vlr Unit.", 1, 0, "C",1);
    $pdf->cell(30, $alt, "Fornecedor", 1, 0, "C",1);
    $pdf->cell(16, $alt, "Licitação", 1, 1, "C",1);

    for($i = 0; $i < pg_num_rows($result); $i++){

        db_fieldsmemory($result,$i);

        $pdf->setfont('arial', '', 8);
        $pdf->cell(14, $alt, substr($codigo,0,164), 1, 0, "C",0);
        $pdf->cell(185, $alt, $descricao, 1, 0, "L",0);
        $pdf->cell(15, $alt, $quantidade, 1, 0, "C",0);
        $pdf->cell(15, $alt, $valorunitario, 1, 0, "C",0);
        $pdf->cell(30, $alt, $fornecedor, 1, 0, "C",0);
        $pdf->cell(16, $alt, $licitacao, 1, 1, "C",0);
    }
}

if($impforne == "true" && $impproc == null && $impaco == null && $impvlrunit == "true"){

    /*
 * query de busca de todos os itens licitados no ano
 */
    $sql = "SELECT DISTINCT pc01_codmater AS codigo,
                CASE
                    WHEN pc01_descrmater = NULL
                         OR pc01_descrmater = pc01_complmater THEN pc01_descrmater
                    ELSE pc01_descrmater||'. '||pc01_complmater
                END AS descricao,
                pc11_quant AS quantidade,
                pc23_vlrun AS valorUnitario,
                pc21_numcgm AS Fornecedor,
                l20_codigo AS Licitacao,
                CASE
                    WHEN pc11_reservado ='t' THEN 'Cota exclusiva'
                    ELSE 'Normal'
                END AS tipoitem,
                l20_edital||' / '||l20_anousu AS processo,
                l202_datahomologacao,
                z01_nome
        FROM pcorcamitem
        INNER JOIN pcorcam ON pcorcam.pc20_codorc = pcorcamitem.pc22_codorc
        LEFT JOIN pcorcamforne ON pcorcamforne.pc21_codorc = pcorcam.pc20_codorc
        LEFT JOIN cgm ON cgm.z01_numcgm = pcorcamforne.pc21_numcgm
        INNER JOIN pcorcamitemlic ON pcorcamitemlic.pc26_orcamitem = pcorcamitem.pc22_orcamitem
        INNER JOIN liclicitem ON pcorcamitemlic.pc26_liclicitem = liclicitem.l21_codigo
        INNER JOIN liclicita ON liclicita.l20_codigo = liclicitem.l21_codliclicita
        INNER JOIN pcprocitem ON pcprocitem.pc81_codprocitem = liclicitem.l21_codpcprocitem
        INNER JOIN solicitem ON solicitem.pc11_codigo = pcprocitem.pc81_solicitem
        INNER JOIN solicita ON solicita.pc10_numero = solicitem.pc11_numero
        LEFT JOIN solicitaregistropreco ON solicitaregistropreco.pc54_solicita = solicita.pc10_numero
        LEFT JOIN solicitemunid ON solicitemunid.pc17_codigo = solicitem.pc11_codigo
        LEFT JOIN matunid ON matunid.m61_codmatunid = solicitemunid.pc17_unid
        LEFT JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
        LEFT JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater
        LEFT JOIN pcorcamval ON pcorcamval.pc23_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamval.pc23_orcamforne = pcorcamforne.pc21_orcamforne
        LEFT JOIN pcorcamdescla ON pcorcamdescla.pc32_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamdescla.pc32_orcamforne = pcorcamforne.pc21_orcamforne
        LEFT JOIN liclicitemlote ON liclicitemlote.l04_liclicitem = liclicitem.l21_codigo
        LEFT JOIN licsituacao ON liclicita.l20_licsituacao = licsituacao.l08_sequencial
        LEFT JOIN pcproc ON pcproc.pc80_codproc = pcprocitem.pc81_codproc
        LEFT JOIN pcorcamjulg ON pcorcamjulg.pc24_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamforne.pc21_orcamforne = pcorcamjulg.pc24_orcamforne
        LEFT JOIN acordo ON ac16_licitacao=l20_codigo
        left join homologacaoadjudica on l202_licitacao=l20_codigo
        WHERE pc24_pontuacao= 1
        and l202_datahomologacao is not null
        $sWhere
        AND l20_instit = ". db_getsession("DB_instit") . "
        $sOrder
        ";

    $result = db_query($sql);

    if (pg_num_rows(db_query($sql)) == 0) {
        db_redireciona('db_erros.php?fechar=true&db_erro=Não foi encontrado nenhum item licitado para essa instituição.');
    }


    $pdf->cell(14, $alt, "Código", 1, 0, "C",1);
    $pdf->cell(185, $alt, "Descrição", 1, 0, "C",1);
    $pdf->cell(15, $alt, "Qtd.", 1, 0, "C",1);
    $pdf->cell(15, $alt, "Vlr Unit.", 1, 0, "C",1);
    $pdf->cell(50, $alt, "Fornecedor", 1, 1, "C",1);

    for($i = 0; $i < pg_num_rows($result); $i++){

        db_fieldsmemory($result,$i);

        $pdf->setfont('arial', '', 8);
        $pdf->cell(14, $alt, substr($codigo,0,164), 1, 0, "C",0);
        $pdf->cell(185, $alt, $descricao, 1, 0, "L",0);
        $pdf->cell(15, $alt, $quantidade, 1, 0, "C",0);
        $pdf->cell(15, $alt, $valorunitario, 1, 0, "C",0);
        $pdf->cell(50, $alt, $fornecedor, 1, 1, "C",0);
    }
}

if($impforne == "true" && $impproc == null && $impaco == null && $impvlrunit == null){

    /*
     * query de busca de todos os itens licitados no ano
     */
    $sql = "SELECT DISTINCT pc01_codmater AS codigo,
                CASE
                    WHEN pc01_descrmater = NULL
                         OR pc01_descrmater = pc01_complmater THEN pc01_descrmater
                    ELSE pc01_descrmater||'. '||pc01_complmater
                END AS descricao,
                pc11_quant AS quantidade,
                pc23_vlrun AS valorUnitario,
                pc21_numcgm AS Fornecedor,
                l20_codigo AS Licitacao,
                CASE
                    WHEN pc11_reservado ='t' THEN 'Cota exclusiva'
                    ELSE 'Normal'
                END AS tipoitem,
                l20_edital||' / '||l20_anousu AS processo,
                l202_datahomologacao,
                z01_nome
        FROM pcorcamitem
        INNER JOIN pcorcam ON pcorcam.pc20_codorc = pcorcamitem.pc22_codorc
        LEFT JOIN pcorcamforne ON pcorcamforne.pc21_codorc = pcorcam.pc20_codorc
        LEFT JOIN cgm ON cgm.z01_numcgm = pcorcamforne.pc21_numcgm
        INNER JOIN pcorcamitemlic ON pcorcamitemlic.pc26_orcamitem = pcorcamitem.pc22_orcamitem
        INNER JOIN liclicitem ON pcorcamitemlic.pc26_liclicitem = liclicitem.l21_codigo
        INNER JOIN liclicita ON liclicita.l20_codigo = liclicitem.l21_codliclicita
        INNER JOIN pcprocitem ON pcprocitem.pc81_codprocitem = liclicitem.l21_codpcprocitem
        INNER JOIN solicitem ON solicitem.pc11_codigo = pcprocitem.pc81_solicitem
        INNER JOIN solicita ON solicita.pc10_numero = solicitem.pc11_numero
        LEFT JOIN solicitaregistropreco ON solicitaregistropreco.pc54_solicita = solicita.pc10_numero
        LEFT JOIN solicitemunid ON solicitemunid.pc17_codigo = solicitem.pc11_codigo
        LEFT JOIN matunid ON matunid.m61_codmatunid = solicitemunid.pc17_unid
        LEFT JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
        LEFT JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater
        LEFT JOIN pcorcamval ON pcorcamval.pc23_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamval.pc23_orcamforne = pcorcamforne.pc21_orcamforne
        LEFT JOIN pcorcamdescla ON pcorcamdescla.pc32_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamdescla.pc32_orcamforne = pcorcamforne.pc21_orcamforne
        LEFT JOIN liclicitemlote ON liclicitemlote.l04_liclicitem = liclicitem.l21_codigo
        LEFT JOIN licsituacao ON liclicita.l20_licsituacao = licsituacao.l08_sequencial
        LEFT JOIN pcproc ON pcproc.pc80_codproc = pcprocitem.pc81_codproc
        LEFT JOIN pcorcamjulg ON pcorcamjulg.pc24_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamforne.pc21_orcamforne = pcorcamjulg.pc24_orcamforne
        LEFT JOIN acordo ON ac16_licitacao=l20_codigo
        left join homologacaoadjudica on l202_licitacao=l20_codigo
        WHERE pc24_pontuacao= 1
        and l202_datahomologacao is not null
        $sWhere
        AND l20_instit = ". db_getsession("DB_instit") . "
        $sOrder
        ";

    $result = db_query($sql);

    $pdf->cell(14, $alt, "Código", 1, 0, "C",1);
    $pdf->cell(140, $alt, "Descrição", 1, 0, "C",1);
    $pdf->cell(15, $alt, "Qtd.", 1, 0, "C",1);
    $pdf->cell(115, $alt, "Fornecedor", 1, 1, "C",1);

    for($i = 0; $i < pg_num_rows($result); $i++){

        db_fieldsmemory($result,$i);

        $pdf->setfont('arial', '', 8);
        $pdf->cell(14, $alt, substr($codigo,0,164), 1, 0, "C",0);
        $pdf->cell(140, $alt, $descricao, 1, 0, "L",0);
        $pdf->cell(15, $alt, $quantidade, 1, 0, "C",0);
        $pdf->cell(115, $alt, $fornecedor."-".$z01_nome, 1, 1, "C",0);
    }
}

if($impforne == "true" && $impproc == "true" && $impaco == null && $impvlrunit == null){

    $sql = "SELECT DISTINCT pc01_codmater AS codigo,
                CASE
                    WHEN pc01_descrmater = NULL
                         OR pc01_descrmater = pc01_complmater THEN pc01_descrmater
                    ELSE pc01_descrmater||'. '||pc01_complmater
                END AS descricao,
                pc11_quant AS quantidade,
                pc23_vlrun AS valorUnitario,
                pc21_numcgm AS Fornecedor,
                l20_codigo AS Licitacao,
                CASE
                    WHEN pc11_reservado ='t' THEN 'Cota exclusiva'
                    ELSE 'Normal'
                END AS tipoitem,
                l20_edital||' / '||l20_anousu AS processo,
                l202_datahomologacao,
                z01_nome
        FROM pcorcamitem
        INNER JOIN pcorcam ON pcorcam.pc20_codorc = pcorcamitem.pc22_codorc
        LEFT JOIN pcorcamforne ON pcorcamforne.pc21_codorc = pcorcam.pc20_codorc
        LEFT JOIN cgm ON cgm.z01_numcgm = pcorcamforne.pc21_numcgm
        INNER JOIN pcorcamitemlic ON pcorcamitemlic.pc26_orcamitem = pcorcamitem.pc22_orcamitem
        INNER JOIN liclicitem ON pcorcamitemlic.pc26_liclicitem = liclicitem.l21_codigo
        INNER JOIN liclicita ON liclicita.l20_codigo = liclicitem.l21_codliclicita
        INNER JOIN pcprocitem ON pcprocitem.pc81_codprocitem = liclicitem.l21_codpcprocitem
        INNER JOIN solicitem ON solicitem.pc11_codigo = pcprocitem.pc81_solicitem
        INNER JOIN solicita ON solicita.pc10_numero = solicitem.pc11_numero
        LEFT JOIN solicitaregistropreco ON solicitaregistropreco.pc54_solicita = solicita.pc10_numero
        LEFT JOIN solicitemunid ON solicitemunid.pc17_codigo = solicitem.pc11_codigo
        LEFT JOIN matunid ON matunid.m61_codmatunid = solicitemunid.pc17_unid
        LEFT JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
        LEFT JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater
        LEFT JOIN pcorcamval ON pcorcamval.pc23_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamval.pc23_orcamforne = pcorcamforne.pc21_orcamforne
        LEFT JOIN pcorcamdescla ON pcorcamdescla.pc32_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamdescla.pc32_orcamforne = pcorcamforne.pc21_orcamforne
        LEFT JOIN liclicitemlote ON liclicitemlote.l04_liclicitem = liclicitem.l21_codigo
        LEFT JOIN licsituacao ON liclicita.l20_licsituacao = licsituacao.l08_sequencial
        LEFT JOIN pcproc ON pcproc.pc80_codproc = pcprocitem.pc81_codproc
        LEFT JOIN pcorcamjulg ON pcorcamjulg.pc24_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamforne.pc21_orcamforne = pcorcamjulg.pc24_orcamforne
        LEFT JOIN acordo ON ac16_licitacao=l20_codigo
        left join homologacaoadjudica on l202_licitacao=l20_codigo
        WHERE pc24_pontuacao= 1
        and l202_datahomologacao is not null
        $sWhere
        AND l20_instit = ". db_getsession("DB_instit") . "
        $sOrder
        ";

    $result = db_query($sql);

    $pdf->cell(14, $alt, "Código", 1, 0, "C",1);
    $pdf->cell(135, $alt, "Descrição", 1, 0, "C",1);
    $pdf->cell(15, $alt, "Qtd.", 1, 0, "C",1);
    $pdf->cell(85, $alt, "Fornecedor", 1, 0, "C",1);
    $pdf->cell(30, $alt, "Licitação", 1, 1, "C",1);

    for($i = 0; $i < pg_num_rows($result); $i++){

        db_fieldsmemory($result,$i);

        $pdf->setfont('arial', '', 8);
        $pdf->cell(14, $alt, substr($codigo,0,164), 1, 0, "C",0);
        $pdf->cell(135, $alt, $descricao, 1, 0, "L",0);
        $pdf->cell(15, $alt, $quantidade, 1, 0, "C",0);
        $pdf->cell(85, $alt, $fornecedor."-".$z01_nome, 1, 0, "C",0);
        $pdf->cell(30, $alt, $licitacao, 1, 1, "C",0);
    }
}

if($impforne == "true" && $impproc == "true" && $impaco == "true" && $impvlrunit == null){

    $sql = "SELECT DISTINCT pc01_codmater AS codigo,
                CASE
                    WHEN pc01_descrmater = NULL
                         OR pc01_descrmater = pc01_complmater THEN pc01_descrmater
                    ELSE pc01_descrmater||'. '||pc01_complmater
                END AS descricao,
                pc11_quant AS quantidade,
                pc23_vlrun AS valorUnitario,
                pc21_numcgm AS Fornecedor,
                l20_codigo AS Licitacao,
                CASE
                    WHEN pc11_reservado ='t' THEN 'Cota exclusiva'
                    ELSE 'Normal'
                END AS tipoitem,
                l20_edital||' / '||l20_anousu AS processo,
                ac16_sequencial AS Contrato,
                l202_datahomologacao,
                z01_nome
        FROM pcorcamitem
        INNER JOIN pcorcam ON pcorcam.pc20_codorc = pcorcamitem.pc22_codorc
        LEFT JOIN pcorcamforne ON pcorcamforne.pc21_codorc = pcorcam.pc20_codorc
        LEFT JOIN cgm ON cgm.z01_numcgm = pcorcamforne.pc21_numcgm
        INNER JOIN pcorcamitemlic ON pcorcamitemlic.pc26_orcamitem = pcorcamitem.pc22_orcamitem
        INNER JOIN liclicitem ON pcorcamitemlic.pc26_liclicitem = liclicitem.l21_codigo
        INNER JOIN liclicita ON liclicita.l20_codigo = liclicitem.l21_codliclicita
        INNER JOIN pcprocitem ON pcprocitem.pc81_codprocitem = liclicitem.l21_codpcprocitem
        INNER JOIN solicitem ON solicitem.pc11_codigo = pcprocitem.pc81_solicitem
        INNER JOIN solicita ON solicita.pc10_numero = solicitem.pc11_numero
        LEFT JOIN solicitaregistropreco ON solicitaregistropreco.pc54_solicita = solicita.pc10_numero
        LEFT JOIN solicitemunid ON solicitemunid.pc17_codigo = solicitem.pc11_codigo
        LEFT JOIN matunid ON matunid.m61_codmatunid = solicitemunid.pc17_unid
        LEFT JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
        LEFT JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater
        LEFT JOIN pcorcamval ON pcorcamval.pc23_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamval.pc23_orcamforne = pcorcamforne.pc21_orcamforne
        LEFT JOIN pcorcamdescla ON pcorcamdescla.pc32_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamdescla.pc32_orcamforne = pcorcamforne.pc21_orcamforne
        LEFT JOIN liclicitemlote ON liclicitemlote.l04_liclicitem = liclicitem.l21_codigo
        LEFT JOIN licsituacao ON liclicita.l20_licsituacao = licsituacao.l08_sequencial
        LEFT JOIN pcproc ON pcproc.pc80_codproc = pcprocitem.pc81_codproc
        LEFT JOIN pcorcamjulg ON pcorcamjulg.pc24_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamforne.pc21_orcamforne = pcorcamjulg.pc24_orcamforne
        LEFT JOIN acordo ON ac16_licitacao=l20_codigo
        left join homologacaoadjudica on l202_licitacao=l20_codigo
        WHERE pc24_pontuacao= 1
        and l202_datahomologacao is not null
        $sWhere
        AND l20_instit = ". db_getsession("DB_instit") . "
        $sOrder
        ";

    $result = db_query($sql);

    $pdf->cell(14, $alt, "Código", 1, 0, "C",1);
    $pdf->cell(120, $alt, "Descrição", 1, 0, "C",1);
    $pdf->cell(15, $alt, "Qtd.", 1, 0, "C",1);
    $pdf->cell(90, $alt, "Fornecedor", 1, 0, "C",1);
    $pdf->cell(20, $alt, "Licitação", 1, 0, "C",1);
    $pdf->cell(20, $alt, "Contrato", 1, 1, "C",1);

    for($i = 0; $i < pg_num_rows($result); $i++){

        db_fieldsmemory($result,$i);

        $pdf->setfont('arial', '', 8);
        $pdf->cell(14, $alt, substr($codigo,0,164), 1, 0, "C",0);
        $pdf->cell(120, $alt, $descricao, 1, 0, "L",0);
        $pdf->cell(15, $alt, $quantidade, 1, 0, "C",0);
        $pdf->cell(90, $alt, $fornecedor."-".$z01_nome, 1, 0, "C",0);
        $pdf->cell(20, $alt, $licitacao, 1, 0, "C",0);
        $pdf->cell(20, $alt, $contrato, 1, 1, "C",0);

    }
}

if($impforne == false && $impproc == "true" && $impaco == "true" && $impvlrunit == "true"){

    $sql = "SELECT DISTINCT pc01_codmater AS codigo,
                CASE
                    WHEN pc01_descrmater = NULL
                         OR pc01_descrmater = pc01_complmater THEN pc01_descrmater
                    ELSE pc01_descrmater||'. '||pc01_complmater
                END AS descricao,
                pc11_quant AS quantidade,
                pc23_vlrun AS valorUnitario,
                pc21_numcgm AS Fornecedor,
                l20_codigo AS Licitacao,
                CASE
                    WHEN pc11_reservado ='t' THEN 'Cota exclusiva'
                    ELSE 'Normal'
                END AS tipoitem,
                l20_edital||' / '||l20_anousu AS processo,
                ac16_sequencial AS Contrato,
                l202_datahomologacao,
                z01_nome
        FROM pcorcamitem
        INNER JOIN pcorcam ON pcorcam.pc20_codorc = pcorcamitem.pc22_codorc
        LEFT JOIN pcorcamforne ON pcorcamforne.pc21_codorc = pcorcam.pc20_codorc
        LEFT JOIN cgm ON cgm.z01_numcgm = pcorcamforne.pc21_numcgm
        INNER JOIN pcorcamitemlic ON pcorcamitemlic.pc26_orcamitem = pcorcamitem.pc22_orcamitem
        INNER JOIN liclicitem ON pcorcamitemlic.pc26_liclicitem = liclicitem.l21_codigo
        INNER JOIN liclicita ON liclicita.l20_codigo = liclicitem.l21_codliclicita
        INNER JOIN pcprocitem ON pcprocitem.pc81_codprocitem = liclicitem.l21_codpcprocitem
        INNER JOIN solicitem ON solicitem.pc11_codigo = pcprocitem.pc81_solicitem
        INNER JOIN solicita ON solicita.pc10_numero = solicitem.pc11_numero
        LEFT JOIN solicitaregistropreco ON solicitaregistropreco.pc54_solicita = solicita.pc10_numero
        LEFT JOIN solicitemunid ON solicitemunid.pc17_codigo = solicitem.pc11_codigo
        LEFT JOIN matunid ON matunid.m61_codmatunid = solicitemunid.pc17_unid
        LEFT JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
        LEFT JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater
        LEFT JOIN pcorcamval ON pcorcamval.pc23_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamval.pc23_orcamforne = pcorcamforne.pc21_orcamforne
        LEFT JOIN pcorcamdescla ON pcorcamdescla.pc32_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamdescla.pc32_orcamforne = pcorcamforne.pc21_orcamforne
        LEFT JOIN liclicitemlote ON liclicitemlote.l04_liclicitem = liclicitem.l21_codigo
        LEFT JOIN licsituacao ON liclicita.l20_licsituacao = licsituacao.l08_sequencial
        LEFT JOIN pcproc ON pcproc.pc80_codproc = pcprocitem.pc81_codproc
        LEFT JOIN pcorcamjulg ON pcorcamjulg.pc24_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamforne.pc21_orcamforne = pcorcamjulg.pc24_orcamforne
        LEFT JOIN acordo ON ac16_licitacao=l20_codigo
        left join homologacaoadjudica on l202_licitacao=l20_codigo
        WHERE pc24_pontuacao= 1
        and l202_datahomologacao is not null
        $sWhere
        AND l20_instit = ". db_getsession("DB_instit") . "
        $sOrder
        ";

    $result = db_query($sql);

    $pdf->cell(14, $alt, "Código", 1, 0, "C",1);
    $pdf->cell(175, $alt, "Descrição", 1, 0, "C",1);
    $pdf->cell(15, $alt, "Qtd.", 1, 0, "C",1);
    $pdf->cell(15, $alt, "Vlr Unit.", 1, 0, "C",1);
    $pdf->cell(30, $alt, "Licitação", 1, 0, "C",1);
    $pdf->cell(30, $alt, "Contrato", 1, 1, "C",1);

    for($i = 0; $i < pg_num_rows($result); $i++){

        db_fieldsmemory($result,$i);

        $pdf->setfont('arial', '', 8);
        $pdf->cell(14, $alt, substr($codigo,0,164), 1, 0, "C",0);
        $pdf->cell(175, $alt, $descricao, 1, 0, "L",0);
        $pdf->cell(15, $alt, $quantidade, 1, 0, "C",0);
        $pdf->cell(15, $alt, $valorunitario, 1, 0, "C",0);
        $pdf->cell(30, $alt, $licitacao, 1, 0, "C",0);
        $pdf->cell(30, $alt, $contrato, 1, 1, "C",0);

    }
}

if($impforne == false && $impproc == false && $impaco == "true" && $impvlrunit == "true"){

    $sql = "SELECT DISTINCT pc01_codmater AS codigo,
                CASE
                    WHEN pc01_descrmater = NULL
                         OR pc01_descrmater = pc01_complmater THEN pc01_descrmater
                    ELSE pc01_descrmater||'. '||pc01_complmater
                END AS descricao,
                pc11_quant AS quantidade,
                pc23_vlrun AS valorUnitario,
                pc21_numcgm AS Fornecedor,
                l20_codigo AS Licitacao,
                CASE
                    WHEN pc11_reservado ='t' THEN 'Cota exclusiva'
                    ELSE 'Normal'
                END AS tipoitem,
                l20_edital||' / '||l20_anousu AS processo,
                ac16_sequencial AS Contrato,
                l202_datahomologacao,
                z01_nome
        FROM pcorcamitem
        INNER JOIN pcorcam ON pcorcam.pc20_codorc = pcorcamitem.pc22_codorc
        LEFT JOIN pcorcamforne ON pcorcamforne.pc21_codorc = pcorcam.pc20_codorc
        LEFT JOIN cgm ON cgm.z01_numcgm = pcorcamforne.pc21_numcgm
        INNER JOIN pcorcamitemlic ON pcorcamitemlic.pc26_orcamitem = pcorcamitem.pc22_orcamitem
        INNER JOIN liclicitem ON pcorcamitemlic.pc26_liclicitem = liclicitem.l21_codigo
        INNER JOIN liclicita ON liclicita.l20_codigo = liclicitem.l21_codliclicita
        INNER JOIN pcprocitem ON pcprocitem.pc81_codprocitem = liclicitem.l21_codpcprocitem
        INNER JOIN solicitem ON solicitem.pc11_codigo = pcprocitem.pc81_solicitem
        INNER JOIN solicita ON solicita.pc10_numero = solicitem.pc11_numero
        LEFT JOIN solicitaregistropreco ON solicitaregistropreco.pc54_solicita = solicita.pc10_numero
        LEFT JOIN solicitemunid ON solicitemunid.pc17_codigo = solicitem.pc11_codigo
        LEFT JOIN matunid ON matunid.m61_codmatunid = solicitemunid.pc17_unid
        LEFT JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
        LEFT JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater
        LEFT JOIN pcorcamval ON pcorcamval.pc23_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamval.pc23_orcamforne = pcorcamforne.pc21_orcamforne
        LEFT JOIN pcorcamdescla ON pcorcamdescla.pc32_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamdescla.pc32_orcamforne = pcorcamforne.pc21_orcamforne
        LEFT JOIN liclicitemlote ON liclicitemlote.l04_liclicitem = liclicitem.l21_codigo
        LEFT JOIN licsituacao ON liclicita.l20_licsituacao = licsituacao.l08_sequencial
        LEFT JOIN pcproc ON pcproc.pc80_codproc = pcprocitem.pc81_codproc
        LEFT JOIN pcorcamjulg ON pcorcamjulg.pc24_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamforne.pc21_orcamforne = pcorcamjulg.pc24_orcamforne
        LEFT JOIN acordo ON ac16_licitacao=l20_codigo
        left join homologacaoadjudica on l202_licitacao=l20_codigo
        WHERE pc24_pontuacao= 1
        and l202_datahomologacao is not null
        $sWhere
        AND l20_instit = ". db_getsession("DB_instit") . "
        $sOrder
        ";

    $result = db_query($sql);

    $pdf->cell(14, $alt, "Código", 1, 0, "C",1);
    $pdf->cell(205, $alt, "Descrição", 1, 0, "C",1);
    $pdf->cell(15, $alt, "Qtd.", 1, 0, "C",1);
    $pdf->cell(15, $alt, "Vlr Unit.", 1, 0, "C",1);
    $pdf->cell(30, $alt, "Contrato", 1, 1, "C",1);

    for($i = 0; $i < pg_num_rows($result); $i++){

        db_fieldsmemory($result,$i);

        $pdf->setfont('arial', '', 8);
        $pdf->cell(14, $alt, substr($codigo,0,164), 1, 0, "C",0);
        $pdf->cell(205, $alt, $descricao, 1, 0, "L",0);
        $pdf->cell(15, $alt, $quantidade, 1, 0, "C",0);
        $pdf->cell(15, $alt, $valorunitario, 1, 0, "C",0);
        $pdf->cell(30, $alt, $contrato, 1, 1, "C",0);

    }
}

if($impforne == false && $impproc == false && $impaco == false && $impvlrunit == "true"){

    $sql = "SELECT DISTINCT pc01_codmater AS codigo,
                CASE
                    WHEN pc01_descrmater = NULL
                         OR pc01_descrmater = pc01_complmater THEN pc01_descrmater
                    ELSE pc01_descrmater||'. '||pc01_complmater
                END AS descricao,
                pc11_quant AS quantidade,
                pc23_vlrun AS valorUnitario,
                pc21_numcgm AS Fornecedor,
                l20_codigo AS Licitacao,
                CASE
                    WHEN pc11_reservado ='t' THEN 'Cota exclusiva'
                    ELSE 'Normal'
                END AS tipoitem,
                l20_edital||' / '||l20_anousu AS processo,
                l202_datahomologacao,
                z01_nome
        FROM pcorcamitem
        INNER JOIN pcorcam ON pcorcam.pc20_codorc = pcorcamitem.pc22_codorc
        LEFT JOIN pcorcamforne ON pcorcamforne.pc21_codorc = pcorcam.pc20_codorc
        LEFT JOIN cgm ON cgm.z01_numcgm = pcorcamforne.pc21_numcgm
        INNER JOIN pcorcamitemlic ON pcorcamitemlic.pc26_orcamitem = pcorcamitem.pc22_orcamitem
        INNER JOIN liclicitem ON pcorcamitemlic.pc26_liclicitem = liclicitem.l21_codigo
        INNER JOIN liclicita ON liclicita.l20_codigo = liclicitem.l21_codliclicita
        INNER JOIN pcprocitem ON pcprocitem.pc81_codprocitem = liclicitem.l21_codpcprocitem
        INNER JOIN solicitem ON solicitem.pc11_codigo = pcprocitem.pc81_solicitem
        INNER JOIN solicita ON solicita.pc10_numero = solicitem.pc11_numero
        LEFT JOIN solicitaregistropreco ON solicitaregistropreco.pc54_solicita = solicita.pc10_numero
        LEFT JOIN solicitemunid ON solicitemunid.pc17_codigo = solicitem.pc11_codigo
        LEFT JOIN matunid ON matunid.m61_codmatunid = solicitemunid.pc17_unid
        LEFT JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
        LEFT JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater
        LEFT JOIN pcorcamval ON pcorcamval.pc23_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamval.pc23_orcamforne = pcorcamforne.pc21_orcamforne
        LEFT JOIN pcorcamdescla ON pcorcamdescla.pc32_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamdescla.pc32_orcamforne = pcorcamforne.pc21_orcamforne
        LEFT JOIN liclicitemlote ON liclicitemlote.l04_liclicitem = liclicitem.l21_codigo
        LEFT JOIN licsituacao ON liclicita.l20_licsituacao = licsituacao.l08_sequencial
        LEFT JOIN pcproc ON pcproc.pc80_codproc = pcprocitem.pc81_codproc
        LEFT JOIN pcorcamjulg ON pcorcamjulg.pc24_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamforne.pc21_orcamforne = pcorcamjulg.pc24_orcamforne
        LEFT JOIN acordo ON ac16_licitacao=l20_codigo
        left join homologacaoadjudica on l202_licitacao=l20_codigo
        WHERE pc24_pontuacao= 1
        and l202_datahomologacao is not null
        $sWhere
        AND l20_instit = ". db_getsession("DB_instit") . "
        $sOrder
        ";

    $result = db_query($sql);

    $pdf->cell(14, $alt, "Código", 1, 0, "C",1);
    $pdf->cell(235, $alt, "Descrição", 1, 0, "C",1);
    $pdf->cell(15, $alt, "Qtd.", 1, 0, "C",1);
    $pdf->cell(15, $alt, "Vlr Unit.", 1, 1, "C",1);

    for($i = 0; $i < pg_num_rows($result); $i++){

        db_fieldsmemory($result,$i);

        $pdf->setfont('arial', '', 8);
        $pdf->cell(14, $alt, substr($codigo,0,164), 1, 0, "C",0);
        $pdf->cell(235, $alt, $descricao, 1, 0, "L",0);
        $pdf->cell(15, $alt, $quantidade, 1, 0, "C",0);
        $pdf->cell(15, $alt, $valorunitario, 1, 1, "C",0);

    }
}

if($impforne == false && $impproc == "true" && $impaco == false && $impvlrunit == "true"){

    $sql = "SELECT DISTINCT pc01_codmater AS codigo,
                CASE
                    WHEN pc01_descrmater = NULL
                         OR pc01_descrmater = pc01_complmater THEN pc01_descrmater
                    ELSE pc01_descrmater||'. '||pc01_complmater
                END AS descricao,
                pc11_quant AS quantidade,
                pc23_vlrun AS valorUnitario,
                pc21_numcgm AS Fornecedor,
                l20_codigo AS Licitacao,
                CASE
                    WHEN pc11_reservado ='t' THEN 'Cota exclusiva'
                    ELSE 'Normal'
                END AS tipoitem,
                l20_edital||' / '||l20_anousu AS processo,
                l202_datahomologacao,
                z01_nome
        FROM pcorcamitem
        INNER JOIN pcorcam ON pcorcam.pc20_codorc = pcorcamitem.pc22_codorc
        LEFT JOIN pcorcamforne ON pcorcamforne.pc21_codorc = pcorcam.pc20_codorc
        LEFT JOIN cgm ON cgm.z01_numcgm = pcorcamforne.pc21_numcgm
        INNER JOIN pcorcamitemlic ON pcorcamitemlic.pc26_orcamitem = pcorcamitem.pc22_orcamitem
        INNER JOIN liclicitem ON pcorcamitemlic.pc26_liclicitem = liclicitem.l21_codigo
        INNER JOIN liclicita ON liclicita.l20_codigo = liclicitem.l21_codliclicita
        INNER JOIN pcprocitem ON pcprocitem.pc81_codprocitem = liclicitem.l21_codpcprocitem
        INNER JOIN solicitem ON solicitem.pc11_codigo = pcprocitem.pc81_solicitem
        INNER JOIN solicita ON solicita.pc10_numero = solicitem.pc11_numero
        LEFT JOIN solicitaregistropreco ON solicitaregistropreco.pc54_solicita = solicita.pc10_numero
        LEFT JOIN solicitemunid ON solicitemunid.pc17_codigo = solicitem.pc11_codigo
        LEFT JOIN matunid ON matunid.m61_codmatunid = solicitemunid.pc17_unid
        LEFT JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
        LEFT JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater
        LEFT JOIN pcorcamval ON pcorcamval.pc23_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamval.pc23_orcamforne = pcorcamforne.pc21_orcamforne
        LEFT JOIN pcorcamdescla ON pcorcamdescla.pc32_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamdescla.pc32_orcamforne = pcorcamforne.pc21_orcamforne
        LEFT JOIN liclicitemlote ON liclicitemlote.l04_liclicitem = liclicitem.l21_codigo
        LEFT JOIN licsituacao ON liclicita.l20_licsituacao = licsituacao.l08_sequencial
        LEFT JOIN pcproc ON pcproc.pc80_codproc = pcprocitem.pc81_codproc
        LEFT JOIN pcorcamjulg ON pcorcamjulg.pc24_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamforne.pc21_orcamforne = pcorcamjulg.pc24_orcamforne
        LEFT JOIN acordo ON ac16_licitacao=l20_codigo
        left join homologacaoadjudica on l202_licitacao=l20_codigo
        WHERE pc24_pontuacao= 1
        and l202_datahomologacao is not null
        $sWhere
        AND l20_instit = ". db_getsession("DB_instit") . "
        $sOrder
        ";

    $result = db_query($sql);

    $pdf->cell(14, $alt, "Código", 1, 0, "C",1);
    $pdf->cell(220, $alt, "Descrição", 1, 0, "C",1);
    $pdf->cell(30, $alt, "Licitação", 1, 0, "C",1);
    $pdf->cell(15, $alt, "Vlr Unit.", 1, 1, "C",1);

    for($i = 0; $i < pg_num_rows($result); $i++){

        db_fieldsmemory($result,$i);

        $pdf->setfont('arial', '', 8);
        $pdf->cell(14, $alt, substr($codigo,0,164), 1, 0, "C",0);
        $pdf->cell(220, $alt, $descricao, 1, 0, "L",0);
        $pdf->cell(30, $alt, $licitacao, 1, 0, "C",0);
        $pdf->cell(15, $alt, $valorunitario, 1, 1, "C",0);

    }
}

if($impforne == "true" && $impproc == false && $impaco == "true" && $impvlrunit == "true"){

    $sql = "SELECT DISTINCT pc01_codmater AS codigo,
                CASE
                    WHEN pc01_descrmater = NULL
                         OR pc01_descrmater = pc01_complmater THEN pc01_descrmater
                    ELSE pc01_descrmater||'. '||pc01_complmater
                END AS descricao,
                pc11_quant AS quantidade,
                pc23_vlrun AS valorUnitario,
                pc21_numcgm AS Fornecedor,
                l20_codigo AS Licitacao,
                CASE
                    WHEN pc11_reservado ='t' THEN 'Cota exclusiva'
                    ELSE 'Normal'
                END AS tipoitem,
                l20_edital||' / '||l20_anousu AS processo,
                ac16_sequencial AS Contrato,
                l202_datahomologacao,
                z01_nome
        FROM pcorcamitem
        INNER JOIN pcorcam ON pcorcam.pc20_codorc = pcorcamitem.pc22_codorc
        LEFT JOIN pcorcamforne ON pcorcamforne.pc21_codorc = pcorcam.pc20_codorc
        LEFT JOIN cgm ON cgm.z01_numcgm = pcorcamforne.pc21_numcgm
        INNER JOIN pcorcamitemlic ON pcorcamitemlic.pc26_orcamitem = pcorcamitem.pc22_orcamitem
        INNER JOIN liclicitem ON pcorcamitemlic.pc26_liclicitem = liclicitem.l21_codigo
        INNER JOIN liclicita ON liclicita.l20_codigo = liclicitem.l21_codliclicita
        INNER JOIN pcprocitem ON pcprocitem.pc81_codprocitem = liclicitem.l21_codpcprocitem
        INNER JOIN solicitem ON solicitem.pc11_codigo = pcprocitem.pc81_solicitem
        INNER JOIN solicita ON solicita.pc10_numero = solicitem.pc11_numero
        LEFT JOIN solicitaregistropreco ON solicitaregistropreco.pc54_solicita = solicita.pc10_numero
        LEFT JOIN solicitemunid ON solicitemunid.pc17_codigo = solicitem.pc11_codigo
        LEFT JOIN matunid ON matunid.m61_codmatunid = solicitemunid.pc17_unid
        LEFT JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
        LEFT JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater
        LEFT JOIN pcorcamval ON pcorcamval.pc23_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamval.pc23_orcamforne = pcorcamforne.pc21_orcamforne
        LEFT JOIN pcorcamdescla ON pcorcamdescla.pc32_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamdescla.pc32_orcamforne = pcorcamforne.pc21_orcamforne
        LEFT JOIN liclicitemlote ON liclicitemlote.l04_liclicitem = liclicitem.l21_codigo
        LEFT JOIN licsituacao ON liclicita.l20_licsituacao = licsituacao.l08_sequencial
        LEFT JOIN pcproc ON pcproc.pc80_codproc = pcprocitem.pc81_codproc
        LEFT JOIN pcorcamjulg ON pcorcamjulg.pc24_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamforne.pc21_orcamforne = pcorcamjulg.pc24_orcamforne
        LEFT JOIN acordo ON ac16_licitacao=l20_codigo
        left join homologacaoadjudica on l202_licitacao=l20_codigo
        WHERE pc24_pontuacao= 1
        and l202_datahomologacao is not null
        $sWhere
        AND l20_instit = ". db_getsession("DB_instit") . "
        $sOrder
        ";

    $result = db_query($sql);

    $pdf->cell(14, $alt, "Código", 1, 0, "C",1);
    $pdf->cell(130, $alt, "Descrição", 1, 0, "C",1);
    $pdf->cell(15, $alt, "Qtd.", 1, 0, "C",1);
    $pdf->cell(80, $alt, "Fornecedor", 1, 0, "C",1);
    $pdf->cell(15, $alt, "Vlr Unit.", 1, 0, "C",1);
    $pdf->cell(20, $alt, "Contrato", 1, 1, "C",1);

    for($i = 0; $i < pg_num_rows($result); $i++){

        db_fieldsmemory($result,$i);

        $pdf->setfont('arial', '', 8);
        $pdf->cell(14, $alt, substr($codigo,0,164), 1, 0, "C",0);
        $pdf->cell(130, $alt, $descricao, 1, 0, "L",0);
        $pdf->cell(15, $alt, $quantidade, 1, 0, "C",0);
        $pdf->cell(80, $alt, $fornecedor."-".$z01_nome, 1, 0, "C",0);
        $pdf->cell(15, $alt, $valorunitario, 1, 0, "C",0);
        $pdf->cell(20, $alt, $contrato, 1, 1, "C",0);

    }
}

if($impforne == false && $impproc == "true" && $impaco == "true" && $impvlrunit == false){

    $sql = "SELECT DISTINCT pc01_codmater AS codigo,
                CASE
                    WHEN pc01_descrmater = NULL
                         OR pc01_descrmater = pc01_complmater THEN pc01_descrmater
                    ELSE pc01_descrmater||'. '||pc01_complmater
                END AS descricao,
                pc11_quant AS quantidade,
                pc23_vlrun AS valorUnitario,
                pc21_numcgm AS Fornecedor,
                l20_codigo AS Licitacao,
                CASE
                    WHEN pc11_reservado ='t' THEN 'Cota exclusiva'
                    ELSE 'Normal'
                END AS tipoitem,
                l20_edital||' / '||l20_anousu AS processo,
                ac16_sequencial AS Contrato,
                l202_datahomologacao,
                z01_nome
        FROM pcorcamitem
        INNER JOIN pcorcam ON pcorcam.pc20_codorc = pcorcamitem.pc22_codorc
        LEFT JOIN pcorcamforne ON pcorcamforne.pc21_codorc = pcorcam.pc20_codorc
        LEFT JOIN cgm ON cgm.z01_numcgm = pcorcamforne.pc21_numcgm
        INNER JOIN pcorcamitemlic ON pcorcamitemlic.pc26_orcamitem = pcorcamitem.pc22_orcamitem
        INNER JOIN liclicitem ON pcorcamitemlic.pc26_liclicitem = liclicitem.l21_codigo
        INNER JOIN liclicita ON liclicita.l20_codigo = liclicitem.l21_codliclicita
        INNER JOIN pcprocitem ON pcprocitem.pc81_codprocitem = liclicitem.l21_codpcprocitem
        INNER JOIN solicitem ON solicitem.pc11_codigo = pcprocitem.pc81_solicitem
        INNER JOIN solicita ON solicita.pc10_numero = solicitem.pc11_numero
        LEFT JOIN solicitaregistropreco ON solicitaregistropreco.pc54_solicita = solicita.pc10_numero
        LEFT JOIN solicitemunid ON solicitemunid.pc17_codigo = solicitem.pc11_codigo
        LEFT JOIN matunid ON matunid.m61_codmatunid = solicitemunid.pc17_unid
        LEFT JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
        LEFT JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater
        LEFT JOIN pcorcamval ON pcorcamval.pc23_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamval.pc23_orcamforne = pcorcamforne.pc21_orcamforne
        LEFT JOIN pcorcamdescla ON pcorcamdescla.pc32_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamdescla.pc32_orcamforne = pcorcamforne.pc21_orcamforne
        LEFT JOIN liclicitemlote ON liclicitemlote.l04_liclicitem = liclicitem.l21_codigo
        LEFT JOIN licsituacao ON liclicita.l20_licsituacao = licsituacao.l08_sequencial
        LEFT JOIN pcproc ON pcproc.pc80_codproc = pcprocitem.pc81_codproc
        LEFT JOIN pcorcamjulg ON pcorcamjulg.pc24_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamforne.pc21_orcamforne = pcorcamjulg.pc24_orcamforne
        LEFT JOIN acordo ON ac16_licitacao=l20_codigo
        left join homologacaoadjudica on l202_licitacao=l20_codigo
        WHERE pc24_pontuacao= 1
        and l202_datahomologacao is not null
        $sWhere
        AND l20_instit = ". db_getsession("DB_instit") . "
        $sOrder
        ";

    $result = db_query($sql);

    $pdf->cell(14, $alt, "Código", 1, 0, "C",1);
    $pdf->cell(185, $alt, "Descrição", 1, 0, "C",1);
    $pdf->cell(15, $alt, "Qtd.", 1, 0, "C",1);
    $pdf->cell(30, $alt, "Licitação", 1, 0, "C",1);
    $pdf->cell(30, $alt, "Contrato", 1, 1, "C",1);

    for($i = 0; $i < pg_num_rows($result); $i++){

        db_fieldsmemory($result,$i);

        $pdf->setfont('arial', '', 8);
        $pdf->cell(14, $alt, substr($codigo,0,164), 1, 0, "C",0);
        $pdf->cell(185, $alt, $descricao, 1, 0, "L",0);
        $pdf->cell(15, $alt, $quantidade, 1, 0, "C",0);
        $pdf->cell(30, $alt, $licitacao, 1, 0, "C",0);
        $pdf->cell(30, $alt, $contrato, 1, 1, "C",0);

    }
}

if($impforne == null && $impproc == null && $impaco == null && $impvlrunit == null){

    $sql = "SELECT x.codigo,
                   x.descricao,
                   sum(x.quantidade) as quantidade
            FROM
                (SELECT DISTINCT pc01_codmater AS codigo,
                                 CASE
                                     WHEN pc01_descrmater = NULL
                                          OR pc01_descrmater = pc01_complmater THEN pc01_descrmater
                                     ELSE pc01_descrmater||'. '||pc01_complmater
                                 END AS descricao,
                                 pc11_quant AS quantidade
                 FROM pcorcamitem
                 INNER JOIN pcorcam ON pcorcam.pc20_codorc = pcorcamitem.pc22_codorc
                 LEFT JOIN pcorcamforne ON pcorcamforne.pc21_codorc = pcorcam.pc20_codorc
                 LEFT JOIN cgm ON cgm.z01_numcgm = pcorcamforne.pc21_numcgm
                 INNER JOIN pcorcamitemlic ON pcorcamitemlic.pc26_orcamitem = pcorcamitem.pc22_orcamitem
                 INNER JOIN liclicitem ON pcorcamitemlic.pc26_liclicitem = liclicitem.l21_codigo
                 INNER JOIN liclicita ON liclicita.l20_codigo = liclicitem.l21_codliclicita
                 INNER JOIN pcprocitem ON pcprocitem.pc81_codprocitem = liclicitem.l21_codpcprocitem
                 INNER JOIN solicitem ON solicitem.pc11_codigo = pcprocitem.pc81_solicitem
                 INNER JOIN solicita ON solicita.pc10_numero = solicitem.pc11_numero
                 LEFT JOIN solicitaregistropreco ON solicitaregistropreco.pc54_solicita = solicita.pc10_numero
                 LEFT JOIN solicitemunid ON solicitemunid.pc17_codigo = solicitem.pc11_codigo
                 LEFT JOIN matunid ON matunid.m61_codmatunid = solicitemunid.pc17_unid
                 LEFT JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
                 LEFT JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater
                 LEFT JOIN pcorcamval ON pcorcamval.pc23_orcamitem = pcorcamitem.pc22_orcamitem
                 AND pcorcamval.pc23_orcamforne = pcorcamforne.pc21_orcamforne
                 LEFT JOIN pcorcamdescla ON pcorcamdescla.pc32_orcamitem = pcorcamitem.pc22_orcamitem
                 AND pcorcamdescla.pc32_orcamforne = pcorcamforne.pc21_orcamforne
                 LEFT JOIN liclicitemlote ON liclicitemlote.l04_liclicitem = liclicitem.l21_codigo
                 LEFT JOIN licsituacao ON liclicita.l20_licsituacao = licsituacao.l08_sequencial
                 LEFT JOIN pcproc ON pcproc.pc80_codproc = pcprocitem.pc81_codproc
                 LEFT JOIN pcorcamjulg ON pcorcamjulg.pc24_orcamitem = pcorcamitem.pc22_orcamitem
                 AND pcorcamforne.pc21_orcamforne = pcorcamjulg.pc24_orcamforne
                 LEFT JOIN acordo ON ac16_licitacao=l20_codigo
                 LEFT JOIN homologacaoadjudica ON l202_licitacao=l20_codigo
                 WHERE pc24_pontuacao= 1
                     AND l202_datahomologacao IS NOT NULL
                     $sWhere
                     AND l20_instit = ". db_getsession("DB_instit") . ") AS x
                group by x.codigo,x.descricao
                $sOrder";
    $result = db_query($sql);

    $pdf->cell(14, $alt, "Código", 1, 0, "C",1);
    $pdf->cell(235, $alt, "Descrição", 1, 0, "C",1);
    $pdf->cell(15, $alt, "Qtd.", 1, 1, "C",1);

    for($i = 0; $i < pg_num_rows($result); $i++){

        db_fieldsmemory($result,$i);

        $pdf->setfont('arial', '', 7);
        $linhas = ceil(strlen($descricao));
        $addalt = $linhas * 4;
        $old_y = $pdf->gety();

        $pdf->cell(14, $alt + $addalt, substr($codigo,0,164), 1, 0, "C",0);
        $pdf->multicell(235, $alt, mb_strtoupper($descricao), "T", "J", 0);
        $pdf->sety($old_y);
        $pdf->setx(259);
        $pdf->cell(15, $alt + $addalt, $quantidade, 1, 1, "C",0);
    }
}
//exit;
if($impforne == false && $impproc == false && $impaco == "true" && $impvlrunit == false){

    $sql = "SELECT DISTINCT pc01_codmater AS codigo,
                CASE
                    WHEN pc01_descrmater = NULL
                         OR pc01_descrmater = pc01_complmater THEN pc01_descrmater
                    ELSE pc01_descrmater||'. '||pc01_complmater
                END AS descricao,
                pc11_quant AS quantidade,
                pc23_vlrun AS valorUnitario,
                pc21_numcgm AS Fornecedor,
                l20_codigo AS Licitacao,
                CASE
                    WHEN pc11_reservado ='t' THEN 'Cota exclusiva'
                    ELSE 'Normal'
                END AS tipoitem,
                l20_edital||' / '||l20_anousu AS processo,
                ac16_sequencial AS Contrato,
                l202_datahomologacao,
                z01_nome
        FROM pcorcamitem
        INNER JOIN pcorcam ON pcorcam.pc20_codorc = pcorcamitem.pc22_codorc
        LEFT JOIN pcorcamforne ON pcorcamforne.pc21_codorc = pcorcam.pc20_codorc
        LEFT JOIN cgm ON cgm.z01_numcgm = pcorcamforne.pc21_numcgm
        INNER JOIN pcorcamitemlic ON pcorcamitemlic.pc26_orcamitem = pcorcamitem.pc22_orcamitem
        INNER JOIN liclicitem ON pcorcamitemlic.pc26_liclicitem = liclicitem.l21_codigo
        INNER JOIN liclicita ON liclicita.l20_codigo = liclicitem.l21_codliclicita
        INNER JOIN pcprocitem ON pcprocitem.pc81_codprocitem = liclicitem.l21_codpcprocitem
        INNER JOIN solicitem ON solicitem.pc11_codigo = pcprocitem.pc81_solicitem
        INNER JOIN solicita ON solicita.pc10_numero = solicitem.pc11_numero
        LEFT JOIN solicitaregistropreco ON solicitaregistropreco.pc54_solicita = solicita.pc10_numero
        LEFT JOIN solicitemunid ON solicitemunid.pc17_codigo = solicitem.pc11_codigo
        LEFT JOIN matunid ON matunid.m61_codmatunid = solicitemunid.pc17_unid
        LEFT JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
        LEFT JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater
        LEFT JOIN pcorcamval ON pcorcamval.pc23_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamval.pc23_orcamforne = pcorcamforne.pc21_orcamforne
        LEFT JOIN pcorcamdescla ON pcorcamdescla.pc32_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamdescla.pc32_orcamforne = pcorcamforne.pc21_orcamforne
        LEFT JOIN liclicitemlote ON liclicitemlote.l04_liclicitem = liclicitem.l21_codigo
        LEFT JOIN licsituacao ON liclicita.l20_licsituacao = licsituacao.l08_sequencial
        LEFT JOIN pcproc ON pcproc.pc80_codproc = pcprocitem.pc81_codproc
        LEFT JOIN pcorcamjulg ON pcorcamjulg.pc24_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamforne.pc21_orcamforne = pcorcamjulg.pc24_orcamforne
        LEFT JOIN acordo ON ac16_licitacao=l20_codigo
        left join homologacaoadjudica on l202_licitacao=l20_codigo
        WHERE pc24_pontuacao= 1
        and l202_datahomologacao is not null
        $sWhere
        AND l20_instit = ". db_getsession("DB_instit") . "
        $sOrder
        ";

    $result = db_query($sql);

    $pdf->cell(14, $alt, "Código", 1, 0, "C",1);
    $pdf->cell(215, $alt, "Descrição", 1, 0, "C",1);
    $pdf->cell(15, $alt, "Qtd.", 1, 0, "C",1);
    $pdf->cell(30, $alt, "Contrato", 1, 1, "C",1);

    for($i = 0; $i < pg_num_rows($result); $i++){

        db_fieldsmemory($result,$i);

        $pdf->setfont('arial', '', 8);
        $pdf->cell(14, $alt, substr($codigo,0,164), 1, 0, "C",0);
        $pdf->cell(215, $alt, $descricao, 1, 0, "L",0);
        $pdf->cell(15, $alt, $quantidade, 1, 0, "C",0);
        $pdf->cell(30, $alt, $contrato, 1, 1, "C",0);

    }
}

if($impforne == false && $impproc == "true" && $impaco == false && $impvlrunit == false){

    $sql = "SELECT DISTINCT pc01_codmater AS codigo,
                CASE
                    WHEN pc01_descrmater = NULL
                         OR pc01_descrmater = pc01_complmater THEN pc01_descrmater
                    ELSE pc01_descrmater||'. '||pc01_complmater
                END AS descricao,
                pc11_quant AS quantidade,
                pc23_vlrun AS valorUnitario,
                pc21_numcgm AS Fornecedor,
                l20_codigo AS Licitacao,
                CASE
                    WHEN pc11_reservado ='t' THEN 'Cota exclusiva'
                    ELSE 'Normal'
                END AS tipoitem,
                l20_edital||' / '||l20_anousu AS processo,
                l202_datahomologacao,
                z01_nome
        FROM pcorcamitem
        INNER JOIN pcorcam ON pcorcam.pc20_codorc = pcorcamitem.pc22_codorc
        LEFT JOIN pcorcamforne ON pcorcamforne.pc21_codorc = pcorcam.pc20_codorc
        LEFT JOIN cgm ON cgm.z01_numcgm = pcorcamforne.pc21_numcgm
        INNER JOIN pcorcamitemlic ON pcorcamitemlic.pc26_orcamitem = pcorcamitem.pc22_orcamitem
        INNER JOIN liclicitem ON pcorcamitemlic.pc26_liclicitem = liclicitem.l21_codigo
        INNER JOIN liclicita ON liclicita.l20_codigo = liclicitem.l21_codliclicita
        INNER JOIN pcprocitem ON pcprocitem.pc81_codprocitem = liclicitem.l21_codpcprocitem
        INNER JOIN solicitem ON solicitem.pc11_codigo = pcprocitem.pc81_solicitem
        INNER JOIN solicita ON solicita.pc10_numero = solicitem.pc11_numero
        LEFT JOIN solicitaregistropreco ON solicitaregistropreco.pc54_solicita = solicita.pc10_numero
        LEFT JOIN solicitemunid ON solicitemunid.pc17_codigo = solicitem.pc11_codigo
        LEFT JOIN matunid ON matunid.m61_codmatunid = solicitemunid.pc17_unid
        LEFT JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
        LEFT JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater
        LEFT JOIN pcorcamval ON pcorcamval.pc23_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamval.pc23_orcamforne = pcorcamforne.pc21_orcamforne
        LEFT JOIN pcorcamdescla ON pcorcamdescla.pc32_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamdescla.pc32_orcamforne = pcorcamforne.pc21_orcamforne
        LEFT JOIN liclicitemlote ON liclicitemlote.l04_liclicitem = liclicitem.l21_codigo
        LEFT JOIN licsituacao ON liclicita.l20_licsituacao = licsituacao.l08_sequencial
        LEFT JOIN pcproc ON pcproc.pc80_codproc = pcprocitem.pc81_codproc
        LEFT JOIN pcorcamjulg ON pcorcamjulg.pc24_orcamitem = pcorcamitem.pc22_orcamitem
        AND pcorcamforne.pc21_orcamforne = pcorcamjulg.pc24_orcamforne
        LEFT JOIN acordo ON ac16_licitacao=l20_codigo
        left join homologacaoadjudica on l202_licitacao=l20_codigo
        WHERE pc24_pontuacao= 1
        and l202_datahomologacao is not null
        $sWhere
        AND l20_instit = ". db_getsession("DB_instit") . "
        $sOrder
        ";

    $result = db_query($sql);

    $pdf->cell(14, $alt, "Código", 1, 0, "C",1);
    $pdf->cell(215, $alt, "Descrição", 1, 0, "C",1);
    $pdf->cell(15, $alt, "Qtd.", 1, 0, "C",1);
    $pdf->cell(30, $alt, "Licitação", 1, 1, "C",1);

    for($i = 0; $i < pg_num_rows($result); $i++){

        db_fieldsmemory($result,$i);

        $pdf->setfont('arial', '', 8);
        $pdf->cell(14, $alt, substr($codigo,0,164), 1, 0, "C",0);
        $pdf->cell(215, $alt, $descricao, 1, 0, "L",0);
        $pdf->cell(15, $alt, $quantidade, 1, 0, "C",0);
        $pdf->cell(30, $alt, $licitacao, 1, 1, "C",0);
    }
}

$pdf->Output();
