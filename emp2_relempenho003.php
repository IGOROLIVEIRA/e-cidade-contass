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
include("libs/db_liborcamento.php");
include("classes/db_empempenho_classe.php");
include("classes/db_cgm_classe.php");
include("classes/db_orctiporec_classe.php");
include("classes/db_orcdotacao_classe.php");
include("classes/db_orcorgao_classe.php");
include("classes/db_empemphist_classe.php");
include("classes/db_emphist_classe.php");
include("classes/db_orcelemento_classe.php");
include("classes/db_conlancamemp_classe.php");
include("classes/db_conlancamdoc_classe.php");
include("classes/db_empempitem_classe.php");
include("classes/db_empresto_classe.php");
include("classes/db_empelemento_classe.php");

//db_postmemory($HTTP_POST_VARS,2);exit;
db_postmemory($HTTP_POST_VARS);
//db_postmemory($HTTP_SERVER_VARS,2);exit;
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);

/// Para o caso de ter filtro de Gestores
$lSepararGestor = $agrupar === 'gest' ? true : false;
$sGestorAtual   = "";


$clselorcdotacao = new cl_selorcdotacao();
$clorcelemento   = new cl_orcelemento;
$clemphist       = new cl_emphist;
$clconlancamemp  = new cl_conlancamemp;
$clconlancamdoc  = new cl_conlancamdoc;
$clempempenho    = new cl_empempenho;
$clcgm           = new cl_cgm;
$clorctiporec    = new cl_orctiporec;
$clorcdotacao    = new cl_orcdotacao;
$clorcorgao      = new cl_orcorgao;
$clempemphist    = new cl_empemphist;
$clempempitem    = new cl_empempitem;
$clempresto      = new cl_empresto;
$clempelemento   = new cl_empelemento;

$clorcelemento->rotulo->label();
$clemphist->rotulo->label();
$clempemphist->rotulo->label();
$clempempenho->rotulo->label();
$clcgm->rotulo->label();
$clorctiporec->rotulo->label();
$clorcdotacao->rotulo->label();
$clorcorgao->rotulo->label();
$clempelemento->rotulo->label();
$clrotulo = new rotulocampo;

$tipo = "a"; // sempre analitico

$clselorcdotacao->setDados($filtra_despesa); // passa os parametros vindos da func_selorcdotacao_abas.php

$instits = str_replace('-', ', ', $db_selinstit);

$sele_work = $clselorcdotacao->getDados(false);

$sele_desdobramentos = "";
$desdobramentos = $clselorcdotacao->getDesdobramento(); // coloca os codele dos desdobramntos no formato (x,y,z)
if ($desdobramentos != "") {
    $sele_desdobramentos = " and empelemento.e64_codele in " . $desdobramentos; // adiciona desdobramentos
}

//////////////////////////////////////////////////////////////////

$resultinst = pg_exec("select munic from db_config where codigo in (" . str_replace('-', ', ', $db_selinstit) . ") ");
db_fieldsmemory($resultinst, 0);

$head1 = "MUNICPIO DE " . strtoupper($munic);

//////////////////////////////////////////////////////////////////

$clrotulo->label("pc50_descr");

//////////////////////////////////////////////////////////////////

$sCamposPosicaoAtual  = "distinct e60_numemp, to_number(e60_codemp::text,'9999999999') as e60_codemp, e60_resumo, e60_emiss";
$sCamposPosicaoAtual .= ", e60_numcgm, z01_nome, z01_cgccpf, z01_munic, e60_vlremp, e60_vlranu, e60_vlrliq, e63_codhist, e40_descr";
$sCamposPosicaoAtual .= ", e60_vlrpag, e60_anousu, e60_coddot, o58_coddot, o58_orgao, o40_orgao, o40_descr, o58_unidade, o41_descr";
$sCamposPosicaoAtual .= ", o15_codigo, o15_descr, fc_estruturaldotacao(e60_anousu,e60_coddot) as dl_estrutural, e60_codcom";
$sCamposPosicaoAtual .= ", pc50_descr,e60_concarpeculiar,e60_numerol,e54_gestaut,descrdepto,e94_empanuladotipo,e38_descr";

//---------
// monta sql
$sWhereSQL = "e60_instit in ( $instits )";
if ($listaitem != "") {
    if (isset($veritem) and $veritem == "com") {
        $sWhereSQL = $sWhereSQL . " and e62_item in  ($listaitem)";
    } else {
        $sWhereSQL = $sWhereSQL . " and e62_item not in  ($listaitem)";
    }
}
$sValoresEmpenho = "";
if ($nValorEmpenhoInicial != "") {

    $nValorEmpenhoInicial  = str_replace(',', '.', $nValorEmpenhoInicial);
    $sValoresEmpenho      .= " and e60_vlremp >= {$nValorEmpenhoInicial} ";
}
if ($nValorEmpenhoFinal != "") {
    $nValorEmpenhoFinal  = str_replace(',', '.', $nValorEmpenhoFinal);
    $sValoresEmpenho    .= " and e60_vlremp <= {$nValorEmpenhoFinal} ";
}


if ($listasub != "") {
    $resultado = pg_exec("select pc01_codmater from pcmater where pc01_codsubgrupo in ($listasub)");

    if (pg_numrows($resultado) > 0) {
        $virgula = "";
        $listar  = "";
        for ($i = 0; $i < pg_numrows($resultado); $i++) {
            db_fieldsmemory($resultado, $i);
            $listar  .= $virgula . $pc01_codmater;
            $virgula  = ", ";
        }

        if (isset($veritem) and $veritem == "com") {
            $sWhereSQL = $sWhereSQL . " and e62_item in  ($listar)";
        } else {
            $sWhereSQL = $sWhereSQL . " and e62_item not in  ($listar)";
        }
    } else {
        $listasub = "";
    }
}
if ($listacredor != "") {
    if (isset($ver) and $ver == "com") {
        $sWhereSQL = $sWhereSQL . " and e60_numcgm in  ($listacredor)";
    } else {
        $sWhereSQL = $sWhereSQL . " and e60_numcgm not in  ($listacredor)";
    }
}
if ($listahist != "") {
    if (isset($verhist) and $verhist == "com") {
        $sWhereSQL = $sWhereSQL . " and e63_codhist in  ($listahist)";
    } else {
        $sWhereSQL = $sWhereSQL . " and e63_codhist not in  ($listahist)";
    }
}
if ($listaevento != "") {
    if (isset($verhist) && $verhist == "com") {
        $sWhereSQL = $sWhereSQL . " and e60_codtipo in ($listaevento)";
    } else {
        $sWhereSQL = $sWhereSQL . " and e60_codtipo not in ($listaevento)";
    }
}
if ($listatipoanulacao != "") {
    if (isset($verhist) && $verhist == "com") {
        $sWhereSQL = $sWhereSQL . " and e94_empanuladotipo in ($listatipoanulacao)";
    }
}

if ($listacom != "") {
    if (isset($vercom) and $vercom == "com") {
        $sWhereSQL = $sWhereSQL . " and e60_codcom in  ($listacom)";
    } else {
        $sWhereSQL = $sWhereSQL . " and e60_codcom not in  ($listacom)";
    }
}

if ($listalicita != "") {
    if (isset($vercom) and $vercom == "com") {
        $sWhereSQL = $sWhereSQL . " and empempenho.e60_numerol IN (select l20_numero::varchar ||'/'|| l20_anousu::varchar as ano from liclicita where l20_codigo in  ($listalicita))";

        $sWhereSQL = $sWhereSQL . " AND empempenho.e60_codcom IN
    (SELECT l03_codcom
     FROM liclicita join cflicita on l03_codigo = l20_codtipocom
     WHERE l20_codigo IN ($listalicita))";
    } else {
        $sWhereSQL = $sWhereSQL . " and empempenho.e60_numerol IN (select l20_numero::varchar ||'/'|| l20_anousu::varchar as ano from liclicita where l20_codigo not in  ($listalicita))";

        $sWhereSQL = $sWhereSQL . " AND empempenho.e60_codcom IN
    (SELECT l03_codcom
     FROM liclicita join cflicita on l03_codigo = l20_codtipocom
     WHERE l20_codigo NOT IN ($listalicita))";
    }
}

if (($datacredor != "--") && ($datacredor1 != "--")) {
    $sWhereSQL = $sWhereSQL . " and e60_emiss between '$datacredor' and '$datacredor1'  ";
    $info = "De " . db_formatar($datacredor, "d") . " at " . db_formatar($datacredor1, "d") . ".";
} else
    if ($datacredor != "--") {
    $sWhereSQL = $sWhereSQL . " and e60_emiss >= '$datacredor'  ";
    $info = "Apartir de " . db_formatar($datacredor, "d") . ".";
} else
        if ($datacredor1 != "--") {
    $sWhereSQL = $sWhereSQL . "    e60_emiss <= '$datacredor1'   ";
    $info = "At " . db_formatar($datacredor1, "d") . ".";
}

if ($tipoemp == "todos") {
    $sWhereSQL = $sWhereSQL . " ";
} elseif ($tipoemp == "somemp") {
    $sWhereSQL = $sWhereSQL . " and (round(yyy.e60_vlremp,2) - round(yyy.e60_vlranu,2) > 0) and round(yyy.e60_vlrliq,2) = 0 ";
} elseif ($tipoemp == "saldo") {
    // com saldo a pagar geral
    $sWhereSQL = $sWhereSQL . " and (round(round(yyy.e60_vlremp,2) - round(yyy.e60_vlranu,2),2) - round(yyy.e60_vlrpag,2) > 0 ) ";
} elseif ($tipoemp == "saldoliq") {
    $sWhereSQL = $sWhereSQL . " and (round(yyy.e60_vlrliq,2) - round(yyy.e60_vlrpag,2) > 0) and round(yyy.e60_vlrliq,2) > 0";
} elseif ($tipoemp == "saldonaoliq") {
    //	$sWhereSQL = $sWhereSQL." and (round(yyy.e60_vlrliq,2) - round(yyy.e60_vlrpag,2) > 0) and round(yyy.e60_vlrliq,2) = 0";
    $sWhereSQL = $sWhereSQL . " and (round(yyy.e60_vlremp,2) - round(yyy.e60_vlranu,2) - round(yyy.e60_vlrliq,2) > 0)";
} elseif ($tipoemp == "anul") {
    $sWhereSQL = $sWhereSQL . " and round(yyy.e60_vlranu,2) > 0 ";
} elseif ($tipoemp == "anultot") {
    $sWhereSQL = $sWhereSQL . " and round(yyy.e60_vlremp,2) = round(yyy.e60_vlranu,2)";
} elseif ($tipoemp == "anulparc") {
    $sWhereSQL = $sWhereSQL . " and round(yyy.e60_vlranu,2) > 0 and round(yyy.e60_vlremp,2) <> round(yyy.e60_vlranu,2)";
} elseif ($tipoemp == "anulsem") {
    $sWhereSQL = $sWhereSQL . " and round(yyy.e60_vlranu,2) = 0";
} elseif ($tipoemp == "liq") {
    $sWhereSQL = $sWhereSQL . " and round(yyy.e60_vlrliq,2) > 0";
} elseif ($tipoemp == "liqtot") {
    $sWhereSQL = $sWhereSQL . " and ((round(yyy.e60_vlremp,2) - round(yyy.e60_vlranu,2)) = round(yyy.e60_vlrliq,2))";
} elseif ($tipoemp == "liqparc") {
    $sWhereSQL = $sWhereSQL . " and round(yyy.e60_vlrliq,2) > 0 and ((round(yyy.e60_vlremp,2) - round(yyy.e60_vlranu,2)) <> round(yyy.e60_vlrliq,2))";
} elseif ($tipoemp == "liqsem") {
    $sWhereSQL = $sWhereSQL . " and round(yyy.e60_vlrliq,2) = 0";
} elseif ($tipoemp == "pag") {
    $sWhereSQL = $sWhereSQL . " and round(yyy.e60_vlrpag,2) > 0 ";
} elseif ($tipoemp == "pagtot") {
    $sWhereSQL = $sWhereSQL . " and round(yyy.e60_vlrpag,2) > 0 and (round(yyy.e60_vlrliq,2) = round(yyy.e60_vlrpag,2))";
} elseif ($tipoemp == "pagparc") {
    $sWhereSQL = $sWhereSQL . " and round(yyy.e60_vlrpag,2) > 0 and (round(yyy.e60_vlrliq,2) <> round(yyy.e60_vlrpag,2))";
} elseif ($tipoemp == "pagsem") {
    $sWhereSQL = $sWhereSQL . " and round(yyy.e60_vlrpag,2) = 0";
} elseif ($tipoemp == "pagsemcomliq") {
    $sWhereSQL = $sWhereSQL . " and round(yyy.e60_vlrpag,2) = 0 and round(yyy.e60_vlrliq,2) > 0";
}

if ($emptipo != 0) {
    $sWhereSQL = $sWhereSQL . " and e60_codtipo = {$emptipo} ";
}


if (isset($listaconcarpeculiar) && $listaconcarpeculiar != "") {

    $listaconcarpeculiar = "'" . str_replace(",", "','", $listaconcarpeculiar) . "'";

    if (isset($verconcarpeculiar) && $verconcarpeculiar == "com") {
        $sWhereSQL = $sWhereSQL . " and e60_concarpeculiar in ($listaconcarpeculiar)";
    } else {
        $sWhereSQL = $sWhereSQL . " and e60_concarpeculiar not in ($listaconcarpeculiar)";
    }
}

$sWhereSQL .= " and $sele_work {$sValoresEmpenho}";

// para gestores
if ($lSepararGestor  && !empty($listagestor)) {
    $sWhereSQL .= " AND e54_gestaut IN ({$listagestor}) ";
}

/////////////////////////////////////////////
$sOrderSQL = "z01_nome, e60_emiss";

if ($agrupar == "a") { // fornecedor
    $sOrderSQL = "z01_nome, e60_emiss";
} elseif ($agrupar == "orgao") { // orgao
    $sOrderSQL = "o58_orgao, e60_emiss";
} elseif ($agrupar == "r") { // recurso
    $sOrderSQL = "o15_codigo, e60_emiss";
} elseif ($agrupar == "d") {
    // desdobramento
} elseif ($agrupar == "ta") {
    $sOrderSQL = "e94_empanuladotipo,e60_emiss";
} elseif ($agrupar == "do") {
    $sOrderSQL = "e60_coddot, e60_emiss";
} else {
}
if ($agrupar != "orgao" && $agrupar != "r" && $agrupar != "d") {
    if ($chk_ordem != "0") {
        if ($chk_ordem == "E") {
            $sOrderSQL = "e60_vlremp desc ";
        } elseif ($chk_ordem == "L") {
            $sOrderSQL = "e60_vlrliq desc ";
        } elseif ($chk_ordem == "P") {
            $sOrderSQL = "e60_vlrpag desc ";
        }
    }
}

if ($agrupar == "oo") {
    // $sOrderSQL = " e60_emiss, z01_nome, e60_anousu, e60_codemp ";
    $sOrderSQL = " e60_numemp, to_number(e60_codemp::text,'9999999999') ";
}


// para gestores
if ($lSepararGestor) {
    $sOrderSQL = ' e54_gestaut ASC, e60_numemp ';
}

// para tipos de anulacao
if ($agrupar == "ta") {
    $sSqlAnulado .= " INNER JOIN empanulado on e94_numemp = empempenho.e60_numemp ";
    $sSqlAnulado .= " INNER JOIN empanuladotipo ON e38_sequencial = e94_empanuladotipo ";
} else {
    $sSqlAnulado .= " LEFT JOIN empanulado on e94_numemp = empempenho.e60_numemp ";
    $sSqlAnulado .= " LEFT JOIN empanuladotipo ON e38_sequencial = e94_empanuladotipo ";
}

