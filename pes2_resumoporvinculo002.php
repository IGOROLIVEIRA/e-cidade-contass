<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2013  DBselller Servicos de Informatica             
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
parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
//db_postmemory($HTTP_POST_VARS,2);
//db_postmemory($HTTP_SERVER_VARS,2);exit;
if ($folha == 'r14') {
    $xarquivo = 'DE SALÁRIO';
    $arquivo = 'gerfsal';
} elseif ($folha == 'r20') {
    $xarquivo = 'DE RESCISÄO';
    $arquivo = 'gerfres';
} elseif ($folha == 'r35') {
    $xarquivo = 'DE 13o SALÁRIO';
    $arquivo = 'gerfs13';
} elseif ($folha == 'r22') {
    $xarquivo = 'DE ADIANTAMENTO';
    $arquivo = 'gerfadi';
} elseif ($folha == 'r48') {
    $xarquivo = 'COMPLEMENTAR';
    $arquivo = 'gerfcom';
}

$wherepes = '';
if (isset($semest) && $semest != 0) {
    $wherepes = " and r48_semest = " . $semest;
    $head6 = $xarquivo . " ($semest)";
}

if ($vinc == 'a') {
    $dvinc = ' ATIVOS';
    $xvinc = " and rh30_vinculo = 'A' ";
} elseif ($vinc == 'i') {
    $dvinc = ' INATIVOS';
    $xvinc = " and rh30_vinculo = 'I' ";
} elseif ($vinc == 'p') {
    $dvinc = ' PENSIONISTAS';
    $xvinc = " and rh30_vinculo = 'P' ";
} elseif ($vinc == 'ip') {
    $dvinc = ' ATIVOS/PENSIONISTAS ';
    $xvinc = " and rh30_vinculo in ('P','I') ";
} else {
    $dvinc = ' GERAL';
    $xvinc = '';
}


$xcampos  = " rh30_codreg ,rh30_descr";
$campos  = $xcampos;

if ($tipo == "G") {
    $xxordem = $xcampos;
    $grupo   = $xcampos;
} else {
    if ($ordem == 'a') {
        $xxordem = ' descr, codigo ';
    } else {
        $xxordem = ' codigo, descr';
    }
    if ($tipo == "L") {
        $xcampos = $campos . ', r70_estrut as codigo,r70_descr as descr ';
        $wherepes .= "and r70_estrut between '$lotaini' and '$lotafin'";
        $quebra    = "";
        $head7 = "RESUMO GERAL - LOTAÇÕES : " . $lotaini . " A " . $lotafin;
    } elseif ($tipo == "R") {
        $xcampos = $campos . ', o15_codigo as codigo, o15_descr as descr ';
        $wherepes .= "and r70_estrut between '$lotaini' and '$lotafin'";
        $grupo   = $campos . ", " . $xxordem;
        $xxordem .= ", rh30_codreg";
        $quebra    = 0;
        $head7 = "RESUMO GERAL - RECURSOS : " . $lotaini . " A " . $lotafin;
    } elseif ($tipo == "O") {
        $xcampos = $campos . ', o40_orgao as codigo, o40_descr as descr ';
        $wherepes .= "and r70_estrut between '$lotaini' and '$lotafin'";
        $grupo   = $campos . ", " . $xxordem;
        $quebra    = 0;
        $head7 = "RESUMO GERAL - ORGÃOS : " . $lotaini . " A " . $lotafin;
    } elseif ($tipo == "T") {
        $quebra    = "";
        $xcampos  = $campos . ', rh55_estrut as codigo ,rh55_descr as descr ';
        if ($lotaini != "" && $lotafin != "") {
            $wherepes .= " and rh55_estrut >= '$lotaini' and rh55_estrut <= '$lotafin' ";
        } else if ($lotaini != "") {
            $wherepes .= " and rh55_estrut >= '$lotaini' ";
        } else if ($lotafin != "") {
            $wherepes .= " and rh55_estrut >= '$lotafin' ";
        }
        $head7 = "RESUMO GERAL - LOCAL DE TRABALHO : " . $lotaini . " A " . $lotafin;
    }
    $grupo   = $campos . ',' . $xxordem;
}

if ($reg != 0) {
    $wherepes .= " and rh30_regime = " . $reg;
}

$erroajuda = "";

if ($sel != 0) {
    $result_sel = db_query("select r44_where from selecao where r44_selec = {$sel} and r44_instit = " . db_getsession('DB_instit'));
    if (pg_num_rows($result_sel) > 0) {
        db_fieldsmemory($result_sel, 0, 1);
        $wherepes .= " and " . $r44_where;
        $erroajuda = " ou seleção informada é inválida";
    }
}

