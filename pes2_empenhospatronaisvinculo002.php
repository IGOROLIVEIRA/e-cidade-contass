<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2012  DBselller Servicos de Informatica             
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
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("libs/db_utils.php");
include("dbforms/db_funcoes.php");
include("fpdf151/pdf.php");
include("libs/db_sql.php");
include("classes/db_relempenhospatronais_classe.php");

$clrotulo = new rotulocampo;
$clrotulo->label('r06_codigo');
$clrotulo->label('r06_descr');
$clrotulo->label('r06_elemen');
$clrotulo->label('r06_pd');

const SALARIO_FAMILIA = "salarioFamilia";
const SALARIO_MATERNIDADE = "salarioMaternidade";

parse_str($HTTP_SERVER_VARS['QUERY_STRING']);

db_inicio_transacao();
$clrelempenhospatronais = new cl_relempenhospatronais;
$clrelempenhospatronais->excluir(null,"rh170_tipo = '".SALARIO_FAMILIA."' AND rh170_usuario = ".db_getsession("DB_id_usuario")." AND rh170_instit = ".db_getsession("DB_instit"));
$clrelempenhospatronais->excluir(null,"rh170_tipo = '".SALARIO_MATERNIDADE."' AND rh170_usuario = ".db_getsession("DB_id_usuario")." AND rh170_instit = ".db_getsession("DB_instit"));

$arrSalarioFamilia = explode(",", $salarioFamilia);
foreach($arrSalarioFamilia as $rubrica) {
    $clrelempenhospatronais->rh170_tipo = SALARIO_FAMILIA;
    $clrelempenhospatronais->rh170_rubric = $rubrica;
    $clrelempenhospatronais->rh170_instit = db_getsession("DB_instit");
    $clrelempenhospatronais->rh170_usuario = db_getsession("DB_id_usuario");
    $clrelempenhospatronais->incluir();
    if($clrelempenhospatronais->erro_status == 0){
        db_fim_transacao(true);
        db_redireciona('db_erros.php?fechar=true&db_erro='.$clrelempenhospatronais->erro_banco);
    }
}

$arrSalarioMaternidade = explode(",", $salarioMaternidade);
foreach($arrSalarioMaternidade as $rubrica) {
    $clrelempenhospatronais->rh170_tipo = SALARIO_MATERNIDADE;
    $clrelempenhospatronais->rh170_rubric = $rubrica;
    $clrelempenhospatronais->rh170_instit = db_getsession("DB_instit");
    $clrelempenhospatronais->rh170_usuario = db_getsession("DB_id_usuario");
    $clrelempenhospatronais->incluir();
    if($clrelempenhospatronais->erro_status == 0){
        db_fim_transacao(true);
        db_redireciona('db_erros.php?fechar=true&db_erro='.$clrelempenhospatronais->erro_banco);
    }
}
db_fim_transacao(false);

$salarioFamilia = str_replace(',',"','","'$salarioFamilia'");
$salarioMaternidade = str_replace(',',"','","'$salarioMaternidade'");

$sql_prev1 = "select distinct r33_ppatro
        from inssirf 
        where r33_anousu = $ano 
          and r33_mesusu = $mes 
          and r33_codtab in ($selec)
          and r33_codtab > 2
          and r33_instit = ".db_getsession('DB_instit') ;

$res_prev1 = pg_query($sql_prev1);
if (pg_numrows($res_prev1) > 1) {
    db_redireciona('db_erros.php?fechar=true&db_erro=As previdência escolhidas possuem percentuais patronais diferentes. Verifique!');
} elseif (pg_numrows($res_prev1) > 0) {
    db_fieldsmemory($res_prev1,0);
    $rub_base    = 'R992';
} else {
    $r33_ppatro = 8;
    $rub_base   = 'R991';
    $rub_ded    = '';
}

$sql_prev = "select distinct (cast(r33_codtab as integer)- 2) as r33_codtab,
              case when r33_codtab = 2 then 'FGTS' else r33_nome end as r33_nome
        from inssirf 
        where r33_anousu = $ano 
          and r33_mesusu = $mes 
          and r33_codtab in ($selec)
          and r33_codtab > 1
          and r33_instit = ".db_getsession('DB_instit') ;

$res_prev = pg_query($sql_prev);

