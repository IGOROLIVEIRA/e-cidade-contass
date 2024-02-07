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

require_once ("libs/db_stdlib.php");
require_once ("libs/db_conecta.php");
require_once ("libs/db_sessoes.php");
require_once ("libs/db_usuariosonline.php");
require_once ("dbforms/db_funcoes.php");

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
            <label class="bold" id="lbl_data" for="data">Data dos Lançamentos:</label>
          </td>
          <td>
            <?php db_inputdata("data", '31', '12', db_getsession("DB_anousu"), true, 'text', 1);  ?>
          </td>
        </tr>
      </table>

      <fieldset class="separator item-encerramento">
          <legend>Transferência dos créditos empenhados para RP</legend>
          <div class="text-left">
              <input name="processar_transferencias" type="button" id="processar_transferencias" value="Processar"/>
              <input name="desprocessar_transferencias" type="button" id="desprocessar_transferencias" value="Cancelar"/>
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
        <legend>Restos a Pagar / Natureza Orçamentária e Controle</legend>

        <div class="text-left">
          <input name="processar_natureza" type="button" id="processar_natureza" value="Processar"/>
          <input name="desprocessar_natureza" type="button" id="desprocessar_natureza" value="Cancelar"/>
          <input name="regras_natureza" type="button" id="regras_natureza" value="Regras"/>
        </div>
      </fieldset>

      <fieldset class="separator item-encerramento">
        <legend>Implantação de Saldos</legend>

        <div class="text-left">
          <input name="processar_saldo" type="button" id="processar_saldo" value="Processar"/>
          <input name="desprocessar_saldo" type="button" id="desprocessar_saldo" value="Cancelar"/>
        </div>
      </fieldset>

    </fieldset>

    <div id="contentRegras">
      <table style="width: 650px; margin: 0 auto;">
        <tr>
          <td>
            <fieldset>
              <legend>Regras de Encerramento das Naturezas Orçamentárias e Controle</legend>
              <table>
                <tr>
                  <td>
                    <label class="bold" for="contadevedora" id="lbl_contadevedora">Conta com SALDO Devedor:</label>
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
                    <label class="bold" for="contacredora" id="lbl_contacredora">Conta com SALDO Credor:</label>
                  </td>
                  <td>
                    <?php
                    $Scontacredora = "Conta Credora";
                    db_input('contacredora', 15, 1, true, "text", 1, '', '', '', '', 15);
                    ?>
                  </td>
                </tr>
                <tr>
                  <td>
                    <label class="bold" for="c117_contareferencia" id="lbl_c117_contareferenciaa">Conta Referência para valor do lançamento:</label>
                  </td>
                  <td>
                    <?php
                    $x = array("D" => "Conta com SALDO Devedor", "C" => "Conta com SALDO Credor");
                    db_select('c117_contareferencia',$x,'','','','c117_contareferencia');
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
            <input name="excluir_regra_selecionada" type="button" id="excluir_regra_selecionada" value="Excluir"/>
            <input name="importar_regra" type="button" id="importar_regra" value="Importar"/>
            <input name="importar_regra_csv" type="button" id="importar_regra_csv" value="Importar Csv"/>
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
          Transferencias : {
            processar : $('processar_transferencias'),
            desprocessar : $('desprocessar_transferencias')
          },
          Variacoes : {
            processar : $('processar_variacoes'),
            desprocessar : $('desprocessar_variacoes')
          },
          Natureza : {
            processar : $('processar_natureza'),
            desprocessar : $('desprocessar_natureza'),
            regras : $('regras_natureza')
          },
          Saldo : {
            processar : $("processar_saldo"),
            desprocessar : $("desprocessar_saldo")
          }
        },
        oRegra = {
          salvar : $('incluir_regra'),
          contacredora : $('contacredora'),
          contadevedora : $('contadevedora'),
          contareferencia : $('c117_contareferencia'),
          importar: $('importar_regra'),
          excluir: $('excluir_regra_selecionada'),
          importarCsv: $('importar_regra_csv')
        },
        oData = $('data'),
        oEncerramentos = {
          'tx' : "transferência dos créditos empenhados para RP",
          'vp' : "encerramento das Variações Patrimoniais",
          'no' : "lançamentos de inscrição dos Restos a Pagar e encerramento das contas de Natureza Orçamentária e Controle",
          'is' : "Implantação de Saldos"
        };

    var oGridRegras = new DBGrid("gridRegras");
    oGridRegras.nameInstance = "oGridRegras";
    oGridRegras.setCheckbox(0);
    oGridRegras.setSelectAll(true);
    oGridRegras.setCellWidth(["hidden","40%", "40%", "20%","20%"]);
    oGridRegras.setCellAlign(["center","left", "left", "center","center"]);
    oGridRegras.setHeader(["Sequencial","Devedora", "Credora", "Referência", "Ação"]);
    oGridRegras.show($('gridRegras'));

    var oWindowRegras = new windowAux('windowRegras', 'Regras para o Encerramento de Natureza Orçamentária e Controle', 700, 420);
    oMessageBoard = new DBMessageBoard("messageboard", "Regras", "Configurar regras para o encerramento de Natureza Orçamentária e Controle", $('contentRegras'));
    oMessageBoard.show();
    oWindowRegras.setContent($('contentRegras'));

    function verificarEncerramentos() {

      /**
       * Bloqueia todos os encerramentos
       */
      oButtons.Transferencias.processar.disabled = true;
      oButtons.Transferencias.desprocessar.disabled = true;

      oButtons.Variacoes.processar.disabled = true;
      oButtons.Variacoes.desprocessar.disabled = true;

      oButtons.Natureza.processar.disabled = true;
      oButtons.Natureza.desprocessar.disabled = true;

      oButtons.Saldo.processar.disabled = true;
      oButtons.Saldo.desprocessar.disabled = true;

      /**
       * Verifica quais os encerramentos já foram realizados
       */
      new AjaxRequest(RPC, {sExecucao : "encerramentosRealizados"}, function(oRetorno, lErro) {

        if (lErro) {
          alert(oRetorno.sMessage.urlDecode());
          return false;
        }

        if(oRetorno.aEncerramentos.tx) {
            oButtons.Transferencias.desprocessar.disabled = false;
        } else {
            oButtons.Transferencias.processar.disabled = false;
        }

        if (oRetorno.aEncerramentos.vp) {
          oButtons.Variacoes.desprocessar.disabled = false;

          if (oRetorno.aEncerramentos.no) {
            oButtons.Variacoes.desprocessar.disabled = true;
            oButtons.Natureza.desprocessar.disabled  = false;

            if (oRetorno.aEncerramentos.is) {

              oButtons.Natureza.desprocessar.disabled = true;
              oButtons.Saldo.desprocessar.disabled    = false;
            } else {
              oButtons.Saldo.processar.disabled = false;
            }

          } else {
            oButtons.Natureza.processar.disabled = false;
          }

        } else {
          oButtons.Variacoes.processar.disabled = false;
        }

      }).setMessage("Aguarde, verificando encerramentos...")
          .execute();
    }

    /**
     * Efetua o processamento
     */
    function processar(sTipo) {

      if (empty(oData.value)) {
        alert( _M(MENSAGEM + "campo_obrigatorio", {sCampo : "Data dos Lançamentos"}) );
        return false;
      }

      if (!confirm( _M(MENSAGEM + "confirmar_processamento", {sEncerramento : oEncerramentos[sTipo]})) ) {
        return false;
      }

      var oParametros = {
        sExecucao : "processarEncerramento",
        sTipo : sTipo,
        sData : oData.value
      };

      new AjaxRequest(RPC, oParametros, function(oRetorno, lErro) {

        if (lErro) {
          alert(oRetorno.sMessage.urlDecode());
          return false;
        }

        alert( _M(MENSAGEM + sTipo + "_encerrado_sucesso") );

        verificarEncerramentos();
      }).setMessage("Aguarde, efetuando encerramento...").execute();
    }

    /**
     * efetua o desprocesamento
     */
    function cancelarProcessamento(sTipo) {

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

        alert( _M(MENSAGEM + sTipo + "_cancelado_sucesso") );

        verificarEncerramentos();
      }).setMessage("Aguarde, efetuando cancelamento...").execute();
    }

    /**
     * Seta os Eventos
     */
    oButtons.Transferencias.processar.observe('click', function() {
        processar("tx");
    });

    oButtons.Transferencias.desprocessar.observe('click', function() {
        cancelarProcessamento("tx");
    });

    oButtons.Variacoes.processar.observe('click', function() {
      processar("vp");
    });

    oButtons.Variacoes.desprocessar.observe('click', function() {
      cancelarProcessamento("vp");
    });

    oButtons.Natureza.processar.observe('click', function() {
      processar("no");
    });

    oButtons.Natureza.desprocessar.observe('click', function() {
      cancelarProcessamento("no");
    });

    oButtons.Saldo.processar.observe('click', function() {
      processar("is");
    });

    oButtons.Saldo.desprocessar.observe('click', function() {
      cancelarProcessamento("is");
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

      }).setMessage("Aguarde, excluindo regra...")
          .execute();
    }

    function alterarRegra(iSequencial) {
      $("regra_"+iSequencial+"_ctdevedora").hidden = false;
      $("regra_"+iSequencial+"_ctdevedora_leitura").hidden = true;
      $("regra_"+iSequencial+"_ctcredora").hidden = false;
      $("regra_"+iSequencial+"_ctcredora_leitura").hidden = true;
      $("regra_"+iSequencial+"_ctreferencia").hidden = false;
      $("regra_"+iSequencial+"_ctreferencia_leitura").hidden = true;
      $("confirma_alterar_"+iSequencial).hidden = false;
      $("alterar_"+iSequencial).hidden = true;
    }


    function confirmaAlterarRegra(iSequencial) {
     
      if (!confirm( _M(MENSAGEM + "confirma_alterar_regra") )) {
        return false;
      }

      var oParametros = {
        sExecucao : "alterarRegra",
        iSequencial : iSequencial,
        sCtCredora : $("regra_"+iSequencial+"_ctdevedora").value,
        sCtDevedora : $("regra_"+iSequencial+"_ctcredora").value,
        sCtReferencia : $("regra_"+iSequencial+"_ctreferencia").value,
      }

      new AjaxRequest(RPC, oParametros, function(oRetorno, lErro) {

        if (lErro) {
          alert(oRetorno.sMessage.urlDecode());
          return false;
        }

        alert( _M(MENSAGEM + "alterado_sucesso") );
        carregarRegras();

      }).setMessage("Aguarde, alterando regra...")
          .execute();
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
          oGridRegras.addRow([ 
            oItem.c117_sequencial,
            '<span name="regra_'+oItem.c117_sequencial+'_ctdevedora_leitura" id="regra_'+oItem.c117_sequencial+'_ctdevedora_leitura">'+oItem.c117_contadevedora
            +'</span><input hidden type="text" name="regra_'+oItem.c117_sequencial+'_ctdevedora" id="regra_'+oItem.c117_sequencial+'_ctdevedora" value="'+oItem.c117_contadevedora+'" />',
            '<span name="regra_'+oItem.c117_sequencial+'_ctcredora_leitura" id="regra_'+oItem.c117_sequencial+'_ctcredora_leitura">'+oItem.c117_contacredora
            +'</span><input hidden type="text" name="regra_'+oItem.c117_sequencial+'_ctcredora" id="regra_'+oItem.c117_sequencial+'_ctcredora" value="'+oItem.c117_contacredora+'" />',
            '<span name="regra_'+oItem.c117_sequencial+'_ctreferencia_leitura" id="regra_'+oItem.c117_sequencial+'_ctreferencia_leitura">'+oItem.c117_contareferencia+'</span>'
            +'<select hidden name="regra_'+oItem.c117_sequencial+'_ctreferencia" id="regra_'+oItem.c117_sequencial+'_ctreferencia">'
            +'<option value="D" '+(oItem.c117_contareferencia == "D" ? "selected" : "" )+'>D</option>'
            +'<option value="C" '+(oItem.c117_contareferencia == "C" ? "selected" : "" )+'>C</option></select>',
            '<input type="button" name="remover' + oItem.c117_sequencial + '" id="remover' + oItem.c117_sequencial
            + '" onclick="removerRegra(' + oItem.c117_sequencial + ')" value="E" title="Excluir"/>&nbsp' 
            + '<input type="button" name="alterar_' + oItem.c117_sequencial + '" id="alterar_' + oItem.c117_sequencial 
            + '" onclick="alterarRegra('+ oItem.c117_sequencial +')" value="A" title="Alterar"/>'
            +'<input hidden type="button" name="confirma_alterar_' + oItem.c117_sequencial + '" id="confirma_alterar_' + oItem.c117_sequencial 
            + '" onclick="confirmaAlterarRegra('+ oItem.c117_sequencial +')" value="A" title="Alterar"/>']);
        });

        oGridRegras.renderRows();

      }).setMessage("Aguarde, Carregando regras...")
          .execute();
    }

    /**
     * Abre a janela das regras
     */
    oButtons.Natureza.regras.observe('click', function() {
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
        contadevedora : oRegra.contadevedora.value,
        contareferencia : oRegra.contareferencia.value
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

    /**
     * Importar regras do exercício anterior
     */

    oRegra.importar.observe('click', function() {

      var resp = confirm("Ao importar as regras do exercício anterior, as atuais serão apagadas. Deseja Continuar?");

      if(resp == true) {
        var oParametros = {
          sExecucao: "importarRegra"
        }

        new AjaxRequest(RPC, oParametros, function (oRetorno, lErro) {

          if (lErro) {
            alert(oRetorno.sMessage.urlDecode());
            return false;
          }

          alert("Importação realizada com sucesso!");

          carregarRegras();
        }).setMessage("Aguarde, importando regras...").execute();
      }
    });

    oRegra.excluir.observe('click', function () {
      const aRegras = oGridRegras.getSelection('array');

      if (!confirm( _M(MENSAGEM + "confirma_excluir_regras_selecionadas") )) {
        return false;
      }

      var oParametros = {
        sExecucao : "removerRegrasSelecionadas",
        aCodigoRegra : aRegras
      }

      new AjaxRequest(RPC, oParametros, function(oRetorno, lErro) {

        if (lErro) {
          alert(oRetorno.sMessage.urlDecode());
          return false;
        }

        alert( _M(MENSAGEM + "excluido_sucesso") );
        carregarRegras();

      }).setMessage("Aguarde, excluindo regras...")
          .execute();
    });

    oRegra.importarCsv.observe('click', function () {

      const inputArquivo = document.createElement('input');
      inputArquivo.type = 'file';
      inputArquivo.accept = '.csv';
      inputArquivo.style.display = 'none';

      document.body.appendChild(inputArquivo);

      inputArquivo.click();

      inputArquivo.addEventListener('change', function(e) {
        let arquivo = e.target;

        if (arquivo) {
          let formData = new FormData();
          var oParametros = {
            sExecucao : "importaRegrasCsv",
          }
          
          formData.append('json', Object.toJSON(oParametros));
          formData.append('regrasCSV', arquivo.files[0]);

          const xhr = new XMLHttpRequest();
          xhr.open('POST', RPC, true);
          xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                alert(eval("("+xhr.responseText+")").sMessage);
                carregarRegras();
            }
          };
          xhr.send(formData);
        }

        document.body.removeChild(inputArquivo);
      });
    });


    verificarEncerramentos();

    exports.oGridRegras = oGridRegras;
    exports.alterarRegra = alterarRegra;
    exports.confirmaAlterarRegra = confirmaAlterarRegra;
    exports.removerRegra = removerRegra;
  })(this);

</script>
</body>
</html>