//$head9    = 'FUNCIONARIOS COM INSS';
//$wherepes = " and r01_tbprev = 1 and r01_tpvinc = 'A' ";

$head1 = "RESUMO DA FOLHA DE PAGAMENTO ";
$head3 = "ARQUIVO : " . $xarquivo;
$head5 = "PERÍODO : " . $mes . " / " . $ano;
$head9 = "VINCULO : " . $dvinc;

$sql = "select 
               COUNT(DISTINCT(" . $folha . "_REGIST)) AS FUNC,
               round(sum(case when " . $folha . "_pd = 1 then " . $folha . "_valor end),2) as provento, 
               round(sum(case when " . $folha . "_pd = 2 then " . $folha . "_valor end),2) as desconto,
               $xcampos 
        from " . $arquivo . "
             inner join rhpessoalmov on rh02_anousu = " . $folha . "_anousu 
                                    and rh02_mesusu = $mes
                                    and rh02_regist = " . $folha . "_regist 
                                    and rh02_instit = " . $folha . "_instit
             inner join rhregime     on rh30_codreg = rh02_codreg 
                                    and rh30_instit = rh02_instit 
             $xvinc 
             left join rhlota        on r70_codigo = rh02_lota
                                    and r70_instit = rh02_instit
             left join (select distinct rh25_codigo,rh25_projativ, rh25_recurso from rhlotavinc where rh25_anousu = $ano ) as rhlotavinc on rh25_codigo = r70_codigo
             left  join rhlotaexe    on rh26_codigo = r70_codigo 
                                    and rh26_anousu = $ano
             left  join orcprojativ  on o55_anousu = $ano
                                    and o55_projativ = rh25_projativ
             left  join orcorgao     on o40_orgao = rh26_orgao
                                    and o40_anousu = $ano
             left join orcunidade    on o41_anousu = $ano
                                    and o41_orgao = rh26_orgao
                                    and o41_unidade = rh26_unidade
             left join orctiporec    on o15_codigo = rh25_recurso
             left join  rhpeslocaltrab on rh56_seqpes = rh02_seqpes  
			                                and rh56_princ = 't'
	           left join rhlocaltrab     on rh55_codigo = rh56_localtrab
		                                and rh55_instit = rh02_instit 
        where " . $folha . "_instit = " . db_getsession('DB_instit') . "
          and " . $folha . "_anousu = $ano
          and " . $folha . "_mesusu = $mes
          and " . $folha . "_pd <> 3
        $wherepes 
        group by $grupo 
        order by $xxordem";

