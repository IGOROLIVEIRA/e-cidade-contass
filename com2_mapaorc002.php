<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
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

require_once ("fpdf151/pdf.php");
require_once ("libs/db_sql.php");
require_once ("libs/db_utils.php");
require_once ("classes/db_pcorcam_classe.php");
require_once ("classes/db_pcorcamforne_classe.php");
require_once ("classes/db_pcorcamitem_classe.php");
require_once ("classes/db_pcorcamval_classe.php");
require_once ("classes/db_liclicita_classe.php");
require_once ("classes/db_pcorcamdescla_classe.php");
require_once ("classes/db_pcorcamtroca_classe.php");
require_once ("classes/db_liclicitemanu_classe.php");


require_once ("integracao_externa/ged/GerenciadorEletronicoDocumento.model.php");
require_once ("integracao_externa/ged/GerenciadorEletronicoDocumentoConfiguracao.model.php");
require_once ("libs/exceptions/BusinessException.php");

$oGet = db_utils::postMemory($_GET);


$oConfiguracaoGed = GerenciadorEletronicoDocumentoConfiguracao::getInstance();
if ($oConfiguracaoGed->utilizaGED()) {

    if (empty($oGet->pc20_codorc)) {

        $sMsgErro  = "O parâmetro para utilização do GED (Gerenciador Eletrônico de Documentos) está ativado.<br><br>";
        $sMsgErro .= "Neste não é possível informar interválos de códigos ou datas.<br><br>";
        db_redireciona("db_erros.php?fechar=true&db_erro={$sMsgErro}");
        exit;
    }
}


$imp_vlrun = "S";
$imp_vlrtotal = "S";

$clpcorcam = new cl_pcorcam();
$clpcorcamforne = new cl_pcorcamforne();
$clpcorcamitem = new cl_pcorcamitem();
$clpcorcamval = new cl_pcorcamval();
$clliclicita = new cl_liclicita();
$clpcorcamdescla = new cl_pcorcamdescla();
$clpcorcamtroca = new cl_pcorcamtroca();
$clliclicitemanu = new cl_liclicitemanu();

$clrotulo = new rotulocampo();
$clrotulo->label('');

parse_str($HTTP_SERVER_VARS ['QUERY_STRING']);
//echo $HTTP_SERVER_VARS['QUERY_STRING'];

$sOrigem = "";

if (isset($tipoOrcamento) && !empty($tipoOrcamento)) {
    $sOrigem = $oGet->tipoOrcamento;
}

$sInner = "";

if ($sOrigem == "solicitacao") {
    $sSqlMater = $clpcorcamitem->sql_query_pcmatersol(null, "pc11_codigo, pc11_numero, pc11_seq, pc22_codorc, 1 as l20_tipojulg", null, "pc20_codorc=$pc20_codorc");
    $sInner = "inner join pcorcamitemsol          on pcorcamitemsol.pc29_orcamitem  = pcorcamtroca.pc25_orcamitem
             inner join solicitem               on solicitem.pc11_codigo          = pcorcamitemsol.pc29_solicitem";

} else if ($sOrigem == "processo") {
    $sSqlMater = $clpcorcamitem->sql_query_pcmaterproc(null, "pc81_codproc, pc11_seq,pc22_codorc, 1 as l20_tipojulg", null, "pc20_codorc=$pc20_codorc");
    $sInner = "inner join pcorcamitemproc          on pcorcamitemproc.pc31_orcamitem  = pcorcamtroca.pc25_orcamitem
             inner join pcprocitem               on pcprocitem.pc81_codprocitem     = pcorcamitemproc.pc31_pcprocitem
             inner join solicitem                on solicitem.pc11_codigo           = pcprocitem.pc81_solicitem";

}

$result_info = $clpcorcamitem->sql_record($sSqlMater);
if ($clpcorcamitem->numrows > 0) {
    db_fieldsmemory($result_info, 0);
}

if (isset($imp_troca) && $imp_troca == "S") {

    if ($sOrigem == "solicitacao") {
        $sWhere = "  pc11_numero =  $pc11_numero  ";
    }

    if ($sOrigem == "processo") {
        $sWhere = "  pc81_codproc =  $pc81_codproc  ";
    }

    $sql_troca = "select pc01_codmater, pc01_descrmater, pc25_motivo, nome_julgado, nome_trocado
                from (select distinct on(pc25_orcamitem) pc25_orcamitem, pc25_codtroca, pc01_codmater, pc01_descrmater,
                                                         pc25_motivo, cgm.z01_nome as nome_julgado,
                                                         cgm_ant.z01_nome as nome_trocado
                      from pcorcamtroca
                           inner join pcorcamjulg              on pcorcamjulg.pc24_orcamitem      = pcorcamtroca.pc25_orcamitem
                           inner join pcorcamforne             on pcorcamforne.pc21_orcamforne    = pcorcamjulg.pc24_orcamforne
                           inner join cgm                      on cgm.z01_numcgm                  = pcorcamforne.pc21_numcgm
                           $sInner
                           inner join solicitempcmater         on solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
                           inner join pcmater                  on pcmater.pc01_codmater           = solicitempcmater.pc16_codmater
                           left  join pcorcamforne as forneant on forneant.pc21_orcamforne        = pcorcamtroca.pc25_forneant
                           left  join cgm as cgm_ant           on cgm_ant.z01_numcgm              = forneant.pc21_numcgm
                           left  join pcorcamval               on pcorcamval.pc23_orcamitem       = pcorcamjulg.pc24_orcamitem
                           left  join pcorcamdescla            on pcorcamdescla.pc32_orcamitem    = pcorcamval.pc23_orcamitem and
                                                                  pcorcamdescla.pc32_orcamforne   = pcorcamval.pc23_orcamforne
                      where $sWhere and
                            pc24_pontuacao   = 1              and
                            pc32_orcamitem  is null           and
                            pc32_orcamforne is null
                      order by pc25_orcamitem desc, pc25_codtroca desc) as x
                order by pc01_descrmater";

    //echo $sql_troca; exit;
    $res_troca = $clpcorcamtroca->sql_record($sql_troca);
}

