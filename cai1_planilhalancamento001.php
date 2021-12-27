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
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_libdicionario.php");
require_once("libs/db_app.utils.php");
require_once("classes/db_placaixa_classe.php");
require_once("classes/db_placaixarec_classe.php");
require_once("dbforms/db_classesgenericas.php");
require_once("classes/db_contabancaria_classe.php");

$clplacaixa    = new cl_placaixa;
$clplacaixarec = new cl_placaixarec;
$clrotulo      = new rotulocampo;
$ano = db_getsession("DB_anousu"); //ano 

$clcontabancaria = new cl_contabancaria;
$clcontabancaria->rotulo->label();

$clplacaixa->rotulo->label();
$clrotulo->label("nomeinst");

$clplacaixarec->rotulo->label();
$clrotulo->label("k80_data");
$clrotulo->label("k13_descr");
$clrotulo->label("k02_descr");
$clrotulo->label("k02_drecei");
$clrotulo->label("c61_codigo");
$clrotulo->label("o15_codigo");
$clrotulo->label("z01_numcgm");
$clrotulo->label("z01_nome");
$clrotulo->label("q02_inscr");
$clrotulo->label("j01_matric");
$clrotulo->label("db83_numerocontratooc");
$clrotulo->label("db83_dataassinaturacop");

$db_opcao = 1;
$c58_sequencial = "000";
$c58_descr      = "NAO SE APLICA";
/*
 * definimos qual funcao sera usada para consultar a matricula.
* se o campo db_config.db21_usasisagua for true, usamos a func_aguabase.
* se for false, usamos a func_iptubase
*/
$oDaoDBConfig = db_utils::getDao("db_config");
$rsInstit     = $oDaoDBConfig->sql_record($oDaoDBConfig->sql_query_file(db_getsession("DB_instit")));
$oInstit      = db_utils::fieldsMemory($rsInstit, 0);
$sFuncaoBusca = "js_pesquisaMatricula";
if ($oInstit->db21_usasisagua == "t") {
  $sFuncaoBusca = "js_pesquisa_agua";
}
?>
<html>

<head>
  <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="Expires" CONTENT="0">
  <?php
  db_app::load("scripts.js");
  db_app::load("prototype.js");
  db_app::load("datagrid.widget.js");
  db_app::load("strings.js");
  db_app::load("grid.style.css");
  db_app::load("estilos.css");
  db_app::load("classes/dbViewAvaliacoes.classe.js");
  db_app::load("widgets/windowAux.widget.js");
  db_app::load("widgets/dbmessageBoard.widget.js");
  db_app::load("dbcomboBox.widget.js");
  ?>
  <style>
    #k81_origem,
    #k81_codigo,
    #k81_regrepasse {
      width: 83px;
    }

    .tamanho-primeira-col {
      width: 150px;
    }

    .input-menor {
      width: 100px;
    }

    .input-maior {
      width: 400px;
    }

    #k81_codigodescr {
      width: 454px;
    }

    #k81_emparlamentar {
      width: 541px;
    }

    #k81_obs {
      width: 100%;
      height: 50px;
    }

    #k81_valor {
      width: 100px;
    }
  </style>

</head>

<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1">
  <center>

    <form name="form1" method="post" action="<?= $db_action ?>">
      <input type="hidden" value="0" id="iEmParlamentarAux" />
      <fieldset style="margin-top: 30px; width: 800px;">
        <legend><strong>Planilha de Arrecadação</strong></legend>
        <fieldset style='width:95%;'>
          <legend><strong>Dados da Planilha</strong></legend>

          <table width="100%" border="0">
            <!-- Número da Planilha -->
            <tr>
              <td class='tamanho-primeira-col' nowrap><strong>Código da Planilha:</strong></td>
              <td>
                <?
                db_input('k80_codpla', 10, $Ik80_codpla, true, 'text', 3, "")
                ?>
              </td>
              <td nowrap width="50px"><strong>Data:</strong></td>
              <td>
                <?php
                db_inputdata('k80_data', @$k80_data_dia, @$k80_data_mes, @$k80_data_ano, true, 'text', 3, "")
                ?>
              </td>
            </tr>
            <tr>
              <td>
                <b>Processo Administrativo:</b>
              </td>
              <td colspan="3">
                <?php
                db_input('k144_numeroprocesso', 10, null, true, 'text', $db_opcao, null, null, null, null, 15)
                ?>
              </td>
            </tr>

          </table>
        </fieldset>


        <!-- Dados Receita -->
        <fieldset style="width:95%; margin-top: 20px">
          <legend><b>Receita</b></legend>
          <table border="0" width="101%">
            <!-- Receita -->
            <tr>
              <td class='tamanho-primeira-col' nowrap><? db_ancora($Lk81_receita, "js_pesquisaReceita(true)", $db_opcao); ?></td>
              <td colspan='3'>
                <?
                db_input('codigo_receitaplanilha', 10, null, true, 'text', 2, " style='display:none;'");
                db_input('k81_receita', 10, $Ik81_receita, true, 'text', 2, " onchange='js_pesquisaReceita(false)'");
                db_input('c61_codigo', 5, $Ic61_codigo, true, 'text', 3, " onfocus=\"document.getElementById('k81_conta').focus()\" ", 'recurso');
                db_input('k02_drecei', 50, $Ik02_drecei, true, 'text', 3, "class='input-maior'");
                db_input('estrutural', 20, null, true, 'hidden', 2, "");
                db_input('k02_tipo', 1, null, true, 'hidden');
                ?>
              </td>
            </tr>

            <!-- Código Conta -->
            <tr>
              <td class='tamanho-primeira-col' nowrap title="<?= @$Tk81_conta ?>">
                <?
                db_ancora($Lk81_conta, "js_pesquisaConta(true);", $db_opcao);
                ?>
              </td>
              <td colspan='3'>
                <?
                db_input('k81_conta', 10, $Ik81_conta, true, 'text', 2, "onchange='js_pesquisaConta(false);'");
                db_input('c61_codigo', 5, $Ic61_codigo, true, 'text', 3);
                db_input('k13_descr', 50, $Ik13_descr, true, 'text', 3, "class='input-maior'");
                ?>
              </td>
            </tr>
            <!-- Número do Contrato da Operação de Crédito -->
            <?php if ($ano >= 2022) { ?>
              <tr>
                <td class='tamanho-primeira-col' nowrap title="<?= @$Tdb83_numerocontratooc ?>"><? echo $Ldb83_numerocontratooc ?></td>
                <td colspan='3'>
                  <?
                  $oDaoOrctiporec = db_utils::getDao("contabancaria");
                  $sWhere         = " ";
                  $sCampos        = "db83_numerocontratooc";
                  $sSQLOrctiporec = $oDaoOrctiporec->sql_query_file(null, $sCampos, "db83_numerocontratooc");
                  $rsOrctiporec   = $oDaoOrctiporec->sql_record($sSQLOrctiporec);
                  db_input('db83_numerocontratooc', $rsOrctiporec, true, $db_opcao);
                  ?>
                </td>
              </tr>
              <tr>
                <td nowrap title="<?= @$Tdb83_dataassinaturacop ?>"><? echo $Ldb83_dataassinaturacop ?></td>
                <td colspan='3'>
                  <?
                  $oDaoOrctiporec = db_utils::getDao("contabancaria");
                  $sWhere         = " ";
                  $sCampos        = "db83_dataassinaturacop";
                  $sSQLOrctiporec = $oDaoOrctiporec->sql_query_file(null, $sCampos, "db83_dataassinaturacop");
                  $rsOrctiporec   = $oDaoOrctiporec->sql_record($sSQLOrctiporec);
                  db_input('db83_dataassinaturacop', $rsOrctiporec, true, $db_opcao);
                  ?>
                </td>
              </tr>
            <?php } ?>

            <tr id="notificacao" style="display:none;">
              <td colspan='4' style="text-align: left; background-color: #fcf8e3; border: 1px solid #fcc888; padding: 10px">
                <!-- Mensagem de notificação -->
              </td>
            </tr>

            <tr id="notificacao2" style="display:none;">
              <td colspan='4' style="text-align: left; background-color: #fcf8e3; border: 1px solid #fcc888; padding: 10px">
                <!-- Mensagem de notificação -->
              </td>
            </tr>

            <!-- Origem -->
            <tr>
              <td class='tamanho-primeira-col' nowrap title="<?= @$Tk81_origem ?>"><?= $Lk81_origem ?></td>
              <td colspan='3'>
                <?
                db_select("k81_origem", getValoresPadroesCampo("k81_origem"), true, 1, "class='input-menor' onChange='toogleOrigem()'");
                ?>
              </td>
            </tr>

            <!-- CGM -->
            <tr id='inputCgm' style=''>
              <td nowrap title="<?= @$Tk81_conta ?>">
                <? db_ancora(@$Lk81_numcgm, "js_pesquisaCgm(true);", $db_opcao); ?>
              </td>
              <td colspan='3'>
                <?
                db_input('k81_numcgm', 10, $Ik81_numcgm, true, 'text', 2, "onchange='js_pesquisaCgm(false);'");
                db_input('z01_nome', 63, $Iz01_nome, true, 'text', 3);
                ?>
              </td>
            </tr>

            <!-- Inscricao -->
            <tr id='inputInscr' style='display:none'>
              <td nowrap title="<?= @$Tq02_inscr ?>"><? db_ancora(@$Lq02_inscr, "js_pesquisaInscricao(true);", $db_opcao); ?></td>
              <td colspan='3'>
                <?
                db_input('q02_inscr', 10, $Iq02_inscr, true, 'text', 2, " onchange='js_pesquisaInscricao(false);'");
                db_input('nomeinscr', 65, $Iz01_nome, true, 'text', 3, "class='input-maior'");
                ?>
              </td>
            </tr>

            <!-- Matricula -->
            <tr id='inputMatric' style='display:none'>
              <td class='tamanho-primeira-col' nowrap title="<?= @$Tj01_matric ?>"><? db_ancora(@$Lj01_matric, "{$sFuncaoBusca}(true);", $db_opcao); ?></td>
              <td colspan='3'>
                <?
                db_input('j01_matric', 10, $Ij01_matric, true, 'text', 2, " onchange='{$sFuncaoBusca}(false);'");
                db_input('nomematric', 63, $Iz01_nome, true, 'text', 3);
                ?>
              </td>
            </tr>

            <!-- Recurso -->
            <tr>
              <td class='tamanho-primeira-col' nowrap title="<?= @$To15_codigo ?>"><? echo $Lo15_codigo ?></td>
              <td colspan='3'>
                <?
                $oDaoOrctiporec = db_utils::getDao("orctiporec");
                $sWhere         = " o15_datalimite is null or o15_datalimite > '" . date('Y-m-d', db_getsession('DB_datausu')) . "'";
                $sCampos        = "o15_codigo,o15_descr";
                $sSQLOrctiporec = $oDaoOrctiporec->sql_query_file(null, $sCampos, "o15_codigo", $sWhere);
                $rsOrctiporec   = $oDaoOrctiporec->sql_record($sSQLOrctiporec);
                db_selectrecord('k81_codigo', $rsOrctiporec, true, $db_opcao);
                ?>
              </td>
            </tr>

            <!--Convênio -->
            <tr>
              <td nowrap title="<?= @$Tk81_convenio ?>"><? echo $Lk81_convenio ?></td>
              <td colspan='3'>
                <?
                db_input('k81_convenio', 11, $Ik81_convenio, true, 'text', 3, "onChange='js_pesquisak81_convenio(false);'");
                db_input("c206_objetoconvenio", 62, 0, true, "text", 3);
                ?>
              </td>
            </tr>
            <!-- Regularização de Repasse -->
            <tr id="regrepasse" style="display: none;">
              <td class='tamanho-primeira-col' nowrap title="<?= @$Tk81_regrepasse ?>"><?= $Lk81_regrepasse ?></td>
              <td colspan='1'>
                <?
                $aOpcoes = array('' => 'Selecione', '1' => 'Sim', '2' => 'Não');
                db_select("k81_regrepasse", $aOpcoes, true, 1, "class='input-menor' onChange='js_toogleRegRepasse(this.value)'");
                ?>
              </td>

              <td nowrap title="<?= @$Tk81_exerc ?>" id="exercicioLabel" style="display: none"><? echo $Lk81_exerc ?></td>
              <td id="exercicioInput" style="display: none">
                <?
                db_input('k81_exerc', 11, $Ik81_exerc, true, 'text', $db_opcao, "");
                ?>
              </td>

            </tr>

            <!-- Ref a Emenda Parlamentar -->
            <tr <?= db_getsession("DB_anousu") >= 2020 ? '' : 'style="display: none;"' ?>>
              <td class='tamanho-primeira-col' nowrap title="<?= @$Tk81_emparlamentar ?>"><?= $Lk81_emparlamentar ?></td>
              <td colspan='5'>
                <?
                if (db_getsession("DB_anousu") == 2020) {
                  $aOpcoes = array(
                    '' => 'Selecione',
                    '1' => '1 - Emenda parlamentar individual',
                    '2' => '2 - Emenda parlamentar de bancada',
                    '3' => '3 - Não se aplica'
                  );
                } elseif (db_getsession("DB_anousu") >= 2021) {
                  $aOpcoes = array(
                    '' => 'Selecione',
                    '1' => '1 - Emenda parlamentar individual',
                    '2' => '2 - Emenda parlamentar de bancada ou de bloco',
                    '3' => '3 - Não se aplica',
                    '4' => '4 - Emenda não impositiva (Emendas de comissão e relatoria)'
                  );
                }
                db_select("k81_emparlamentar", $aOpcoes, true, 1, "class='input-menor'");
                ?>
              </td>
            </tr>

            <tr id="notificacao-conv" style="display:none;">
              <td colspan='4' style="text-align: left; background-color: #fcf8e3; border: 1px solid #fcc888; padding: 10px">
                <!-- Mensagem de notificação -->
              </td>
            </tr>

            <!-- Característica Peculiar -->
            <tr style='display: none'>
              <td><b><? db_ancora("C.Peculiar / C.Aplicação :", "js_pesquisaPeculiar(true);", $db_opcao); ?></b></td>
              <td colspan='3'>
                <?
                db_input('c58_sequencial', 10, '', true, 'text', 2, "onchange='js_pesquisaPeculiar(false);'");
                db_input('c58_descr', 63, '', true, 'text', 3);
                ?>
              </td>
            </tr>

            <tr>
              <td nowrap title="<?= @$Tk81_datareceb ?>"><? echo $Lk81_datareceb ?></td>
              <td><?
                  if ($db_opcao == 1) {

                    $k81_datareceb_dia = date("d", db_getsession("DB_datausu"));
                    $k81_datareceb_mes = date("m", db_getsession("DB_datausu"));
                    $k81_datareceb_ano = date("Y", db_getsession("DB_datausu"));
                  }
                  db_inputdata('k81_datareceb', @$k81_datareceb_dia, @$k81_datareceb_mes, @$k81_datareceb_ano, true, 'text', $db_opcao, "class='input-menor'")
                  ?>
              </td>
              <td nowrap title="<?= @$Tk81_operbanco ?>" width="100px"><?= @$Lk81_operbanco ?></td>
              <td><? db_input('k81_operbanco', 10, $Ik81_operbanco, true, 'text', $db_opcao); ?></td>
            </tr>

            <tr>

              <td nowrap title="<?= @$Tk81_valor ?>"><?= @$Lk81_valor ?></td>
              <td><? db_input('k81_valor', 10, $Ik81_valor, true, 'text', $db_opcao) ?></td>

            </tr>


            <tr>
              <td colspan='4'>
                <fieldset>
                  <legend><strong>Observação</strong></legend>
                  <? db_textarea("k81_obs", 1, 40, $Ik81_obs, "true", "text", $db_opcao); ?>
                </fieldset>
              </td>
            </tr>
          </table>
        </fieldset>
        <br>

        <input type='button' value='Salvar Item' id='incluir' onclick='js_addReceita();' />
        <input type='button' value='Pesquisar' id='btnPesquisar' onclick='js_pesquisaPlanilha(false);' />
        <input type='button' value='Importar' id='importar' onclick='js_pesquisaPlanilha(true);' />
        <input type='button' value='Limpar Dados Receita' id='limpar' onclick='js_limpaFormularioReceita();' />
        <div id='ctnReceitas' style="margin-top: 20px;"></div>

      </fieldset>
      <input type="button" value='Salvar Planilha' id='salvar' style="margin-top: 10px;" onclick='js_salvarPlanilha()' />
      <input type="button" value='Excluir Selecionados' id='excluir' style="margin-top: 10px;" onclick='js_excluiSelecionados();' />
      <input type="button" value='Nova Planilha' id='excluir' style="margin-top: 10px;" onclick='js_novaReceita()' />
      <input type="hidden" value="<?= db_getsession("DB_anousu") ?>" id="anoUsu" />
      <input type="hidden" value="0" id="bAtualiza" />
    </form>
  </center>

  <?php
  db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit"));
  ?>
