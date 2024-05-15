<?php
require_once("libs/db_stdlib.php");
require_once("libs/db_stdlibwebseller.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("dbforms/db_funcoes.php");

$oRotuloContrans = new rotulo("contrans");
$oRotuloContrans->label();
$oRotuloContransLan = new rotulo("contranslan");
$oRotuloContransLan->label();
$oRotuloConhist = new rotulo("conhistdoc");
$oRotuloConhist->label();

db_postmemory($HTTP_POST_VARS);
$cl_scripts = new cl_scripts;

if(isset($alterar)){
  $alterar = "";
  $db_botao=false;
  $ano    = db_getsession('DB_anousu');
  $instit = db_getsession('DB_instit');
  $rsVerify = db_query(
    "SELECT 1
    FROM conlancam
    JOIN conlancamdoc on c71_codlan = c70_codlan
    JOIN conlancaminstit on c02_codlan = c70_codlan
    JOIN condataconf ON (c99_anousu,
                         c99_instit) = (c70_anousu,
                                        c02_instit)
    WHERE c70_data > c99_data
    AND c70_codlan = $c70_codlan
    AND c99_instit = $instit
    AND c70_anousu = '$ano'"
  );

  if(pg_num_rows($rsVerify) > 0 ){

    db_inicio_transacao();
    $cl_scripts->alteraDocumento($c70_codlan,$c45_coddoc,$coddoc);
    echo "<script>alert(\"".$cl_scripts->erro_msg."\");</script>";

    db_fim_transacao();

    if($cl_scripts->erro == false){
      $coddoc = $c45_coddoc;
      $descr  = $c53_descr;
      $c45_coddoc = "";
      $c53_descr  = "";
    }

  }

  $rsVerify2 = db_query(
    "SELECT 1
    FROM conlancam
    JOIN conlancamdoc on c71_codlan = c70_codlan
    JOIN conlancaminstit on c02_codlan = c70_codlan
    JOIN condataconf ON (c99_anousu,
                         c99_instit) = (c70_anousu,
                                        c02_instit)
    WHERE c70_codlan = $c70_codlan
    AND c99_data is not null
    AND c99_instit = $instit
    AND c70_anousu = '$ano'"
  );

  if(pg_num_rows($rsVerify2) == 0){

    db_inicio_transacao();
    $cl_scripts->alteraDocumento($c70_codlan,$c45_coddoc,$coddoc);
    echo "<script>alert(\"".$cl_scripts->erro_msg."\");</script>";

    db_fim_transacao();

    $coddoc = $c45_coddoc;
    $descr  = $c53_descr;
    $c45_coddoc = "";
    $c53_descr  = "";

  }

  if(pg_num_rows($rsVerify2) != 0 && pg_num_rows($rsVerify) == 0 ){
    echo "<script>alert('Alteração não efetuada. A data do lançamento é menor ou igual a data do encerramento do período contábil');</script>";
  }

}

?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php
  db_app::load("scripts.js, prototype.js");
  db_app::load("estilos.css, grid.style.css");
?>

</head>
<body bgcolor="#cccccc" style='margin-top: 30px'>
  <center>
    <div style="margin-top: 25px; width: 500px;">
      <?php
      $sContass = explode(".",db_getsession("DB_login"));

      if ($sContass[1] != 'contass') {

        echo "<br><center><br><H2>Essa rotina apenas pode ser usada por usuários da contass</h2></center>";
      } else {
        ?>
      <form action="" method="post" name='form1' >
        <fieldset>
          <legend><b>Alteração de Documento</b></legend>
          <table>

            <tr>
              <td nowrap><? db_ancora("Código do Lançamento:",'js_pesquisaLancamento();',1); ?> </td>
              <td><?  db_input("c70_codlan",10,"",true,'text',3);   ?> </td>
            </tr>

            <tr>
              <td nowrap><strong>Documento Atual: </strong></td>
              <td>
                <?
                  db_input('coddoc', 10, $Ic45_coddoc, true, 'text', 3);
                  db_input('descr', 40, $Ic53_descr, true, 'text',3);
                ?>
              </td>
            </tr>

            <tr>
              <td nowrap="nowrap" id="tdDocumento">
                <b><? db_ancora('Novo Documento: ', "js_pesquisaDocumento(true);", 1);?></b>
              </td>
              <td nowrap="nowrap" colspan="3">
                <?
                  db_input('c45_coddoc', 10, $Ic45_coddoc, true, 'text', 1, "onchange='js_pesquisaDocumento(false);'");
                  db_input('c53_descr', 40, $Ic53_descr, true, 'text',3);
                ?>
              </td>
            </tr>
          </table>
        </fieldset><br />
        <input name="alterar" type="submit" id="alterar" value="Alterar Documento">
      </form>
      <?
}
?>

    </div>
  </center>
  <?db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));?>

</body>
</html>

<script type="text/javascript">

/*
 * lokup para lancamentos contabeis
 */
function js_pesquisaLancamento(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_conlancamlan','func_conlancamlanmanut.php?funcao_js=parent.js_preencheLancamento|c70_codlan|c53_coddoc|c53_descr','Pesquisa Lançamentos',true);
}
function js_preencheLancamento(chave,chave2,descr){

  $('c70_codlan').value = chave;
  $('coddoc').value = chave2;
  $('descr').value = descr;
  db_iframe_conlancamlan.hide();
}

/* Funções de pesquisa do Documento */
function js_pesquisaDocumento(lMostra) {

  var sUrlDocumento = "";
  if (lMostra) {
    sUrlDocumento = "func_conhistdoc.php?funcao_js=parent.js_preencheDocumento|c53_coddoc|c53_descr";
  } else {
    sUrlDocumento = "func_conhistdoc.php?pesquisa_chave="+$F("c45_coddoc")+"&funcao_js=parent.js_completaDocumento";
  }
  js_OpenJanelaIframe("", "db_iframe_conhistdoc", sUrlDocumento, "Pesquisa Documento", lMostra);
}

function js_preencheDocumento(iCodigoDocumento, sDescricaoDocumento) {

  $("c45_coddoc").value = iCodigoDocumento;
  $("c53_descr").value = sDescricaoDocumento;
  db_iframe_conhistdoc.hide();
}

function js_completaDocumento(sDescricao, lErro) {

  $("c53_descr").value = sDescricao;
  if (lErro) {
    $("c45_coddoc").value = "";
  }
}

</script>
