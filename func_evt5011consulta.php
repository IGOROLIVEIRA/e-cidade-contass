<?php

/**
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

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_evt5011consulta_classe.php");
include("classes/db_cgm_classe.php");
db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clevt5011consulta = new cl_evt5011consulta;
$clevt5011consulta->rotulo->label("rh219_perapurano");
$clevt5011consulta->rotulo->label("rh219_perapurmes");
$clevt5011consulta->rotulo->label("rh219_indapuracao");
if (!isset($chave_rh219_perapurano)) {
    $chave_rh219_perapurano = db_getsession("DB_anousu");
}
if (!isset($chave_rh219_perapurmes)) {
    $chave_rh219_perapurmes = date("m", db_getsession("DB_datausu"));
}
if (!isset($chave_rh219_indapuracao)) {
    $chave_rh219_indapuracao = 1;
}
?>
<html xmlns="http://www.w3.org/1999/html">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
    <table height="100%" border="0" align="center" cellspacing="0" bgcolor="#CCCCCC">
        <tr>
            <td height="63" align="center" valign="top">
                <form name="form2" method="post" action="">
                    <fieldset style="width: 35%">
                        <legend>Pesquisa de Função</legend>
                        <table width="35%" border="0" align="center" cellspacing="0">
                            <tr>
                                <td width="4%" align="left" nowrap title="<?= $Trh219_perapurano ?>">
                                    <?= $Lrh219_perapurano ?>
                                </td>
                                <td width="96%" align="left" nowrap>
                                    <?
                                    db_input("rh219_perapurano", 5, $Irh219_perapurano, true, "text", 4, "", "chave_rh219_perapurano");
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td width="4%" align="left" nowrap title="<?= $Trh219_perapurmes ?>">
                                    <?= $Lrh219_perapurmes ?>
                                </td>
                                <td width="96%" align="left" nowrap>
                                    <?
                                    db_input("rh219_perapurmes", 5, $Irh219_perapurmes, true, "text", 4, "", "chave_rh219_perapurmes");
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td width="4%" align="left" nowrap title="<?= $Trh219_indapuracao ?>">
                                    <?= $Lrh219_indapuracao ?>
                                </td>
                                <td width="96%" align="left" nowrap>
                                    <?
                                    $arr_indapuracao = array(1 => 'Mensal', 2 => 'Anual (13° salário)', '' => 'Sem Filtro');
                                    db_select("rh219_indapuracao", $arr_indapuracao, true, $db_opcao, "", "chave_rh219_indapuracao");
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                    <table width="35%" border="0" align="center" cellspacing="0">
                        <tr>
                            <td colspan="2" align="center">
                                <input name="pesquisar" type="submit" id="pesquisar2" value="Pesquisar">
                                <input name="limpar" type="reset" id="limpar" value="Limpar">
                                <input name="Fechar" type="button" id="fechar" value="Fechar" onClick="parent.db_iframe_evt5001consulta.hide();">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">
                                <input name="imprimir" type="button" id="imprimir" value="Imprimir" onclick="js_imprimir()">
                            </td>
                        </tr>
                    </table>
                </form>
            </td>
        </tr>
        <tr>
            <td align="center" valign="top">
                <fieldset>
                    <legend>Resultado da Pesquisa</legend>
                    <?
                    $where = " rh219_instit = " . db_getsession("DB_instit");
                    if (!isset($pesquisa_chave)) {

                        $campos = "  
            rh219_sequencial    
            ,rh219_perapurano
            ,rh219_perapurmes
            ,case when rh219_indapuracao = 1 then 'Mensal'
            when rh219_indapuracao = 2 then 'Anual (13° salário)'
            else '' end as rh219_indapuracao     
            ,rh219_classtrib
            ,rh219_cnaeprep
            ,rh219_aliqrat
            ,rh219_fap
            ,rh219_aliqratajust     
            ,rh219_fpas             
            ,rh219_vrbccp00         
            ,rh219_baseaposentadoria
            ,rh219_vrsalfam
            ,rh219_vrsalmat
            ,rh219_vrdesccp         
            ,rh219_vrcpseg
            ,rh219_vrcr  
            ,rh219_vrcr + rh219_vrcpseg - rh219_vrsalfam - rh219_vrsalmat  
            as dl_Valor_Devido_à_Previdência      
            ";

                        if (isset($chave_rh219_perapurano) && (trim($chave_rh219_perapurano) != "")) {
                            $where .= " and rh219_perapurano = $chave_rh219_perapurano ";
                        }
                        if (isset($chave_rh219_perapurmes) && (trim($chave_rh219_perapurmes) != "")) {
                            $where .= " and rh219_perapurmes = $chave_rh219_perapurmes ";
                        }
                        if (isset($chave_rh219_indapuracao) && (trim($chave_rh219_indapuracao) != "")) {
                            $where .= " and rh219_indapuracao = $chave_rh219_indapuracao ";
                        }
                        if (!empty($chave_rh219_perapurano) && empty($chave_rh219_perapurmes)) {
                            $where .= " and rh219_perapurmes is null ";
                        }
                        $sql = $clevt5011consulta->sql_query(null, $campos, "rh219_sequencial desc", $where);
                        db_lovrot($sql, 15, "()", "", $funcao_js);
                    } else {
                        if ($pesquisa_chave != null && $pesquisa_chave != "") {
                            echo $clevt5011consulta->sql_query($pesquisa_chave, db_getsession("DB_instit"));
                            $result = $clevt5011consulta->sql_record($clevt5011consulta->sql_query($pesquisa_chave, db_getsession("DB_instit"), 'rh219_sequencial desc'));
                            if ($clevt5011consulta->numrows != 0) {
                                db_fieldsmemory($result, 0);
                                echo "<script>" . $funcao_js . "('$rh219_sequencial',false);</script>";
                            } else {
                                echo "<script>" . $funcao_js . "('Chave(" . $pesquisa_chave . ") não Encontrado',true);</script>";
                            }
                        } else {
                            echo "<script>" . $funcao_js . "('',false);</script>";
                        }
                    }
                    ?>
                </fieldset>
            </td>
        </tr>
    </table>
</body>

</html>
<?
if (!isset($pesquisa_chave)) {
?>
    <script>
        function js_imprimir() {
            jan = window.open('eso2_evt5011consulta002.php?rh219_perapurmes=' + document.form2.chave_rh219_perapurmes.value + '&rh219_perapurano=' + document.form2.chave_rh219_perapurano.value + '&rh219_indapuracao=' + document.form2.rh219_indapuracao.value, '', 'width=' + (screen.availWidth - 5) + ',height=' + (screen.availHeight - 40) + ',scrollbars=1,location=0 ');
            jan.moveTo(0, 0);
        }
    </script>
<?
}
?>