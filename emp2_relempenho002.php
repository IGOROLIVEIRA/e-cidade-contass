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

/*====================================================================
=                             IMPORTANTE                             =
====================================================================*/
//
// LEIA ISSO!!!! Vai te ajudar entender... talvez.
//
// Esse arquivo tem dois grandes SQLs que você deve se preocupar:
//  - $sqlrelemp:
//      Que faz a busca do 'Processar Posição Atual'
//
//  - $sqlperiodo:
//      Que faz a busca do 'Processar Períodos de Lançamento'
//
// Ambos são confusos, pois tem subselects com eles mesmo. Ex.:
//
// ```
//  $sqlrelemp = $clempempenho->sql_query_relatorio([...]);
//  $sqlrelemp = "select [...] from ($sqlrelemp) ";
//
// ```
//--------------------------------------------------------------------
//
// A variável `$sCamposPosicaoAtual` só serve para essa linha:
//    $sqlrelemp = $clempempenho->sql_query_relatorio(null, $sCamposPosicaoAtual, $sOrderSQL, $sWhereSQL);
//
// A variável `$sOrderSQL` torna possível os agrupamentos do relatório,
// determinado pelo `ORDER` da query. Então na prática, a query vai
// ordenar pelo agrupamento determinado, e o `ORDER` fala os campos
// específicos para isso.
//
// E a variável `$sWhereSQL` armazena as condições do `WHERE` das
// query, que são aplicadas através dos filtros que o usuário insere.
//
// As variáveis `$sOrderSQL` e `$sWhereSQL` são utilizadas por
// `$sqlrelemp` e `$sqlperiodo`.
//
//====================================================================
//--------------------------------------------------------------------
//-                             Alterações                           -
//--------------------------------------------------------------------
//
// A última alteração deste arquivo foi para dar suporte ao filtro de
// gestores de empenho. Para isso, o arquivo `classes/db_empempenho_classe.php`
// sofreu alteração no método `sql_query_relatorio()`. Agora ele tem
// `INNER JOIN` com `empempaut` e com `empautoriza`, para chegar no
// campo `e54_gestaut`. Essa alteração foi feita para atender o
// 'Processar Posição Atual'; já 'Processar Períodos de Lançamento'
// teve sua query altera diretamente aqui no arquivo, com os mesmos
// `INNER`s.
//
//####################################################################


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

/// Para o caso de ter filtro de Contratos
$lSepararAcordo = $agrupar === 'c' ? true : false;
$sAcordoAtual   = "";


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

function multiCell($oPdf, $aTexto, $iTamFixo, $iTam, $iTamCampo, $lCor = '')
{
    $pos_x = $oPdf->x;
    $pos_y = $oPdf->y;
    $oPdf->cell($iTamCampo, $iTam, "", 0, 0, 'L', $lCor);
    $oPdf->x = $pos_x;
    $oPdf->y = $pos_y;
    foreach ($aTexto as $sProcedimento) {
        $sProcedimento = ltrim($sProcedimento);
        $oPdf->cell($iTamCampo, $iTamFixo, $sProcedimento, 0, 1, 'L', $lCor);
        $oPdf->x = $pos_x;
    }
    $oPdf->x = $pos_x + $iTamCampo;
    $oPdf->y = $pos_y;
}

function quebrar_texto($texto, $tamanho)
{

    $aTexto = explode(" ", $texto);
    $string_atual = "";
    foreach ($aTexto as $word) {
        $string_ant = $string_atual;
        $string_atual .= " " . $word;
        if (strlen($string_atual) > $tamanho) {
            $aTextoNovo[] = $string_ant;
            $string_ant   = "";
            $string_atual = $word;
        }
    }
    $aTextoNovo[] = $string_atual;
    return $aTextoNovo;
}

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

$head1 = "MUNICÍPIO DE " . strtoupper($munic);

//////////////////////////////////////////////////////////////////

$clrotulo->label("pc50_descr");

//////////////////////////////////////////////////////////////////

$sCamposPosicaoAtual  = "distinct e60_numemp, to_number(e60_codemp::text,'9999999999') as e60_codemp, e60_resumo, e60_emiss";
$sCamposPosicaoAtual .= ", e60_numcgm, z01_nome, z01_cgccpf, z01_munic, e60_vlremp, e60_vlranu, e60_vlrliq, e63_codhist, e40_descr";
$sCamposPosicaoAtual .= ", e60_vlrpag, e60_anousu, e60_coddot, o58_coddot, o58_orgao, o40_orgao, o40_descr, o58_unidade, o41_descr";
$sCamposPosicaoAtual .= ", o15_codigo, o15_descr, fc_estruturaldotacao(e60_anousu,e60_coddot) as dl_estrutural, e60_codcom";
$sCamposPosicaoAtual .= ", pc50_descr,e60_concarpeculiar,e60_numerol,e54_gestaut,descrdepto,e94_empanuladotipo,e38_descr,l20_edital,l20_anousu";
$sCamposPosicaoAtual .= ", ac16_sequencial, ac16_resumoobjeto, (acordo.ac16_numero || '/' || acordo.ac16_anousu)::varchar as ac16_numero";

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

if ($listaacordo != "") {
    if (isset($vercom) and $vercom == "com") {
        $sWhereSQL = $sWhereSQL . " and ac16_sequencial in  ($listaacordo)";
    } else {
        $sWhereSQL = $sWhereSQL . " and ac16_sequencial not in  ($listaacordo)";
    }
}

if ($listalicita != "") {
    if (isset($vercom) and $vercom == "com") {
        $sWhereSQL = $sWhereSQL . " and empempenho.e60_numerol IN (select l20_edital::varchar ||'/'|| l20_anousu::varchar as ano from liclicita where l20_codigo in  ($listalicita))";

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
    $info = "De " . db_formatar($datacredor, "d") . " até " . db_formatar($datacredor1, "d") . ".";
} else
    if ($datacredor != "--") {
    $sWhereSQL = $sWhereSQL . " and e60_emiss >= '$datacredor'  ";
    $info = "Apartir de " . db_formatar($datacredor, "d") . ".";
} else
        if ($datacredor1 != "--") {
    $sWhereSQL = $sWhereSQL . "    e60_emiss <= '$datacredor1'   ";
    $info = "Até " . db_formatar($datacredor1, "d") . ".";
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
    // $sOrderSQL = " e60_emiss, e60_codemp, z01_nome, e60_anousu ";
    $sOrderSQL = " to_number(e60_codemp::text,'9999999999') ";
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

        $sqlrelemp = "select distinct x.e60_resumo,
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
                      orcelemento.o56_elemento,
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
            x.ac16_sequencial,
            x.ac16_resumoobjeto,
            x.ac16_numero,
            x.l20_edital,
            x.l20_anousu
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
                          orcelemento.o56_elemento,
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
                x.ac16_sequencial,
                x.ac16_resumoobjeto,
                x.ac16_numero,
                e94_empanuladotipo,
            	  e38_descr,
                x.l20_edital,
                x.l20_anousu";
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
            x.ac16_sequencial,
            x.ac16_resumoobjeto,
            x.ac16_numero,
            e94_empanuladotipo,
            e38_descr,
            x.l20_edital,
            x.l20_anousu
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
                x.ac16_sequencial,
                x.ac16_resumoobjeto,
                x.ac16_numero,
                e94_empanuladotipo,
            	  e38_descr,
                x.l20_edital,
                x.l20_anousu";
    } else {
        $sqlrelemp = "select distinct x.e60_resumo,
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
            x.ac16_sequencial,
            x.ac16_resumoobjeto,
            x.ac16_numero,
            x.l20_edital,
            x.l20_anousu
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
                x.ac16_sequencial,
                x.ac16_resumoobjeto,
                x.ac16_numero,
                e94_empanuladotipo,
            	  e38_descr,
                x.l20_edital,
                x.l20_anousu";
    }

    $sqlrelemp = "select * from ($sqlrelemp) as x " . ($agrupar == "d"
        ? " order by e64_codele, e60_emiss "
        : $agrupar == "c"
        ? " order by  x.ac16_sequencial "
        : " order by $sOrderSQL ");
    //echo $sqlrelemp;exit;
    $res = $clempempenho->sql_record($sqlrelemp);
    if ($clempempenho->numrows > 0) {
        $rows = $clempempenho->numrows;
    } else {
        db_redireciona('db_erros.php?fechar=true&db_erro=Não existem dados para gerar a consulta (A21) !');
    }
} else {

    $sqlperiodo = " select ";
    if ($agrupar != "ta") {
        $sqlperiodo .=   " distinct ";
    }

    $sqlperiodo .=  " empempenho.e60_numemp,
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
          descrdepto,
          to_number(e60_codemp::text,'9999999999')
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
    $sqlperiodo .= " order by $sOrderSQL  ";

    if ($agrupar == "d" || $sele_desdobramentos != "") {
        $sqlperiodo =  "
			      select distinct e60_numemp,
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
                         order by  empelemento.e64_codele
  			    ";
        } else {
            $sqlperiodo .= "
                         order by  $sOrderSQL, empelemento.e64_codele
  			    ";
        }
    } elseif ($agrupar == "ta") {

        $sqlperiodo =  "
			      select e60_numemp,
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

        $sqlperiodo .= "
                         order by  e60_emiss,empelemento.e64_codele
  			    ";
    }

    $res = $clempempenho->sql_record($sqlperiodo);
    //echo $sqlperiodo;db_criatabela($res);die();
    if ($clempempenho->numrows > 0) {
        $rows = $clempempenho->numrows;
    } else {
        db_redireciona('db_erros.php?fechar=true&db_erro=Não existem dados para gerar a consulta!');
    }
}

//////////////////////////////////////////////////////////////////////

$head3 = "Relatório de Empenhos";

if (isset($tipoemp) && $tipoemp != "") {
    if ($tipoemp == "todos") {
        $head4 = "Todos os empenhos";
    } elseif ($tipoemp == "saldo") {
        $head4 = "Com saldo a pagar geral";
    } elseif ($tipoemp == "saldoliq") {
        $head4 = "Com saldo a pagar liquidados";
    } elseif ($tipoemp == "saldonaoliq") {
        $head4 = "Com saldo a pagar nao liquidados";
    } elseif ($tipoemp == "anul") {
        $head4 = "Com anulação";
    } elseif ($tipoemp == "anultot") {
        $head4 = "Apenas os totalmente anulados";
    } elseif ($tipoemp == "anulparc") {
        $head4 = "Apenas os anulados parcialmente";
    } elseif ($tipoemp == "anulsem") {
        $head4 = "Apenas os sem anulação";
    } elseif ($tipoemp == "liq") {
        $head4 = "Com liquidação";
    } elseif ($tipoemp == "liqtot") {
        $head4 = "Apenas os liquidados totalmente";
    } elseif ($tipoemp == "liqparc") {
        $head4 = "Apenas os liquidados parcialmente";
    } elseif ($tipoemp == "liqsem") {
        $head4 = "Apenas os sem liquidação";
    } elseif ($tipoemp == "pag") {
        $head4 = "Com pagamentos";
    } elseif ($tipoemp == "pagtot") {
        $head4 = "Apenas os pagos totalmente";
    } elseif ($tipoemp == "pagparc") {
        $head4 = "Apenas os pagos parcialmente";
    } elseif ($tipoemp == "pagsem") {
        $head4 = "Apenas os sem pagamento";
    } elseif ($tipoemp == "pagsemsemliq") {
        $head4 = "Apenas os sem pagamento e sem liquidação";
    } elseif ($tipoemp == "pagsemcomliq") {
        $head4 = "Apenas os sem pagamento e com liquidação";
    }
}

$head5 = "$info";

if ($processar == "a") {
    $head6 = "Posição atual";
} else {
    $head6 = "Periodo especificado: " . db_formatar($dataesp11, "d") . " a " . db_formatar($dataesp22, "d");
}

if ($chk_ordem == "C") {
    $head7 = "Ordenado crescente por valor ";
    if ($chk_valor == "E") {
        $head7 .= "empenhado";
    } else if ($chk_valor == "L") {
        $head7 .= "liquidado";
    } else if ($chk_valor == "P") {
        $head7 .= "pago";
    }
}

if ($chk_ordem == "D") {
    $head7 = "Ordenado decrescente por valor ";
    if ($chk_valor == "E") {
        $head7 .= "empenhado";
    } else if ($chk_valor == "L") {
        $head7 .= "liquidado";
    } else if ($chk_valor == "P") {
        $head7 .= "pago";
    }
}

if ($lSepararGestor && !empty($listagestor)) {
    $head8 = "Gestor do Empenho: {$listagestor}";
}

if ($lSepararAcordo && !empty($listaacordo)) {
    $head8 = "Contrato do Empenho: {$listaacordo}";
}

$pdf = new PDF(); // abre a classe
$pdf->Open(); // abre o relatorio
$pdf->AliasNbPages(); // gera alias para as paginas
$pdf->AddPage('L'); // adiciona uma pagina
$pdf->SetTextColor(0, 0, 0);
$pdf->SetFillColor(235);
$pdf->setleftmargin(3);


if ($agrupar != "d") {
    $e64_codele = "99999";
}

$tam = '04';
$imprime_header = true;
$contador = 0;
$repete_r = "";
$repete_d = "";
$repete_ta = "";
$repete = "";
$t_emp1 = 0;
$t_liq1 = 0;
$t_anu1 = 0;
$t_pag1 = 0;
$t_total1 = 0;
$t_emp2 = 0;
$t_liq2 = 0;
$t_anu2 = 0;
$t_pag2 = 0;
$t_total2 = 0;
$t_emp3 = 0;
$t_liq3 = 0;
$t_anu3 = 0;
$t_pag3 = 0;
$t_total3 = 0;
$t_emp = 0;
$t_liq = 0;
$t_anu = 0;
$t_pag = 0;
$t_total = 0;
$g_emp = 0;
$g_liq = 0;
$g_anu = 0;
$g_pag = 0;
$g_total = 0;
$tg_emp = 0;
$tg_liq = 0;
$tg_anu = 0;
$tg_pag = 0;
$tg_total = 0;
$p = 0;
$t_emp5 = 0;
$t_liq5 = 0;
$t_anu5 = 0;
$t_pag5 = 0;
$t_total5 = 0;
$t_emp6 = 0;
$t_liq6 = 0;
$t_anu6 = 0;
$t_pag6 = 0;
$t_total6 = 0;
$quantimp = 0;

