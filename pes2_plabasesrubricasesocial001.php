<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2009  DBselller Servicos de Informatica             
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
$clrotulo = new rotulocampo;
$clrotulo->label('DBtxt23');
$clrotulo->label('DBtxt25');
$clrotulo->label('DBtxt27');
$clrotulo->label('DBtxt28');
db_postmemory($HTTP_POST_VARS);
?>

<html>

<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>

    <script>
        function js_emite() {

            if (document.form1.tipoRelatorio.value == 'base') {
                qry = '?ativos=' + document.form1.ativos.value;
                qry += '&base=' + document.form1.base01.value;
                qry += '&descr_base=' + document.form1.descr_base01.value;
                jan = window.open('pes2_relbasesrubricasesocial002.php' + qry, '', 'width=' + (screen.availWidth - 5) + ',height=' + (screen.availHeight - 40) + ',scrollbars=1,location=0 ');
            } else {
                qry = '?ativos=' + document.form1.ativos.value;
                jan = window.open('pes2_cadrubricasesocial002.php' + qry, '', 'width=' + (screen.availWidth - 5) + ',height=' + (screen.availHeight - 40) + ',scrollbars=1,location=0 ');
            }
            jan.moveTo(0, 0);
        }


        function js_pesquisabase01(mostra) {
            if (mostra == true) {
                js_OpenJanelaIframe('top.corpo', 'db_iframe_bases', 'func_bases.php?funcao_js=parent.js_mostrabase011|r08_codigo|r08_descr', 'Pesquisa', true);
            } else {
                if (document.form1.base01.value != '') {
                    js_OpenJanelaIframe('top.corpo', 'db_iframe_base01', 'func_bases.php?pesquisa_chave=' + document.form1.base01.value + '&funcao_js=parent.js_mostrabase01', 'Pesquisa', false);
                } else {
                    document.form1.descr_base01.value = '';
                }
            }
        }

        function js_mostrabase01(chave, erro) {
            document.form1.descr_base01.value = chave;
            if (erro == true) {
                document.form1.base01.focus();
                document.form1.base01.value = '';
            }
        }

        function js_mostrabase011(chave1, chave2) {
            document.form1.base01.value = chave1;
            document.form1.descr_base01.value = chave2;
            db_iframe_bases.hide();
        }
    </script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">
    <table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
        <tr>
            <td width="360" height="18">&nbsp;</td>
            <td width="263">&nbsp;</td>
            <td width="25">&nbsp;</td>
            <td width="140">&nbsp;</td>
        </tr>
    </table>

    <table align="center">
        <form name="form1" method="post" action="">
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td align="right"><strong>Tipo de Relatório:&nbsp;&nbsp;</strong>
                </td>
                <td align="left">
                    <?
                    $arrTipoRelatorio = array("base" => "Bases e-social / rubricas", "rubrica" => "Rubricas - Bases e-social");
                    db_select('tipoRelatorio', $arrTipoRelatorio, true, 4, "onchange='js_tipo_relatorio();'");
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap align="right" title="Teto remuneratório (art. 37, XI, da CF/1988)"><b>
                        <?
                        db_ancora('Teto remuneratório (art. 37, XI, da CF/1988):', "js_pesquisabase01(true)", @$db_opcao);
                        ?>
                        &nbsp;</b>
                </td>
                <td nowrap>
                    <?
                    db_input('base01', 4, @$base01, true, 'text', @$db_opcao, "onchange='js_pesquisabase01(false)'");
                    db_input("r08_descr", 50, @$Ir08_descr, true, "text", 3, "", "descr_base01");
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap align="right" title="Base de Calculo IRRF Mensal"><b>
                        <?
                        db_ancora('Base de Calculo IRRF Mensal:', "js_pesquisabase02(true)", @$db_opcao);
                        ?>
                        &nbsp;</b>
                </td>
                <td nowrap>
                    <?
                    db_input('base01', 4, @$base01, true, 'text', @$db_opcao, "onchange='js_pesquisabase02(false)'");
                    db_input("r08_descr", 50, @$Ir08_descr, true, "text", 3, "", "descr_base02");
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap align="right" title="Base de Cálculo IRRF Férias"><b>
                        <?
                        db_ancora('Base de Cálculo IRRF Férias:', "js_pesquisabase03(true)", @$db_opcao);
                        ?>
                        &nbsp;</b>
                </td>
                <td nowrap>
                    <?
                    db_input('base01', 4, @$base01, true, 'text', @$db_opcao, "onchange='js_pesquisabase03(false)'");
                    db_input("r08_descr", 50, @$Ir08_descr, true, "text", 3, "", "descr_base03");
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap align="right" title="Base de Cálculo IRRF 13º Salário"><b>
                        <?
                        db_ancora('Base de Cálculo IRRF 13º Salário:', "js_pesquisabase04(true)", @$db_opcao);
                        ?>
                        &nbsp;</b>
                </td>
                <td nowrap>
                    <?
                    db_input('base01', 4, @$base01, true, 'text', @$db_opcao, "onchange='js_pesquisabase04(false)'");
                    db_input("r08_descr", 50, @$Ir08_descr, true, "text", 3, "", "descr_base04");
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap align="right" title="Base de Cálculo RGPS Mensal"><b>
                        <?
                        db_ancora('Base de Cálculo RGPS Mensal:', "js_pesquisabase05(true)", @$db_opcao);
                        ?>
                        &nbsp;</b>
                </td>
                <td nowrap>
                    <?
                    db_input('base01', 4, @$base01, true, 'text', @$db_opcao, "onchange='js_pesquisabase05(false)'");
                    db_input("r08_descr", 50, @$Ir08_descr, true, "text", 3, "", "descr_base05");
                    ?>
                </td>
            </tr>
            <tr>

                <td nowrap align="right" title="Base de Cálculo RGPS Férias"><b>
                        <?
                        db_ancora('Base de Cálculo RGPS Férias:', "js_pesquisabase06(true)", @$db_opcao);
                        ?>
                        &nbsp;</b>
                </td>
                <td nowrap>
                    <?
                    db_input('base01', 4, @$base01, true, 'text', @$db_opcao, "onchange='js_pesquisabase06(false)'");
                    db_input("r08_descr", 50, @$Ir08_descr, true, "text", 3, "", "descr_base06");
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap align="right" title="Base de Cálculo RGPS 13º Salário"><b>
                        <?
                        db_ancora('Base de Cálculo RGPS 13º Salário:', "js_pesquisabase07(true)", @$db_opcao);
                        ?>
                        &nbsp;</b>
                </td>
                <td nowrap>
                    <?
                    db_input('base01', 4, @$base01, true, 'text', @$db_opcao, "onchange='js_pesquisabase07(false)'");
                    db_input("r08_descr", 50, @$Ir08_descr, true, "text", 3, "", "descr_base07");
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap align="right" title="Base de Cálculo RPPS Mensal"><b>
                        <?
                        db_ancora('Base de Cálculo RPPS Mensal:', "js_pesquisabase08(true)", @$db_opcao);
                        ?>
                        &nbsp;</b>
                </td>
                <td nowrap>
                    <?
                    db_input('base01', 4, @$base01, true, 'text', @$db_opcao, "onchange='js_pesquisabase08(false)'");
                    db_input("r08_descr", 50, @$Ir08_descr, true, "text", 3, "", "descr_base08");
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap align="right" title="Base de Cálculo RPPS Férias"><b>
                        <?
                        db_ancora('Base de Cálculo RPPS Férias:', "js_pesquisabase09(true)", @$db_opcao);
                        ?>
                        &nbsp;</b>
                </td>
                <td nowrap>
                    <?
                    db_input('base01', 4, @$base01, true, 'text', @$db_opcao, "onchange='js_pesquisabase09(false)'");
                    db_input("r08_descr", 50, @$Ir08_descr, true, "text", 3, "", "descr_base09");
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap align="right" title="Base de Cálculo RPPS 13º Salário"><b>
                        <?
                        db_ancora('Base de Cálculo RPPS 13º Salário:', "js_pesquisabase010(true)", @$db_opcao);
                        ?>
                        &nbsp;</b>
                </td>
                <td nowrap>
                    <?
                    db_input('base01', 4, @$base01, true, 'text', @$db_opcao, "onchange='js_pesquisabase010(false)'");
                    db_input("r08_descr", 50, @$Ir08_descr, true, "text", 3, "", "descr_base010");
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap align="right" title="Base de Cálculo FGTS"><b>
                        <?
                        db_ancora('Base de Cálculo FGTS:', "js_pesquisabase011(true)", @$db_opcao);
                        ?>
                        &nbsp;</b>
                </td>
                <td nowrap>
                    <?
                    db_input('base01', 4, @$base01, true, 'text', @$db_opcao, "onchange='js_pesquisabase011(false)'");
                    db_input("r08_descr", 50, @$Ir08_descr, true, "text", 3, "", "descr_base011");
                    ?>
                </td>
            </tr>
            </span>
            <tr>
                <td align="right"><strong>Imprime Rubricas :&nbsp;&nbsp;</strong>
                </td>
                <td align="left">
                    <?
                    $arr_ativos = array("t" => "Ativas", "f" => "Inativas", "i" => "Todas");
                    db_select('ativos', $arr_ativos, true, 4, "");
                    ?>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input name="emite2" id="emite2" type="button" value="Processar" onclick="js_emite();">
                </td>
            </tr>

        </form>
    </table>
    <?
    db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit"));
    ?>
    <script>
        function js_tipo_relatorio() {
            let elementoVerificar = $("tipoRelatorio");
            let elementoBase = $('columnBase');
            if (elementoVerificar.value == 'base') {
                elementoBase.show();
            } else {
                elementoBase.hide();
            }
        }
        js_tipo_relatorio();
    </script>
</body>

</html>