if ($processar == "a") {

    $sWhereSQL = str_replace("yyy.", "", $sWhereSQL);

    $sqlrelemp = $clempempenho->sql_query_relatorio(null, $sCamposPosicaoAtual, $sOrderSQL, $sWhereSQL, $sSqlAnulado);

    if ($agrupar == "d") {

        if ($sememp == "s") {
            $sqlrelemp =
                "select count(e60_numemp) AS e60_numemp,
            empelemento.e64_codele,
            o56_elemento,
            o56_descr,
            sum(empelemento.e64_vlremp) AS e64_vlremp,
            sum(empelemento.e64_vlrliq) AS e64_vlrliq,
            sum(empelemento.e64_vlranu) AS e64_vlranu,
            sum(empelemento.e64_vlrpag) AS e64_vlrpag,
            sum(e60_vlremp) as e60_vlremp,
            sum(e60_vlranu) as e60_vlranu,
            sum(e60_vlrliq) as e60_vlrliq,
            sum(e60_vlrpag) as e60_vlrpag  
            FROM empelemento
            inner JOIN empempenho ON e64_numemp = e60_numemp
            inner JOIN orcelemento ON (e64_codele, e60_anousu) = (o56_codele, o56_anousu)
            WHERE $sWhereSQL
            GROUP BY 2, o56_elemento,o56_descr
            HAVING count(e60_numemp) >= 1
            ORDER BY 4";
        } else {
            $sqlrelemp = "select distinct  x.e60_resumo,
					  x.e60_numemp,
					  x.e60_codemp,
					  x.e60_emiss,
					  x.e60_numcgm,
					  x.z01_nome,
					  x.z01_cgccpf,
					  x.z01_munic,
 					  x.e63_codhist,
					  x.e40_descr,
 				  	  x.e60_anousu,
					  x.e60_coddot,
					  x.o58_coddot,
					  x.o58_orgao,
					  x.o40_orgao,
					  x.o40_descr,
					  x.o58_unidade,
					  x.o41_descr,
					  x.o15_codigo,
					  x.o15_descr,
					  x.dl_estrutural,
					  x.e60_codcom,
					  x.pc50_descr,
					  empelemento.e64_codele,
					  orcelemento.o56_descr,
                                          x.e60_vlremp,
					  x.e60_vlranu,
					  x.e60_vlrliq,
                                          x.e60_vlrpag,
					  empelemento.e64_vlremp,
					  empelemento.e64_vlrliq,
					  empelemento.e64_vlranu,
					  empelemento.e64_vlrpag,
            x.e60_concarpeculiar,
            x.e60_numerol,
            x.e54_gestaut,
            x.descrdepto
				  from ($sqlrelemp) as x
			               inner join empelemento on x.e60_numemp = e64_numemp  " . $sele_desdobramentos . "
				       inner join orcelemento on o56_codele = e64_codele and o56_anousu = x.e60_anousu

				       group by
                x.e60_resumo,
					      x.e60_numemp,
					      x.e60_codemp,
					      x.e60_emiss,
					      x.e60_numcgm,
					      x.z01_nome,
					      x.z01_cgccpf,
					      x.z01_munic,
 					      x.e63_codhist,
					      x.e40_descr,
 				  	      x.e60_anousu,
					      x.e60_coddot,
					      x.o58_coddot,
					      x.o58_orgao,
					      x.o40_orgao,
					      x.o40_descr,
					      x.o58_unidade,
					      x.o41_descr,
					      x.o15_codigo,
					      x.o15_descr,
					      x.dl_estrutural,
					      x.e60_codcom,
					      x.pc50_descr,
					      empelemento.e64_codele,
					      orcelemento.o56_descr,
                                              x.e60_vlremp,
					      x.e60_vlranu,
					      x.e60_vlrliq,
                                              x.e60_vlrpag,
					      empelemento.e64_vlremp,
					      empelemento.e64_vlrliq,
					      empelemento.e64_vlranu,
					      empelemento.e64_vlrpag,
                x.e60_concarpeculiar,
                x.e60_numerol,
                x.e54_gestaut,
                x.descrdepto,
                e94_empanuladotipo,
            	e38_descr";
            $sqlrelemp = "select * from ($sqlrelemp) as yy order by yy.o56_descr";
        }
    } elseif ($agrupar == "ta") {
        $sqlrelemp = "select 	  x.e60_resumo,
					  x.e60_numemp,
					  x.e60_codemp,
					  x.e60_emiss,
					  x.e60_numcgm,
					  x.z01_nome,
					  x.z01_cgccpf,
					  x.z01_munic,
 					  x.e63_codhist,
					  x.e40_descr,
 				  	  x.e60_anousu,
					  x.e60_coddot,
					  x.o58_coddot,
					  x.o58_orgao,
					  x.o40_orgao,
					  x.o40_descr,
					  x.o58_unidade,
					  x.o41_descr,
					  x.o15_codigo,
					  x.o15_descr,
					  x.dl_estrutural,
					  x.e60_codcom,
					  x.pc50_descr,
					  empelemento.e64_codele,
					  orcelemento.o56_descr,
                                          x.e60_vlremp,
					  x.e60_vlranu,
					  x.e60_vlrliq,
                                          x.e60_vlrpag,
					  empelemento.e64_vlremp,
					  empelemento.e64_vlrliq,
					  empelemento.e64_vlranu,
					  empelemento.e64_vlrpag,
            x.e60_concarpeculiar,
            x.e60_numerol,
            x.e54_gestaut,
            x.descrdepto,
            e94_empanuladotipo,
            e38_descr
				  from ($sqlrelemp) as x
			               inner join empelemento on x.e60_numemp = e64_numemp  " . $sele_desdobramentos . "
				       inner join orcelemento on o56_codele = e64_codele and o56_anousu = x.e60_anousu

				       group by
                x.e60_resumo,
					      x.e60_numemp,
					      x.e60_codemp,
					      x.e60_emiss,
					      x.e60_numcgm,
					      x.z01_nome,
					      x.z01_cgccpf,
					      x.z01_munic,
 					      x.e63_codhist,
					      x.e40_descr,
 				  	      x.e60_anousu,
					      x.e60_coddot,
					      x.o58_coddot,
					      x.o58_orgao,
					      x.o40_orgao,
					      x.o40_descr,
					      x.o58_unidade,
					      x.o41_descr,
					      x.o15_codigo,
					      x.o15_descr,
					      x.dl_estrutural,
					      x.e60_codcom,
					      x.pc50_descr,
					      empelemento.e64_codele,
					      orcelemento.o56_descr,
                                              x.e60_vlremp,
					      x.e60_vlranu,
					      x.e60_vlrliq,
                                              x.e60_vlrpag,
					      empelemento.e64_vlremp,
					      empelemento.e64_vlrliq,
					      empelemento.e64_vlranu,
					      empelemento.e64_vlrpag,
                x.e60_concarpeculiar,
                x.e60_numerol,
                x.e54_gestaut,
                x.descrdepto,
                e94_empanuladotipo,
            	e38_descr";
    } else {
        $sqlrelemp = "select distinct  x.e60_resumo,
					  x.e60_numemp,
					  x.e60_codemp,
					  x.e60_emiss,
					  x.e60_numcgm,
					  x.z01_nome,
					  x.z01_cgccpf,
					  x.z01_munic,
 					  x.e63_codhist,
					  x.e40_descr,
 				  	  x.e60_anousu,
					  x.e60_coddot,
					  x.o58_coddot,
					  x.o58_orgao,
					  x.o40_orgao,
					  x.o40_descr,
					  x.o58_unidade,
					  x.o41_descr,
					  x.o15_codigo,
					  x.o15_descr,
					  x.dl_estrutural,
					  x.e60_codcom,
					  x.pc50_descr,
					  empelemento.e64_codele,
					  orcelemento.o56_descr,
                                          x.e60_vlremp,
					  x.e60_vlranu,
					  x.e60_vlrliq,
                                          x.e60_vlrpag,
					  empelemento.e64_vlremp,
					  empelemento.e64_vlrliq,
					  empelemento.e64_vlranu,
					  empelemento.e64_vlrpag,
            x.e60_concarpeculiar,
            x.e60_numerol,
            x.e54_gestaut,
            x.descrdepto
				  from ($sqlrelemp) as x
			               inner join empelemento on x.e60_numemp = e64_numemp  " . $sele_desdobramentos . "
				       inner join orcelemento on o56_codele = e64_codele and o56_anousu = x.e60_anousu

				       group by
                x.e60_resumo,
					      x.e60_numemp,
					      x.e60_codemp,
					      x.e60_emiss,
					      x.e60_numcgm,
					      x.z01_nome,
					      x.z01_cgccpf,
					      x.z01_munic,
 					      x.e63_codhist,
					      x.e40_descr,
 				  	      x.e60_anousu,
					      x.e60_coddot,
					      x.o58_coddot,
					      x.o58_orgao,
					      x.o40_orgao,
					      x.o40_descr,
					      x.o58_unidade,
					      x.o41_descr,
					      x.o15_codigo,
					      x.o15_descr,
					      x.dl_estrutural,
					      x.e60_codcom,
					      x.pc50_descr,
					      empelemento.e64_codele,
					      orcelemento.o56_descr,
                                              x.e60_vlremp,
					      x.e60_vlranu,
					      x.e60_vlrliq,
                                              x.e60_vlrpag,
					      empelemento.e64_vlremp,
					      empelemento.e64_vlrliq,
					      empelemento.e64_vlranu,
					      empelemento.e64_vlrpag,
                x.e60_concarpeculiar,
                x.e60_numerol,
                x.e54_gestaut,
                x.descrdepto,
                e94_empanuladotipo,
            	e38_descr";
    }

    // $sqlrelemp = "select * from ($sqlrelemp) as x " . ($agrupar != "d"
    // ? " order by e64_codele, e60_emiss "
    // : " order by $sOrderSQL ");

    $res = $clempempenho->sql_record($sqlrelemp);
    // echo $sqlrelemp;db_criatabela($res);die();

    if ($clempempenho->numrows > 0) {
        $rows = $clempempenho->numrows;
    } else {
        db_redireciona('db_erros.php?fechar=true&db_erro=No existem dados para gerar a consulta (A21) !');
    }
} else {

    $sqlperiodo = "
	      select 	empempenho.e60_numemp,
					e60_resumo,
					e60_codemp,
					e60_emiss,
					e60_numcgm,
					z01_nome,
					z01_cgccpf,
					z01_munic,
					yyy.e60_vlremp as e60_vlremp,
					yyy.e60_vlranu,
					yyy.e60_vlrliq,
					e63_codhist,
					e40_descr,
					yyy.e60_vlrpag,
					e60_anousu,
					e60_coddot,
					o58_coddot,
					o58_orgao,
					o40_orgao,
					o40_descr,
					o58_unidade,
					o41_descr,
					o15_codigo,
					o15_descr,
					fc_estruturaldotacao(e60_anousu,e60_coddot) as dl_estrutural,
					e60_codcom,
					pc50_descr,
          			e60_concarpeculiar,
          			e60_numerol,
          			e54_gestaut,
                    descrdepto
			   from (
			  select e60_numemp, e60_vlremp,

					sum(case when c53_tipo = 11 then c70_valor else 0 end) as e60_vlranu,
					sum(case when c53_tipo = 20 then c70_valor else 0 end) - sum(case when c53_tipo = 21 then c70_valor else 0 end) as e60_vlrliq,
					sum(case when c53_tipo = 30 then c70_valor else 0 end) - sum(case when c53_tipo = 31 then c70_valor else 0 end) as e60_vlrpag
				from (

				select  e60_numemp,
						c53_tipo,
						e60_vlremp,
						sum(c70_valor) as c70_valor
				from (
				      select e60_numemp,
						    e60_anousu,
						    e60_coddot,
						    e60_vlremp
				      from empempenho
				      where 	e60_instit in ($instits) and
						e60_emiss between '$datacredor' and '$datacredor1'
				      ) as xxx
					  inner join orcdotacao 		on orcdotacao.o58_anousu 	= xxx.e60_anousu and orcdotacao.o58_coddot = xxx.e60_coddot
					  inner join orcelemento 		on  orcelemento.o56_codele = orcdotacao.o58_codele
									       and  orcelemento.o56_anousu = orcdotacao.o58_anousu
					      inner join conlancamemp 	on c75_numemp = xxx.e60_numemp
					      inner join conlancam	    on c70_codlan = c75_codlan
					      inner join conlancamdoc 	on c71_codlan = c70_codlan
					      inner join conhistdoc 	on c53_coddoc = c71_coddoc and c53_tipo in (10,11,20,21,30,31)
					      inner join conlancamdot   on c73_codlan = c75_codlan
					 group by e60_numemp, c53_tipo, e60_vlremp
				) as xxx
			group by e60_numemp, e60_vlremp) as yyy
					inner join empempenho		on empempenho.e60_numemp	= yyy.e60_numemp
					inner join cgm 			on cgm.z01_numcgm 		= empempenho.e60_numcgm
					inner join db_config 		on db_config.codigo 		= empempenho.e60_instit
					inner join orcdotacao 		on orcdotacao.o58_anousu 	= empempenho.e60_anousu and orcdotacao.o58_coddot = empempenho.e60_coddot
					inner join emptipo 		on emptipo.e41_codtipo 		= empempenho.e60_codtipo
					inner join db_config as a 	on a.codigo 			= orcdotacao.o58_instit
					inner join orctiporec 		on orctiporec.o15_codigo 	= orcdotacao.o58_codigo
					inner join orcfuncao 		on orcfuncao.o52_funcao 	= orcdotacao.o58_funcao
					inner join orcsubfuncao 	on orcsubfuncao.o53_subfuncao 	= orcdotacao.o58_subfuncao
					inner join orcprograma 		on orcprograma.o54_anousu 	= orcdotacao.o58_anousu
													   and orcprograma.o54_programa = orcdotacao.o58_programa
					inner join orcelemento 		on orcelemento.o56_codele = orcdotacao.o58_codele
								       and orcelemento.o56_anousu = orcdotacao.o58_anousu
					inner join orcprojativ 		on orcprojativ.o55_anousu 	= orcdotacao.o58_anousu and orcprojativ.o55_projativ = orcdotacao.o58_projativ
					inner join orcorgao 		on orcorgao.o40_anousu 		= orcdotacao.o58_anousu and orcorgao.o40_orgao = orcdotacao.o58_orgao
					inner join orcunidade 		on orcunidade.o41_anousu 	= orcdotacao.o58_anousu
								 and orcunidade.o41_orgao = orcdotacao.o58_orgao and orcunidade.o41_unidade = orcdotacao.o58_unidade
					left join  empemphist 		on empemphist.e63_numemp = empempenho.e60_numemp
					left join  emphist 		on emphist.e40_codhist = empemphist.e63_codhist
					inner join pctipocompra 	on pctipocompra.pc50_codcom = empempenho.e60_codcom

          INNER JOIN empempaut ON e61_numemp = empempenho.e60_numemp
          INNER JOIN empautoriza ON e54_autori = e61_autori
          INNER JOIN db_depart ON e54_gestaut = coddepto
		  {$sSqlAnulado}";
    if ($listaitem != "" or $listasub != "") {
        if ($listaitem != "") {
            $sqlperiodo .= "  inner join empempitem on e62_numemp=empempenho.e60_numemp and e62_item in ($listaitem) ";
        }

        if ($listasub != "") {
            $sqlperiodo .= "  left join empempitem on e62_numemp=empempenho.e60_numemp and e62_item in ($listar) ";
        }
    }
    $sqlperiodo .= " where $sWhereSQL ";

    if ($listaitem != "") {
        $sqlperiodo .= " group by empempenho.e60_numemp,  empempenho.e60_resumo, empempenho.e60_codemp,
		                            empempenho.e60_emiss,   empempenho.e60_numcgm,
			                    cgm.z01_nome,           cgm.z01_cgccpf,        cgm.z01_munic,
				            yyy.e60_vlremp,         yyy.e60_vlranu,        yyy.e60_vlrliq,
					    empemphist.e63_codhist, emphist.e40_descr,     yyy.e60_vlrpag,
					    empempenho.e60_anousu,  empempenho.e60_coddot, orcdotacao.o58_coddot,
					    orcdotacao.o58_orgao,   orcorgao.o40_orgao,    orcorgao.o40_descr,
					    orcdotacao.o58_unidade, orcunidade.o41_descr,  orctiporec.o15_codigo,
					    orctiporec.o15_descr,   empempenho.e60_codcom, pctipocompra.pc50_descr,empempenho.e60_concarpeculiar ";
    }
    $sqlperiodo .= " group by 1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31  ";

    if ($agrupar == "d" || $sele_desdobramentos != "") {
        $sqlperiodo =  "
			      select 	e60_numemp,
					e60_resumo,
					e60_codemp,
					e60_emiss,
					e60_numcgm,
					z01_nome,
					z01_cgccpf,
					z01_munic,
					e60_vlremp,
					e60_vlranu,
					e60_vlrliq,
					e63_codhist,
					e40_descr,
					e60_vlrpag,
					e60_anousu,
					e60_coddot,
					o58_coddot,
					o58_orgao,
					o40_orgao,
					o40_descr,
					o58_unidade,
					o41_descr,
					o15_codigo,
					o15_descr,
					dl_estrutural,
					e60_codcom,
					pc50_descr,
					empelemento.e64_codele,
					orcelemento.o56_descr,
          			e60_concarpeculiar,
          			e60_numerol
		      from ($sqlperiodo) as x
			    /* inner join empelemento on x.e60_numemp = e64_numemp */

	 	      inner join empelemento on x.e60_numemp = e64_numemp  " . $sele_desdobramentos . "
			  inner join orcelemento on o56_codele = e64_codele and o56_anousu = x.e60_anousu
		      group by  e60_numemp,
					e60_resumo,
					e60_codemp,
					e60_emiss,
					e60_numcgm,
					z01_nome,
					z01_cgccpf,
					z01_munic,
					e60_vlremp,
					e60_vlranu,
					e60_vlrliq,
					e63_codhist,
					e40_descr,
					e60_vlrpag,
					e60_anousu,
					e60_coddot,
					o58_coddot,
					o58_orgao,
					o40_orgao,
					o40_descr,
					o58_unidade,
					o41_descr,
					o15_codigo,
					o15_descr,
					dl_estrutural,
					e60_codcom,
					pc50_descr,
					empelemento.e64_codele,
					orcelemento.o56_descr,
          e60_concarpeculiar,
          e60_numerol";
        if ($agrupar == "d") {
            $sqlperiodo .= "
                        group by 1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31
                         order by  e60_emiss
  			    ";
        } else {
            $sqlperiodo .= "
                         group by 1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31
                         order by  e60_emiss
  			    ";
        }
    }

    $res = $clempempenho->sql_record($sqlperiodo);
    //echo $sqlperiodo;db_criatabela($res);die();

    if ($clempempenho->numrows > 0) {
        $rows = $clempempenho->numrows;
    } else {
        db_redireciona('db_erros.php?fechar=true&db_erro=No existem dados para gerar a consulta!');
    }
}

