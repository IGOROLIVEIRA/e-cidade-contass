<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBselller Servicos de Informatica
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

include("fpdf151/impcarne.php");
include("fpdf151/scpdf.php");
include("libs/db_sql.php");
include("classes/db_basesr_classe.php");
include("classes/db_selecao_classe.php");
include("classes/db_rhautonomolanc_classe.php");
$clselecao = new cl_selecao();
$clbasesr = new cl_basesr;
$clrhautonomolanc = new cl_rhautonomolanc();

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
if ($tipo == 'd') {
    $mes = 12;
    $mesPdf = 13;
    $iInstituicao        = db_getsession('DB_instit');
    $oCompetenciaAtual = DBPessoal::getCompetenciaFolha();

    $oDaoCfpess = new cl_cfpess();
    $sSqlCfpess = $oDaoCfpess->sql_query_file(
        $oCompetenciaAtual->getAno(),
        '',
        $iInstituicao,
        'distinct r11_mes13'
    );
    $rsCfPess   = $oDaoCfpess->sql_record($sSqlCfpess);
    if (pg_num_rows($rsCfPess) > 1)
        $vir = "";
    $sMeses = '';
    for ($i = 0; $i < pg_num_rows($rsCfPess); $i++) {
        $sMeses .= $vir . db_utils::fieldsMemory($rsCfPess, $i)->r11_mes13;
        $vir = ",";
    }
} else {
    $mesPdf = $mes;
}

$sql_in = $clbasesr->sql_query_file($ano, $mes, "B995", null, db_getsession("DB_instit"), "r09_rubric");

$sql_inst = "select * from db_config where codigo = " . db_getsession("DB_instit");

$result_inst = db_query($sql_inst);

db_fieldsmemory($result_inst, 0);

if (empty($campoextra)) {
    $campoextra = 0;
}

$where = " ";
if (trim($selecao) != "") {
    $result_selecao = $clselecao->sql_record($clselecao->sql_query_file($selecao, db_getsession("DB_instit")));
    if ($clselecao->numrows > 0) {
        db_fieldsmemory($result_selecao, 0);
        $where = " and " . $r44_where;
        $head8 = "SELEÇÃO: " . $selecao . " - " . $r44_descr;
    }
}

//// nome das previdencias
$sql_nome = "SELECT distinct (cast(r33_codtab as integer)-2) as r33_codtab,r33_nome, r33_ppatro
         FROM inssirf
   WHERE r33_anousu = $ano
	   and r33_mesusu = $mes
	   and r33_codtab in ($previdencia)
	   and r33_codtab > 2
	   and r33_instit = " . db_getsession("DB_instit") . "
	  ";
$res_nome = db_query($sql_nome);

$virg_nome = '';
$descr_nome = '';
for ($inome = 0; $inome < pg_numrows($res_nome); $inome++) {
    db_fieldsmemory($res_nome, $inome);
    $descr_nome .= $virg_nome . $r33_nome;
    $virg_nome   = ', ';
}

$xbases    = " ('R992') ";
$xdeducao  = " (" . $sql_in . ") ";
$xrubricas = " ('R901','R902','R903','R904','R905','R906','R907','R908','R909','R910','R911','R912') ";
$prev      = " and rh02_tbprev in ($previdencia) ";
$devolucao = " ('')";

$soma     = 0;
$base     = 0;
$ded      = 0;
$dev      = 0;
$desco    = 0;
$patronal = 0;
$agentes_nocivos = 0;

