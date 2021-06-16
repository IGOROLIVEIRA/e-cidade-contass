<?php
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_utils.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_liclicita_classe.php");
require_once("classes/db_liclicitaproc_classe.php");
require_once("classes/db_pctipocompra_classe.php");
require_once("classes/db_pctipocompranumero_classe.php");
require_once("classes/db_pccfeditalnum_classe.php");
require_once("classes/db_db_usuarios_classe.php");
require_once("classes/db_liclicitemlote_classe.php");
require_once("classes/db_liclicitem_classe.php");
require_once("classes/db_pcorcamitemlic_classe.php");
require_once("classes/db_pcorcamdescla_classe.php");
require_once("classes/db_cflicita_classe.php");
require_once("classes/db_homologacaoadjudica_classe.php");
require_once("classes/db_liccomissaocgm_classe.php");
require_once("classes/db_condataconf_classe.php");
require_once("classes/db_manutencaolicitacao_classe.php");

$clrotulo = new rotulocampo;
$clrotulo->label("pc10_numero");
$clrotulo->label("l20_codigo");
$clrotulo->label("pc80_codproc");
$clrotulo->label("l20_licsituacao");
$clrotulo->label("l03_codigo");
$clrotulo->label("l03_descr");
$clrotulo->label("pc50_descr");
$clrotulo->label("l34_protprocesso");
$clrotulo->label("p58_numero");
$clrotulo->label("l20_nroedital");

$clliclicita          = new cl_liclicita;
$clliclicitaproc      = new cl_liclicitaproc;
$clpctipocompra       = new cl_pctipocompra;
$clpctipocompranumero = new cl_pctipocompranumero;
$cldb_usuarios        = new cl_db_usuarios;
$clliclicitemlote     = new cl_liclicitemlote;
$clliclicitem         = new cl_liclicitem;
$clpcorcamitemlic     = new cl_pcorcamitemlic;
$clpcorcamdescla      = new cl_pcorcamdescla;
$clcflicita           = new cl_cflicita;
$oDaoLicitaPar        = new cl_pccflicitapar;
$clhomologacao        = new cl_homologacaoadjudica;
$clliccomissaocgm     = new cl_liccomissaocgm;
$clpccfeditalnum      = new cl_pccfeditalnum;
$clmanutencaolicitacao = new cl_manutencaolicitacao;

parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);

$cl_scripts = new cl_scripts;