$descr_prev = '';
$tab_prev   = '';
$virg       = '';
if (pg_numrows($res_prev) == 0) {
    db_redireciona('db_erros.php?fechar=true&db_erro=Problema na geração do relatório. Contate Suporte.');
} else {
    for ($xprev=0;$xprev<pg_numrows($res_prev);$xprev++) {
        db_fieldsmemory($res_prev,$xprev);
        $descr_prev .= $virg.$r33_nome;
        $tab_prev   .= $virg.$r33_codtab;
        $virg = ', ';
    }
}
//echo '  descricao --> '.$descr_prev;
//db_criatabela($res_prev);exit;

if ($salario == 's') {
    $descr_arq = 'SALÁRIO';
    $sql = "

    select 
            rh26_orgao,
            o40_descr,
            rh26_unidade,
            o41_descr,
            rh25_projativ,
            o55_descr,
            rh25_recurso,
            o15_descr,
            round(sum(inss),2) AS inss,
            round(sum(salario_familia),2) AS salario_familia,
            round(sum(salario_maternidade),2) AS salario_maternidade
    from 
    (
        select 
                case 
                    when rh171_orgaonov is not null then rh171_orgaonov
                    else rh26_orgao
                end as rh26_orgao,
                case 
                    when rh171_orgaonov is not null then orgaovinculo.o40_descr
                    else orcorgao.o40_descr
                end as o40_descr,
                case 
                    when rh171_unidadenov is not null then orcunidadevinculo.o41_descr
                    else orcunidade.o41_descr
                end as o41_descr,
                case 
                    when rh171_unidadenov is not null then rh171_unidadenov
                    else rh26_unidade
                end as rh26_unidade,
                case 
                    when rh171_projativnov is not null then rh171_projativnov
                    else rh25_projativ
                end as rh25_projativ,
                case 
                    when rh171_projativnov is not null then orcprojativvinculo.o55_descr
                    else orcprojativ.o55_descr
                end as o55_descr,
                case 
                    when rh171_recursonov is not null then rh171_recursonov
                    else rh25_recurso
                end as rh25_recurso,
                case 
                    when rh171_recursonov is not null then orctiporecvinculo.o15_descr
                    else orctiporec.o15_descr
                end as o15_descr,
                inss,
                salario_familia,
                salario_maternidade
        from
        (
        select rh02_regist as r01_regist,
                z01_nome,
                rh02_lota,
                rh03_padrao as r01_padrao,
                rh02_instit,
                case when r14_rubric = '$rub_base' then r14_valor else 0 end as inss,
                case when r14_rubric in ({$salarioFamilia}) then r14_valor else 0 end as salario_familia,
                case when r14_rubric in ({$salarioMaternidade}) then r14_valor else 0 end as salario_maternidade
        from gerfsal 
            inner join rhpessoalmov on rh02_anousu = r14_anousu 
                                    and rh02_mesusu = r14_mesusu 
                                    and rh02_regist = r14_regist
                                    and rh02_instit = r14_instit                
            inner join rhpessoal    on rh01_regist = rh02_regist												
            left join rhpespadrao   on rh03_seqpes = rhpessoalmov.rh02_seqpes
            inner join cgm on rh01_numcgm = z01_numcgm  
        where r14_anousu = $ano 
            and r14_mesusu = $mes
            and r14_instit = ".db_getsession("DB_instit")."
            and r14_rubric in ('$rub_base',{$salarioFamilia},{$salarioMaternidade})
            ".($tab_prev == 0?'':" and rh02_tbprev in ($tab_prev)")."

        union all

        select rh02_regist as r01_regist,
                z01_nome,
                rh02_lota,
                rh03_padrao as r01_padrao,
                rh02_instit,
                case when r48_rubric = '$rub_base' then r48_valor else 0 end as inss,
                case when r48_rubric in ({$salarioFamilia}) then r48_valor else 0 end as salario_familia,
                case when r48_rubric in ({$salarioMaternidade}) then r48_valor else 0 end as salario_maternidade
        from gerfcom
            inner join rhpessoalmov on rh02_anousu = r48_anousu 
                                    and rh02_mesusu = r48_mesusu 
                                    and rh02_regist = r48_regist
                                    and rh02_instit = r48_instit                
            inner join rhpessoal    on rh01_regist = rh02_regist												
            left join rhpespadrao   on rh03_seqpes = rhpessoalmov.rh02_seqpes
            inner join cgm on rh01_numcgm = z01_numcgm
        where r48_anousu = $ano
            and r48_mesusu = $mes
            and r48_instit = ".db_getsession("DB_instit")."
            and r48_rubric in ('$rub_base',{$salarioFamilia},{$salarioMaternidade})
            ".($tab_prev == 0?'':" and rh02_tbprev in ($tab_prev)")."
                        
        union all

        select rh02_regist as r01_regist,
                z01_nome,
                rh02_lota,
                rh03_padrao as r01_padrao,
                rh02_instit,
                case when r20_rubric = '$rub_base' then r20_valor else 0 end as inss,
                case when r20_rubric in ({$salarioFamilia}) then r20_valor else 0 end as salario_familia,
                case when r20_rubric in ({$salarioMaternidade}) then r20_valor else 0 end as salario_maternidade
        from gerfres
            inner join rhpessoalmov on rh02_anousu = r20_anousu 
                                    and rh02_mesusu = r20_mesusu 
                                    and rh02_regist = r20_regist
                                    and rh02_instit = r20_instit                
            inner join rhpessoal    on rh01_regist = rh02_regist												
            left join rhpespadrao   on rh03_seqpes = rhpessoalmov.rh02_seqpes
            inner join cgm on rh01_numcgm = z01_numcgm
        where r20_anousu = $ano
            and r20_mesusu = $mes
            and r20_instit = ".db_getsession("DB_instit")."
            and r20_rubric in ('$rub_base',{$salarioFamilia},{$salarioMaternidade})
            ".($tab_prev == 0?'':" and rh02_tbprev in ($tab_prev)")."
                        
        ) as x
        left join rhlota on rh02_lota = r70_codigo
                        and r70_instit = ".db_getsession("DB_instit")."
        left join (select distinct rh25_codigo,rh25_projativ, rh25_recurso from rhlotavinc where rh25_anousu = $ano ) as rhlotavinc on rh25_codigo = r70_codigo
        left  join rhlotaexe  on r70_codigo = rh26_codigo and rh26_anousu = $ano
        left  join orcprojativ on o55_anousu = $ano
                                and o55_projativ = rh25_projativ
        left  join orcorgao    on o40_orgao = rh26_orgao
                                and o40_anousu = $ano
                                and o40_instit = ".db_getsession("DB_instit")."
        left join orcunidade   on o41_anousu = $ano
                                and o41_orgao = rh26_orgao
                                and o41_unidade = rh26_unidade
        left join orctiporec   on o15_codigo = rh25_recurso
        left join rhvinculodotpatronais on rh26_orgao = rh171_orgaoorig 
                                        and rh26_unidade = rh171_unidadeorig 
                                        and rh25_projativ = rh171_projativorig 
                                        and rh25_recurso = rh171_recursoorig 
                                        and rh171_mes = $mes 
                                        and rh171_anousu = $ano 
                                        and rh171_instit = ".db_getsession("DB_instit")."
        left join orcorgao as orgaovinculo on orgaovinculo.o40_orgao = rh171_orgaonov 
                                            and orgaovinculo.o40_anousu = $ano 
                                            and orgaovinculo.o40_instit = ".db_getsession("DB_instit")."
        left join orcunidade as orcunidadevinculo on orcunidadevinculo.o41_anousu = $ano 
                                            and orcunidadevinculo.o41_orgao = rh171_orgaonov 
                                            and orcunidadevinculo.o41_unidade = rh171_unidadenov  
        left join orcprojativ as orcprojativvinculo on orcprojativvinculo.o55_anousu = $ano 
                                            and orcprojativvinculo.o55_projativ = rh171_projativnov     
        left join orctiporec as orctiporecvinculo on orctiporecvinculo.o15_codigo = rh171_recursonov
    ) as xxxx

    group by
            rh26_orgao,
            o40_descr,
            rh26_unidade,
            o41_descr,
            rh25_projativ,
            rh25_recurso,
            o15_descr,
            o55_descr
    order by
            rh26_orgao,
            o40_descr,
            rh26_unidade,
            o41_descr,
            rh25_projativ,
            rh25_recurso,
            o15_descr,
            o55_descr
         ";
} elseif($salario == 'd') {
    $descr_arq = '13o. SALÁRIO';
    $sql = "

    select 
            rh26_orgao,
            o40_descr,
            rh26_unidade,
            o41_descr,
            rh25_projativ,
            o55_descr,
            rh25_recurso,
            o15_descr,
            round(sum(inss),2) AS inss,
            round(sum(salario_familia),2) AS salario_familia,
            round(sum(salario_maternidade),2) AS salario_maternidade
    from 
    (
    select 
            case 
                when rh171_orgaonov is not null then rh171_orgaonov
                else rh26_orgao
            end as rh26_orgao,
            case 
                when rh171_orgaonov is not null then orgaovinculo.o40_descr
                else orcorgao.o40_descr
            end as o40_descr,
            case 
                when rh171_unidadenov is not null then orcunidadevinculo.o41_descr
                else orcunidade.o41_descr
            end as o41_descr,
            case 
                when rh171_unidadenov is not null then rh171_unidadenov
                else rh26_unidade
            end as rh26_unidade,
            case 
                when rh171_projativnov is not null then rh171_projativnov
                else rh25_projativ
            end as rh25_projativ,
            case 
                when rh171_projativnov is not null then orcprojativvinculo.o55_descr
                else orcprojativ.o55_descr
            end as o55_descr,
            case 
                when rh171_recursonov is not null then rh171_recursonov
                else rh25_recurso
            end as rh25_recurso,
            case 
                when rh171_recursonov is not null then orctiporecvinculo.o15_descr
                else orctiporec.o15_descr
            end as o15_descr,
            inss,
            salario_familia,
            salario_maternidade 

    from 

    (
    select rh02_regist as r01_regist,
            z01_nome,
            rh02_lota,
            rh03_padrao as r01_padrao,
            rh02_instit,
            case when r35_rubric = '$rub_base' then r35_valor else 0 end as inss,
            case when r35_rubric in ({$salarioFamilia}) then r35_valor else 0 end as salario_familia,
            case when r35_rubric in ({$salarioMaternidade}) then r35_valor else 0 end as salario_maternidade
    from gerfs13 
        inner join rhpessoalmov on rh02_anousu = r35_anousu 
                                and rh02_mesusu = r35_mesusu 
                                and rh02_regist = r35_regist
                                and rh02_instit = r35_instit                
        inner join rhpessoal    on rh01_regist = rh02_regist												
        left join rhpespadrao   on rh03_seqpes = rhpessoalmov.rh02_seqpes
        inner join cgm on rh01_numcgm = z01_numcgm  
    where r35_anousu = $ano 
        and r35_mesusu = $mes
        and r35_instit = ".db_getsession("DB_instit")."
        and r35_rubric in ('$rub_base',{$salarioFamilia},{$salarioMaternidade})
        ".($tab_prev == 0?'':" and rh02_tbprev in ($tab_prev)")."
    ) as x
    left join rhlota on rh02_lota = r70_codigo
                    and r70_instit = ".db_getsession("DB_instit")."
    left join (select distinct rh25_codigo,rh25_projativ, rh25_recurso from rhlotavinc where rh25_anousu = $ano ) as rhlotavinc on rh25_codigo = r70_codigo
    left  join rhlotaexe  on r70_codigo = rh26_codigo and rh26_anousu = $ano
    left  join orcprojativ on o55_anousu = $ano
                            and o55_projativ = rh25_projativ
    left  join orcorgao    on o40_orgao = rh26_orgao
                            and o40_anousu = $ano
                            and o40_instit = ".db_getsession("DB_instit")."
    left join orcunidade   on o41_anousu = $ano
                            and o41_orgao = rh26_orgao
                            and o41_unidade = rh26_unidade
    left join orctiporec   on o15_codigo = rh25_recurso
    left join rhvinculodotpatronais on rh26_orgao = rh171_orgaoorig 
                                        and rh26_unidade = rh171_unidadeorig 
                                        and rh25_projativ = rh171_projativorig 
                                        and rh25_recurso = rh171_recursoorig 
                                        and rh171_mes = $mes 
                                        and rh171_anousu = $ano 
                                        and rh171_instit = ".db_getsession("DB_instit")."
    left join orcorgao as orgaovinculo on orgaovinculo.o40_orgao = rh171_orgaonov 
                                        and orgaovinculo.o40_anousu = $ano 
                                        and orgaovinculo.o40_instit = ".db_getsession("DB_instit")."
    left join orcunidade as orcunidadevinculo on orcunidadevinculo.o41_anousu = $ano 
                                        and orcunidadevinculo.o41_orgao = rh171_orgaonov 
                                        and orcunidadevinculo.o41_unidade = rh171_unidadenov  
    left join orcprojativ as orcprojativvinculo on orcprojativvinculo.o55_anousu = $ano 
                                        and orcprojativvinculo.o55_projativ = rh171_projativnov     
    left join orctiporec as orctiporecvinculo on orctiporecvinculo.o15_codigo = rh171_recursonov
    ) as xxxx

    group by
            rh26_orgao,
            o40_descr,
            rh26_unidade,
            o41_descr,
            rh25_projativ,
            rh25_recurso,
            o15_descr,
            o55_descr
    order by
            rh26_orgao,
            o40_descr,
            rh26_unidade,
            o41_descr,
            rh25_projativ,
            rh25_recurso,
            o15_descr,
            o55_descr
            ";
}


