<?php
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
include("classes/db_scripts_classe.php");
$clrotulo = new rotulocampo;
$clrotulo->label("e60_codemp");


db_postmemory($HTTP_POST_VARS);
$cl_scripts = new cl_scripts;
if(isset($excluir)){

  $db_botao=false;
  $ano    = db_getsession('DB_anousu');
  $instit = db_getsession('DB_instit');
  $codemp = explode('/',$e60_codemp);
  $rsVerify = db_query(
    "SELECT 1
    FROM empempenho
    JOIN condataconf ON (c99_anousu,
                         c99_instit) = (e60_anousu,
                                        e60_instit)
    WHERE e60_emiss > c99_data
    AND e60_codemp = '$codemp[0]'
    AND c99_instit = $instit
    AND e60_anousu = '$ano'"
  );

  if(pg_num_rows($rsVerify) > 0 ){
    db_inicio_transacao();
    $cl_scripts->excluiEmpenho($e60_numemp);
    echo "<script>alert(\"".$cl_scripts->erro_msg."\");</script>";
    //echo "<script>alert(\"maior\");</script>";
    db_fim_transacao();
  }

  $rsVerify2 = db_query(
    "SELECT 1
    FROM empempenho
    JOIN condataconf ON (c99_anousu,
                         c99_instit) = (e60_anousu,
                                        e60_instit)
    WHERE e60_codemp = '$codemp[0]'
    AND c99_instit = $instit
    AND e60_anousu = '$ano'"
  );

  if(pg_num_rows($rsVerify2) == 0){
    db_inicio_transacao();
    $cl_scripts->excluiEmpenho($e60_numemp);
    echo "<script>alert(\"".$cl_scripts->erro_msg."\");</script>";
    //echo "<script>alert(\"periodo vazio\");</script>";
    db_fim_transacao();
  }

  if(pg_num_rows($rsVerify2) != 0 && pg_num_rows($rsVerify) == 0 ){
    echo "<script>alert('Exclusão não efetuada. A data de emissão do empenho é menor ou igual a data do encerramento do período contábil');</script>";
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
      .temdesconto {background-color: #D6EDFF}
    </style>
  </head>
<body bgcolor="#CCCCCC">
<?php
$sContass = explode(".",db_getsession("DB_login"));

if ($sContass[1] != 'contass') {

  echo "<br><center><br><H2>Essa rotina apenas pode ser usada por usuários da contass</h2></center>";
} else {
  ?>

  <form name='form1' method="post" action="" onsubmit="return confirm('Deseja realmente excluir?');">
    <div class="container">
      <fieldset>
        <legend><b>Manutenção de Empenhos</b></legend>
        <table>
          <tr>
            <td  align="left" nowrap title="<?=$Te60_numemp?>">
              <? db_ancora(@$Le60_codemp,"js_pesquisa_empenho(true);",1);  ?>
            </td>
            <td  nowrap>
              <input name="e60_codemp" id='e60_codemp' title='<?=$Te60_codemp?>' size="12" type='text' readonly class="readonly" />
              <b>Sequencial:</b> <input name="e60_numemp" id='e60_numemp' type="text" size="10" readonly class="readonly" />
            </td>
          </tr>
        </table>
      </fieldset>
      <input name="excluir" type="submit" id="excluir" value="Excluir Empenho" <?=($db_botao==false?"disabled":"")?> >
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

    function js_pesquisa_empenho(mostra) {

      if (mostra == true) {

        js_OpenJanelaIframe('CurrentWindow.corpo',
          'db_iframe_empempenho',
          'func_empempenho_manut.php?funcao_js=parent.js_mostraempenho1|e60_codemp|e60_anousu|e60_numemp',
          'Pesquisa',
          true);

      }
    }

    function js_mostraempenho1(chave1, chave2, chave3) {

      document.form1.e60_codemp.value = chave1+"/"+chave2;
      document.form1.e60_numemp.value = chave3;
      db_iframe_empempenho.hide();
      document.form1.excluir.disabled = false;
    }


  </script>
<?
}
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
