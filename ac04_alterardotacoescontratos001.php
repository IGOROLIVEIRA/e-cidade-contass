<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2013  DBselller Servicos de Informatica
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
include_once("libs/db_sessoes.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_utils.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("dbforms/db_classesgenericas.php");
$clrotulo = new rotulocampo;
$clrotulo->label("ac16_sequencial");
$clrotulo->label("ac16_resumoobjeto");
?>

<html>

<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <?
    db_app::load("scripts.js, strings.js, prototype.js, datagrid.widget.js");
    db_app::load("widgets/dbmessageBoard.widget.js, widgets/windowAux.widget.js, datagrid.widget.js");
    db_app::load("estilos.css, grid.style.css");
    ?>
</head>

<body style="background-color: #cccccc; margin-top: 35px">
    <center>
        <div style="display: table; margin-top:0.8rem;" id='alterar-dotacoes-contratos'>
            <fieldset>
                <legend><b>Alterar Dotações de Contratos</legend>
                <table>
                    <tr>
                        <td nowrap align="right"><strong>Ano origem:</strong>
                        <td nowrap>
                            <?php
                            db_input('iAnoOrigem',6,'',true,'text',3);
                            ?><strong>Ano destino:</strong>
                            <?php
                            db_input('iAnoDestino',6,'',true,'text',3);
                            ?>
                        </td>
                    </tr>
                </table>
            </fieldset>
        </div>
        <input style='margin-top: 10px;' type="button" name='Processar' value='Processar' onclick="alterarDotacoes();">
    </center>
</body>

</html>
<?php
db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit"));
?>

<script type="text/javascript">
    const iAnoOrigem = document.getElementById("iAnoOrigem");
    const iAnoDestino = document.getElementById("iAnoDestino");
    let anoDestino = "<?php echo db_getsession('DB_anousu') + 1; ?>";
    const codigoInstituicao = "<?php echo db_getsession('DB_instit'); ?>";

    iAnoOrigem.value = "<?php echo db_getsession('DB_anousu'); ?>";
    iAnoDestino.value = anoDestino;

    function alterarDotacoes() {
        let oParametros = {};
        oParametros.anoOrigem = $F('iAnoOrigem');
        oParametros.anoDestino = anoDestino;
        oParametros.codigoInstituicao = codigoInstituicao;
        js_divCarregando('Aguarde, Atualizando leituras...<br>Esse procedimento pode levar algum tempo.', 'msgBox');
        new Ajax.Request('ac04_alteradotacoescontratos.RPC.php', {
            method: 'post',
            parameters: 'json=' + Object.toJSON(oParametros),
            onComplete: function(oResponse) {
                const oRetorno = eval("(" + oResponse.responseText + ")");
                js_removeObj('msgBox');
                if (oRetorno.status === 1) {
                    alert(oRetorno.message.urlDecode());
                    if (oRetorno.naoEncontrado === false) {
                        setTimeout(function(){
                            js_emite();
                        }, 25000);
                    }
                } else {
                    alert(oRetorno.message.urlDecode());
                }
            }
        });
    }

    function js_emite() {
        const query = 'anoOrigem=' + $F('iAnoOrigem') + '&anoDestino=' + anoDestino + '&codigoInstituicao=' + codigoInstituicao;

        jan = window.open('ac04_alterardotacoescontratos002.php?' + query, '', 'width=' + (screen.availWidth - 5) + ',height=' + (screen.availHeight - 40) + ',scrollbars=1,location=0 ');
        jan.moveTo(0, 0);
    }
</script>
