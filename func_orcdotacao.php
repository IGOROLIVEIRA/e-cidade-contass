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
include("dbforms/db_funcoes.php");
include("classes/db_orcorgao_classe.php");
include("classes/db_orcunidade_classe.php");
include("classes/db_orcdotacao_classe.php");
include("classes/db_orcdotacaocontr_classe.php");
include("classes/db_orcparametro_classe.php");
require("libs/db_liborcamento.php");
$clorcparametro = new cl_orcparametro;
$clorcorgao = new cl_orcorgao;
$clorcunidade = new cl_orcunidade;
$clorcdotacao = new cl_orcdotacao;
$clorcdotacaocontr = new cl_orcdotacaocontr;
$clestrutura = new cl_estrutura;
$clorcorgao->rotulo->label();
$clorcunidade->rotulo->label();
$clorcdotacao->rotulo->label();
$clorcdotacaocontr->rotulo->label();
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS['QUERY_STRING']);
?>

<html>

<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
    <table height="100%" border="0" align="center" cellspacing="0" bgcolor="#CCCCCC">
        <tr>
            <td height="63" align="center" valign="top">
                <table width="80%" border="0" align="center" cellspacing="0">
                    <form name="form1" method="post">
                        <tr>
                            <td width="25%" align="left" nowrap title="<?= $To58_coddot ?>">
                                <?= $Lo58_coddot ?>
                            </td>
                            <td width="75%" align="left" nowrap>
                                <? db_input("o58_coddot", 6, $Io58_coddot, true, "text", 4, "", "o58_coddot"); ?>
                            </td>
                        </tr>
                        <?
                        $clestrutura->nomeform = "form1";
                        $clestrutura->estrutura('o50_estrutdespesa')
                        ?>
                        <tr>
                            <td><?= $Lo40_orgao ?></td>
                            <td>
                                <?
                                $result = $clorcorgao->sql_record($clorcorgao->sql_query(null, null, "o40_orgao,o40_descr", "o40_orgao", "o40_anousu=" . db_getsession("DB_anousu") . " and o40_instit=" . db_getsession("DB_instit")));
                                db_selectrecord("o40_orgao", $result, true, 2, "", "", "", "0", $onchange = " js_troca('o40_orgao');");
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?= $Lo41_unidade ?></td>
                            <td>
                                <?
                                if (isset($o40_orgao)) {
                                    $result = $clorcunidade->sql_record($clorcunidade->sql_query(null, null, null, "o41_unidade,o41_descr", "o41_unidade", "o41_anousu=" . db_getsession("DB_anousu") . "  and o41_orgao=$o40_orgao "));
                                    db_selectrecord("o41_unidade", $result, true, 2, "", "", "", ($clorcunidade->numrows > 1 ? "0" : ""), $onchange = "  js_troca('o41_unidade');");
                                } else {
                                    db_input("o41_unidade", 6, 0, true, "hidden", 0);
                                }
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td><?= $Lo58_funcao ?></td>
                            <td>
                                <?
                                $dbwhere = "";
                                if (isset($o40_orgao) && $o40_orgao > 0) {
                                    $dbwhere .= " and o58_orgao= $o40_orgao ";
                                }
                                if (isset($o41_unidade) && $o41_unidade > 0) {
                                    $dbwhere .= " and o58_unidade = $o41_unidade ";
                                }
                                $result = $clorcdotacao->sql_record($clorcdotacao->sql_query(null, null, "distinct o52_funcao,o52_descr", "o52_funcao", "o58_anousu=" . db_getsession("DB_anousu") . " and o58_instit=" . db_getsession("DB_instit") . " $dbwhere"));
                                //db_criatabela($result);
                                db_selectrecord("o52_funcao", $result, true, 2, "", "", "", ($clorcdotacao->numrows > 1 ? "0" : ""), $onchange = "  js_troca('o52_funcao');");
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?= $Lo58_subfuncao ?></td>
                            <td>
                                <?
                                $dbwhere = "";
                                if (isset($o40_orgao) && $o40_orgao > 0) {
                                    $dbwhere .= " and o58_orgao= $o40_orgao ";
                                }
                                if (isset($o41_unidade) && $o41_unidade > 0) {
                                    $dbwhere .= " and o58_unidade = $o41_unidade ";
                                }

                                if (isset($o52_funcao) && $o52_funcao > 0) {
                                    $dbwhere .= " and  o58_funcao = $o52_funcao ";
                                }

                                $result = $clorcdotacao->sql_record($clorcdotacao->sql_query(null, null, "distinct o53_subfuncao,o53_descr", "o53_subfuncao", "o58_anousu=" . db_getsession("DB_anousu") . " and o58_instit=" . db_getsession("DB_instit") . " $dbwhere"));
                                db_selectrecord("o53_subfuncao", $result, true, 2, "", "", "", ($clorcdotacao->numrows > 1 ? "0" : ""), $onchange = "  js_troca('o53_subfuncao');");
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td><?= $Lo58_programa ?></td>
                            <td>
                                <?
                                $dbwhere = "";
                                if (isset($o40_orgao) && $o40_orgao > 0) {
                                    $dbwhere .= "  and o58_orgao= $o40_orgao ";
                                }
                                if (isset($o41_unidade) && $o41_unidade > 0) {
                                    $dbwhere .= " and o58_unidade = $o41_unidade ";
                                }
                                if (isset($o52_funcao) && $o52_funcao > 0) {
                                    if ($dbwhere != "")
                                        $dbwhere .= "  and o58_funcao = $o52_funcao ";
                                }

                                if (isset($o53_subfuncao) && $o53_subfuncao > 0) {
                                    $dbwhere .= "  and o58_subfuncao = $o53_subfuncao ";
                                }

                                $result = $clorcdotacao->sql_record($clorcdotacao->sql_query(null, null, "distinct o54_programa,o54_descr", "o54_programa", "o58_anousu=" . db_getsession("DB_anousu") . " and o58_instit=" . db_getsession("DB_instit") . " $dbwhere"));
                                db_selectrecord("o54_programa", $result, true, 2, "", "", "", ($clorcdotacao->numrows > 1 ? "0" : ""), $onchange = "  js_troca('o54_programa');");
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td><?= $Lo58_projativ ?></td>
                            <td>
                                <?
                                $dbwhere = "";
                                if (isset($o40_orgao) && $o40_orgao > 0) {
                                    $dbwhere .= "  and o58_orgao= $o40_orgao ";
                                }
                                if (isset($o41_unidade) && $o41_unidade > 0) {
                                    $dbwhere .= " and o58_unidade = $o41_unidade ";
                                }
                                if (isset($o52_funcao) && $o52_funcao > 0) {
                                    $dbwhere .= "  and o58_funcao = $o52_funcao ";
                                }
                                if (isset($o53_subfuncao) && $o53_subfuncao > 0) {
                                    $dbwhere .= "  and o58_subfuncao = $o53_subfuncao ";
                                }
                                if (isset($o54_programa) && $o54_programa > 0) {
                                    $dbwhere .= "  and o58_programa = $o54_programa ";
                                }
                                $result = $clorcdotacao->sql_record($clorcdotacao->sql_query(null, null, "distinct o55_projativ,o55_descr", "o55_projativ", "o58_anousu=" . db_getsession("DB_anousu") . " and o58_instit=" . db_getsession("DB_instit") . " $dbwhere"));
                                db_selectrecord("o55_projativ", $result, true, 2, "", "", "", ($clorcdotacao->numrows > 1 ? "0" : ""), $onchange = "  js_troca('o55_projativ');");
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td><?= $Lo58_codele ?></td>
                            <td>
                                <?
                                $dbwhere = "";
                                if (isset($o40_orgao) && $o40_orgao > 0) {
                                    $dbwhere .= " and o58_orgao= $o40_orgao ";
                                }
                                if (isset($o41_unidade) && $o41_unidade > 0) {
                                    $dbwhere .= " and o58_unidade = $o41_unidade ";
                                }
                                if (isset($o52_funcao) && $o52_funcao > 0) {
                                    $dbwhere .= " and o58_funcao = $o52_funcao ";
                                }
                                if (isset($o53_subfuncao) && $o53_subfuncao > 0) {
                                    $dbwhere .= " and  o58_subfuncao = $o53_subfuncao ";
                                }
                                if (isset($o54_programa) && $o54_programa > 0) {
                                    $dbwhere .= " and o58_programa = $o54_programa ";
                                }
                                if (isset($o55_projativ) && $o55_projativ > 0) {
                                    $dbwhere .= " and  o58_projativ = $o55_projativ ";
                                }
                                $result = $clorcdotacao->sql_record($clorcdotacao->sql_query(null, null, "distinct o56_elemento,o56_descr", "o56_elemento", "o58_anousu=" . db_getsession("DB_anousu") . " and o58_instit=" . db_getsession("DB_instit") . " $dbwhere"));
                                db_selectrecord("o56_elemento", $result, true, 2, "", "", "", ($clorcdotacao->numrows > 1 ? "0" : ""), " js_troca('o56_elemento');");
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td><?= $Lo58_codigo ?></td>
                            <td>
                                <?
                                $dbwhere = "";
                                if (isset($o40_orgao) && $o40_orgao > 0) {
                                    $dbwhere .= " and o58_orgao= $o40_orgao ";
                                }
                                if (isset($o41_unidade) && $o41_unidade > 0) {
                                    $dbwhere .= " and o58_unidade = $o41_unidade ";
                                }
                                if (isset($o52_funcao) && $o52_funcao > 0) {
                                    $dbwhere .= " and o58_funcao = $o52_funcao ";
                                }
                                if (isset($o53_subfuncao) && $o53_subfuncao > 0) {
                                    $dbwhere .= " and o58_subfuncao = $o53_subfuncao ";
                                }
                                if (isset($o54_programa) && $o54_programa > 0) {
                                    $dbwhere .= " and o58_programa = $o54_programa ";
                                }
                                if (isset($o55_projativ) && $o55_projativ > 0) {
                                    $dbwhere .= " and o58_projativ = $o55_projativ ";
                                }
                                if (isset($o56_elemento) && $o56_elemento > 0) {
                                    $dbwhere .= " and o56_elemento = '$o56_elemento' ";
                                }
                                $dbwhere .= " and (o15_datalimite is null or o15_datalimite > '" . date('Y-m-d', db_getsession('DB_datausu')) . "')";
                                $sSqlRecursos = $clorcdotacao->sql_query(null, null, "distinct o15_codigo,o15_descr", "o15_codigo", "o58_anousu=" . db_getsession("DB_anousu") . " and o58_instit=" . db_getsession("DB_instit") . " $dbwhere");
                                $result = $clorcdotacao->sql_record($sSqlRecursos);
                                db_selectrecord("o58_codigo", $result, true, 2, "", "", "", ($clorcdotacao->numrows > 1 ? "0" : ""), " js_troca('o58_codigo');");
                                ?>
                            </td>
                        </tr>
                        <tr height="20px">
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>

                            <td colspan="2" align="center">
                                <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
                                <input name="limpar" type="reset" id="limpar" value="Limpar">
                                <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_orcdotacao.hide();">
                            </td>
                        </tr>
                    </form>
                </table>
            </td>
        </tr>
        <?
        if (isset($o58_coddot) && $o58_coddot != "") {
            $filtro = " and o58_coddot=$o58_coddot  ";
        } else {
            $filtro = "";
            if (isset($o50_estrutdespesa) && $o50_estrutdespesa != "") {
                $matriz = split('\.', $o50_estrutdespesa);
                for ($i = 0; $i < count($matriz); $i++) {
                    switch ($i) {
                        case 0: //orgao
                            $o40_orgao = $matriz[$i];
                            break;
                        case 1: //unidade
                            $o41_unidade = $matriz[$i];
                            break;
                        case 2: //funcao
                            $o52_funcao = $matriz[$i];
                            break;
                        case 3: //subfuncao
                            $o53_subfuncao = $matriz[$i];
                            break;
                        case 4: //programa
                            $o54_programa = $matriz[$i];
                            break;
                        case 5: //projativ
                            $o55_projativ = $matriz[$i];
                            break;
                        case 6: //elemento de despesa
                            $o56_elemento = $matriz[$i];
                            break;
                        case 7: //tipo de  recurso
                            $o58_codigo = $matriz[$i];
                            break;
                        case 8: //contra recurso
                            $o61_codigo = $matriz[$i];
                            break;
                    }
                }
            }

            if (!empty($o40_orgao)) {
                $filtro .= " and o58_orgao = $o40_orgao ";
            }
            if (!empty($o41_unidade)) {
                if ($filtro != "")
                    $filtro .= " and o58_unidade = $o41_unidade ";
            }
            if (!empty($o52_funcao)) {
                $filtro .= " and o58_funcao = $o52_funcao ";
            }
            if (!empty($o53_subfuncao)) {
                $filtro .= " and o58_subfuncao = $o53_subfuncao ";
            }
            if (!empty($o54_programa)) {
                $filtro .= " and o58_programa = $o54_programa ";
            }
            if (!empty($o55_projativ)) {
                $filtro .= " and o58_projativ = $o55_projativ ";
            }
            if (!empty($o56_elemento)) {
                $filtro .= " and o56_elemento = '$o56_elemento'";
            }
            if (!empty($o58_codigo)) {
                $filtro .= " and o58_codigo = $o58_codigo ";
            }
            if (!empty($o61_codigo)) {
                $filtro .= " and o61_codigo = $o61_codigo ";
            }
            if (!empty($pesquisa_chave))
                $filtro .= " and o58_coddot = $pesquisa_chave ";
            echo $pesquisa_chave;
        }
        /* quando a instituição é prefeitura, é permitido selecionar dotações de outras instituições */
        $where_instit = "o58_instit=" . db_getsession("DB_instit");
        $sql_instit = "select prefeitura  /* campo boolean */
          from db_config 
  where codigo = " . db_getsession("DB_instit");
        $res_instit = $clorcdotacao->sql_record($sql_instit);
        if ($clorcdotacao->numrows != 0) {
            db_fieldsmemory($res_instit, 0);
            if ($prefeitura == 't')
                $where_instit = "1=1 ";
        }
        $sql = " select fc_estruturaldotacao(" . db_getsession("DB_anousu") . ",o58_coddot) as dl_estrutural,
            o56_elemento,
            o55_descr::text,
            o56_descr,
            o58_coddot,
            o58_instit
            from orcdotacao d
            inner join orcprojativ p on p.o55_anousu = " . db_getsession("DB_anousu") . " and p.o55_projativ = d.o58_projativ
            inner join orcelemento e on e.o56_codele = d.o58_codele and o56_anousu = o58_anousu
            where  $where_instit  
            and o58_anousu=" . db_getsession('DB_anousu') . " $filtro
            order by dl_estrutural";
        ?>
        <tr>
            <td align="center" valign="top">
                <?
                if (!isset($pesquisa_chave)) {
                    db_lovrot($sql, 15, "()", "", $funcao_js, "", "NoMe", array(), false, array());
                } else {
                    if ($pesquisa_chave != null && $pesquisa_chave != "") {
                        // Dim result as RecordSet
                        $result = $clorcdotacao->sql_record($clorcdotacao->sql_query(db_getsession("DB_anousu"), $pesquisa_chave));

                        if ($clorcdotacao->numrows != 0) {
                            db_fieldsmemory($result, 0);
                            echo $result;
                            echo "<script>" . $funcao_js . "('$o56_descr',false);</script>";
                        } else {
                            echo "<script>" . $funcao_js . "('Chave(" . $pesquisa_chave . ") não Encontrado',true);</script>";
                        }
                    } else {
                        echo "<script>" . $funcao_js . "('',false);</script>";
                    }
                }

                ?>
            </td>
        </tr>
    </table>
    </center>
</body>

</html>
<script>
    function js_troca(nome) {
        ordem = new Array("o40_orgao", "o41_unidade", "o52_funcao", "o53_subfuncao", "o54_programa", "o55_projativ", "o56_elemento", "o58_codigo");
        for (i = (ordem.length - 1); i > 0; i--) {
            if (ordem[i] == nome) {
                break;
            } else {
                if (eval("document.form1." + ordem[i] + ".options;")) {
                    if (eval("document.form1." + ordem[i] + ".options.length>'1';")) {
                        eval("document.form1." + ordem[i] + ".options[0].selected=true;");
                        eval("document.form1." + ordem[i] + "descr.options[0].selected=true;");
                    } else {
                        eval("document.form1." + ordem[i] + ".options[0].value='0';");
                        eval("document.form1." + ordem[i] + ".options[0].text='0';");
                        eval("document.form1." + ordem[i] + "descr.options[0].value='0';");
                        eval("document.form1." + ordem[i] + "descr.options[0].text='0';");
                    }
                }
            }
        }
        document.form1.submit();
    }
</script>