$head2      = "EMPENHOS DO ".strtoupper($descr_prev);
$rub_basee  = 'R991';
$head4      = "ARQUIVO : ".$descr_arq;
$head6      = "PERÍODO : ".$mes." / ".$ano;

// echo $sql ; exit;
//echo "patronal --> $r33_ppatro" ; exit;

$result = pg_exec($sql);
//db_criatabela($result);
$xxnum = pg_numrows($result);
if ($xxnum == 0) {
    db_redireciona('db_erros.php?fechar=true&db_erro=Não existem movimentos cadastrados no período de '.$mes.' / '.$ano);
}

$pdf = new PDF(); 
$pdf->Open(); 
$pdf->AliasNbPages(); 
$total = 0;
$pdf->setfillcolor(235);
$pdf->setfont('arial','b',8);
$troca = 1;
$alt = 4;
$orgao = '';
$unidade = '';
$proj = '';
$val_fgts     = 0;
$val_fgts_seg = 0;
$val_fgts_pad = 0;
$val_ded      = 0;
$val_pat      = 0;
$val_extra    = 0;
$pat60        = 0;
$pat40        = 0;
$patronal     = 0;
$teste        = 0;
$extra        = 0;
$totalSalarioFamilia = 0;
$totalSalarioMaternidade = 0;
$width_perc_extra = 0;
if (trim($perc_extra) != '' ) {
    $width_perc_extra = 3;
}
for ($x = 0; $x < pg_numrows($result);$x++) {

    db_fieldsmemory($result,$x);
    if ($pdf->gety() > $pdf->h - 30 || $troca != 0 ){
        $pdf->addpage();
        $pdf->setfont('arial','B',7);
        $pdf->cell(95-$width_perc_extra,$alt,'DESCRIÇÃO',1,0,"C",0);
        $pdf->cell(18-$width_perc_extra,$alt,'BASE',1,0,"R",0);
        if ($tab_prev == 0) {
            $pdf->cell(18,$alt,"SEG. $r33_ppatro%",1,0,"R",0);
            $pdf->cell(18,$alt,'TOTAL',1,1,"R",0);
        } else {
            $pdf->cell(18-$width_perc_extra,$alt,'PATRONAL',1,0,"R",0);
            if (trim($perc_extra) != '' ) {
                $pdf->cell(18,$alt,"EXTRA {$perc_extra} %",1,0,"R",0);
            }
            $pdf->cell(18-$width_perc_extra,$alt,'S/FAMÍLIA',1,0,"R",0);
            $pdf->cell(22-$width_perc_extra,$alt,'S/MATERN.',1,0,"R",0);
            $pdf->cell(18-$width_perc_extra,$alt,'TOTAL',1,1,"R",0);
        }
        $troca = 0;
    }
    $pdf->setfont('arial','B',7);
    if ($orgao != $rh26_orgao) {
        $pdf->cell(15,$alt,db_formatar($rh26_orgao,'orgao'),0,0,"C",1);
        $pdf->cell(0,$alt,$o40_descr,0,1,"L",1);
        $orgao = $rh26_orgao;
    }
    if ($unidade != $rh26_orgao.$rh26_unidade) {
        $pdf->cell(5,$alt,'',0,0,"C",1);
        $pdf->cell(14,$alt,db_formatar($rh26_orgao,'orgao').db_formatar($rh26_unidade,'orgao'),0,0,"C",1);
        $pdf->cell(0,$alt,$o41_descr,0,1,"L",1);
        $unidade = $rh26_orgao.$rh26_unidade;
    }
    if ($proj != $rh25_projativ) {
        $pdf->cell(5,$alt,'',0,0,"C",1);
        $pdf->cell(14,$alt,$rh25_projativ,0,0,"C",1);
        $pdf->cell(0,$alt,$o55_descr,0,1,"L",1);
        $proj= $rh25_projativ;
    }
    $pdf->setfont('arial','',6);
    $aDescRecurso = quebrarTexto($o15_descr, 60);
    
    $altNovo = $alt*count($aDescRecurso);
    $pdf->cell(10,$altNovo,'',0,0,"C",0);
    $pdf->cell(15-$width_perc_extra,$altNovo,$rh25_recurso,0,0,"C",0);
    if (count($aDescRecurso) > 1) {
        multiCell($pdf, $aDescRecurso, $alt, $altNovo, 70);
    } else {
        $pdf->cell(70,$altNovo,$o15_descr,0,0,"L",0);
    }

    $patronal   = round($inss / 100 * $r33_ppatro,2);

    $pdf->cell(18-$width_perc_extra,$altNovo,db_formatar($inss,'f'),0,0,"R",0);
    $pdf->cell(18-$width_perc_extra,$altNovo,db_formatar($patronal,'f'),0,0,"R",0);
    if (trim($perc_extra) != '' ) {
        $extra = round($inss / 100 * $perc_extra,2);
        $pdf->cell(18,$altNovo,trim(db_formatar($extra,'f')),0,0,"R",0);
    }
    if ($tab_prev != 0) {
        $pdf->cell(18-$width_perc_extra,$altNovo,db_formatar($salario_familia,'f'),0,0,"R",0);
        $pdf->cell(22-$width_perc_extra,$altNovo,db_formatar($salario_maternidade,'f'),0,0,"R",0);
    }
    $pdf->cell(18-$width_perc_extra,$altNovo,db_formatar(($patronal + $extra - $salario_familia - $salario_maternidade),'f'),0,1,"R",0);
    $val_pat      += $patronal;
    $val_extra    += round((($inss)/100)*$perc_extra,2);
    $val_fgts     += $inss;
    $val_ded      += ($salario_familia+$salario_maternidade);
    $totalSalarioFamilia += $salario_familia;
    $totalSalarioMaternidade += $salario_maternidade;
}