$anousu = db_getsession("DB_anousu");
$instit = db_getsession("DB_instit");
$db_opcao = 3;
if (isset($alterar)) {
  $bmsg = false;
  $result_geral = $clliclicita->sql_record($clliclicita->sql_query_file(null, "max(l20_edital) as edital", null, "l20_instit=$instit and l20_instit = " . db_getsession('DB_instit') . "and l20_anousu = " . db_getsession("DB_anousu")));
  if ($l20_edital != $l20_edital_old) {
    $change = true;
    if ($clliclicita->numrows > 0) {
      db_fieldsmemory($result_geral, 0, 1);
      //verifica se existe edital maior ou igual.
      if ($l20_edital >= $l20_edital_old) {
        $numero = $l20_edital;
        $numero_geral = $clliclicita->sql_record($clliclicita->sql_query_file(null, "l20_edital", null, "l20_edital=$numero and l20_instit = " . db_getsession('DB_instit') . "and l20_anousu = " . db_getsession("DB_anousu")));
        if ($clliclicita->numrows > 0) {
          db_msgbox("Já existe licitação com o processo licitatório $numero");
          $erro = true;
          $bmsg = true;
        }
      }

      //verifica se existe edital menor
      if ($l20_edital < $l20_edital_old) {
        $numero = $l20_edital;
        $numero_geral = $clliclicita->sql_record($clliclicita->sql_query_file(null, "l20_edital", null, "l20_edital=$numero and l20_instit = " . db_getsession('DB_instit') . "and l20_anousu = " . db_getsession("DB_anousu")));
        if ($clliclicita->numrows == 0) {
          $l20_edital = $l20_edital;
        } else {
          db_msgbox("Já existe licitação com o processo licitatório $numero");
          $erro = true;
          $bmsg = true;
        }
      }
    }
  }

  if ($l20_numero != $l20_numero_old) {
    $change = true;
    /* Tratamento do campo l20_numero. */
    $clliclicita_edital = new cl_liclicita;

    $sSqlModalidadeAtual    = $clliclicita_edital->sql_query_edital(null, "distinct pc50_pctipocompratribunal as codtribunalatual", null, "l20_instit = $instit and l20_codigo = $l20_codigo and l20_anousu = " . db_getsession("DB_anousu"));
    $result_modalidadeAtual = $clliclicita_edital->sql_record($sSqlModalidadeAtual);
    //        echo $sSqlModalidadeAtual;
    //        db_criatabela($result_modalidadeAtual);exit;
    db_fieldsmemory($result_modalidadeAtual, 0, 1);

    $sSqlModalidade    = $clliclicita_edital->sql_query_edital(null, "distinct pc50_pctipocompratribunal as searchcodtribunal,l20_numero", null, "l20_instit = $instit and l20_numero = $l20_numero and pc50_pctipocompratribunal = $codtribunalatual and l20_anousu = " . db_getsession("DB_anousu"));
    $result_modalidade = $clliclicita_edital->sql_record($sSqlModalidade);
    //        echo $sSqlModalidade;
    //        db_criatabela($result_modalidade);exit;
    if ($clliclicita_edital->numrows > 0) {
      db_msgbox("Já existe licitação com a modalidade $l20_numero");
      $erro_edital = true;
      $bmsg = true;
    }
  }

  if ($l20_nroedital != $l20_nroedital_old) {
    $change = true;
    /* Tratamento do campo l20_nroedital. */
    $clliclicita_edital = new cl_liclicita;
    $sSqlMaxEdital = $clliclicita_edital->sql_query_file(null, "max(l20_nroedital) as nroedital", null, "l20_instit = $instit and l20_anousu = " . db_getsession("DB_anousu"));
    $result_geral_edital = $clliclicita_edital->sql_record($sSqlMaxEdital);

    if ($clliclicita_edital->numrows > 0) {

      db_fieldsmemory($result_geral_edital, 0, 1);
      //verifica se existe edital maior ou igual.

      $numero = $l20_nroedital;

      $sWhere = "l20_nroedital = $numero and l20_instit = $instit and l20_anousu = $anousu";
      $numero_geral = $clliclicita_edital->sql_record($clliclicita_edital->sql_query_file(null, "l20_nroedital", null, $sWhere));

      if ($clliclicita_edital->numrows > 0) {
        db_msgbox("Já existe licitação com o edital número $numero");
        $erro_edital = true;
        $bmsg = true;
      }
    }
  }

  if ($manutlic_codunidsubanterior != $manutlic_codunidsubanterior_old) {
    $change = true;

    $sSqlMaxManutLic = $clmanutencaolicitacao->sql_query_file(null, "max(manutlic_sequencial)", null, "manutlic_licitacao = $l20_codigo");
    $clmanutencaolicitacao->sql_record($sSqlMaxEdital);

    if ($clmanutencaolicitacao->numrows > 0) {
      $clmanutencaolicitacao->excluir('', "manutlic_licitacao = $l20_codigo");
    }
  }

  if (!isset($erro) && !$erro_edital && $change == true) {
    //print_r($_POST);exit;
    $clliclicita->l20_numero = $l20_numero;
    $clliclicita->l20_nroedital = $l20_nroedital;
    $clliclicita->l20_codtipocom = $l20_codtipocom;

    $clliclicita->alterar($l20_codigo, $descricao);

    $db_opcao = 2;

    if ($clliclicita->erro_status == "0") {
      $erro_msg = $clliclicita->erro_msg;
      $sqlerro = true;
    }

    $clmanutencaolicitacao->manutlic_licitacao = $l20_codigo;
    $clmanutencaolicitacao->manutlic_codunidsubanterior = $manutlic_codunidsubanterior;

    $clmanutencaolicitacao->incluir();

    if ($sqlerro == false) {
      $resmanut = db_query("select nextval('db_manut_log_manut_sequencial_seq') as seq");
      $seq = pg_result($resmanut, 0, 0);
      $result = db_query("insert into db_manut_log values($seq,'Vigencia anterior: " . $oPosicao->ac16_datainicio . " - " . $oPosicao->ac16_datafim . " atual: " . $ac16_datainicio . " - " . $ac16_datafim . "  '," . db_getsession('DB_datausu') . "," . db_getsession('DB_id_usuario') . ")");
      echo "<script>alert('Alteração efetuada');</script>";
      $db_opcao = 3;
      $l20_codigo = '';
    }
  } else {
    if ($bmsg == false) {
      echo "<script>alert('Você não fez nenhuma mudança');</script>";
    }
  }
} else if (isset($chavepesquisa)) {

  $db_opcao = 2;
  $sCampos = '*, ';
  $sCampos .= "(select count(*) from liclicitem where l21_codliclicita = l20_codigo) as itens_lancados";
  $result = $clliclicita->sql_record($clliclicita->sql_query($chavepesquisa, $sCampos));

  if ($clliclicita->numrows > 0) {

    db_fieldsmemory($result, 0);

    $result = $clmanutencaolicitacao->sql_record($clmanutencaolicitacao->sql_query('', '*', '', "manutlic_licitacao = $chavepesquisa"));

    db_fieldsmemory($result, 0);

    if (isset($l34_protprocesso) && trim($l34_protprocesso) != '') {
      $l34_protprocessodescr = $p58_requer;
    }

    $tipojulg = $l20_tipojulg;

    if (!empty($p58_numero)) {

      $p58_numero = "{$p58_numero}/{$p58_ano}";
      $l34_protprocesso = $p58_codproc;
    }

    $l20_edital_old    = $l20_edital;
    $l20_numero_old    = $l20_numero;
    $l20_nroedital_old = $l20_nroedital;
    $manutlic_codunidsubanterior_old = $manutlic_codunidsubanterior_old;
  }
}

