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

$oRotulo = new rotulocampo;
$oRotulo->label("pc20_codorc");

?>
<html>
  <head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
  </head>
  <body class="body-default">
    <div class="container">
      <form name="mapaOrcamentoLote" id="mapaOrcamentoLote" method="post" action="">
        <fieldset>
          <legend>Mapa das Propostas do Orçamento por Lote</legend>
          <fieldset class="separator">
          <legend>Processo de compra</legend>
          <table>
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
        </tr>
          </table>
        </fieldset>
          <fieldset class="separator">
            <legend>Orçamento do Processo de Compras</legend>

            <table>
              <tr>
                <td>
                  <label class="bold" for="pc20_codorc" id="lbl_pc20_codorc">
                    <?php db_ancora('Orçamento:', "js_pesquisaOrcamento(true);", 1); ?>
                  </label>
                </td>
                <td>
                  <?php db_input("pc20_codorc", 6, $Ipc20_codorc, true, "text", 4, "onchange=\"js_pesquisaOrcamento(false);\""); ?>
                </td>
              </tr>
            </table>
          </fieldset>


          <fieldset class="separator">
            <legend>Visualização</legend>

            <table>
              <tr>
                <td>
                  <label class="bold" for="justificativa">Imprimir justificativa de troca de fornacedores:</label>
                </td>
                <td>
                  <?php

                    $aOpcoes = array(
                        "S" => "Sim",
                        "N" => "Não"
                      );

                    db_select("justificativa", $aOpcoes, true, 4, "style='width:83px;'");
                  ?>
                </td>
              </tr>
              <tr>
                <td><b>Qtd. de casas decimais:</b></td>
                <td>
                  <?php
                    $aQuant_casas = array("2" => "2", "3" => "3", "4" => "4");
                    db_select("quant_casas", $aQuant_casas, true, 4, "style='width:83px;'");
                  ?>
                </td>
              </tr>
            </table>
          </fieldset>

        </fieldset>
        <input  name="processar" id="processar" type="submit" value="Processar" />
      </form>
    </div>
    <?php
      db_menu( db_getsession("DB_id_usuario"),
               db_getsession("DB_modulo"),
               db_getsession("DB_anousu"),
               db_getsession("DB_instit") );
    ?>
  </body>
  <script type="text/javascript">

    const MENSAGENS = "patrimonial.compras.com2_mapaorcamentolote.";

    function js_pesquisaOrcamento(lMostra) {

      var sUrl = "func_pcorcamlancval.php?sol=false&lProcessoLote=true&",
          sChavePesquisa = $F('pc20_codorc');

      if (!lMostra && sChavePesquisa != '') {
        sUrl += "chave_pc20_codorc=" + sChavePesquisa + "&pesquisa_chave=" + sChavePesquisa + "&";
      }

      sUrl += "funcao_js=parent.js_pesquisaOrcamento.js_orcamentoProcesso";

      if (lMostra) {
        sUrl += "|pc20_codorc";
      }
      if (!lMostra) {
        $('processar').disabled = true;
      }

      js_OpenJanelaIframe( 'CurrentWindow.corpo',
                           'db_iframe_pcorcam',
                           sUrl,
                           'Pesquisar Orçamento do Processo de Compras',
                           lMostra );

      js_pesquisaOrcamento.js_orcamentoProcesso = function(sCodigoOrcamento, lErro) {

        var oCodigoOrcamento = $('pc20_codorc');
        $('processar').disabled = false;
        oCodigoOrcamento.value = "";

        if (lErro) {

          alert( _M(MENSAGENS + "orcamento_invalido", { iOrcamento : sChavePesquisa }) );
          return false;
        }

        $('pc20_codorc').value = (lMostra) ? sCodigoOrcamento : sChavePesquisa;
        db_iframe_pcorcam.hide();
      }
    }

    Event.observe('mapaOrcamentoLote', 'submit', function(e) {
      e.stop();

      var iOrcamento = $F('pc20_codorc'),
          sJustificativa = $F('justificativa'),
          sCasasdecimais =  $F('quant_casas'),
          iProcessodecompras = $F('pc80_codprocini');


      oJanela = window.open( "com2_mapaorcamentolote002.php?iOrcamento=" + iOrcamento + "&sJustificativa=" + sJustificativa + "&sCasasdecimais=" + sCasasdecimais + "&pc80_codproc="+iProcessodecompras,
                             '',
                             'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
      oJanela.moveTo(0,0);

      return false;
    })
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
</html>
