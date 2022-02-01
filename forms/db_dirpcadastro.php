<?
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

require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_libdicionario.php");
require_once("libs/db_libcontabilidade.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_classesgenericas.php");
require_once("classes/db_conparametro_classe.php");

$GsTitulo        = 't';
$NsFuncionamento = 'style="background-color:#E6E4F1;"';
$NsFuncao        = 'style="background-color:#E6E4F1;"';

$oEstruturaSistema = new cl_estrutura_sistema();
$iOpcao = 1;
?>
<html>

<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <?
        db_app::load("scripts.js");
        db_app::load("prototype.js");
        db_app::load("datagrid.widget.js");
        db_app::load("strings.js");
        db_app::load("estilos.css");
        db_app::load("AjaxRequest.js");
        db_app::load("widgets/windowAux.widget.js");
    ?>
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <style>
        textarea {
            width: 100%;
        }
    </style>
</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1">
    <form name="form1" id='form1'>
        <center>
            <br />
            <fieldset style="width: 800;">
                <legend><b>Informçõaes Previdenciárias - DIPR</b></legend>
                <table border="0" width="800;">
                    <tr>
                        <td><b>O ente possui segregção da massa instituída por lei?:</b></td>
                        <td>
                            <?php
                            $aSegregacaoLei = array(0 => "Selecione", 1 => "Sim", 2 => "No");
                            db_select('segregacaolei', $aSegregacaoLei, true, 1, "");
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td><b>O município possui beneficiários custeados com recursos do tesouro?:</b></td>
                        <td>
                            <?php
                            $aBeneficiarioTesouro = array(0 => "Selecione", 1 => "Sim", 2 => "No");
                            db_select('beneficiariotesouro', $aBeneficiarioTesouro, true, 1, "");
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td><b>Número do ato normativo:</b></td>
                        <td>
                            <?php
                            db_input("atonormativo", 11, "0", true, "text", $db_opcao, "", "", "", "", 6);
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td><b>Exercício do ato normativo:</b></td>
                        <td>
                            <?php
                            db_input("atonormativo", 11, "0", true, "text", $db_opcao, "", "", "", "", 4);
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td nowrap>
                            <?
                                db_ancora("CGM do Ente", "js_pesquisac236_numcgm(true);", $db_opcao);
                            ?>
                        </td>
                        <td>
                            <?
                            db_input('c236_numcgm', 11, $Ic236_numcgm, true, 'text', $db_opcao, " onchange='js_pesquisac236_numcgm(false);'");
                            db_input('z01_nome', 40, $Iz01_nome, true, 'text', 3, '', "z01_nome1");
                            ?>
                        </td>
                    </tr>

                    <tr>
                        <td><b>Tipo Orgão:</b></td>
                        <td>
                            <?php
                            $aTipoOrgao = array(
                                0 => "Selecione",
                                1 => "Administração Direta Executivo",
                                2 => "Administração Direta Legislativo",
                                3 => "Unidade Gestora"
                            );
                            db_select('beneficiariotesouro', $aTipoOrgao, true, 1, "");
                            ?>
                        </td>
                    </tr>
                </table>
            </fieldset>
            <br>
            <input type="button" name="btnIncluir" id="btnIncluir" value="Incluir" />
            &nbsp;
            <input type="button" name="btnPesquisar" id="btnPesquisar" value="Pesquisar" />
        </center>
    </form>
</body>

</html>

<script>
    function js_pesquisac236_numcgm(mostra) {
        let anousu = "<?= db_getsession('DB_anousu') ?>";

        if (mostra == true) {
            js_OpenJanelaIframe('top.corpo.db_iframe_numcgm', 'db_iframe_cgm', 'func_nome.php?funcao_js=top.corpo.iframe_pcfornereprlegal.js_mostracgm1|z01_numcgm|z01_nome', 'Pesquisa', true, 0);
        } else {
            if (document.form1.c236_numcgm.value != '') {
                js_OpenJanelaIframe('top.corpo.db_iframe_numcgm', 'db_iframe_cgm', 'func_nome.php?pesquisa_chave=' + document.form1.pc81_cgmresp.value + '&funcao_js=top.corpo.iframe_pcfornereprlegal.js_mostracgm', 'Pesquisa', false);
            } else {
                document.form1.z01_nome1.value = '';
            }
        }
    }

    function js_mostracgm(erro, chave) {
        document.form1.z01_nome1.value = chave;
        if (erro == true) {
            document.form1.c236_numcgm.focus();
            document.form1.c236_numcgm.value = '';
        }
    }

    function js_mostracgm1(chave1, chave2) {
        document.form1.c236_numcgm.value = chave1;
        document.form1.z01_nome1.value = chave2;
        db_iframe_cgm.hide();
    }

    function js_pesquisa() {
        js_OpenJanelaIframe('top.corpo', 'db_iframe_numcgm', 'func_pcfornereprlegal.php?funcao_js=parent.js_preenchepesquisa|pc81_sequencia', 'Pesquisa', true);
    }

    function js_preenchepesquisa(chave) {
        db_iframe_numcgm.hide();
        <?
        if ($db_opcao != 1) {
            echo " location.href = '" . basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]) . "?chavepesquisa='+chave";
        }
        ?>
    }
</script>