?>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <?php
  db_app::load("scripts.js, prototype.js, datagrid.widget.js, messageboard.widget.js, dbtextField.widget.js");
  db_app::load("windowAux.widget.js, strings.js,dbtextFieldData.widget.js");
  db_app::load("grid.style.css, estilos.css");
  ?>
  <style>
    .temdesconto {
      background-color: #D6EDFF
    }
  </style>
</head>

<body bgcolor="#CCCCCC">
  <?php
  $sContass = explode(".", db_getsession("DB_login"));

  if ($sContass[1] != 'contass') {

    echo "<br><center><br><H2>Essa rotina apenas pode ser usada por usuários da contass</h2></center>";
  } else {
  ?>

    <form name='form1' method="post" action="" onsubmit="return confirm('Deseja realmente alterar?');">
      <div class="container">
        <fieldset>
          <legend><b></b></legend>
          <table>
            <tr>
              <td nowrap="nowrap" title="<?= $Tl20_codigo ?>">
                <b><? db_ancora('Licitação:', "js_pesquisa_liclicita(true);", 1); ?></b>
              </td>
              <td align="left" nowrap="nowrap">
                <?
                db_input("l20_codigo", 10, $Il20_codigo, true, "text", 3, "onchange='js_pesquisa_liclicita(false);'");
                ?>
              </td>
            </tr>
            <?php if ($db_opcao == 2) : ?>
              <tr>
                <td nowrap title="Processo Licitatório">
                  <strong>Processo Licitatório:</strong>
                </td>
                <td>
                  <?
                  db_input('l20_edital', 10, $Il20_edital, true, 'text', 2, "");
                  ?>
                </td>
              </tr>
              <?php
              db_input('l20_edital_old', 10, $Il20_edital, true, 'hidden', 2, "");
              ?>
              <tr>
                <td nowrap title="Numeração">
                  <strong>Modalidade:</strong>
                </td>
                <td>
                  <?
                  db_input('l20_numero', 10, $Il20_numero, true, 'text', 2, "");
                  ?>
                </td>
              </tr>
              <?php
              db_input('l20_numero_old', 10, $Il20_numero, true, 'hidden', 2, "");
              ?>

              <?php
              if ($chavepesquisa2 != 101) :
                if ($chavepesquisa2 != 100) :
              ?>
                  <tr id="linha_nroedital">
                    <td nowrap title="<?= @$Tl20_nroedital ?>">
                      <?= @$Ll20_nroedital ?>
                    </td>
                    <td>
                      <?
                      $mostra = $l20_nroedital && $db_opcao == 2 || !$l20_nroedital && $db_opcao == 1
                        || db_getsession('DB_anousu') >= 2021 ? 3 : 1;
                      db_input('l20_nroedital', 10, $Il20_nroedital, true, 'text', 2, "");
                      ?>
                    </td>
                  </tr>
                  <?php
                  db_input('l20_nroedital_old', 10, $Il20_nroedital, true, 'hidden', 2, "");
                  ?>

                  <tr>
                    <td nowrap title="Codunidsubanterior">
                      <strong>Codunidsubanterior:</strong>
                    </td>
                    <td>
                      <?
                      db_input('manutlic_codunidsubanterior', 10, $Imanutlic_codunidsubanterior, true, 'text', 2, "");
                      db_input('manutlic_codunidsubanterior_old', 10, $Imanutlic_codunidsubanterior, true, 'hidden', 2, "");
                      ?>
                    </td>
                  </tr>

              <?php
                endif;
              endif;
              ?>

            <?php endif; ?>
          </table>
        </fieldset>
        <input name="alterar" type="submit" value="Alterar" <?= ($db_opcao == 2 ? "" : "disabled") ?>>
      </div>
    </form>
    </div>

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
  function js_pesquisa_liclicita(mostra) {

    if (mostra) {
      js_OpenJanelaIframe('', 'db_iframe_liclicita', 'func_liclicitamanutencao.php?funcao_js=parent.js_mostraliclicita1|l20_codigo|pc50_pctipocompratribunal', 'Pesquisa', true);
    } else {

      if (document.form1.l20_codigo.value != '') {
        js_OpenJanelaIframe('', 'db_iframe_liclicita', 'func_liclicitamanutencao.php?pesquisa_chave=' + document.form1.l20_codigo.value + '&funcao_js=parent.js_mostraliclicita', 'Pesquisa', false);
      } else {
        document.form1.l20_codigo.value = '';
      }
    }
  }

  function js_mostraliclicita(chave, erro) {

    document.form1.l20_codigo.value = chave;
    if (erro) {
      document.form1.l20_codigo.value = '';
      document.form1.l20_codigo.focus();
    }

    <?
    echo " location.href = '" . basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]) . "?chavepesquisa='+chave;";
    ?>

  }

  function js_mostraliclicita1(chave1, chave2) {

    document.form1.l20_codigo.value = chave1;
    db_iframe_liclicita.hide();

    <?
    echo " location.href = '" . basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]) . "?chavepesquisa='+chave1+'&chavepesquisa2='+chave2";
    ?>

  }
</script>
<?
  }
?>