$lanctotemp = 0;
$lanctotanuemp = 0;
$lanctotliq = 0;
$lanctotanuliq = 0;
$lanctotpag = 0;
$lanctotanupag = 0;
$iBorda        = 0;
/*  geral analitico */
if ($tipo == "a" or 1 == 1) {
    $pdf->SetFont('Arial', '', 7);
    $totalforne = 0;
    for ($x = 0; $x < $rows; $x++) {
        db_fieldsmemory($res, $x, true);
        // testa novapagina
        if ($pdf->gety() > $pdf->h - 30) {
            $pdf->addpage("L");
            $imprime_header = true;
        }

        if ($imprime_header == true) {
            $pdf->Ln();

            $pdf->SetFont('Arial', 'B', 7);

            if ($agrupar == "a") {
                if ($sememp == "n") {
                    $pdf->Cell(45, $tam, strtoupper($RLo15_codigo), 1, 0, "C", 1);
                    $pdf->Cell(120, $tam, strtoupper($RLo15_descr), 1, 0, "C", 1);
                    $pdf->Cell(72, $tam, "MOVIMENTAÇÃO", 1, 0, "C", 1);
                    $pdf->Cell(54, $tam, "SALDO A PAGAR", 1, 1, "C", 1);
                } else {
                    $pdf->Cell(45, $tam, strtoupper($RLo15_codigo), 1, 0, "C", 1);
                    $pdf->Cell(80, $tam, strtoupper($RLo15_descr), 1, 0, "C", 1);
                    $pdf->Cell(97, $tam, "MOVIMENTAÇÃO", 1, 0, "C", 1);
                    $pdf->Cell(54, $tam, "SALDO A PAGAR", 1, 1, "C", 1);

                    $pdf->Cell(125, $tam, '', 1, 0, "C", 1);
                    $pdf->Cell(25, $tam, "QUANTIDADE", 1, 0, "C", 1);
                    $pdf->Cell(18, $tam, strtoupper($RLe60_vlremp), 1, 0, "C", 1);
                    $pdf->Cell(18, $tam, strtoupper($RLe60_vlranu), 1, 0, "C", 1);
                    $pdf->Cell(18, $tam, strtoupper($RLe60_vlrliq), 1, 0, "C", 1);
                    $pdf->Cell(18, $tam, strtoupper($RLe60_vlrpag), 1, 0, "C", 1);
                    $pdf->Cell(18, $tam, "LIQUIDADO", 1, 0, "C", 1);
                    $pdf->Cell(18, $tam, "NAO LIQUID", 1, 0, "C", 1);
                    $pdf->Cell(18, $tam, "GERAL", 1, 1, "C", 1); //quebra linha
                }
            }

            if ($agrupar == "d") {
                if ($sememp == "n") {
                    $pdf->Cell(45, $tam, strtoupper($RLo56_codele), 1, 0, "C", 1);
                    $pdf->Cell(120, $tam, strtoupper($RLo56_descr), 1, 0, "C", 1);
                    $pdf->Cell(72, $tam, "MOVIMENTAÇÃO", 1, 0, "C", 1);
                    $pdf->Cell(54, $tam, "SALDO A PAGAR", 1, 1, "C", 1);
                } else {
                    $pdf->Cell(45, $tam, strtoupper($RLo56_codele), 1, 0, "C", 1);
                    $pdf->Cell(80, $tam, strtoupper($RLo56_descr), 1, 0, "C", 1);
                    $pdf->Cell(97, $tam, "MOVIMENTAÇÃO", 1, 0, "C", 1);
                    $pdf->Cell(54, $tam, "SALDO A PAGAR", 1, 1, "C", 1);

                    $pdf->Cell(125, $tam, '', 1, 0, "C", 1);
                    $pdf->Cell(25, $tam, "QUANTIDADE", 1, 0, "C", 1);
                    $pdf->Cell(18, $tam, strtoupper($RLe60_vlremp), 1, 0, "C", 1);
                    $pdf->Cell(18, $tam, strtoupper($RLe60_vlranu), 1, 0, "C", 1);
                    $pdf->Cell(18, $tam, strtoupper($RLe60_vlrliq), 1, 0, "C", 1);
                    $pdf->Cell(18, $tam, strtoupper($RLe60_vlrpag), 1, 0, "C", 1);
                    $pdf->Cell(18, $tam, "LIQUIDADO", 1, 0, "C", 1);
                    $pdf->Cell(18, $tam, "NAO LIQUID", 1, 0, "C", 1);
                    $pdf->Cell(18, $tam, "GERAL", 1, 1, "C", 1); //quebra linha
                }
            }

            if ($agrupar == "r") {
                if ($sememp == "n") {
                    $pdf->Cell(45, $tam, strtoupper($RLo15_codigo), 1, 0, "C", 1);
                    $pdf->Cell(120, $tam, strtoupper($RLo15_descr), 1, 0, "C", 1);
                    $pdf->Cell(72, $tam, "MOVIMENTAÇÃO", 1, 0, "C", 1);
                    $pdf->Cell(54, $tam, "SALDO A PAGAR", 1, 1, "C", 1);
                } else {
                    $pdf->Cell(45, $tam, strtoupper($RLo15_codigo), 1, 0, "C", 1);
                    $pdf->Cell(80, $tam, strtoupper($RLo15_descr), 1, 0, "C", 1);
                    $pdf->Cell(97, $tam, "MOVIMENTAÇÃO", 1, 0, "C", 1);
                    $pdf->Cell(54, $tam, "SALDO A PAGAR", 1, 1, "C", 1);

                    $pdf->Cell(125, $tam, '', 1, 0, "C", 1);
                    $pdf->Cell(25, $tam, "QUANTIDADE", 1, 0, "C", 1);
                    $pdf->Cell(18, $tam, strtoupper($RLe60_vlremp), 1, 0, "C", 1);
                    $pdf->Cell(18, $tam, strtoupper($RLe60_vlranu), 1, 0, "C", 1);
                    $pdf->Cell(18, $tam, strtoupper($RLe60_vlrliq), 1, 0, "C", 1);
                    $pdf->Cell(18, $tam, strtoupper($RLe60_vlrpag), 1, 0, "C", 1);
                    $pdf->Cell(18, $tam, "LIQUIDADO", 1, 0, "C", 1);
                    $pdf->Cell(18, $tam, "NAO LIQUID", 1, 0, "C", 1);
                    $pdf->Cell(18, $tam, "GERAL", 1, 1, "C", 1); //quebra linha
                }
            }

            if ($agrupar == "orgao") {
                if ($sememp == "n") {
                    $pdf->Cell(45, $tam, strtoupper($RLo58_codigo), 1, 0, "C", 1);
                    $pdf->Cell(120, $tam, strtoupper($RLo40_descr), 1, 0, "C", 1);
                    $pdf->Cell(72, $tam, "MOVIMENTAÇÃO", 1, 0, "C", 1);
                    $pdf->Cell(54, $tam, "SALDO A PAGAR", 1, 1, "C", 1);
                } else {
                    $pdf->Cell(45, $tam, strtoupper($RLo58_codigo), 1, 0, "C", 1);
                    $pdf->Cell(80, $tam, strtoupper($RLo40_descr), 1, 0, "C", 1);
                    $pdf->Cell(97, $tam, "MOVIMENTAÇÃO", 1, 0, "C", 1);
                    $pdf->Cell(54, $tam, "SALDO A PAGAR", 1, 1, "C", 1);

                    $pdf->Cell(125, $tam, '', 1, 0, "C", 1);
                    $pdf->Cell(25, $tam, "QUANTIDADE", 1, 0, "C", 1);
                    $pdf->Cell(18, $tam, strtoupper($RLe60_vlremp), 1, 0, "C", 1);
                    $pdf->Cell(18, $tam, strtoupper($RLe60_vlranu), 1, 0, "C", 1);
                    $pdf->Cell(18, $tam, strtoupper($RLe60_vlrliq), 1, 0, "C", 1);
                    $pdf->Cell(18, $tam, strtoupper($RLe60_vlrpag), 1, 0, "C", 1);
                    $pdf->Cell(18, $tam, "LIQUIDADO", 1, 0, "C", 1);
                    $pdf->Cell(18, $tam, "NAO LIQUID", 1, 0, "C", 1);
                    $pdf->Cell(18, $tam, "GERAL", 1, 1, "C", 1); //quebra linha
                }
            }

            if ($agrupar == "do") {
                if ($sememp == "n") {
                    $pdf->Cell(45, $tam, 'REDUZIDO', 1, 0, "C", 1);
                    $pdf->Cell(120, $tam, 'DOTAÇÃO ORÇAMENTÁRIA', 1, 0, "C", 1);
                    $pdf->Cell(72, $tam, "MOVIMENTAÇÃO", 1, 0, "C", 1);
                    $pdf->Cell(54, $tam, "SALDO A PAGAR", 1, 1, "C", 1);
                } else {
                    $pdf->Cell(45, $tam, 'REDUZIDO', 1, 0, "C", 1);
                    $pdf->Cell(80, $tam, 'DOTAÇÃO ORÇAMENTÁRIA', 1, 0, "C", 1);
                    $pdf->Cell(97, $tam, "MOVIMENTAÇÃO", 1, 0, "C", 1);
                    $pdf->Cell(54, $tam, "SALDO A PAGAR", 1, 1, "C", 1);

                    $pdf->Cell(125, $tam, '', 1, 0, "C", 1);
                    $pdf->Cell(25, $tam, "QUANTIDADE", 1, 0, "C", 1);
                    $pdf->Cell(18, $tam, strtoupper($RLe60_vlremp), 1, 0, "C", 1);
                    $pdf->Cell(18, $tam, strtoupper($RLe60_vlranu), 1, 0, "C", 1);
                    $pdf->Cell(18, $tam, strtoupper($RLe60_vlrliq), 1, 0, "C", 1);
                    $pdf->Cell(18, $tam, strtoupper($RLe60_vlrpag), 1, 0, "C", 1);
                    $pdf->Cell(18, $tam, "LIQUIDADO", 1, 0, "C", 1);
                    $pdf->Cell(18, $tam, "NAO LIQUID", 1, 0, "C", 1);
                    $pdf->Cell(18, $tam, "GERAL", 1, 1, "C", 1); //quebra linha
                }
            }

            if ($tipo == "a" and $sememp == "n") {
                if ($agrupar == "oo" || $agrupar == 'gest') {
                    $pdf->Cell(165, $tam, '', 1, 0, "C", 1);
                    $pdf->Cell(72, $tam, "MOVIMENTAÇÃO", 1, 0, "C", 1);
                    $pdf->Cell(54, $tam, "SALDO A PAGAR", 1, 1, "C", 1);
                }
                $pdf->Cell(20, $tam, "TP COMPRA", 1, 0, "C", 1);
                $pdf->Cell(11, $tam, "LICI.", 1, 0, "C", 1);
                $pdf->Cell(11, $tam, "EMP.", 1, 0, "C", 1);
                $pdf->Cell(15, $tam, "EMISSÃO", 1, 0, "C", 1);

                if ($agrupar == "a") {
                    if ($mostrar == "r") {
                        $pdf->Cell(40, $tam, strtoupper($RLo15_codigo), 1, 0, "C", 1); // recurso
                    } else
                        if ($mostrar == "t") {
                        $pdf->Cell(40, $tam, strtoupper('Tipo de Compra'), 1, 0, "C", 1); // tipo de compra
                    }
                }

                if ($agrupar == "d") {
                    if ($mostrar == "r") {
                        $pdf->Cell(46, $tam, strtoupper($RLz01_nome), 1, 0, "C", 1); // recurso
                    } else
                        if ($mostrar == "t") {
                        $pdf->Cell(40, $tam, strtoupper('Tipo de Compra'), 1, 0, "C", 1); // tipo de compra
                    }
                }

                if ($agrupar == "r" || $agrupar == "c") {
                    if ($mostrar == "r") {
                        $pdf->Cell(46, $tam, strtoupper($RLz01_nome), 1, 0, "C", 1); // recurso
                    } else
                        if ($mostrar == "t") {
                        $pdf->Cell(40, $tam, strtoupper('Tipo de Compra'), 1, 0, "C", 1); // tipo de compra
                    }
                }

                if ($agrupar == "orgao") {
                    if ($mostrar == "r") {
                        $pdf->Cell(46, $tam, strtoupper($RLo40_descr), 1, 0, "C", 1); // recurso
                    } elseif ($mostrar == "t") {
                        $pdf->Cell(40, $tam, strtoupper('Tipo de Compra'), 1, 0, "C", 1); // tipo de compra
                    }
                }

                if ($agrupar == "oo" || $agrupar == 'gest') {
                    $pdf->Cell(46, $tam, strtoupper($RLz01_nome), 1, 0, "C", 1);
                }

                if ($agrupar == 'ta') {
                    $pdf->Cell(46, $tam, strtoupper($RLz01_nome), 1, 0, "C", 1);
                }
                if ($agrupar == "do") {
                    if ($mostrar == "r") {
                        $pdf->Cell(46, $tam, 'NOME', 1, 0, "C", 1); //108
                        $pdf->Cell(62, $tam, 'DOTAÇÃO', 1, 0, "C", 1);
                    } elseif ($mostrar == "t") {
                        $pdf->Cell(40, $tam, strtoupper('Tipo de Compra'), 1, 0, "C", 1); // tipo de compra
                    }
                } else {
                    //strtoupper($RLe60_coddot)
                    $pdf->Cell(62, $tam, 'DOTAÇÃO', 1, 0, "L", 1); // cod+estrut dotatao // quebra linha
                }
                //$pdf->Cell(15, $tam, "CP", 1, 0, "C", 1);
                $pdf->Cell(18, $tam, strtoupper($RLe60_vlremp), 1, 0, "C", 1);
                $pdf->Cell(18, $tam, strtoupper($RLe60_vlranu), 1, 0, "C", 1);
                $pdf->Cell(18, $tam, strtoupper($RLe60_vlrliq), 1, 0, "C", 1);
                $pdf->Cell(18, $tam, strtoupper($RLe60_vlrpag), 1, 0, "C", 1);
                $pdf->Cell(18, $tam, "LIQUIDADO", 1, 0, "C", 1);
                $pdf->Cell(18, $tam, "NAO LIQUID", 1, 0, "C", 1);
                $pdf->Cell(18, $tam, "GERAL", 1, 1, "C", 1); //quebra linha

                if ($mostralan == "m") {
                    $pdf->Cell(40, $tam, "", 0, 0, "C", 0);
                    $pdf->Cell(20, $tam, "DATA", 1, 0, "C", 1);
                    $pdf->Cell(25, $tam, "LANÇAMENTO", 1, 0, "C", 1);
                    $pdf->Cell(25, $tam, "DOCUMENTO", 1, 0, "C", 1);
                    $pdf->Cell(25, $tam, "VALOR", 1, 1, "C", 1); // quebra linha1
                }
                if ($mostraritem == "m") {
                    $pdf->Cell(40, $tam, "", 0, 0, "C", 0);
                    $pdf->Cell(20, $tam, "ITEM", 1, 0, "C", 1);
                    $pdf->Cell(150, $tam, "DESCRIÇÃO DO ITEM", 1, 0, "C", 1);
                    $pdf->Cell(20, $tam, "QUANTIDADE", 1, 0, "C", 1);
                    if ($instits == db_getsession("DB_instit")) {
                        $pdf->Cell(20, $tam, "VALOR TOTAL", 1, 0, "C", 1);
                        $pdf->Cell(20, $tam, "SALDO", 1, 1, "C", 1);
                    } else {
                        $pdf->Cell(20, $tam, "VALOR TOTAL", 1, 1, "C", 1);
                    }
                    //$pdf->Cell(102, $tam, "COMPLEMENTO", 1, 1, "C", 1); // quebra linha1
                }
            } else if ($tipo == "a" and $sememp == "s" and ($agrupar == "oo" || $agrupar == 'gest')) {
                $pdf->Cell(150, $tam, '', 1, 0, "C", 1);
                $pdf->Cell(72, $tam, "MOVIMENTAÇÃO", 1, 0, "C", 1);
                $pdf->Cell(54, $tam, "SALDO A PAGAR", 1, 1, "C", 1);
                $pdf->Cell(150, $tam, "", 1, 0, "C", 1);
                $pdf->Cell(18, $tam, strtoupper($RLe60_vlremp), 1, 0, "C", 1);
                $pdf->Cell(18, $tam, strtoupper($RLe60_vlranu), 1, 0, "C", 1);
                $pdf->Cell(18, $tam, strtoupper($RLe60_vlrliq), 1, 0, "C", 1);
                $pdf->Cell(18, $tam, strtoupper($RLe60_vlrpag), 1, 0, "C", 1);
                $pdf->Cell(18, $tam, "LIQUIDADO", 1, 0, "C", 1);
                $pdf->Cell(18, $tam, "NAO LIQUID", 1, 0, "C", 1);
                $pdf->Cell(18, $tam, "GERAL", 1, 1, "C", 1); //quebra linha
                if ($mostralan == "m") {

                    $pdf->Cell(40, $tam, "", 0, 0, "C", 0);
                    $pdf->Cell(20, $tam, "DATA", 1, 0, "C", 1);
                    $pdf->Cell(25, $tam, "LANÇAMENTO", 1, 0, "C", 1);
                    $pdf->Cell(25, $tam, "DOCUMENTO", 1, 0, "C", 1);
                    $pdf->Cell(25, $tam, "VALOR", 1, 1, "C", 1); // quebra linha1
                }
                if ($mostraritem == "m") {

                    $pdf->Cell(40, $tam, "", 0, 0, "C", 0);
                    $pdf->Cell(20, $tam, "ITEM", 1, 0, "C", 1);
                    $pdf->Cell(150, $tam, "DESCRIÇÃO DO ITEM", 1, 0, "C", 1);
                    $pdf->Cell(20, $tam, "QUANTIDADE", 1, 0, "C", 1);
                    if ($instits == db_getsession("DB_instit")) {
                        $pdf->Cell(20, $tam, "VALOR TOTAL", 1, 0, "C", 1);
                        $pdf->Cell(20, $tam, "SALDO", 1, 1, "C", 1);
                    } else {
                        $pdf->Cell(20, $tam, "VALOR TOTAL", 1, 1, "C", 1);
                    }
                    //$pdf->Cell(102, $tam, "COMPLEMENTO", 1, 1, "C", 1); // quebra linha1

                }
            }
            $pdf->SetFont('Arial', '', 7);
            $imprime_header = false;
            // echo $RLe60_vlremp;
            // echo $sqlrelemp;exit;
        }
        /* ----------- AGRUPAR POR FORNECEDOR -----------*/
        if ($repete != $e60_numcgm and $agrupar == "a") {
            if ($quantimp > 1 or ($sememp == "s" and $quantimp > 0)) {

                if (($quantimp > 1 and $sememp == "n") or ($quantimp > 0 and $sememp == "s")) {
                    //$pdf->setX(125);
                    $pdf->SetFont('Arial', 'B', 7);
                    if ($sememp == "n") {
                        $base = "B";
                        $preenche = 1;
                        $iTamanhoCelula = 40;
                    } else {
                        $base = "";
                        $preenche = 0;
                        $iTamanhoCelula = 25;
                    }
                    //$base = 1;
                    $pdf->Cell(125, $tam, '', $base, 0, "R", $preenche);
                    $pdf->Cell($iTamanhoCelula, $tam, ($sememp == "n" ? "TOTAL DE " : "") . db_formatar($quantimp, "s") . " EMPENHO" . ($quantimp == 1 ? "" : "S"), $base, 0, "L", $preenche);
                    $pdf->Cell(18, $tam, db_formatar($t_emp, 'f'), $base, 0, "R", $preenche);
                    $pdf->Cell(18, $tam, db_formatar($t_anu, 'f'), $base, 0, "R", $preenche);
                    $pdf->Cell(18, $tam, db_formatar($t_liq, 'f'), $base, 0, "R", $preenche);
                    $pdf->Cell(18, $tam, db_formatar($t_pag, 'f'), $base, 0, "R", $preenche);
                    if ($saldopagar == "s") {
                        $pdf->Cell(18, $tam, db_formatar($t_liq - $t_pag, 'f'), $base, 0, "R", $preenche);
                        $pdf->Cell(18, $tam, db_formatar($t_emp - $t_anu - $t_liq, 'f'), $base, 0, "R", $preenche); //quebra linha
                        $pdf->Cell(18, $tam, db_formatar($t_emp - $t_anu - $t_pag, 'f'), $base, 1, "R", $preenche); //quebra linha
                    } else {
                        $pdf->Ln();
                    }
                    $pdf->SetFont('Arial', '', 7);
                }
            }
            $t_emp = 0;
            $t_liq = 0;
            $t_anu = 0;
            $t_pag = 0;
            $t_total = 0;
            $repete = $e60_numcgm;
            $repete_r = $o15_codigo;
            $quantimp = 0;
            if ($sememp == "n") {
                $pdf->Ln();
            }
            $pdf->SetFont('Arial', 'B', 8);
            $totalforne++;
            if ($agrupar == "a") {
                $pdf->Cell(45, $tam, "$e60_numcgm", $iBorda, 0, "C", 0);
                $pdf->Cell(80, $tam, "$z01_nome", $iBorda, 1, "L", 0);
                if ($sememp == "n") {
                    $pdf->Cell(25, $tam, $z01_cgccpf, $iBorda, 0, "C", 0);
                    $pdf->Cell(72, $tam, $z01_munic, $iBorda, 1, "L", 0);
                }
            }
            if ($agrupar == "d") {
                $pdf->Cell(45, $tam, "$o56_codele", $iBorda, 0, "C", 0);
                $pdf->Cell(105, $tam, "$o56_descr", $iBorda, 1, "L", 0);
                if ($sememp == "n") {
                    //$pdf->Cell(25, $tam, $z01_cgccpf, 0, 0, "C", 0);
                    //$pdf->Cell(72, $tam, $z01_munic, 0, 1, "L", 0);
                }
            }
            if ($agrupar == "r") {
                $pdf->Cell(45, $tam, "$o15_codigo", $iBorda, 0, "C", 0);
                $pdf->Cell(105, $tam, "$o15_descr", $iBorda, 1, "L", 0);
                if ($sememp == "n") {
                    //$pdf->Cell(25, $tam, $z01_cgccpf, 0, 0, "C", 0);
                    //$pdf->Cell(72, $tam, $z01_munic, 0, 1, "L", 0);
                }
            }

            $pdf->SetFont('Arial', '', 7);
        }
        /* ----------- AGRUPAR POR DESDOBRAMENTO ----------- */
        if ($repete_d != $e64_codele and $agrupar == "d") {
            if ($quantimp > 1 or ($sememp == "s" and $quantimp > 0)) {
                if (($quantimp > 1 and $sememp == "n") or ($quantimp > 0 and $sememp == "s")) {
                    //$pdf->setX(125);
                    $pdf->SetFont('Arial', 'B', 7);
                    if ($sememp == "n") {
                        $base = "B";
                        $preenche = 1;
                        $iTamanhoCelula = 40;
                    } else {
                        $base = "";
                        $preenche = 0;
                        $iTamanhoCelula = 25;
                    }
                    $pdf->Cell(125, $tam, '', $base, 0, "R", $preenche);
                    $pdf->Cell($iTamanhoCelula, $tam, ($sememp == "n" ? "TOTAL DE " : "") . db_formatar($quantimp, "s") . " EMPENHO" . ($quantimp == 1 ? "" : "S"), $base, 0, "L", $preenche);
                    $pdf->Cell(18, $tam, db_formatar($t_emp, 'f'), $base, 0, "R", $preenche);
                    $pdf->Cell(18, $tam, db_formatar($t_anu, 'f'), $base, 0, "R", $preenche);
                    $pdf->Cell(18, $tam, db_formatar($t_liq, 'f'), $base, 0, "R", $preenche);
                    $pdf->Cell(18, $tam, db_formatar($t_pag, 'f'), $base, 0, "R", $preenche);
                    if ($saldopagar == "s") {
                        $pdf->Cell(18, $tam, db_formatar($t_liq - $t_pag, 'f'), $base, 0, "R", $preenche);
                        $pdf->Cell(18, $tam, db_formatar($t_emp - $t_anu - $t_liq, 'f'), $base, 0, "R", $preenche); //quebra linha
                        $pdf->Cell(18, $tam, db_formatar($t_emp - $t_anu - $t_pag, 'f'), $base, 1, "R", $preenche); //quebra linha
                    } else {
                        $pdf->Ln();
                    }
                    $pdf->SetFont('Arial', '', 7);
                }
            }
            $t_emp = 0;
            $t_liq = 0;
            $t_anu = 0;
            $t_pag = 0;
            $t_total = 0;
            $repete = $e60_numcgm;
            $repete_d = $e64_codele;
            $quantimp = 0;
            if ($sememp == "n") {
                $pdf->Ln();
            }
            $pdf->SetFont('Arial', 'B', 8);
            $totalforne++;
            if ($agrupar == "d") {
                $pdf->Cell(45, $tam, "$e64_codele - $o56_elemento", $iBorda, 0, "C", 0);
                $pdf->Cell(105, $tam, "$o56_descr", $iBorda, 1, "L", 0);
            }
            $pdf->SetFont('Arial', '', 7);
        }

        /*----------- AGRUPAR POR RECURSO -----------*/
        if ($repete_r != $o15_codigo and $agrupar == "r") {
            if ($quantimp > 1 or ($sememp == "s" and $quantimp > 0)) {
                if (($quantimp > 1 and $sememp == "n") or ($quantimp > 0 and $sememp == "s")) {
                    //$pdf->setX(125);
                    $pdf->SetFont('Arial', 'B', 7);
                    if ($sememp == "n") {
                        $base = "B";
                        $preenche = 1;
                        $iTamanhoCelula = 40;
                    } else {
                        $base = "";
                        $preenche = 0;
                        $iTamanhoCelula = 25;
                    }
                    $pdf->Cell(125, $tam, '', $base, 0, "R", $preenche);
                    $pdf->Cell($iTamanhoCelula, $tam, ($sememp == "n" ? "TOTAL DE " : "") . db_formatar($quantimp, "s") . " EMPENHO" . ($quantimp == 1 ? "" : "S"), $base, 0, "L", $preenche);
                    $pdf->Cell(18, $tam, db_formatar($t_emp, 'f'), $base, 0, "R", $preenche);
                    $pdf->Cell(18, $tam, db_formatar($t_anu, 'f'), $base, 0, "R", $preenche);
                    $pdf->Cell(18, $tam, db_formatar($t_liq, 'f'), $base, 0, "R", $preenche);
                    $pdf->Cell(18, $tam, db_formatar($t_pag, 'f'), $base, 0, "R", $preenche);
                    if ($saldopagar == "s") {
                        $pdf->Cell(18, $tam, db_formatar($t_liq - $t_pag, 'f'), $base, 0, "R", $preenche);
                        $pdf->Cell(18, $tam, db_formatar($t_emp - $t_anu - $t_liq, 'f'), $base, 0, "R", $preenche); //quebra linha
                        $pdf->Cell(18, $tam, db_formatar($t_emp - $t_anu - $t_pag, 'f'), $base, 1, "R", $preenche); //quebra linha
                    } else {
                        $pdf->Ln();
                    }
                    $pdf->SetFont('Arial', '', 7);
                }
            }
            $t_emp = 0;
            $t_liq = 0;
            $t_anu = 0;
            $t_pag = 0;
            $t_total = 0;
            $repete = $e60_numcgm;
            $repete_r = $o15_codigo;
            $quantimp = 0;
            if ($sememp == "n") {
                $pdf->Ln();
            }
            $pdf->SetFont('Arial', 'B', 8);
            $totalforne++;
            if ($agrupar == "a") {
                $pdf->Cell(45, $tam, "$e60_numcgm", $iBorda, 0, "C", 0);
                $pdf->Cell(80, $tam, "$z01_nome", $iBorda, 0, "L", 0);
                if ($sememp == "n") {
                    $pdf->Cell(25, $tam, $z01_cgccpf, $iBorda, 0, "C", 0);
                    $pdf->Cell(72, $tam, $z01_munic, $iBorda, 1, "L", 0);
                }
            }
            if ($agrupar == "d") {

                $pdf->Cell(45, $tam, "$e64_codele", $iBorda, 0, "C", 0);
                $pdf->Cell(105, $tam, "$o56_descr", $iBorda, 1, "L", 0);
                if ($sememp == "n") {
                    //$pdf->Cell(25, $tam, $z01_cgccpf, 0, 0, "C", 0);
                    //$pdf->Cell(72, $tam, $z01_munic, 0, 1, "L", 0);
                }
            }
            if ($agrupar == "r") {
                $pdf->Cell(45, $tam, "$o15_codigo", $iBorda, 0, "C", 0);
                $pdf->Cell(105, $tam, "$o15_descr", $iBorda, 1, "L", 0);
                if ($sememp == "n") {
                    //$pdf->Cell(25, $tam, $z01_cgccpf, 0, 0, "C", 0);
                    //$pdf->Cell(72, $tam, $z01_munic, 0, 1, "L", 0);
                }
            }
            $pdf->SetFont('Arial', '', 7);
        }

        /* ----------- AGRUPAR POR ORGAO ----------- */
        if ($repete_r != $o58_orgao and $agrupar == "orgao") {
            if ($quantimp > 1 or ($sememp == "s" and $quantimp > 0)) {
                if (($quantimp > 1 and $sememp == "n") or ($quantimp > 0 and $sememp == "s")) {
                    //$pdf->setX(125);
                    $pdf->SetFont('Arial', 'B', 7);
                    if ($sememp == "n") {
                        $base = "B";
                        $preenche = 1;
                        $iTamanhoCelula = 40;
                    } else {
                        $base = "";
                        $preenche = 0;
                        $iTamanhoCelula = 25;
                    }
                    $pdf->Cell(125, $tam, '', $base, 0, "R", $preenche);
                    $pdf->Cell($iTamanhoCelula, $tam, ($sememp == "n" ? "TOTAL DE " : "") . db_formatar($quantimp, "s") . " EMPENHO" . ($quantimp == 1 ? "" : "S"), $base, 0, "L", $preenche);
                    $pdf->Cell(18, $tam, db_formatar($t_emp, 'f'), $base, 0, "R", $preenche);
                    $pdf->Cell(18, $tam, db_formatar($t_anu, 'f'), $base, 0, "R", $preenche);
                    $pdf->Cell(18, $tam, db_formatar($t_liq, 'f'), $base, 0, "R", $preenche);
                    $pdf->Cell(18, $tam, db_formatar($t_pag, 'f'), $base, 0, "R", $preenche);
                    if ($saldopagar == "s") {
                        $pdf->Cell(18, $tam, db_formatar($t_liq - $t_pag, 'f'), $base, 0, "R", $preenche);
                        $pdf->Cell(18, $tam, db_formatar($t_emp - $t_anu - $t_liq, 'f'), $base, 0, "R", $preenche); //quebra linha
                        $pdf->Cell(18, $tam, db_formatar($t_emp - $t_anu - $t_pag, 'f'), $base, 1, "R", $preenche); //quebra linha
                    } else {
                        $pdf->Ln();
                    }
                    $pdf->SetFont('Arial', '', 7);
                }
            }
            $t_emp = 0;
            $t_liq = 0;
            $t_anu = 0;
            $t_pag = 0;
            $t_total = 0;
            $repete = $e60_numcgm;
            $repete_r = $o58_orgao; // trocado
            $quantimp = 0;
            if ($sememp == "n") {
                $pdf->Ln();
            }
            $pdf->SetFont('Arial', 'B', 8);
            $totalforne++;
            if ($agrupar == "a") {
                $pdf->Cell(45, $tam, "$e60_numcgm", $iBorda, 0, "C", 0);
                $pdf->Cell(80, $tam, "$z01_nome", $iBorda, 0, "L", 0);
                if ($sememp == "n") {
                    $pdf->Cell(25, $tam, $z01_cgccpf, $iBorda, 0, "C", 0);
                    $pdf->Cell(72, $tam, $z01_munic, $iBorda, 1, "L", 0);
                }
            }
            if ($agrupar == "d") {
                $pdf->Cell(45, $tam, "$e64_codele", $iBorda, 0, "C", 0);
                $pdf->Cell(105, $tam, "$o56_descr", $iBorda, 1, "L", 0);
                if ($sememp == "n") {
                    //$pdf->Cell(25, $tam, $z01_cgccpf, 0, 0, "C", 0);
                    //$pdf->Cell(72, $tam, $z01_munic, 0, 1, "L", 0);
                }
            }
            if ($agrupar == "r") {
                $pdf->Cell(45, $tam, "$o15_codigo", $iBorda, 0, "C", 0);
                $pdf->Cell(105, $tam, "$o15_descr", $iBorda, 1, "L", 0);
                if ($sememp == "n") {
                    //$pdf->Cell(25, $tam, $z01_cgccpf, 0, 0, "C", 0);
                    //$pdf->Cell(72, $tam, $z01_munic, 0, 1, "L", 0);
                }
            }
            if ($agrupar == "orgao") {
                $pdf->Cell(45, $tam, "$o58_orgao", $iBorda, 0, "C", 0);
                $pdf->Cell(105, $tam, "$o40_descr", $iBorda, 1, "L", 0);
                if ($sememp == "n") {
                    //$pdf->Cell(25, $tam, $z01_cgccpf, 0, 0, "C", 0);
                    //$pdf->Cell(72, $tam, $z01_munic, 0, 1, "L", 0);
                }
            }
            // if ($agrupar == 'gest') { // aqui
            // 	$pdf->Cell(45, $tam, "Gestor:", $iBorda, 0, "C", 0);
            // 	$pdf->Cell(105, $tam, "{$e54_gestaut} - teste{$o40_descr}", $iBorda, 1, "L", 0);
            // }
            $pdf->SetFont('Arial', '', 7);
        }

        /* ----------- AGRUPAR POR DOTAÇÃO ORÇAMENTÁRIA ----------- */
        if ($repete_r != $e60_coddot and $agrupar == "do") {
            if ($quantimp > 1 or ($sememp == "s" and $quantimp > 0)) {
                if (($quantimp > 1 and $sememp == "n") or ($quantimp > 0 and $sememp == "s")) {
                    //$pdf->setX(125);
                    $pdf->SetFont('Arial', 'B', 7);
                    if ($sememp == "n") {
                        $base = "B";
                        $preenche = 1;
                        $iTamanhoCelula = 40;
                    } else {
                        $base = "";
                        $preenche = 0;
                        $iTamanhoCelula = 25;
                    }
                    $pdf->Cell(125, $tam, '', $base, 0, "R", $preenche);
                    $pdf->Cell($iTamanhoCelula, $tam, ($sememp == "n" ? "TOTAL DE " : "") . db_formatar($quantimp, "s") . " EMPENHO" . ($quantimp == 1 ? "" : "S"), $base, 0, "L", $preenche);
                    $pdf->Cell(18, $tam, db_formatar($t_emp, 'f'), $base, 0, "R", $preenche);
                    $pdf->Cell(18, $tam, db_formatar($t_anu, 'f'), $base, 0, "R", $preenche);
                    $pdf->Cell(18, $tam, db_formatar($t_liq, 'f'), $base, 0, "R", $preenche);
                    $pdf->Cell(18, $tam, db_formatar($t_pag, 'f'), $base, 0, "R", $preenche);
                    if ($saldopagar == "s") {
                        $pdf->Cell(18, $tam, db_formatar($t_liq - $t_pag, 'f'), $base, 0, "R", $preenche);
                        $pdf->Cell(18, $tam, db_formatar($t_emp - $t_anu - $t_liq, 'f'), $base, 0, "R", $preenche); //quebra linha
                        $pdf->Cell(18, $tam, db_formatar($t_emp - $t_anu - $t_pag, 'f'), $base, 1, "R", $preenche); //quebra linha
                    } else {
                        $pdf->Ln();
                    }
                    $pdf->SetFont('Arial', '', 7);
                }
            }
            $t_emp = 0;
            $t_liq = 0;
            $t_anu = 0;
            $t_pag = 0;
            $t_total = 0;
            $repete = $e60_numcgm;
            $repete_r = $e60_coddot;
            $quantimp = 0;
            if ($sememp == "n") {
                $pdf->Ln();
            }
            $pdf->SetFont('Arial', 'B', 8);
            $totalforne++;

            if ($agrupar == "do") {
                $pdf->Cell(45, $tam, "$e60_coddot", $iBorda, 0, "C", 0);
                $pdf->Cell(63, $tam, "$dl_estrutural", $iBorda, 1, "L", 0);
            }

            $pdf->SetFont('Arial', '', 7);
        }

        /* ----------- AGRUPAR POR GEST ----------- */
        if ($sGestorAtual != "{$e54_gestaut} :: {$descrdepto}" and $agrupar == 'gest') {

            $sGestorAtual = "{$e54_gestaut} :: {$descrdepto}";

            if ($quantimp >= 1 or ($sememp == "s" and $quantimp > 0)) {
                if (($quantimp >= 1 and $sememp == "n") or ($quantimp > 0 and $sememp == "s")) {
                    //$pdf->setX(125);
                    $pdf->SetFont('Arial', 'B', 7);
                    if ($sememp == "n") {
                        $base = "B";
                        $preenche = 1;
                        $iTamanhoCelula = 40;
                    } else {
                        $base = "";
                        $preenche = 0;
                        $iTamanhoCelula = 25;
                    }
                    $pdf->Cell(125, $tam, '', $base, 0, "R", $preenche);
                    $pdf->Cell($iTamanhoCelula, $tam, ($sememp == "n" ? "TOTAL DE " : "") . db_formatar($quantimp, "s") . " EMPENHO" . ($quantimp == 1 ? "" : "S"), $base, 0, "L", $preenche);
                    $pdf->Cell(18, $tam, db_formatar($t_emp, 'f'), $base, 0, "R", $preenche);
                    $pdf->Cell(18, $tam, db_formatar($t_anu, 'f'), $base, 0, "R", $preenche);
                    $pdf->Cell(18, $tam, db_formatar($t_liq, 'f'), $base, 0, "R", $preenche);
                    $pdf->Cell(18, $tam, db_formatar($t_pag, 'f'), $base, 0, "R", $preenche);
                    if ($saldopagar == "s") {
                        $pdf->Cell(18, $tam, db_formatar($t_liq - $t_pag, 'f'), $base, 0, "R", $preenche);
                        $pdf->Cell(18, $tam, db_formatar($t_emp - $t_anu - $t_liq, 'f'), $base, 0, "R", $preenche); //quebra linha
                        $pdf->Cell(18, $tam, db_formatar($t_emp - $t_anu - $t_pag, 'f'), $base, 1, "R", $preenche); //quebra linha
                    } else {
                        $pdf->Ln();
                    }
                    $pdf->SetFont('Arial', '', 7);
                }
            }

            $t_emp = 0;
            $t_liq = 0;
            $t_anu = 0;
            $t_pag = 0;
            $t_total = 0;
            $repete = $e60_numcgm;
            $repete_r = $o15_codigo;
            $quantimp = 0;
            if ($sememp == "n") {
                $pdf->Ln();
            }
            $pdf->SetFont('Arial', 'B', 8);
            $totalforne++;

            // imprime código e nome do gestor
            $pdf->Cell(30, $tam, "Gestor:", $iBorda, 0, "L", 0);
            $pdf->Cell(120, $tam, "{$e54_gestaut} :: {$descrdepto}", $iBorda, 1, "L", 0);

            $pdf->SetFont('Arial', '', 7);
        }

        /* ----------- AGRUPAR POR CONTRATO ----------- */
        if ($sContratoAtual != "{$ac16_sequencial}" and $agrupar == "c") {

            $sContratoAtual = "{$ac16_sequencial}";

            if ($quantimp >= 1 or ($sememp == "s" and $quantimp > 0)) {
                if (($quantimp >= 1 and $sememp == "n") or ($quantimp > 0 and $sememp == "s")) {
                    //$pdf->setX(125);
                    $pdf->SetFont('Arial', 'B', 7);
                    if ($sememp == "n") {
                        $base = "B";
                        $preenche = 1;
                        $iTamanhoCelula = 40;
                    } else {
                        $base = "";
                        $preenche = 0;
                        $iTamanhoCelula = 25;
                    }
                    $pdf->Cell(125, $tam, '', $base, 0, "R", $preenche);
                    $pdf->Cell($iTamanhoCelula, $tam, ($sememp == "n" ? "TOTAL DE " : "") . db_formatar($quantimp, "s") . " EMPENHO" . ($quantimp == 1 ? "" : "S"), $base, 0, "L", $preenche);
                    $pdf->Cell(18, $tam, db_formatar($t_emp, 'f'), $base, 0, "R", $preenche);
                    $pdf->Cell(18, $tam, db_formatar($t_anu, 'f'), $base, 0, "R", $preenche);
                    $pdf->Cell(18, $tam, db_formatar($t_liq, 'f'), $base, 0, "R", $preenche);
                    $pdf->Cell(18, $tam, db_formatar($t_pag, 'f'), $base, 0, "R", $preenche);
                    if ($saldopagar == "s") {
                        $pdf->Cell(18, $tam, db_formatar($t_liq - $t_pag, 'f'), $base, 0, "R", $preenche);
                        $pdf->Cell(18, $tam, db_formatar($t_emp - $t_anu - $t_liq, 'f'), $base, 0, "R", $preenche); //quebra linha
                        $pdf->Cell(18, $tam, db_formatar($t_emp - $t_anu - $t_pag, 'f'), $base, 1, "R", $preenche); //quebra linha
                    } else {
                        $pdf->Ln();
                    }
                    $pdf->SetFont('Arial', '', 7);
                }
            }

            $t_emp = 0;
            $t_liq = 0;
            $t_anu = 0;
            $t_pag = 0;
            $t_total = 0;
            $repete = $e60_numcgm;
            $repete_r = $o15_codigo;
            $quantimp = 0;
            if ($sememp == "n") {
                $pdf->Ln();
            }
            $pdf->SetFont('Arial', 'B', 8);
            $totalforne++;

            // imprime resumo obj do contrato
            if (!empty($ac16_sequencial)) {
                $pdf->Cell(30, $tam, "Contrato:", $iBorda, 0, "L", 0);
                $pdf->Cell(120, $tam, "{$ac16_sequencial} - {$ac16_numero} :: {$ac16_resumoobjeto}", $iBorda, 1, "L", 0);
            } else {
                $pdf->Cell(30, $tam, "Sem Contrato Vinculado ", $iBorda, 1, "1", 0);
            }
            $pdf->SetFont('Arial', '', 7);
        }

        /* ----------- AGRUPAR POR TIPO DE ANULAÇÃO ----------- */
        if ($repete_ta != $e94_empanuladotipo and $agrupar == 'ta') {
            if ($quantimp >= 1 or ($sememp == "s" and $quantimp > 0)) {
                if (($quantimp >= 1 and $sememp == "n") or ($quantimp > 0 and $sememp == "s")) {
                    //$pdf->setX(125);
                    $pdf->SetFont('Arial', 'B', 7);
                    if ($sememp == "n") {
                        $base = "B";
                        $preenche = 1;
                        $iTamanhoCelula = 40;
                    } else {
                        $base = "";
                        $preenche = 0;
                        $iTamanhoCelula = 25;
                    }
                    $pdf->Cell(125, $tam, '', $base, 0, "R", $preenche);
                    $pdf->Cell($iTamanhoCelula, $tam, ($sememp == "n" ? "TOTAL DE " : "") . db_formatar($quantimp, "s") . " EMPENHO" . ($quantimp == 1 ? "" : "S"), $base, 0, "L", $preenche);
                    $pdf->Cell(18, $tam, db_formatar($t_emp, 'f'), $base, 0, "R", $preenche);
                    $pdf->Cell(18, $tam, db_formatar($t_anu, 'f'), $base, 0, "R", $preenche);
                    $pdf->Cell(18, $tam, db_formatar($t_liq, 'f'), $base, 0, "R", $preenche);
                    $pdf->Cell(18, $tam, db_formatar($t_pag, 'f'), $base, 0, "R", $preenche);
                    if ($saldopagar == "s") {
                        $pdf->Cell(18, $tam, db_formatar($t_liq - $t_pag, 'f'), $base, 0, "R", $preenche);
                        $pdf->Cell(18, $tam, db_formatar($t_emp - $t_anu - $t_liq, 'f'), $base, 0, "R", $preenche); //quebra linha
                        $pdf->Cell(18, $tam, db_formatar($t_emp - $t_anu - $t_pag, 'f'), $base, 1, "R", $preenche); //quebra linha
                    } else {
                        $pdf->Ln();
                    }
                    $pdf->SetFont('Arial', '', 7);
                }
            }
            $t_emp = 0;
            $t_liq = 0;
            $t_anu = 0;
            $t_pag = 0;
            $t_total = 0;
            $repete = $e94_empanuladotipo;
            $repete_ta = $e94_empanuladotipo;
            $quantimp = 0;
            if ($sememp == "n") {
                $pdf->Ln();
            }
            $pdf->SetFont('Arial', 'B', 8);
            $totalforne++;

            // imprime código e nome do tipo de anulacao

            $pdf->Cell(120, $tam, $e94_empanuladotipo . "-" . $e38_descr, $iBorda, 1, "L", 0);

            $pdf->SetFont('Arial', '', 7);
        }

        if ($agrupar == "a") {
            $preenche = 1;
        }
        if ($agrupar == "d") {
            if ($mostralan == 'm') {
                $preenche = 1;
            } else {
                $preenche = 0;
            }
        } else {
            $preenche = 0;
        }
        if ($agrupar == "r") {
            if ($mostralan == 'm') {
                $preenche = 1;
            } else {
                $preenche = 0;
            }
        } else {
            $preenche = 0;
        }
        if ($agrupar == "orgao") {
            if ($mostralan == 'm') {
                $preenche = 1;
            } else {
                $preenche = 0;
            }
        } else {
            $preenche = 0;
        }

        $quantimp++;
        // caso o exercicio do empenho for maior que o do exercicio do resto nao gerar

        if (substr($dataesp22, 0, 4) < db_getsession("DB_anousu")) {

            $resresto = $clempresto->sql_record($clempresto->sql_query(db_getsession("DB_anousu"), $e60_numemp, "*", "", ""));
            if ($clempresto->numrows > 0) {
                db_fieldsmemory($resresto, 0, true);
                if ($processar != "a") {
                    $e60_vlremp += $e91_vlremp;
                    $e60_vlranu += $e91_vlranu;
                    $e60_vlrliq += $e91_vlrliq;
                    $e60_vlrpag += $e91_vlrpag;
                }
            }
        }

        $total = $e60_vlrliq - $e60_vlrpag;

        // o tipo sempre é == "A"
        if ($tipo == "a" and $sememp == "n") {
            $pdf->Cell(20, $tam, substr($pc50_descr, 0, 10), $iBorda, 0, "L", $preenche);
            $pdf->Cell(11, $tam, "$e60_numerol", $iBorda, 0, "R", $preenche);
            $pdf->Cell(11, $tam, "$e60_codemp", $iBorda, 0, "R", $preenche);
            $pdf->Cell(15, $tam, $e60_emiss, $iBorda, 0, "C", $preenche);
            if ($agrupar == "a") {
                if ($mostrar == "r") {
                    $pdf->Cell(40, $tam, db_formatar($o15_codigo, 'recurso') . " - " . substr($o15_descr, 0, 20), $iBorda, 0, "L", $preenche); // recurso
                } else
                    if ($mostrar == "t") {
                    $pdf->Cell(40, $tam, $e60_codcom . " - $pc50_descr", $iBorda, 0, "L", $preenche); // tipo de compra
                }
            }
            if ($agrupar == "d") {
                if ($mostrar == "r") {
                    $pdf->Cell(46, $tam, substr($z01_nome, 0, 28), $iBorda, 0, "L", $preenche); // recurso
                } elseif ($mostrar == "t") {
                    $pdf->Cell(40, $tam, $e60_codcom . " - $pc50_descr", $iBorda, 0, "L", $preenche); // tipo de compra
                }
            }
            if ($agrupar == "r" || $agrupar == "c") {
                if ($mostrar == "r") {
                    $pdf->Cell(46, $tam, substr($z01_nome, 0, 28), $iBorda, 0, "L", $preenche); // recurso
                } else
                    if ($mostrar == "t") {
                    $pdf->Cell(40, $tam, $e60_codcom . " - $pc50_descr", $iBorda, 0, "L", $preenche); // tipo de compra
                }
            }
            if ($agrupar == "orgao") {
                if ($mostrar == "r") {
                    $pdf->Cell(46, $tam, substr($z01_nome, 0, 28), $iBorda, 0, "L", $preenche); // recurso
                } else
                    if ($mostrar == "t") {
                    $pdf->Cell(40, $tam, $e60_codcom . " - $pc50_descr", $iBorda, 0, "L", $preenche); // tipo de compra
                }
            }
            if ($agrupar == "oo" || $agrupar == 'gest') {
                $pdf->Cell(46, $tam, substr($z01_nome, 0, 28), $iBorda, 0, "L", 0);
            }

            if ($agrupar == 'ta') {
                $pdf->Cell(46, $tam, substr($z01_nome, 0, 28), $iBorda, 0, "L", 0);
            }

            if ($agrupar == "do") {
                $pdf->Cell(46, $tam, substr($z01_nome, 0, 27), $iBorda, 0, "L", $preenche); //quebra linha 108
                $pdf->Cell(62, $tam, str_pad($e60_coddot, 4, '0', STR_PAD_LEFT) . " -  $dl_estrutural", $iBorda, 0, "L", $preenche); //quebra linha
            } else {
                $pdf->Cell(62, $tam, str_pad($e60_coddot, 4, '0', STR_PAD_LEFT) . " -  $dl_estrutural", $iBorda, 0, "L", $preenche); //quebra linha
            }

            $pdf->Cell(18, $tam, db_formatar($e60_vlremp, 'f'), 'B', 0, "R", $preenche);
            $pdf->Cell(18, $tam, db_formatar($e60_vlranu, 'f'), 'B', 0, "R", $preenche);
            $pdf->Cell(18, $tam, db_formatar($e60_vlrliq, 'f'), 'B', 0, "R", $preenche);
            $pdf->Cell(18, $tam, db_formatar($e60_vlrpag, 'f'), 'B', 0, "R", $preenche);
            $pdf->Cell(18, $tam, db_formatar($e60_vlrliq - $e60_vlrpag, 'f'), 'B', 0, "R", $preenche); //quebra linha
            $pdf->Cell(18, $tam, db_formatar($e60_vlremp - $e60_vlranu - $e60_vlrliq, 'f'), 'B', 0, "R", $preenche);
            $pdf->Cell(18, $tam, db_formatar($e60_vlremp - $e60_vlranu - $e60_vlrpag, 'f'), 'B', 1, "R", $preenche);
            if ($mostrarobs == "m") {
                $pdf->multicell(270, 4, $e60_resumo);
            }


            if (1 == 1) {
                $reslancam = $clconlancamemp->sql_record($clconlancamemp->sql_query("", "*", "c75_codlan", " c75_numemp = $e60_numemp " . ($processar == "a" ? "" : " and c75_data between '$dataesp11' and '$dataesp22'")));
                $rows_lancamemp = $clconlancamemp->numrows;

                $totemp = 0;
                $totanuemp = 0;
                $totliq = 0;
                $totanuliq = 0;
                $totpag = 0;
                $totanupag = 0;

                for ($lancemp = 0; $lancemp < $rows_lancamemp; $lancemp++) {
                    db_fieldsmemory($reslancam, $lancemp, true);
                    $reslancamdoc = $clconlancamdoc->sql_record($clconlancamdoc->sql_query($c70_codlan, "*"));
                    db_fieldsmemory($reslancamdoc, 0, true);
                    if ($mostralan == "m") {
                        $preenche = ($lancemp % 2 == 0 ? 0 : 1);
                        $pdf->Cell(40, $tam, "", $iBorda, 0, "R", $preenche);
                        $pdf->Cell(20, $tam, $c70_data, $iBorda, 0, "C", $preenche);
                        $pdf->Cell(25, $tam, $c70_codlan, $iBorda, 0, "R", $preenche);
                        $pdf->Cell(25, $tam, substr($c53_descr, 0, 22), $iBorda, 0, "L", $preenche);
                        $pdf->Cell(25, $tam, db_formatar($c70_valor, 'f'), $iBorda, 1, "R", $preenche);
                    }

                    if ($c53_tipo == 10) {
                        $lanctotemp += $c70_valor;
                        $totemp  += $c70_valor;
                    } elseif ($c53_tipo == 11) {
                        $lanctotanuemp += $c70_valor;
                        $totanuemp  += $c70_valor;
                    } elseif ($c53_tipo == 20) {
                        $lanctotliq += $c70_valor;
                        $totliq  += $c70_valor;
                    } elseif ($c53_tipo == 21) {
                        $lanctotanuliq += $c70_valor;
                        $totanuliq     += $c70_valor;
                    } elseif ($c53_tipo == 30) {
                        $lanctotpag += $c70_valor;
                        $totpag     += $c70_valor;
                    } elseif ($c53_tipo == 31) {
                        $lanctotanupag += $c70_valor;
                        $totanupag     += $c70_valor;
                    }
                }

                if ($agrupar == "ta") {
                    $tamanho = 105;
                } else {
                    $tamanho = 105;
                }

                if ($processar == "e") {
                    $preenche = 0;
                    $pdf->Cell($tamanho, $tam, '', "B", 0, "R", $preenche);
                    $pdf->Cell(60, $tam, "Movimentação do Empenho no Período", "B", 0, "R", $preenche);
                    $pdf->Cell(18, $tam, db_formatar($totemp, 'f'), "B", 0, "R", $preenche);
                    $pdf->Cell(18, $tam, db_formatar($totanuemp, 'f'), "B", 0, "R", $preenche);
                    $pdf->Cell(18, $tam, db_formatar($totliq - $totanuliq, 'f'), "B", 0, "R", $preenche);
                    $pdf->Cell(18, $tam, db_formatar($totpag - $totanupag, 'f'), "B", 0, "R", $preenche);
                    $pdf->Cell(18, $tam, db_formatar(($totliq - $totanuliq) - ($totpag - $totanupag), 'f'), "B", 0, "R", $preenche);
                    $pdf->Cell(18, $tam, db_formatar(($totemp - ($totanuemp + ($totpag - $totanupag))) - (($totliq - $totanuliq) - ($totpag - $totanupag)), 'f'), "B", 0, "R", $preenche); //quebra linha
                    $pdf->Cell(18, $tam, db_formatar($totemp - ($totanuemp + ($totpag - $totanupag)), 'f'), "B", 1, "R", $preenche); //quebra linha
                    $pdf->SetFont('Arial', '', 7);
                }
            }

            if ($mostraritem == "m") {
                if ($instits != db_getsession("DB_instit")) {
                    $dbwhere = "e62_numemp = $e60_numemp ";
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
                        //$preenche = ($item % 2 == 0 ? 0 : 1);
                        $preenche = 1;
                        $pdf->Cell(40, $tam, "", $iBorda, 0, "R", $preenche);
                        $pdf->Cell(20, $tam, "$e62_item", $iBorda, 0, "R", $preenche);
                        //$pdf->Cell(75, $tam, $descrmatersub, $iBorda, 0, "L", $preenche);
                        $aDescrmater = quebrar_texto($pc01_descrmater, 150);
                        $iTamFixo = 5;
                        $iTam = $iTamFixo * (count($aDescrmater));
                        if (strlen($pc01_descrmater) > 150) {
                            multiCell($pdf, $aDescrmater, $iTamFixo, $iTam, 150, $preenche);
                        } else {
                            $pdf->Cell(150, $tam, $pc01_descrmater, $iBorda, 0, "L", $preenche);
                        }
                        $pdf->Cell(20, $tam, db_formatar($e62_quant, 'f'), $iBorda, 0, "R", $preenche);
                        $pdf->Cell(20, $tam, db_formatar($e62_vltot, 'f'), $iBorda, 1, "R", $preenche);
                        //$pdf->Cell(80, $tam, substr($e62_descr, 0, 100), $iBorda, 0, "L", $preenche);
                        //$pdf->Cell(20, $tam, "", 0, 1, "R", 0);
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
                    $sWhereEmpenho   = "e60_numemp = {$e60_numemp}";

                    $oDaoEmpenho      = db_utils::getDao("empempenho");
                    $sSqlItensEmpenho = $oDaoEmpenho->sql_query_itens_consulta_empenho($e60_numemp, $sCamposEmpenho);
                    $rsBuscaEmpenho   = $oDaoEmpenho->sql_record($sSqlItensEmpenho);
                    for ($item = 0; $item < $oDaoEmpenho->numrows; $item++) {
                        db_fieldsmemory($rsBuscaEmpenho, $item, true);
                        //$preenche = ($item % 2 == 0 ? 0 : 1);
                        $preenche = 1;
                        $pdf->Cell(40, $tam, "", $iBorda, 0, "R", $preenche);
                        $pdf->Cell(20, $tam, "$e62_item", $iBorda, 0, "R", $preenche);
                        //$pdf->Cell(75, $tam, $descrmatersub, $iBorda, 0, "L", $preenche);
                        $aDescrmater = quebrar_texto($pc01_descrmater, 150);
                        $iTamFixo = 5;
                        $iTam = $iTamFixo * (count($aDescrmater));
                        if (strlen($pc01_descrmater) > 150) {
                            multiCell($pdf, $aDescrmater, $iTamFixo, $iTam, 150, $preenche);
                        } else {
                            $pdf->Cell(150, $tam, $pc01_descrmater, $iBorda, 0, "L", $preenche);
                        }
                        $pdf->Cell(20, $tam, db_formatar($e62_quant, 'f'), $iBorda, 0, "R", $preenche);
                        $pdf->Cell(20, $tam, db_formatar($e62_vltot, 'f'), $iBorda, 0, "R", $preenche);
                        $pdf->Cell(20, $tam, db_formatar($saldo_valor, 'f'), $iBorda, 1, "R", $preenche);
                        //$pdf->Cell(80, $tam, substr($e62_descr, 0, 100), $iBorda, 0, "L", $preenche);
                        //$pdf->Cell(20, $tam, "", 0, 1, "R", 0);

                    }
                }
            }
        }

        if ($sememp == "n") {
            $pdf->Ln(1);
        }
        /* somatorio  */
        $t_emp += $e60_vlremp;
        $t_liq += $e60_vlrliq;
        $t_anu += $e60_vlranu;
        $t_pag += $e60_vlrpag;
        $t_total += $total;
        $g_emp += $e60_vlremp;
        $g_liq += $e60_vlrliq;
        $g_anu += $e60_vlranu;
        $g_pag += $e60_vlrpag;
        $g_total += $total;
        /*  */
        if ($x == ($rows - 1)) {
            //$pdf->setX(125);
            /* imprime totais -*/
            $pdf->SetFont('Arial', 'B', 7);
            if ($sememp == "n") {
                $base = "B";
                $preenche = 1;
                $iTamanhoCelula = 40;
                $iCelulaFornec  = 80;
            } else {

                $base = "";
                $preenche = 0;
                $iTamanhoCelula = 25;
                $iCelulaFornec  = 65;
            }
            $iTamanho = 125;

            $pdf->Cell($iTamanho, $tam, '', $base, 0, "R", $preenche);
            $pdf->Cell($iTamanhoCelula, $tam, ($sememp == "n" ? "TOTAL DE " : "") . db_formatar($quantimp, "s") . " EMPENHO" . ($quantimp == 1 ? "" : "S"), $base, 0, "L", $preenche);
            $pdf->Cell(18, $tam, db_formatar($t_emp, 'f'), $base, 0, "R", $preenche);
            $pdf->Cell(18, $tam, db_formatar($t_anu, 'f'), $base, 0, "R", $preenche);
            $pdf->Cell(18, $tam, db_formatar($t_liq, 'f'), $base, 0, "R", $preenche);
            $pdf->Cell(18, $tam, db_formatar($t_pag, 'f'), $base, 0, "R", $preenche);
            if ($saldopagar == "s") {
                $pdf->Cell(18, $tam, db_formatar($t_liq - $t_pag, 'f'), $base, 0, "R", $preenche);
                $pdf->Cell(18, $tam, db_formatar($t_emp - $t_anu - $t_liq, 'f'), $base, 0, "R", $preenche); //quebra linha
                $pdf->Cell(18, $tam, db_formatar($t_emp - $t_anu - $t_pag, 'f'), $base, 1, "R", $preenche); //quebra linha
            } else {
                $pdf->Ln();
            }
            $pdf->Ln();
            $pdf->Ln();
            if ($agrupar == "ta") {
                $pdf->Cell(138, $tam, "TOTAL DE EMPENHOS: " . db_formatar($rows, "s"), "T", 0, "L", 1);
                $pdf->Cell(27, $tam, "TOTAL GERAL", "T", 0, "L", 1);
                $pdf->Cell(18, $tam, db_formatar($g_emp, 'f'), "T", 0, "R", 1); //totais globais
                $pdf->Cell(18, $tam, db_formatar($g_anu, 'f'), "T", 0, "R", 1);
                $pdf->Cell(18, $tam, db_formatar($g_liq, 'f'), "T", 0, "R", 1);
                $pdf->Cell(18, $tam, db_formatar($g_pag, 'f'), "T", 0, "R", 1);
                if ($saldopagar == "s") {
                    $pdf->Cell(18, $tam, db_formatar($g_liq - $g_pag, 'f'), "T", 0, "R", 1);
                    $pdf->Cell(18, $tam, db_formatar($g_emp - $g_anu - $g_liq, 'f'), "T", 0, "R", 1); //quebra linha
                    $pdf->Cell(18, $tam, db_formatar($g_emp - $g_anu - $g_pag, 'f'), "T", 1, "R", 1); //quebra linha
                } else {
                    $pdf->Ln();
                }

                $pdf->Ln();
                $pdf->Cell(165, $tam, "MOVIMENTAÇÃO CONTABIL NO PERIODO", "T", 0, "L", 1);
                $pdf->Cell(18, $tam, db_formatar($lanctotemp, 'f'), "T", 0, "R", 1); //totais globais
                $pdf->Cell(18, $tam, db_formatar($lanctotanuemp, 'f'), "T", 0, "R", 1);
                $pdf->Cell(18, $tam, db_formatar($lanctotliq - $lanctotanuliq, 'f'), "T", 0, "R", 1);
                $pdf->Cell(18, $tam, db_formatar($lanctotpag - $lanctotanupag, 'f'), "T", 0, "R", 1);
                if ($saldopagar == "s") {
                    $pdf->Cell(18, $tam, db_formatar(($lanctotliq - $lanctotanuliq) - ($lanctotpag - $lanctotanupag), 'f'), "T", 0, "R", 1);
                    $pdf->Cell(18, $tam, db_formatar(($lanctotemp - ($lanctotanuemp + ($lanctotpag - $lanctotanupag))) - (($lanctotliq - $lanctotanuliq) - ($lanctotpag - $lanctotanupag)), 'f'), "T", 0, "R", 1);
                    $pdf->Cell(18, $tam, db_formatar($lanctotemp - ($lanctotanuemp + ($lanctotpag - $lanctotanupag)), 'f'), "T", 1, "R", 1);
                } else {
                    $pdf->Ln();
                }
                $pdf->SetFont('Arial', '', 7);
            } else {
                $pdf->Cell(60, $tam, "TOTAL DE EMPENHOS: " . db_formatar($rows, "s"), "T", 0, "L", 1);

                if ($totalforne > 0) {
                    $pdf->Cell($iCelulaFornec, $tam, "TOTAL DE FORNECEDORES: " . db_formatar($totalforne, "s"), "T", 0, "L", 1);
                } else {
                    $pdf->Cell($iCelulaFornec, $tam, "", "T", 0, "L", 1);
                }
                $pdf->Cell(25, $tam, "TOTAL GERAL", "T", 0, "L", 1);
                $pdf->Cell(18, $tam, db_formatar($g_emp, 'f'), "T", 0, "R", 1); //totais globais
                $pdf->Cell(18, $tam, db_formatar($g_anu, 'f'), "T", 0, "R", 1);
                $pdf->Cell(18, $tam, db_formatar($g_liq, 'f'), "T", 0, "R", 1);
                $pdf->Cell(18, $tam, db_formatar($g_pag, 'f'), "T", 0, "R", 1);
                if ($saldopagar == "s") {
                    $pdf->Cell(18, $tam, db_formatar($g_liq - $g_pag, 'f'), "T", 0, "R", 1);
                    $pdf->Cell(18, $tam, db_formatar($g_emp - $g_anu - $g_liq, 'f'), "T", 0, "R", 1); //quebra linha
                    $pdf->Cell(18, $tam, db_formatar($g_emp - $g_anu - $g_pag, 'f'), "T", 1, "R", 1); //quebra linha
                } else {
                    $pdf->Ln();
                }

                $pdf->Ln();
                $iTam = $sememp == "n" ? 165 : 150;
                $pdf->Cell($iTam, $tam, "MOVIMENTAÇÃO CONTABIL NO PERIODO", "T", 0, "L", 1);
                $pdf->Cell(18, $tam, db_formatar($lanctotemp, 'f'), "T", 0, "R", 1); //totais globais
                $pdf->Cell(18, $tam, db_formatar($lanctotanuemp, 'f'), "T", 0, "R", 1);
                $pdf->Cell(18, $tam, db_formatar($lanctotliq - $lanctotanuliq, 'f'), "T", 0, "R", 1);
                $pdf->Cell(18, $tam, db_formatar($lanctotpag - $lanctotanupag, 'f'), "T", 0, "R", 1);
                if ($saldopagar == "s") {
                    $pdf->Cell(18, $tam, db_formatar(($lanctotliq - $lanctotanuliq) - ($lanctotpag - $lanctotanupag), 'f'), "T", 0, "R", 1);
                    $pdf->Cell(18, $tam, db_formatar(($lanctotemp - ($lanctotanuemp + ($lanctotpag - $lanctotanupag))) - (($lanctotliq - $lanctotanuliq) - ($lanctotpag - $lanctotanupag)), 'f'), "T", 0, "R", 1);
                    $pdf->Cell(18, $tam, db_formatar($lanctotemp - ($lanctotanuemp + ($lanctotpag - $lanctotanupag)), 'f'), "T", 1, "R", 1);
                } else {
                    $pdf->Ln();
                }
                $pdf->SetFont('Arial', '', 7);
            }
        }
    }
}