// INICIO TRATAMENTO CALCULO DE EXCECAO POR RECURSO
if ($tipo == 'R' && $separar == 1) {

    // query que busca matriculas que não possuem descontos, apenas proventos
    $sqlProventosUnic = "select distinct g1." . $folha . "_regist as matriculaunic,
                                           z01_nome as servidorunic,
                                           rh02_codreg as codregimeunic,
                                           rh30_descr as descrregimeunic,
                                           rh25_recurso as recursoprovunic,
                                           o1.o15_descr as descrrecursounic,
                                           g1." . $folha . "_rubric as rubricaunic,
                                           round(g1." . $folha . "_valor,2) valorprovunic,
                                           rh74_recurso as recursoexcunic,
                                           o2.o15_descr as descrrecursoexcunic
                           from " . $arquivo . " g1
                           inner join rhpessoalmov on rhpessoalmov.rh02_anousu = " . $folha . "_anousu
                                and rhpessoalmov.rh02_mesusu = " . $folha . "_mesusu
                                and rhpessoalmov.rh02_instit = " . db_getsession('DB_instit') . "
                                and rhpessoalmov.rh02_regist = " . $folha . "_regist
                           inner join rhpessoal on rhpessoal.rh01_regist = rhpessoalmov.rh02_regist
                           inner join cgm on cgm.z01_numcgm = rhpessoal.rh01_numcgm
                           inner join rhrubricas on rhrubricas.rh27_rubric = " . $folha . "_rubric
                                and rhrubricas.rh27_instit = " . db_getsession('DB_instit') . "
                           left join rhrubelemento on rhrubelemento.rh23_rubric = rhrubricas.rh27_rubric
                                and rhrubelemento.rh23_instit = rhrubricas.rh27_instit
                           inner join rhlota on rhlota.r70_codigo = rhpessoalmov.rh02_lota
                                and rhlota.r70_instit = rhpessoalmov.rh02_instit
                           inner join rhregime on rhregime.rh30_codreg = rhpessoalmov.rh02_codreg
                                and rhregime.rh30_instit = rhpessoalmov.rh02_instit
                           left join rhempenhofolhaexcecaorubrica on rhempenhofolhaexcecaorubrica.rh74_anousu = " . $folha . "_anousu
                                and rhempenhofolhaexcecaorubrica.rh74_rubric = " . $folha . "_rubric
                                and rhempenhofolhaexcecaorubrica.rh74_instit = " . db_getsession('DB_instit') . "
                           left join orctiporec o2 on o2.o15_codigo = rhempenhofolhaexcecaorubrica.rh74_recurso
                           inner join rhlotaexe on rhlotaexe.rh26_anousu = rhpessoalmov.rh02_anousu
                                and rhlotaexe.rh26_codigo = rhlota.r70_codigo
                           inner join orcunidade on orcunidade.o41_anousu = rhlotaexe.rh26_anousu
                                and orcunidade.o41_orgao = rhlotaexe.rh26_orgao
                                and orcunidade.o41_unidade = rhlotaexe.rh26_unidade
                           inner join orcorgao on orcorgao.o40_anousu = orcunidade.o41_anousu
                                and orcorgao.o40_orgao = orcunidade.o41_orgao
                           inner join rhlotavinc on rhlotavinc.rh25_codigo = rhlotaexe.rh26_codigo
                                and rhlotavinc.rh25_anousu = rhpessoalmov.rh02_anousu
                                and rhlotavinc.rh25_vinculo = rhregime.rh30_vinculo
                           inner join orcprojativ on orcprojativ.o55_anousu = rhpessoalmov.rh02_anousu
                                and orcprojativ.o55_projativ = rhlotavinc.rh25_projativ
                           inner join orctiporec o1 on o1.o15_codigo = rhlotavinc.rh25_recurso
                           where g1." . $folha . "_pd = 1
                                and g1." . $folha . "_anousu = $ano
                                and g1." . $folha . "_mesusu = $mes
                                and g1." . $folha . "_instit = " . db_getsession('DB_instit') . "
                                and not exists (select 1 from " . $arquivo . " g2
                                                where g2." . $folha . "_pd = 2
                                                    and g2." . $folha . "_regist = g1." . $folha . "_regist
                                                    and g2." . $folha . "_anousu = $ano
                                                    and g2." . $folha . "_mesusu = $mes
                                                    and g2." . $folha . "_instit = " . db_getsession('DB_instit') . ")
                           group by g1." . $folha . "_regist,
                                    z01_nome,
                                    rh02_codreg,
                                    rh30_descr,
                                    rh25_recurso,
                                    o1.o15_descr,
                                    g1." . $folha . "_rubric,
                                    g1." . $folha . "_valor,
                                    rh74_recurso,
                                    o2.o15_descr
                           order by g1." . $folha . "_regist;";
    $resultProvUnic = db_query($sqlProventosUnic);

    $aDadosUnic = array();

    for ($x = 0; $x < pg_num_rows($resultProvUnic); $x++) {
        db_fieldsmemory($resultProvUnic, $x);

        $objUnic = new stdClass();
        $objUnic->matricula = $matriculaunic . $rubricaunic . $x;
        $objUnic->nome = $servidorunic;
        $objUnic->codregime = $codregimeunic;
        $objUnic->descrregime = $descrregimeunic;
        $objUnic->rubrica = $rubricaunic;
        $objUnic->totalproventosfinal = $valorprovunic;
        $objUnic->recurso = $recursoprovunic;
        $objUnic->descricaorecurso = $descrrecursounic;
        $objUnic->recursoexc = $recursoexcunic;
        $objUnic->descrrecursoexc = $descrrecursoexcunic;
        $objUnic->valordescfinal = 0;
        if ($objUnic->recursoexc != null || $objUnic->recursoexc != 0) {
            $objUnic->valorprovexc = $valorprovunic;
            $objUnic->totalproventosfinal = 0;
            $objUnic->recurso = null;
            $objUnic->descricaorecurso = null;
        }

        $aDadosUnic[] = $objUnic;
    }

    // query dos descontos por matricula
    $sqlDescontos = "select distinct " . $folha . "_regist as matricula,
                        z01_nome as servidor,
                        rh02_codreg as codregime,
                        rh30_descr as descrregime,
                        rh25_recurso as recursodesconto,
                        o15_descr as descrrecurso,
                        " . $folha . "_rubric as rubricadesconto,
                        round(sum(" . $folha . "_valor),2) as valordesconto,
                        (case when rh23_rubric is null then 'f' else 't' end) as descontoemp
                from " . $arquivo . "
                inner join rhpessoalmov on rhpessoalmov.rh02_anousu = " . $folha . "_anousu
                    and rhpessoalmov.rh02_mesusu = " . $folha . "_mesusu
                    and rhpessoalmov.rh02_instit = " . db_getsession('DB_instit') . "
                    and rhpessoalmov.rh02_regist = " . $folha . "_regist
                inner join rhpessoal on rhpessoal.rh01_regist = rhpessoalmov.rh02_regist
                inner join cgm on cgm.z01_numcgm = rhpessoal.rh01_numcgm
                inner join rhrubricas on rhrubricas.rh27_rubric = " . $folha . "_rubric
                    and rhrubricas.rh27_instit = " . db_getsession('DB_instit') . "
                left join rhrubelemento on rhrubelemento.rh23_rubric = rhrubricas.rh27_rubric
                    and rhrubelemento.rh23_instit = rhrubricas.rh27_instit
                inner join rhlota on rhlota.r70_codigo = rhpessoalmov.rh02_lota
                    and rhlota.r70_instit = rhpessoalmov.rh02_instit
                inner join rhregime on rhregime.rh30_codreg = rhpessoalmov.rh02_codreg
                    and rhregime.rh30_instit = rhpessoalmov.rh02_instit
                inner join rhlotaexe on rhlotaexe.rh26_anousu = rhpessoalmov.rh02_anousu
                    and rhlotaexe.rh26_codigo = rhlota.r70_codigo
                inner join orcunidade on orcunidade.o41_anousu = rhlotaexe.rh26_anousu
                    and orcunidade.o41_orgao = rhlotaexe.rh26_orgao
                    and orcunidade.o41_unidade = rhlotaexe.rh26_unidade
                inner join orcorgao on orcorgao.o40_anousu = orcunidade.o41_anousu
                    and orcorgao.o40_orgao = orcunidade.o41_orgao
                inner join rhlotavinc on rhlotavinc.rh25_codigo = rhlotaexe.rh26_codigo
                    and rhlotavinc.rh25_anousu = rhpessoalmov.rh02_anousu
                    and rhlotavinc.rh25_vinculo = rhregime.rh30_vinculo
                inner join orcprojativ on orcprojativ.o55_anousu = rhpessoalmov.rh02_anousu
                    and orcprojativ.o55_projativ = rhlotavinc.rh25_projativ
                inner join orctiporec o1 on o1.o15_codigo = rhlotavinc.rh25_recurso
                where rhpessoalmov.rh02_anousu = $ano
                    and rhpessoalmov.rh02_mesusu = $mes
                    and " . $arquivo . "." . $folha . "_pd = 2
                    and " . $arquivo . "." . $folha . "_instit = " . db_getsession('DB_instit') . "
                group by rh25_recurso,
                         z01_nome,
                         o15_descr,
                         " . $folha . "_rubric,
                         " . $folha . "_regist,
                         rh02_codreg,
                         rh30_descr,
                         descontoemp
                order by " . $folha . "_regist,
                         " . $folha . "_rubric,
                         rh25_recurso";

    $resultDesc = db_query($sqlDescontos);

    // armazenando matriculas com desconto de empenho e seus valores
    $aDescMatricula = array();

    for ($n = 0; $n < pg_num_rows($resultDesc); $n++) {
        db_fieldsmemory($resultDesc, $n);

        if ($descontoemp == 't') {
            $objDescEmp = new stdClass();
            $objDescEmp->matricula = $matricula;
            $objDescEmp->valordescontoempenho = $valordesconto;
            $aDescMatricula[] = $objDescEmp;
        }
    }

    $aDadosMatricula = array();

    for ($x = 0; $x < pg_num_rows($resultDesc); $x++) {
        db_fieldsmemory($resultDesc, $x);

        // query dos proventos que não entram no calculo da excecao, mas agrupam no total do provento do recurso
        $sqlProventosExtra = "select " . $folha . "_rubric as rubricaprovextra,
                                 round(" . $folha . "_valor, 2) as valorproventoextra
                                 from $arquivo
                                 inner join rhpessoalmov on rhpessoalmov.rh02_anousu = " . $folha . "_anousu
                                    and rhpessoalmov.rh02_mesusu = " . $folha . "_mesusu
                                    and rhpessoalmov.rh02_instit = " . db_getsession('DB_instit') . "
                                    and rhpessoalmov.rh02_regist = " . $folha . "_regist
                                inner join rhrubricas on rhrubricas.rh27_rubric = " . $folha . "_rubric
                                    and rhrubricas.rh27_instit = " . db_getsession('DB_instit') . "
                                left join rhrubelemento on rhrubelemento.rh23_rubric = rhrubricas.rh27_rubric
                                    and rhrubelemento.rh23_instit = rhrubricas.rh27_instit
                                where rhpessoalmov.rh02_anousu = $ano
                                    and rhpessoalmov.rh02_mesusu = $mes
                                    and rh23_rubric is null
                                    and " . $folha . "_pd = 1
                                    and " . $folha . "_regist = $matricula
                                    and " . $arquivo . "." . $folha . "_instit = " . db_getsession('DB_instit') . "
                                group by " . $folha . "_rubric,
                                " . $folha . "_valor";

        $rsProvExt = db_query($sqlProventosExtra);

        // query dos proventos por matricula
        $sqlProventos = "select " . $folha . "_regist as matriculaprov,
                                " . $folha . "_rubric as rubricaprov,
                                round(sum(case when " . $folha . "_pd = 1 then " . $folha . "_valor else 0 end),2) as valorprovento,
                                /*round(sum(case when " . $folha . "_pd = 2 then " . $folha . "_valor else 0 end),2) as valordescontoemp,*/
                                rh74_recurso as recursoexc,
                                o2.o15_descr as descrrecursoexc
                        from $arquivo
                        inner join rhpessoalmov on rhpessoalmov.rh02_anousu = " . $folha . "_anousu
                            and rhpessoalmov.rh02_mesusu = " . $folha . "_mesusu
                            and rhpessoalmov.rh02_instit = " . db_getsession('DB_instit') . "
                            and rhpessoalmov.rh02_regist = " . $folha . "_regist
                        inner join rhrubricas on rhrubricas.rh27_rubric = " . $folha . "_rubric
                            and rhrubricas.rh27_instit = " . db_getsession('DB_instit') . "
                        inner join rhrubelemento on rhrubelemento.rh23_rubric = rhrubricas.rh27_rubric
                            and rhrubelemento.rh23_instit = rhrubricas.rh27_instit
                        inner join rhlota on rhlota.r70_codigo = rhpessoalmov.rh02_lota
                            and rhlota.r70_instit = rhpessoalmov.rh02_instit
                        inner join rhregime on rhregime.rh30_codreg = rhpessoalmov.rh02_codreg
                            and rhregime.rh30_instit = rhpessoalmov.rh02_instit
                        left join rhempenhofolhaexcecaorubrica on rhempenhofolhaexcecaorubrica.rh74_anousu = " . $folha . "_anousu
                            and rhempenhofolhaexcecaorubrica.rh74_rubric = " . $folha . "_rubric
                            and rhempenhofolhaexcecaorubrica.rh74_instit = " . db_getsession('DB_instit') . "
                        left join orctiporec o2 on o2.o15_codigo = rhempenhofolhaexcecaorubrica.rh74_recurso
                        inner join rhlotaexe on rhlotaexe.rh26_anousu = rhpessoalmov.rh02_anousu
                            and rhlotaexe.rh26_codigo = rhlota.r70_codigo
                        inner join orcunidade on orcunidade.o41_anousu = rhlotaexe.rh26_anousu
                            and orcunidade.o41_orgao = rhlotaexe.rh26_orgao
                            and orcunidade.o41_unidade = rhlotaexe.rh26_unidade
                        inner join orcorgao on orcorgao.o40_anousu = orcunidade.o41_anousu
                            and orcorgao.o40_orgao = orcunidade.o41_orgao
                        inner join rhlotavinc on rhlotavinc.rh25_codigo = rhlotaexe.rh26_codigo
                            and rhlotavinc.rh25_anousu = rhpessoalmov.rh02_anousu
                            and rhlotavinc.rh25_vinculo = rhregime.rh30_vinculo
                        inner join orcprojativ on orcprojativ.o55_anousu = rhpessoalmov.rh02_anousu
                            and orcprojativ.o55_projativ = rhlotavinc.rh25_projativ
                        inner join orctiporec o1 on o1.o15_codigo = rhlotavinc.rh25_recurso
                        where rhpessoalmov.rh02_anousu = $ano
                            and rhpessoalmov.rh02_mesusu = $mes
                            and rh23_rubric is not null
                            and " . $folha . "_regist = $matricula
                            and " . $arquivo . "." . $folha . "_instit = " . db_getsession('DB_instit') . "
                            and " . $folha . "_pd <> 3
                        group by " . $folha . "_rubric,
                                 o1.o15_codigo,
                                 " . $folha . "_regist,
                                 rh74_recurso,
                                 o2.o15_descr
                        order by " . $folha . "_regist,
                                 " . $folha . "_rubric";

        $rsProv = db_query($sqlProventos);

        // armazenando os dados das querys por matricula
        $objMatricula = new stdClass();
        $objMatricula->matricula = $matricula;
        $objMatricula->nome = $servidor;
        $objMatricula->codregime = $codregime;
        $objMatricula->descrregime = $descrregime;
        $objMatricula->rubrica = $rubricadesconto;
        $objMatricula->valordesc = $valordesconto;
        $objMatricula->recurso = $recursodesconto;
        $objMatricula->recursoreg = $recursodesconto . " - " . $codregime;
        $objMatricula->recursorubric = $recursodesconto . " - " . $rubricadesconto;
        $objMatricula->descricaorecurso = $descrrecurso;
        $objMatricula->proventos = db_utils::getCollectionByRecord($rsProv);
        $objMatricula->proventosextra = db_utils::getCollectionByRecord($rsProvExt);
        foreach ($aDescMatricula as $matDesconto) {
            if ($matDesconto->matricula == $objMatricula->matricula) {
                $objMatricula->valordescontoempenho += $matDesconto->valordescontoempenho;
            }
        }
        $objMatricula->descontoempenho = "nao";
        if ($descontoemp == 't') {
            $objMatricula->descontoempenho = "sim";
        }

        $valorprovento = 0;
        $valorprovexc = 0;

        foreach (db_utils::getCollectionByRecord($rsProv) as $key => $provento) {

            $valorprovento += $provento->valorprovento;
            $objMatricula->somaproventos = $valorprovento;
            $objMatricula->totalproventosfinal = $objMatricula->somaproventos;
            if ($provento->recursoexc != null) {
                $valorprovexc = $provento->valorprovento;
                $objMatricula->proventoexc += $valorprovexc;
            }
        }
        $aDadosMatricula[] = $objMatricula;
    }

    // efetuando o calculo das excecoes por matricula e rubrica de desconto
    $aMatriculaDescEmp = array();
    $aSomaDescEmp = array();

    foreach ($aDadosMatricula as $dado) {
        $matricula = $dado->matricula;

        $dado->valordescfinal = $dado->valordesc;

        $percentualexc = 0;
        $valorexcecao = 0;
        $sumvalorexcecao = 0;

        foreach ($dado->proventos as $calcexc) {
            if ($calcexc->recursoexc != null || $calcexc->recursoexc != "") {
                if ($dado->descontoempenho != "sim") {
                    $percentualexc = $calcexc->valorprovento / ($dado->totalproventosfinal - $dado->valordescontoempenho) * 100;
                    $valorexcecao  = $dado->valordesc * $percentualexc / 100;
                    $sumvalorexcecao += $valorexcecao;
                    $dado->valorexcecaoformat = round($sumvalorexcecao, 2);
                }
                $dado->recursoexcecao = $calcexc->recursoexc;
                $dado->descrrecursoexc = $calcexc->descrrecursoexc;
            }
            $dado->valordescfinal = $dado->valordesc - $dado->valorexcecaoformat;
        }

        foreach ($dado->proventosextra as $provextra) {
            if ($provextra->rubricaprovextra != null || $provextra->rubricaprovextra != "") {
                $somaprovextra = $provextra->valorproventoextra;
                $dado->totalproventosfinal = $dado->totalproventosfinal + $somaprovextra;
            }
        }

        $aMatriculaDescEmp[] = $matricula;
    }

    //verificação por recurso e rubrica
    //foreach ($aDadosMatricula as $w) {
    //    if ($w->recursorubric == "15000002 - 0400") {
    //        echo $w->matricula . " => " . $w->valordescfinal . "<br>";
    //    }
    //}die;

    // agrupa arrays das matriculas com as matriculas que só possuem proventos
    $aDadosMatricula = array_merge($aDadosMatricula, $aDadosUnic);

    // agrupa dados por recurso e exceção
    $aRecurso = array();
    $ultimamatricula = null;

    foreach ($aDadosMatricula as $item) {
        $key = $item->recurso . '|' . $item->codregime;
        if (!isset($aRecurso[$key])) {
            $aRecurso[$key] = (object) array(
                'recurso' => $item->recurso,
                'descricaorecurso' => $item->descricaorecurso,
                'codregime' => $item->codregime,
                'descrregime' => $item->descrregime,
                'valordescfinal' => $item->valordescfinal,
            );

            if (($ultimamatricula !== null || $ultimamatricula !== 0) && $ultimamatricula !== $item->matricula) {
                $aRecurso[$key]->valorprovfinal = $item->totalproventosfinal - $item->proventoexc;
            }
        } else {
            $aRecurso[$key]->valordescfinal += $item->valordescfinal;
            if (($ultimamatricula !== null || $ultimamatricula !== 0) && $ultimamatricula !== $item->matricula) {
                $aRecurso[$key]->valorprovfinal += $item->totalproventosfinal - $item->proventoexc;
            }
        }

        if ($item->recursoexcecao !== null) {
            $keyExcecao = $item->recursoexcecao . '|' . $item->codregime;
            if (!isset($aRecurso[$keyExcecao])) {
                $aRecurso[$keyExcecao] = (object) array(
                    'recurso' => $item->recursoexcecao,
                    'descricaorecurso' => $item->descrrecursoexc,
                    'codregime' => $item->codregime,
                    'descrregime' => $item->descrregime,
                    'valordescfinal' => $item->valorexcecaoformat,
                );
                if (($ultimamatricula !== null || $ultimamatricula !== 0) && $ultimamatricula !== $item->matricula) {
                    $aRecurso[$keyExcecao]->valorprovfinal = $item->proventoexc;
                }
            } else {
                $aRecurso[$keyExcecao]->valordescfinal += $item->valorexcecaoformat;
                if (($ultimamatricula !== null || $ultimamatricula !== 0) && $ultimamatricula !== $item->matricula) {
                    $aRecurso[$keyExcecao]->valorprovfinal += $item->proventoexc;
                }
            }
        }
        $ultimamatricula = $item->matricula;
    }

    $aResult = array();

    // agrupa array por recurso e separa por codreg
    foreach ($aRecurso as $key => $dados) {
        $chaverecurso = $dados->recurso . " - " . $dados->descricaorecurso;
        $aResult[$chaverecurso][$dados->codregime] = $dados;
    }

    // ordena array pelo recurso
    ksort($aResult);

    function ordenaRegime($a, $b)
    {
        // Comparar o campo codregime
        return $a->codregime - $b->codregime;
    }

    foreach ($aResult as &$aRegime) {
        // ordena pelo codigo do regime
        uasort($aRegime, 'ordenaRegime');
    }
}