header("Content-type: text/plain");
header("Content-type: application/csv");
header("Content-Disposition: attachment; filename=file.csv");
header("Pragma: no-cache");

if ($agrupar == 'gest') {

    $departAnt = '';
    $contEmpenhos = 0;

    echo ";;;;;;MOVIMENTACAO;;;;SALDO A PAGAR;;;\n";
    echo "TP COMPRA;LICI;EMP;EMISSAO;NOME;DOTACAO;EMPENHADO;ANULADO;LIQUIDADO;PAGO;LIQUIDADO;NAO LIQUID;GERAL;\n";
    if ($mostralan == "m") {
        echo ";;;DATA;LANCAMENTO;DOCUMENTO;VALOR;;;;;;;\n";
    }
    if ($mostraritem == "m") {
        if ($instits != db_getsession("DB_instit")) {
            echo "ITEM;DESCRICAO DO ITEM;QUANTIDADE;VALOR TOTAL;COMPLEMENTO;;;;;;\n";
        } else {
            echo "ITEM;DESCRICAO DO ITEM;QUANTIDADE;VALOR TOTAL;SALDO;COMPLEMENTO;;;;;;\n";
        }
    }

    for ($x = 0; $x < $rows; $x++) {

        $objeto = db_utils::fieldsMemory($res, $x, true);

        if (empty($departAnt) &&  $departAnt == null) {
            echo ";;;GESTOR : ;{$objeto->e54_gestaut} :: {$objeto->descrdepto};\n";
            $departAnt = "{$objeto->e54_gestaut}";
        }

        $dotacao = str_pad($objeto->e60_coddot, 4, '0', STR_PAD_LEFT);
        $EMPENHADO = db_formatar($objeto->e60_vlremp, 'f');
        $ANULADO = db_formatar($objeto->e60_vlranu, 'f');
        $LIQUIDADO = db_formatar($objeto->e60_vlrliq, 'f');
        $PAGO = db_formatar($objeto->e60_vlrpag, 'f');
        $LIQUIDADO2 = db_formatar($objeto->e60_vlrliq - $objeto->e60_vlrpag, 'f');
        $NAOLIQUID = db_formatar($objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrliq, 'f');
        $GERAL = db_formatar($objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrpag, 'f');

        if ($departAnt != "{$objeto->e54_gestaut}") {

            echo ";;;;;TOTAL DE $contEmpenhos EMPENHOS;$TotalEmpenhado;$TotalAnulado;$TotalLiquidado;$TotalPago;$TotalLiquidado2;$TotalNaoLiquidado;$TotalGeral;\n";
            echo ";;;GESTOR : ;{$objeto->e54_gestaut} :: {$objeto->descrdepto};\n";

            $TotalEmpenhado    = 0;
            $TotalAnulado      = 0;
            $TotalLiquidado    = 0;
            $TotalPago         = 0;
            $TotalLiquidado2   = 0;
            $TotalNaoLiquidado = 0;
            $TotalGeral        = 0;

            $departAnt = "{$objeto->e54_gestaut}";
            $contEmpenhos = 0;
        }

        $TotalEmpenhado    += $objeto->e60_vlremp;
        $TotalAnulado      += $objeto->e60_vlranu;
        $TotalLiquidado    += $objeto->e60_vlrliq;
        $TotalPago         += $objeto->e60_vlrpag;
        $TotalLiquidado2   += $objeto->e60_vlrliq - $objeto->e60_vlrpag;
        $TotalNaoLiquidado += $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrliq;
        $TotalGeral        += $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrpag;

        $GeralTotalEmpenhado    += $objeto->e60_vlremp;
        $GeralTotalAnulado      += $objeto->e60_vlranu;
        $GeralTotalLiquidado    += $objeto->e60_vlrliq;
        $GeralTotalPago         += $objeto->e60_vlrpag;
        $GeralTotalLiquidado2   += $objeto->e60_vlrliq - $objeto->e60_vlrpag;
        $GeralTotalNaoLiquidado += $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrliq;
        $GeralTotalGeral        += $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrpag;


        echo "$objeto->pc50_descr;$objeto->e60_numerol;$objeto->e60_codemp;$objeto->e60_emiss;$objeto->z01_nome;";
        echo "$dotacao - $objeto->dl_estrutural;$EMPENHADO;$ANULADO;$LIQUIDADO;$PAGO;$LIQUIDADO2;$NAOLIQUID;$GERAL;";
        echo "\n";

        if ($mostraritem == "m") {
            if ($instits != db_getsession("DB_instit")) {
                $dbwhere = "e62_numemp = $objeto->e60_numemp ";
                if ($listaitem != "" or $listasub != "") {
                    if ($listaitem != "") {
                        $dbwhere .= "and e62_item in ($listaitem) ";
                    }

                    if ($listasub != "") {
                        $dbwhere .= "and e62_item in ($listar) ";
                    }
                }

                $resitem = $clempempitem->sql_record($clempempitem->sql_query(null, null, "e62_item,pc01_descrmater,e62_quant,e62_vltot,e62_descr", null, $dbwhere));
                $rows_item = $clempempitem->numrows;

                for ($item = 0; $item < $rows_item; $item++) {
                    db_fieldsmemory($resitem, $item, true);

                    echo "$e62_item;$pc01_descrmater;";
                    echo db_formatar($e62_quant, 'f') . ";";
                    echo db_formatar($e62_vltot, 'f') . ";";
                    echo substr($e62_descr, 0, 100) . ";\n";
                }
            } else {
                $sCamposEmpenho  = "distinct riseqitem     as item_empenho";
                $sCamposEmpenho .= "         ,ricodmater   as e62_item";
                $sCamposEmpenho .= "         ,rsdescr      as pc01_descrmater";
                $sCamposEmpenho .= "         ,e62_descr";
                $sCamposEmpenho .= "         ,rnquantini   as e62_quant";
                $sCamposEmpenho .= "         ,rnvalorini   as e62_vltot";
                $sCamposEmpenho .= "         ,rnvaloruni";
                $sCamposEmpenho .= "         ,rnsaldoitem  as saldo";
                $sCamposEmpenho .= "         ,round(rnsaldovalor,2) as saldo_valor";
                $sCamposEmpenho .= "         ,o56_descr";
                $sCamposEmpenho .= "         ,case when pcorcamval.pc23_obs is not null";
                $sCamposEmpenho .= "              then pcorcamval.pc23_obs";
                $sCamposEmpenho .= "              else pcorcamvalpai.pc23_obs";
                $sCamposEmpenho .= "         end as observacao";
                $sWhereEmpenho   = "e60_numemp = {$objeto->e60_numemp}";

                $oDaoEmpenho      = db_utils::getDao("empempenho");
                $sSqlItensEmpenho = $oDaoEmpenho->sql_query_itens_consulta_empenho($objeto->e60_numemp, $sCamposEmpenho);
                $rsBuscaEmpenho   = $oDaoEmpenho->sql_record($sSqlItensEmpenho);

                for ($item = 0; $item < $oDaoEmpenho->numrows; $item++) {
                    db_fieldsmemory($rsBuscaEmpenho, $item, true);

                    echo "$e62_item;$pc01_descrmater;";
                    echo db_formatar($e62_quant, 'f') . ";";
                    echo db_formatar($e62_vltot, 'f') . ";";
                    echo db_formatar($saldo_valor, 'f') . ";";
                    echo substr($e62_descr, 0, 100) . ";\n";
                }
            }
        }
        if ($mostrarobs == "m") {
            echo "$objeto->e60_resumo;\n";
        }
        if (1 == 1) {

            $reslancam = $clconlancamemp->sql_record($clconlancamemp->sql_query("", "*", "c75_codlan", " c75_numemp = $objeto->e60_numemp " . ($processar == "a" ? "" : " and c75_data between '$objeto->dataesp11' and '$objeto->dataesp22'")));
            $rows_lancamemp = $clconlancamemp->numrows;
            for ($lancemp = 0; $lancemp < $rows_lancamemp; $lancemp++) {
                db_fieldsmemory($reslancam, $lancemp, true);
                $reslancamdoc = $clconlancamdoc->sql_record($clconlancamdoc->sql_query($c70_codlan, "*"));
                db_fieldsmemory($reslancamdoc, 0, true);
                if ($mostralan == "m") {

                    echo ";;;$c70_data;";
                    echo "$c70_codlan;";
                    echo "$c53_descr;";
                    echo db_formatar($c70_valor, 'f') . ";\n";
                }

                if ($c53_tipo == 10) {
                    $lanctotemp += $c70_valor;
                } elseif ($c53_tipo == 11) {
                    $lanctotanuemp += $c70_valor;
                } elseif ($c53_tipo == 20) {
                    $lanctotliq += $c70_valor;
                } elseif ($c53_tipo == 21) {
                    $lanctotanuliq += $c70_valor;
                } elseif ($c53_tipo == 30) {
                    $lanctotpag += $c70_valor;
                } elseif ($c53_tipo == 31) {
                    $lanctotanupag += $c70_valor;
                }
            }
        }
        $contEmpenhos++;

        if ($x == $rows - 1) {
            echo ";;;;;TOTAL DE $contEmpenhos EMPENHOS;$TotalEmpenhado;$TotalAnulado;$TotalLiquidado;$TotalPago;$TotalLiquidado2;$TotalNaoLiquidado;$TotalGeral;\n";
        }
    }

    echo "TOTAL DE EMPENHOS: $rows;;;;;TOTAL GERAL;$GeralTotalEmpenhado;$GeralTotalAnulado;$GeralTotalLiquidado;$GeralTotalPago;$GeralTotalLiquidado2;$GeralTotalNaoLiquidado;$GeralTotalGeral;\n";

    if ($processar == "a") {

        echo "MOVIMENTAO CONTABIL NO PERIODO;;;;;;"
            . db_formatar($lanctotemp, 'p') . ";"
            . db_formatar($lanctotanuemp, 'p') . ";"
            . db_formatar($lanctotliq - $lanctotanuliq, 'p') . ";"
            . db_formatar($lanctotpag - $lanctotanupag, 'p') . ";"
            . db_formatar(($lanctotliq - $lanctotanuliq) - ($lanctotpag - $lanctotanupag), 'p') . ";"
            . db_formatar(($lanctotemp - ($lanctotanuemp + ($lanctotpag - $lanctotanupag))) - (($lanctotliq - $lanctotanuliq) - ($lanctotpag - $lanctotanupag)), 'p') . ";"
            . db_formatar($lanctotemp - ($lanctotanuemp + ($lanctotpag - $lanctotanupag)), 'p') . ";";
    } else {

        echo "MOVIMENTAO CONTABIL NO PERIODO;;;;;;"
            . db_formatar($lanctotemp, 'p') . ";"
            . db_formatar($lanctotanuemp, 'p') . ";"
            . db_formatar($lanctotliq - $lanctotanuliq, 'p') . ";"
            . db_formatar($lanctotpag - $lanctotanupag, 'p') . ";";
    }
}