/* geral sintetico */
if ($tipo == "s") {

    $pdf->SetFont('Arial', '', 7);
    for ($x = 0; $x < $rows; $x++) {
        db_fieldsmemory($res, $x, true);
        // testa nova pagina
        if ($pdf->gety() > $pdf->h - 30) {
            $pdf->addpage("L");
            $imprime_header = true;
        }

        if ($imprime_header == true) {
            $pdf->Ln();
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(20, $tam, strtoupper($RLe60_numcgm), 1, 0, "C", 1);
            $pdf->Cell(100, $tam, strtoupper($RLz01_nome), 1, 0, "C", 1);
            $pdf->Cell(20, $tam, strtoupper($RLe60_vlremp), 1, 0, "C", 1);
            $pdf->Cell(20, $tam, strtoupper($RLe60_vlranu), 1, 0, "C", 1);
            $pdf->Cell(20, $tam, strtoupper($RLe60_vlrliq), 1, 0, "C", 1);
            $pdf->Cell(20, $tam, strtoupper($RLe60_vlrpag), 1, 0, "C", 1);
            $pdf->Cell(30, $tam, "TOTAL A PAGAR", 1, 1, "C", 1); //quebra linha
            $pdf->Ln();
            $pdf->SetFont('Arial', '', 7);
            $imprime_header = false;
        }
        /* ----------- */
        $pdf->Ln(1);
        $pdf->Cell(20, $tam, $e60_numcgm, $iBorda, 0, "R", $p);
        $pdf->Cell(100, $tam, $z01_nome, $iBorda, 0, "L", $p);
        $pdf->Cell(20, $tam, $e60_vlremp, $iBorda, 0, "R", $p);
        $pdf->Cell(20, $tam, $e60_vlranu, $iBorda, 0, "R", $p);
        $pdf->Cell(20, $tam, $e60_vlrliq, $iBorda, 0, "R", $p);
        $pdf->Cell(20, $tam, $e60_vlrpag, $iBorda, 0, "R", $p);
        $total = $e60_vlremp - $e60_vlranu - $e60_vlrpag;
        $pdf->Cell(30, $tam, db_formatar($total, 'f'), $iBorda, 1, "R", $p); //quebra linha
        $t_emp += $e60_vlremp;
        $t_liq += $e60_vlrliq;
        $t_anu += $e60_vlranu;
        $t_pag += $e60_vlrpag;
        $t_total += $total;
        if ($p == 0) {
            $p = 1;
        } else
            $p = 0;
        if ($x == ($rows - 1)) {
            $pdf->Ln();
            $pdf->setX(110);
            /* imprime totais -*/
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(25, $tam, "TOTAL ", "T", 0, "L", 1);
            $pdf->Cell(20, $tam, db_formatar($t_emp, 'f'), "T", 0, "R", 1);
            $pdf->Cell(20, $tam, db_formatar($t_anu, 'f'), "T", 0, "R", 1);
            $pdf->Cell(20, $tam, db_formatar($t_liq, 'f'), "T", 0, "R", 1);
            $pdf->Cell(20, $tam, db_formatar($t_pag, 'f'), "T", 0, "R", 1);
            $pdf->Cell(22, $tam, db_formatar($t_total, 'f'), "T", 1, "R", 1); //quebra linha
            $pdf->SetFont('Arial', '', 7);
        }
        /* */
    }
} /* fim geral sintetico */

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
        $pdf->addpage("L");
        $imprime_header = true;
        $rows = $clempempenho->numrows;

        $pdf->SetFont('Arial', '', 7);
        for ($x = 0; $x < $rows; $x++) {
            db_fieldsmemory($result, $x, true);
            // testa nova pagina
            if ($pdf->gety() > $pdf->h - 30) {
                $pdf->addpage("L");
                $imprime_header = true;
            }

            if ($imprime_header == true) {
                $pdf->Ln();
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->cell(200, $tam, "TOTALIZAÇÃO DOS HISTÓRICOS", 1, 0, "C", 1);
                $pdf->cell(66, $tam, "SALDO A PAGAR", 1, 1, "C", 1);
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->Cell(20, $tam, strtoupper($RLe63_codhist), 1, 0, "C", 1);
                $pdf->Cell(100, $tam, strtoupper($RLe40_descr), 1, 0, "C", 1);
                $pdf->Cell(20, $tam, strtoupper($RLe60_vlremp), 1, 0, "C", 1);
                $pdf->Cell(20, $tam, strtoupper($RLe60_vlranu), 1, 0, "C", 1);
                $pdf->Cell(20, $tam, strtoupper($RLe60_vlrliq), 1, 0, "C", 1);
                $pdf->Cell(20, $tam, strtoupper($RLe60_vlrpag), 1, 0, "C", 1);
                $pdf->Cell(22, $tam, "LIQUIDADO", 1, 0, "C", 1); //quebra linha
                $pdf->Cell(22, $tam, "NAO LIQUIDADO", 1, 0, "C", 1); //quebra linha
                $pdf->Cell(22, $tam, "GERAL", 1, 1, "C", 1); //quebra linha
                $pdf->Ln();
                $pdf->SetFont('Arial', '', 7);
                $imprime_header = false;
            }
            /* ----------- */
            $pdf->Ln(1);
            $pdf->Cell(20, $tam, $e63_codhist, $iBorda, 0, "R", $p);
            $pdf->Cell(100, $tam, $e40_descr, $iBorda, 0, "L", $p);
            $pdf->Cell(20, $tam, $e60_vlremp, $iBorda, 0, "R", $p);
            $pdf->Cell(20, $tam, $e60_vlranu, $iBorda, 0, "R", $p);
            $pdf->Cell(20, $tam, $e60_vlrliq, $iBorda, 0, "R", $p);
            $pdf->Cell(20, $tam, $e60_vlrpag, $iBorda, 0, "R", $p);
            $total = $e60_vlrliq - $e60_vlrpag;
            $pdf->Cell(22, $tam, db_formatar($e60_vlrliq - $e60_vlrpag, 'f'), $iBorda, 0, "R", $p);
            $pdf->Cell(22, $tam, db_formatar($e60_vlremp - $e60_vlranu - $e60_vlrliq, 'f'), $iBorda, 0, "R", $p);
            $pdf->Cell(22, $tam, db_formatar($e60_vlremp - $e60_vlranu - $e60_vlrpag, 'f'), $iBorda, 1, "R", $p); //quebra linha
            $t_emp1 += $e60_vlremp;
            $t_liq1 += $e60_vlrliq;
            $t_anu1 += $e60_vlranu;
            $t_pag1 += $e60_vlrpag;
            $t_total1 += $total;
            if ($p == 0) {
                $p = 1;
            } else
                $p = 0;
            if ($x == ($rows - 1)) {
                $pdf->Ln();
                $pdf->setX(110);
                /* imprime totais -*/
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->Cell(20, $tam, "TOTAL ", "T", 0, "L", 1);
                $pdf->Cell(20, $tam, db_formatar($t_emp1, 'f'), "T", 0, "R", 1);
                $pdf->Cell(20, $tam, db_formatar($t_anu1, 'f'), "T", 0, "R", 1);
                $pdf->Cell(20, $tam, db_formatar($t_liq1, 'f'), "T", 0, "R", 1);
                $pdf->Cell(20, $tam, db_formatar($t_pag1, 'f'), "T", 0, "R", 1);
                $pdf->Cell(22, $tam, db_formatar($t_liq1 - $t_pag1, 'f'), "T", 0, "R", 1);
                $pdf->Cell(22, $tam, db_formatar($t_emp1 - $t_anu1 - $t_liq1, 'f'), "T", 0, "R", 1);
                $pdf->Cell(22, $tam, db_formatar($t_emp1 - $t_anu1 - $t_pag1, 'f'), "T", 1, "R", 1); //quebra linha
                $pdf->SetFont('Arial', '', 7);
            }
            /* */
        }
    } else {
    }
}

