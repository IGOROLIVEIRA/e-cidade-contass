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
require_once("dbforms/db_classesgenericas.php");
include("dbforms/db_funcoes.php");
$aux = new cl_arquivo_auxiliar;
$clrotulo = new rotulocampo;
$clrotulo->label("k17_codigo");
db_postmemory($HTTP_POST_VARS);
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="document.form1.k17_codigo_de.focus();" bgcolor="#cccccc">
    <table valign="top" marginwidth="0" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr><td>&nbsp;</td></tr>
        <tr><td>&nbsp;</td></tr>
        <tr>
            <td align="center" valign="top">
                <form name='form1'>
                    <fieldset>
                        <legend><b>Reemissão de Slip</b></legend>
                        <table border='0'>
                            <tr height="20px"><td></td></tr>
                            <tr>
                                <td nowrap>
                                    <?
                                        // $aux = new cl_arquivo_auxiliar;
                                        $aux->cabecalho      = "<strong>CGM</strong>";
                                        $aux->codigo         = "z01_numcgm"; //chave de retorno da func
                                        $aux->descr          = "z01_nome";   //chave de retorno
                                        $aux->nomeobjeto     = 'lista';
                                        $aux->funcao_js      = 'js_mostra';
                                        $aux->funcao_js_hide = 'js_mostra1';
                                        $aux->sql_exec       = "";
                                        $aux->func_arquivo   = "func_nome.php";  //func a executar
                                        $aux->isfuncnome     = true;
                                        $aux->nomeiframe     = "db_iframe_cgm";
                                        $aux->localjan       = "";
                                        $aux->onclick        = "";
                                        $aux->db_opcao       = 2;
                                        $aux->tipo           = 2;
                                        $aux->top            = 0;
                                        $aux->linhas         = 10;
                                        $aux->vwhidth        = 400;
                                        $aux->funcao_gera_formulario();
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td nowrap title="<?=$Tk17_codigo?>"><? db_ancora("<b>Slip</b>", "js_pesquisak17_codigo_de(true);", 1); ?></td>
                                <td nowrap>
                                    <? db_input("k17_codigo_de", 15, $Ik17_codigo, true, "text", 4, "onchange='js_pesquisak17_codigo_de(false);'"); ?>
                                    <? db_ancora("<b>à</b>", "js_pesquisak17_codigo_ate(true);", 1); ?>
                                    <? db_input("k17_codigo_ate", 15, $Ik17_codigo, true, "text", 4, "onchange='js_pesquisak17_codigo_ate(false);'", "k17_codigo_ate"); ?>
                                </td>
                            </tr>
                            <tr>
                                <td><strong> Período:</strong></td>
                                <td>
                                    <? db_inputdata('dtini', @$dia, @$mes, @$ano, true, 'text', 1, ""); ?>
                                    à
                                    <? db_inputdata('dtfim', @$dia, @$mes, @$ano, true, 'text', 1, ""); ?>
                                </td>
                            </tr>
                            <tr height="20px">
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="4" align="center">
                                    <input name="relatorio" type="button" onclick='js_abre();' value="Imprimir">
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                </form>
            </td>
        </tr>
    </table>
</center>
<? db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit")); ?>
<script>
    var k17_codigo_de  = document.form1.k17_codigo_de;
    var k17_codigo_ate = document.form1.k17_codigo_ate;
    var t52_descr      = document.form1.t52_descr;
    var dtini          = document.form1.dtini;
    var dtfim          = document.form1.dtfim;
    var lista          = document.form1.lista;
    //--------------------------------
    function js_pesquisak17_codigo_de(mostra){
        if (mostra == true) {
            js_OpenJanelaIframe('top.corpo', 'db_iframe_slip', 'func_slip.php?funcao_js=parent.js_mostraslip1_de|k17_codigo', 'Pesquisa', true);
        } else {
            if (k17_codigo_de != '') {
                js_OpenJanelaIframe('top.corpo', 'db_iframe_slip', 'func_slip.php?pesquisa_chave=' + k17_codigo_de.value + '&funcao_js=parent.js_mostraslip_de','Pesquisa', false);
            } else {
                t52_descr.value = '';
            }
        }
    }

    function js_pesquisak17_codigo_ate(mostra){
        if (mostra == true) {
            js_OpenJanelaIframe('top.corpo', 'db_iframe_slip', 'func_slip.php?funcao_js=parent.js_mostraslip1_ate|k17_codigo', 'Pesquisa', true);
        } else {
            if (k17_codigo_ate != '') {
                js_OpenJanelaIframe('top.corpo', 'db_iframe_slip', 'func_slip.php?pesquisa_chave=' + k17_codigo_ate.value + '&funcao_js=parent.js_mostraslip_ate','Pesquisa', false);
            } else {
                t52_descr.value = '';
            }
        }
    }

    function js_mostraslip_de(chave, erro) {
        if (erro == true) {
            k17_codigo_de.focus();
            k17_codigo_de.value = '';
        }
    }

    function js_mostraslip_ate(chave, erro) {
        if (erro == true) {
            k17_codigo_ate.focus();
            k17_codigo_ate.value = '';
        }
    }

    function js_mostraslip1_de(chave1) {
        k17_codigo_de.value = chave1;
        db_iframe_slip.hide();
    }

    function js_mostraslip1_ate(chave1) {
        k17_codigo_ate.value = chave1;
        db_iframe_slip.hide();
    }

    function trata_data(data) {
        var dataFinal = data.split("/");
        return dataFinal[2] + "-" + dataFinal[1] + "-" + dataFinal[0];
    }

    function js_abre() {
        var query = "";
        var error = false;

        if (k17_codigo_de.value == "" && (dtini.value == '' && dtfim.value == '') && lista.length == 0) {
            k17_codigo_de.style.backgroundColor='#99A9AE';
            k17_codigo_de.focus();
            alert("Informe o código Slip, CGM ou um período");
            error = true;
        } else {
            if (k17_codigo_de.value != "")
                query += "numslip_de=" + k17_codigo_de.value;
            if ((dtini.value != '')) {
                if (k17_codigo_de.value != "")
                    query += "&";
                query += "dtini=" + trata_data(dtini.value);
            }
            if (dtfim.value != '') {
                if (k17_codigo_de.value != "" || dtini != "")
                    query += "&";
                query += "dtfim=" + trata_data(dtfim.value);
            }
            var vir      = "";
            var listacgm = "";

            for (x = 0; x < lista.length; x++) {
                listacgm += vir + lista.options[x].value;
                vir       = ",";
            }

            query += "&listacgm=" + listacgm;
        }

        if (k17_codigo_de.value != "" && k17_codigo_ate.value != "" && !error) {
            if (Number(k17_codigo_de.value) > Number(k17_codigo_ate.value)) {
                alert("Slip inicial maior que a slip final. Verifique!");
                k17_codigo_ate.value = "";
                error = true;
            } else {
                query += "&numslip_ate=" + k17_codigo_ate.value;
            }
        } else {
            if (k17_codigo_de.value != "")
               query += "&numslip_ate=" + k17_codigo_de.value;
        }

        if (!error) {
            jan = window.open('cai1_slip003.php?' + query, '', 'width=' + (screen.availWidth - 5) + ', height=' + (screen.availHeight - 40) +', scrollbars=1,location=0');
            jan.moveTo(0,0);
            k17_codigo_de.style.backgroundColor = '';
        }
    }
    //--------------------------------
</script>
</body>
</html>
