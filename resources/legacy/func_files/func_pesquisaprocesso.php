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

$teste = $_POST["chave_p58_requer"];
$filtro = $_POST["filtropesquisa"];




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
    <style>
        .container {
            display: flex;
            flex-direction: column;
        }

        .titulo {
            font-size: 5vw;
            background-color: blue;
            text-align: center;
            padding: 3vw;
            position: relative;
        }

        .ctnFlex {
            display: flex;
            justify-content: space-between;
        }

        div.op1 {
            display: inline-block;
            font-size: 3vw;
            text-align: center;
            padding: 1vw 0vw 1vw 0vw;
            min-width: 40vw;
            margin-right: -250px;
        }

        div.op2 {
            display: inline-block;
            margin-right: 0vw;
            font-size: 3vw;
            text-align: center;
            padding: 1vw 0vw 1vw 0vw;
            min-width: 40vw;
            margin-right: -200px;

        }
    </style>
</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">


    <table height="100%" width="80%" border="0" align="center" cellspacing="0" bgcolor="#CCCCCC">
        <form name="form3" method="post" action="">

            <tr>
                <td height="63" align="center" valign="top">

                    <fieldset>
                        <legend class="bold">Pesquisa</legend>

                        <div class="container">

                            <div class="op1">
                                <table border="1px">
                                    <tr>
                                        <th style="background-color: #C0C0C0;">Selecione</th>
                                        <th style="background-color: #C0C0C0;">Descrição</th>
                                    </tr>
                                    <tr>

                                        <td align="center"> <input type="radio" name="filtropesquisa" value="filtro1" id="filtro1">
                                        </td>
                                        <td>Com todas as palavras </td>
                                    </tr>
                                    <tr>
                                        <td align="center"><input type="radio" name="filtropesquisa" value="filtro2" id="filtro2"></td>
                                        <td>Com expressão</td>
                                    </tr>
                                    <tr>
                                        <td align="center"><input type="radio" name="filtropesquisa" value="filtro3" id="filtro3"></td>
                                        <td>Com qualquer uma das palavras</td>
                                    </tr>

                                </table>

                            </div>
                            <div class="op2">
                                <table>
                                    <tr>
                                        <td width="4%" align="right" nowrap>
                                            <strong>Código/Nome do Titular:</strong>
                                        </td>
                                        <td width="96%" align="left" nowrap>
                                            <?
                                            db_input("z01_numcgm", 10, '', true, "text", 4, "", "z01_numcgm");
                                            ?>
                                            <?
                                            db_input("z01_nome", 36, $Ip58_requer, true, "text", 4, "", "z01_nome");
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="4%" align="right" nowrap title="<?= $Tp58_numero ?>">
                                            <strong>Protocolo Geral:</strong>
                                        </td>
                                        <td width="5%" align="left" nowrap>
                                            <?
                                            db_input("p58_numero", 10, $Ip58_numero, true, "text", 4, "", "p58_numero");
                                            ?>
                                            <strong>Tipo de Processo:</strong>
                                            <?
                                            db_input("p51_descr", 20, $Ip58_numero, true, "text", 4, "", "p51_descr");
                                            ?>
                                        </td>

                                    </tr>
                                    <tr>
                                        <td width="4%" align="right" nowrap>
                                            <strong>Observação:</strong>
                                        </td>
                                        <td width="96%" align="left" nowrap>
                                            <?
                                            db_input("p58_obs", 50, '', true, "text", 4, "", "p58_obs");
                                            ?>
                                        </td>
                                    </tr>


                                    <tr>
                                        <td width="4%" align="right" nowrap title="<?= $Tp58_requer ?>">
                                            <strong>Data do Processo:</strong>
                                        </td>
                                        <td width="96%" align="left" nowrap>
                                            <?
                                            db_inputdata('datainicial', @$datainicial_dia, @$datainicial_mes, @$datainicial_ano, true, 'text', $db_opcao, "");                                        ?>
                                            <strong>a </strong>
                                            <?
                                            db_inputdata('datafinal', @$datafinal_dia, @$datafinal_mes, @$datafinal_ano, true, 'text', $db_opcao, "");                                        ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <form name="form2" method="post" action="">
                            <table width="35%" border="0" align="center" cellspacing="0">



                                <tr>
                                    <td colspan="2" align="center">
                                        <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
                                        <input name="limpar" type="button" id="limpar" value="Limpar" onclick="limparTela();">
                                    </td>
                                </tr>

                            </table>

                        </form>

                    </fieldset>
                </td>
            </tr>



            <tr>
                <td align="center" valign="top">
                    <?



                    $sLeft = "";
                    $where .= " p58_instit = " . db_getsession("DB_instit");

                    if (isset($datainicial)) {
                        $data = str_replace("/", "-", $datainicial);
                        $datainicialformatada = date('Y-m-d', strtotime($data));
                    }

                    if (isset($datafinal)) {
                        $data = str_replace("/", "-", $datafinal);
                        $datafinalformatada = date('Y-m-d', strtotime($data));
                    }


                    /* 
                        valores dos filtros de pesquisa:
                        filtro1 = Com todas as palavras
                        filtro2 = Com expressão
                        filtro3 = Com qualquer uma das palavras
                    
                    */

                    if (isset($filtro)) {
                        if ($filtro == "filtro1") {
                            if (isset($z01_numcgm) && trim($z01_numcgm) != '') {
                                $where .= " and z01_numcgm = " . $z01_numcgm;
                            }

                            if (isset($z01_nome) && trim($z01_nome) != '') {

                                $array_palavras = explode(" ", $z01_nome);
                                $palavras = "";
                                for ($i = 0; $i < count($array_palavras); $i++) {

                                    $where .= " and LOWER (z01_nome) like LOWER ('%" . $array_palavras[$i] . "%')";
                                }
                            }

                            if (isset($p51_descr) && trim($p51_descr) != '') {

                                $array_palavras = explode(" ", $p51_descr);
                                $palavras = "";
                                for ($i = 0; $i < count($array_palavras); $i++) {

                                    $where .= " and LOWER (p51_descr) like LOWER ('%" . $array_palavras[$i] . "%')";
                                }
                            }

                            if (isset($p58_obs) && trim($p58_obs) != '') {
                                $array_palavras = explode(" ", $p58_obs);
                                $palavras = "";
                                for ($i = 0; $i < count($array_palavras); $i++) {

                                    $where .= " and LOWER (p58_obs) like LOWER ('%" . $array_palavras[$i] . "%')";
                                }
                            }

                            if (isset($p58_numero) && trim($p58_numero) != '') {
                                $numero = substr($p58_numero, 0, strpos($p58_numero, "/"));
                                $ano = substr($p58_numero, strpos($p58_numero, "/") + 1);
                                $where .= " and p58_numero = " . "'" . $numero . "'" . " and p58_ano = $ano";
                            }

                            if (isset($datainicial) && isset($datafinal) && $datainicial != '' && $datafinal != '') {
                                $where .= " and p58_dtproc >= " . "'" . $datainicialformatada . "'";
                                $where .= " and p58_dtproc < " . "'" . $datafinalformatada . "'";
                            } else if (isset($datainicial) && $datainicial != '') {
                                $where .= " and p58_dtproc = " . "'" . $datainicialformatada . "'";
                            } else if (isset($datafinal) && $datafinal != '') {
                                $where .= " and p58_dtproc = " . "'" . $datafinalformatada . "'";
                            }
                        }

                        if ($filtro == "filtro2") {
                            if (isset($z01_numcgm) && trim($z01_numcgm) != '') {
                                $where .= " and z01_numcgm = " . $z01_numcgm;
                            }

                            if (isset($z01_nome) && trim($z01_nome) != '') {
                                $where .= " and z01_nome ~* " . "'" . $z01_nome . "'";
                            }

                            if (isset($p51_descr) && trim($p51_descr) != '') {
                                $where .= " and p51_descr ~* " . "'" . $p51_descr . "'";
                            }

                            if (isset($p58_obs) && trim($p58_obs) != '') {
                                $where .= " and p58_obs ~* " . "'" . $p58_obs . "'";
                            }

                            if (isset($p58_numero) && trim($p58_numero) != '') {
                                $numero = substr($p58_numero, 0, strpos($p58_numero, "/"));
                                $ano = substr($p58_numero, strpos($p58_numero, "/") + 1);
                                $where .= " and p58_numero = " . "'" . $numero . "'" . " and p58_ano = $ano";
                            }

                            if (isset($datainicial) && isset($datafinal) && $datainicial != '' && $datafinal != '') {
                                $where .= " and p58_dtproc >= " . "'" . $datainicialformatada . "'";
                                $where .= " and p58_dtproc < " . "'" . $datafinalformatada . "'";
                            } else if (isset($datainicial) && $datainicial != '') {
                                $where .= " and p58_dtproc = " . "'" . $datainicialformatada . "'";
                            } else if (isset($datafinal) && $datafinal != '') {
                                $where .= " and p58_dtproc = " . "'" . $datafinalformatada . "'";
                            }
                        }

                        if ($filtro == "filtro3") {

                            if (isset($z01_numcgm) && trim($z01_numcgm) != '') {
                                $where .= " and z01_numcgm = " . $z01_numcgm;
                            }

                            if (isset($z01_nome) && $z01_nome != '') {
                                $array_palavras = explode(" ", $z01_nome);
                                $palavras = "";
                                for ($i = 0; $i < count($array_palavras); $i++) {
                                    if ($i == count($array_palavras) - 1) {
                                        $palavras .= "LOWER('%" . $array_palavras[$i] . "%')";
                                    } else {
                                        $palavras .= "LOWER('%" . $array_palavras[$i] . "%')" . ",";
                                    }
                                }
                                $where .= " and LOWER (z01_nome) like any(array[$palavras]) ";
                            }

                            if (isset($p51_descr) && trim($p51_descr) != '') {

                                $array_palavras = explode(" ", $p51_descr);
                                $palavras = "";
                                for ($i = 0; $i < count($array_palavras); $i++) {
                                    if ($i == count($array_palavras) - 1) {
                                        $palavras .= "LOWER('%" . $array_palavras[$i] . "%')";
                                    } else {
                                        $palavras .= "LOWER('%" . $array_palavras[$i] . "%')" . ",";
                                    }
                                }
                                $where .= " and LOWER (p51_descr) like any(array[$palavras]) ";
                            }

                            if (isset($p58_obs) && trim($p58_obs) != '') {
                                $array_palavras = explode(" ", $p58_obs);
                                $palavras = "";
                                for ($i = 0; $i < count($array_palavras); $i++) {
                                    if ($i == count($array_palavras) - 1) {
                                        $palavras .= "LOWER('%" . $array_palavras[$i] . "%')";
                                    } else {
                                        $palavras .= "LOWER('%" . $array_palavras[$i] . "%')" . ",";
                                    }
                                }
                                $where .= " and LOWER (p58_obs) like any(array[$palavras]) ";
                            }

                            if (isset($p58_numero) && trim($p58_numero) != '') {
                                $numero = substr($p58_numero, 0, strpos($p58_numero, "/"));
                                $ano = substr($p58_numero, strpos($p58_numero, "/") + 1);
                                $where .= " and p58_numero = " . "'" . $numero . "'" . " and p58_ano = $ano";
                            }

                            if (isset($datainicial) && isset($datafinal) && $datainicial != '' && $datafinal != '') {
                                $where .= " and p58_dtproc >= " . "'" . $datainicialformatada . "'";
                                $where .= " and p58_dtproc < " . "'" . $datafinalformatada . "'";
                            } else if (isset($datainicial) && $datainicial != '') {
                                $where .= " and p58_dtproc = " . "'" . $datainicialformatada . "'";
                            } else if (isset($datafinal) && $datafinal != '') {
                                $where .= " and p58_dtproc = " . "'" . $datafinalformatada . "'";
                            }
                        }
                    } else {
                        if (isset($z01_numcgm) && trim($z01_numcgm) != '') {
                            $where .= " and z01_numcgm = " . $z01_numcgm;
                        }

                        if (isset($z01_nome) && trim($z01_nome) != '') {
                            $where .= " and LOWER (z01_nome) like LOWER " . "('" . $z01_nome . "%')";
                        }

                        if (isset($p51_descr) && trim($p51_descr) != '') {
                            $where .= " and LOWER (p51_descr) like LOWER" . "('" . $p51_descr . "%')";
                        }

                        if (isset($p58_obs) && trim($p58_obs) != '') {
                            $where .= " and LOWER (p58_obs) like LOWER " . "('" . $p58_obs . "%')";
                        }

                        if (isset($p58_numero) && trim($p58_numero) != '') {
                            $numero = substr($p58_numero, 0, strpos($p58_numero, "/"));
                            $ano = substr($p58_numero, strpos($p58_numero, "/") + 1);
                            $where .= " and p58_numero = " . "'" . $numero . "'" . " and p58_ano = $ano";
                        }

                        if (isset($datainicial) && isset($datafinal) && $datainicial != '' && $datafinal != '') {
                            $where .= " and p58_dtproc >= " . "'" . $datainicialformatada . "'";
                            $where .= " and p58_dtproc < " . "'" . $datafinalformatada . "'";
                        } else if (isset($datainicial) && $datainicial != '') {
                            $where .= " and p58_dtproc = " . "'" . $datainicialformatada . "'";
                        } else if (isset($datafinal) && $datafinal != '') {
                            $where .= " and p58_dtproc = " . "'" . $datafinalformatada . "'";
                        }
                    }


                    $where .= " and tipoproc.p51_tipoprocgrupo = 1 ";
                    if (!isset($pesquisa_chave)) {

                        if (isset($campos) == false) {

                            $campos = "p58_dtproc,p58_codproc,cast(p58_numero||'/'||p58_ano as varchar) as p58_numero,z01_numcgm as DB_p58_numcgm,";
                            $campos .= "z01_nome,p58_obs,p51_descr,p58_requer as DB_p58_requer";
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
                            $sql = $clprotprocesso->sql_query(
                                "",
                                $campos,
                                "p58_codproc desc",
                                "$where "
                            );
                        } else if (isset($chave_unica) and ($chave_unica != '')) {

                            $sql = $clprotprocesso->sql_query($chave_unica, $campos);
                        } else if (isset($ntfornec)) {
                            if (!empty($p58_codigo)) {
                                $nrProcesso = explode("/", $p58_codigo);
                                !empty($where) ? $where .= " and p58_codigo = {$nrProcesso[0]} and p58_ano = {$nrProcesso[1]} " : $where .= " p58_codigo = {$nrProcesso[0]} and p58_ano = {$nrProcesso[1]} ";
                            }
                            if (!empty($p58_numero)) {
                                !empty($where) ? $where .= " and p58_codigo = {$p58_numero} " : $where .= " p58_codigo = {$p58_numero} ";
                            }
                            if (!empty($p58_requer)) {
                                !empty($where) ? $where .= " and p58_requer like '%{$p58_requer}%' " : $where .= " p58_requer like '%{$p58_requer}%' ";
                            }
                            if (!empty($p51_codigo)) {
                                !empty($where) ? $where .= " and p51_codigo = {$p51_codigo} " : $where .= " p51_codigo = {$p51_codigo} ";
                            }
                            $sql = $clprotprocesso->sql_query("", $campos, "p58_codproc desc", $where);
                        } else {
                            $sql = $clprotprocesso->sql_query("", $campos, "p58_dtproc desc", $where);
                        }
                        $repassa = array();
                        if (isset($chave_p58_codproc)) {
                            $repassa = array("chave_p58_codproc" => $chave_p58_codproc);
                        }

                        $funcao_js = "funcao_js=parent.js_consultarProcesso|p58_numero";
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
                            $pesquisa_chave = strlen($pesquisa_chave) == 4 ? $pesquisa_chave . '/' . $iAno : $pesquisa_chave;
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
        </form>
    </table>
</body>

</html>
<script type="text/javascript">
    var z01_nome = document.getElementsByName("z01_nome");
    z01_nome[1].value = "Titular do processo";

    function limparTela() {
        location.href = 'pro3_consultaprocesso001.php';

    }

    function js_validar(evt) {

        $('chave_p58_codproc').onkeyup = evt;
    }
</script>