if ($hist == "h") {

    if ($processar == "a") {
        $sql = "select case when o58_codigo is null then 0               else o58_codigo end as o58_codigo,
														       case when o15_descr  is null then 'SEM RECURSO'  else o15_descr   end as o15_descr,
														       e60_vlremp, e60_vlranu, e60_vlrliq, e60_vlrpag from (
														select o58_codigo,o15_descr,
												                       sum(e60_vlremp) as e60_vlremp,
												                       sum(e60_vlranu) as e60_vlranu,
												          	       sum(e60_vlrliq) as e60_vlrliq,
												       	               sum(e60_vlrpag) as e60_vlrpag
												   	        from empempenho
															inner join orcdotacao   on orcdotacao.o58_anousu = empempenho.e60_anousu and  orcdotacao.o58_coddot  = empempenho.e60_coddot
															inner join orcelemento  on orcelemento.o56_codele = orcdotacao.o58_codele
															                       and orcelemento.o56_anousu = orcdotacao.o58_anousu
												            left join orctiporec    on orctiporec.o58_codigo = orcdotacao.o58_codigo
														where 	$sWhereSQL
												                      ";
        $sql = $sql . " group by o58_codigo,o15_descr order by o58_codigo) as x";
    } else {
        $sql = "select case when x.o58_codigo is null then 0               else x.o58_codigo end as o58_codigo,
														       case when x.o15_descr  is null then 'SEM RECURSO'   else x.o15_descr   end as o15_descr,
														       sum(e60_vlremp) as e60_vlremp, sum(e60_vlranu) as e60_vlranu, sum(e60_vlrliq) as e60_vlrliq, sum(e60_vlrpag) as e60_vlrpag from
														       ($sqlperiodo) as x
												                       left join orctiporec    on orctiporec.o58_codigo = orcdotacao.o58_codigo
														       group by x.o58_codigo,x.o15_descr order by x.o58_codigo";
    }

    $result = $clempempenho->sql_record($sql);
    if ($clempempenho->numrows > 0) {
        $pdf->addpage("L");
        $imprime_header = true;
        $rows = $clempempenho->numrows;

        $pdf->SetFont('Arial', '', 7);
        for ($x = 0; $x < $rows; $x++) {
            db_fieldsmemory($result, $x, true);
            // testa nova pagina
            if ($pdf->gety() > $pdf->h - 30) {
                $pdf->addpage("L");
                $imprime_header = true;
            }

            if ($imprime_header == true) {
                $pdf->Ln();
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->cell(200, $tam, "TOTALIZAÇÃO DOS RECURSOS", 1, 0, "C", 1);
                $pdf->cell(66, $tam, "SALDO A PAGAR", 1, 1, "C", 1);
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->Cell(20, $tam, strtoupper($RLo58_codigo), 1, 0, "C", 1);
                $pdf->Cell(100, $tam, strtoupper($RLo15_descr), 1, 0, "C", 1);
                $pdf->Cell(20, $tam, strtoupper($RLe60_vlremp), 1, 0, "C", 1);
                $pdf->Cell(20, $tam, strtoupper($RLe60_vlranu), 1, 0, "C", 1);
                $pdf->Cell(20, $tam, strtoupper($RLe60_vlrliq), 1, 0, "C", 1);
                $pdf->Cell(20, $tam, strtoupper($RLe60_vlrpag), 1, 0, "C", 1);
                $pdf->Cell(22, $tam, "LIQUIDADO", 1, 0, "C", 1); //quebra linha
                $pdf->Cell(22, $tam, "NAO LIQUIDADO", 1, 0, "C", 1); //quebra linha
                $pdf->Cell(22, $tam, "GERAL", 1, 1, "C", 1); //quebra linha
                $pdf->Ln();
                $pdf->SetFont('Arial', '', 7);
                $imprime_header = false;
            }
            /* ----------- */
            $pdf->Ln(1);
            $pdf->Cell(20, $tam, $o58_codigo, $iBorda, 0, "R", $p);
            $pdf->Cell(100, $tam, $o15_descr, $iBorda, 0, "L", $p);
            $pdf->Cell(20, $tam, $e60_vlremp, $iBorda, 0, "R", $p);
            $pdf->Cell(20, $tam, $e60_vlranu, $iBorda, 0, "R", $p);
            $pdf->Cell(20, $tam, $e60_vlrliq, $iBorda, 0, "R", $p);
            $pdf->Cell(20, $tam, $e60_vlrpag, $iBorda, 0, "R", $p);
            $total = $e60_vlrliq - $e60_vlrpag;
            $pdf->Cell(22, $tam, db_formatar($e60_vlrliq - $e60_vlrpag, 'f'), $iBorda, 0, "R", $p);
            $pdf->Cell(22, $tam, db_formatar($e60_vlremp - $e60_vlranu - $e60_vlrliq, 'f'), $iBorda, 0, "R", $p);
            $pdf->Cell(22, $tam, db_formatar($e60_vlremp - $e60_vlranu - $e60_vlrpag, 'f'), $iBorda, 1, "R", $p); //quebra linha
            $t_emp1 += $e60_vlremp;
            $t_liq1 += $e60_vlrliq;
            $t_anu1 += $e60_vlranu;
            $t_pag1 += $e60_vlrpag;
            $t_total1 += $total;
            if ($p == 0) {
                $p = 1;
            } else
                $p = 0;
            if ($x == ($rows - 1)) {
                $pdf->Ln();
                $pdf->setX(110);
                /* imprime totais -*/
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->Cell(20, $tam, "TOTAL ", "T", 0, "L", 1);
                $pdf->Cell(20, $tam, db_formatar($t_emp1, 'f'), "T", 0, "R", 1);
                $pdf->Cell(20, $tam, db_formatar($t_anu1, 'f'), "T", 0, "R", 1);
                $pdf->Cell(20, $tam, db_formatar($t_liq1, 'f'), "T", 0, "R", 1);
                $pdf->Cell(20, $tam, db_formatar($t_pag1, 'f'), "T", 0, "R", 1);
                $pdf->Cell(22, $tam, db_formatar($t_liq1 - $t_pag1, 'f'), "T", 0, "R", 1);
                $pdf->Cell(22, $tam, db_formatar($t_emp1 - $t_anu1 - $t_liq1, 'f'), "T", 0, "R", 1);
                $pdf->Cell(22, $tam, db_formatar($t_emp1 - $t_anu1 - $t_pag1, 'f'), "T", 1, "R", 1); //quebra linha
                $pdf->SetFont('Arial', '', 7);
            }
            /* */
        }
    } else {
    }
}

if ($hist == "h") {

    if ($processar == "a") {
        $sql = "select e60_codcom, pc50_descr,
														    sum(e60_vlremp) as e60_vlremp,
														    sum(e60_vlranu) as e60_vlranu,
														    sum(e60_vlrliq) as e60_vlrliq,
														    sum(e60_vlrpag) as e60_vlrpag
													     from empempenho
														    inner join pctipocompra on empempenho.e60_codcom = pctipocompra.pc50_codcom
														    inner join orcdotacao on orcdotacao.o58_anousu = empempenho.e60_anousu
																	 and orcdotacao.o58_coddot = empempenho.e60_coddot
														    inner join orcelemento  on  orcelemento.o56_codele = orcdotacao.o58_codele
														                           and  orcelemento.o56_anousu = orcdotacao.o58_anousu
														    where $sWhereSQL
															  ";
        $sql = $sql . "group by e60_codcom, pc50_descr order by e60_codcom";
    } else {
        $sql = "select 	x.e60_codcom, x.pc50_descr,
   sum(x.e60_vlremp) as e60_vlremp,
   sum(x.e60_vlranu) as e60_vlranu,
   sum(x.e60_vlrliq) as e60_vlrliq,
   sum(x.e60_vlrpag) as e60_vlrpag
   from
  ($sqlperiodo) as x
 	inner join pctipocompra on x.e60_codcom = pctipocompra.pc50_codcom
 	inner join orcdotacao on orcdotacao.o58_anousu = x.e60_anousu
   		   and orcdotacao.o58_coddot = x.e60_coddot
 	inner join orcelemento  on  orcelemento.o56_codele = orcdotacao.o58_codele
                               and  orcelemento.o56_anousu = orcdotacao.o58_anousu
  	group by x.e60_codcom, x.pc50_descr order by x.e60_codcom";
    }
    $result1 = $clempempenho->sql_record($sql);
    if ($clempempenho->numrows > 0) {
        $pdf->addpage("L");
        $imprime_header = true;
        $rows = $clempempenho->numrows;

        $pdf->SetFont('Arial', '', 7);
        for ($x = 0; $x < $rows; $x++) {
            db_fieldsmemory($result1, $x, true);
            // testa nova pagina
            if ($pdf->gety() > $pdf->h - 30) {
                $pdf->addpage("L");
                $imprime_header = true;
            }

            if ($imprime_header == true) {
                $pdf->Ln();
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->cell(200, $tam, "TOTALIZAÇÃO POR TIPO DE COMPRA", 1, 0, "C", 1);
                $pdf->cell(66, $tam, "SALDO A PAGAR", 1, 1, "C", 1);
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->Cell(20, $tam, 'Codigo', 1, 0, "C", 1);
                $pdf->Cell(100, $tam, strtoupper($RLpc50_descr), 1, 0, "C", 1);
                $pdf->Cell(20, $tam, strtoupper($RLe60_vlremp), 1, 0, "C", 1);
                $pdf->Cell(20, $tam, strtoupper($RLe60_vlranu), 1, 0, "C", 1);
                $pdf->Cell(20, $tam, strtoupper($RLe60_vlrliq), 1, 0, "C", 1);
                $pdf->Cell(20, $tam, strtoupper($RLe60_vlrpag), 1, 0, "C", 1);
                $pdf->Cell(22, $tam, "LIQUIDADO", 1, 0, "C", 1);
                $pdf->Cell(22, $tam, "NÃO LIQUIDADO", 1, 0, "C", 1);
                $pdf->Cell(22, $tam, "GERAL", 1, 1, "C", 1); //quebra linha
                $pdf->Ln();
                $pdf->SetFont('Arial', '', 7);
                $imprime_header = false;
            }
            /* ----------- */
            $pdf->Ln(1);
            $pdf->Cell(20, $tam, $e60_codcom, $iBorda, 0, "R", $p);
            $pdf->Cell(100, $tam, $pc50_descr, $iBorda, 0, "L", $p);
            $pdf->Cell(20, $tam, $e60_vlremp, $iBorda, 0, "R", $p);
            $pdf->Cell(20, $tam, $e60_vlranu, $iBorda, 0, "R", $p);
            $pdf->Cell(20, $tam, $e60_vlrliq, $iBorda, 0, "R", $p);
            $pdf->Cell(20, $tam, $e60_vlrpag, $iBorda, 0, "R", $p);
            $total = $e60_vlrliq - $e60_vlrpag;
            $pdf->Cell(22, $tam, db_formatar($e60_vlrliq - $e60_vlrpag, 'f'), $iBorda, 0, "R", $p);
            $pdf->Cell(22, $tam, db_formatar($e60_vlremp - $e60_vlranu - $e60_vlrliq, 'f'), $iBorda, 0, "R", $p);
            $pdf->Cell(22, $tam, db_formatar($e60_vlremp - $e60_vlranu - $e60_vlrpag, 'f'), $iBorda, 1, "R", $p); //quebra linha
            $t_emp5 += $e60_vlremp;
            $t_liq5 += $e60_vlrliq;
            $t_anu5 += $e60_vlranu;
            $t_pag5 += $e60_vlrpag;
            $t_total5 += $total;
            if ($p == 0) {
                $p = 1;
            } else
                $p = 0;
            if ($x == ($rows - 1)) {
                $pdf->Ln();
                $pdf->setX(110);
                /* imprime totais -*/
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->Cell(20, $tam, "TOTAL ", "T", 0, "L", 1);
                $pdf->Cell(20, $tam, db_formatar($t_emp5, 'f'), "T", 0, "R", 1);
                $pdf->Cell(20, $tam, db_formatar($t_anu5, 'f'), "T", 0, "R", 1);
                $pdf->Cell(20, $tam, db_formatar($t_liq5, 'f'), "T", 0, "R", 1);
                $pdf->Cell(20, $tam, db_formatar($t_pag5, 'f'), "T", 0, "R", 1);
                $pdf->Cell(22, $tam, db_formatar($t_liq1 - $t_pag1, 'f'), "T", 0, "R", 1);
                $pdf->Cell(22, $tam, db_formatar($t_emp1 - $t_anu1 - $t_liq1, 'f'), "T", 0, "R", 1);
                $pdf->Cell(22, $tam, db_formatar($t_emp1 - $t_anu1 - $t_pag1, 'f'), "T", 1, "R", 1); // quebra linha
                $pdf->SetFont('Arial', '', 7);
            }
            /* */
        }
    }
}

if ($hist == "h") {

    if ($processar == "a") {
        $sql = "select o58_orgao,
														    o40_descr,
														    sum(e60_vlremp) as e60_vlremp,
														    sum(e60_vlranu) as e60_vlranu,
														    sum(e60_vlrliq) as e60_vlrliq,
														    sum(e60_vlrpag) as e60_vlrpag
													     from empempenho
														    inner join pctipocompra on empempenho.e60_codcom = pctipocompra.pc50_codcom
														    inner join orcdotacao 	on orcdotacao.o58_anousu = empempenho.e60_anousu and
																	       orcdotacao.o58_coddot = empempenho.e60_coddot
														    inner join orcorgao 	on o40_orgao = o58_orgao and o40_anousu = o58_anousu
														    inner join orcunidade 	on o41_orgao = o40_orgao and o41_unidade = o58_unidade and o41_anousu = o40_anousu
														    where $sWhereSQL
															  ";
        $sql = $sql . "group by o58_orgao, o40_descr";
    } else {
        $sql = "select x.o58_orgao,
														    x.o40_descr,
														    sum(e60_vlremp) as e60_vlremp,
														    sum(e60_vlranu) as e60_vlranu,
														    sum(e60_vlrliq) as e60_vlrliq,
														    sum(e60_vlrpag) as e60_vlrpag
														    from
														    ($sqlperiodo) as x
														    inner join orcdotacao 	on 	orcdotacao.o58_anousu = x.e60_anousu and
																	       		orcdotacao.o58_coddot = x.e60_coddot
														    inner join orcorgao 	on 	orcorgao.o40_orgao = orcdotacao.o58_orgao and orcorgao.o40_anousu = orcdotacao.o58_anousu
														    inner join orcunidade 	on 	o41_orgao = orcorgao.o40_orgao and o41_unidade = orcdotacao.o58_unidade and o41_anousu = orcorgao.o40_anousu
														    group by x.o58_orgao, x.o40_descr
														    ";
    }
    //     echo $sql;exit;
    $result1 = $clempempenho->sql_record($sql);
    if ($clempempenho->numrows > 0) {
        $pdf->addpage("L");
        $imprime_header = true;
        $rows = $clempempenho->numrows;

        $pdf->SetFont('Arial', '', 7);
        for ($x = 0; $x < $rows; $x++) {
            db_fieldsmemory($result1, $x, true);
            // testa nova pagina
            if ($pdf->gety() > $pdf->h - 30) {
                $pdf->addpage("L");
                $imprime_header = true;
            }

            if ($imprime_header == true) {
                $pdf->Ln();
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->cell(200, $tam, "TOTALIZAÇÃO POR ORGAO", 1, 0, "C", 1);
                $pdf->cell(66, $tam, "SALDO A PAGAR", 1, 1, "C", 1);
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->Cell(20, $tam, 'ORGAO', 1, 0, "C", 1);
                $pdf->Cell(100, $tam, "DESCRICAO", 1, 0, "C", 1);
                $pdf->Cell(20, $tam, strtoupper($RLe60_vlremp), 1, 0, "C", 1);
                $pdf->Cell(20, $tam, strtoupper($RLe60_vlranu), 1, 0, "C", 1);
                $pdf->Cell(20, $tam, strtoupper($RLe60_vlrliq), 1, 0, "C", 1);
                $pdf->Cell(20, $tam, strtoupper($RLe60_vlrpag), 1, 0, "C", 1);
                $pdf->Cell(22, $tam, "LIQUIDADO", 1, 0, "C", 1);
                $pdf->Cell(22, $tam, "NÃO LIQUIDADO", 1, 0, "C", 1);
                $pdf->Cell(22, $tam, "GERAL", 1, 1, "C", 1); //quebra linha
                $pdf->Ln();
                $pdf->SetFont('Arial', '', 7);
                $imprime_header = false;
            }
            /* ----------- */
            $pdf->Ln(1);
            $pdf->Cell(20, $tam, $o58_orgao, $iBorda, 0, "R", $p);
            $pdf->Cell(100, $tam, $o40_descr, $iBorda, 0, "L", $p);
            $pdf->Cell(20, $tam, $e60_vlremp, $iBorda, 0, "R", $p);
            $pdf->Cell(20, $tam, $e60_vlranu, $iBorda, 0, "R", $p);
            $pdf->Cell(20, $tam, $e60_vlrliq, $iBorda, 0, "R", $p);
            $pdf->Cell(20, $tam, $e60_vlrpag, $iBorda, 0, "R", $p);
            $total = $e60_vlrliq - $e60_vlrpag;
            $pdf->Cell(22, $tam, db_formatar($e60_vlrliq - $e60_vlrpag, 'f'), $iBorda, 0, "R", $p);
            $pdf->Cell(22, $tam, db_formatar($e60_vlremp - $e60_vlranu - $e60_vlrliq, 'f'), $iBorda, 0, "R", $p);
            $pdf->Cell(22, $tam, db_formatar($e60_vlremp - $e60_vlranu - $e60_vlrpag, 'f'), $iBorda, 1, "R", $p); // quebra linha
            $t_emp6 += $e60_vlremp;
            $t_liq6 += $e60_vlrliq;
            $t_anu6 += $e60_vlranu;
            $t_pag6 += $e60_vlrpag;
            $t_total6 += $total;
            if ($p == 0) {
                $p = 1;
            } else
                $p = 0;
            if ($x == ($rows - 1)) {
                $pdf->Ln();
                $pdf->setX(110);
                /* imprime totais -*/
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->Cell(20, $tam, "TOTAL ", "T", 0, "L", 1);
                $pdf->Cell(20, $tam, db_formatar($t_emp6, 'f'), "T", 0, "R", 1);
                $pdf->Cell(20, $tam, db_formatar($t_anu6, 'f'), "T", 0, "R", 1);
                $pdf->Cell(20, $tam, db_formatar($t_liq6, 'f'), "T", 0, "R", 1);
                $pdf->Cell(20, $tam, db_formatar($t_pag6, 'f'), "T", 0, "R", 1);
                $pdf->Cell(22, $tam, db_formatar($t_liq1 - $t_pag1, 'f'), "T", 0, "R", 1);
                $pdf->Cell(22, $tam, db_formatar($t_emp1 - $t_anu1 - $t_liq1, 'f'), "T", 0, "R", 1);
                $pdf->Cell(22, $tam, db_formatar($t_emp1 - $t_anu1 - $t_pag1, 'f'), "T", 1, "R", 1); // quebra linha
                $pdf->SetFont('Arial', '', 7);
            }
        }
    }

    $t_emp6 = 0;
    $t_liq6 = 0;
    $t_anu6 = 0;
    $t_pag6 = 0;
    $t_total6 = 0;

    if ($processar == "a") {
        $sql = "select o58_orgao,
														    o58_unidade,
														    o40_descr,
														    o41_descr,
														    sum(e60_vlremp) as e60_vlremp,
														    sum(e60_vlranu) as e60_vlranu,
														    sum(e60_vlrliq) as e60_vlrliq,
														    sum(e60_vlrpag) as e60_vlrpag
													     from empempenho
														    inner join pctipocompra on empempenho.e60_codcom = pctipocompra.pc50_codcom
														    inner join orcdotacao 	on orcdotacao.o58_anousu = empempenho.e60_anousu
																	 and orcdotacao.o58_coddot = empempenho.e60_coddot
														    inner join orcorgao 	on o40_orgao = o58_orgao and o40_anousu = o58_anousu
														    inner join orcunidade 	on o41_orgao = o40_orgao and o41_unidade = o58_unidade and o41_anousu = o40_anousu
														    inner join orcelemento  on  orcelemento.o56_codele = orcdotacao.o58_codele
														                           and  orcelemento.o56_anousu = orcdotacao.o58_anousu
														    where $sWhereSQL
															  ";
        $sql = $sql . "group by o58_orgao, o58_unidade, o40_descr, o41_descr";
    } else {
        $sql = "select x.o58_orgao,
														    x.o58_unidade,
														    x.o40_descr,
														    x.o41_descr,
														    sum(e60_vlremp) as e60_vlremp,
														    sum(e60_vlranu) as e60_vlranu,
														    sum(e60_vlrliq) as e60_vlrliq,
														    sum(e60_vlrpag) as e60_vlrpag
													     from ($sqlperiodo) as x
														    inner join orcdotacao 	on orcdotacao.o58_anousu = x.e60_anousu
																	 	and orcdotacao.o58_coddot = x.e60_coddot
														    inner join orcorgao 	on orcorgao.o40_orgao = orcdotacao.o58_orgao and o40_anousu = orcdotacao.o58_anousu
														    inner join orcunidade 	on o41_orgao = orcorgao.o40_orgao and o41_unidade = orcdotacao.o58_unidade and o41_anousu = orcorgao.o40_anousu
														    group by x.o58_orgao, x.o58_unidade, x.o40_descr, x.o41_descr";
    }
    //	 echo $sql;exit;
    $result1 = $clempempenho->sql_record($sql);
    if ($clempempenho->numrows > 0 and 1 == 2) {
        $pdf->addpage("L");
        $imprime_header = true;
        $rows = $clempempenho->numrows;

        $pdf->SetFont('Arial', '', 7);
        for ($x = 0; $x < $rows; $x++) {
            db_fieldsmemory($result1, $x, true);
            // testa nova pagina
            if ($pdf->gety() > $pdf->h - 30) {
                $pdf->addpage("L");
                $imprime_header = true;
            }

            if ($imprime_header == true) {
                $pdf->Ln();
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->cell(275, $tam, "TOTALIZAÇÃO POR ORGAO/UNIDADE", 1, 1, "C", 1);
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->Cell(10, $tam, 'ORGAO', 1, 0, "C", 1);
                $pdf->Cell(60, $tam, "DESCRICAO", 1, 0, "C", 1);
                $pdf->Cell(15, $tam, "UNIDADE", 1, 0, "C", 1);
                $pdf->Cell(80, $tam, "DESCRICAO", 1, 0, "C", 1);
                $pdf->Cell(20, $tam, strtoupper($RLe60_vlremp), 1, 0, "C", 1);
                $pdf->Cell(20, $tam, strtoupper($RLe60_vlranu), 1, 0, "C", 1);
                $pdf->Cell(20, $tam, strtoupper($RLe60_vlrliq), 1, 0, "C", 1);
                $pdf->Cell(20, $tam, strtoupper($RLe60_vlrpag), 1, 0, "C", 1);
                $pdf->Cell(30, $tam, "TOTAL A PAGAR", 1, 1, "C", 1); //quebra linha
                $pdf->Ln();
                $pdf->SetFont('Arial', '', 7);
                $imprime_header = false;
            }
            /* ----------- */
            $pdf->Ln(1);
            $pdf->Cell(10, $tam, $o58_orgao, $iBorda, 0, "R", $p);
            $pdf->Cell(60, $tam, substr($o40_descr, 0, 50), $iBorda, 0, "L", $p);
            $pdf->Cell(15, $tam, $o58_unidade, $iBorda, 0, "L", $p);
            $pdf->Cell(80, $tam, $o41_descr, $iBorda, 0, "L", $p);
            $pdf->Cell(20, $tam, $e60_vlremp, $iBorda, 0, "R", $p);
            $pdf->Cell(20, $tam, $e60_vlranu, $iBorda, 0, "R", $p);
            $pdf->Cell(20, $tam, $e60_vlrliq, $iBorda, 0, "R", $p);
            $pdf->Cell(20, $tam, $e60_vlrpag, $iBorda, 0, "R", $p);
            $total = $e60_vlrliq - $e60_vlrpag;
            $pdf->Cell(30, $tam, db_formatar($total, 'f'), $iBorda, 1, "R", $p); //quebra linha
            $t_emp6 += $e60_vlremp;
            $t_liq6 += $e60_vlrliq;
            $t_anu6 += $e60_vlranu;
            $t_pag6 += $e60_vlrpag;
            $t_total6 += $total;
            if ($p == 0) {
                $p = 1;
            } else
                $p = 0;
            if ($x == ($rows - 1)) {
                $pdf->Ln();
                //  $pdf->setX(110);
                /* imprime totais -*/
                $pdf->SetFont('Arial', 'B', 7);
                $pdf->Cell(140, $tam, "", "T", 0, "L", 0);
                $pdf->Cell(25, $tam, "TOTAL ", "T", 0, "L", 1);
                $pdf->Cell(20, $tam, db_formatar($t_emp6, 'f'), "T", 0, "R", 1);
                $pdf->Cell(20, $tam, db_formatar($t_anu6, 'f'), "T", 0, "R", 1);
                $pdf->Cell(20, $tam, db_formatar($t_liq6, 'f'), "T", 0, "R", 1);
                $pdf->Cell(20, $tam, db_formatar($t_pag6, 'f'), "T", 0, "R", 1);
                $pdf->Cell(30, $tam, db_formatar($t_total6, 'f'), "T", 1, "R", 1); //quebra linha
                $pdf->SetFont('Arial', '', 7);
            }
        }
    }
}
// echo $sqlrelemp;exit;

$pdf->output();
