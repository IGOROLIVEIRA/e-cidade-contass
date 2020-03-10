<?php
/**
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBseller Servicos de Informatica
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
include("libs/db_utils.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_protprocesso_classe.php");

db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);

$oPost = db_utils::postMemory($_POST, 0);
$oGet = db_utils::postMemory($_GET, 0);

$clprotprocesso = new cl_protprocesso;
$clprotprocesso->rotulo->label("p58_codproc");
$clprotprocesso->rotulo->label("p58_requer");
$clprotprocesso->rotulo->label("p58_numero");

/**
 * Evita o escape dos campos
 */
if (isset($chave_p58_numero)) {
    $chave_p58_numero = stripslashes($chave_p58_numero);
}

if (isset($chave_p58_requer)) {
    $chave_p58_requer = stripslashes($chave_p58_requer);
}

?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table height="100%" border="0" align="center" cellspacing="0" bgcolor="#CCCCCC">
    <tr>
        <td height="63" align="center" valign="top">
            <table width="35%" border="0" align="center" cellspacing="0">
                <form name="form2" method="post" action="">
                    <tr>
                        <td width="4%" align="right" nowrap>
                            <strong>Número do Processo:</strong>
                        </td>
                        <td width="96%" align="left" nowrap>
                            <?
                            db_input("numeroprocesso", 10, '', true, "text", 4, "", "chave_numeroprocesso");
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="4%" align="right" nowrap title="<?= $Tp58_codproc ?>">
                            <?= $Lp58_codproc ?>
                        </td>
                        <td width="96%" align="left" nowrap>
                            <?
                            db_input("p58_codproc", 10, $Ip58_codproc, true, "text", 4, "", "chave_p58_codproc");
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="4%" align="right" nowrap title="<?= $Tp58_numero ?>">
                            <?= $Lp58_numero ?>
                        </td>
                        <td width="96%" align="left" nowrap>
                            <?
                            db_input("p58_numero", 10, $Ip58_numero, true, "text", 4, "", "chave_p58_numero");
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="4%" align="right" nowrap title="<?= $Tp58_requer ?>">
                            <?= $Lp58_requer ?>
                        </td>
                        <td width="96%" align="left" nowrap>
                            <?
                            db_input("p58_requer", 50, $Ip58_requer, true, "text", 4, "", "chave_p58_requer");
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar"
                                   onclick="return js_validar(arguments[0]);">
                            <input name="limpar" type="reset" id="limpar" value="Limpar">
                            <input name="Fechar" type="button" id="fechar" value="Fechar"
                                   onClick="parent.db_iframe_proc.hide();">
                        </td>
                    </tr>
                </form>
            </table>
        </td>
    </tr>
    <tr>
        <td align="center" valign="top">
            <?


            /**
             * Evita o escape dos campos
             */
            if (isset($chave_p58_numero)) {
                $chave_p58_numero = addslashes($chave_p58_numero);
            }

            if (isset($chave_p58_requer)) {
                $chave_p58_requer = addslashes($chave_p58_requer);
            }


            $sLeft = "";
            $where = " p58_instit = " . db_getsession("DB_instit");

            if (isset($grupo) && trim($grupo) != '') {
                $where .= " and tipoproc.p51_tipoprocgrupo = $grupo";
            }
            if (isset($tipo) && trim($tipo) != '') {
                $where .= " and p58_codigo = {$tipo} ";
            }
            if (isset($apensado)) {
                //Não permite que um secundário tenha mais de um principal.
                $where .= " and not exists ( select *
                                       from processosapensados
                                      where p30_procapensado  = p58_codproc limit 1)";
                if(trim($apensado) != '') {
                    $aPartesNumero = explode("/", $apensado);
                    $iAno = db_getsession("DB_anousu");
                    if (count($aPartesNumero) > 1 && !empty($aPartesNumero[1])) {
                        $iAno = $aPartesNumero[1];
                    }
                    $iNumero = $aPartesNumero[0];
                    $where .= " and p58_codproc not in (select p58_codproc from protprocesso where p58_ano = {$iAno} and p58_numero = '{$iNumero}') ";
                }
            }
            //Lista apenas os processos do departamento da sessão
            if($validaDepartamento) {
                $where .= " and (select p61_coddepto from procandam where p61_codproc = p58_codproc order by p61_codandam DESC limit 1) = " . db_getsession('DB_coddepto');
            }

            /**
             * Removido verificação de processos arquivados, conforme solicitado na ocorrência 2558
             */
            /**
             * Adicionado novamente verificação de processos arquivados, conforme solicitado na ocorrência 3689
             */
            //Não permite apensar processos arquivados.
            $where .= " and not exists (select 1 from arqproc where p68_codproc = p58_codproc) ";
            if (!isset($pesquisa_chave)) {

                if (isset($campos) == false) {

                    $campos = "p58_codproc,cast(p58_numero||'/'||p58_ano as varchar) as p58_numero,z01_numcgm as DB_p58_numcgm,";
                    $campos .= "z01_nome,p58_dtproc,p51_descr,p58_obs,p58_requer as DB_p58_requer";
                }
                if (isset($chave_p58_numcgm) && (trim($chave_p58_numcgm) != "")) {
                    $sql = $clprotprocesso->sql_query(null, $campos, "p58_codproc desc", "p58_numcgm = $chave_p58_numcgm  and $where");
                } else if (isset($chave_p58_codproc) && (trim($chave_p58_codproc) != "")) {

                    if (trim($where) != "") {
                        $where .= " and p58_codproc = " . $chave_p58_codproc;
                    } else {
                        $where .= " p58_codproc = " . $chave_p58_codproc;
                    }
                    $sql = $clprotprocesso->sql_query($chave_p58_codproc, $campos, "p58_codproc desc", $where);

                } else if (isset($chave_p58_requer) && (trim($chave_p58_requer) != "")) {
                    $sql = $clprotprocesso->sql_query("", $campos, "p58_codproc desc", " p58_requer like '$chave_p58_requer%'  and $where");
                } else if (isset($chave_p58_numero) && (trim($chave_p58_numero) != "")) {

                    $aPartesNumero = explode("/", $chave_p58_numero);
                    $iAno = db_getsession("DB_anousu");
                    if (count($aPartesNumero) > 1 && !empty($aPartesNumero[1])) {
                        $iAno = $aPartesNumero[1];
                    }
                    $iNumero = $aPartesNumero[0];
                    $where .= " and p58_ano = {$iAno} and p58_numero = '{$iNumero}'";
                    $sql = $clprotprocesso->sql_query("", $campos, "p58_codproc desc",
                        "$where ");
                } else if (isset($chave_unica) and ($chave_unica != '')) {

                    $sql = $clprotprocesso->sql_query($chave_unica, $campos);
                }
                else if (isset($ntfornec)) {
                    if (!empty($p58_codigo)) {
                        $nrProcesso = explode("/", $p58_codigo);
                        !empty($where) ? $where .= " and p58_codigo = {$nrProcesso[0]} and p58_ano = {$nrProcesso[1]} " : $where .= " p58_codigo = {$nrProcesso[0]} and p58_ano = {$nrProcesso[1]} ";
                    }
                    if (!empty($p58_numero)){
                        !empty($where) ? $where .= " and p58_codigo = {$p58_numero} " : $where .= " p58_codigo = {$p58_numero} ";
                    }
                    if (!empty($p58_requer)) {
                        !empty($where) ? $where .= " and p58_requer like '%{$p58_requer}%' " : $where .= " p58_requer like '%{$p58_requer}%' ";
                    }
                    if (!empty($p51_codigo)) {
                        !empty($where) ? $where .= " and p51_codigo = {$p51_codigo} " : $where .= " p51_codigo = {$p51_codigo} ";
                    }
                    $sql = $clprotprocesso->sql_query("", $campos, "p58_codproc desc", $where);

                }
                else {
                    $sql = $clprotprocesso->sql_query("", $campos, "p58_dtproc desc", $where);
                }
                $repassa = array();
                if (isset($chave_p58_codproc)) {
                    $repassa = array("chave_p58_codproc" => $chave_p58_codproc);
                }

                db_lovrot($sql . " ", 15, "()", "", $funcao_js, "", "NoMe", $repassa);
            } else {

                if ($pesquisa_chave != null && $pesquisa_chave != "") {

                    $aPartesNumero = explode("/", $pesquisa_chave);
                    $iAno = db_getsession("DB_anousu");
                    if (count($aPartesNumero) > 1 && !empty($aPartesNumero[1])) {
                        $iAno = $aPartesNumero[1];
                    }
                    $iNumero = $aPartesNumero[0];
                    $where .= " and p58_ano = {$iAno} and p58_numero = '{$iNumero}'";

                    $result = $clprotprocesso->sql_record($clprotprocesso->sql_query("", "*", "", $where));
                    $pesquisa_chave = strlen($pesquisa_chave) == 4 ? $pesquisa_chave.'/'.$iAno : $pesquisa_chave;
                    if ($clprotprocesso->numrows != 0 && ($apensado != $pesquisa_chave)) {

                        db_fieldsmemory($result, 0);
                        if (isset($retobs)) {

                            echo "<script>" . $funcao_js . "('$p58_numcgm','$p58_obs',false);</script>";

                        } elseif (isset($rettipoproc)) {

                            echo "<script>" . $funcao_js . "('$p58_numero/$p58_ano','$p51_descr','$p58_codproc',false);</script>";
                        } else {

                            echo "<script>" . $funcao_js . "('$p58_numero/$p58_ano','$z01_nome','$p58_codproc',false);</script>";
                        }
                    } else {
                        echo "<script>" . $funcao_js . "('','Chave(" . $pesquisa_chave . ") não Encontrado',true);</script>";
                    }
                } else {

                    echo "<script>" . $funcao_js . "('','',false);</script>";
                }
            }
            ?>
        </td>
    </tr>
</table>
</body>
</html>
<script type="text/javascript">

    function js_validar(evt) {

        $('chave_p58_codproc').onkeyup = evt;
    }

</script>