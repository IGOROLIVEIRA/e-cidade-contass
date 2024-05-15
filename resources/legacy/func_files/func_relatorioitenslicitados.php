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

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_liclicita_classe.php");
require_once("classes/db_liclicitem_classe.php");
require_once("classes/db_licobraslicitacao_classe.php");
require_once("classes/db_db_usuarios_classe.php");

db_postmemory($_GET);
db_postmemory($_POST);
$oGet = db_utils::postMemory($_GET);

parse_str($_SERVER["QUERY_STRING"]);

$clliclicitem = new cl_liclicitem;
$clliclicita  = new cl_liclicita;
$cllicobraslicitacao = new cl_licobraslicitacao;
$cldbusuarios = new cl_db_usuarios();

$clliclicita->rotulo->label("l20_codigo");
$clliclicita->rotulo->label("l20_numero");
$clliclicita->rotulo->label("l20_edital");
$clrotulo = new rotulocampo;
$clrotulo->label("l03_descr");
$iAnoSessao = db_getsession("DB_anousu");

?>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
    <table height="100%" border="0" align="center" cellspacing="0" bgcolor="#CCCCCC">
        <tr>
            <td height="63" align="center" valign="top">
                <table width="35%" border="0" align="center" cellspacing="0">
                    <form name="form2" method="post" action="">
                        <tr>
                            <td width="4%" align="right" nowrap title="<?= $Tl20_codigo ?>">
                                <?= $Ll20_codigo ?>
                            </td>
                            <td width="96%" align="left" nowrap>
                                <?php
                                db_input("l20_codigo", 10, $Il20_codigo, true, "text", 4, "", "chave_l20_codigo");
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td width="4%" align="right" nowrap title="<?= $Tl20_edital ?>">
                                <?= $Ll20_edital ?>
                            </td>
                            <td width="96%" align="left" nowrap>
                                <?php
                                db_input("l20_edital", 10, $Il20_edital, true, "text", 4, "", "chave_l20_edital");
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td width="4%" align="right" nowrap title="<?= $Tl20_numero ?>">
                                <?= $Ll20_numero ?>
                            </td>
                            <td width="96%" align="left" nowrap>
                                <?php
                                db_input("l20_numero", 10, $Il20_numero, true, "text", 4, "", "chave_l20_numero");
                                ?>
                            </td>
                        </tr>
                        <tr>

                        <tr>
                            <td width="4%" align="right" nowrap title="<?= $Tl03_descr ?>">
                                <?= $Ll03_descr ?>
                            </td>
                            <td width="96%" align="left" nowrap>
                                <?php
                                db_input("l03_descr", 60, $Il03_descr, true, "text", 4, "", "chave_l03_descr");
                                db_input("param", 10, "", false, "hidden", 3);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">
                                <b>Ano:</b>
                            </td>
                            <td>
                                <?php
                                db_input("l20_anousu", 10, "int", true, "text", 1, null, null, null, null, 4);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">
                                <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
                                <input name="limpar" type="reset" id="limpar" value="Limpar">
                                <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_liclicita.hide();">
                            </td>
                        </tr>
                    </form>
                </table>
            </td>
        </tr>
        <tr>
            <td align="center" valign="top">
                <?php
                $and            = "and ";
                $dbwhere        = "";
                $dbwhere_instit = "l20_licsituacao = 10 and l20_instit = " . db_getsession("DB_instit") . "{$sWhereModalidade}";
                $campos = "
                DISTINCT liclicita.l20_codigo,
                    liclicita.l20_edital,
                    l20_anousu,
                    pctipocompra.pc50_descr,
                    liclicita.l20_numero,
                    (CASE
                         WHEN l20_nroedital IS NULL THEN '-'
                         ELSE l20_nroedital::varchar
                     END) AS l20_nroedital,
                    liclicita.l20_datacria AS dl_Data_Abertura_Proc_Adm,
                    liclicita.l20_dataaber AS dl_Data_Emis_Alt_Edital_Convite,
                    liclicita.l20_dtpublic AS dl_Data_Publicação_DO,
                    liclicita.l20_objeto,
                    liclicita.l20_tipojulg,
                    l08_descr AS dl_Situacao
            ";
                if (!isset($pesquisa_chave)) {

                    if (isset($chave_l20_codigo) && (trim($chave_l20_codigo) != "")) {
                        $sql = $clliclicita->sql_queryContratos(null, $campos, "l20_codigo", "$dbwhere  l20_codigo = $chave_l20_codigo and $dbwhere_instit");
                    } else if (isset($chave_l20_numero) && (trim($chave_l20_numero) != "")) {
                        $sql = $clliclicita->sql_queryContratos(null, $campos, "l20_codigo", "$dbwhere l20_numero=$chave_l20_numero  and $dbwhere_instit");
                    } else if (isset($chave_l03_descr) && (trim($chave_l03_descr) != "")) {
                        $sql = $clliclicita->sql_queryContratos(null, $campos, "l20_codigo", "$dbwhere l03_descr like '$chave_l03_descr%'  and $dbwhere_instit");
                    } else if (isset($chave_l03_codigo) && (trim($chave_l03_codigo) != "")) {
                        $sql = $clliclicita->sql_queryContratos(null, $campos, "l20_codigo", "$dbwhere l03_codigo=$chave_l03_codigo  and $dbwhere_instit");
                    } else if (isset($chave_l20_edital) && (trim($chave_l20_edital) != "")) {
                        $sql = $clliclicita->sql_queryContratos(null, $campos, "l20_codigo", "$dbwhere l20_edital=$chave_l20_edital  and $dbwhere_instit");
                    } else if (isset($l20_anousu) && (trim($l20_anousu) != "")) {
                        $sql = $clliclicita->sql_queryContratos(null, $campos, "l20_codigo", "$dbwhere $dbwhere_instit and l20_anousu = {$l20_anousu}");
                    } else {
                        $sql = $clliclicita->sql_queryContratos("", $campos, "l20_codigo", "$dbwhere $dbwhere_instit");
                    }

                    $aRepassa = array();
                    db_lovrot($sql . ' desc ', 15, "()", "", $funcao_js, null, 'NoMe', $aRepassa, false);
                } else {
                    $result = $clliclicita->sql_record($clliclicita->sql_queryContratos(null, "*", null, "$dbwhere l20_codigo = $pesquisa_chave $and $dbwhere_instit "));
                    if ($clliclicita->numrows != 0) {
                        db_fieldsmemory($result, 0);
                        if ($tipoproc == "true") {
                            echo "<script>" . $funcao_js . "('$l20_objeto','$l03_pctipocompratribunal',false);</script>";
                        } else {
                            echo "<script>" . $funcao_js . "('$l20_objeto',false);</script>";
                        }
                    } else {
                        echo "<script>" . $funcao_js . "('Chave(" . $pesquisa_chave . ") não Encontrado',true);</script>";
                    }
                }
                ?>
            </td>
        </tr>
    </table>
</body>

</html>
<script>
    if (typeof document.getElementsByName("l20_veicdivulgacao")[0] !== 'undefined') {
        document.getElementsByName("l20_veicdivulgacao")[0].value = "Veículo de Publicação";
    }
    if (typeof document.getElementsByName("l20_dtpubratificacao")[0] !== 'undefined') {
        document.getElementsByName("l20_dtpubratificacao")[0].value = "Publicação";
    }
</script>
<?
if (!isset($pesquisa_chave)) {
?>
    <script>
    </script>
<?php
}
?>