for ($inome = 0; $inome < pg_numrows($res_nome); $inome++) {
    db_fieldsmemory($res_nome, $inome);
    if ($tipo == 's') {

        $sql = "
    select count(soma) as soma1,
           round(sum(base),2)                 as base1,
           round(sum(ded),2)                  as ded1,
           round(sum(dev),2)                  as dev1,
           round(sum(desco),2)                as desco1,
           round(sum(parcela_patronal),2)     as patronal1,
           round(sum(campoextra),2) AS campoextra1,
           round(sum(agentes_nocivos),2) AS agentes_nocivos1
    from
    (
    select r01_regist                           as soma,
           sum(base)                            as base,
           sum(ded)                             as ded,
           sum(dev)                             as dev,
           sum(desco)                           as desco,
           sum(base)/100*$r33_ppatro   as parcela_patronal,
           sum(base)/100* " . $campoextra . " AS campoextra,
           sum(nocivo) AS agentes_nocivos
    from
    (
    select
           rh01_regist as r01_regist,
           z01_nome,
           rh02_lota,
           rh03_padrao,
           sum(case when r14_rubric in " . $xrubricas . " then r14_valor else 0 end) as desco,
           sum(case when r14_rubric in " . $xdeducao . " then r14_valor else 0 end) as ded ,
           sum(case when r14_rubric in " . $devolucao . " then r14_valor else 0 end) as dev ,
           sum(case when r14_rubric in " . $xbases . "    then r14_valor else 0 end) as base,
           sum(case when r14_rubric = 'R992' and rh02_ocorre IN ('02','06') then r14_valor*12/100
                    when r14_rubric = 'R992' and rh02_ocorre IN ('03','07') then r14_valor*9/100
                    when r14_rubric = 'R992' and rh02_ocorre IN ('04','08') then r14_valor*6/100
           else 0 end) as nocivo
    from gerfsal
         inner join rhpessoalmov on rh02_anousu = r14_anousu
                                and rh02_mesusu = r14_mesusu
                                and rh02_regist = r14_regist
                                and rh02_instit = r14_instit
         inner join rhlota       on r70_codigo  = rh02_lota
                                and r70_instit  = rh02_instit
                                left  join rhlotavinc  on rh25_codigo = r70_codigo
         inner join rhregime     on rh02_codreg = rh30_codreg
                                and rh02_instit = rh30_instit
         inner join rhpessoal    on rh01_regist = r14_regist
         left join rhpespadrao   on rh03_seqpes    = rhpessoalmov.rh02_seqpes
         inner join cgm on rh01_numcgm = z01_numcgm
    where r14_anousu = $ano
      and r14_mesusu = $mes
      $where
      and r14_instit = " . db_getsession('DB_instit') . "
      and rh02_tbprev = $r33_codtab
      and ( r14_rubric in " . $xrubricas . "
         or r14_rubric in " . $xdeducao . "
         or r14_rubric in " . $devolucao . "
         or r14_rubric in " . $xbases . ")
      and rh25_anousu = $ano
      group by
           rh01_regist,
           z01_nome,
           rh02_lota,
           rh03_padrao

    union all

    select rh01_regist,
           z01_nome,
           rh02_lota,
           rh03_padrao,
           sum(case when r48_rubric in " . $xrubricas . " then r48_valor else 0 end) as desco,
           sum(case when r48_rubric in " . $xdeducao . "  then r48_valor else 0 end) as ded ,
           sum(case when r48_rubric in " . $devolucao . " then r48_valor else 0 end) as dev ,
           sum(case when r48_rubric in " . $xbases . "    then r48_valor else 0 end) as base,
           sum(case when r48_rubric = 'R992' and rh02_ocorre IN ('02','06') then r48_valor*12/100
                    when r48_rubric = 'R992' and rh02_ocorre IN ('03','07') then r48_valor*9/100
                    when r48_rubric = 'R992' and rh02_ocorre IN ('04','08') then r48_valor*6/100
           else 0 end) as nocivo
    from gerfcom
         inner join rhpessoalmov on rh02_anousu = r48_anousu
                                and rh02_mesusu = r48_mesusu
                                and rh02_regist = r48_regist
                                and rh02_instit = r48_instit
         inner join rhlota       on r70_codigo  = rh02_lota
                                and r70_instit  = rh02_instit
                                left  join rhlotavinc  on rh25_codigo = r70_codigo
         inner join rhregime     on rh02_codreg = rh30_codreg
                                and rh02_instit = rh30_instit
         inner join rhpessoal    on rh01_regist = r48_regist
         left join rhpespadrao   on rh03_seqpes    = rhpessoalmov.rh02_seqpes
         inner join cgm on rh01_numcgm = z01_numcgm
    where r48_anousu = $ano
      $where
      and r48_mesusu = $mes
      and r48_instit = " . db_getsession('DB_instit') . "
      and rh02_tbprev = $r33_codtab
      and ( r48_rubric in " . $xrubricas . "
         or r48_rubric in " . $xdeducao . "
         or r48_rubric in " . $devolucao . "
         or r48_rubric in " . $xbases . " )
      and rh25_anousu = $ano
      group by
           rh01_regist,
           z01_nome,
           rh02_lota,
           rh03_padrao

    union all

    select rh01_regist,
           z01_nome,
           rh02_lota,
           rh03_padrao,
           sum(case when r20_rubric in " . $xrubricas . " then r20_valor else 0 end) as desco,
           sum(case when r20_rubric in " . $xdeducao . "  then r20_valor else 0 end) as ded ,
           sum(case when r20_rubric in " . $devolucao . " then r20_valor else 0 end) as dev ,
           sum(case when r20_rubric in " . $xbases . "    then r20_valor else 0 end) as base,
           sum(case when r20_rubric = 'R992' and rh02_ocorre IN ('02','06') then r20_valor*12/100
                    when r20_rubric = 'R992' and rh02_ocorre IN ('03','07') then r20_valor*9/100
                    when r20_rubric = 'R992' and rh02_ocorre IN ('04','08') then r20_valor*6/100
           else 0 end) as nocivo
    from gerfres
         inner join rhpessoalmov on rh02_anousu = r20_anousu
                                and rh02_mesusu = r20_mesusu
                                and rh02_regist = r20_regist
                                and rh02_instit = r20_instit
         inner join rhlota       on r70_codigo  = rh02_lota
                                and r70_instit  = rh02_instit
                                left  join rhlotavinc  on rh25_codigo = r70_codigo
         inner join rhregime     on rh02_codreg = rh30_codreg
                                and rh02_instit = rh30_instit
         inner join rhpessoal    on rh01_regist = r20_regist
         left join rhpespadrao   on rh03_seqpes    = rhpessoalmov.rh02_seqpes
         inner join cgm on rh01_numcgm = z01_numcgm
    where r20_anousu = $ano
      and r20_mesusu = $mes
      $where
      and r20_instit = " . db_getsession('DB_instit') . "
      and rh02_tbprev = $r33_codtab
      and ( r20_rubric in " . $xrubricas . "
         or r20_rubric in " . $xdeducao . "
         or r20_rubric in " . $devolucao . "
         or r20_rubric in " . $xbases . ")
      and rh25_anousu = $ano
      group by
           rh01_regist,
           z01_nome,
           rh02_lota,
           rh03_padrao
    ) as xx group by r01_regist


    ) as xxx

           ";
    } else {

        if (pg_num_rows($rsCfPess) > 1)
            $mes = $sMeses;

        $sql = "

    select count(soma) as soma1,
           round(sum(base),2)                 as base1,
           round(sum(ded),2)                  as ded1,
           round(sum(dev),2)                  as dev1,
           round(sum(desco),2)                as desco1,
           round(sum(parcela_patronal),2)     as patronal1,
           round(sum(campoextra),2) AS campoextra1,
           round(sum(agentes_nocivos),2) AS agentes_nocivos1
    from
    (
    select r01_regist                           as soma,
           sum(base)                            as base,
           sum(ded)                             as ded,
           sum(dev)                             as dev,
           sum(desco)                           as desco,
           sum(base)/100*$r33_ppatro   as parcela_patronal,
           sum(base)/100* " . $campoextra . " AS campoextra,
           sum(nocivo) AS agentes_nocivos
    from
    (
    select
           rh01_regist as r01_regist,
           z01_nome,
           rh02_lota,
           rh03_padrao,
           sum(case when r35_rubric in " . $xrubricas . " then r35_valor else 0 end) as desco,
           sum(case when r35_rubric in " . $xdeducao . " then r35_valor else 0 end) as ded ,
           sum(case when r35_rubric in " . $devolucao . " then r35_valor else 0 end) as dev ,
           sum(case when r35_rubric in " . $xbases . "    then r35_valor else 0 end) as base,
           sum(case when r35_rubric = 'R992' and rh02_ocorre IN ('02','06') then r35_valor*12/100
                    when r35_rubric = 'R992' and rh02_ocorre IN ('03','07') then r35_valor*9/100
                    when r35_rubric = 'R992' and rh02_ocorre IN ('04','08') then r35_valor*6/100
           else 0 end) as nocivo
    from gerfs13
         inner join rhpessoalmov on rh02_anousu = r35_anousu
                                and rh02_mesusu = r35_mesusu
                                and rh02_regist = r35_regist
                                and rh02_instit = r35_instit
         inner join rhlota       on r70_codigo  = rh02_lota
                                and r70_instit  = rh02_instit
                                left  join rhlotavinc  on rh25_codigo = r70_codigo
         inner join rhregime     on rh02_codreg = rh30_codreg
                                and rh02_instit = rh30_instit
         inner join rhpessoal    on rh01_regist = r35_regist
         left join rhpespadrao   on rh03_seqpes    = rhpessoalmov.rh02_seqpes
         inner join cgm on rh01_numcgm = z01_numcgm
    where r35_anousu = $ano
      and r35_mesusu in ($mes)
      $where
      and r35_instit = " . db_getsession('DB_instit') . "
      and rh02_tbprev = $r33_codtab
      and ( r35_rubric in " . $xrubricas . "
         or r35_rubric in " . $xdeducao . "
         or r35_rubric in " . $devolucao . "
         or r35_rubric in " . $xbases . ")
      and rh25_anousu = $ano
      group by
           rh01_regist,
           z01_nome,
           rh02_lota,
           rh03_padrao

    ) as xx group by r01_regist


    ) as xxx

           ";
    }
    $result = db_query($sql);
    $xxnum = pg_numrows($result);
    if ($xxnum == 0) {
        db_redireciona('db_erros.php?fechar=true&db_erro=Não existem Códigos cadastrados no período de ' . $mes . ' / ' . $ano);
    }
    db_fieldsmemory($result, 0);
    $soma     += $soma1;
    $base     += $base1;
    $ded      += $ded1;
    $dev      += $dev1;
    $desco    += $desco1;
    $patronal += $patronal1;
    $cmpextra += $campoextra1;
    $agentes_nocivos += $agentes_nocivos1;
}
//echo $sql ; exit;
if ($selautonomo == 'true') {
    $sql = $clrhautonomolanc->sql_query_file(null, "sum((rh89_valorserv*20/100)+rh89_valorretinss) as terceiros,sum(rh89_valorserv) as valor_servico", null, "(rh89_anousu,rh89_mesusu) = ({$ano},{$mes})");
    $rsTerceiros = $clrhautonomolanc->sql_record($sql);
}

