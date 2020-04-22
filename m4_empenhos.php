<?php

require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
include("classes/db_scripts_classe.php");
require_once("dbforms/db_funcoes.php");
$clrotulo = new rotulocampo;
$clrotulo->label("e60_codemp");

db_postmemory($HTTP_POST_VARS);

if(isset($incluir)){
  db_inicio_transacao();
  //$clidentificacaoresponsaveis->incluir($si166_sequencial);
  db_fim_transacao();
}

?>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
        <legend><b>Manutenção de empenho</b></legend>
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
      <input type="submit" id='buttonSubmit' value='Excluir Empenho'>
      <input type="submit" id="db_opcao" value="Executar" >
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
    sUrlRPC = 'con4_lancamentoscontabeisempenho.RPC.php';
    function js_pesquisa_empenho(mostra) {

      if (mostra == true) {

        js_OpenJanelaIframe('top.corpo',
          'db_iframe_empempenho',
          'func_empempenho.php?funcao_js=parent.js_mostraempenho1|e60_codemp|e60_anousu|e60_numemp',
          'Pesquisa',
          true);

      }
    }

    function js_mostraempenho1(chave1, chave2, chave3) {

      document.form1.e60_codemp.value = chave1+"/"+chave2;
      document.form1.e60_numemp.value = chave3;
      db_iframe_empempenho.hide();
      js_visualizarEmpenhos(chave3);

    }

  </script>
<?
}
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>