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

require_once "libs/db_stdlib.php";
require_once "libs/db_conecta.php";
require_once "libs/db_sessoes.php";
require_once "libs/db_usuariosonline.php";
require_once "dbforms/db_funcoes.php";

?>
<html>
  <head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/AjaxRequest.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/widgets/windowAux.widget.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/datagrid.widget.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/widgets/dbmessageBoard.widget.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <style type="text/css">

      .item-encerramento {
        margin-bottom: 10px !important;
        display: block;
      }
    </style>
  </head>
  <body class="body-default">
    <div class="container">
      <form name="form1" method="post" action="">
        <fieldset>
          <legend>Encerramento do Exercício</legend>
          <table>
            <tr>
              <td>
                <label class="bold" id="lbl_data" for="data">Data para os Lançamentos:</label>
              </td>
              <td>
                <?php db_inputdata("data", '31', '12', db_getsession("DB_anousu"), true, 'text', 1);  ?>
              </td>
            </tr>
          </table>

          <fieldset class="separator item-encerramento">
            <legend>Inscrição dos Restos a Pagar</legend>

            <div class="text-left">
              <input name="processar_rp" type="button" id="processar_rp" value="Processar"/>
              <input name="desprocessar_rp" type="button" id="desprocessar_rp" value="Cancelar"/>
            </div>
          </fieldset>

          <fieldset class="separator item-encerramento">
            <legend>Encerramento das Variações Patrimoniais</legend>

            <div class="text-left">
              <input name="processar_variacoes" type="button" id="processar_variacoes" value="Processar"/>
              <input name="desprocessar_variacoes" type="button" id="desprocessar_variacoes" value="Cancelar"/>
            </div>
          </fieldset>

          <fieldset class="separator item-encerramento">
            <legend>Natureza Orçamentária e Controle</legend>

            <div class="text-left">
              <input name="processar_natureza" type="button" id="processar_natureza" value="Processar"/>
              <input name="desprocessar_natureza" type="button" id="desprocessar_natureza" value="Cancelar"/>
              <input name="regras_natureza" type="button" id="regras_natureza" value="Regras"/>
            </div>
          </fieldset>

        </fieldset>

        <div id="contentRegras" style="display: none;">
          <table style="width: 650px; margin: 0 auto;">
            <tr>
              <td>
                <fieldset>
                  <legend>Regras de Encerramento das Naturezas Orçamentárias e Controle</legend>
                  <table>
                    <tr>
                      <td>
                        <label class="bold" for="contadevedora" id="lbl_contadevedora">Conta Devedora:</label>
                      </td>
                      <td>
                        <?php
                          $Scontadevedora = "Conta Devedora";
                          db_input('contadevedora', 15, 1, true, "text", 1, '', '', '', '', 15);
                        ?>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <label class="bold" for="contacredora" id="lbl_contacredora">Conta Credora:</label>
                      </td>
                      <td>
                        <?php
                          $Scontacredora = "Conta Credora";
                          db_input('contacredora', 15, 1, true, "text", 1, '', '', '', '', 15);
                        ?>
                      </td>
                    </tr>
                  </table>
                </fieldset>
              </td>
            </tr>

            <tr>
              <td class="text-center">
                <input name="incluir_regra" type="button" id="incluir_regra" value="Incluir"/>
              </td>
            </tr>

            <tr>
              <td>
                <fieldset>
                  <legend>Regras de Encerramento Cadastradas</legend>
                  <div id="gridRegras"></div>
                </fieldset>
              </td>
            </tr>
          </table>
        </div>

      </form>
    </div>
    <?php db_menu( db_getsession("DB_id_usuario"),
                   db_getsession("DB_modulo"),
                   db_getsession("DB_anousu"),
                   db_getsession("DB_instit") ); ?>

    <script type="text/javascript">

      ;(function(exports) {

        const RPC = "con4_processaencerramentopcasp.RPC.php";
        const MENSAGEM = "financeiro.contabilidade.con4_processaencerramentopcasp.";

        var oButtons = {
          RestosPagar : {
            processar : $('processar_rp'),
            desprocessar : $('desprocessar_rp')
          },
          Variacoes : {
            processar : $('processar_variacoes'),
            desprocessar : $('desprocessar_variacoes')
          },
          Natureza : {
            processar : $('processar_natureza'),
            desprocessar : $('desprocessar_natureza'),
            regras : $('regras_natureza')
          }
        },
        oRegra = {
          salvar : $('incluir_regra'),
          contacredora : $('contacredora'),
          contadevedora : $('contadevedora')
        },
        oData = $('data'),
        oGridRegras = new DBGrid("gridRegras"),
        oContentRegras = $('contentRegras'),
        oWindowRegras = null,
        oEncerramentos = {
          'rp' : "dos Restos a Pagar",
          'vp' : "das Variações Patrimoniais",
          'no' : "das Naturezas Orçamentárias e Controle"
        }

        oGridRegras.nameInstance = "oGridRegras";
        oGridRegras.setCellWidth(["40%", "40%", "20%"]);
        oGridRegras.setCellAlign(["left", "left", "center"]);
        oGridRegras.setHeader(["Devedora", "Credora", "Ação"]);

        function verificarEncerramentos() {

          /**
           * Bloqueia todos os encerramentos
           */
          oButtons.RestosPagar.processar.disabled = true;
          oButtons.RestosPagar.desprocessar.disabled = true;

          oButtons.Variacoes.processar.disabled = true;
          oButtons.Variacoes.desprocessar.disabled = true;

          oButtons.Natureza.processar.disabled = true;
          oButtons.Natureza.desprocessar.disabled = true;

          /**
           * Verifica quais os encerramentos já foram realizados
           */
          new AjaxRequest(RPC, {sExecucao : "encerramentosRealizados"}, function(oRetorno, lErro) {

            if (lErro) {
              alert(oRetorno.sMessage.urlDecode());
              return false;
            }

            if (oRetorno.aEncerramentos.rp) {
              oButtons.RestosPagar.desprocessar.disabled = false;

              if (oRetorno.aEncerramentos.vp) {
                oButtons.RestosPagar.desprocessar.disabled = true;
                oButtons.Variacoes.desprocessar.disabled   = false;

                if (oRetorno.aEncerramentos.no) {
                  oButtons.RestosPagar.desprocessar.disabled = true;
                  oButtons.Variacoes.desprocessar.disabled   = true;
                  oButtons.Natureza.desprocessar.disabled    = false;

                } else {
                  oButtons.Natureza.processar.disabled = false;
                }

              } else {
                oButtons.Variacoes.processar.disabled = false;
              }

            } else {
              oButtons.RestosPagar.processar.disabled = false;
            }

          }).setMessage("Aguarde, verificando encerramentos...").execute();
        }

        /**
         * Efetua o processamento
         */
        function encerrar(sTipo) {

          if (empty(oData.value)) {
            alert( _M(MENSAGEM + "campo_obrigatorio", {sCampo : "Data para os Lançamentos"}) );
            return false;
          }

          if (!confirm( _M(MENSAGEM + "confirmar_processamento", {sEncerramento : oEncerramentos[sTipo]})) ) {
            return false;
          }

          var oParametros = {
            sExecucao : "processarEncerramento",
            sTipo : sTipo,
            sData : oData.value
          }

          new AjaxRequest(RPC, oParametros, function(oRetorno, lErro) {

            if (lErro) {
              alert(oRetorno.sMessage.urlDecode());
              return false;
            }

            alert( _M(MENSAGEM + "encerrado_sucesso") );

            verificarEncerramentos();
          }).setMessage("Aguarde, efetuando encerramento...").execute();
        }

        /**
         * efetua o desprocesamento
         */
        function cancelarEncerramento(sTipo) {

          var oParametros = {
            sExecucao : "desprocessarEncerramento",
            sTipo : sTipo
          }

          if (!confirm( _M(MENSAGEM + "confirmar_cancelamento", {sEncerramento : oEncerramentos[sTipo]})) ) {
            return false;
          }

          new AjaxRequest(RPC, oParametros, function(oRetorno, lErro) {

            if (lErro) {
              alert(oRetorno.sMessage.urlDecode());
              return false;
            }

            alert( _M(MENSAGEM + "cancelado_sucesso") );

            verificarEncerramentos();
          }).setMessage("Aguarde, efetuando cancelamento...").execute();
        }

        /**
         * Seta os Eventos
         */
        oButtons.RestosPagar.processar.observe('click', function() {
          encerrar('rp');
        });

        oButtons.RestosPagar.desprocessar.observe('click', function() {
          cancelarEncerramento('rp');
        });

        oButtons.Variacoes.processar.observe('click', function() {
          encerrar('vp');
        });

        oButtons.Variacoes.desprocessar.observe('click', function() {
          cancelarEncerramento('vp');
        });

        oButtons.Natureza.processar.observe('click', function() {
          encerrar('no');
        });

        oButtons.Natureza.desprocessar.observe('click', function() {
          cancelarEncerramento('no');
        });

        function removerRegra(iRegra) {

          if (!confirm( _M(MENSAGEM + "confirma_exclui_regra") )) {
            return false;
          }

          var oParametros = {
            sExecucao : "removerRegra",
            iCodigoRegra : iRegra
          }

          new AjaxRequest(RPC, oParametros, function(oRetorno, lErro) {

            if (lErro) {
              alert(oRetorno.sMessage.urlDecode());
              return false;
            }

            alert( _M(MENSAGEM + "excluido_sucesso") );
            carregarRegras();

          }).setMessage("Aguarde, excluindo regra...").execute();
        }

        /**
         * Carrega a grid das regras
         */
        function carregarRegras() {

          var oParametros = {
            sExecucao : "buscarRegras"
          }

          oGridRegras.clearAll(true);

          new AjaxRequest(RPC, oParametros, function(oRetorno, lErro) {

            if (lErro) {
              alert(oRetorno.sMessage.urlDecode());
              return false;
            }

            oRetorno.aRegras.each(function(oItem) {
              oGridRegras.addRow([ oItem.c117_contadevedora,
                                   oItem.c117_contacredora,
                                   '<input type="button" name="remover' + oItem.c117_sequencial + '" id="remover' + oItem.c117_sequencial
                                   + '" onclick="removerRegra(' + oItem.c117_sequencial + ')" value="E" title="Excluir"/>' ]);
            });

            oGridRegras.renderRows();

          }).setMessage("Aguarde, Carregando regras...").execute();
        }

        /**
         * Abre a janela das regras
         */
        oButtons.Natureza.regras.observe('click', function() {

          if (empty(oWindowRegras)) {
            oWindowRegras = new windowAux('windowRegras', '', 700, 420);
            oMessageBoard = new DBMessageBoard("messageboard", "Regras", "Configurar regras para o encerramento de Natureza Orçamentária e Controle", oContentRegras);
            oMessageBoard.show();

            oWindowRegras.setContent(oContentRegras);
            oContentRegras.style.display = 'block';
            oGridRegras.show($('gridRegras'));
          }

          oWindowRegras.show();
          carregarRegras();
        });

        /**
         * Salva as regras
         */
        oRegra.salvar.observe('click', function() {

          if (empty(oRegra.contadevedora.value)) {
            alert( _M(MENSAGEM + "campo_obrigatorio", {sCampo : "Conta Devedora"}))
            return false;
          }

          if (empty(oRegra.contacredora.value)) {
            alert( _M(MENSAGEM + "campo_obrigatorio", {sCampo : "Conta Credora"}));
            return false;
          }

          var oParametros = {
            sExecucao : "salvarRegra",
            contacredora : oRegra.contacredora.value,
            contadevedora : oRegra.contadevedora.value
          }

          new AjaxRequest(RPC, oParametros, function(oRetorno, lErro) {

            if (lErro) {
              alert(oRetorno.sMessage.urlDecode());
              return false;
            }

            alert( _M(MENSAGEM + "salvo_sucesso") );

            oRegra.contacredora.value = '';
            oRegra.contadevedora.value = '';

            carregarRegras();
          }).setMessage("Aguarde, salvando regra...").execute();
        });

        verificarEncerramentos();

        exports.oGridRegras = oGridRegras;
        exports.removerRegra = removerRegra;
      })(this);

    </script>
  </body>
</html>
