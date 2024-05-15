<?php
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

require "libs/db_stdlib.php";
require "libs/db_conecta.php";
include "libs/db_sessoes.php";
include "libs/db_usuariosonline.php";
include "dbforms/db_funcoes.php";
include "classes/db_empempenho_classe.php";
include "classes/db_pcparam_classe.php";

db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);

$clempempenho = new cl_empempenho();
$clempempenho->rotulo->label("e60_numemp");
$clempempenho->rotulo->label("e60_codemp");

$rotulo = new rotulocampo();
$rotulo->label("z01_nome");
$rotulo->label("z01_cgccpf");

//ini_set("display_errors", "on");

$todos = !empty($todos) && (int)$todos === 1;

?>


<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script>
        function js_mascara(event) {
            let evt = event;

            if (!evt) {
                if (window.event) {
                    evt = window.event;
                } else {
                    evt = ""
                };
            };

            if ((evt.charCode > 46 && evt.charCode < 58) || evt.charCode == 0) {
                return true;
            } else {
                return false;
            }
        }
    </script>
</head>

<body bgcolor="#CCCCCC" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="a=1">
    <form name="form2" class="container" method="post" action="">
        <fieldset>
            <legend>Pesquisa de Empenhos</legend>
            <table border="0" class="form-container">
                <tr>
                    <td>
                        <label for="chave_e60_codemp">
                            <?= $Le60_codemp; ?>
                        </label>
                    </td>
                    <td>
                        <?php db_input("e60_codemp", 14, $Ie60_codemp, true, "text", 4, "onKeyPress='return js_mascara(event);'", "chave_e60_codemp"); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="chave_e60_numemp">
                            <?= $Le60_numemp; ?>
                        </label>
                    </td>
                    <td>
                        <?php db_input("e60_numemp", 14, $Ie60_numemp, true, "text", 4, "", "chave_e60_numemp"); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="chave_z01_nome">
                            <?= $Lz01_nome; ?>
                        </label>
                    </td>
                    <td>
                        <?php db_input("z01_nome", 45, "", true, "text", 4, "", "chave_z01_nome"); ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="">
                            <?= $Lz01_cgccpf; ?>
                        </label>
                    </td>
                    <td>
                        <?php db_input("z01_cgccpf", 14, "", true, "text", 4, "", "chave_z01_cgccpf"); ?>
                    </td>
                </tr>
            </table>
        </fieldset>
        <table style="margin: 0 auto;">
            <tr>
                <td align="center">
                    <input type="hidden" value="1" name="pesquisa_geral">
                    <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
                    <input name="limpar" type="reset" id="limpar" value="Limpar">
                    <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_empempenho.hide();">
                </td>
            </tr>
        </table>
    </form>
    <table class="container">
        <tr>
            <td align="center" valign="top">
                <?php
                $campos = "e60_numemp, e60_codemp, z01_nome,si172_nrocontrato,
                si172_datafinalvigencia,
                si174_novadatatermino
                ";

                $filtroempelemento = "";
                if (!isset($pesquisa_chave)) {
                    $campos = "empempenho.e60_numemp,
                    e60_emiss,
                    empempenho.e60_codemp,
                    empempenho.e60_anousu,
                    empempaut.e61_autori,
                    empempenho.e60_numcgm,
                    case when ac16_numeroacordo is null then si172_nrocontrato::varchar else (ac16_numeroacordo || '/' || ac16_anousu)::varchar end as si172_nrocontrato,
                    CASE WHEN ac16_vigenciaindeterminada='t' then null else (select ac18_datafim from acordovigencia where ac18_acordoposicao in (select min(ac26_sequencial) from acordoposicao where ac26_acordo = acordo.ac16_sequencial) and ac18_ativo  = true) end as si172_datafinalvigencia,
                    case when ac16_datafim is null then si174_novadatatermino when ac16_vigenciaindeterminada='t' then null else ac16_datafim end as si174_novadatatermino,
                    empempenho.e60_emiss as DB_e60_emiss,
                    cgm.z01_nome,
                    cgm.z01_cgccpf,
                    empempenho.e60_coddot,
                    e60_vlremp,
                    e60_vlremp-e60_vlrutilizado as saldodisponivel,
                    e60_vlrutilizado,
                    e60_vlrliq,
                    e60_vlrpag,
                    e60_vlranu,
                    RPAD(SUBSTR(convconvenios.c206_objetoconvenio,0,47),50,'...') AS c206_objetoconvenio
                    ";
                    $campos = " distinct " . $campos;
                    $dbwhere = " e60_instit = " . db_getsession("DB_instit");

                    if ($inclusaoordemcompra == true) {

                        $dbwhere .= " and e60_vlremp > (e60_vlranu + e60_vlrliq)";
                    }

                    if (isset($pegaAnousu)) {
                        $dbwhere .= " and e60_anousu = " . db_getsession("DB_anousu");
                    }

                    if (isset($anul) && $anul == false) {
                        $dbwhere .= " and e60_vlranu < e60_vlremp ";
                    }
                    /**
                     * Filtro $filtroabast
                     * Busca pelo elemento do empenho para abastecimento
                     * @see ocorrência contass 1011
                     *
                     */

                    if ($filtroabast == 1) {

                        $anoant = db_getsession("DB_anousu") - 1;
                        $ve70_abast = implode("-", array_reverse(explode("/", $ve70_abast)));
                        $dbwhere = " (e60_instit = " . db_getsession("DB_instit");
                        $dbwhere .= " and elementoempenho.o56_elemento in ('3339030010000','3390330100000','3390339900000','3339033990000','3339030030000','3339092000000','3339033000000','3339093010000','3339093020000','3339093030000','3449030000000','3339039990000') ";
                        $dbwhere .= " and empempenho.e60_emiss <= '$ve70_abast' and (empempenho.e60_anousu = " . db_getsession("DB_anousu");
                        $dbwhere .= "	or (empempenho.e60_anousu = " . $anoant . "";
                        $dbwhere .= "	and e91_anousu = " . db_getsession('DB_anousu') . ")))";
                        $filtroempelemento = 1;
                    }

                    /**
                     * Filtro $filtromanut
                     * Busca pelo elemento do empenho para manutencao
                     * @see ocorrências contass 2079, 20105
                     *
                     */

                    if ($importacaoveiculo == 1) {

                        $anoant = db_getsession("DB_anousu") - 1;

                        $dbwhere .= " and (elementoempenho.o56_elemento in ('3339030010000','3390330100000','3390339900000','3339033990000','3339030030000','3339092000000','3339033000000','3339093010000','3339093020000','3339093030000','3449030000000','3339039990000') ";
                        $dbwhere .= " or elementoempenho.o56_elemento like '335041%')";
                        $dbwhere .= " AND empempenho.e60_emiss <= '$dataAbastecimento' ";

                        $filtroempelemento = 1;
                    }

                    if ($filtromanut == 1) {

                        $anoant = db_getsession("DB_anousu") - 1;

                        $dbwhere .= "and ((e91_anousu >= " . db_getsession("DB_anousu") . " and e60_anousu >= $anoant  ) or (e60_anousu >= " . db_getsession("DB_anousu") . "))";
                        $dbwhere .= " and (elementoempenho.o56_elemento like '3339039%' ";
                        $dbwhere .= " or elementoempenho.o56_elemento like '3339036%' ";
                        $dbwhere .= " or elementoempenho.o56_elemento like '335041%' ";
                        $dbwhere .= " or elementoempenho.o56_elemento in ('3339030010000','3339030250000','3339030370000','3339030990000','3339030020000','3339030030000','3339092000000','3339339990000'))";
                        $dbwhere .= " and empempenho.e60_emiss <= '$ve62_dtmanut'";
                        $dbwhere .= " and date_part('year', empempenho.e60_emiss) <= date_part('year', date'" . $ve62_dtmanut . "')";
                        $filtroempelemento = 1;
                    }

                    /**
                     * Filtro $emperro
                     * Busca pelos empenhos anulados por erro na emissão, validando período contábil
                     * @see ocorrência contass 3414
                     *
                     */
                    if (isset($emperro) && $emperro == true) {
                        $dbwhere .= " AND e60_vlremp = e60_vlranu
                        AND e60_vlrliq = 0
                        AND e60_numemp NOT IN
                        (SELECT m52_numemp FROM matordemitem
                        UNION
                        SELECT e69_numemp FROM empnota)";
                    }

                    if (isset($chave_e60_numemp) && !empty($chave_e60_numemp)) {
                        $sql = $clempempenho->sql_query($chave_e60_numemp, $campos, "empempenho.e60_emiss desc", "$dbwhere and e60_numemp=$chave_e60_numemp ", $filtroempelemento);
                    } elseif (isset($chave_e60_codemp) && !empty($chave_e60_codemp)) {
                        $arr = split("/", $chave_e60_codemp);
                        if (count($arr) == 2  && isset($arr[1]) && $arr[1] != '') {
                            $dbwhere_ano = " and e60_anousu = " . $arr[1];
                        } elseif (count($arr) == 1) {
                            $dbwhere_ano = " and e60_anousu = " . db_getsession("DB_anousu");
                        } else {
                            $dbwhere_ano = "";
                        }

                        $sql = $clempempenho->sql_query("", $campos, "empempenho.e60_emiss desc", "$dbwhere and e60_codemp='" . $arr[0] . "'$dbwhere_ano", $filtroempelemento);

                    } elseif (isset($chave_z01_nome) && !empty($chave_z01_nome)) {

                        $sql = $clempempenho->sql_query("", $campos, "empempenho.e60_emiss desc", "$dbwhere and z01_nome like '$chave_z01_nome%'", $filtroempelemento);
                    } elseif (isset($chave_z01_cgccpf) && !empty($chave_z01_cgccpf)) {

                        $sql = $clempempenho->sql_query("", $campos, "empempenho.e60_emiss desc", "$dbwhere and z01_cgccpf like '$chave_z01_cgccpf%'", $filtroempelemento);
                    } elseif (count($_POST) > 0 || $todos) {

                        $sql = $clempempenho->sql_query("", $campos, "empempenho.e60_emiss desc", "{$dbwhere}", $filtroempelemento);
                    }

                    $repassa = array(
                        "chave_z01_nome" => @$chave_z01_nome
                    );
                    if (isset($relordemcompra) && $relordemcompra == true) {
                        $campos .= ",z01_numcgm";
                        $whereRelCompra = ' e60_instit=' . db_getsession('DB_instit');
                        if (isset($periodoini) && $periodoini != "") {

                            $data = explode("/", $periodoini);
                            $periodoini = $data[2] . '-' . $data[1] . '-' . $data[0];

                            $whereRelCompra .= " AND e60_emiss >= '$periodoini'";
                        }
                        if (isset($periodofim) && $periodofim != "") {
                            $data = explode("/", $periodofim);
                            $periodofim = $data[2] . '-' . $data[1] . '-' . $data[0];

                            $whereRelCompra .= " AND e60_emiss <= '$periodofim'";
                        }
                        if (isset($fornecedor) && $fornecedor != "") {
                            $whereRelCompra .= " AND z01_numcgm = $fornecedor";
                        }
                        if (isset($chave_e60_codemp) && $chave_e60_codemp != "") {
                            $whereRelCompra .= " AND e60_codemp = '$chave_e60_codemp'";
                        }
                        if (isset($chave_z01_cgccpf) && $chave_z01_cgccpf != "") {
                            $whereRelCompra .= " AND z01_cgccpf = '$chave_z01_cgccpf'";
                        }
                        if (isset($chave_z01_nome) && $chave_z01_nome != "") {
                            $whereRelCompra .= " AND z01_nome LIKE '%$chave_z01_nome%'";
                        }


                        $sql = $clempempenho->sql_query(null, $campos, null, $whereRelCompra);
                    }

                    if ($inclusaoordemcompra == true) {
                        $clpcparam = new cl_pcparam();
                        //Parametro adicionado a pedido de ivan OC18994
                        $rspcparam = $clpcparam->sql_record($clpcparam->sql_query(db_getsession('DB_instit'), "pc30_liboccontrato"));
                        db_fieldsmemory($rspcparam, 0);

                        $campos = "";

                        $campos = "empempenho.e60_numemp,
                        empempenho.e60_codemp,
                        empempenho.e60_anousu,
                        empempaut.e61_autori,
                        empempenho.e60_numcgm,
                        case when ac16_numeroacordo is null then si172_nrocontrato::varchar else (ac16_numeroacordo || '/' || ac16_anousu)::varchar end as si172_nrocontrato,
                        case when (select ac18_datafim from acordovigencia where ac18_acordoposicao in (select max(ac26_sequencial) from acordoposicao where ac26_acordo = acordo.ac16_sequencial) and ac18_ativo  = true) is null then si172_datafinalvigencia else (select ac18_datafim from acordovigencia where ac18_acordoposicao in (select max(ac26_sequencial) from acordoposicao where ac26_acordo = acordo.ac16_sequencial) and ac18_ativo  = true) end as si172_datafinalvigencia,
                        case when ac16_datafim is null then si174_novadatatermino else ac16_datafim end as si174_novadatatermino,
                        empempenho.e60_emiss as DB_e60_emiss,
                        cgm.z01_nome,
                        cgm.z01_cgccpf,
                        empempenho.e60_coddot,
                        e60_vlremp,
                        e60_vlrliq,
                        e60_vlrpag,
                        e60_vlranu,
                        RPAD(SUBSTR(convconvenios.c206_objetoconvenio,0,47),50,'...') AS c206_objetoconvenio,
                        ";
                        if ($pc30_liboccontrato == 't') {
                            $campos .= "1 as pc30_liboccontrato";
                        } else {
                            $campos .= "2 as pc30_liboccontrato";
                        }
                        $campos = " distinct " . $campos;
                        $dbwhere = "";
                        $dbwhere = " WHERE (e60_vlremp - e60_vlranu) >
                        (SELECT case when sum(m52_valor)  is null then 0 else sum(m52_valor) end as totalemordemdecompra
                         FROM matordemitem
                         WHERE m52_numemp = e60_numemp) -
                        (SELECT case when sum(m36_vrlanu) is null then 0 else sum(m36_vrlanu) end AS totalemordemdecompraanulado
                         FROM matordemitem
                         INNER JOIN matordemitemanu ON m36_matordemitem = m52_codlanc
                         WHERE m52_numemp = e60_numemp)
                        and e60_vlremp > e60_vlranu ";

                        if (isset($chave_e60_codemp) && $chave_e60_codemp != "") {
                            $dbwhere .= " AND e60_codemp = '$chave_e60_codemp'";
                        }
                        if (isset($chave_z01_cgccpf) && $chave_z01_cgccpf != "") {
                            $dbwhere .= " AND z01_cgccpf = '$chave_z01_cgccpf'";
                        }
                        if (isset($chave_z01_nome) && $chave_z01_nome != "") {
                            $dbwhere .= " AND z01_nome LIKE '%$chave_z01_nome%'";
                        }
                        if (isset($chave_e60_numemp) && !empty($chave_e60_numemp)) {
                            $dbwhere .= " AND e60_numemp=$chave_e60_numemp ";
                        }


                        $dbwhere .= " and e60_instit = " . db_getsession("DB_instit") . " order by e60_numemp desc";

                        $sql = $clempempenho->sql_query_inclusaoempenho(null, $campos, null, $dbwhere);
                    }

                    $result = $clempempenho->sql_record($sql);

                    if ($clempempenho->numrows == 0) {
                        $lin = "parent.js_mostraempempenho";
                        //echo "<script> alert('Não encontrado');</script>";
                        echo "<script>" . $lin . "('Número(" . $chave_e60_codemp . ") não Encontrado', true);</script>";
                    } else {
                        db_lovrot($sql, 15, "()", "", $funcao_js, "", "NoMe", $repassa, true);
                        if ($importacaoveiculo == 1 || $filtroabast == 1) {
                            echo "<script> document.getElementsByClassName('DBLovrotInputCabecalho').item(13).value = 'Valor Disponível' </script>;";
                            echo "<script> document.getElementsByClassName('DBLovrotInputCabecalho').item(14).value = 'Valor Utilizado' </script>;";
                        }
                    }
                } else {

                    if ($pesquisa_chave != null && $pesquisa_chave != "") {

                        if (isset($lPesquisaPorCodigoEmpenho)) {

                            if (!empty($iAnoEmpenho)) {
                                $sWherePesquisaPorCodigoEmpenho = " e60_anousu = " . $iAnoEmpenho;
                            } else {
                                $sWherePesquisaPorCodigoEmpenho = " e60_anousu = " . db_getsession("DB_anousu");
                            }

                            $aEmpenho = explode("/", $pesquisa_chave);
                            $e60_codemp = $aEmpenho[0];
                            $e60_anousu = $aEmpenho[1];
                            $e60_anousu = $e60_anousu == null ? db_getsession("DB_anousu") : $e60_anousu;

                            $dbwhere = "e60_codemp = '$e60_codemp' and e60_anousu = $e60_anousu";

                            /**
                             * Filtro $filtroabast
                             * Busca pelo elemento do empenho para abastecimento
                             * @see ocorrência contass 1011
                             *
                             */
                            if ($filtroabast == 1) {

                                $anoant = db_getsession("DB_anousu") - 1;
                                $ve70_abast = implode("-", array_reverse(explode("/", $ve70_abast)));
                                $aCodEmp  = explode("/", $pesquisa_chave);
                                $dbwhere = " e60_codemp = '" . $aCodEmp[0] . "'";
                                $dbwhere .= " and e60_anousu = " . $aCodEmp[1];
                                $dbwhere .= " and (elementoempenho.o56_elemento in ('3339030010000','3390330100000','3390339900000','3339033990000','3339030030000','3339092000000','3339033000000','3339093010000','3339093020000','3339093030000','3449030000000','3339039990000') ";
                                $dbwhere .= " or elementoempenho.o56_elemento like '335041%')";
                                $dbwhere .= " and empempenho.e60_emiss <= '$ve70_abast' ";
                                $filtroempelemento = 1;
                            }

                            if ($importacaoveiculo == 1) {

                                $aCodEmp  = explode("/", $pesquisa_chave);

                                $anoant = db_getsession("DB_anousu") - 1;

                                $dbwhere .= "(elementoempenho.o56_elemento in ('3339030010000','3390330100000','3390339900000','3339033990000','3339030030000','3339092000000','3339033000000','3339093010000','3339093020000','3339093030000','3449030000000','3339039990000')";
                                $dbwhere .= " or elementoempenho.o56_elemento like '335041%')";
                                $dbwhere .= " AND empempenho.e60_emiss <= '$dataAbastecimento' ";
                                $dbwhere .= " and e60_instit = " . db_getsession('DB_instit');
                                $dbwhere .= " and e60_codemp = '" . $aCodEmp[0] . "'";
                                $dbwhere .= " and e60_anousu = " . $aCodEmp[1];
                                $filtroempelemento = 1;
                            }

                            /**
                             * Filtro $filtromanut
                             * Busca pelo elemento do empenho para manutencao
                             * @see ocorrência contass 2079
                             *
                             */
                            if ($filtromanut == 1) {
                                $dbwhere .= " and elementoempenho.o56_elemento in ('3339039990400','3339039990000','3339039170000','3339039160000','3339039150000','3339039050000','3339036990000','3339036170000','3339036160000','3339036060000','3339030010000','3339030250000','3339030370000','3339030990000','3339030020000','3339030030000','3339092000000') ";
                                $dbwhere .= " and empempenho.e60_emiss <= '$ve62_dtmanut'";
                                $dbwhere .= " and date_part('year', empempenho.e60_emiss) <= date_part('year', date'" . $ve62_dtmanut . "')";
                                $filtroempelemento = 1;
                            }

                            $aCodEmp  = explode("/", $pesquisa_chave);
                            $sWherePesquisaPorCodigoEmpenho .= " and e60_codemp = '" . $aCodEmp[0] . "'";

                            $sSql = $clempempenho->sql_query(null, $campos, null, $sWherePesquisaPorCodigoEmpenho, $filtroempelemento);
                        }

                        if (isset($protocolo)) {
                            $campos = " z01_nome,e60_numemp,e60_emiss,e60_vlremp,e60_codemp ";
                            if ($protocolo == 2) {
                                $where = " e60_codemp = '{$pesquisa_chave}' and e60_anousu = " . db_getsession("DB_anousu") . " and e60_instit = " . db_getsession("DB_instit");
                                $sSql = $clempempenho->sql_query(null, "*", null, $where, $filtroempelemento);
                            } else {
                                $sSql = $clempempenho->sql_query($pesquisa_chave, "*", null, $where, $filtroempelemento);
                            }
                        } else {
                            $sSql = $clempempenho->sql_query($pesquisa_chave, "e60_vlremp-e60_vlrutilizado as saldodisponivel,*", null, $dbwhere, $filtroempelemento);
                        }

                        if ($inclusaoordemcompra == "true") {
                            if ($codemp == true) {
                                $dbwhere = " WHERE empempenho.e60_codemp = '$pesquisa_chave' ";
                            }

                            if ($numemp == true) {
                                $dbwhere = " WHERE empempenho.e60_numemp = $pesquisa_chave ";
                            }

                            //Parametro adicionado a pedido de ivan OC18994
                            $clpcparam = new cl_pcparam();
                            $rspcparam = $clpcparam->sql_record($clpcparam->sql_query(db_getsession('DB_instit'), "pc30_liboccontrato"));
                            db_fieldsmemory($rspcparam, 0);

                            $campos = "";

                            $campos = "empempenho.e60_numemp,
              empempenho.e60_codemp,
              empempenho.e60_anousu,
              empempaut.e61_autori,
              empempenho.e60_numcgm,
              case when ac16_numeroacordo is null then si172_nrocontrato::varchar else (ac16_numeroacordo || '/' || ac16_anousu)::varchar end as si172_nrocontrato,
              case when (select ac18_datafim from acordovigencia where ac18_acordoposicao in (select max(ac26_sequencial) from acordoposicao where ac26_acordo = acordo.ac16_sequencial) and ac18_ativo  = true) is null then si172_datafinalvigencia else (select ac18_datafim from acordovigencia where ac18_acordoposicao in (select max(ac26_sequencial) from acordoposicao where ac26_acordo = acordo.ac16_sequencial) and ac18_ativo  = true) end as si172_datafinalvigencia,
              case when ac16_datafim is null then si174_novadatatermino else ac16_datafim end as si174_novadatatermino,
              empempenho.e60_emiss as DB_e60_emiss,
              cgm.z01_nome,
              cgm.z01_cgccpf,
              empempenho.e60_coddot,
              e60_vlremp,
              e60_vlrliq,
              e60_vlrpag,
              e60_vlranu,
              RPAD(SUBSTR(convconvenios.c206_objetoconvenio,0,47),50,'...') AS c206_objetoconvenio,
              ";
                            if ($pc30_liboccontrato == 't') {
                                $campos .= "1 as pc30_liboccontrato";
                            } else {
                                $campos .= "2 as pc30_liboccontrato";
                            }
                            $campos = " distinct " . $campos;
                            $dbwhere .= " and (e60_vlremp - e60_vlranu) >
              (SELECT case when sum(m52_valor)  is null then 0 else sum(m52_valor) end as totalemordemdecompra
              FROM matordemitem
              WHERE m52_numemp = e60_numemp) -
             (SELECT case when sum(m36_vrlanu) is null then 0 else sum(m36_vrlanu) end AS totalemordemdecompraanulado
              FROM matordemitem
             INNER JOIN matordemitemanu ON m36_matordemitem = m52_codlanc
             WHERE m52_numemp = e60_numemp)
            and e60_vlremp > e60_vlranu ";
                            $dbwhere .= " and e60_instit = " . db_getsession("DB_instit") . " order by e60_numemp desc";
                            $sSql = $clempempenho->sql_query_inclusaoempenho(null, $campos, null, $dbwhere);
                        }

                        $result = $clempempenho->sql_record($sSql);

                        if ($clempempenho->numrows != 0) {

                            db_fieldsmemory($result, 0);

                            if (isset($filtroabast) && $filtroabast == 1) {
                                echo "<script>" . $funcao_js . "('{$e60_codemp}/{$e60_anousu}', false,'$e60_numcgm','$e60_numemp','$saldodisponivel');</script>";
                            } elseif (isset($lPesquisaPorCodigoEmpenho)) {
                                echo "<script>" . $funcao_js . "('{$e60_codemp}/{$e60_anousu}', '" . str_replace("'", "\'", $z01_nome) . "', '{$si172_nrocontrato}','{$si172_datafinalvigencia}','{$si174_novadatatermino}','{$e60_emiss}',false);</script>";
                            } elseif (isset($inclusaoordemcompra)) {
                                echo "<script>" . $funcao_js . "('{$e60_codemp}/{$e60_anousu}','{$si172_nrocontrato}','{$si172_datafinalvigencia}','{$si174_novadatatermino}','{$pc30_liboccontrato}',false);</script>";
                            } else {
                                if ($funcao_js == 'parent.js_mostraempempenhotesta') {
                                    echo "<script>" . $funcao_js . "('{$e60_codemp} / {$e60_anousu}', false);</script>";
                                }
                                if (isset($protocolo)) {
                                    echo "<script>" . $funcao_js . "('" . str_replace("'", "\'", $z01_nome) . "', '{$e60_numemp}','{$e60_emiss}','{$e60_vlremp}','{$e60_codemp}',false);</script>";
                                } else {
                                    echo "<script>" . $funcao_js . "('" . str_replace("'", "\'", $z01_nome) . "', '{$si172_nrocontrato}','{$si172_datafinalvigencia}','{$si174_novadatatermino}',false);</script>";
                                }
                            }
                        } else {
                            echo "<script>" . $funcao_js . "('Chave(" . $pesquisa_chave . ") não Encontrado', true);</script>";
                        }
                    } else {

                        echo "<script>" . $funcao_js . "('', false);</script>";
                    }
                }

                ?>
            </td>
        </tr>
    </table>
</body>

</html>
<script>
    document.getElementById("chave_e60_codemp").focus();
</script>
<?php
?>
