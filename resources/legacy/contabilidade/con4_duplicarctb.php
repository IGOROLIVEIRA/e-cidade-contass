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
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
$clrotulo = new rotulocampo;
$clrotulo->label("e60_codemp");

?>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <?php
        db_app::load("scripts.js, prototype.js, datagrid.widget.js, messageboard.widget.js, dbtextField.widget.js");
        db_app::load("windowAux.widget.js, strings.js,dbtextFieldData.widget.js");
        db_app::load("classes/infoLancamentoContabil.classe.js");
        db_app::load("grid.style.css, estilos.css");
        ?>
        <style>
            .temdesconto {background-color: #D6EDFF}
        </style>
    </head>
    <body bgcolor="#CCCCCC">
    <?php
    if (db_getsession("DB_id_usuario") != 1) {

        echo "<br><center><br><H2>Essa rotina apenas poderá ser usada pelo usuario dbseller</h2></center>";
    } else {
    ?>

    <form name='form1'>
        <div class="container">
            <fieldset>
                <legend><b>Copiar Contas CTB</b></legend>
                <table>
                    <tr>

                    </tr>
                </table>
            </fieldset>
            <input type="button" id='btnVisualizar' value='Visualizar Contas' onclick="js_visualizarContas();">
        </div>
    </form>


    </body>
    </html>
    <div style='position:absolute;top: 200px; left:15px;
            border:1px solid black;
            width:400px;
            text-align: left;
            padding:3px;
            z-index:10000;
            background-color: #FFFFCC;
            display:none;' id='ajudaItem'>

    </div>
    <script>
        sUrlRPC = 'con4_duplicarctb.RPC.php';

        function js_visualizarContas() {

            oWindowContas  = new windowAux('wndContas', 'Contas do Tipo Aplicação', screen.availWidth - 20, '800');
            sContent            = "<div style='text-align:center;padding:2px'>";
            sContent           += "<fieldset style='text-align:center'><legend><b>Contas</b></legend>";
            sContent           += "<div style='width:100%' id='ctnDataGrid'>";
            sContent           += "</div>";
            sContent           += "</fieldset>";
            sContent           += "<input type='button' accessky='s' id='btnCopiar' value='Salvar' onclick='js_copiar()'> ";
            sContent           += "</div>";
            oWindowContas.setContent(sContent);
            oWindowContas.show(25,0);
            oMessage   = new messageBoard('msgboard1',
                'Encerramento de conta aplicação apenas no sicom de 01/2018 ',
                'Selecione as contas.',
                $("windowwndContas_content"));
            oMessage.show();
            oWindowContas.setShutDownFunction(function (){

                oWindowContas.destroy();
            });
            /*
             *Monta a Grid;
             */
            oGridContas = new DBGrid('gridContas');
            oGridContas.nameInstance = 'oGridContas';
            oGridContas.setCheckbox(0);
            oGridContas.setHeight((oWindowContas.getHeight()/2)-30);
            oGridContas.setCellWidth(new Array('5%','5%','5%', '10%',"45%","10%",'10%','10%'));
            oGridContas.setCellAlign(new Array("center","center", "center","center","left", "center", "center","center"));
            oGridContas.setHeader(new Array('CodCon','Reduz','CodCtb', 'Conta','Descrição','Tipo Aplic. Anterior', 'Tipo APlic. Novo','Tipo Intistuição'));
            oGridContas.allowSelectColumns(true);

            oGridContas.show($('ctnDataGrid'));
            oGridContas.resizeCols();

            js_getContas();



        }

        function js_getContas() {


            var oParam     = new Object();
            oParam.exec    = "getContas";
            js_divCarregando('Aguarde, processando arquivos','msgBox');
            var oAjax      = new Ajax.Request(sUrlRPC,
                {
                    method: "post",
                    parameters:'json='+Object.toJSON(oParam),
                    onComplete: js_retornoGetContas
                });
        }


        function js_retornoGetContas(oAjax) {
            js_removeObj('msgBox');
            var oRetorno = eval("("+oAjax.responseText+")");
            oGridContas.clearAll(true);
            if (oRetorno.status == 1) {

                for (var i = 0; i < oRetorno.contas.length; i++) {

                    var lBloqueia = false;
                    var lChecked = false;
                    with(oRetorno.contas[i]) {

                        var aLinha = new Array();
                        aLinha[0]  = codcon;
                        aLinha[1]  = reduz;
                        aLinha[2]  = codctb;
                        aLinha[3]  = conta;
                        aLinha[4]  = descricao.urlDecode();
                        aLinha[5]  = tpaplicanterior;
                        aLinha[6]  = tpaplicnovo;
                        aLinha[7]  = tipoinstit;
                        lChecked = si95_reduz == "" ? false : true;
                        oGridContas.addRow(aLinha, false, lBloqueia,lChecked);

                    }
                }
                oGridContas.renderRows();
            }
            if (oRetorno.aviso != "") {

                oMessage.setHelp("<span style='color:red'>"+oRetorno.aviso.urlDecode()+"</span>");
                alert(oRetorno.aviso.urlDecode());

            }

        }

        function js_copiar() {


            var sMsgConfirma  = "Você está executando a copia de conta aplicação. ";
            sMsgConfirma     += "Será criada uma nava conta os mesmos campos exceto o tipo de aplicação apenas para o sicom de 01/2018.";
            sMsgConfirma     += "A conta selecionada será finalizada e o saldo transferido para a nova conta.";
            sMsgConfirma     += "Você realmente tem certeza de que deseja confirmar a operação?";
            if (!confirm(sMsgConfirma)) {
                return false;
            }
            var aSelecionados = oGridContas.getSelection("object");


            if (aSelecionados.length == 0) {

                alert('Nenhuma conta selecionada.');
                return false;
            }
            var oParam      = new Object();
            oParam.exec     = 'processarAlteracao';

            var contas = new Array();

            aSelecionados.each(function (oElemento){
                var conta          = new Object();
                conta.reduz        = oElemento.aCells[2].getValue();
                conta.codtceantigo = oElemento.aCells[3].getValue();
                contas.push(conta);
            });
            oParam.contas = contas;
            js_divCarregando('Aguarde, ','msgBox');

            var oAjax       = new Ajax.Request(sUrlRPC,
                {
                    method: "post",
                    parameters:'json='+Object.toJSON(oParam),
                    onComplete: js_retornoCopiar
                });
        }

        function js_retornoCopiar(oAjax) {

            js_removeObj('msgBox');
            var oRetorno = eval("("+oAjax.responseText+")");
            if (oRetorno.status == 2) {
                alert(oRetorno.message.urlDecode().replace(/\\n/g,'\n'));
            } else {

                alert('Contas registradas com sucesso!');
            }
        }

    </script>
    <?
}
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>