$pdf->setfont('arial','B',7);
$pdf->cell(95-$width_perc_extra,$alt,'TOTAL ',0,0,"C",0);
$pdf->cell(18-$width_perc_extra,$alt,db_formatar($val_fgts,'f'),0,0,"R",0);
$pdf->cell(18-$width_perc_extra,$alt,db_formatar($val_pat,'f'),0,0,"R",0);
if (trim($perc_extra) != '' ) {
    $pdf->cell(18,$alt,db_formatar($val_extra,'f'),0,0,"R",0);
}
if ($tab_prev != 0) {
    $pdf->cell(18-$width_perc_extra,$alt,db_formatar($totalSalarioFamilia,'f'),0,0,"R",0);
    $pdf->cell(22-$width_perc_extra,$alt,db_formatar($totalSalarioMaternidade,'f'),0,0,"R",0);
}
$pdf->cell(18-$width_perc_extra,$alt,db_formatar($val_pat + $val_extra - $val_ded,'f'),0,1,"R",0);

$pdf->Output();

function quebrarTexto($texto,$tamanho){

    $aTexto = explode(" ", $texto);
    $string_atual = "";
    foreach ($aTexto as $word) {
        $string_ant = $string_atual;
        $string_atual .= " ".$word;
        if (strlen($string_atual) > $tamanho) {
            $aTextoNovo[] = $string_ant;
            $string_ant   = "";
            $string_atual = $word;
        }
    }
    $aTextoNovo[] = $string_atual;
    return $aTextoNovo;

}

function multiCell($oPdf,$aTexto,$iTamFixo,$iTam,$iTamCampo) {
    
    $pos_x = $oPdf->x;
    $pos_y = $oPdf->y;
    $oPdf->cell($iTamCampo, $iTam, "", 0, 0, 'L');
    $oPdf->x = $pos_x;
    $oPdf->y = $pos_y;
    foreach ($aTexto as $sProcedimento) {
        $sProcedimento=ltrim($sProcedimento);
        $oPdf->cell($iTamCampo, $iTamFixo, $sProcedimento, 0, 1, 'L');
        $oPdf->x=$pos_x;
    }
    $oPdf->x = $pos_x+$iTamCampo;
    $oPdf->y = $pos_y;
    
}
   
?>