global $pdf;
$pdf = new scpdf();
$pdf->Open();
$pdf1 = new db_impcarne($pdf, 25);
//$pdf1->modelo     	= 25;
$pdf1->logo             = $logo;
$pdf1->prefeitura       = $nomeinst;
$pdf1->enderpref        = $ender . ', ' . $numero;
$pdf1->cgcpref          = $cgc;
$pdf1->cep              = $cep;
$pdf1->ufpref           = $uf;
$pdf1->cgcpref          = $cgc;
$pdf1->municpref        = $munic;
$pdf1->telefpref        = $telef;
$pdf1->emailpref        = $email;
$pdf1->ano              = $ano;
$pdf1->mes              = $mesPdf;
$pdf1->func             = $soma;
$pdf1->base             = $base;
$pdf1->deducao          = $ded;
$pdf1->desconto         = $desco - $dev;
$pdf1->patronal         = $patronal;
$pdf1->campoextra       = $cmpextra;
$pdf1->cod_pagto        = $cod_pagto;
$pdf1->terceiros        = round(db_utils::fieldsMemory($rsTerceiros, 0)->terceiros, 2);
$pdf1->valor_servico    = round(db_utils::fieldsMemory($rsTerceiros, 0)->valor_servico, 2);
$pdf1->agentes_nocivos  = $agentes_nocivos;
$pdf1->atu_monetaria    = 0;
$pdf1->juros            = 0;
$pdf1->previdencia      = strtoupper($tipo == 's' ? $descr_nome : $descr_nome . ' S/ 13º');
$pdf1->imprime();

$pdf1->objpdf->output();
