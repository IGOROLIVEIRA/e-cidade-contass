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
            qry = '?date=' + document.form1.daterel.value;
            //qry += '&base01='  + document.form1.base01.value;
            qry += '&base02=' + document.form1.base02.value;
            qry += '&base03=' + document.form1.base03.value;
            qry += '&base04=' + document.form1.base04.value;
            qry += '&base05=' + document.form1.base05.value;
            qry += '&base06=' + document.form1.base06.value;
            qry += '&base07=' + document.form1.base07.value;
            qry += '&base08=' + document.form1.base08.value;
            qry += '&base09=' + document.form1.base09.value;
            qry += '&base010=' + document.form1.base010.value;
            qry += '&base011=' + document.form1.base011.value;
            qry += '&ativos=' + document.form1.ativos.value;
            const jan = window.open('pes2_planilhabasesrubricaesocial.php' + qry);
            jan.moveTo(0, 0);
        }

        /*Ancora01
        function js_pesquisabase01(mostra) {
            if (mostra == true) {
                js_OpenJanelaIframe('top.corpo', 'db_iframe_bases', 'func_bases.php?funcao_js=parent.js_mostrabase001|r08_codigo|r08_descr', 'Pesquisa', true);
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

        function js_mostrabase001(chave1, chave2) {
            document.form1.base01.value = chave1;
            document.form1.descr_base01.value = chave2;
            db_iframe_bases.hide();
        }
        */

        /*Ancora02*/
        function js_pesquisabase02(mostra) {
            if (mostra == true) {
                js_OpenJanelaIframe('top.corpo', 'db_iframe_bases', 'func_bases.php?funcao_js=parent.js_mostrabase002|r08_codigo|r08_descr', 'Pesquisa', true);
            } else {
                if (document.form1.base01.value != '') {
                    js_OpenJanelaIframe('top.corpo', 'db_iframe_base02', 'func_bases.php?pesquisa_chave=' + document.form1.base01.value + '&funcao_js=parent.js_mostrabase02', 'Pesquisa', false);
                } else {
                    document.form1.descr_base01.value = '';
                }
            }
        }

        function js_mostrabase02(chave, erro) {
            document.form1.descr_base02.value = chave;
            if (erro == true) {
                document.form1.base02.focus();
                document.form1.base02.value = '';
            }
        }

        function js_mostrabase002(chave1, chave2) {
            document.form1.base02.value = chave1;
            document.form1.descr_base02.value = chave2;
            db_iframe_bases.hide();
        }
        /*Ancora03*/
        function js_pesquisabase03(mostra) {
            if (mostra == true) {
                js_OpenJanelaIframe('top.corpo', 'db_iframe_bases', 'func_bases.php?funcao_js=parent.js_mostrabase003|r08_codigo|r08_descr', 'Pesquisa', true);
            } else {
                if (document.form1.base03.value != '') {
                    js_OpenJanelaIframe('top.corpo', 'db_iframe_base03', 'func_bases.php?pesquisa_chave=' + document.form1.base03.value + '&funcao_js=parent.js_mostrabase03', 'Pesquisa', false);
                } else {
                    document.form1.descr_base03.value = '';
                }
            }
        }

        function js_mostrabase03(chave, erro) {
            document.form1.descr_base03.value = chave;
            if (erro == true) {
                document.form1.base03.focus();
                document.form1.base03.value = '';
            }
        }

        function js_mostrabase003(chave1, chave2) {
            document.form1.base03.value = chave1;
            document.form1.descr_base03.value = chave2;
            db_iframe_bases.hide();
        }
        /*Ancora04*/
        function js_pesquisabase04(mostra) {
            if (mostra == true) {
                js_OpenJanelaIframe('top.corpo', 'db_iframe_bases', 'func_bases.php?funcao_js=parent.js_mostrabase004|r08_codigo|r08_descr', 'Pesquisa', true);
            } else {
                if (document.form1.base04.value != '') {
                    js_OpenJanelaIframe('top.corpo', 'db_iframe_base04', 'func_bases.php?pesquisa_chave=' + document.form1.base04.value + '&funcao_js=parent.js_mostrabase04', 'Pesquisa', false);
                } else {
                    document.form1.descr_base04.value = '';
                }
            }
        }

        function js_mostrabase04(chave, erro) {
            document.form1.descr_base04.value = chave;
            if (erro == true) {
                document.form1.base04.focus();
                document.form1.base04.value = '';
            }
        }

        function js_mostrabase004(chave1, chave2) {
            document.form1.base04.value = chave1;
            document.form1.descr_base04.value = chave2;
            db_iframe_bases.hide();
        }
        /*Ancora05*/
        function js_pesquisabase05(mostra) {
            if (mostra == true) {
                js_OpenJanelaIframe('top.corpo', 'db_iframe_bases', 'func_bases.php?funcao_js=parent.js_mostrabase005|r08_codigo|r08_descr', 'Pesquisa', true);
            } else {
                if (document.form1.base05.value != '') {
                    js_OpenJanelaIframe('top.corpo', 'db_iframe_base05', 'func_bases.php?pesquisa_chave=' + document.form1.base05.value + '&funcao_js=parent.js_mostrabase05', 'Pesquisa', false);
                } else {
                    document.form1.descr_base05.value = '';
                }
            }
        }

        function js_mostrabase05(chave, erro) {
            document.form1.descr_base05.value = chave;
            if (erro == true) {
                document.form1.base05.focus();
                document.form1.base05.value = '';
            }
        }

        function js_mostrabase005(chave1, chave2) {
            document.form1.base05.value = chave1;
            document.form1.descr_base05.value = chave2;
            db_iframe_bases.hide();
        }
        /*Ancora06*/
        function js_pesquisabase06(mostra) {
            if (mostra == true) {
                js_OpenJanelaIframe('top.corpo', 'db_iframe_bases', 'func_bases.php?funcao_js=parent.js_mostrabase006|r08_codigo|r08_descr', 'Pesquisa', true);
            } else {
                if (document.form1.base06.value != '') {
                    js_OpenJanelaIframe('top.corpo', 'db_iframe_base06', 'func_bases.php?pesquisa_chave=' + document.form1.base06.value + '&funcao_js=parent.js_mostrabase06', 'Pesquisa', false);
                } else {
                    document.form1.descr_base06.value = '';
                }
            }
        }

        function js_mostrabase06(chave, erro) {
            document.form1.descr_base06.value = chave;
            if (erro == true) {
                document.form1.base06.focus();
                document.form1.base06.value = '';
            }
        }

        function js_mostrabase006(chave1, chave2) {
            document.form1.base06.value = chave1;
            document.form1.descr_base06.value = chave2;
            db_iframe_bases.hide();
        }
        /*Ancora07*/
        function js_pesquisabase07(mostra) {
            if (mostra == true) {
                js_OpenJanelaIframe('top.corpo', 'db_iframe_bases', 'func_bases.php?funcao_js=parent.js_mostrabase007|r08_codigo|r08_descr', 'Pesquisa', true);
            } else {
                if (document.form1.base07.value != '') {
                    js_OpenJanelaIframe('top.corpo', 'db_iframe_base07', 'func_bases.php?pesquisa_chave=' + document.form1.base07.value + '&funcao_js=parent.js_mostrabase07', 'Pesquisa', false);
                } else {
                    document.form1.descr_base07.value = '';
                }
            }
        }

        function js_mostrabase07(chave, erro) {
            document.form1.descr_base07.value = chave;
            if (erro == true) {
                document.form1.base07.focus();
                document.form1.base07.value = '';
            }
        }

        function js_mostrabase007(chave1, chave2) {
            document.form1.base07.value = chave1;
            document.form1.descr_base07.value = chave2;
            db_iframe_bases.hide();
        }
        /*Ancora08*/
        function js_pesquisabase08(mostra) {
            if (mostra == true) {
                js_OpenJanelaIframe('top.corpo', 'db_iframe_bases', 'func_bases.php?funcao_js=parent.js_mostrabase008|r08_codigo|r08_descr', 'Pesquisa', true);
            } else {
                if (document.form1.base08.value != '') {
                    js_OpenJanelaIframe('top.corpo', 'db_iframe_base08', 'func_bases.php?pesquisa_chave=' + document.form1.base08.value + '&funcao_js=parent.js_mostrabase08', 'Pesquisa', false);
                } else {
                    document.form1.descr_base08.value = '';
                }
            }
        }

        function js_mostrabase08(chave, erro) {
            document.form1.descr_base08.value = chave;
            if (erro == true) {
                document.form1.base08.focus();
                document.form1.base08.value = '';
            }
        }

        function js_mostrabase008(chave1, chave2) {
            document.form1.base08.value = chave1;
            document.form1.descr_base08.value = chave2;
            db_iframe_bases.hide();
        }
        /*Ancora09*/
        function js_pesquisabase09(mostra) {
            if (mostra == true) {
                js_OpenJanelaIframe('top.corpo', 'db_iframe_bases', 'func_bases.php?funcao_js=parent.js_mostrabase009|r08_codigo|r08_descr', 'Pesquisa', true);
            } else {
                if (document.form1.base09.value != '') {
                    js_OpenJanelaIframe('top.corpo', 'db_iframe_base09', 'func_bases.php?pesquisa_chave=' + document.form1.base09.value + '&funcao_js=parent.js_mostrabase09', 'Pesquisa', false);
                } else {
                    document.form1.descr_base09.value = '';
                }
            }
        }

        function js_mostrabase09(chave, erro) {
            document.form1.descr_base09.value = chave;
            if (erro == true) {
                document.form1.base09.focus();
                document.form1.base09.value = '';
            }
        }

        function js_mostrabase009(chave1, chave2) {
            document.form1.base09.value = chave1;
            document.form1.descr_base09.value = chave2;
            db_iframe_bases.hide();
        }
        /*Ancora010*/
        function js_pesquisabase010(mostra) {
            if (mostra == true) {
                js_OpenJanelaIframe('top.corpo', 'db_iframe_bases', 'func_bases.php?funcao_js=parent.js_mostrabase0010|r08_codigo|r08_descr', 'Pesquisa', true);
            } else {
                if (document.form1.base010.value != '') {
                    js_OpenJanelaIframe('top.corpo', 'db_iframe_base010', 'func_bases.php?pesquisa_chave=' + document.form1.base010.value + '&funcao_js=parent.js_mostrabase010', 'Pesquisa', false);
                } else {
                    document.form1.descr_base010.value = '';
                }
            }
        }

        function js_mostrabase010(chave, erro) {
            document.form1.descr_base010.value = chave;
            if (erro == true) {
                document.form1.base010.focus();
                document.form1.base010.value = '';
            }
        }

        function js_mostrabase0010(chave1, chave2) {
            document.form1.base010.value = chave1;
            document.form1.descr_base010.value = chave2;
            db_iframe_bases.hide();
        }
        /*Ancora011*/
        function js_pesquisabase011(mostra) {
            if (mostra == true) {
                js_OpenJanelaIframe('top.corpo', 'db_iframe_bases', 'func_bases.php?funcao_js=parent.js_mostrabase0011|r08_codigo|r08_descr', 'Pesquisa', true);
            } else {
                if (document.form1.base011.value != '') {
                    js_OpenJanelaIframe('top.corpo', 'db_iframe_base011', 'func_bases.php?pesquisa_chave=' + document.form1.base011.value + '&funcao_js=parent.js_mostrabase011', 'Pesquisa', false);
                } else {
                    document.form1.descr_base011.value = '';
                }
            }
        }

        function js_mostrabase011(chave, erro) {
            document.form1.descr_base011.value = chave;
            if (erro == true) {
                document.form1.base011.focus();
                document.form1.base011.value = '';
            }
        }

        function js_mostrabase0011(chave1, chave2) {
            document.form1.base011.value = chave1;
            document.form1.descr_base011.value = chave2;
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
                <td nowrap align="right">
                    <strong>Data:</strong>
                </td>
                <td>
                    <?
                    db_inputdata('daterel', @$daterel_dia, @$daterel_mes, @$daterel_ano, true, 'text', $db_opcao, "")
                    ?>
                    &nbsp;</b>
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
                    db_input('base02', 4, @$base01, true, 'text', @$db_opcao, "onchange='js_pesquisabase02(false)'");
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
                    db_input('base03', 4, @$base01, true, 'text', @$db_opcao, "onchange='js_pesquisabase03(false)'");
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
                    db_input('base04', 4, @$base01, true, 'text', @$db_opcao, "onchange='js_pesquisabase04(false)'");
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
                    db_input('base05', 4, @$base01, true, 'text', @$db_opcao, "onchange='js_pesquisabase05(false)'");
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
                    db_input('base06', 4, @$base01, true, 'text', @$db_opcao, "onchange='js_pesquisabase06(false)'");
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
                    db_input('base07', 4, @$base01, true, 'text', @$db_opcao, "onchange='js_pesquisabase07(false)'");
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
                    db_input('base08', 4, @$base01, true, 'text', @$db_opcao, "onchange='js_pesquisabase08(false)'");
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
                    db_input('base09', 4, @$base01, true, 'text', @$db_opcao, "onchange='js_pesquisabase09(false)'");
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
                    db_input('base010', 4, @$base01, true, 'text', @$db_opcao, "onchange='js_pesquisabase010(false)'");
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
                    db_input('base011', 4, @$base01, true, 'text', @$db_opcao, "onchange='js_pesquisabase011(false)'");
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
</body>

</html>