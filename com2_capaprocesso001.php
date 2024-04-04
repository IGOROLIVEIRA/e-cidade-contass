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

require_once ("libs/db_stdlib.php");
require_once ("libs/db_conecta.php");
require_once ("libs/db_sessoes.php");
require_once ("libs/db_usuariosonline.php");
require_once ("dbforms/db_funcoes.php");

$clrotulo = new rotulocampo;
$clrotulo->label("pc80_resumo");
$clrotulo->label("pc80_codproc");
?>
<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC >

<center>
    <div style="margin-top: 20px">
        <form name="form1" method="post">
            <fieldset style="width: 550;">
                <legend><strong>Imprimir Capa de Processo</strong></legend>
                <table >
                    <tr>
                        <td  align="left" nowrap title="<?=$Tpc10_numero?>"> <b>
                                <? db_ancora("Processos de Compra de : ","js_pesquisaProcessoCompras(true, true);",1);?>
                        </td>
                        <td align="left" nowrap>
                            <?
                            db_input("pc80_codproc", 10, $Ipc80_codproc,
                                true,
                                "text",
                                4,
                                "onchange='js_pesquisaProcessoCompras(false, true);'",
                                "pc80_codprocini"
                            );
                            ?>
                            </b>
                        </td>

                        <td  align="left" nowrap title="<?=$Tpc10_numero?>">
                            <? db_ancora("<b>Até:</b> ","js_pesquisaProcessoCompras(true, false);",1);?>
                        </td>
                        <td align="left" nowrap>
                            <?
                            db_input("pc80_codproc",10,$Ipc80_codproc, true,
                                "text", 4,
                                "onchange='js_pesquisaProcessoCompras(false, false);'",
                                "pc80_codprocfim");
                            ?>
                        </td>
                    </tr>
                </table>
            </fieldset>
            <br>
            <input name="processar" type="button" onclick='js_emite();'  value="Emitir">
        </form>
    </div>
</center>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
<script>
    function js_emite() {
        let pc80_codprocini = document.form1.pc80_codprocini.value;
        let pc80_codprocfim = document.form1.pc80_codprocfim.value;

        if (document.form1.pc80_codprocini.value != "") {
            query = 'pc80_codprocini='+pc80_codprocini;
            query += '&pc80_codprocfim='+pc80_codprocfim;
            window.open('com2_capaprocesso002.php?'+query,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
        }
    }
    function js_pesquisaProcessoCompras(mostra, lInicial) {

        var sFuncaoRetorno         = 'js_mostraProcessoInicial';
        var sFuncaoRetornoOnChange = 'js_mostraProcessoInicialChange';
        var sCampo                 = 'pc80_codprocini';
        if (!lInicial) {

            var sFuncaoRetorno         = 'js_mostraProcessoFinal';
            var sFuncaoRetornoOnChange = 'js_mostraProcessoFinalChange';
            var sCampo                 = 'pc80_codprocfim';
        }

        if (mostra) {
            js_OpenJanelaIframe('CurrentWindow.corpo',
                'db_iframe_processo',
                'func_pcproc.php?funcao_js=parent.'+sFuncaoRetorno+'|'+
                'pc80_codproc','Pesquisa Processo de Compras',true);
        } else {

            var sValorCampo = $F(sCampo);
            if (sValorCampo != '') {
                js_OpenJanelaIframe('CurrentWindow.corpo',
                    'db_iframe_processo',
                    'func_pcproc.php?pesquisa_chave='+sValorCampo+
                    '&funcao_js=parent.'+sFuncaoRetornoOnChange,
                    'Pesquisa Processo de Compras',
                    false);
            } else {
                $F(sCampo).value = '';
            }
        }
    }

    function js_mostraProcessoInicial(iProcesso) {

        $('pc80_codprocini').value = iProcesso;
        db_iframe_processo.hide();
    }

    function js_mostraProcessoInicialChange(iProcesso, lErro) {

        if (lErro) {
            $('pc80_codprocini').value = '';
        }
    }

    function js_mostraProcessoFinal(iProcesso) {

        db_iframe_processo.hide();
        $('pc80_codprocfim').value = iProcesso;
    }

    function js_mostraProcessoFinalChange(iProcesso, lErro) {

        if (lErro) {
            $('pc80_codprocfim').value = '';
        }
    }

</script>
</body>
</html>
