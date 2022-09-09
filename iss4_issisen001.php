<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_issisen_classe.php");
require_once("classes/db_issbase_classe.php");

db_postmemory($HTTP_SERVER_VARS);
db_postmemory($HTTP_POST_VARS);

$db_botao  = 1;
$db_opcao  = 1;
$db_opcaom = 1;
$db_opcaon = 3;

$clissisen = new cl_issisen;
$clissisen->rotulo->label();
$clrotulo   = new rotulocampo;
$clrotulo->label("z01_nome");
?>
<html lang="">
<head>
<title>DBSeller Informática Ltda - Página Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
function js_checa(){

  if(document.form1.q148_inscr.value===""){

    alert("Informe a inscricao!");
    return false;
  }
  return true;
}
</script>
</head>
<body class="body-default" onload="document.form1.q148_inscr.focus();">
  <div class="container">
    <form name="form1" method="post" action="iss4_issisen002.php">
      <fieldset style="width:486px;">
        <legend>Isenção</legend>

          <table style="border: 0;">
            <tr>
              <td style="width: 126px" title="<?=@$Tq148_inscr?>">
                  <?php
                db_ancora(@$Lq148_inscr,"js_pesquisaq148_inscr(true);",$db_opcao);
                ?>
              </td>
              <td>
                  <?php
                db_input('q148_inscr',10,$Iq148_inscr,true,'text',$db_opcaom," onchange='js_pesquisaq148_inscr(false);'");
                db_input('z01_nome',45,$Iz01_nome,true,'text',3,"","z01_nomeinscr");
                ?>
              </td>
          </table>
      </fieldset>
      <input name="entrar" type="submit" id="entrar" value="Pesquisar" onclick=" return js_checa()" />
    </form>
  </div>
  <?php
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<script type="text/javascript">
function js_pesquisaq148_inscr(mostra){

  if(mostra===true){
    js_OpenJanelaIframe('','db_iframe','func_issbase.php?funcao_js=parent.js_mostraissbase1|q02_inscr|z01_nome','Pesquisa',true);
  }else{
    js_OpenJanelaIframe('','db_iframe','func_issbase.php?pesquisa_chave='+document.form1.q148_inscr.value+'&funcao_js=parent.js_mostraissbase','Pesquisa',false);
  }
}
function js_mostraissbase(chave,erro){

  document.form1.z01_nomeinscr.value = chave;
  if(erro===true){

    document.form1.q148_inscr.focus();
    document.form1.q148_inscr.value = '';
  }
}
function js_mostraissbase1(chave1,chave2){

  document.form1.q148_inscr.value = chave1;
  document.form1.z01_nomeinscr.value = chave2;
  db_iframe.hide();
}
</script>
<?php

$func_iframe                 = new janela('db_iframe','');
$func_iframe->posX           = 1;
$func_iframe->posY           = 20;
$func_iframe->largura        = 780;
$func_iframe->altura         = 430;
$func_iframe->titulo         = 'Pesquisa';
$func_iframe->iniciarVisivel = false;
$func_iframe->mostrar();

if(isset($invalido)){
  echo "<script>alert('Número de inscrição inválido!')</script>";

}
if(isset($excluir)){

  if($clissisen->erro_status=="0"){

    $clissisen->erro(true,false);
    if($clissisen->erro_campo!=""){

      echo "<script> document.form1.".$clissisen->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clissisen->erro_campo.".focus();</script>";
    }
  }else{

    $clissisen->erro(true,false);
    db_redireciona("cad4_issisen001.php");
  }
}
if(isset($atualizar)){

  if($clissisen->erro_status=="0"){

    $clissisen->erro(true,false);
    if($clissisen->erro_campo!=""){

      echo "<script> document.form1.".$clissisen->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clissisen->erro_campo.".focus();</script>";
    }
  }else{

    $clissisen->erro(true,false);
    db_redireciona("iss4_issisen001.php");
  }
}
?>