</body>

</html>

<script>
  const CAMINHO_MENSAGEM = 'financeiro.caixa.cai1_planilhalancamento001.';
  sRPC = 'cai4_planilhaarrecadacao.RPC.php';

  if ($('anoUsu').value >= 2020) {
    document.getElementById("k81_emparlamentar").options[3].selected = true;
    let lEmendaParlamentarObrigatoria = false;
  }

  function js_pesquisak81_convenio(mostra) {
    if (mostra == true) {
      js_OpenJanelaIframe('', 'db_iframe_convconvenios', 'func_convconvenios.php?funcao_js=parent.js_mostrak81_convenio1|c206_sequencial|c206_objetoconvenio', 'Pesquisa', true);
    } else {
      if (document.form1.k81_convenio.value != '') {
        js_OpenJanelaIframe('', 'db_iframe_convconvenios', 'func_convconvenios.php?pesquisa_chave=' + document.form1.k81_convenio.value + '&funcao_js=parent.js_mostrak81_convenio', 'Pesquisa', false);
      } else {
        document.form1.c206_objetoconvenio.value = '';
      }
    }
  }

  function js_mostrak81_convenio(chave, erro) {
    document.form1.c206_objetoconvenio.value = chave;
    if (erro == true) {
      document.form1.k81_convenio.focus();
      document.form1.k81_convenio.value = '';
    }
  }

  function js_mostrak81_convenio1(chave1, chave2) {
    document.form1.k81_convenio.value = chave1;
    document.form1.c206_objetoconvenio.value = chave2;
    db_iframe_convconvenios.hide();
  }

  /*
   * funcao para verificar o grupo das receitas.
   * Nesta rotina nao permitiremos mais receitas do Grupo 11
   */
  function js_verificaReceita() {

    var sUrlRPC = "cai4_devolucaoadiantamento004.RPC.php";
    var iReceita = $F("k81_receita");
    var oParametros = new Object();
    var msgDiv = "Verificando grupo receita selecionado \n Aguarde ...";

    oParametros.exec = 'verificaGrupoReceita';
    oParametros.iReceita = iReceita;

    if (iReceita == '' || iReceita == null) {
      return false;
    }

    js_divCarregando(msgDiv, 'msgBox');

    new Ajax.Request(sUrlRPC, {
      method: "post",
      parameters: 'json=' + Object.toJSON(oParametros),
      onComplete: js_retornoVerificacaoReceita
    });
  }

  function js_retornoVerificacaoReceita(oAjax) {

    js_removeObj('msgBox');
    var oRetorno = eval("(" + oAjax.responseText + ")");

    if (oRetorno.iStatus == '2') {

      alert(oRetorno.sMessage.urlDecode());
      $('codigo_receitaplanilha').value = '';
      $('k81_receita').value = '';
      $('c61_codigo').value = '';
      $('k02_drecei').value = '';
      $('estrutural').value = '';
      $('recurso').value = '';

      return false;
    }
  }
  /**
   * função para montar a grid de receitas:
   */
  var oGridReceitas;
  var aReceitas = new Array();
  var iIndiceReceitas = 0;
  var iAlteracao = null;
  var oGet = js_urlToObject();
  var iPlanilha = null;
  var dtPlanilha = null;
  var lMenuAlteracao = false;
  var lImportacao = false;
  $('btnPesquisar').style.display = "none";
  if (oGet.lAlteracao == 'true') {

    $('btnPesquisar').style.display = "";
    lMenuAlteracao = true;
  }

  function js_novaReceita() {

    document.form1.reset();
    toogleOrigem();
    oGridReceitas.clearAll(true);
    aReceitas = new Array();
    iIndiceReceitas = 0;
    iAlteracao = null;
  }

  function js_limpaFormularioReceita() {

    document.form1.reset();

    toogleOrigem();
    iAlteracao = null;

    if (lMenuAlteracao) {

      $('k80_codpla').value = iPlanilha;
      $('k80_data').value = dtPlanilha;
    }
  }

  function js_gridReceitas() {

    oGridReceitas = new DBGrid('ctnReceitas');
    oGridReceitas.nameInstance = 'oGridReceitas';
    oGridReceitas.setCheckbox(0);
    oGridReceitas.setCellWidth(new Array('1%',
      '40%',
      '40%',
      '10%',
      '5%'));

    oGridReceitas.setCellAlign(new Array('center',
      'left',
      'left',
      'right',
      'center'));


    oGridReceitas.setHeader(new Array('Indice',
      'Dados da Conta',
      'Conta Tesouraria',
      'Valor',
      'Ação'));


    oGridReceitas.aHeaders[1].lDisplayed = false;
    oGridReceitas.hasTotalizador = true;
    oGridReceitas.setHeight(100);
    oGridReceitas.show($('ctnReceitas'));
    oGridReceitas.clearAll(true);
  }


  function toogleOrigem() {

    iTipo = $F("k81_origem");

    $('k81_numcgm').value = '';
    $('q02_inscr').value = '';
    $('j01_matric').value = '';
    $('z01_nome').value = '';
    $('nomematric').value = '';

    switch (iTipo) {

      case '1':

        $('inputCgm').style.display = '';
        $('inputMatric').style.display = 'none';
        $('inputInscr').style.display = 'none';
        break;

      case '2':

        $('inputInscr').style.display = '';
        $('inputMatric').style.display = 'none';
        $('inputCgm').style.display = 'none';
        break;

      case '3':

        $('inputMatric').style.display = '';
        $('inputInscr').style.display = 'none';
        $('inputCgm').style.display = 'none';
        break;

    }
  }

  function js_pesquisak81_codpla(lMostra) {

    if (lMostra == true) {
      js_OpenJanelaIframe('top.corpo', 'db_iframe_placaixa', 'func_placaixa.php?funcao_js=parent.js_preenchePlacaixa|k80_codpla|k80_data', 'Pesquisa', true, '0');
    } else {

      if (document.form1.k81_codpla.value != '') {
        js_OpenJanelaIframe('top.corpo', 'db_iframe_placaixa', 'func_placaixa.php?pesquisa_chave=' + document.form1.k81_codpla.value + '&funcao_js=parent.js_preenchePlacaixa', 'Pesquisa', false);
      } else {
        $('k80_data').value = '';
      }
    }
  }

  function js_preenchePlacaixa(chave, erro) {

    document.form1.k80_data.value = chave;
    if (erro == true) {

      document.form1.k81_codpla.focus();
      document.form1.k81_codpla.value = '';
    }
  }

  function js_preenchePlacaixa(chave1, chave2) {
    document.form1.k81_codpla.value = chave1;
    document.form1.k80_data.value = chave2;
    db_iframe_placaixa.hide();
  }


  /**
   *   CONTA
   */
  function js_pesquisaConta(lMostra) {

    var sFuncao = 'funcao_js=parent.js_mostraSaltes|k13_conta|k13_descr|c61_codigo|db83_conta|db83_numerocontratooc|db83_dataassinaturacop';
    var sPesquisa = 'func_saltesrecurso.php?recurso=0&' + sFuncao + '&data_limite=<?= date("Y-m-d", db_getsession("DB_datausu")) ?>'

    if (!lMostra) {
      if ($F('k81_conta') == '') {
        $('k13_descr').value = '';
      } else {
        sFuncao = 'funcao_js=parent.js_preencheSaltes';
        sPesquisa = 'func_saltesrecurso.php?pesquisa_chave=' + $('k81_conta').value + '&' + sFuncao + '&data_limite=<?= date("Y-m-d", db_getsession("DB_datausu")) ?>'
      }
    }

    js_OpenJanelaIframe('top.corpo', 'db_iframe_saltes', sPesquisa + '&data_limite=<?= date("Y-m-d", db_getsession("DB_datausu")) ?>', 'Pesquisa', lMostra);
  }


  function js_getSaltesConvenio(iCodigoSaltes) {
    sJson = '{"exec":"getSaltesConvenio","iCodigoSaltes":' + iCodigoSaltes + '}';
    url = 'cai4_planilhalancamento.RPC.php';
    oAjax = new Ajax.Request(
      url, {
        method: 'post',
        parameters: 'sJson=' + sJson,
        onComplete: js_retornoSaltesConvenio
      }
    );
  }

  function js_retornoSaltesConvenio(oAjax) {
    oSaltesConvenio = eval("(" + oAjax.responseText + ")");

    $('k81_convenio').value = oSaltesConvenio.c206_sequencial;
    $('c206_objetoconvenio').value = oSaltesConvenio.c206_objetoconvenio;
    js_mostrarNotificacaoConvenio(oSaltesConvenio);
  }

  function js_preencheSaltes(iCodigoConta, sDescricao, iCodigoRecurso, idb83_numerocontratooc, idb83_dataassinaturacop, lErro) {

    $('k81_conta').value = iCodigoConta;
    $('k13_descr').value = sDescricao;
    $('c61_codigo').value = iCodigoRecurso;

    if (iCodigoConta != '') {
      $('db83_numerocontratooc').value = idb83_numerocontratooc;
    } else {
      $('db83_numerocontratooc').value = '';
    }

    if (idb83_dataassinaturacop != '') {
      const data = idb83_dataassinaturacop.split('-');
      $('db83_dataassinaturacop').value = data[2] + "/" + data[1] + "/" + data[0];
    } else {
      $('db83_dataassinaturacop').value = '';
    }

    if (iCodigoRecurso == 174 || iCodigoRecurso == 179 || iCodigoRecurso == 190 || iCodigoRecurso == 191) {
      if (idb83_dataassinaturacop == '' || idb83_numerocontratooc == '') {
        alert('É obrigatório informar o número do contrato da operação de crédito para as receitas de fontes 174,179,190 e 191');
        $('k81_conta').focus();
        return false;

      }
    }

    iCodRecursoConta = $F('c61_codigo').substr(-3);

    if ($('estrutural').value.substr(0, 3) == '211') {

      $('k81_codigo').value = $('c61_codigo').value;
      $('k81_codigo').onchange();
    } else {

      if (iCodigoRecurso != '') {
        $('k81_codigo').value = iCodigoRecurso;
        $('k81_codigo').onchange();
      }

    }

    if (lErro) {

      $('k81_conta').focus();
      $('k81_receita').focus();
      $('k81_conta').value = '';

    } else {
      if ($('anoUsu').value >= 2022) {
        if ($('estrutural').value.substr(0, 7) != '4121004' && $('estrutural').value.substr(0, 7) != '4721004' && $('estrutural').value.substr(0, 5) != '41215' && $('estrutural').value.substr(0, 5) != '47215') {
          js_getCgmConta(iCodigoConta);
        }
      } else {
        if ($('estrutural').value.substr(0, 7) != '4121004' && $('estrutural').value.substr(0, 7) != '4721004' && $('estrutural').value.substr(0, 5) != '41218' && $('estrutural').value.substr(0, 5) != '47218') {
          js_getCgmConta(iCodigoConta);
        }
      }
    }


    if ($('anoUsu').value >= 2022) {
      if (iCodRecursoConta == 122 || iCodRecursoConta == 123 || iCodRecursoConta == 124 || iCodRecursoConta == 142 || iCodRecursoConta == 163 || iCodRecursoConta == 171 || iCodRecursoConta == 172 || iCodRecursoConta == 173 || iCodRecursoConta == 176 || iCodRecursoConta == 177 || iCodRecursoConta == 178 || iCodRecursoConta == 181 || iCodRecursoConta == 182 || iCodRecursoConta == 183) {
        js_getSaltesConvenio(iCodigoConta);
      } else {
        $('k81_convenio').value = '';
        $('c206_objetoconvenio').value = '';
      }
    } else {
      if (iCodRecursoConta == 122 || iCodRecursoConta == 123 || iCodRecursoConta == 124 || iCodRecursoConta == 142 || iCodRecursoConta == 163) {
        js_getSaltesConvenio(iCodigoConta);
      } else {
        $('k81_convenio').value = '';
        $('c206_objetoconvenio').value = '';
      }
    }
    js_mostrarNotificacaoConta();
  }



  function js_mostraSaltes(iCodigoConta, sDescricao, iCodigoRecurso, idb_conta, idb83_numerocontratooc, idb83_dataassinaturacop) {

    $('k81_conta').value = iCodigoConta;
    $('k13_descr').value = sDescricao;
    $('c61_codigo').value = iCodigoRecurso;

    <?php if ($ano >= 2022) { ?>
      if (iCodigoConta != '') {
        $('db83_numerocontratooc').value = idb83_numerocontratooc;
      } else {
        $('db83_numerocontratooc').value = '';
      }
      if (idb83_dataassinaturacop != '') {
        const data = idb83_dataassinaturacop.split('-');
        $('db83_dataassinaturacop').value = data[2] + "/" + data[1] + "/" + data[0];
      } else {
        $('db83_dataassinaturacop').value = '';
      }


      if (iCodigoRecurso == 174 || iCodigoRecurso == 179 || iCodigoRecurso == 190 || iCodigoRecurso == 191) {
        if (idb83_dataassinaturacop == '' || idb83_numerocontratooc == '') {
          alert('É obrigatório informar o número do contrato da operação de crédito para as receitas de fontes 174,179,190 e 191');

        }
      }
    <?php } ?>
    iCodRecursoConta = $F('c61_codigo').substr(-3);

    if ($F('estrutural').substr(0, 3) == '211') {

      $('k81_codigo').value = $('c61_codigo').value;
      $('k81_codigo').onchange();

    } else {

      $('k81_codigo').value = iCodigoRecurso;
      $('k81_codigo').onchange();
    }
    //OC5689
    if ($('anoUsu').value >= 2022) {
      if ($('estrutural').value.substr(0, 7) != '4121004' && $('estrutural').value.substr(0, 7) != '4721004' && $('estrutural').value.substr(0, 5) != '41215' && $('estrutural').value.substr(0, 5) != '47215') {
        js_getCgmConta(iCodigoConta);
      }
    } else {
      if ($('estrutural').value.substr(0, 7) != '4121004' && $('estrutural').value.substr(0, 7) != '4721004' && $('estrutural').value.substr(0, 5) != '41218' && $('estrutural').value.substr(0, 5) != '47218') {
        js_getCgmConta(iCodigoConta);
      }

    }
    db_iframe_saltes.hide();

    if ($('anoUsu').value >= 2022) {
      if (iCodRecursoConta == 122 || iCodRecursoConta == 123 || iCodRecursoConta == 124 || iCodRecursoConta == 142 || iCodRecursoConta == 163 || iCodRecursoConta == 171 || iCodRecursoConta == 172 || iCodRecursoConta == 173 || iCodRecursoConta == 176 || iCodRecursoConta == 177 || iCodRecursoConta == 178 || iCodRecursoConta == 181 || iCodRecursoConta == 182 || iCodRecursoConta == 183) {
        js_getSaltesConvenio(iCodigoConta);

      } else {

        $('k81_convenio').value = '';
        $('c206_objetoconvenio').value = '';

      }
    } else {

      if (iCodRecursoConta == 122 || iCodRecursoConta == 123 || iCodRecursoConta == 124 || iCodRecursoConta == 142 || iCodRecursoConta == 163) {

        js_getSaltesConvenio(iCodigoConta);

      } else {

        $('k81_convenio').value = '';
        $('c206_objetoconvenio').value = '';

      }
    }

    js_mostrarNotificacaoConta();
  }


  function js_getCgmConta(iReduz) {
    sJson = '{"exec":"getCgmConta","iCodReduz":' + iReduz + '}';
    url = 'cai4_placaixaRPC.php';
    oAjax = new Ajax.Request(
      url, {
        method: 'post',
        parameters: 'sJson=' + sJson,
        onComplete: js_retornoCgm
      }
    );
  }


  /**
     RECEITA
  */
  function js_pesquisaReceita(lMostra) {

    var sPesquisa = 'func_tabrec_recurso.php?funcao_js=parent.js_mostratabrec1|k02_codigo|k02_drecei|recurso|k02_estorc|k02_tipo|recurso';

    if (!lMostra) {

      if ($F('k81_receita') == '') {

        $('k02_descr').value = '';
        return;
      }
      sPesquisa = 'func_tabrec_recurso.php?pesquisa_chave=' + $F('k81_receita') + '&funcao_js=parent.js_mostratabrec';

    }
    js_OpenJanelaIframe('top.corpo', 'db_iframe_tabrec', sPesquisa, 'Pesquisa', lMostra);

  }

  function js_mostratabrec(iReceita, sReceita, chave3, chave4, erro, chave5, chave6) {

    $('k81_receita').value = iReceita;
    $('k02_drecei').value = sReceita;
    $('recurso').value = chave3;
    $('estrutural').value = chave4;
    $('k02_tipo').value = chave6;

    if (erro) {
      $('k81_receita').focus();
      $('k81_receita').value = '';
    }
    if ($('anoUsu').value >= 2022) {
      if ($('estrutural').value.substr(0, 7) == '4121004' || $('estrutural').value.substr(0, 7) == '4721004' || $('estrutural').value.substr(0, 5) == '41215' || $('estrutural').value.substr(0, 5) == '47215') {
        if ($('bAtualiza').value == 0) {
          $('k81_numcgm').value = '';
          $('z01_nome').value = '';
        }
      } else {
        js_getCgmConta($('k81_conta').value);
      }
    } else {
      if ($('estrutural').value.substr(0, 7) == '4121004' || $('estrutural').value.substr(0, 7) == '4721004' || $('estrutural').value.substr(0, 5) == '41218' || $('estrutural').value.substr(0, 5) == '47218') {
        if ($('bAtualiza').value == 0) {
          $('k81_numcgm').value = '';
          $('z01_nome').value = '';
        }
      } else {
        js_getCgmConta($('k81_conta').value);
      }
    }

    if ($('anoUsu').value >= 2020) {

      js_verificaEmendaParlamentar();
      js_verificaRegularizaRepasse();

    }

    js_verificaReceita();
    js_mostrarNotificacaoEstruturais();
    js_mostrarNotificacaoConta();
    js_mostrarNotificacaoConvenio();
  }

  function js_mostratabrec1(iReceita, sReceita, chave3, chave4, chave5, chave6) {

    $('k81_receita').value = iReceita;
    $('k02_drecei').value = sReceita;
    $('recurso').value = chave3;
    $('estrutural').value = chave4;
    $('k02_tipo').value = chave5;

    if ($('anoUsu').value >= 2022) {
      if ($('estrutural').value.substr(0, 7) == '4121004' || $('estrutural').value.substr(0, 7) == '4721004' || $('estrutural').value.substr(0, 5) == '41215' || $('estrutural').value.substr(0, 5) == '47215') {
        if ($('bAtualiza').value == 0) {
          $('k81_numcgm').value = '';
          $('z01_nome').value = '';
        }
      } else {
        js_getCgmConta($('k81_conta').value);
      }
    } else {
      if ($('estrutural').value.substr(0, 7) == '4121004' || $('estrutural').value.substr(0, 7) == '4721004' || $('estrutural').value.substr(0, 5) == '41218' || $('estrutural').value.substr(0, 5) == '47218') {
        if ($('bAtualiza').value == 0) {
          $('k81_numcgm').value = '';
          $('z01_nome').value = '';
        }
      } else {
        js_getCgmConta($('k81_conta').value);
      }
    }

    if ($('anoUsu').value >= 2020) {

      js_verificaEmendaParlamentar();
      js_verificaRegularizaRepasse();

    }

    db_iframe_tabrec.hide();
    js_verificaReceita();
    js_mostrarNotificacaoEstruturais();
    js_mostrarNotificacaoConta();
    js_mostrarNotificacaoConvenio();

  }

  /**
   * Pesquisa CGM
   */
  function js_pesquisaCgm(lMostra) {

    if (lMostra == true) {
      js_OpenJanelaIframe('top.corpo', 'db_iframe_cgm', 'func_nome.php?funcao_js=parent.js_mostraCgm|z01_numcgm|z01_nome', 'Pesquisa', true);
    } else {
      js_OpenJanelaIframe('top.corpo', 'db_iframe_cgm', 'func_nome.php?pesquisa_chave=' + $('k81_numcgm').value + '&funcao_js=parent.js_preencheCgm', 'Pesquisa', false);
    }
    js_mostrarNotificacaoEstruturais();
  }

  function js_mostraCgm(iCodigoCgm, sDescricao) {

    $('k81_numcgm').value = iCodigoCgm;
    $('z01_nome').value = sDescricao;
    db_iframe_cgm.hide();
    js_mostrarNotificacaoEstruturais();
  }

  function js_preencheCgm(lErro, sDescricao) {

    $('z01_nome').value = sDescricao;

    if (lErro) {
      $('k81_numcgm').focus();
      $('k81_numcgm').value = '';
      $('z01_nome').value = sDescricao;
    }
    js_mostrarNotificacaoEstruturais();
  }


  /**
   *  Pesquisa Inscrição
   */
  function js_pesquisaInscricao(lMostra) {

    var sFuncao = 'func_issbase.php?funcao_js=parent.js_mostraInscricao|q02_inscr|z01_nome';

    if (!lMostra) {

      sFuncao = 'func_issbase.php?pesquisa_chave=' + $F('q02_inscr') + '&funcao_js=parent.js_preencheInscricao';
    }
    js_OpenJanelaIframe('top.corpo', 'db_iframe_inscr', sFuncao, 'Pesquisa', lMostra, '10');
  }

  function js_mostraInscricao(iCodigo, sDescricao) {

    $('q02_inscr').value = iCodigo;
    $('nomeinscr').value = sDescricao;
    db_iframe_inscr.hide();
  }

  function js_preencheInscricao(sDescricao, lErro) {

    $('nomeinscr').value = sDescricao;

    if (lErro) {
      $('q02_inscr').focus();
      $('nomeinscr').value = sDescricao;
    }
  }

  /**
   * Pesquisa Matricula
   */
  function js_pesquisaMatricula(lMostra) {
    if (lMostra == true) {
      js_OpenJanelaIframe('top.corpo', 'db_iframe_matric', 'func_iptubase.php?funcao_js=parent.js_mostraMatricula|j01_matric|z01_nome', 'Pesquisa', true);
    } else {
      js_OpenJanelaIframe('top.corpo', 'db_iframe_matric', 'func_iptubase.php?pesquisa_chave=' + $F('j01_matric') + '&funcao_js=parent.js_preencheMatricula', 'Pesquisa', false);
    }
  }

  function js_mostraMatricula(chave1, chave2) {

    $('j01_matric').value = chave1;
    $('nomematric').value = chave2;
    db_iframe_matric.hide();
  }

  function js_preencheMatricula(chave, erro) {
    $('nomematric').value = chave;
    if (erro == true) {
      $('j01_matric').focus();
      $('nomematric').value = chave;
    }
  }

  function js_pesquisa_agua(lMostra) {

    if (lMostra == true) {
      js_OpenJanelaIframe('top.corpo', 'db_iframe_matric', 'func_aguabase.php?funcao_js=parent.js_mostraMatricula|x01_matric|z01_nome', 'Pesquisa', true, '10');
    } else {
      js_OpenJanelaIframe('top.corpo', 'db_iframe_matric', 'func_aguabase.php?pesquisa_chave=' + $F('j01_matric') + '&funcao_js=parent.js_preencheMatricula', 'Pesquisa', false);
    }
  }

  /**
   *  Caracteristica Peculiar
   */
  function js_pesquisaPeculiar(lMostra) {

    var sPesquisa = 'func_concarpeculiar.php?funcao_js=parent.js_mostraPeculiar|c58_sequencial|c58_descr';
    if (!lMostra) {

      sPesquisa = 'func_concarpeculiar.php?pesquisa_chave=' + document.form1.c58_sequencial.value;
      sPesquisa += '&funcao_js=parent.js_mostraPeculiar1';
    }
    js_OpenJanelaIframe('top.corpo', 'db_iframe_peculiar', sPesquisa, 'Pesquisa', lMostra, '10');
  }

  function js_mostraPeculiar(iCodigoCaracteristica, sDescricaoCaracteristica) {

    $('c58_sequencial').value = iCodigoCaracteristica;
    $('c58_descr').value = sDescricaoCaracteristica;
    db_iframe_peculiar.hide();
  }

  function js_mostraPeculiar1(sDescricao, lErro) {

    if (lErro) {

      $('c58_sequencial').value = "";
      $('c58_descr').value = "";
      return;
    }
    $('c58_sequencial').focus();
    $('c58_descr').value = sDescricao;
  }

  function js_getCgmConta(iReduz) {

    oParam = new Object();
    oParam.exec = "getCgmConta";
    oParam.iCodReduz = iReduz;


    url = 'cai4_placaixaRPC.php';
    oAjax = new Ajax.Request(
      url, {
        method: 'post',
        parameters: 'sJson=' + Object.toJSON(oParam),
        onComplete: js_retornoCgm
      }
    );
  }

  function js_retornoCgm(oAjax) {

    oCgm = eval("(" + oAjax.responseText + ")");
    $('k81_numcgm').value = oCgm.z01_numcgm;
    $('z01_nome').value = oCgm.z01_nome;
  }

  /**
   * Função para Adicionar uma Receita na Grid
   */
  function js_addReceita() {

    if ($('anoUsu').value >= 2022) {
      if ($F('db83_dataassinaturacop') == '' || $F('db83_numerocontratooc') == '') {
        if ($F('c61_codigo') == 174 || $F('c61_codigo') == 179 || $F('c61_codigo') == 190 || $F('c61_codigo') == 191) {
          alert('É obrigatório informar o número do contrato da operação de crédito para as receitas de fontes 174,179,190 e 191');
          $('k81_conta').focus();
          return false;
        }
      }
    }

    if ($F('k81_receita') == '') {

      alert("Informe o código da receita.");
      $('k81_receita').focus();
      return false;
    }


    if ($F('k81_conta') == '') {

      alert("Informe o código da conta.");
      $('k81_conta').focus();
      return false;
    }

    if ($('anoUsu').value >= 2022) {
      aEstruts = ['4172150', '4172151', '4175150'];
      aEstrutsDed = ['4951728011', '4951728012', '4951758011', '4951728991'];

      if (aEstruts.indexOf($('estrutural').value.substr(0, 7)) > -1 ||
        aEstrutsDed.indexOf($('estrutural').value.substr(0, 10)) > -1 ||
        ($('estrutural').value.substr(0, 7) == '42428991' && $('recurso').value == '106')) {
        if ($('k81_regrepasse').value == '') {
          alert("É obrigatório informar o Regularização de Repasse.");
          return false;
        } else if ($('k81_regrepasse').value == 1) {
          if ($('k81_exerc').value == '') {
            alert("É obrigatório informar o Ano de Referência.");
            return false;
          } else if ($('k81_exerc').value.length < 4) {
            alert("O campo Ano de Referência deve conter obrigatoriamente 4 caracteres.");
            return false;
          }
        }
      }

      if (lEmendaParlamentarObrigatoria && $('k81_emparlamentar').value == '') {
        alert("É obrigatório informar o campo: Referente a Emenda Parlamentar.");
        return false;
      }
    }

    if ($('anoUsu').value == 2020 || $('anoUsu').value == 2021) {
      aEstruts = ['41728011', '41728012', '41758011', '41728991'];
      aEstrutsDed = ['4951728011', '4951728012', '4951758011', '4951728991'];

      if (aEstruts.indexOf($('estrutural').value.substr(0, 8)) > -1 ||
        aEstrutsDed.indexOf($('estrutural').value.substr(0, 10)) > -1 ||
        ($('estrutural').value.substr(0, 8) == '42428991' && $('recurso').value == '106')) {
        if ($('k81_regrepasse').value == '') {
          alert("É obrigatório informar o Regularização de Repasse.");
          return false;
        } else if ($('k81_regrepasse').value == 1) {
          if ($('k81_exerc').value == '') {
            alert("É obrigatório informar o Ano de Referência.");
            return false;
          } else if ($('k81_exerc').value.length < 4) {
            alert("O campo Ano de Referência deve conter obrigatoriamente 4 caracteres.");
            return false;
          }
        }
      }

      if (lEmendaParlamentarObrigatoria && $('k81_emparlamentar').value == '') {
        alert("É obrigatório informar o campo: Referente a Emenda Parlamentar.");
        return false;
      }

    }

    if ($F('k81_numcgm') == '' && $F('j01_matric') == '' && $F('q02_inscr') == '') {

      alert("Informe a origem.");
      return false;
    }

    if ($F('c58_sequencial') == '') {

      alert("Informe a característica peculiar.");
      $('c58_sequencial').focus();
      return false;
    }

    if ($F('k81_datareceb') == '') {

      alert("Informe a data do recebimento.");
      $('k81_datareceb').focus();
      return false;
    }

    if ($F('k81_valor') == '') {

      alert("Informe o valor recebido.");
      $('k81_valor').focus();
      return false;
    }

    if ($('anoUsu').value >= 2022) {

      switch (Number($F('recurso'))) {

        case 122:
          if (!$('k81_convenio').value) {
            alert("É obrigatório informar o convênio para as receitas de fontes 122, 123, 124, 142, 163, 171, 172, 173, 176, 177, 178, 181, 182 e 183. ");
            $('k81_convenio').focus();
            return false;
          }
          break;

        case 123:
          if (!$('k81_convenio').value) {
            alert("É obrigatório informar o convênio para as receitas de fontes 122, 123, 124, 142, 163, 171, 172, 173, 176, 177, 178, 181, 182 e 183. ");
            $('k81_convenio').focus();
            return false;
          }
          break;

        case 124:
          if (!$('k81_convenio').value) {
            alert("É obrigatório informar o convênio para as receitas de fontes 122, 123, 124, 142, 163, 171, 172, 173, 176, 177, 178, 181, 182 e 183. ");
            $('k81_convenio').focus();
            return false;
          }
          break;

        case 142:
          if (!$('k81_convenio').value) {
            alert("É obrigatório informar o convênio para as receitas de fontes 122, 123, 124, 142, 163, 171, 172, 173, 176, 177, 178, 181, 182 e 183. ");
            $('k81_convenio').focus();
            return false;
          }
          break;

        case 163:
          if (!$('k81_convenio').value) {
            alert("É obrigatório informar o convênio para as receitas de fontes 122, 123, 124, 142, 163, 171, 172, 173, 176, 177, 178, 181, 182 e 183. ");
            $('k81_convenio').focus();
            return false;
          }
          break;

        case 171:
          if (!$('k81_convenio').value) {
            alert("É obrigatório informar o convênio para as receitas de fontes 122, 123, 124, 142, 163, 171, 172, 173, 176, 177, 178, 181, 182 e 183. ");
            $('k81_convenio').focus();
            return false;
          }
          break;

        case 172:
          if (!$('k81_convenio').value) {
            alert("É obrigatório informar o convênio para as receitas de fontes 122, 123, 124, 142, 163, 171, 172, 173, 176, 177, 178, 181, 182 e 183. ");
            $('k81_convenio').focus();
            return false;
          }
          break;

        case 173:
          if (!$('k81_convenio').value) {
            alert("É obrigatório informar o convênio para as receitas de fontes 122, 123, 124, 142, 163, 171, 172, 173, 176, 177, 178, 181, 182 e 183. ");
            $('k81_convenio').focus();
            return false;
          }
          break;

        case 176:
          if (!$('k81_convenio').value) {
            alert("É obrigatório informar o convênio para as receitas de fontes 122, 123, 124, 142, 163, 171, 172, 173, 176, 177, 178, 181, 182 e 183. ");
            $('k81_convenio').focus();
            return false;
          }
          break;

        case 177:
          if (!$('k81_convenio').value) {
            alert("É obrigatório informar o convênio para as receitas de fontes 122, 123, 124, 142, 163, 171, 172, 173, 176, 177, 178, 181, 182 e 183. ");
            $('k81_convenio').focus();
            return false;
          }
          break;

        case 178:
          if (!$('k81_convenio').value) {
            alert("É obrigatório informar o convênio para as receitas de fontes 122, 123, 124, 142, 163, 171, 172, 173, 176, 177, 178, 181, 182 e 183. ");
            $('k81_convenio').focus();
            return false;
          }
          break;

        case 181:
          if (!$('k81_convenio').value) {
            alert("É obrigatório informar o convênio para as receitas de fontes 122, 123, 124, 142, 163, 171, 172, 173, 176, 177, 178, 181, 182 e 183. ");
            $('k81_convenio').focus();
            return false;
          }
          break;

        case 182:
          if (!$('k81_convenio').value) {
            alert("É obrigatório informar o convênio para as receitas de fontes 122, 123, 124, 142, 163, 171, 172, 173, 176, 177, 178, 181, 182 e 183. ");
            $('k81_convenio').focus();
            return false;
          }
          break;

        case 183:
          if (!$('k81_convenio').value) {
            alert("É obrigatório informar o convênio para as receitas de fontes 122, 123, 124, 142, 163, 171, 172, 173, 176, 177, 178, 181, 182 e 183. ");
            $('k81_convenio').focus();
            return false;
          }
          break;
      }
    } else {
      switch (Number($F('recurso'))) {

        case 122:
          if (!$('k81_convenio').value) {
            alert("É obrigatório informar o convênio para as receitas de fontes 122, 123, 124 e 142.");
            $('k81_convenio').focus();
            return false;
          }
          break;

        case 123:
          if (!$('k81_convenio').value) {
            alert("É obrigatório informar o convênio para as receitas de fontes 122, 123, 124 e 142.");
            $('k81_convenio').focus();
            return false;
          }
          break;

        case 124:
          if (!$('k81_convenio').value) {
            alert("É obrigatório informar o convênio para as receitas de fontes 122, 123, 124 e 142.");
            $('k81_convenio').focus();
            return false;
          }
          break;

        case 142:
          if (!$('k81_convenio').value) {
            alert("É obrigatório informar o convênio para as receitas de fontes 122, 123, 124 e 142.");
            $('k81_convenio').focus();
            return false;
          }
          break;

        case 163:
          if ($('anoUsu').value >= 2021 && (!$('k81_convenio').value) && ($('estrutural').value.substr(0, 8) == '41718113')) {
            alert("É obrigatório informar o convênio para as receitas de fontes 122, 123, 124, 142 e 163.");
            $('k81_convenio').focus();
            return false;
          }
          break;
      }
    }

    var oReceita = new Object();
    //Receita
    oReceita.iReceitaPlanilha = $F('codigo_receitaplanilha');
    oReceita.k81_receita = $F('k81_receita');
    oReceita.k02_drecei = $F('k02_drecei');

    //Conta
    oReceita.k81_conta = $F('k81_conta');
    oReceita.k13_descr = $F('k13_descr');

    //Origem
    oReceita.k81_origem = $F('k81_origem');
    oReceita.k81_numcgm = $F('k81_numcgm');
    oReceita.q02_inscr = $F('q02_inscr');
    oReceita.j01_matric = $F('j01_matric');

    //Recurso
    oReceita.k81_codigo = $F('k81_codigo');
    oReceita.k81_codigodescr = $F('k81_codigodescr');

    //Regularização Repasse
    oReceita.k81_regrepasse = $F('k81_regrepasse');
    oReceita.k81_exerc = $F('k81_exerc');

    //Referente a Emenda Parlamentar
    oReceita.k81_emparlamentar = $F('k81_emparlamentar');

    //Característica Peculiar
    oReceita.c58_sequencial = $F('c58_sequencial');

    //Data Recebimento
    oReceita.k81_datareceb = $F('k81_datareceb');

    //Dados Adicionais
    if (js_isReceitaFundeb()) {
      oReceita.k81_valor = js_arredondamentoFundeb($F('k81_valor'), 118);
    } else {
      oReceita.k81_valor = $F('k81_valor');
    }

    oReceita.k81_obs = $F('k81_obs');
    oReceita.recurso = $F('recurso');
    oReceita.k81_operbanco = $F('k81_operbanco');
    oReceita.k81_convenio = $F('k81_convenio');

    if (iAlteracao == null) {

      var oParametro = new Object();

      if (js_isReceitaFundeb()) {

        oParametro.exec = 'buscaReceitaFundep';

      } else {

        oParametro.exec = 'buscarDeducao';
        oParametro.k81_receita = $F('k81_receita');

      }

      oReceita.iIndice = "a" + iIndiceReceitas;
      aReceitas["a" + iIndiceReceitas] = oReceita;
      iIndiceReceitas++;

      var oAjax = new Ajax.Request(sRPC, {
        method: 'post',
        parameters: 'json=' + Object.toJSON(oParametro),
        onComplete: js_criaLinhaReceita
      });

    } else {

      aReceitas[iAlteracao] = oReceita;
      iAlteracao = null;
      alert("Receita inserida com sucesso!");

    }

    js_renderizarGrid();

  }

  function js_criaLinhaReceita(oAjax) {

    var oRetorno = eval("(" + oAjax.responseText + ")");

    if (oRetorno.status == 2) {

      alert(oRetorno.message.urlDecode());

      if (js_isReceitaFundeb()) {
        oGridReceitas.clearAll(true);
        iIndiceReceitas--;
      }

    } else if (oRetorno.oReceita.k02_codigo != undefined) {

      alert("Receita inserida com sucesso!");

      var oReceita = new Object();
      //Receita
      oReceita.iReceitaPlanilha = $F('codigo_receitaplanilha');
      oReceita.k81_receita = oRetorno.oReceita.k02_codigo;
      oReceita.k02_drecei = oRetorno.oReceita.k02_descr.urlDecode();

      //Conta
      oReceita.k81_conta = $F('k81_conta');
      oReceita.k13_descr = $F('k13_descr');

      //Origem
      oReceita.k81_origem = $F('k81_origem');
      oReceita.k81_numcgm = $F('k81_numcgm');
      oReceita.q02_inscr = $F('q02_inscr');
      oReceita.j01_matric = $F('j01_matric');

      //Recurso
      oReceita.k81_codigo = $F('k81_codigo');
      oReceita.k81_codigodescr = $F('k81_codigodescr');

      //Regularização Repasse
      oReceita.k81_regrepasse = $F('k81_regrepasse');
      oReceita.k81_exerc = $F('k81_exerc');

      //Referente a Emenda Parlamentar
      oReceita.k81_emparlamentar = $F('k81_emparlamentar');

      //Característica Peculiar
      oReceita.c58_sequencial = $F('c58_sequencial');

      //Data Recebimento
      oReceita.k81_datareceb = $F('k81_datareceb');

      //Dados Adicionais
      if (js_isReceitaFundeb()) {
        oReceita.k81_valor = js_arredondamentoFundeb($F('k81_valor'), 119);
      } else {
        oReceita.k81_valor = (new Number($F('k81_valor')) * 0.20) * (-1);
      }

      oReceita.k81_obs = $F('k81_obs');
      oReceita.recurso = oRetorno.oReceita.o70_codigo;
      oReceita.k81_operbanco = $F('k81_operbanco');
      oReceita.k81_convenio = $F('k81_convenio');

      if (iAlteracao == null) {

        oReceita.iIndice = "a" + iIndiceReceitas;
        aReceitas["a" + iIndiceReceitas] = oReceita;
        iIndiceReceitas++;

      }

      js_renderizarGrid();

    }
  }

  /**
   * Função para redesenhar a grid na tela
   */
  function js_renderizarGrid() {

    oGridReceitas.clearAll(true);
    var nTotalReceitas = 0;
    for (var iIndice in aReceitas) {

      var oReceita = aReceitas[iIndice];

      if (typeof(oReceita) == 'function') {
        continue;
      }
      var aRow = new Array();
      aRow[0] = iIndice;
      aRow[1] = oReceita.k81_conta + " - " + oReceita.k13_descr;
      aRow[2] = oReceita.k81_receita + " - " + oReceita.k02_drecei;
      aRow[3] = js_formatar(oReceita.k81_valor, "f");
      aRow[4] = "<input type='button' onclick=js_mostraReceita(\'" + iIndice + "\') value='A'/>";
      oGridReceitas.addRow(aRow);
      nTotalReceitas = (new Number(nTotalReceitas) + new Number(oReceita.k81_valor));
    }
    oGridReceitas.renderRows();
    $('TotalForCol4').innerHTML = "Total: " + js_formatar(nTotalReceitas, 'f');
  }

  /**
   * Função que mostra na tela, para alteração, uma receita selecionada através da grid
   */
  function js_mostraReceita(iIndice) {

    iAlteracao = iIndice;
    $('codigo_receitaplanilha').value = aReceitas[iIndice].iReceitaPlanilha;
    $('k81_receita').value = aReceitas[iIndice].k81_receita;
    $('k81_conta').value = aReceitas[iIndice].k81_conta;

    $('k81_origem').value = aReceitas[iIndice].k81_origem;
    $('k81_numcgm').value = aReceitas[iIndice].k81_numcgm;
    $('q02_inscr').value = aReceitas[iIndice].q02_inscr;
    $('j01_matric').value = aReceitas[iIndice].j01_matric;

    $('c58_sequencial').value = aReceitas[iIndice].c58_sequencial;
    $('k81_datareceb').value = aReceitas[iIndice].k81_datareceb;
    $('k81_valor').value = aReceitas[iIndice].k81_valor;
    $('k81_obs').value = aReceitas[iIndice].k81_obs;
    $('recurso').value = aReceitas[iIndice].recurso;
    $('k81_regrepasse').value = aReceitas[iIndice].k81_regrepasse;
    $('k81_exerc').value = aReceitas[iIndice].k81_exerc;
    $('iEmParlamentarAux').value = aReceitas[iIndice].k81_emparlamentar;
    $('k81_operbanco').value = aReceitas[iIndice].k81_operbanco;
    $('k81_convenio').value = aReceitas[iIndice].k81_convenio;
    $('bAtualiza').value = 1;

    js_pesquisaReceita(false);
    js_pesquisaCgm(false);
    js_pesquisaMatricula(false);
    js_pesquisaInscricao(false);
    js_pesquisaPeculiar(false);
    js_pesquisaConta(false);

    $('k81_codigo').value = aReceitas[iIndice].k81_codigo;
    $('k81_codigodescr').value = aReceitas[iIndice].k81_codigodescr;
  }

  function js_salvarPlanilha() {

    if (lMenuAlteracao && !$F('k80_codpla')) {
      alert("Selecione uma planilha para alteração.");
      return false;
    }
    var aReceitasPlanilha = new Array();

    for (var iIndice in aReceitas) {

      var oReceitaTela = aReceitas[iIndice];

      if (typeof(oReceitaTela) == 'function') {
        continue;
      }

      var oReceita = new Object();
      oReceita.iReceitaPlanilha = oReceitaTela.iReceitaPlanilha;
      oReceita.iOrigem = oReceitaTela.k81_origem;
      oReceita.iCgm = oReceitaTela.k81_numcgm;
      oReceita.iInscricao = oReceitaTela.q02_inscr;
      oReceita.iMatricula = oReceitaTela.j01_matric;
      oReceita.iCaracteriscaPeculiar = oReceitaTela.c58_sequencial;
      oReceita.iContaTesouraria = oReceitaTela.k81_conta;
      oReceita.sObservacao = encodeURIComponent(tagString(oReceitaTela.k81_obs));
      oReceita.nValor = js_round(oReceitaTela.k81_valor, 2);
      oReceita.iRecurso = oReceitaTela.recurso;
      oReceita.iRegRepasse = oReceitaTela.k81_regrepasse;
      oReceita.iExerc = oReceitaTela.k81_exerc;
      oReceita.iEmParlamentar = oReceitaTela.k81_emparlamentar;
      oReceita.iReceita = oReceitaTela.k81_receita;
      oReceita.dtRecebimento = oReceitaTela.k81_datareceb;
      oReceita.sOperacaoBancaria = oReceitaTela.k81_operbanco;
      oReceita.iConvenio = oReceitaTela.k81_convenio;

      aReceitasPlanilha.push(oReceita);
    }

    if (aReceitasPlanilha.length == 0) {

      alert("Não é possível incluir uma planilha zerada.");
      return false;
    }

    var sMensagemSalvar = "Deseja salvar a planilha de arrecadação?\n\n";
    sMensagemSalvar += "Este procedimento pode demandar algum tempo.";
    if (!confirm(sMensagemSalvar)) {
      return false;
    }

    js_divCarregando("Aguarde, salvando planilha de arrecadação...", "msgBox");

    var oParametro = new Object();
    oParametro.exec = 'salvarPlanilha';
    oParametro.k144_numeroprocesso = encodeURIComponent(tagString($F('k144_numeroprocesso')));

    if (lMenuAlteracao) {
      oParametro.exec = 'alterarPlanilha';
    }

    oParametro.iCodigoPlanilha = $F("k80_codpla");
    oParametro.aReceitas = aReceitasPlanilha;

    var oAjax = new Ajax.Request(sRPC, {
      method: 'post',
      parameters: 'json=' + Object.toJSON(oParametro),
      onComplete: js_completaSalvar
    });

  }

  function js_completaSalvar(oAjax) {

    js_removeObj('msgBox');
    var oRetorno = eval("(" + oAjax.responseText + ")");
    if (oRetorno.status == 1) {

      if (confirm(oRetorno.message.urlDecode())) {

        var sUrlOpen = "cai2_emiteplanilha002.php?codpla=" + oRetorno.iCodigoPlanilha;
        var oJanelaRelatorio = window.open(sUrlOpen, '', 'width=' + (screen.availWidth - 5) + ',height=' + (screen.availHeight - 40) + ',scrollbars=1,location=0 ');
      }

      js_autenticar(oRetorno.iCodigoPlanilha);
      //js_novaReceita();
    } else {
      alert(oRetorno.message.urlDecode());
    }
    //document.form1.reset();
  }


  /**
   * função para retornar registros selecinados na grid
   *
   */
  function getSelecionados() {

    var aListaCheckbox = oGridReceitas.getSelection("object");
    var aListaSelecionados = new Array();

    aListaCheckbox.each(
      function(aRow) {
        aListaSelecionados.push(aRow.aCells[1].getValue());
      });

    return aListaSelecionados;
  }

  function js_excluiSelecionados() {

    var aSelecionados = getSelecionados();
    aSelecionados.each(
      function(oSelecionado, iIndice) {
        delete aReceitas[oSelecionado];
      }
    );
    js_renderizarGrid();
  }

  /**
   * Funções para importar dados de uma segunda planilha
   **/
  function js_pesquisaPlanilha(lImportarPlanilha) {

    var sAutenticadas = '';
    lImportacao = lImportarPlanilha;
    if (lMenuAlteracao && !lImportarPlanilha) {
      sAutenticadas = '&lAutenticada=false';
    }
    js_OpenJanelaIframe('top.corpo', 'db_iframe_placaixa', 'func_placaixa.php?lPlanilhasSemSlip=true&funcao_js=parent.js_getItensPlanilha|k80_codpla' + sAutenticadas, 'Pesquisa', true);
  }

  function js_getItensPlanilha(iCodigoPlanilha) {

    if (!lMenuAlteracao && lImportacao && !confirm("Deseja importar dados da planilha " + iCodigoPlanilha + " ?")) {
      return false;
    }

    db_iframe_placaixa.hide();
    js_divCarregando("Aguarde, buscando dados da planilha...", "msgBox");

    var oParametro = new Object();
    oParametro.exec = 'importarPlanilha';
    oParametro.iPlanilha = iCodigoPlanilha;


    new Ajax.Request(sRPC, {
      method: 'post',
      parameters: 'json=' + Object.toJSON(oParametro),
      onComplete: js_completaImportar
    });
  }

  /**
   * Função que cria um objeto para cada receita da planilha importada, adicionando ao array (objeto)
   * que possui todas receitas que serão vinculadas a planilha atual
   */
  function js_completaImportar(oAjax) {

    js_removeObj('msgBox');
    var oRetorno = eval("(" + oAjax.responseText + ")");

    if (lMenuAlteracao && !lImportacao) {

      aReceitas = new Array();
      iPlanilha = oRetorno.oPlanilha.iPlanilha;
      dtDataCriacao = oRetorno.oPlanilha.dtDataCriacao;

      $('k80_codpla').value = oRetorno.oPlanilha.iPlanilha;
      $('k80_data').value = oRetorno.oPlanilha.dtDataCriacao;
    }

    var oInputProcesso = $('k144_numeroprocesso');
    oInputProcesso.value = "";
    if (oRetorno.oPlanilha.k144_numeroprocesso != null) {
      oInputProcesso.value = oRetorno.oPlanilha.k144_numeroprocesso.urlDecode();
    }

    //Adiciona as novas receitas importadas ao array de receitas
    var convenio;

    oRetorno.oPlanilha.aReceitas.each(

      function(oReceita) {

        var oReceitaImportada = new Object();
        if (!lImportacao) {
          oReceitaImportada.iReceitaPlanilha = oReceita.iCodigo;
        }
        oReceitaImportada.k81_receita = oReceita.iReceita;
        oReceitaImportada.k02_drecei = oReceita.sDescricaoReceita.urlDecode();

        oReceitaImportada.k81_origem = oReceita.iOrigem;
        oReceitaImportada.k81_numcgm = oReceita.iCgm;
        oReceitaImportada.q02_inscr = oReceita.iInscricao;
        oReceitaImportada.j01_matric = oReceita.iMatricula;

        oReceitaImportada.c58_sequencial = oReceita.iCaracteriscaPeculiar;
        oReceitaImportada.k81_conta = oReceita.iContaTesouraria;
        oReceitaImportada.k13_descr = oReceita.sDescricaoConta.urlDecode();

        oReceitaImportada.k81_datareceb = oReceita.dtRecebimento;
        oReceitaImportada.k81_obs = oReceita.sObservacao.urlDecode();
        oReceitaImportada.recurso = oReceita.iRecurso;
        oReceitaImportada.k81_regrepasse = oReceita.iRegRepasse;
        oReceitaImportada.k81_exerc = oReceita.iExerc;
        oReceitaImportada.k81_emparlamentar = oReceita.iEmParlamentar;
        oReceitaImportada.k81_valor = oReceita.nValor;
        oReceitaImportada.k81_operbanco = oReceita.sOperacaoBancaria.urlDecode();
        oReceitaImportada.k81_convenio = convenio = oReceita.iConvenio;

        //Adiciona índice na receita e adiciona no array de receitas (cria propriedade no objeto)
        oReceitaImportada.iIndice = "a" + iIndiceReceitas;
        aReceitas["a" + iIndiceReceitas] = oReceitaImportada;
        iIndiceReceitas++;
      }
    );
    js_renderizarGrid();

    js_OpenJanelaIframe('', 'db_iframe_convconvenios', 'func_convconvenios.php?pesquisa_chave=' + convenio + '&funcao_js=parent.js_mostrak81_convenio', 'Pesquisa', false);

    if (lMenuAlteracao && !lImportacao) {

      $('k80_codpla').value = oRetorno.oPlanilha.iPlanilha;
      $('k80_data').value = oRetorno.oPlanilha.dtDataCriacao;
    }
  }

  js_gridReceitas();
  toogleOrigem();

  if (lMenuAlteracao) {
    js_pesquisaPlanilha(false);
  }

  /**
   * Verifica se a conta da receita orcamentária é igual ao código da conta
   *
   * @returns {Boolean}
   */
  function js_mostrarNotificacaoConta() {

    var iContaReceita = $('recurso').value;
    var iConta = $('c61_codigo').value;

    if (!empty(iContaReceita) && !empty(iConta)) {

      var sTipoReceita = $('k02_tipo').value;

      if ((sTipoReceita == 'O') && (iConta !== iContaReceita)) {

        var sMensagem = _M(CAMINHO_MENSAGEM + 'contas_diferentes', {
          ContaReceita: iContaReceita,
          Conta: iConta
        });

        $('notificacao').childElements()[0].update("");
        $('notificacao').childElements()[0].insert("<b>" + sMensagem + "</b>");

        $('notificacao').setStyle({
          display: 'table-row'
        });

        return true;
      }
    }

    $('notificacao').setStyle({
      display: 'none'
    });

    return false;
  }
  //OC5689
  function js_mostrarNotificacaoEstruturais() {

    var iEstrutural = $('estrutural').value;
    if ($('anoUsu').value >= 2022) {
      if (($('estrutural').value.substr(0, 7) == '4121004' || $('estrutural').value.substr(0, 7) == '4721004' || $('estrutural').value.substr(0, 5) == '41215' || $('estrutural').value.substr(0, 5) == '47215') && $('k81_numcgm').value == "") {

        var sMensagem = "Ao arrecadar receitas de contribuições para o Regime Próprio de Previdência Social é obrigatório informar o CGM do Contribuinte.";

        $('notificacao2').childElements()[0].update("");
        $('notificacao2').childElements()[0].insert("<b>" + sMensagem + "</b>");

        $('notificacao2').setStyle({
          display: 'table-row'
        });

        return true;
      }
    } else {
      if (($('estrutural').value.substr(0, 7) == '4121004' || $('estrutural').value.substr(0, 7) == '4721004' || $('estrutural').value.substr(0, 5) == '41218' || $('estrutural').value.substr(0, 5) == '47218') && $('k81_numcgm').value == "") {

        var sMensagem = "Ao arrecadar receitas de contribuições para o Regime Próprio de Previdência Social é obrigatório informar o CGM do Contribuinte.";

        $('notificacao2').childElements()[0].update("");
        $('notificacao2').childElements()[0].insert("<b>" + sMensagem + "</b>");

        $('notificacao2').setStyle({
          display: 'table-row'
        });

        return true;
      }
    }

    $('notificacao2').setStyle({
      display: 'none'
    });

    return false;
  }

  /**
   * Verifica se a conta possui convênio cadastrado
   *
   * @returns {Boolean}
   */
  function js_mostrarNotificacaoConvenio(oSaltesConvenio) {

    if (oSaltesConvenio) {

      if (!oSaltesConvenio.lValidacao) {

        $('notificacao-conv').childElements()[0].update("");
        $('notificacao-conv').childElements()[0].insert("<b>" + oSaltesConvenio.sMensagem + "</b>");

        $('notificacao-conv').setStyle({
          display: 'table-row'
        });

        return true;

      }
    }

    $('notificacao-conv').setStyle({
      display: 'none'
    });

    return false;
  }

  function js_autenticar(iPlaninhaAutentica) {


    if (iPlaninhaAutentica == '') {

      alert('Planilha de arrecadação não localizada.');
      return false;
    }

    var sMensagemSalvar = "Deseja autenticar a planilha de arrecadação selecionada?\n\n";
    sMensagemSalvar += "Este procedimento pode demandar algum tempo.";
    if (!confirm(sMensagemSalvar)) {
      return false;
    }

    js_divCarregando("Aguarde, autenticando planilha de arrecadação...", "msgBox");

    var oParametro = new Object();
    oParametro.exec = 'autenticarPlanilha';
    oParametro.iPlanilha = iPlaninhaAutentica;
    oParametro.k144_numeroprocesso = encodeURIComponent(tagString($F("k144_numeroprocesso")));

    var oAjax = new Ajax.Request(sRPC, {
      method: 'post',
      parameters: 'json=' + Object.toJSON(oParametro),
      onComplete: js_retornoAutenticacao
    });
  }

  function js_retornoAutenticacao(oAjax) {

    js_removeObj('msgBox');
    var oRetorno = eval("(" + oAjax.responseText + ")");

    if (oRetorno.status == 1) {
      alert("Planilha " + oRetorno.iPlanilha + " autenticada com sucesso");
      js_novaReceita();
    } else {
      alert(oRetorno.message.urlDecode());
    }
  }

  function js_toogleRegRepasse(opcao) {
    if (opcao == 1) {
      document.getElementById('exercicioLabel').style.display = "table-cell";
      document.getElementById('exercicioInput').style.display = "table-cell";
    } else if (opcao == 2 || opcao == '') {
      document.getElementById('exercicioLabel').style.display = "none";
      document.getElementById('exercicioInput').style.display = "none";
      document.getElementById('k81_exerc').value = "";
    }
  }

  function js_verificaEmendaParlamentar() {

    let sReceita = $('estrutural').value.substr(0, 9);
    let sRecurso = $('recurso').value;


    if ($('anoUsu').value >= 2022) {
      lEmendaParlamentarObrigatoria = (
        (sReceita == '417199901' && sRecurso == '100') ||
        (sReceita == '424199901' && sRecurso == '100') ||
        (sReceita == '417299901' && sRecurso == '100') ||
        (sReceita == '424299901' && sRecurso == '100') ||
        (sReceita == '417175001' && sRecurso == '123') ||
        (sReceita == '417175101' && sRecurso == '122') ||
        (sReceita == '417175201' && sRecurso == '142') ||
        (sReceita == '417175301' && sRecurso == '124') ||
        (sReceita == '417175401' && sRecurso == '124') ||
        (sReceita == '417179900' && sRecurso == '124') ||
        (sReceita == '424145001' && sRecurso == '123') ||
        (sReceita == '424145101' && sRecurso == '122') ||
        (sReceita == '424145201' && sRecurso == '124') ||
        (sReceita == '424145301' && sRecurso == '124') ||
        (sReceita == '424145401' && sRecurso == '124') ||
        (sReceita == '424149901' && sRecurso == '124') ||
        (sReceita == '424149901' && sRecurso == '142') ||
        (sReceita == '417245001' && sRecurso == '123') ||
        (sReceita == '417245101' && sRecurso == '122') ||
        (sReceita == '417249901' && sRecurso == '124') ||
        (sReceita == '417249901' && sRecurso == '142') ||
        (sReceita == '424225001' && sRecurso == '123') ||
        (sReceita == '424225101' && sRecurso == '122') ||
        (sReceita == '424225201' && sRecurso == '124') ||
        (sReceita == '424225301' && sRecurso == '124') ||
        (sReceita == '424225401' && sRecurso == '124') ||
        (sReceita == '424229901' && sRecurso == '124') ||
        (sReceita == '424229901' && sRecurso == '142') ||
        (sReceita == '417135011' && sRecurso == '159') ||
        (sReceita == '417135021' && sRecurso == '159') ||
        (sReceita == '417135031' && sRecurso == '159') ||
        (sReceita == '417135041' && sRecurso == '159') ||
        (sReceita == '417135051' && sRecurso == '159') ||
        (sReceita == '417135091' && sRecurso == '154') ||
        (sReceita == '417135111' && sRecurso == '153') ||
        (sReceita == '417135121' && sRecurso == '153') ||
        (sReceita == '417135131' && sRecurso == '153') ||
        (sReceita == '417135151' && sRecurso == '153') ||
        (sReceita == '417165001' && sRecurso == '129') ||
        (sReceita == '424115011' && sRecurso == '159') ||
        (sReceita == '424115021' && sRecurso == '159') ||
        (sReceita == '424115031' && sRecurso == '159') ||
        (sReceita == '424115041' && sRecurso == '159') ||
        (sReceita == '424115051' && sRecurso == '159') ||
        (sReceita == '424115091' && sRecurso == '154') ||
        (sReceita == '424115111' && sRecurso == '153') ||
        (sReceita == '424115121' && sRecurso == '153') ||
        (sReceita == '424115141' && sRecurso == '153') ||
        (sReceita == '424115151' && sRecurso == '153') ||
        (sReceita == '424135001' && sRecurso == '129') ||
        (sReceita == '417295101' && sRecurso == '156') ||
        (sReceita == '424215001' && sRecurso == '154') ||
        (sReceita == '424215001' && sRecurso == '155') ||
        (sRecurso == '164') ||
        (sRecurso == '169')
      );

    } else {
      lEmendaParlamentarObrigatoria = (
        (sReceita == '417189911' && sRecurso == '100') ||
        (sReceita == '417189911' && sRecurso == '164') ||
        (sReceita == '424189911' && sRecurso == '100') ||
        (sReceita == '424189911' && sRecurso == '164') ||
        (sReceita == '417289911' && sRecurso == '100') ||
        (sReceita == '417289911' && sRecurso == '164') ||
        (sReceita == '424289911' && sRecurso == '100') ||
        (sReceita == '424289911' && sRecurso == '164') ||
        (sReceita == '417181011' && sRecurso == '123') ||
        (sReceita == '417181021' && sRecurso == '122') ||
        (sReceita == '417181031' && sRecurso == '142') ||
        (sReceita == '417181041' && sRecurso == '124') ||
        (sReceita == '417181051' && sRecurso == '124') ||
        (sReceita == '417181091' && sRecurso == '124') ||
        (sReceita == '424181011' && sRecurso == '123') ||
        (sReceita == '424181021' && sRecurso == '122') ||
        (sReceita == '424181051' && sRecurso == '124') ||
        (sReceita == '424181061' && sRecurso == '124') ||
        (sReceita == '424181071' && sRecurso == '124') ||
        (sReceita == '424181091' && sRecurso == '124') ||
        (sReceita == '424181091' && sRecurso == '142') ||
        (sReceita == '417281011' && sRecurso == '123') ||
        (sReceita == '417281021' && sRecurso == '122') ||
        (sReceita == '417281091' && sRecurso == '124') ||
        (sReceita == '417281091' && sRecurso == '142') ||
        (sReceita == '424281011' && sRecurso == '123') ||
        (sReceita == '424281021' && sRecurso == '122') ||
        (sReceita == '424281051' && sRecurso == '124') ||
        (sReceita == '424281061' && sRecurso == '124') ||
        (sReceita == '424281071' && sRecurso == '124') ||
        (sReceita == '424281091' && sRecurso == '124') ||
        (sReceita == '424281091' && sRecurso == '142') ||
        (sReceita == '417180311' && sRecurso == '159') ||
        (sReceita == '417180321' && sRecurso == '159') ||
        (sReceita == '417180331' && sRecurso == '159') ||
        (sReceita == '417180341' && sRecurso == '159') ||
        (sReceita == '417180351' && sRecurso == '159') ||
        (sReceita == '417180391' && sRecurso == '154') ||
        (sReceita == '417180411' && sRecurso == '153') ||
        (sReceita == '417180421' && sRecurso == '153') ||
        (sReceita == '417180431' && sRecurso == '153') ||
        (sReceita == '417180441' && sRecurso == '153') ||
        (sReceita == '417180451' && sRecurso == '153') ||
        (sReceita == '417180461' && sRecurso == '153') ||
        (sReceita == '417180461' && sRecurso == '154') ||
        (sReceita == '417181211' && sRecurso == '129') ||
        (sReceita == '424180311' && sRecurso == '159') ||
        (sReceita == '424180321' && sRecurso == '159') ||
        (sReceita == '424180331' && sRecurso == '159') ||
        (sReceita == '424180341' && sRecurso == '159') ||
        (sReceita == '424180351' && sRecurso == '159') ||
        (sReceita == '424180391' && sRecurso == '154') ||
        (sReceita == '424180411' && sRecurso == '153') ||
        (sReceita == '424180421' && sRecurso == '153') ||
        (sReceita == '424180431' && sRecurso == '153') ||
        (sReceita == '424180441' && sRecurso == '153') ||
        (sReceita == '424180451' && sRecurso == '153') ||
        (sReceita == '424180461' && sRecurso == '154') ||
        (sReceita == '424181211' && sRecurso == '129') ||
        (sReceita == '417280311' && sRecurso == '155') ||
        (sReceita == '417280711' && sRecurso == '156') ||
        (sReceita == '424280311' && sRecurso == '154') ||
        (sReceita == '424280311' && sRecurso == '155')
      );
    }

    if (lEmendaParlamentarObrigatoria) {
      document.getElementById("k81_emparlamentar").options[0].selected = true;
    } else {
      document.getElementById("k81_emparlamentar").options[3].selected = true;
    }

  }

  function js_verificaRegularizaRepasse() {

    if ($('anoUsu').value >= 2022) {
      aEstruts = ['4172150', '4172151', '4175150'];
      aEstrutsDed = ['4951728011', '4951728012', '4951758011', '4951728991'];

      if (aEstruts.indexOf($('estrutural').value.substr(0, 7)) > -1 ||
        aEstrutsDed.indexOf($('estrutural').value.substr(0, 10)) > -1 ||
        ($('estrutural').value.substr(0, 7) == '42428991' && $('recurso').value == '106')) {

        document.getElementById('regrepasse').style.display = "table-row";
        if ($('k81_regrepasse').value != '') {
          document.getElementById("k81_regrepasse").options[$('k81_regrepasse').value].selected = true;
          if ($('k81_regrepasse').value == 1) {
            document.getElementById('exercicioLabel').style.display = "table-cell";
            document.getElementById('exercicioInput').style.display = "table-cell";
          } else {
            document.getElementById('exercicioLabel').style.display = "none";
            document.getElementById('exercicioInput').style.display = "none";
          }
        } else {
          document.getElementById("k81_regrepasse").options[0].selected = true;
        }

      } else {
        document.getElementById('regrepasse').style.display = "none";
        document.getElementById('exercicioLabel').style.display = "none";
        document.getElementById('exercicioInput').style.display = "none";
        document.getElementById('k81_exerc').value = "";
        document.getElementById("k81_regrepasse").options[0].selected = "true";
      }
    }

    if ($('anoUsu').value == 2020 || $('anoUsu').value == 2021) {
      aEstruts = ['41728011', '41728012', '41758011', '41728991'];
      aEstrutsDed = ['4951728011', '4951728012', '4951758011', '4951728991'];

      if (aEstruts.indexOf($('estrutural').value.substr(0, 8)) > -1 ||
        aEstrutsDed.indexOf($('estrutural').value.substr(0, 10)) > -1 ||
        ($('estrutural').value.substr(0, 8) == '42428991' && $('recurso').value == '106')) {

        document.getElementById('regrepasse').style.display = "table-row";
        if ($('k81_regrepasse').value != '') {
          document.getElementById("k81_regrepasse").options[$('k81_regrepasse').value].selected = true;
          if ($('k81_regrepasse').value == 1) {
            document.getElementById('exercicioLabel').style.display = "table-cell";
            document.getElementById('exercicioInput').style.display = "table-cell";
          } else {
            document.getElementById('exercicioLabel').style.display = "none";
            document.getElementById('exercicioInput').style.display = "none";
          }
        } else {
          document.getElementById("k81_regrepasse").options[0].selected = true;
        }

      } else {
        document.getElementById('regrepasse').style.display = "none";
        document.getElementById('exercicioLabel').style.display = "none";
        document.getElementById('exercicioInput').style.display = "none";
        document.getElementById('k81_exerc').value = "";
        document.getElementById("k81_regrepasse").options[0].selected = "true";
      }
    }

  }

  function js_isReceitaFundeb() {

    let sEstrutural = $('estrutural').value.substr(0, 9);
    let sRecurso = $('recurso').value;
    let iAno = $('anoUsu').value;

    return (iAno >= 2021 && sRecurso == '118' && (sEstrutural == '417580111' || sEstrutural == '417180911')) ? true : false;

  }

  /**
   * Em arrecadações do fundeb, a receita é desdobrada em duas fontes: 
   * 70% para fonte 118 e 30% para fonte 119.
   * Em algumas situações a função js_round arredonda os valores causando diferença de 0.01 no valor total da arrecadação. 
   * Essa função verifica se há divergência no valor final, e, caso exista,
   * a diferença é atribuída para fonte 118.
   */
  function js_arredondamentoFundeb(fValor, iTipo) {

    let fTotal = js_round((new Number(fValor)), 2);
    let fVl118 = js_round((new Number(fValor) * 0.70), 2);
    let fVl119 = js_round((new Number(fValor) * 0.30), 2);

    let fDif = js_round((fTotal - (fVl118 + fVl119)), 2);

    if (fDif > 0) {
      fVl118 += fDif;
      fVl119 = js_round((fTotal - fVl118), 2);
    } else {
      fVl119 += fDif;
      fVl118 = js_round((fTotal - fVl119), 2);
    }

    return iTipo == 118 ? fVl118 : fVl119;

  }
</script>