$rsOrcamento = db_query($sSqlMater);
db_fieldsmemory($rsOrcamento, 0);

$head3 = "Orçamento: " . @$pc22_codorc;

if ($sOrigem == "solicitacao") {
    $head5 = "Solicitação: $pc11_numero";
} else if ($sOrigem == "processo") {
    $head5 = "Processo de Compra: $pc81_codproc";
}

$orcamento = @$pc22_codorc;

if ($modelo == 1) {

    //-----------------------------  MODELO 1  -----------------------------------------------------------------------------------------------------------------//
    //-----------------------------  MODELO 1  -----------------------------------------------------------------------------------------------------------------//
    //-----------------------------  MODELO 1  -----------------------------------------------------------------------------------------------------------------//


    $sSqlFornecedores = $clpcorcamforne->sql_query(null, "*", null, "pc21_codorc=$orcamento");
    $result_forne = $clpcorcamforne->sql_record($sSqlFornecedores);
    $numrows_forne = $clpcorcamforne->numrows;
    if ($numrows_forne == 0) {
        db_redireciona('db_erros.php?fechar=true&db_erro=Não existem Fornecedores cadastrados.');
    }
    $pdf = new PDF();
    $pdf->Open();
    $pdf->AliasNbPages();
    $total = 0;
    $pdf->setfillcolor(235);
    $pdf->setfont('arial', 'b', 8);
    $troca = 1;
    $alt = 4;
    $total = 0;
    $p = 0;

    if ($sOrigem == "solicitacao") {
        $sSqlMater = $clpcorcamitem->sql_query_pcmatersol(null,
            "distinct pc11_seq,pc22_orcamitem,pc01_descrmater,pc11_resum,pc80_criterioadjudicacao",
            "pc11_seq", "pc22_codorc=$orcamento");
    } else if ($sOrigem == "processo") {
        $sSqlMater = $clpcorcamitem->sql_query_pcmaterproc(null,
            "distinct pc11_seq,pc22_orcamitem,pc01_descrmater,pc11_resum,pc80_criterioadjudicacao",
            "pc11_seq", "pc22_codorc=$orcamento");
    }

    $result_itens = $clpcorcamitem->sql_record($sSqlMater);
    $numrows_itens = $clpcorcamitem->numrows;

    $pdf->addpage('L');
    $total_media = 0;
    $total_mediapercentual = 0;
    $condCriterioadj = "";
    for($x = 0; $x < $numrows_itens; $x ++) {

        $condCriterioadj = (empty($pc80_criterioadjudicacao) || $pc80_criterioadjudicacao == 3) ? " and pc23_valor > 0 " : "";
        $troca = 1;
        db_fieldsmemory($result_itens, $x);
        if ($pdf->gety() > $pdf->h - 60 || $troca != 0) {
            if ($pdf->gety() > $pdf->h - 60) {
                $pdf->addpage('L');
            }
            $pdf->setfont('arial', 'b', 9);
            $pdf->cell(15, $alt, "Item", 1, 0, "C", 1);
            $pdf->cell(159, $alt, "Material", 1, 0, "C", 1);
            $pdf->cell(65, $alt, "Obs/Marca", 1, 0, "C", 1);
            $pdf->cell(20, $alt, "Vl. Unitário", 1, 0, "C", 1);
            $pdf->cell(20, $alt, "Quantidade", 1, 1, "C", 1);
            $p = 0;
            $troca = 0;
        }
        $sSql = $clpcorcamval->sql_query_julg(null, null, "min(pc23_vlrun) as menor_valor", null,
            "pc23_orcamitem=$pc22_orcamitem and pc23_vlrun > 0");
        $sSqlJulg = $clpcorcamval->sql_query_julg(null, null, "($sSql) as vlrunit, pc23_quant as quant, pc24_pontuacao, pc23_obs", null,
            "pc23_orcamitem=$pc22_orcamitem {$condCriterioadj}");
        $result_valor_item = $clpcorcamval->sql_record($sSqlJulg);
        db_fieldsmemory($result_valor_item);
        $pdf->setfont('arial', '', 8);
        $pdf->cell(15, $alt, $pc11_seq, 1, 0, "C", 0);
        $pdf->cell(159, $alt,substr($pc01_descrmater,0,190), 1, 0, "L", 0);
        $pdf->cell(65, $alt,substr($pc23_obs,0,30), 1, 0, "L", 0);
        $pdf->cell(20, $alt, number_format($vlrunit,4,',','.'), 1, 0, "R", 0);
        $pdf->cell(20, $alt, $quant, 1, 1, "R", 0);
        $pdf->cell(279,$alt/2,'','',1,"L",0);

        $troca = 1;
        $total_unit = 0;
        $total_percentualdesconto = 0;
        $total_percentualdescontotaxa = 0;
        $iContOrcamento = 0;
        for($y = 0; $y < $numrows_forne; $y ++) {
            db_fieldsmemory($result_forne, $y);
            if ($pdf->gety() > $pdf->h - 30 || $troca != 0) {
                if ($pdf->gety() > $pdf->h - 30 ) {
                    $pdf->addpage('L');
                }
                if($pc80_criterioadjudicacao == 2 || $pc80_criterioadjudicacao == 1){ //OC8365
                    $p = 0;
                    $pdf->setfont('arial', 'b', 8);
                    $pdf->cell(15, $alt, "Cgm", 1, 0, "C", 1);
                    $pdf->cell(200, $alt, "Fornecedor", 1, 0, "C", 1);
                    $pdf->cell(24, $alt, "Taxa/Tabela", 1, 0, "C", 1);//OC3770
                    $pdf->cell(20, $alt, "Vl. Unitário", 1, 0, "C", 1);
                    $pdf->cell(20, $alt, "Vl. Total", 1, 1, "C", 1);
                    $troca = 0;
                }else{
                    $p = 0;
                    $pdf->setfont('arial', 'b', 8);
                    $pdf->cell(15, $alt, "Cgm", 1, 0, "C", 1);
                    $pdf->cell(224, $alt, "Fornecedor", 1, 0, "C", 1);
                    $pdf->cell(20, $alt, "Vl. Unitário", 1, 0, "C", 1);
                    $pdf->cell(20, $alt, "Vl. Total", 1, 1, "C", 1);
                    $troca = 0;
                }
            }

            $sSqlJulg = $clpcorcamval->sql_query_julg(null, null, "pc23_vlrun as pc23_vlrun,pc23_quant,pc23_valor,pc23_perctaxadesctabela,pc23_percentualdesconto,pc24_pontuacao", null,
                "pc23_orcamforne=$pc21_orcamforne and pc23_orcamitem=$pc22_orcamitem {$condCriterioadj} and pc23_vlrun <> 0");
            $result_valor = $clpcorcamval->sql_record($sSqlJulg);

            if(pg_num_rows($result_valor) == 0){
                continue;
            }
            db_fieldsmemory($result_valor);
            $pdf->setfont('arial', '', 7);
            if($pc80_criterioadjudicacao == 2 || $pc80_criterioadjudicacao == 1){ //OC8365
                $pdf->cell(15, $alt, $z01_numcgm, 1, 0, "C", 0);
                $pdf->cell(200, $alt, $z01_nome, 1, 0, "L", 0);
                /*OC3770*/
                if ($pc23_perctaxadesctabela != 0) {
                    $pdf->cell(24, $alt, $pc23_perctaxadesctabela . "%", 1, 0, "R", 0);
                    $pdf->cell(20, $alt, "", 1, 0, "R", 0);
                } else if ($pc23_percentualdesconto != 0) {
                    $pdf->cell(24, $alt, $pc23_percentualdesconto . "%", 1, 0, "R", 0);
                    $pdf->cell(20, $alt, "", 1, 0, "R", 0);
                } else {
                    $pdf->cell(24, $alt, "", 1, 0, "R", 0);
                    $pdf->cell(20, $alt, number_format($pc23_vlrun, 4, ',', '.'), 1, 0, "R", 0);
                }
                /*FIM - OC3770*/
            }else{
                $pdf->cell(15, $alt, $z01_numcgm, 1, 0, "C", 0);
                $pdf->cell(224, $alt, $z01_nome, 1, 0, "L", 0);
                $pdf->cell(20, $alt, number_format($pc23_vlrun, 4, ',', '.'), 1, 0, "R", 0);
            }

            $pdf->cell(20, $alt, number_format($pc23_valor,2,',','.'), 1, 1, "R", 0);
            $total_unit  += $pc23_vlrun;
            $total_percentualdesconto += $pc23_percentualdesconto;
            $total_percentualdescontotaxa += $pc23_perctaxadesctabela;

            if($pc23_vlrun != 0)
                $iContOrcamento++;
        }

        $pdf->setfont('arial', '', 7);
        $pdf->cell(20, $alt, "", 0, 0, "L", 0);
        if($pc80_criterioadjudicacao == 2 || $pc80_criterioadjudicacao == 1) { //OC8365
            $pdf->cell(199, $alt, "Média", 0, 0, "L", 0);

            if ($pc23_percentualdesconto != 0) {
                $pdf->cell(20, $alt, ($total_percentualdesconto/$iContOrcamento)."%", 0, 0, "R", 0);
            }else if ($pc23_perctaxadesctabela != 0){
                $pdf->cell(20, $alt,number_format(($total_percentualdescontotaxa/$iContOrcamento),2,',','.')."%", 0, 0, "R", 0);
            }else{
                $pdf->cell(20, $alt,"", 0, 0, "R", 0);
            }

            /*OC3770*/
            if ($pc23_perctaxadesctabela != 0 || $pc23_percentualdesconto != 0) {
                $pdf->cell(20, $alt, "", 0, 0, "R", 0);
            } else {
                $pdf->cell(20, $alt, number_format($total_unit / $iContOrcamento, 4, ',', '.'), 0, 0, "R", 0);
            }
            /*FIM - OC3770*/

//            if ($quant_casas == 2) {
//                $pdf->cell(20, $alt, number_format(round(($total_unit / $iContOrcamento), 2) * $quant, $oGet->quant_casas, ',', '.'), 0, 1, "R", 0);
//            } else {
                $pdf->cell(20, $alt, number_format(round(($total_unit / $iContOrcamento), 2) * $quant, 2, ',', '.'), 0, 1, "R", 0);
//            }

            $pdf->cell(279, $alt, '', '', 1, "L", 0);
//            if ($quant_casas == 2) {
                $total_media += round(($total_unit / $iContOrcamento), 2) * $quant;
                $total_mediapercentual += ($total_percentualdesconto/$iContOrcamento);
                $total_mediapercentualtaxa += ($total_percentualdescontotaxa/$iContOrcamento);
//            } else {
//                $total_media += round($total_unit / $iContOrcamento, 3) * $quant;
//                $total_mediapercentual += ($total_percentualdesconto/$iContOrcamento);
//                $total_mediapercentualtaxa += ($total_percentualdescontotaxa/$iContOrcamento);
//            }
        }else{
            $pdf->cell(219, $alt, "Média", 0, 0, "L", 0);

            /*OC3770*/
            if ($pc23_perctaxadesctabela != 0 || $pc23_percentualdesconto != 0) {
                $pdf->cell(20, $alt, "", 0, 0, "R", 0);
            } else {
                $pdf->cell(20, $alt, number_format($total_unit / $iContOrcamento, 4, ',', '.'), 0, 0, "R", 0);
            }
            /*FIM - OC3770*/

            //if ($quant_casas == 2) {
                $pdf->cell(20, $alt, number_format(round(($total_unit / $iContOrcamento), 2) * $quant, 2, ',', '.'), 0, 1, "R", 0);
//            } else {
//                $pdf->cell(20, $alt, number_format(round(($total_unit / $iContOrcamento), 3) * $quant, $oGet->quant_casas, ',', '.'), 0, 1, "R", 0);
//            }

            $pdf->cell(279, $alt, '', '', 1, "L", 0);
//            if ($quant_casas == 2) {
//                $total_media += round(($total_unit / $iContOrcamento), 2) * $quant;
//            } else {
                $total_media += round($total_unit / $iContOrcamento, 2) * $quant;
//            }
        }
    }

    $troca = 1;
    for($y = 0; $y < $numrows_forne; $y ++) {
        db_fieldsmemory($result_forne, $y);
        if ($pdf->gety() > $pdf->h - 30 || $troca != 0) {
            if ($pdf->gety() > $pdf->h - 30 ) {
                $pdf->addpage('L');
            }
            $p = 0;
            $pdf->setfont('arial', 'b', 8);
            $pdf->cell(279,$alt,'TOTAL',1,1,"C",1);
            $pdf->cell(15, $alt, "Cgm", 1, 0, "C", 1);
            $pdf->cell(224, $alt, "Fornecedor", 1, 0, "C", 1);
            $pdf->cell(40, $alt, "Valor", 1, 1, "C", 1);
            $troca = 0;
        }

        $sSqlJulg = $clpcorcamval->sql_query_julg(null, null, "sum(pc23_valor) as vltotal", null,
            "pc23_orcamforne=$pc21_orcamforne");
        $result_valor = $clpcorcamval->sql_record($sSqlJulg);
        db_fieldsmemory($result_valor);
        if($vltotal > 0) {
            $pdf->setfont('arial', '', 7);
            $pdf->cell(15, $alt, $z01_numcgm, 1, 0, "C", 0);
            $pdf->cell(224, $alt, $z01_nome, 1, 0, "L", 0);
            $pdf->cell(40, $alt, number_format($vltotal, 2,',','.'), 1, 1, "R", 0);
        }

    }
    $pdf->setfont('arial', '', 9);
    $pdf->cell(279,$alt,'','',1,"L",0);
    $pdf->cell(15, $alt, "Total da Média", 0, 0, "C", 0);
    if($pc80_criterioadjudicacao == 2 || $pc80_criterioadjudicacao == 1) {
        if($pc80_criterioadjudicacao == 1){
            $pdf->cell(224, $alt, $total_mediapercentualtaxa . "%", 0, 0, "R", 0);
            $pdf->cell(40, $alt, number_format($total_media, 2,',','.'), 0, 1, "R", 0);
        }else if($pc80_criterioadjudicacao == 2){
            $pdf->cell(224, $alt, $total_mediapercentual . "%", 0, 0, "R", 0);
            $pdf->cell(40, $alt, number_format($total_media, 2,',','.'), 0, 1, "R", 0);
        }else{
            $pdf->cell(40, $alt, number_format($total_media, 2,',','.'), 0, 1, "R", 0);
        }
    }else{
        $pdf->cell(264, $alt, number_format($total_media, 2,',','.'), 0, 1, "R", 0);
    }

} else if ($modelo == 2) {

    //-----------------------------  MODELO 2  -----------------------------------------------------------------------------------------------------------------//
    //-----------------------------  MODELO 2  -----------------------------------------------------------------------------------------------------------------//
    //-----------------------------  MODELO 2  -----------------------------------------------------------------------------------------------------------------//


    if ($sOrigem == "solicitacao") {
        $sSqlItens = $clpcorcamitem->sql_query_pcmatersol(null, "distinct pc22_orcamitem,
                                                             pc01_descrmater,
                                                             pc11_resum,
                                                             pc11_quant,
                                                             m61_descr,
                                                             (select coalesce(sum(val.pc23_valor),0)/case when count(val.*) > 0 then count(val.*) else 1 end
                                                                from pcorcamval val
                                                               where val.pc23_orcamitem = pc22_orcamitem) as valor_medio,
                                                             pc11_seq", "pc11_seq", "pc22_codorc=$orcamento");
    } else if ($sOrigem == "processo") {
        $sSqlItens = "SELECT DISTINCT pc22_orcamitem,
                pc01_descrmater,
                pc11_resum,
                pc11_quant,
                m61_descr,

    (SELECT coalesce(sum(val.pc23_valor),0)/CASE
                                                WHEN count(val.*) > 0 THEN count(val.*)
                                                ELSE 1
                                            END
     FROM pcorcamval val
     WHERE val.pc23_orcamitem = pc22_orcamitem) AS valor_medio,
                pc11_seq,
                /*CASE
                    WHEN pc23_percentualdesconto = 0 THEN NULL
                    ELSE pc23_percentualdesconto
                END AS pc23_percentualdesconto,*/
                pc80_criterioadjudicacao
FROM pcorcamitem
INNER JOIN pcorcam ON pcorcam.pc20_codorc = pcorcamitem.pc22_codorc
INNER JOIN pcorcamitemproc ON pcorcamitemproc.pc31_orcamitem = pcorcamitem.pc22_orcamitem
INNER JOIN pcprocitem ON pcprocitem.pc81_codprocitem = pcorcamitemproc.pc31_pcprocitem
INNER JOIN pcorcamforne ON pc21_codorc = pc20_codorc
/*INNER JOIN pcorcamval pc2 on (pc2.pc23_orcamitem,pc2.pc23_orcamforne) = (pcorcamitem.pc22_orcamitem,pcorcamforne.pc21_orcamforne)*/
INNER JOIN pcproc ON pcprocitem.pc81_codproc = pcproc.pc80_codproc
INNER JOIN solicitem ON solicitem.pc11_codigo = pcprocitem.pc81_solicitem
LEFT JOIN solicitempcmater ON solicitempcmater.pc16_solicitem = solicitem.pc11_codigo
LEFT JOIN pcmater ON pcmater.pc01_codmater = solicitempcmater.pc16_codmater
LEFT JOIN processocompraloteitem ON pc69_pcprocitem = pcprocitem.pc81_codprocitem
LEFT JOIN processocompralote ON pc68_sequencial = pc69_processocompralote
LEFT JOIN solicitemunid ON solicitemunid.pc17_codigo = solicitem.pc11_codigo
LEFT JOIN matunid ON matunid.m61_codmatunid = solicitemunid.pc17_unid
WHERE pc22_codorc= $orcamento
ORDER BY pc11_seq";
    }
    $result_itens = $clpcorcamitem->sql_record($sSqlItens);
//    echo $sSqlItens; db_criatabela($result_itens);exit;

    $numrows_itens = $clpcorcamitem->numrows;
    if ($numrows_itens == 0) {
        db_redireciona('db_erros.php?fechar=true&db_erro=Não existem itens cadastrados.');
    }
    $pdf = new PDF();
    $pdf->Open();
    $pdf->AliasNbPages();
    $total = 0;
    $pdf->setfillcolor(235);
    $pdf->setdrawcolor(0);
    $pdf->setfont('arial', 'b', 9);
    $troca = 1;
    $alt = 6;
    $total = 0;
    $p = 0;
    $max_forne = 0;
    $max = false;
    $quant_imp = 0;
    $valor_total = 0;

    $arr_subtotganhoun = array ();
    $arr_subtotcotadoun = array ();

    $arr_subtotganhovlr = array ();
    $arr_subtotcotadovlr = array ();

    $arr_totalganho = array ();
    $arr_totalcotado = array ();

    $result_forne = $clpcorcamforne->sql_record($clpcorcamforne->sql_query(null, "*", null, "pc21_codorc=$orcamento"));
    $numrows_forne = $clpcorcamforne->numrows;

    for($i = 0; $i < $numrows_forne; $i ++) {
        db_fieldsmemory($result_forne, $i);

        $arr_subtotganhoun [$i] = 0;
        $arr_subtotcotadoun [$i] = 0;

        $arr_subtotganhovlr [$i] = 0;
        $arr_subtotcotadovlr [$i] = 0;

        $arr_totalganho [$pc21_orcamforne] = 0;
        $arr_totalcotado [$pc21_orcamforne] = 0;
    }

    $total_quant = 0;
    for($i = 0; $i < $numrows_itens; $i ++) {
        db_fieldsmemory($result_itens, $i);

        $total_quant += $pc11_quant;
    }

    for($x = 0; $x < $numrows_itens; $x ++) {
        db_fieldsmemory($result_itens, $x);
        if ($pdf->gety() > $pdf->h - 30 || $troca != 0) {
            if ($pdf->gety() > $pdf->h - 30 || $max == false) {
                $pdf->addpage('L');
            }
            $p = 0;

            $alt = 6;
            $pdf->setfont('arial', 'b', 9);
            $pdf->cell(7, $alt, "Seq", 1, 0, "C", 1);
            $pdf->cell(60, $alt, "Descr. Produto", 1, 0, "C", 1);
            $pdf->cell(15, $alt, "Unidade", 1, 0, "C", 1);
            $pdf->cell(15, $alt, "Vlr. Med.", 1, 0, "C", 1);
            $pdf->cell(13, $alt, "Quant.", 1, 0, "C", 1);

            $sSqlFornecedores = $clpcorcamforne->sql_query(null, "*", null, "pc21_codorc=$orcamento");
            $result_forne = $clpcorcamforne->sql_record($sSqlFornecedores);

            $numrows_forne = $clpcorcamforne->numrows;
            if ($troca != 0) {
                if ($numrows_forne > $max_forne + 2) {
                    $max_forne = $max_forne + 2;
                    $max = true;
                } else {
                    $max = false;
                    $max_forne = $numrows_forne;
                }
            }
            $t = 0;
            for($w = $quant_imp; $w < $max_forne; $w ++) {
                db_fieldsmemory($result_forne, $w);
                if ($pdf->gety() > $pdf->h - 30) {
                    $t = 1;
                }

                if ($w == ($max_forne - 1)) {
                    $t = 1;
                }

                if ($imp_vlrun == "S") {
                    $pdf->cell(15, $alt, "Vlr. Un.", 1, 0, "C", 1);
                    if($pc80_criterioadjudicacao == 2 || $pc80_criterioadjudicacao == 1){
                        $pdf->cell(20, $alt, "Taxa/Tabela", 1, 0, "C", 1);
                    }

                }
                if($pc80_criterioadjudicacao == 2 || $pc80_criterioadjudicacao == 1) {
                    $pdf->cell(53, $alt, substr($z01_nome, 0, 25) . "(" . ($w + 1) . ")", 1, $t, "C", 1);
                }else{
                    $pdf->cell(70, $alt, substr($z01_nome, 0, 25) . "(" . ($w + 1) . ")", 1, $t, "C", 1);
                }
            }
            $troca = 0;
        }
        if($pc80_criterioadjudicacao == 2 || $pc80_criterioadjudicacao == 1){
            if(!$pc23_percentualdesconto == null || $pc23_percentualdesconto = ""){
                $pc23_percentualdesconto = $pc23_percentualdesconto."%";
            }
        }
        $alt = 4;
        $pdf->setfont('arial', '', 7);
        $pdf->cell(7, $alt, $pc11_seq, 1, 0, "C", 0);
        $pdf->cell(60, $alt, substr($pc01_descrmater . " - " . $pc11_resum, 0, 38), 1, 0, "L", 0);
        $pdf->cell(15, $alt, $m61_descr, 1, 0, "C", 0);
        $pdf->cell(15, $alt, number_format($valor_medio, 2,',','.'), 1, 0, "C", 0);
        $pdf->cell(13, $alt, $pc11_quant, 1, 0, "C", 0);

        $t = 0;
        $cont_quant = 0;
        for($w = $quant_imp; $w < $max_forne; $w ++) {
            db_fieldsmemory($result_forne, $w);
            $pdf->setfont('arial', '', 7);
            if ($w == ($max_forne - 1)) {
                $t = 1;
            }

            $sSqlJulg = $clpcorcamval->sql_query_julg(null, null,
                "pc23_valor,pc23_vlrun,pc24_pontuacao,CASE
                    WHEN pc23_percentualdesconto = 0 THEN NULL
                    ELSE pc23_percentualdesconto
                END AS pc23_percentualdesconto,
                CASE WHEN pc23_perctaxadesctabela = 0 THEN NULL 
                ELSE pc23_perctaxadesctabela END AS pc23_perctaxadesctabela", null,
                "pc23_orcamforne=$pc21_orcamforne and pc23_orcamitem=$pc22_orcamitem");

            $result_valor = $clpcorcamval->sql_record($sSqlJulg);
//            db_criatabela($result_valor);
            if ($clpcorcamval->numrows > 0) {
                db_fieldsmemory($result_valor, 0);
                if ($pc24_pontuacao == 1) {
                    $pdf->setfont('arial', 'b', 8);
                    $fundo = 1;
                    $arr_subtotganhoun [$w] += $pc23_vlrun;
                    $arr_subtotganhovlr [$w] += $pc23_valor;
                    $arr_totalganho [$pc21_orcamforne] += $pc23_valor;
                } else {
                    $fundo = 0;
                }

                $arr_subtotcotadoun [$w] += $pc23_vlrun;
                $arr_subtotcotadovlr [$w] += $pc23_valor;
                $arr_totalcotado [$pc21_orcamforne] += $pc23_valor;

                if ($imp_vlrun == "S") {
                    $pdf->cell(15, $alt, number_format(@$pc23_vlrun, 4,',','.'), 1, 0, "R", $fundo);
                    if($pc80_criterioadjudicacao == 2 ){
                        $pdf->cell(20, $alt, $pc23_percentualdesconto, 1, 0, "C", $fundo);
                    }else if ($pc80_criterioadjudicacao == 1){
                        $pdf->cell(20, $alt, $pc23_perctaxadesctabela  == null ? "" : $pc23_perctaxadesctabela."%", 1, 0, "C", $fundo);
                    }
                }
                if($pc80_criterioadjudicacao == 2 || $pc80_criterioadjudicacao == 1) {
                    $pdf->cell(53, $alt, number_format(@$pc23_valor, 2, ',', '.'), 1, $t, "R", $fundo);
                }else{
                    $pdf->cell(70, $alt, number_format(@$pc23_valor, 2, ',', '.'), 1, $t, "R", $fundo);
                }
                if ($imp_vlrtotal == "S") {
                    if (isset($arr_valor [$w]) && trim(@$arr_valor [$w]) != "") {
                        $arr_valor [$w] += @$pc23_valor;
                    }

                    $valor_total += $pc23_valor;
                }
            } else {
                if ($imp_vlrun == "S") {
                    $pdf->cell(15, $alt, "0,00", 1, 0, "R", 0);
                }
                if($pc80_criterioadjudicacao == 2 || $pc80_criterioadjudicacao == 1) {
                    $pdf->cell(53, $alt, "0,00", 1, $t, "R", 0);
                }else{
                    $pdf->cell(70, $alt, "0,00", 1, $t, "R", 0);
                }
            }

            $cont_quant ++;
        }

        if ($x == $numrows_itens - 1 && $max == true) {
            $quant_imp = $cont_quant + $quant_imp;
            $x = - 1;
            $troca = 1;
            $total = 0;

            $pdf->setfont('arial', 'b', 8);

            $pdf->cell(125, $alt, number_format($total_quant, 2,',','.'), 1, 0, "R", 0);
            if($pc80_criterioadjudicacao == 2 || $pc80_criterioadjudicacao == 1) {
                $pdf->cell(161, $alt, "", 1, 1, "R", 0);
            }else{
                $pdf->cell(121, $alt, "", 1, 1, "R", 0);
            }

            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            // Impressao de 2 em 2 fornecedores, separados por subtotal ganho e cotado, incluindo valores unitarios e total
            if ($w == 2) { // posicao 0 e 1 dos arrays de subtotais
                $ind = 0;
            } else {
                $ind = $w - 2; // posicoes 2 em diante dos arrays de subtotais, sempre de 2 em 2
            }

            for($xx = $ind; $xx < $w; $xx ++) {
                if (($xx % 2) == 0) {
                    if($pc80_criterioadjudicacao == 2 || $pc80_criterioadjudicacao == 1){
                        $tam = 125;
                        $msg = "SUBTOTAL GANHO ";
                    }else{
                        $tam = 125;
                        $msg = "SUBTOTAL GANHO ";
                    }
                } else {
                    $tam = 15;
                    $msg = "";
                }

                if (($xx + 1) >= $w) {
                    $br = 1;
                } else {
                    $br = 0;
                }

                $pdf->cell($tam, $alt, $msg . number_format($arr_subtotganhoun [$xx], 2,',','.'), 1, 0, "R", 0);
                if($pc80_criterioadjudicacao == 2 || $pc80_criterioadjudicacao == 1){
                    $pdf->cell(73, $alt, number_format($arr_subtotganhovlr [$xx], 2,',','.'), 1, $br, "R", 0);
                }else{
                    $pdf->cell(53, $alt, number_format($arr_subtotganhovlr [$xx], 2,',','.'), 1, $br, "R", 0);
                }
            }

            if ($w == 2) {
                $ind = 0;
            } else {
                $ind = $w - 2;
            }

            for($xx = $ind; $xx < $w; $xx ++) {
                if (($xx % 2) == 0) {
                    if($pc80_criterioadjudicacao == 2 || $pc80_criterioadjudicacao == 1) {
                        $tam = 125;
                        $msg = "SUBTOTAL COTADO ";
                    }else{
                        $tam = 125;
                        $msg = "SUBTOTAL COTADO ";
                    }
                } else {
                    $tam = 15;
                    $msg = "";
                }

                if (($xx + 1) >= $w) {
                    $br = 1;
                } else {
                    $br = 0;
                }

                $pdf->cell($tam, $alt, $msg . number_format($arr_subtotcotadoun [$xx], 2,',','.'), 1, 0, "R", 0);
                if($pc80_criterioadjudicacao == 2 || $pc80_criterioadjudicacao == 1){
                    $pdf->cell(73, $alt, number_format($arr_subtotcotadovlr [$xx], 2,',','.'), 1, $br, "R", 0);
                }else{
                    $pdf->cell(53, $alt, number_format($arr_subtotcotadovlr [$xx], 2,',','.'), 1, $br, "R", 0);
                }
            }
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            $pdf->ln();
        }

        if ($p == 0) {
            $p = 1;
        } else {
            $p = 0;
        }
        $total ++;
    }

    $pdf->setfont('arial', 'b', 8);

    // Ficou pendente valores a serem impressos
    if ($quant_imp < $max_forne) {

        if($pc80_criterioadjudicacao == 2 || $pc80_criterioadjudicacao == 1) {
            $pdf->cell(110, $alt, "QUANT. TOTAL " . number_format($total_quant, 2,',','.'), 1, 0, "R", 0);
            $pdf->cell(88, $alt, "", 1, 1, "R", 0);
            $pdf->cell(125, $alt, "SUBTOTAL GANHO " . number_format($arr_subtotganhoun [$quant_imp], 2, ',', '.'), 1, 0, "R", 0);
            $pdf->cell(73, $alt, number_format($arr_subtotganhovlr [$quant_imp], 2, ',', '.'), 1, 1, "R", 0);

            $pdf->cell(125, $alt, "SUBTOTAL COTADO " . number_format($arr_subtotcotadoun [$quant_imp], 2, ',', '.'), 1, 0, "R", 0);
            $pdf->cell(73, $alt, number_format($arr_subtotcotadovlr [$quant_imp], 2, ',', '.'), 1, 1, "R", 0);
        }else {
            $pdf->cell(110, $alt, "QUANT. TOTAL " . number_format($total_quant, 2,',','.'), 1, 0, "R", 0);
            $pdf->cell(85, $alt, "", 1, 1, "R", 0);
            $pdf->cell(125, $alt, "SUBTOTAL GANHO " . number_format($arr_subtotganhoun [$quant_imp], 2, ',', '.'), 1, 0, "R", 0);
            $pdf->cell(70, $alt, number_format($arr_subtotganhovlr [$quant_imp], 2, ',', '.'), 1, 1, "R", 0);

            $pdf->cell(125, $alt, "SUBTOTAL COTADO " . number_format($arr_subtotcotadoun [$quant_imp], 2, ',', '.'), 1, 0, "R", 0);
            $pdf->cell(70, $alt, number_format($arr_subtotcotadovlr [$quant_imp], 2, ',', '.'), 1, 1, "R", 0);
        }
        $pdf->ln();
    }

    if ($pdf->gety() > $pdf->h - 30) {
        $pdf->addpage("L");
    }

    $pdf->cell(45, $alt, "FORNECEDOR(ES)", 1, 0, "L", 1);
    $pdf->cell(30, $alt, "VALOR GANHO", 1, 0, "R", 1);
    $pdf->cell(30, $alt, "VALOR COTADO", 1, 1, "R", 1);

    $total_ganho = 0;
    $total_cotado = 0;

    $sSqlFornecedores = $clpcorcamforne->sql_query(null, "*", null, "pc21_codorc=$orcamento");
    $result_forne = $clpcorcamforne->sql_record($sSqlFornecedores);

    $numrows_forne = $clpcorcamforne->numrows;
    for($i = 0; $i < $numrows_forne; $i ++) {
        db_fieldsmemory($result_forne, $i);
        $cont = $i;
        $cont ++;

        $pdf->cell(45, $alt, $z01_numcgm." - ".substr($z01_nome, 0, 25) . " (" . $cont . ")", 0, 0, "L", $p);
        $pdf->cell(30, $alt, number_format($arr_totalganho [$pc21_orcamforne], 2,',','.'), 0, 0, "R", $p);
        $pdf->cell(30, $alt, number_format($arr_totalcotado [$pc21_orcamforne], 2,',','.'), 0, 1, "R", $p);

        if ($p == 0) {
            $p = 1;
        } else {
            $p = 0;
        }

        $total_ganho += $arr_totalganho [$pc21_orcamforne];
        $total_cotado += $arr_totalcotado [$pc21_orcamforne];
    }
    if ($numrows_forne > 0) {
        $pdf->cell(125, 1, "", "T", 1, "R", 0);
        $pdf->cell(95, $alt, "TOTAIS " . number_format($total_ganho, 2,',','.'), 0, 0, "R", 0);
        $pdf->cell(30, $alt, number_format($total_cotado, 2,',','.'), 0, 1, "R", 0);
    }

    $pdf->ln();

    if ($imp_vlrtotal == "S") {
        if ($pdf->gety() + 17 > $pdf->h - 30) {
            $pdf->AddPage("L");
            $pdf->cell(20, $alt * 2, "", 0, 1, "L", 0);
        }

        $pdf->cell(55, $alt, "TOTAL GERAL " . number_format($valor_total, 2,',','.'), 0, 1, "R", 0);
    }
} else {
    db_redireciona('db_erros.php?fechar=true&db_erro=Modelo não foi selecionado.');
}

$pdf->setfont('arial', '', 8);

if (isset($imp_troca) && $imp_troca == "S") {
    if ($clpcorcamtroca->numrows > 0) {
        $pdf->ln();
        $tam = 280;
        if ($l20_tipojulg != 1) {
            $tam = 270;
        }

        if ($pdf->gety() > $pdf->h - 50) {
            $pdf->addpage("L");
        }

        $pdf->cell($tam, $alt, "TROCA FORNECEDOR", 1, 1, "C", 1);

        if ($l20_tipojulg == 1) {
            $pdf->cell(10, $alt, "Item", 1, 0, "C", 1);
            $pdf->cell(40, $alt, "Descrição material", 1, 0, "C", 1);
        }

        if ($l20_tipojulg != 1) {
            $pdf->cell(40, $alt, "Descrição lote", 1, 0, "C", 1);
        }

        $pdf->cell(60, $alt, "Fornecedor substituto", 1, 0, "C", 1);
        $pdf->cell(60, $alt, "Fornecedor substituido", 1, 0, "C", 1);
        $pdf->cell(110, $alt, "Justificativa", 1, 1, "C", 1);

        $p = 0;
        $lote = "";
        for($i = 0; $i < $clpcorcamtroca->numrows; $i ++) {
            db_fieldsmemory($res_troca, $i);
            if ($pdf->gety() > $pdf->h - 30) {
                $pdf->addpage("L");
            }

            if ($lote != "") {
                if ($lote == $l04_descricao) {
                    continue;
                }
            }

            if ($l20_tipojulg == 1) {
                $pdf->cell(10, $alt, $pc11_seq, 0, 0, "C", $p);
                $pdf->cell(40, $alt, substr($pc01_codmater . " - " . $pc01_descrmater, 0, 23), 0, 0, "L", $p);
            }

            if ($l20_tipojulg != 1) {
                $pdf->cell(40, $alt, $l04_descricao, 0, 0, "L", $p);
            }

            $pdf->cell(60, $alt, substr(@$nome_julgado, 0, 30), 0, 0, "L", $p);
            $pdf->cell(60, $alt, substr($nome_trocado, 0, 30), 0, 0, "L", $p);
            $pdf->multicell(110, $alt, $pc25_motivo, 0, "J", $p);

            if ($p == 0) {
                $p = 1;
            } else {
                $p = 0;
            }
        }
    }
}



if ($oConfiguracaoGed->utilizaGED()) {

    try {

        $sTipoDocumento = GerenciadorEletronicoDocumentoConfiguracao::MAPA_PROPOSTA;

        $oGerenciador = new GerenciadorEletronicoDocumento();
        $oGerenciador->setLocalizacaoOrigem("tmp/");
        $oGerenciador->setNomeArquivo("{$sTipoDocumento}_{$orcamento}.pdf");

        $oStdDadosGED        = new stdClass();
        $oStdDadosGED->nome  = $sTipoDocumento;
        $oStdDadosGED->tipo  = "NUMERO";
        $oStdDadosGED->valor = $orcamento;

        $pdf->Output("tmp/{$sTipoDocumento}_{$orcamento}.pdf");

        $oGerenciador->moverArquivo(array($oStdDadosGED));


    } catch (Exception $eErro) {
        db_redireciona("db_erros.php?fechar=true&db_erro=".$eErro->getMessage());
    }
} else {
    $pdf->Output();
}

?>