if ($agrupar == 'oo') {

    $departAnt = '';
    $contEmpenhos = 0;
    echo ";;;;;;MOVIMENTACAO;;;;SALDO A PAGAR;;;\n";
    echo "TP COMPRA;LICI;EMP;EMISSAO;NOME;DOTACAO;EMPENHADO;ANULADO;LIQUIDADO;PAGO;LIQUIDADO;NAO LIQUID;GERAL;\n";
    if ($mostralan == "m") {
        echo ";;;DATA;LANCAMENTO;DOCUMENTO;VALOR;;;;;;;\n";
    }
    if ($mostraritem == "m") {
        if ($instits != db_getsession("DB_instit")) {
            echo "ITEM;DESCRICAO DO ITEM;QUANTIDADE;VALOR TOTAL;COMPLEMENTO;;;;;;\n";
        } else {
            echo "ITEM;DESCRICAO DO ITEM;QUANTIDADE;VALOR TOTAL;SALDO;COMPLEMENTO;;;;;;\n";
        }
    }

    for ($x = 0; $x < $rows; $x++) {
        //db_criatabela($res);exit;
        $objeto = db_utils::fieldsMemory($res, $x, true);

        $dotacao = str_pad($objeto->e60_coddot, 4, '0', STR_PAD_LEFT);
        $EMPENHADO = db_formatar($objeto->e60_vlremp, 'f');
        $ANULADO = db_formatar($objeto->e60_vlranu, 'f');
        $LIQUIDADO = db_formatar($objeto->e60_vlrliq, 'f');
        $PAGO = db_formatar($objeto->e60_vlrpag, 'f');
        $LIQUIDADO2 = db_formatar($objeto->e60_vlrliq - $objeto->e60_vlrpag, 'f');
        $NAOLIQUID = db_formatar($objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrliq, 'f');
        $GERAL = db_formatar($objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrpag, 'f');


        $TotalEmpenhado    += $objeto->e60_vlremp;
        $TotalAnulado      += $objeto->e60_vlranu;
        $TotalLiquidado    += $objeto->e60_vlrliq;
        $TotalPago         += $objeto->e60_vlrpag;
        $TotalLiquidado2   += $objeto->e60_vlrliq - $objeto->e60_vlrpag;
        $TotalNaoLiquidado += $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrliq;
        $TotalGeral        += $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrpag;

        $GeralTotalEmpenhado    += $objeto->e60_vlremp;
        $GeralTotalAnulado      += $objeto->e60_vlranu;
        $GeralTotalLiquidado    += $objeto->e60_vlrliq;
        $GeralTotalPago         += $objeto->e60_vlrpag;
        $GeralTotalLiquidado2   += $objeto->e60_vlrliq - $objeto->e60_vlrpag;
        $GeralTotalNaoLiquidado += $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrliq;
        $GeralTotalGeral        += $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrpag;

        echo "$objeto->pc50_descr;$objeto->e60_numerol;$objeto->e60_codemp;$objeto->e60_emiss;$objeto->z01_nome;";
        echo "$dotacao - $objeto->dl_estrutural;$EMPENHADO;$ANULADO;$LIQUIDADO;$PAGO;$LIQUIDADO2;$NAOLIQUID;$GERAL;";
        echo "\n";

        if ($mostraritem == "m") {
            if ($instits != db_getsession("DB_instit")) {
                $dbwhere = "e62_numemp = $objeto->e60_numemp ";
                if ($listaitem != "" or $listasub != "") {
                    if ($listaitem != "") {
                        $dbwhere .= "and e62_item in ($listaitem) ";
                    }

                    if ($listasub != "") {
                        $dbwhere .= "and e62_item in ($listar) ";
                    }
                }

                $resitem = $clempempitem->sql_record($clempempitem->sql_query(null, null, "e62_item,pc01_descrmater,e62_quant,e62_vltot,e62_descr", null, $dbwhere));
                $rows_item = $clempempitem->numrows;

                for ($item = 0; $item < $rows_item; $item++) {
                    db_fieldsmemory($resitem, $item, true);

                    echo "$e62_item;$pc01_descrmater;";
                    echo db_formatar($e62_quant, 'f') . ";";
                    echo db_formatar($e62_vltot, 'f') . ";";
                    echo substr($e62_descr, 0, 100) . ";\n";
                }
            } else {
                $sCamposEmpenho  = "distinct riseqitem     as item_empenho";
                $sCamposEmpenho .= "         ,ricodmater   as e62_item";
                $sCamposEmpenho .= "         ,rsdescr      as pc01_descrmater";
                $sCamposEmpenho .= "         ,e62_descr";
                $sCamposEmpenho .= "         ,rnquantini   as e62_quant";
                $sCamposEmpenho .= "         ,rnvalorini   as e62_vltot";
                $sCamposEmpenho .= "         ,rnvaloruni";
                $sCamposEmpenho .= "         ,rnsaldoitem  as saldo";
                $sCamposEmpenho .= "         ,round(rnsaldovalor,2) as saldo_valor";
                $sCamposEmpenho .= "         ,o56_descr";
                $sCamposEmpenho .= "         ,case when pcorcamval.pc23_obs is not null";
                $sCamposEmpenho .= "              then pcorcamval.pc23_obs";
                $sCamposEmpenho .= "              else pcorcamvalpai.pc23_obs";
                $sCamposEmpenho .= "         end as observacao";
                $sWhereEmpenho   = "e60_numemp = {$objeto->e60_numemp}";

                $oDaoEmpenho      = db_utils::getDao("empempenho");
                $sSqlItensEmpenho = $oDaoEmpenho->sql_query_itens_consulta_empenho($objeto->e60_numemp, $sCamposEmpenho);
                $rsBuscaEmpenho   = $oDaoEmpenho->sql_record($sSqlItensEmpenho);

                for ($item = 0; $item < $oDaoEmpenho->numrows; $item++) {
                    db_fieldsmemory($rsBuscaEmpenho, $item, true);

                    echo "$e62_item;$pc01_descrmater;";
                    echo db_formatar($e62_quant, 'f') . ";";
                    echo db_formatar($e62_vltot, 'f') . ";";
                    echo db_formatar($saldo_valor, 'f') . ";";
                    echo substr($e62_descr, 0, 100) . ";\n";
                }
            }
        }
        if ($mostrarobs == "m") {
            echo "$objeto->e60_resumo;\n";
        }
        if (1 == 1) {

            $reslancam = $clconlancamemp->sql_record($clconlancamemp->sql_query("", "*", "c75_codlan", " c75_numemp = $objeto->e60_numemp " . ($processar == "a" ? "" : " and c75_data between '$objeto->dataesp11' and '$objeto->dataesp22'")));
            $rows_lancamemp = $clconlancamemp->numrows;
            for ($lancemp = 0; $lancemp < $rows_lancamemp; $lancemp++) {
                db_fieldsmemory($reslancam, $lancemp, true);
                $reslancamdoc = $clconlancamdoc->sql_record($clconlancamdoc->sql_query($c70_codlan, "*"));
                db_fieldsmemory($reslancamdoc, 0, true);
                if ($mostralan == "m") {

                    echo ";;;$c70_data;";
                    echo "$c70_codlan;";
                    echo "$c53_descr;";
                    echo db_formatar($c70_valor, 'f') . ";\n";
                }

                if ($c53_tipo == 10) {
                    $lanctotemp += $c70_valor;
                } elseif ($c53_tipo == 11) {
                    $lanctotanuemp += $c70_valor;
                } elseif ($c53_tipo == 20) {
                    $lanctotliq += $c70_valor;
                } elseif ($c53_tipo == 21) {
                    $lanctotanuliq += $c70_valor;
                } elseif ($c53_tipo == 30) {
                    $lanctotpag += $c70_valor;
                } elseif ($c53_tipo == 31) {
                    $lanctotanupag += $c70_valor;
                }
            }
        }
        $contEmpenhos++;

        if ($x == $rows - 1) {
            echo ";;;;;TOTAL DE $contEmpenhos EMPENHOS;$TotalEmpenhado;$TotalAnulado;$TotalLiquidado;$TotalPago;$TotalLiquidado2;$TotalNaoLiquidado;$TotalGeral;\n";
        }
    }

    echo "TOTAL DE EMPENHOS: $rows;;;;;TOTAL GERAL;$GeralTotalEmpenhado;$GeralTotalAnulado;$GeralTotalLiquidado;$GeralTotalPago;$GeralTotalLiquidado2;$GeralTotalNaoLiquidado;$GeralTotalGeral;\n";

    if ($processar == "a") {

        echo "MOVIMENTAO CONTABIL NO PERIODO;;;;;;"
            . db_formatar($lanctotemp, 'p') . ";"
            . db_formatar($lanctotanuemp, 'p') . ";"
            . db_formatar($lanctotliq - $lanctotanuliq, 'p') . ";"
            . db_formatar($lanctotpag - $lanctotanupag, 'p') . ";"
            . db_formatar(($lanctotliq - $lanctotanuliq) - ($lanctotpag - $lanctotanupag), 'p') . ";"
            . db_formatar(($lanctotemp - ($lanctotanuemp + ($lanctotpag - $lanctotanupag))) - (($lanctotliq - $lanctotanuliq) - ($lanctotpag - $lanctotanupag)), 'p') . ";"
            . db_formatar($lanctotemp - ($lanctotanuemp + ($lanctotpag - $lanctotanupag)), 'p') . ";";
    } else {

        echo "MOVIMENTAO CONTABIL NO PERIODO;;;;;;"
            . db_formatar($lanctotemp, 'p') . ";"
            . db_formatar($lanctotanuemp, 'p') . ";"
            . db_formatar($lanctotliq - $lanctotanuliq, 'p') . ";"
            . db_formatar($lanctotpag - $lanctotanupag, 'p') . ";";
    }

    if ($hist == "h") {

        if ($processar == "a") {
            $sql = "select case when e63_codhist is null then 0               else e63_codhist end as e63_codhist,
																       case when e40_descr   is null then 'SEM HISTORICO' else e40_descr   end as e40_descr,
																       e60_vlremp, e60_vlranu, e60_vlrliq, e60_vlrpag from (
																select e63_codhist,e40_descr,
														                       sum(e60_vlremp) as e60_vlremp,
														                       sum(e60_vlranu) as e60_vlranu,
														          	       sum(e60_vlrliq) as e60_vlrliq,
														       	               sum(e60_vlrpag) as e60_vlrpag
														   	        from empempenho
																	inner join orcdotacao  on  orcdotacao.o58_anousu = empempenho.e60_anousu and  orcdotacao.o58_coddot  = empempenho.e60_coddot
																	inner join orcelemento  on  orcelemento.o56_codele = orcdotacao.o58_codele
																	                       and  orcelemento.o56_anousu = orcdotacao.o58_anousu
														                       	left join empemphist on empemphist.e63_numemp = empempenho.e60_numemp
														                       	left join emphist on emphist.e40_codhist = empemphist.e63_codhist
																where 	$sWhereSQL
														                      ";
            $sql = $sql . " group by e63_codhist,e40_descr order by e63_codhist) as x";
        } else {
            $sql = "select case when x.e63_codhist is null then 0               else x.e63_codhist end as e63_codhist,
																       case when x.e40_descr   is null then 'SEM HISTORICO' else x.e40_descr   end as e40_descr,
																       sum(e60_vlremp) as e60_vlremp, sum(e60_vlranu) as e60_vlranu, sum(e60_vlrliq) as e60_vlrliq, sum(e60_vlrpag) as e60_vlrpag from
																       ($sqlperiodo) as x
														                       left join empemphist on empemphist.e63_numemp = x.e60_numemp
														                       left join emphist on emphist.e40_codhist = empemphist.e63_codhist
																       group by x.e63_codhist,x.e40_descr order by x.e63_codhist";
        }

        $result = $clempempenho->sql_record($sql);
        if ($clempempenho->numrows > 0) {

            $imprime_header = true;
            $rows = $clempempenho->numrows;

            for ($x = 0; $x < $rows; $x++) {
                db_fieldsmemory($result, $x, true);

                if ($imprime_header == true) {
                    echo "\n";
                    echo ";;;;TOTALIZAO DOS HISTRICOS;;;SALDO A PAGAR;\n";
                    echo "$RLe63_codhist;$RLe40_descr;$RLe60_vlremp;$RLe60_vlranu;$RLe60_vlrliq;$RLe60_vlrpag;LIQUIDADO;NAO LIQUIDADO;GERAL;\n";
                }

                echo "$e63_codhist;$e40_descr;$e60_vlremp;$e60_vlranu;$e60_vlrliq;$e60_vlrpag;";
                $total         = $e60_vlrliq - $e60_vlrpag;
                $iliquidado    = db_formatar($e60_vlrliq - $e60_vlrpag, 'p');
                $inaoliquidado = db_formatar($e60_vlremp - $e60_vlranu - $e60_vlrliq, 'p');
                $igeral        = db_formatar($e60_vlremp - $e60_vlranu - $e60_vlrpag, 'p');

                echo "$iliquidado;$inaoliquidado;$igeral;\n";

                $t_emp1 += $e60_vlremp;
                $t_liq1 += $e60_vlrliq;
                $t_anu1 += $e60_vlranu;
                $t_pag1 += $e60_vlrpag;
                $t_total1 += $total;
                $imprime_header = false;

                if ($x == ($rows - 1)) {

                    $emp1      = db_formatar($t_emp1, 'p');
                    $anu1      = db_formatar($t_anu1, 'p');
                    $liq1      = db_formatar($t_liq1, 'p');
                    $pag1      = db_formatar($t_pag1, 'p');
                    $liqpag    = db_formatar($t_liq1 - $t_pag1, 'p');
                    $empanuliq = db_formatar($t_emp1 - $t_anu1 - $t_liq1, 'p');
                    $empanupag = db_formatar($t_emp1 - $t_anu1 - $t_pag1, 'p');
                    echo ";TOTAL;$emp1;$anu1;$liq1;$pag1;$liqpag;$empanuliq;$empanupag";
                }
            }
        }
    }
}

if ($agrupar == 'a') {

    $fornAnt = '';
    $municAnt = '';
    $contEmpenhos = 0;
    echo "RECURSO;;;;TIPO DE RECURSO;;MOVIMENTACAO;;;;SALDO A PAGAR;;;\n";
    echo "TP COMPRA;LICI;EMP;EMISSAO;RECURSO;DOTACAO;EMPENHADO;ANULADO;LIQUIDADO;PAGO;LIQUIDADO;NAO LIQUID;GERAL;\n";
    if ($mostralan == "m") {
        echo ";;;DATA;LANCAMENTO;DOCUMENTO;VALOR;;;;;;;\n";
    }
    if ($mostraritem == "m") {
        if ($instits != db_getsession("DB_instit")) {
            echo "ITEM;DESCRICAO DO ITEM;QUANTIDADE;VALOR TOTAL;COMPLEMENTO;;;;;;\n";
        } else {
            echo "ITEM;DESCRICAO DO ITEM;QUANTIDADE;VALOR TOTAL;SALDO;COMPLEMENTO;;;;;;\n";
        }
    }

    for ($x = 0; $x < $rows; $x++) {
        //db_criatabela($res);
        $objeto = db_utils::fieldsMemory($res, $x, true);

        if (empty($fornAnt)) {
            $fornAnt = "{$objeto->e60_numcgm}";
            echo ";;;{$objeto->e60_numcgm};{$objeto->z01_nome};\n";
        }

        $dotacao = str_pad($objeto->e60_coddot, 4, '0', STR_PAD_LEFT);
        $EMPENHADO = db_formatar($objeto->e60_vlremp, 'f');
        $ANULADO = db_formatar($objeto->e60_vlranu, 'f');
        $LIQUIDADO = db_formatar($objeto->e60_vlrliq, 'f');
        $PAGO = db_formatar($objeto->e60_vlrpag, 'f');
        $LIQUIDADO2 = db_formatar($objeto->e60_vlrliq - $objeto->e60_vlrpag, 'f');
        $NAOLIQUID = db_formatar($objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrliq, 'f');
        $GERAL = db_formatar($objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrpag, 'f');


        if ($fornAnt != "{$objeto->e60_numcgm}") {

            echo ";;;;;TOTAL DE $contEmpenhos EMPENHOS;$TotalEmpenhado;$TotalAnulado;$TotalLiquidado;$TotalPago;$TotalLiquidado2;$TotalNaoLiquidado;$TotalGeral;\n";
            echo ";;;{$objeto->e60_numcgm};{$objeto->z01_nome};\n";
            $TotalEmpenhado    = 0;
            $TotalAnulado      = 0;
            $TotalLiquidado    = 0;
            $TotalPago         = 0;
            $TotalLiquidado2   = 0;
            $TotalNaoLiquidado = 0;
            $TotalGeral        = 0;

            $fornAnt = "{$objeto->e60_numcgm}";
            $contEmpenhos = 0;
        }

        $TotalEmpenhado    += $objeto->e60_vlremp;
        $TotalAnulado      += $objeto->e60_vlranu;
        $TotalLiquidado    += $objeto->e60_vlrliq;
        $TotalPago         += $objeto->e60_vlrpag;
        $TotalLiquidado2   += $objeto->e60_vlrliq - $objeto->e60_vlrpag;
        $TotalNaoLiquidado += $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrliq;
        $TotalGeral        += $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrpag;

        $GeralTotalEmpenhado    += $objeto->e60_vlremp;
        $GeralTotalAnulado      += $objeto->e60_vlranu;
        $GeralTotalLiquidado    += $objeto->e60_vlrliq;
        $GeralTotalPago         += $objeto->e60_vlrpag;
        $GeralTotalLiquidado2   += $objeto->e60_vlrliq - $objeto->e60_vlrpag;
        $GeralTotalNaoLiquidado += $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrliq;
        $GeralTotalGeral        += $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrpag;

        if (empty($municAnt)) {
            echo "$objeto->z01_cgccpf;$objeto->z01_munic;\n";
            $municAnt = "{$objeto->z01_munic}";
        } else if ($municAnt != "{$objeto->z01_munic}") {
            echo "$objeto->z01_cgccpf;$objeto->z01_munic;\n";
            $municAnt = "{$objeto->z01_munic}";
        }
        echo "$objeto->pc50_descr;$objeto->e60_numerol;$objeto->e60_codemp;$objeto->e60_emiss;$objeto->o15_codigo-$objeto->o15_descr;";
        echo "$dotacao - $objeto->dl_estrutural;$EMPENHADO;$ANULADO;$LIQUIDADO;$PAGO;$LIQUIDADO2;$NAOLIQUID;$GERAL;";
        echo "\n";

        if ($mostraritem == "m") {
            if ($instits != db_getsession("DB_instit")) {
                $dbwhere = "e62_numemp = $objeto->e60_numemp ";
                if ($listaitem != "" or $listasub != "") {
                    if ($listaitem != "") {
                        $dbwhere .= "and e62_item in ($listaitem) ";
                    }

                    if ($listasub != "") {
                        $dbwhere .= "and e62_item in ($listar) ";
                    }
                }

                $resitem = $clempempitem->sql_record($clempempitem->sql_query(null, null, "e62_item,pc01_descrmater,e62_quant,e62_vltot,e62_descr", null, $dbwhere));
                $rows_item = $clempempitem->numrows;

                for ($item = 0; $item < $rows_item; $item++) {
                    db_fieldsmemory($resitem, $item, true);

                    echo "$e62_item;$pc01_descrmater;";
                    echo db_formatar($e62_quant, 'f') . ";";
                    echo db_formatar($e62_vltot, 'f') . ";";
                    echo substr($e62_descr, 0, 100) . ";\n";
                }
            } else {
                $sCamposEmpenho  = "distinct riseqitem     as item_empenho";
                $sCamposEmpenho .= "         ,ricodmater   as e62_item";
                $sCamposEmpenho .= "         ,rsdescr      as pc01_descrmater";
                $sCamposEmpenho .= "         ,e62_descr";
                $sCamposEmpenho .= "         ,rnquantini   as e62_quant";
                $sCamposEmpenho .= "         ,rnvalorini   as e62_vltot";
                $sCamposEmpenho .= "         ,rnvaloruni";
                $sCamposEmpenho .= "         ,rnsaldoitem  as saldo";
                $sCamposEmpenho .= "         ,round(rnsaldovalor,2) as saldo_valor";
                $sCamposEmpenho .= "         ,o56_descr";
                $sCamposEmpenho .= "         ,case when pcorcamval.pc23_obs is not null";
                $sCamposEmpenho .= "              then pcorcamval.pc23_obs";
                $sCamposEmpenho .= "              else pcorcamvalpai.pc23_obs";
                $sCamposEmpenho .= "         end as observacao";
                $sWhereEmpenho   = "e60_numemp = {$objeto->e60_numemp}";

                $oDaoEmpenho      = db_utils::getDao("empempenho");
                $sSqlItensEmpenho = $oDaoEmpenho->sql_query_itens_consulta_empenho($objeto->e60_numemp, $sCamposEmpenho);
                $rsBuscaEmpenho   = $oDaoEmpenho->sql_record($sSqlItensEmpenho);
                for ($item = 0; $item < $oDaoEmpenho->numrows; $item++) {
                    db_fieldsmemory($rsBuscaEmpenho, $item, true);

                    echo "$e62_item;$pc01_descrmater;";
                    echo db_formatar($e62_quant, 'f') . ";";
                    echo db_formatar($e62_vltot, 'f') . ";";
                    echo db_formatar($saldo_valor, 'f') . ";";
                    echo substr($e62_descr, 0, 100) . ";\n";
                }
            }
        }
        if ($mostrarobs == "m") {
            echo "$objeto->e60_resumo;\n";
        }
        if (1 == 1) {

            $reslancam = $clconlancamemp->sql_record($clconlancamemp->sql_query("", "*", "c75_codlan", " c75_numemp = $objeto->e60_numemp " . ($processar == "a" ? "" : " and c75_data between '$objeto->dataesp11' and '$objeto->dataesp22'")));
            $rows_lancamemp = $clconlancamemp->numrows;
            for ($lancemp = 0; $lancemp < $rows_lancamemp; $lancemp++) {
                db_fieldsmemory($reslancam, $lancemp, true);
                $reslancamdoc = $clconlancamdoc->sql_record($clconlancamdoc->sql_query($c70_codlan, "*"));
                db_fieldsmemory($reslancamdoc, 0, true);
                if ($mostralan == "m") {

                    echo ";;;$c70_data;";
                    echo "$c70_codlan;";
                    echo "$c53_descr;";
                    echo db_formatar($c70_valor, 'f') . ";\n";
                }

                if ($c53_tipo == 10) {
                    $lanctotemp += $c70_valor;
                } elseif ($c53_tipo == 11) {
                    $lanctotanuemp += $c70_valor;
                } elseif ($c53_tipo == 20) {
                    $lanctotliq += $c70_valor;
                } elseif ($c53_tipo == 21) {
                    $lanctotanuliq += $c70_valor;
                } elseif ($c53_tipo == 30) {
                    $lanctotpag += $c70_valor;
                } elseif ($c53_tipo == 31) {
                    $lanctotanupag += $c70_valor;
                }
            }
        }
        $contEmpenhos++;

        if ($x == $rows - 1) {
            echo ";;;;;TOTAL DE $contEmpenhos EMPENHOS;$TotalEmpenhado;$TotalAnulado;$TotalLiquidado;$TotalPago;$TotalLiquidado2;$TotalNaoLiquidado;$TotalGeral;\n";
        }
    }

    echo "TOTAL DE EMPENHOS: $rows;;;;;TOTAL GERAL;$GeralTotalEmpenhado;$GeralTotalAnulado;$GeralTotalLiquidado;$GeralTotalPago;$GeralTotalLiquidado2;$GeralTotalNaoLiquidado;$GeralTotalGeral;\n";

    if ($processar == "a") {

        echo "MOVIMENTAO CONTABIL NO PERIODO;;;;;;"
            . db_formatar($lanctotemp, 'p') . ";"
            . db_formatar($lanctotanuemp, 'p') . ";"
            . db_formatar($lanctotliq - $lanctotanuliq, 'p') . ";"
            . db_formatar($lanctotpag - $lanctotanupag, 'p') . ";"
            . db_formatar(($lanctotliq - $lanctotanuliq) - ($lanctotpag - $lanctotanupag), 'p') . ";"
            . db_formatar(($lanctotemp - ($lanctotanuemp + ($lanctotpag - $lanctotanupag))) - (($lanctotliq - $lanctotanuliq) - ($lanctotpag - $lanctotanupag)), 'p') . ";"
            . db_formatar($lanctotemp - ($lanctotanuemp + ($lanctotpag - $lanctotanupag)), 'p') . ";";
    } else {

        echo "MOVIMENTAO CONTABIL NO PERIODO;;;;;;"
            . db_formatar($lanctotemp, 'p') . ";"
            . db_formatar($lanctotanuemp, 'p') . ";"
            . db_formatar($lanctotliq - $lanctotanuliq, 'p') . ";"
            . db_formatar($lanctotpag - $lanctotanupag, 'p') . ";";
    }
}

if ($agrupar == 'orgao') {

    $orgaoAnt = '';
    $contEmpenhos = 0;
    echo "TIPO DE RECURSO;;;;DESCRICAO ORGAO;;MOVIMENTACAO;;;;SALDO A PAGAR;;;\n";
    echo "TP COMPRA;LICI;EMP;EMISSAO;DESCRICAO ORGAO;DOTACAO;EMPENHADO;ANULADO;LIQUIDADO;PAGO;LIQUIDADO;NAO LIQUID;GERAL;\n";
    if ($mostralan == "m") {
        echo ";;;DATA;LANCAMENTO;DOCUMENTO;VALOR;;;;;;;\n";
    }
    if ($mostraritem == "m") {
        if ($instits != db_getsession("DB_instit")) {
            echo "ITEM;DESCRICAO DO ITEM;QUANTIDADE;VALOR TOTAL;COMPLEMENTO;;;;;;\n";
        } else {
            echo "ITEM;DESCRICAO DO ITEM;QUANTIDADE;VALOR TOTAL;SALDO;COMPLEMENTO;;;;;;\n";
        }
    }

    for ($x = 0; $x < $rows; $x++) {
        //db_criatabela($res);exit;

        $objeto = db_utils::fieldsMemory($res, $x, true);

        if (empty($orgaoAnt)) {
            $orgaoAnt = "{$objeto->o40_orgao}";
            echo ";;;OrgAo: ;$objeto->o40_descr;\n";
        }

        $dotacao = str_pad($objeto->e60_coddot, 4, '0', STR_PAD_LEFT);
        $EMPENHADO = db_formatar($objeto->e60_vlremp, 'f');
        $ANULADO = db_formatar($objeto->e60_vlranu, 'f');
        $LIQUIDADO = db_formatar($objeto->e60_vlrliq, 'f');
        $PAGO = db_formatar($objeto->e60_vlrpag, 'f');
        $LIQUIDADO2 = db_formatar($objeto->e60_vlrliq - $objeto->e60_vlrpag, 'f');
        $NAOLIQUID = db_formatar($objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrliq, 'f');
        $GERAL = db_formatar($objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrpag, 'f');


        if ($orgaoAnt != "{$objeto->o40_orgao}") {

            echo ";;;;;TOTAL DE $contEmpenhos EMPENHOS;$TotalEmpenhado;$TotalAnulado;$TotalLiquidado;$TotalPago;$TotalLiquidado2;$TotalNaoLiquidado;$TotalGeral;\n";
            echo ";;;OrgAo: ;$objeto->o40_descr;\n";
            $TotalEmpenhado    = 0;
            $TotalAnulado      = 0;
            $TotalLiquidado    = 0;
            $TotalPago         = 0;
            $TotalLiquidado2   = 0;
            $TotalNaoLiquidado = 0;
            $TotalGeral        = 0;

            $orgaoAnt = "{$objeto->o40_orgao}";
            $contEmpenhos = 0;
        }

        $TotalEmpenhado    += $objeto->e60_vlremp;
        $TotalAnulado      += $objeto->e60_vlranu;
        $TotalLiquidado    += $objeto->e60_vlrliq;
        $TotalPago         += $objeto->e60_vlrpag;
        $TotalLiquidado2   += $objeto->e60_vlrliq - $objeto->e60_vlrpag;
        $TotalNaoLiquidado += $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrliq;
        $TotalGeral        += $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrpag;

        $GeralTotalEmpenhado    += $objeto->e60_vlremp;
        $GeralTotalAnulado      += $objeto->e60_vlranu;
        $GeralTotalLiquidado    += $objeto->e60_vlrliq;
        $GeralTotalPago         += $objeto->e60_vlrpag;
        $GeralTotalLiquidado2   += $objeto->e60_vlrliq - $objeto->e60_vlrpag;
        $GeralTotalNaoLiquidado += $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrliq;
        $GeralTotalGeral        += $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrpag;


        echo "$objeto->pc50_descr;$objeto->e60_numerol;$objeto->e60_codemp;$objeto->e60_emiss;$objeto->z01_nome;";
        echo "$dotacao - $objeto->dl_estrutural;$EMPENHADO;$ANULADO;$LIQUIDADO;$PAGO;$LIQUIDADO2;$NAOLIQUID;$GERAL;";
        echo "\n";

        if ($mostraritem == "m") {
            if ($instits != db_getsession("DB_instit")) {
                $dbwhere = "e62_numemp = $objeto->e60_numemp ";
                if ($listaitem != "" or $listasub != "") {
                    if ($listaitem != "") {
                        $dbwhere .= "and e62_item in ($listaitem) ";
                    }

                    if ($listasub != "") {
                        $dbwhere .= "and e62_item in ($listar) ";
                    }
                }

                $resitem = $clempempitem->sql_record($clempempitem->sql_query(null, null, "e62_item,pc01_descrmater,e62_quant,e62_vltot,e62_descr", null, $dbwhere));
                $rows_item = $clempempitem->numrows;

                for ($item = 0; $item < $rows_item; $item++) {
                    db_fieldsmemory($resitem, $item, true);

                    echo "$e62_item;$pc01_descrmater;";
                    echo db_formatar($e62_quant, 'f') . ";";
                    echo db_formatar($e62_vltot, 'f') . ";";
                    echo substr($e62_descr, 0, 100) . ";\n";
                }
            } else {
                $sCamposEmpenho  = "distinct riseqitem     as item_empenho";
                $sCamposEmpenho .= "         ,ricodmater   as e62_item";
                $sCamposEmpenho .= "         ,rsdescr      as pc01_descrmater";
                $sCamposEmpenho .= "         ,e62_descr";
                $sCamposEmpenho .= "         ,rnquantini   as e62_quant";
                $sCamposEmpenho .= "         ,rnvalorini   as e62_vltot";
                $sCamposEmpenho .= "         ,rnvaloruni";
                $sCamposEmpenho .= "         ,rnsaldoitem  as saldo";
                $sCamposEmpenho .= "         ,round(rnsaldovalor,2) as saldo_valor";
                $sCamposEmpenho .= "         ,o56_descr";
                $sCamposEmpenho .= "         ,case when pcorcamval.pc23_obs is not null";
                $sCamposEmpenho .= "              then pcorcamval.pc23_obs";
                $sCamposEmpenho .= "              else pcorcamvalpai.pc23_obs";
                $sCamposEmpenho .= "         end as observacao";
                $sWhereEmpenho   = "e60_numemp = {$objeto->e60_numemp}";

                $oDaoEmpenho      = db_utils::getDao("empempenho");
                $sSqlItensEmpenho = $oDaoEmpenho->sql_query_itens_consulta_empenho($objeto->e60_numemp, $sCamposEmpenho);
                $rsBuscaEmpenho   = $oDaoEmpenho->sql_record($sSqlItensEmpenho);
                for ($item = 0; $item < $oDaoEmpenho->numrows; $item++) {
                    db_fieldsmemory($rsBuscaEmpenho, $item, true);

                    echo "$e62_item;$pc01_descrmater;";
                    echo db_formatar($e62_quant, 'f') . ";";
                    echo db_formatar($e62_vltot, 'f') . ";";
                    echo db_formatar($saldo_valor, 'f') . ";";
                    echo substr($e62_descr, 0, 100) . ";\n";
                }
            }
        }
        if ($mostrarobs == "m") {
            echo "$objeto->e60_resumo;\n";
        }
        if (1 == 1) {

            $reslancam = $clconlancamemp->sql_record($clconlancamemp->sql_query("", "*", "c75_codlan", " c75_numemp = $objeto->e60_numemp " . ($processar == "a" ? "" : " and c75_data between '$objeto->dataesp11' and '$objeto->dataesp22'")));
            $rows_lancamemp = $clconlancamemp->numrows;
            for ($lancemp = 0; $lancemp < $rows_lancamemp; $lancemp++) {
                db_fieldsmemory($reslancam, $lancemp, true);
                $reslancamdoc = $clconlancamdoc->sql_record($clconlancamdoc->sql_query($c70_codlan, "*"));
                db_fieldsmemory($reslancamdoc, 0, true);
                if ($mostralan == "m") {

                    echo ";;;$c70_data;";
                    echo "$c70_codlan;";
                    echo "$c53_descr;";
                    echo db_formatar($c70_valor, 'f') . ";\n";
                }

                if ($c53_tipo == 10) {
                    $lanctotemp += $c70_valor;
                } elseif ($c53_tipo == 11) {
                    $lanctotanuemp += $c70_valor;
                } elseif ($c53_tipo == 20) {
                    $lanctotliq += $c70_valor;
                } elseif ($c53_tipo == 21) {
                    $lanctotanuliq += $c70_valor;
                } elseif ($c53_tipo == 30) {
                    $lanctotpag += $c70_valor;
                } elseif ($c53_tipo == 31) {
                    $lanctotanupag += $c70_valor;
                }
            }
        }

        $contEmpenhos++;

        if ($x == $rows - 1) {
            echo ";;;;;TOTAL DE $contEmpenhos EMPENHOS;$TotalEmpenhado;$TotalAnulado;$TotalLiquidado;$TotalPago;$TotalLiquidado2;$TotalNaoLiquidado;$TotalGeral;\n";
        }
    }

    echo "TOTAL DE EMPENHOS: $rows;;;;;TOTAL GERAL;$GeralTotalEmpenhado;$GeralTotalAnulado;$GeralTotalLiquidado;$GeralTotalPago;$GeralTotalLiquidado2;$GeralTotalNaoLiquidado;$GeralTotalGeral;\n";

    if ($processar == "a") {

        echo "MOVIMENTAO CONTABIL NO PERIODO;;;;;;"
            . db_formatar($lanctotemp, 'p') . ";"
            . db_formatar($lanctotanuemp, 'p') . ";"
            . db_formatar($lanctotliq - $lanctotanuliq, 'p') . ";"
            . db_formatar($lanctotpag - $lanctotanupag, 'p') . ";"
            . db_formatar(($lanctotliq - $lanctotanuliq) - ($lanctotpag - $lanctotanupag), 'p') . ";"
            . db_formatar(($lanctotemp - ($lanctotanuemp + ($lanctotpag - $lanctotanupag))) - (($lanctotliq - $lanctotanuliq) - ($lanctotpag - $lanctotanupag)), 'p') . ";"
            . db_formatar($lanctotemp - ($lanctotanuemp + ($lanctotpag - $lanctotanupag)), 'p') . ";";
    } else {

        echo "MOVIMENTAO CONTABIL NO PERIODO;;;;;;"
            . db_formatar($lanctotemp, 'p') . ";"
            . db_formatar($lanctotanuemp, 'p') . ";"
            . db_formatar($lanctotliq - $lanctotanuliq, 'p') . ";"
            . db_formatar($lanctotpag - $lanctotanupag, 'p') . ";";
    }
}

if ($agrupar == 'r') {

    $recursoAnt = '';
    $contEmpenhos = 0;
    echo "RECURSO;;;;TIPO DE RECURSO;;MOVIMENTACAO;;;;SALDO A PAGAR;;;\n";
    echo "TP COMPRA;LICI;EMP;EMISSAO;NOME;DOTACAO;EMPENHADO;ANULADO;LIQUIDADO;PAGO;LIQUIDADO;NAO LIQUID;GERAL;\n";
    if ($mostralan == "m") {
        echo ";;;DATA;LANCAMENTO;DOCUMENTO;VALOR;;;;;;;\n";
    }
    if ($mostraritem == "m") {
        if ($instits != db_getsession("DB_instit")) {
            echo "ITEM;DESCRICAO DO ITEM;QUANTIDADE;VALOR TOTAL;COMPLEMENTO;;;;;;\n";
        } else {
            echo "ITEM;DESCRICAO DO ITEM;QUANTIDADE;VALOR TOTAL;SALDO;COMPLEMENTO;;;;;;\n";
        }
    }

    for ($x = 0; $x < $rows; $x++) {
        //db_criatabela($res);exit;
        $objeto = db_utils::fieldsMemory($res, $x, true);

        if (empty($recursoAnt)) {
            $recursoAnt = "{$objeto->o15_codigo}";
            echo ";;;;$objeto->o15_codigo - $objeto->o15_descr;\n";
        }

        $dotacao = str_pad($objeto->e60_coddot, 4, '0', STR_PAD_LEFT);
        $EMPENHADO = db_formatar($objeto->e60_vlremp, 'f');
        $ANULADO = db_formatar($objeto->e60_vlranu, 'f');
        $LIQUIDADO = db_formatar($objeto->e60_vlrliq, 'f');
        $PAGO = db_formatar($objeto->e60_vlrpag, 'f');
        $LIQUIDADO2 = db_formatar($objeto->e60_vlrliq - $objeto->e60_vlrpag, 'f');
        $NAOLIQUID = db_formatar($objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrliq, 'f');
        $GERAL = db_formatar($objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrpag, 'f');


        if ($recursoAnt != "{$objeto->o15_codigo}") {

            echo ";;;;;TOTAL DE $contEmpenhos EMPENHOS;$TotalEmpenhado;$TotalAnulado;$TotalLiquidado;$TotalPago;$TotalLiquidado2;$TotalNaoLiquidado;$TotalGeral;\n";
            echo ";;;;$objeto->o15_codigo - $objeto->o15_descr;\n";
            $TotalEmpenhado    = 0;
            $TotalAnulado      = 0;
            $TotalLiquidado    = 0;
            $TotalPago         = 0;
            $TotalLiquidado2   = 0;
            $TotalNaoLiquidado = 0;
            $TotalGeral        = 0;

            $recursoAnt = "{$objeto->o15_codigo}";
            $contEmpenhos = 0;
        }

        $TotalEmpenhado    += $objeto->e60_vlremp;
        $TotalAnulado      += $objeto->e60_vlranu;
        $TotalLiquidado    += $objeto->e60_vlrliq;
        $TotalPago         += $objeto->e60_vlrpag;
        $TotalLiquidado2   += $objeto->e60_vlrliq - $objeto->e60_vlrpag;
        $TotalNaoLiquidado += $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrliq;
        $TotalGeral        += $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrpag;

        $GeralTotalEmpenhado    += $objeto->e60_vlremp;
        $GeralTotalAnulado      += $objeto->e60_vlranu;
        $GeralTotalLiquidado    += $objeto->e60_vlrliq;
        $GeralTotalPago         += $objeto->e60_vlrpag;
        $GeralTotalLiquidado2   += $objeto->e60_vlrliq - $objeto->e60_vlrpag;
        $GeralTotalNaoLiquidado += $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrliq;
        $GeralTotalGeral        += $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrpag;


        echo "$objeto->pc50_descr;$objeto->e60_numerol;$objeto->e60_codemp;$objeto->e60_emiss;$objeto->z01_nome;";
        echo "$dotacao - $objeto->dl_estrutural;$EMPENHADO;$ANULADO;$LIQUIDADO;$PAGO;$LIQUIDADO2;$NAOLIQUID;$GERAL;";
        echo "\n";

        if ($mostraritem == "m") {
            if ($instits != db_getsession("DB_instit")) {
                $dbwhere = "e62_numemp = $objeto->e60_numemp ";
                if ($listaitem != "" or $listasub != "") {
                    if ($listaitem != "") {
                        $dbwhere .= "and e62_item in ($listaitem) ";
                    }

                    if ($listasub != "") {
                        $dbwhere .= "and e62_item in ($listar) ";
                    }
                }

                $resitem = $clempempitem->sql_record($clempempitem->sql_query(null, null, "e62_item,pc01_descrmater,e62_quant,e62_vltot,e62_descr", null, $dbwhere));
                $rows_item = $clempempitem->numrows;

                for ($item = 0; $item < $rows_item; $item++) {
                    db_fieldsmemory($resitem, $item, true);

                    echo "$e62_item;$pc01_descrmater;";
                    echo db_formatar($e62_quant, 'f') . ";";
                    echo db_formatar($e62_vltot, 'f') . ";";
                    echo substr($e62_descr, 0, 100) . ";\n";
                }
            } else {
                $sCamposEmpenho  = "distinct riseqitem     as item_empenho";
                $sCamposEmpenho .= "         ,ricodmater   as e62_item";
                $sCamposEmpenho .= "         ,rsdescr      as pc01_descrmater";
                $sCamposEmpenho .= "         ,e62_descr";
                $sCamposEmpenho .= "         ,rnquantini   as e62_quant";
                $sCamposEmpenho .= "         ,rnvalorini   as e62_vltot";
                $sCamposEmpenho .= "         ,rnvaloruni";
                $sCamposEmpenho .= "         ,rnsaldoitem  as saldo";
                $sCamposEmpenho .= "         ,round(rnsaldovalor,2) as saldo_valor";
                $sCamposEmpenho .= "         ,o56_descr";
                $sCamposEmpenho .= "         ,case when pcorcamval.pc23_obs is not null";
                $sCamposEmpenho .= "              then pcorcamval.pc23_obs";
                $sCamposEmpenho .= "              else pcorcamvalpai.pc23_obs";
                $sCamposEmpenho .= "         end as observacao";
                $sWhereEmpenho   = "e60_numemp = {$objeto->e60_numemp}";

                $oDaoEmpenho      = db_utils::getDao("empempenho");
                $sSqlItensEmpenho = $oDaoEmpenho->sql_query_itens_consulta_empenho($objeto->e60_numemp, $sCamposEmpenho);
                $rsBuscaEmpenho   = $oDaoEmpenho->sql_record($sSqlItensEmpenho);
                for ($item = 0; $item < $oDaoEmpenho->numrows; $item++) {
                    db_fieldsmemory($rsBuscaEmpenho, $item, true);

                    echo "$e62_item;$pc01_descrmater;";
                    echo db_formatar($e62_quant, 'f') . ";";
                    echo db_formatar($e62_vltot, 'f') . ";";
                    echo db_formatar($saldo_valor, 'f') . ";";
                    echo substr($e62_descr, 0, 100) . ";\n";
                }
            }
        }
        if ($mostrarobs == "m") {
            echo "$objeto->e60_resumo;\n";
        }
        if (1 == 1) {

            $reslancam = $clconlancamemp->sql_record($clconlancamemp->sql_query("", "*", "c75_codlan", " c75_numemp = $objeto->e60_numemp " . ($processar == "a" ? "" : " and c75_data between '$objeto->dataesp11' and '$objeto->dataesp22'")));
            $rows_lancamemp = $clconlancamemp->numrows;
            for ($lancemp = 0; $lancemp < $rows_lancamemp; $lancemp++) {
                db_fieldsmemory($reslancam, $lancemp, true);
                $reslancamdoc = $clconlancamdoc->sql_record($clconlancamdoc->sql_query($c70_codlan, "*"));
                db_fieldsmemory($reslancamdoc, 0, true);
                if ($mostralan == "m") {

                    echo ";;;$c70_data;";
                    echo "$c70_codlan;";
                    echo "$c53_descr;";
                    echo db_formatar($c70_valor, 'f') . ";\n";
                }

                if ($c53_tipo == 10) {
                    $lanctotemp += $c70_valor;
                } elseif ($c53_tipo == 11) {
                    $lanctotanuemp += $c70_valor;
                } elseif ($c53_tipo == 20) {
                    $lanctotliq += $c70_valor;
                } elseif ($c53_tipo == 21) {
                    $lanctotanuliq += $c70_valor;
                } elseif ($c53_tipo == 30) {
                    $lanctotpag += $c70_valor;
                } elseif ($c53_tipo == 31) {
                    $lanctotanupag += $c70_valor;
                }
            }
        }

        $contEmpenhos++;

        if ($x == $rows - 1) {
            echo ";;;;;TOTAL DE $contEmpenhos EMPENHOS;$TotalEmpenhado;$TotalAnulado;$TotalLiquidado;$TotalPago;$TotalLiquidado2;$TotalNaoLiquidado;$TotalGeral;\n";
        }
    }

    echo "TOTAL DE EMPENHOS: $rows;;;;;TOTAL GERAL;$GeralTotalEmpenhado;$GeralTotalAnulado;$GeralTotalLiquidado;$GeralTotalPago;$GeralTotalLiquidado2;$GeralTotalNaoLiquidado;$GeralTotalGeral;\n";

    if ($processar == "a") {

        echo "MOVIMENTAO CONTABIL NO PERIODO;;;;;;"
            . db_formatar($lanctotemp, 'p') . ";"
            . db_formatar($lanctotanuemp, 'p') . ";"
            . db_formatar($lanctotliq - $lanctotanuliq, 'p') . ";"
            . db_formatar($lanctotpag - $lanctotanupag, 'p') . ";"
            . db_formatar(($lanctotliq - $lanctotanuliq) - ($lanctotpag - $lanctotanupag), 'p') . ";"
            . db_formatar(($lanctotemp - ($lanctotanuemp + ($lanctotpag - $lanctotanupag))) - (($lanctotliq - $lanctotanuliq) - ($lanctotpag - $lanctotanupag)), 'p') . ";"
            . db_formatar($lanctotemp - ($lanctotanuemp + ($lanctotpag - $lanctotanupag)), 'p') . ";";
    } else {

        echo "MOVIMENTAO CONTABIL NO PERIODO;;;;;;"
            . db_formatar($lanctotemp, 'p') . ";"
            . db_formatar($lanctotanuemp, 'p') . ";"
            . db_formatar($lanctotliq - $lanctotanuliq, 'p') . ";"
            . db_formatar($lanctotpag - $lanctotanupag, 'p') . ";";
    }
}

if ($agrupar == 'd') {
    if ($sememp == "s") {
        $encoding = mb_internal_encoding(); // ou UTF-8, ISO-8859-1...
        $desdobraAnt = '';
        $contEmpenhos = 0;
        echo "ELEMENTO;;DESCRICAO;;MOVIMENTACAO;;;;SALDO A PAGAR;;;\n";
        echo "NUMERO DO ELEMENTO;ELEMENTO;NOME;QUANTIDADE;EMPENHADO;ANULADO;LIQUIDADO;PAGO;LIQUIDADO;NAO LIQUID;GERAL;\n";
        if ($mostralan == "m") {

            echo ";;;DATA;LANCAMENTO;DOCUMENTO;VALOR;;;;;;;\n";
        }
        if ($mostraritem == "m") {
            if ($instits != db_getsession("DB_instit")) {
                echo "ITEM;DESCRICAO DO ITEM;QUANTIDADE;VALOR TOTAL;COMPLEMENTO;;;;;;\n";
            } else {
                echo "ITEM;DESCRICAO DO ITEM;QUANTIDADE;VALOR TOTAL;SALDO;COMPLEMENTO;;;;;;\n";
            }
        }

        for ($x = 0; $x < $rows; $x++) {

            $objeto = db_utils::fieldsMemory($res, $x, true);
            $contempenho = str_pad($objeto->e60_numemp, 1, '0', STR_PAD_LEFT);
            $dotacao = str_pad($objeto->e60_coddot, 4, '0', STR_PAD_LEFT);
            $EMPENHADO = db_formatar($objeto->e60_vlremp, 'f');
            $ANULADO = db_formatar($objeto->e60_vlranu, 'f');
            $LIQUIDADO = db_formatar($objeto->e60_vlrliq, 'f');
            $PAGO = db_formatar($objeto->e60_vlrpag, 'f');
            $LIQUIDADO2 = db_formatar($objeto->e60_vlrliq - $objeto->e60_vlrpag, 'f');
            $NAOLIQUID = db_formatar($objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrliq, 'f');
            $GERAL = db_formatar($objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrpag, 'f');
            $contEmpenhos = $contempenho;

            $TotalEmpenhado    = $objeto->e60_vlremp;
            $TotalAnulado      = $objeto->e60_vlranu;
            $TotalLiquidado    = $objeto->e60_vlrliq;
            $TotalPago         = $objeto->e60_vlrpag;
            $TotalLiquidado2   = $objeto->e60_vlrliq - $objeto->e60_vlrpag;
            $TotalNaoLiquidado = $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrliq;
            $TotalGeral        = $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrpag;
            if (empty($desdobraAnt)) {
                $desdobraAnt = "{$objeto->e64_codele}";
                $descricao = mb_strtoupper($objeto->o56_descr, $encoding);
                echo "$objeto->e64_codele;$objeto->o56_elemento;$descricao;TOTAL DE $contEmpenhos EMPENHO (S);$TotalEmpenhado;$TotalAnulado;$TotalLiquidado;$TotalPago;$TotalLiquidado2;$TotalNaoLiquidado;$TotalGeral;\n";
            }
            $TotalEmpenhado    = $objeto->e60_vlremp;
            $TotalAnulado      = $objeto->e60_vlranu;
            $TotalLiquidado    = $objeto->e60_vlrliq;
            $TotalPago         = $objeto->e60_vlrpag;
            $TotalLiquidado2   = $objeto->e60_vlrliq - $objeto->e60_vlrpag;
            $TotalNaoLiquidado = $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrliq;
            $TotalGeral        = $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrpag;

            $GeralTotalEmpenhado    = $objeto->e60_vlremp;
            $GeralTotalAnulado      = $objeto->e60_vlranu;
            $GeralTotalLiquidado    = $objeto->e60_vlrliq;
            $GeralTotalPago         = $objeto->e60_vlrpag;
            $GeralTotalLiquidado2   = $objeto->e60_vlrliq - $objeto->e60_vlrpag;
            $GeralTotalNaoLiquidado = $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrliq;
            $GeralTotalGeral        = $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrpag;
            if ($desdobraAnt != "{$objeto->e64_codele}") {
                $descricao = mb_strtoupper($objeto->o56_descr, $encoding);
                echo "$objeto->e64_codele;$objeto->o56_elemento;$descricao;TOTAL DE $contEmpenhos EMPENHO (S);$TotalEmpenhado;$TotalAnulado;$TotalLiquidado;$TotalPago;$TotalLiquidado2;$TotalNaoLiquidado;$TotalGeral;\n";

                $TotalEmpenhado    = 0;
                $TotalAnulado      = 0;
                $TotalLiquidado    = 0;
                $TotalPago         = 0;
                $TotalLiquidado2   = 0;
                $TotalNaoLiquidado = 0;
                $TotalGeral        = 0;

                $desdobraAnt = "{$objeto->e64_codele}";
                $contEmpenhos = 0;
            }

            $TotalEmpenhado    += $objeto->e60_vlremp;
            $TotalAnulado      += $objeto->e60_vlranu;
            $TotalLiquidado    += $objeto->e60_vlrliq;
            $TotalPago         += $objeto->e60_vlrpag;
            $TotalLiquidado2   += $objeto->e60_vlrliq - $objeto->e60_vlrpag;
            $TotalNaoLiquidado += $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrliq;
            $TotalGeral        += $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrpag;

            $GeralTotalEmpenhado    += $objeto->e60_vlremp;
            $GeralTotalAnulado      += $objeto->e60_vlranu;
            $GeralTotalLiquidado    += $objeto->e60_vlrliq;
            $GeralTotalPago         += $objeto->e60_vlrpag;
            $GeralTotalLiquidado2   += $objeto->e60_vlrliq - $objeto->e60_vlrpag;
            $GeralTotalNaoLiquidado += $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrliq;
            $GeralTotalGeral        += $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrpag;

            // echo "$objeto->o56_elemento;$objeto->e60_numerol;$objeto->e60_codemp;$objeto->e60_emiss;$objeto->z01_nome;";
            // echo "$objeto->o56_elemento;$objeto->e60_numerol;$objeto->e60_codemp;$objeto->e60_emiss;$objeto->z01_nome;";
            // echo "$dotacao - $objeto->dl_estrutural;$EMPENHADO;$ANULADO;$LIQUIDADO;$PAGO;$LIQUIDADO2;$NAOLIQUID;$GERAL;";
            echo "\n";

            if ($mostraritem == "m") {
                if ($instits != db_getsession("DB_instit")) {
                    $dbwhere = "e62_numemp = $objeto->e60_numemp ";
                    if ($listaitem != "" or $listasub != "") {
                        if ($listaitem != "") {
                            $dbwhere .= "and e62_item in ($listaitem) ";
                        }

                        if ($listasub != "") {
                            $dbwhere .= "and e62_item in ($listar) ";
                        }
                    }

                    $resitem = $clempempitem->sql_record($clempempitem->sql_query(null, null, "e62_item,pc01_descrmater,e62_quant,e62_vltot,e62_descr", null, $dbwhere));
                    $rows_item = $clempempitem->numrows;

                    for ($item = 0; $item < $rows_item; $item++) {
                        db_fieldsmemory($resitem, $item, true);

                        echo "$e62_item;$pc01_descrmater;";
                        echo db_formatar($e62_quant, 'f') . ";";
                        echo db_formatar($e62_vltot, 'f') . ";";
                        echo substr($e62_descr, 0, 100) . ";\n";
                    }
                } else {
                    $sCamposEmpenho  = "distinct riseqitem     as item_empenho";
                    $sCamposEmpenho .= "         ,ricodmater   as e62_item";
                    $sCamposEmpenho .= "         ,rsdescr      as pc01_descrmater";
                    $sCamposEmpenho .= "         ,e62_descr";
                    $sCamposEmpenho .= "         ,rnquantini   as e62_quant";
                    $sCamposEmpenho .= "         ,rnvalorini   as e62_vltot";
                    $sCamposEmpenho .= "         ,rnvaloruni";
                    $sCamposEmpenho .= "         ,rnsaldoitem  as saldo";
                    $sCamposEmpenho .= "         ,round(rnsaldovalor,2) as saldo_valor";
                    $sCamposEmpenho .= "         ,o56_descr";
                    $sCamposEmpenho .= "         ,case when pcorcamval.pc23_obs is not null";
                    $sCamposEmpenho .= "              then pcorcamval.pc23_obs";
                    $sCamposEmpenho .= "              else pcorcamvalpai.pc23_obs";
                    $sCamposEmpenho .= "         end as observacao";
                    $sWhereEmpenho   = "e60_numemp = {$objeto->e60_numemp}";

                    $oDaoEmpenho      = db_utils::getDao("empempenho");
                    $sSqlItensEmpenho = $oDaoEmpenho->sql_query_itens_consulta_empenho($objeto->e60_numemp, $sCamposEmpenho);
                    $rsBuscaEmpenho   = $oDaoEmpenho->sql_record($sSqlItensEmpenho);
                    for ($item = 0; $item < $oDaoEmpenho->numrows; $item++) {
                        db_fieldsmemory($rsBuscaEmpenho, $item, true);

                        echo "$e62_item;$pc01_descrmater;";
                        echo db_formatar($e62_quant, 'f') . ";";
                        echo db_formatar($e62_vltot, 'f') . ";";
                        echo db_formatar($saldo_valor, 'f') . ";";
                        echo substr($e62_descr, 0, 100) . ";\n";
                    }
                }
            }
            if ($mostrarobs == "m") {
                echo "$objeto->e60_resumo;\n";
            }
            if (1 == 1) {

                $reslancam = $clconlancamemp->sql_record($clconlancamemp->sql_query("", "*", "c75_codlan", " c75_numemp = $objeto->e60_numemp " . ($processar == "a" ? "" : " and c75_data between '$objeto->dataesp11' and '$objeto->dataesp22'")));
                $rows_lancamemp = $clconlancamemp->numrows;
                for ($lancemp = 0; $lancemp < $rows_lancamemp; $lancemp++) {
                    db_fieldsmemory($reslancam, $lancemp, true);
                    $reslancamdoc = $clconlancamdoc->sql_record($clconlancamdoc->sql_query($c70_codlan, "*"));
                    db_fieldsmemory($reslancamdoc, 0, true);
                    if ($mostralan == "m") {

                        echo ";;;$c70_data;";
                        echo "$c70_codlan;";
                        echo "$c53_descr;";
                        echo db_formatar($c70_valor, 'f') . ";\n";
                    }

                    if ($c53_tipo == 10) {
                        $lanctotemp += $c70_valor;
                    } elseif ($c53_tipo == 11) {
                        $lanctotanuemp += $c70_valor;
                    } elseif ($c53_tipo == 20) {
                        $lanctotliq += $c70_valor;
                    } elseif ($c53_tipo == 21) {
                        $lanctotanuliq += $c70_valor;
                    } elseif ($c53_tipo == 30) {
                        $lanctotpag += $c70_valor;
                    } elseif ($c53_tipo == 31) {
                        $lanctotanupag += $c70_valor;
                    }
                }
            }

            $contEmpenhos++;

            /*if ($x == $rows - 1) {
                    echo ";;;;;TOTAL DE $contEmpenhos EMPENHOS;$TotalEmpenhado;$TotalAnulado;$TotalLiquidado;$TotalPago;$TotalLiquidado2;$TotalNaoLiquidado;$TotalGeral;\n";
                }*/
        }

        echo "TOTAL DE EMPENHOS: $rows;;;;;TOTAL GERAL;$GeralTotalEmpenhado;$GeralTotalAnulado;$GeralTotalLiquidado;$GeralTotalPago;$GeralTotalLiquidado2;$GeralTotalNaoLiquidado;$GeralTotalGeral;\n";

        if ($processar == "a") {

            echo "MOVIMENTAO CONTABIL NO PERIODO;;;;;;"
                . db_formatar($lanctotemp, 'p') . ";"
                . db_formatar($lanctotanuemp, 'p') . ";"
                . db_formatar($lanctotliq - $lanctotanuliq, 'p') . ";"
                . db_formatar($lanctotpag - $lanctotanupag, 'p') . ";"
                . db_formatar(($lanctotliq - $lanctotanuliq) - ($lanctotpag - $lanctotanupag), 'p') . ";"
                . db_formatar(($lanctotemp - ($lanctotanuemp + ($lanctotpag - $lanctotanupag))) - (($lanctotliq - $lanctotanuliq) - ($lanctotpag - $lanctotanupag)), 'p') . ";"
                . db_formatar($lanctotemp - ($lanctotanuemp + ($lanctotpag - $lanctotanupag)), 'p') . ";";
        } else {

            echo "MOVIMENTAO CONTABIL NO PERIODO;;;;;;"
                . db_formatar($lanctotemp, 'p') . ";"
                . db_formatar($lanctotanuemp, 'p') . ";"
                . db_formatar($lanctotliq - $lanctotanuliq, 'p') . ";"
                . db_formatar($lanctotpag - $lanctotanupag, 'p') . ";";
        }
    } else {
        $encoding = mb_internal_encoding(); // ou UTF-8, ISO-8859-1...
        $desdobraAnt = '';
        $contEmpenhos = 0;
        echo "ELEMENTO;;;;DESCRICAO;;MOVIMENTACAO;;;;SALDO A PAGAR;;;\n";
        echo "TP COMPRA;LICI;EMP;EMISSAO;NOME;QUANTIDADE;EMPENHADO;ANULADO;LIQUIDADO;PAGO;LIQUIDADO;NAO LIQUID;GERAL;\n";
        if ($mostralan == "m") {

            echo ";;;DATA;LANCAMENTO;DOCUMENTO;VALOR;;;;;;;\n";
        }
        if ($mostraritem == "m") {
            if ($instits != db_getsession("DB_instit")) {
                echo "ITEM;DESCRICAO DO ITEM;QUANTIDADE;VALOR TOTAL;COMPLEMENTO;;;;;;\n";
            } else {
                echo "ITEM;DESCRICAO DO ITEM;QUANTIDADE;VALOR TOTAL;SALDO;COMPLEMENTO;;;;;;\n";
            }
        }

        for ($x = 0; $x < $rows; $x++) {

            $objeto = db_utils::fieldsMemory($res, $x, true);

            $contempenho = str_pad($objeto->e60_numemp, 1, '0', STR_PAD_LEFT);
            $dotacao = str_pad($objeto->e60_coddot, 4, '0', STR_PAD_LEFT);
            $EMPENHADO = db_formatar($objeto->e60_vlremp, 'f');
            $ANULADO = db_formatar($objeto->e60_vlranu, 'f');
            $LIQUIDADO = db_formatar($objeto->e60_vlrliq, 'f');
            $PAGO = db_formatar($objeto->e60_vlrpag, 'f');
            $LIQUIDADO2 = db_formatar($objeto->e60_vlrliq - $objeto->e60_vlrpag, 'f');
            $NAOLIQUID = db_formatar($objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrliq, 'f');
            $GERAL = db_formatar($objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrpag, 'f');
            $contEmpenhos = $contempenho;
            if (empty($desdobraAnt)) {
                $desdobraAnt = "{$objeto->e64_codele}";
                $descricao = mb_strtoupper($objeto->o56_descr, $encoding);
                echo ";;;$objeto->e64_codele ;$descricao);\n";
                echo ";;;;;TOTAL DE $contEmpenhos EMPENHOS;$TotalEmpenhado;$TotalAnulado;$TotalLiquidado;$TotalPago;$TotalLiquidado2;$TotalNaoLiquidado;$TotalGeral;\n";
            }
            $TotalEmpenhado    = $objeto->e60_vlremp;
            $TotalAnulado      = $objeto->e60_vlranu;
            $TotalLiquidado    = $objeto->e60_vlrliq;
            $TotalPago         = $objeto->e60_vlrpag;
            $TotalLiquidado2   = $objeto->e60_vlrliq - $objeto->e60_vlrpag;
            $TotalNaoLiquidado = $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrliq;
            $TotalGeral        = $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrpag;

            $GeralTotalEmpenhado    = $objeto->e60_vlremp;
            $GeralTotalAnulado      = $objeto->e60_vlranu;
            $GeralTotalLiquidado    = $objeto->e60_vlrliq;
            $GeralTotalPago         = $objeto->e60_vlrpag;
            $GeralTotalLiquidado2   = $objeto->e60_vlrliq - $objeto->e60_vlrpag;
            $GeralTotalNaoLiquidado = $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrliq;
            $GeralTotalGeral        = $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrpag;
            if ($desdobraAnt != "{$objeto->e64_codele}") {
                $descricao = mb_strtoupper($objeto->o56_descr, $encoding);
                echo ";;;$objeto->e64_codele ;$descricao);\n";
                echo ";;;;;TOTAL DE $contEmpenhos EMPENHOS;$TotalEmpenhado;$TotalAnulado;$TotalLiquidado;$TotalPago;$TotalLiquidado2;$TotalNaoLiquidado;$TotalGeral;\n";

                $TotalEmpenhado    = 0;
                $TotalAnulado      = 0;
                $TotalLiquidado    = 0;
                $TotalPago         = 0;
                $TotalLiquidado2   = 0;
                $TotalNaoLiquidado = 0;
                $TotalGeral        = 0;

                $desdobraAnt = "{$objeto->e64_codele}";
                $contEmpenhos = 0;
            }

            $TotalEmpenhado    += $objeto->e60_vlremp;
            $TotalAnulado      += $objeto->e60_vlranu;
            $TotalLiquidado    += $objeto->e60_vlrliq;
            $TotalPago         += $objeto->e60_vlrpag;
            $TotalLiquidado2   += $objeto->e60_vlrliq - $objeto->e60_vlrpag;
            $TotalNaoLiquidado += $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrliq;
            $TotalGeral        += $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrpag;

            $GeralTotalEmpenhado    += $objeto->e60_vlremp;
            $GeralTotalAnulado      += $objeto->e60_vlranu;
            $GeralTotalLiquidado    += $objeto->e60_vlrliq;
            $GeralTotalPago         += $objeto->e60_vlrpag;
            $GeralTotalLiquidado2   += $objeto->e60_vlrliq - $objeto->e60_vlrpag;
            $GeralTotalNaoLiquidado += $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrliq;
            $GeralTotalGeral        += $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrpag;


            echo "$objeto->pc50_descr;$objeto->e60_numerol;$objeto->e60_codemp;$objeto->e60_emiss;$objeto->z01_nome;";
            echo "$dotacao - $objeto->dl_estrutural;$EMPENHADO;$ANULADO;$LIQUIDADO;$PAGO;$LIQUIDADO2;$NAOLIQUID;$GERAL;";
            echo "\n";

            if ($mostraritem == "m") {
                if ($instits != db_getsession("DB_instit")) {
                    $dbwhere = "e62_numemp = $objeto->e60_numemp ";
                    if ($listaitem != "" or $listasub != "") {
                        if ($listaitem != "") {
                            $dbwhere .= "and e62_item in ($listaitem) ";
                        }

                        if ($listasub != "") {
                            $dbwhere .= "and e62_item in ($listar) ";
                        }
                    }

                    $resitem = $clempempitem->sql_record($clempempitem->sql_query(null, null, "e62_item,pc01_descrmater,e62_quant,e62_vltot,e62_descr", null, $dbwhere));
                    $rows_item = $clempempitem->numrows;

                    for ($item = 0; $item < $rows_item; $item++) {
                        db_fieldsmemory($resitem, $item, true);

                        echo "$e62_item;$pc01_descrmater;";
                        echo db_formatar($e62_quant, 'f') . ";";
                        echo db_formatar($e62_vltot, 'f') . ";";
                        echo substr($e62_descr, 0, 100) . ";\n";
                    }
                } else {
                    $sCamposEmpenho  = "distinct riseqitem     as item_empenho";
                    $sCamposEmpenho .= "         ,ricodmater   as e62_item";
                    $sCamposEmpenho .= "         ,rsdescr      as pc01_descrmater";
                    $sCamposEmpenho .= "         ,e62_descr";
                    $sCamposEmpenho .= "         ,rnquantini   as e62_quant";
                    $sCamposEmpenho .= "         ,rnvalorini   as e62_vltot";
                    $sCamposEmpenho .= "         ,rnvaloruni";
                    $sCamposEmpenho .= "         ,rnsaldoitem  as saldo";
                    $sCamposEmpenho .= "         ,round(rnsaldovalor,2) as saldo_valor";
                    $sCamposEmpenho .= "         ,o56_descr";
                    $sCamposEmpenho .= "         ,case when pcorcamval.pc23_obs is not null";
                    $sCamposEmpenho .= "              then pcorcamval.pc23_obs";
                    $sCamposEmpenho .= "              else pcorcamvalpai.pc23_obs";
                    $sCamposEmpenho .= "         end as observacao";
                    $sWhereEmpenho   = "e60_numemp = {$objeto->e60_numemp}";

                    $oDaoEmpenho      = db_utils::getDao("empempenho");
                    $sSqlItensEmpenho = $oDaoEmpenho->sql_query_itens_consulta_empenho($objeto->e60_numemp, $sCamposEmpenho);
                    $rsBuscaEmpenho   = $oDaoEmpenho->sql_record($sSqlItensEmpenho);
                    for ($item = 0; $item < $oDaoEmpenho->numrows; $item++) {
                        db_fieldsmemory($rsBuscaEmpenho, $item, true);

                        echo "$e62_item;$pc01_descrmater;";
                        echo db_formatar($e62_quant, 'f') . ";";
                        echo db_formatar($e62_vltot, 'f') . ";";
                        echo db_formatar($saldo_valor, 'f') . ";";
                        echo substr($e62_descr, 0, 100) . ";\n";
                    }
                }
            }
            if ($mostrarobs == "m") {
                echo "$objeto->e60_resumo;\n";
            }
            if (1 == 1) {

                $reslancam = $clconlancamemp->sql_record($clconlancamemp->sql_query("", "*", "c75_codlan", " c75_numemp = $objeto->e60_numemp " . ($processar == "a" ? "" : " and c75_data between '$objeto->dataesp11' and '$objeto->dataesp22'")));
                $rows_lancamemp = $clconlancamemp->numrows;
                for ($lancemp = 0; $lancemp < $rows_lancamemp; $lancemp++) {
                    db_fieldsmemory($reslancam, $lancemp, true);
                    $reslancamdoc = $clconlancamdoc->sql_record($clconlancamdoc->sql_query($c70_codlan, "*"));
                    db_fieldsmemory($reslancamdoc, 0, true);
                    if ($mostralan == "m") {

                        echo ";;;$c70_data;";
                        echo "$c70_codlan;";
                        echo "$c53_descr;";
                        echo db_formatar($c70_valor, 'f') . ";\n";
                    }

                    if ($c53_tipo == 10) {
                        $lanctotemp += $c70_valor;
                    } elseif ($c53_tipo == 11) {
                        $lanctotanuemp += $c70_valor;
                    } elseif ($c53_tipo == 20) {
                        $lanctotliq += $c70_valor;
                    } elseif ($c53_tipo == 21) {
                        $lanctotanuliq += $c70_valor;
                    } elseif ($c53_tipo == 30) {
                        $lanctotpag += $c70_valor;
                    } elseif ($c53_tipo == 31) {
                        $lanctotanupag += $c70_valor;
                    }
                }
            }

            $contEmpenhos++;

            /*if ($x == $rows - 1) {
                echo ";;;;;TOTAL DE $contEmpenhos EMPENHOS;$TotalEmpenhado;$TotalAnulado;$TotalLiquidado;$TotalPago;$TotalLiquidado2;$TotalNaoLiquidado;$TotalGeral;\n";
            }*/
        }

        echo "TOTAL DE EMPENHOS: $rows;;;;;TOTAL GERAL;$GeralTotalEmpenhado;$GeralTotalAnulado;$GeralTotalLiquidado;$GeralTotalPago;$GeralTotalLiquidado2;$GeralTotalNaoLiquidado;$GeralTotalGeral;\n";

        if ($processar == "a") {

            echo "MOVIMENTAO CONTABIL NO PERIODO;;;;;;"
                . db_formatar($lanctotemp, 'p') . ";"
                . db_formatar($lanctotanuemp, 'p') . ";"
                . db_formatar($lanctotliq - $lanctotanuliq, 'p') . ";"
                . db_formatar($lanctotpag - $lanctotanupag, 'p') . ";"
                . db_formatar(($lanctotliq - $lanctotanuliq) - ($lanctotpag - $lanctotanupag), 'p') . ";"
                . db_formatar(($lanctotemp - ($lanctotanuemp + ($lanctotpag - $lanctotanupag))) - (($lanctotliq - $lanctotanuliq) - ($lanctotpag - $lanctotanupag)), 'p') . ";"
                . db_formatar($lanctotemp - ($lanctotanuemp + ($lanctotpag - $lanctotanupag)), 'p') . ";";
        } else {

            echo "MOVIMENTAO CONTABIL NO PERIODO;;;;;;"
                . db_formatar($lanctotemp, 'p') . ";"
                . db_formatar($lanctotanuemp, 'p') . ";"
                . db_formatar($lanctotliq - $lanctotanuliq, 'p') . ";"
                . db_formatar($lanctotpag - $lanctotanupag, 'p') . ";";
        }
    }
}

if ($agrupar == 'ta') {
    $recursoAnt = '';
    $contEmpenhos = 0;
    echo "TP COMPRA;LICI;EMP;EMISSAO;DOTACAO;EMPENHADO;ANULADO;LIQUIDADO;PAGO;LIQUIDADO;NAO LIQUID;GERAL;\n";
    if ($mostralan == "m") {
        echo ";;;DATA;LANCAMENTO;DOCUMENTO;VALOR;;;;;;;\n";
    }
    if ($mostraritem == "m") {
        if ($instits != db_getsession("DB_instit")) {
            echo "ITEM;DESCRICAO DO ITEM;QUANTIDADE;VALOR TOTAL;COMPLEMENTO;;;;;;\n";
        } else {
            echo "ITEM;DESCRICAO DO ITEM;QUANTIDADE;VALOR TOTAL;SALDO;COMPLEMENTO;;;;;;\n";
        }
    }

    for ($x = 0; $x < $rows; $x++) {
        //        db_criatabela($res);exit;
        $objeto = db_utils::fieldsMemory($res, $x, true);

        if (empty($tipoanterior)) {
            $tipoanterior = "{$objeto->e94_empanuladotipo}";
            //            echo ";;;;$objeto->e94_empanuladotipo - $objeto->e38_descr;\n";
        }

        $dotacao = str_pad($objeto->e60_coddot, 4, '0', STR_PAD_LEFT);
        $EMPENHADO = db_formatar($objeto->e60_vlremp, 'f');
        $ANULADO = db_formatar($objeto->e60_vlranu, 'f');
        $LIQUIDADO = db_formatar($objeto->e60_vlrliq, 'f');
        $PAGO = db_formatar($objeto->e60_vlrpag, 'f');
        $LIQUIDADO2 = db_formatar($objeto->e60_vlrliq - $objeto->e60_vlrpag, 'f');
        $NAOLIQUID = db_formatar($objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrliq, 'f');
        $GERAL = db_formatar($objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrpag, 'f');


        if ($recursoAnt != "{$objeto->o15_codigo}") {

            echo ";;;;;TOTAL DE $contEmpenhos EMPENHOS;$TotalEmpenhado;$TotalAnulado;$TotalLiquidado;$TotalPago;$TotalLiquidado2;$TotalNaoLiquidado;$TotalGeral;\n";
            echo ";;;;$objeto->e94_empanuladotipo - $objeto->e38_descr;\n";
            $TotalEmpenhado    = 0;
            $TotalAnulado      = 0;
            $TotalLiquidado    = 0;
            $TotalPago         = 0;
            $TotalLiquidado2   = 0;
            $TotalNaoLiquidado = 0;
            $TotalGeral        = 0;

            $recursoAnt = "{$objeto->o15_codigo}";
            $contEmpenhos = 0;
        }

        $TotalEmpenhado    += $objeto->e60_vlremp;
        $TotalAnulado      += $objeto->e60_vlranu;
        $TotalLiquidado    += $objeto->e60_vlrliq;
        $TotalPago         += $objeto->e60_vlrpag;
        $TotalLiquidado2   += $objeto->e60_vlrliq - $objeto->e60_vlrpag;
        $TotalNaoLiquidado += $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrliq;
        $TotalGeral        += $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrpag;

        $GeralTotalEmpenhado    += $objeto->e60_vlremp;
        $GeralTotalAnulado      += $objeto->e60_vlranu;
        $GeralTotalLiquidado    += $objeto->e60_vlrliq;
        $GeralTotalPago         += $objeto->e60_vlrpag;
        $GeralTotalLiquidado2   += $objeto->e60_vlrliq - $objeto->e60_vlrpag;
        $GeralTotalNaoLiquidado += $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrliq;
        $GeralTotalGeral        += $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrpag;


        echo "$objeto->pc50_descr;$objeto->e60_numerol;$objeto->e60_codemp;$objeto->e60_emiss;";
        echo "$dotacao - $objeto->dl_estrutural;$EMPENHADO;$ANULADO;$LIQUIDADO;$PAGO;$LIQUIDADO2;$NAOLIQUID;$GERAL;";
        echo "\n";

        if ($mostraritem == "m") {
            if ($instits != db_getsession("DB_instit")) {
                $dbwhere = "e62_numemp = $objeto->e60_numemp ";
                if ($listaitem != "" or $listasub != "") {
                    if ($listaitem != "") {
                        $dbwhere .= "and e62_item in ($listaitem) ";
                    }

                    if ($listasub != "") {
                        $dbwhere .= "and e62_item in ($listar) ";
                    }
                }

                $resitem = $clempempitem->sql_record($clempempitem->sql_query(null, null, "e62_item,pc01_descrmater,e62_quant,e62_vltot,e62_descr", null, $dbwhere));
                $rows_item = $clempempitem->numrows;

                for ($item = 0; $item < $rows_item; $item++) {
                    db_fieldsmemory($resitem, $item, true);

                    echo "$e62_item;$pc01_descrmater;";
                    echo db_formatar($e62_quant, 'f') . ";";
                    echo db_formatar($e62_vltot, 'f') . ";";
                    echo substr($e62_descr, 0, 100) . ";\n";
                }
            } else {
                $sCamposEmpenho  = "distinct riseqitem     as item_empenho";
                $sCamposEmpenho .= "         ,ricodmater   as e62_item";
                $sCamposEmpenho .= "         ,rsdescr      as pc01_descrmater";
                $sCamposEmpenho .= "         ,e62_descr";
                $sCamposEmpenho .= "         ,rnquantini   as e62_quant";
                $sCamposEmpenho .= "         ,rnvalorini   as e62_vltot";
                $sCamposEmpenho .= "         ,rnvaloruni";
                $sCamposEmpenho .= "         ,rnsaldoitem  as saldo";
                $sCamposEmpenho .= "         ,round(rnsaldovalor,2) as saldo_valor";
                $sCamposEmpenho .= "         ,o56_descr";
                $sCamposEmpenho .= "         ,case when pcorcamval.pc23_obs is not null";
                $sCamposEmpenho .= "              then pcorcamval.pc23_obs";
                $sCamposEmpenho .= "              else pcorcamvalpai.pc23_obs";
                $sCamposEmpenho .= "         end as observacao";
                $sWhereEmpenho   = "e60_numemp = {$objeto->e60_numemp}";

                $oDaoEmpenho      = db_utils::getDao("empempenho");
                $sSqlItensEmpenho = $oDaoEmpenho->sql_query_itens_consulta_empenho($objeto->e60_numemp, $sCamposEmpenho);
                $rsBuscaEmpenho   = $oDaoEmpenho->sql_record($sSqlItensEmpenho);
                for ($item = 0; $item < $oDaoEmpenho->numrows; $item++) {
                    db_fieldsmemory($rsBuscaEmpenho, $item, true);

                    echo "$e62_item;$pc01_descrmater;";
                    echo db_formatar($e62_quant, 'f') . ";";
                    echo db_formatar($e62_vltot, 'f') . ";";
                    echo db_formatar($saldo_valor, 'f') . ";";
                    echo substr($e62_descr, 0, 100) . ";\n";
                }
            }
        }
        if ($mostrarobs == "m") {
            echo "$objeto->e60_resumo;\n";
        }
        if (1 == 1) {

            $reslancam = $clconlancamemp->sql_record($clconlancamemp->sql_query("", "*", "c75_codlan", " c75_numemp = $objeto->e60_numemp " . ($processar == "a" ? "" : " and c75_data between '$objeto->dataesp11' and '$objeto->dataesp22'")));
            $rows_lancamemp = $clconlancamemp->numrows;
            for ($lancemp = 0; $lancemp < $rows_lancamemp; $lancemp++) {
                db_fieldsmemory($reslancam, $lancemp, true);
                $reslancamdoc = $clconlancamdoc->sql_record($clconlancamdoc->sql_query($c70_codlan, "*"));
                db_fieldsmemory($reslancamdoc, 0, true);
                if ($mostralan == "m") {

                    echo ";;;$c70_data;";
                    echo "$c70_codlan;";
                    //                    echo "$c53_descr;";
                    echo db_formatar($c70_valor, 'f') . ";\n";
                }

                if ($c53_tipo == 10) {
                    $lanctotemp += $c70_valor;
                } elseif ($c53_tipo == 11) {
                    $lanctotanuemp += $c70_valor;
                } elseif ($c53_tipo == 20) {
                    $lanctotliq += $c70_valor;
                } elseif ($c53_tipo == 21) {
                    $lanctotanuliq += $c70_valor;
                } elseif ($c53_tipo == 30) {
                    $lanctotpag += $c70_valor;
                } elseif ($c53_tipo == 31) {
                    $lanctotanupag += $c70_valor;
                }
            }
        }

        $contEmpenhos++;

        if ($x == $rows - 1) {
            echo ";;;;;TOTAL DE $contEmpenhos EMPENHOS;$TotalEmpenhado;$TotalAnulado;$TotalLiquidado;$TotalPago;$TotalLiquidado2;$TotalNaoLiquidado;$TotalGeral;\n";
        }
    }

    echo "TOTAL DE EMPENHOS: $rows;;;TOTAL GERAL;$GeralTotalEmpenhado;$GeralTotalAnulado;$GeralTotalLiquidado;$GeralTotalPago;$GeralTotalLiquidado2;$GeralTotalNaoLiquidado;$GeralTotalGeral;\n";

    if ($processar == "a") {

        echo "MOVIMENTAO CONTABIL NO PERIODO;;;;;;"
            . db_formatar($lanctotemp, 'p') . ";"
            . db_formatar($lanctotanuemp, 'p') . ";"
            . db_formatar($lanctotliq - $lanctotanuliq, 'p') . ";"
            . db_formatar($lanctotpag - $lanctotanupag, 'p') . ";"
            . db_formatar(($lanctotliq - $lanctotanuliq) - ($lanctotpag - $lanctotanupag), 'p') . ";"
            . db_formatar(($lanctotemp - ($lanctotanuemp + ($lanctotpag - $lanctotanupag))) - (($lanctotliq - $lanctotanuliq) - ($lanctotpag - $lanctotanupag)), 'p') . ";"
            . db_formatar($lanctotemp - ($lanctotanuemp + ($lanctotpag - $lanctotanupag)), 'p') . ";";
    } else {

        echo "MOVIMENTAO CONTABIL NO PERIODO;;;;;;"
            . db_formatar($lanctotemp, 'p') . ";"
            . db_formatar($lanctotanuemp, 'p') . ";"
            . db_formatar($lanctotliq - $lanctotanuliq, 'p') . ";"
            . db_formatar($lanctotpag - $lanctotanupag, 'p') . ";";
    }
}

if ($agrupar == 'do') {

    $dotOrcAnt = '';
    $contEmpenhos = 0;
    echo "REDUZIDO;;;;DOTAO ORAMENTRIA;;MOVIMENTACAO;;;;SALDO A PAGAR;;;\n";
    echo "TP COMPRA;LICI;EMP;EMISSAO;NOME;DOTACAO;EMPENHADO;ANULADO;LIQUIDADO;PAGO;LIQUIDADO;NAO LIQUID;GERAL;\n";
    if ($mostralan == "m") {
        echo ";;;DATA;LANCAMENTO;DOCUMENTO;VALOR;;;;;;;\n";
    }
    if ($mostraritem == "m") {
        if ($instits != db_getsession("DB_instit")) {
            echo "ITEM;DESCRICAO DO ITEM;QUANTIDADE;VALOR TOTAL;COMPLEMENTO;;;;;;\n";
        } else {
            echo "ITEM;DESCRICAO DO ITEM;QUANTIDADE;VALOR TOTAL;SALDO;COMPLEMENTO;;;;;;\n";
        }
    }

    for ($x = 0; $x < $rows; $x++) {

        $objeto = db_utils::fieldsMemory($res, $x, true);

        if (empty($dotOrcAnt)) {
            $dotOrcAnt = "{$objeto->e60_coddot}";
            echo "$dotOrcAnt;;;;$objeto->dl_estrutural\n";
        }

        $dotacao = str_pad($objeto->e60_coddot, 4, '0', STR_PAD_LEFT);
        $EMPENHADO = db_formatar($objeto->e60_vlremp, 'f');
        $ANULADO = db_formatar($objeto->e60_vlranu, 'f');
        $LIQUIDADO = db_formatar($objeto->e60_vlrliq, 'f');
        $PAGO = db_formatar($objeto->e60_vlrpag, 'f');
        $LIQUIDADO2 = db_formatar($objeto->e60_vlrliq - $objeto->e60_vlrpag, 'f');
        $NAOLIQUID = db_formatar($objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrliq, 'f');
        $GERAL = db_formatar($objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrpag, 'f');


        if ($dotOrcAnt != "{$objeto->e60_coddot}") {

            echo ";;;;;TOTAL DE $contEmpenhos EMPENHOS;$TotalEmpenhado;$TotalAnulado;$TotalLiquidado;$TotalPago;$TotalLiquidado2;$TotalNaoLiquidado;$TotalGeral;\n";
            echo "$objeto->e60_coddot;;;;$objeto->dl_estrutural;\n";
            $TotalEmpenhado    = 0;
            $TotalAnulado      = 0;
            $TotalLiquidado    = 0;
            $TotalPago         = 0;
            $TotalLiquidado2   = 0;
            $TotalNaoLiquidado = 0;
            $TotalGeral        = 0;

            $dotOrcAnt = "{$objeto->e60_coddot}";
            $contEmpenhos = 0;
        }

        $TotalEmpenhado    += $objeto->e60_vlremp;
        $TotalAnulado      += $objeto->e60_vlranu;
        $TotalLiquidado    += $objeto->e60_vlrliq;
        $TotalPago         += $objeto->e60_vlrpag;
        $TotalLiquidado2   += $objeto->e60_vlrliq - $objeto->e60_vlrpag;
        $TotalNaoLiquidado += $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrliq;
        $TotalGeral        += $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrpag;

        $GeralTotalEmpenhado    += $objeto->e60_vlremp;
        $GeralTotalAnulado      += $objeto->e60_vlranu;
        $GeralTotalLiquidado    += $objeto->e60_vlrliq;
        $GeralTotalPago         += $objeto->e60_vlrpag;
        $GeralTotalLiquidado2   += $objeto->e60_vlrliq - $objeto->e60_vlrpag;
        $GeralTotalNaoLiquidado += $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrliq;
        $GeralTotalGeral        += $objeto->e60_vlremp - $objeto->e60_vlranu - $objeto->e60_vlrpag;


        echo "$objeto->pc50_descr;$objeto->e60_numerol;$objeto->e60_codemp;$objeto->e60_emiss;$objeto->z01_nome;";
        echo "$dotacao - $objeto->dl_estrutural;$EMPENHADO;$ANULADO;$LIQUIDADO;$PAGO;$LIQUIDADO2;$NAOLIQUID;$GERAL;";
        echo "\n";

        if ($mostraritem == "m") {
            if ($instits != db_getsession("DB_instit")) {
                $dbwhere = "e62_numemp = $objeto->e60_numemp ";
                if ($listaitem != "" or $listasub != "") {
                    if ($listaitem != "") {
                        $dbwhere .= "and e62_item in ($listaitem) ";
                    }

                    if ($listasub != "") {
                        $dbwhere .= "and e62_item in ($listar) ";
                    }
                }

                $resitem = $clempempitem->sql_record($clempempitem->sql_query(null, null, "e62_item,pc01_descrmater,e62_quant,e62_vltot,e62_descr", null, $dbwhere));
                $rows_item = $clempempitem->numrows;

                for ($item = 0; $item < $rows_item; $item++) {
                    db_fieldsmemory($resitem, $item, true);

                    echo "$e62_item;$pc01_descrmater;";
                    echo db_formatar($e62_quant, 'f') . ";";
                    echo db_formatar($e62_vltot, 'f') . ";";
                    echo substr($e62_descr, 0, 100) . ";\n";
                }
            } else {
                $sCamposEmpenho  = "distinct riseqitem     as item_empenho";
                $sCamposEmpenho .= "         ,ricodmater   as e62_item";
                $sCamposEmpenho .= "         ,rsdescr      as pc01_descrmater";
                $sCamposEmpenho .= "         ,e62_descr";
                $sCamposEmpenho .= "         ,rnquantini   as e62_quant";
                $sCamposEmpenho .= "         ,rnvalorini   as e62_vltot";
                $sCamposEmpenho .= "         ,rnvaloruni";
                $sCamposEmpenho .= "         ,rnsaldoitem  as saldo";
                $sCamposEmpenho .= "         ,round(rnsaldovalor,2) as saldo_valor";
                $sCamposEmpenho .= "         ,o56_descr";
                $sCamposEmpenho .= "         ,case when pcorcamval.pc23_obs is not null";
                $sCamposEmpenho .= "              then pcorcamval.pc23_obs";
                $sCamposEmpenho .= "              else pcorcamvalpai.pc23_obs";
                $sCamposEmpenho .= "         end as observacao";
                $sWhereEmpenho   = "e60_numemp = {$objeto->e60_numemp}";

                $oDaoEmpenho      = db_utils::getDao("empempenho");
                $sSqlItensEmpenho = $oDaoEmpenho->sql_query_itens_consulta_empenho($objeto->e60_numemp, $sCamposEmpenho);
                $rsBuscaEmpenho   = $oDaoEmpenho->sql_record($sSqlItensEmpenho);
                for ($item = 0; $item < $oDaoEmpenho->numrows; $item++) {
                    db_fieldsmemory($rsBuscaEmpenho, $item, true);

                    echo "$e62_item;$pc01_descrmater;";
                    echo db_formatar($e62_quant, 'f') . ";";
                    echo db_formatar($e62_vltot, 'f') . ";";
                    echo db_formatar($saldo_valor, 'f') . ";";
                    echo substr($e62_descr, 0, 100) . ";\n";
                }
            }
        }
        if ($mostrarobs == "m") {
            echo "$objeto->e60_resumo;\n";
        }
        if (1 == 1) {

            $reslancam = $clconlancamemp->sql_record($clconlancamemp->sql_query("", "*", "c75_codlan", " c75_numemp = $objeto->e60_numemp " . ($processar == "a" ? "" : " and c75_data between '$objeto->dataesp11' and '$objeto->dataesp22'")));
            $rows_lancamemp = $clconlancamemp->numrows;
            for ($lancemp = 0; $lancemp < $rows_lancamemp; $lancemp++) {
                db_fieldsmemory($reslancam, $lancemp, true);
                $reslancamdoc = $clconlancamdoc->sql_record($clconlancamdoc->sql_query($c70_codlan, "*"));
                db_fieldsmemory($reslancamdoc, 0, true);
                if ($mostralan == "m") {

                    echo ";;;$c70_data;";
                    echo "$c70_codlan;";
                    echo "$c53_descr;";
                    echo db_formatar($c70_valor, 'f') . ";\n";
                }

                if ($c53_tipo == 10) {
                    $lanctotemp += $c70_valor;
                } elseif ($c53_tipo == 11) {
                    $lanctotanuemp += $c70_valor;
                } elseif ($c53_tipo == 20) {
                    $lanctotliq += $c70_valor;
                } elseif ($c53_tipo == 21) {
                    $lanctotanuliq += $c70_valor;
                } elseif ($c53_tipo == 30) {
                    $lanctotpag += $c70_valor;
                } elseif ($c53_tipo == 31) {
                    $lanctotanupag += $c70_valor;
                }
            }
        }

        $contEmpenhos++;

        if ($x == $rows - 1) {
            echo ";;;;;TOTAL DE $contEmpenhos EMPENHOS;$TotalEmpenhado;$TotalAnulado;$TotalLiquidado;$TotalPago;$TotalLiquidado2;$TotalNaoLiquidado;$TotalGeral;\n";
        }
    }

    echo "TOTAL DE EMPENHOS: $rows;;;;;TOTAL GERAL;$GeralTotalEmpenhado;$GeralTotalAnulado;$GeralTotalLiquidado;$GeralTotalPago;$GeralTotalLiquidado2;$GeralTotalNaoLiquidado;$GeralTotalGeral;\n";

    if ($processar == "a") {

        echo "MOVIMENTAO CONTABIL NO PERIODO;;;;;;"
            . db_formatar($lanctotemp, 'p') . ";"
            . db_formatar($lanctotanuemp, 'p') . ";"
            . db_formatar($lanctotliq - $lanctotanuliq, 'p') . ";"
            . db_formatar($lanctotpag - $lanctotanupag, 'p') . ";"
            . db_formatar(($lanctotliq - $lanctotanuliq) - ($lanctotpag - $lanctotanupag), 'p') . ";"
            . db_formatar(($lanctotemp - ($lanctotanuemp + ($lanctotpag - $lanctotanupag))) - (($lanctotliq - $lanctotanuliq) - ($lanctotpag - $lanctotanupag)), 'p') . ";"
            . db_formatar($lanctotemp - ($lanctotanuemp + ($lanctotpag - $lanctotanupag)), 'p') . ";";
    } else {

        echo "MOVIMENTAO CONTABIL NO PERIODO;;;;;;"
            . db_formatar($lanctotemp, 'p') . ";"
            . db_formatar($lanctotanuemp, 'p') . ";"
            . db_formatar($lanctotliq - $lanctotanuliq, 'p') . ";"
            . db_formatar($lanctotpag - $lanctotanupag, 'p') . ";";
    }
}