$result = db_query($sql);

$xxnum = pg_num_rows($result);
if ($xxnum == 0) {
    db_redireciona('db_erros.php?fechar=true&db_erro=Não existem lançamentos no período de ' . $mes . ' / ' . $ano . $erroajuda . ".");
}

if ($tipo == 'R' && $separar == 1) {
    $xxnum = pg_num_rows($resultDesc);
    if ($xxnum == 0) {
        db_redireciona('db_erros.php?fechar=true&db_erro=Nao existem lancamentos no periodo de ' . $mes . ' / ' . $ano . $erroajuda . ".");
    }
}

$pdf = new PDF();
$pdf->Open();
$pdf->AliasNbPages();
$pdf->setfillcolor(235);
$alt = 4;

$venc        = 0;
$desc        = 0;
$total_func  = 0;
$venc_g      = 0;
$desc_g      = 0;
$total_func_g = 0;
$troca       = 1;

//emitir dados apenas quando for por recurso e com exceção sim
if ($tipo == 'R' && $separar == 1) {
    foreach ($aResult as $recurso => $codregimes) {
        if ($pdf->gety() > $pdf->h - 30 || $troca != 0) {
            $pdf->addpage();
            $pdf->setfont('arial', 'b', 8);
            $pdf->cell(20, $alt, 'VINCULO', 1, 0, "C", 1);
            $pdf->cell(80, $alt, 'DESCRIÇÃO', 1, 0, "C", 1);
            $pdf->cell(30, $alt, 'PROVENTOS', 1, 0, "C", 1);
            $pdf->cell(30, $alt, 'DESCONTOS', 1, 0, "C", 1);
            $pdf->cell(30, $alt, 'LÍQUIDO', 1, 1, "C", 1);
            $troca = 0;
        }

        $pdf->ln(2);
        $pdf->setfont('arial', 'b', 8);
        $pdf->cell(190, 5, $recurso, 0, 1, "L", 1);

        $totalrecursoprov = 0;
        $totalrecursodesc = 0;

        foreach ($codregimes as $codregime => $dado) {
            $pdf->setfont('arial', '', 7);
            $pdf->cell(20, $alt, $codregime, 0, 0, "C", 0);
            $pdf->cell(80, $alt, $dado->descrregime, 0, 0, "L", 0);
            $pdf->cell(30, $alt, db_formatar($dado->valorprovfinal, 'f'), 0, 0, "R", 0);
            $pdf->cell(30, $alt, db_formatar($dado->valordescfinal, 'f'), 0, 0, "R", 0);
            $pdf->cell(30, $alt, db_formatar($dado->valorprovfinal - $dado->valordescfinal, 'f'), 0, 1, "R", 0);

            $totalrecursoprov += $dado->valorprovfinal;
            $totalrecursodesc += $dado->valordescfinal;
            $totalgeralprov += $dado->valorprovfinal;
            $totalgeraldesc += $dado->valordescfinal;
        }
        $pdf->setfont('arial', 'b', 7);
        $pdf->cell(100, $alt, 'Sub Total', 0, 0, "L", 0);
        $pdf->cell(30, $alt, db_formatar($totalrecursoprov, 'f'), 0, 0, "R", 0);
        $pdf->cell(30, $alt, db_formatar($totalrecursodesc, 'f'), 0, 0, "R", 0);
        $pdf->cell(30, $alt, db_formatar($totalrecursoprov - $totalrecursodesc, 'f'), 0, 1, "R", 0);
    }
    $pdf->setfont('arial', 'B', 8);
    $pdf->cell(100, $alt, 'Total Geral', 0, 0, "L", 0);
    $pdf->cell(30, $alt, db_formatar($totalgeralprov, 'f'), 0, 0, "R", 0);
    $pdf->cell(30, $alt, db_formatar($totalgeraldesc, 'f'), 0, 0, "R", 0);
    $pdf->cell(30, $alt, db_formatar($totalgeralprov - $totalgeraldesc, 'f'), 0, 1, "R", 0);

    $pdf->Output();
} else {

    for ($x = 0; $x < pg_num_rows($result); $x++) {
        db_fieldsmemory($result, $x);
        if ($pdf->gety() > $pdf->h - 30 || $troca != 0) {
            $pdf->addpage();
            $pdf->setfont('arial', 'b', 8);
            $pdf->cell(20, $alt, 'VINCULO', 1, 0, "C", 1);
            $pdf->cell(80, $alt, 'DESCRIÇÃO', 1, 0, "C", 1);
            $pdf->cell(15, $alt, 'QUANT.', 1, 0, "C", 1);
            $pdf->cell(25, $alt, 'PROVENTOS', 1, 0, "C", 1);
            $pdf->cell(25, $alt, 'DESCONTOS', 1, 0, "C", 1);
            $pdf->cell(25, $alt, 'LÍQUIDO', 1, 1, "C", 1);
            $troca = 0;
        }
        if ($tipo != "G") {
            if ($quebra != $codigo) {
                if ($x > 0) {
                    $pdf->setfont('arial', 'B', 7);
                    $pdf->cell(100, $alt, 'Sub Total', 0, 0, "L", 0);
                    $pdf->cell(15, $alt, $total_func, 0, 0, "C", 0);
                    $pdf->cell(25, $alt, db_formatar($venc, 'f'), 0, 0, "R", 0);
                    $pdf->cell(25, $alt, db_formatar($desc, 'f'), 0, 0, "R", 0);
                    $pdf->cell(25, $alt, db_formatar($venc - $desc, 'f'), 0, 1, "R", 0);
                    $venc        = 0;
                    $desc        = 0;
                    $total_func  = 0;
                }
                $quebra = $codigo;
                $pdf->ln(2);
                $pdf->setfont('arial', 'B', 8);
                $pdf->cell(190, 5, $codigo . " - " . strtoupper($descr), 0, 1, "L", 1);
            }
        }
        $pdf->setfont('arial', '', 7);
        $pdf->cell(20, $alt, $rh30_codreg, 0, 0, "C", 0);
        $pdf->cell(80, $alt, $rh30_descr, 0, 0, "L", 0);
        $pdf->cell(15, $alt, $func, 0, 0, "C", 0);
        $pdf->cell(25, $alt, db_formatar($provento, 'f'), 0, 0, "R", 0);
        $pdf->cell(25, $alt, db_formatar($desconto, 'f'), 0, 0, "R", 0);
        $pdf->cell(25, $alt, db_formatar($provento - $desconto, 'f'), 0, 1, "R", 0);
        $venc        += $provento;
        $desc        += $desconto;
        $total_func  += $func;
        $venc_g      += $provento;
        $desc_g      += $desconto;
        $total_func_g += $func;
    }
    if ($tipo != "G") {
        $pdf->setfont('arial', 'B', 7);
        $pdf->cell(100, $alt, 'Sub Total', 0, 0, "L", 0);
        $pdf->cell(15, $alt, $total_func, 0, 0, "C", 0);
        $pdf->cell(25, $alt, db_formatar($venc, 'f'), 0, 0, "R", 0);
        $pdf->cell(25, $alt, db_formatar($desc, 'f'), 0, 0, "R", 0);
        $pdf->cell(25, $alt, db_formatar($venc - $desc, 'f'), 0, 1, "R", 0);
    }
    $pdf->setfont('arial', 'B', 8);
    $pdf->cell(100, $alt, 'Total Geral', 0, 0, "L", 0);
    $pdf->cell(15, $alt, $total_func_g, 0, 0, "C", 0);
    $pdf->cell(25, $alt, db_formatar($venc_g, 'f'), 0, 0, "R", 0);
    $pdf->cell(25, $alt, db_formatar($desc_g, 'f'), 0, 0, "R", 0);
    $pdf->cell(25, $alt, db_formatar($venc_g - $desc_g, 'f'), 0, 1, "R", 0);
    $pdf->Output();
}
