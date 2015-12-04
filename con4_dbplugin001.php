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
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/AjaxRequest.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/json2.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/datagrid.widget.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/widgets/windowAux.widget.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
  </head>
  <body class="body-default">
    <div class="container">
      <form name="form1" method="post" action="" enctype="multipart/form-data">
        <fieldset style="width: 700px;">
          <legend>Arquivo Plugin</legend>
          <table>
            <tr>
              <td>
                <input type="file" name="file" id="file"/>
              </td>
            </tr>
          </table>
        </fieldset>
        <input name="incluir" id="incluir" type="button" value="Importar" />
      </form>

      <div id="gridPlugins"></div>

      <div id="containerConfig" class="container" style="display: hidden;">
        <form name="formConfig" method="post" action="">
          <fieldset style="width: 600px;">
            <legend>Configurações</legend>

            <table id="tableInput">
            </table>
          </fieldset>
          <input name="salvar" type="submit" value="Salvar" />
        </form>
      </div>
    </div>

    <?php db_menu(); ?>
  </body>
  <script>

    (function() {

      const RPC = "con4_dbplugin.RPC.php";

      var windowConfig = new windowAux('windowConfig', 'Configuração do Plugin', 700, 400),
          oGridPlugins = new DBGrid("gridPlugins"),
          oContainerConfig = $('containerConfig'),
          oTableInput      = $('tableInput');

      windowConfig.setContent(oContainerConfig);

      oGridPlugins.nameInstance = "oGridPlugins";
      oGridPlugins.setCellWidth(["20%", "25%", "10%", "10%", "20%", "20%"]);
      oGridPlugins.setCellAlign(["left", "left", "center", "center", "center", "center"]);
      oGridPlugins.setHeader(["Nome", "Label", "Versão", "Situação", "&nbsp;", "&nbsp;"]);
      oGridPlugins.show($('gridPlugins'));

      /**
       * Instala o plugin já validado
       */
      function instalarPlugin(sPlugin) {

        var oParametros = {
            sExecucao : "instalarPlugin",
            sArquivo  : sPlugin
          };

        new AjaxRequest(RPC, oParametros, function(oRetorno, lErro) {

            if (lErro) {
              alert(oRetorno.sMessage.urlDecode());
              return false;
            }

            alert("Plugin instalado com sucesso.");

            js_recarregaGrid();

          }).setMessage("Aguarde, instalando o plugin.").execute();
      }

      /**
       * Importa o plugin e valida
       */
      $('incluir').observe('click', function() {

        if (empty($('file').value)) {
          return alert("Nenhum arquivo selecionado.");
        }

        var oParametros = { sExecucao : "validarPlugin" },
            oRequest    = new AjaxRequest( RPC, oParametros, function(oRetorno, lErro) {

              if (lErro) {

                alert(oRetorno.sMessage.urlDecode())
                return false;
              }

              if (oRetorno.lAtualizacao) {

                if (confirm("O Plugin já esta instalado, deseja atualizar?")) {
                  return instalarPlugin(oRetorno.sArquivo);
                }

                return false;
              }

              instalarPlugin(oRetorno.sArquivo);
            });

        oRequest.addFileInput($('file'));
        oRequest.setMessage("Aguarde, importando o plugin.");
        oRequest.execute();
      });

      function js_recarregaGrid() {

        new AjaxRequest(RPC, { sExecucao: "getPlugins" }, function(oRetorno, lErro) {

            if (lErro) {

              alert(oRetorno.sMessage.urlDecode())
              return false;
            }

            oGridPlugins.clearAll(true);

            oRetorno.aPlugins.forEach(function(oPlugin) {

              var sButton = '<input type="button" value="' + (oPlugin.lSituacao ? "Desativar" : "Ativar") + '" class="selectRow" data-method="alterarSituacao" data-id="'+oPlugin.iCodigo+'" />';
              var sButtonConfig = '<input type="button" value="Config" class="configRow" data-id="' + oPlugin.iCodigo + '">';
              var sButtonDesinstalar = '<input type="button" value="Desinstalar" class="selectRow" data-method="desinstalar" data-id="' + oPlugin.iCodigo + '" />';

              var aRow = [
                oPlugin.sNome,
                oPlugin.sLabel,
                oPlugin.nVersao,
                oPlugin.lSituacao ? "Ativo" : "Inativo",
                sButton + (oPlugin.lConfiguracao ? ("&nbsp;" + sButtonConfig) : ""),
                sButtonDesinstalar
              ]

              oGridPlugins.addRow(aRow);
            })

            oGridPlugins.renderRows();

            /**
             * Seta a ação dos botões
             */
            $$(".selectRow").each(function(oButton) {

              oButton.observe("click", function() {

                var oParametros = {
                  sExecucao : this.getAttribute("data-method"),
                  iCodigo   : this.getAttribute("data-id")
                };

                if (oParametros.sExecucao == "desinstalar" && !confirm("Confirma a desinstalação do plugin?")) {
                  return false;
                }

                if ( oParametros.sExecucao == "alterarSituacao" && this.value == "Desativar"
                     && !confirm("O Plugin será desativado e todos os seus dados serão removidos, deseja continuar?")) {
                  return false;
                }

                new AjaxRequest(RPC, oParametros, function(oRetorno, lErro) {

                    alert(oRetorno.sMessage.urlDecode());

                    if (lErro) {
                      return false;
                    }

                    js_recarregaGrid()
                  }).setMessage("Aguarde.").execute();
              })
            });


            $$(".configRow").each(function(oButton) {

              oButton.observe("click", function() {

                var oParametros = {
                  sExecucao : "getConfig",
                  iCodigo : this.getAttribute("data-id")
                };

                new AjaxRequest(RPC, oParametros, function(oRetorno, lErro) {

                    if (lErro) {
                      alert(oRetorno.sMessage.urlDecode());
                      return false;
                    }

                    var sInputs = '';

                    if (oRetorno.aConfiguracoes) {

                      for (var sLabel in oRetorno.aConfiguracoes) {
                        sInputs += '<tr>'
                                 +   '<td>'
                                 +     '<label class="bold" for="' + sLabel + '" id="' + oRetorno.aConfiguracoes[sLabel] + '">'
                                 +       sLabel
                                 +     ':</label>'
                                 +   '</td>'
                                 +   '<td>'
                                 +     '<input size="35" type="text" id="' + sLabel + '" name="'
                                 + sLabel + '" value="' + oRetorno.aConfiguracoes[sLabel] + '" autocomplete="off">'
                                 +   '</td>'
                                 + '</tr>';
                      }
                    }

                    oContainerConfig.style.display = '';
                    oTableInput.innerHTML          = sInputs;

                    $$("form[name=formConfig]")[0].observe("submit", function(event) {

                      event.preventDefault()

                      oParametros.aConfig   = {};
                      oParametros.sExecucao = "saveConfig";

                      $$("form[name=formConfig] input:not([type=submit])").each(function(oInput) {
                        oParametros.aConfig[oInput.name] = oInput.value;
                      })

                      new AjaxRequest(RPC, oParametros, function(oRetorno, lErro) {
                          alert(oRetorno.sMessage.urlDecode());
                        }).setMessage("Aguarde, salvando configuração.").execute();
                    });

                    windowConfig.show();

                  }).setMessage("Aguarde, carregando configuração.").execute();

              })
            });

          }).setMessage("Aguarde, carregando plugins.").execute();
      }

      js_recarregaGrid();
    })();

  </script>
</html>