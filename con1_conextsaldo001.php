<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_conextsaldo_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$clconextsaldo = new cl_conextsaldo;

$db_opcao = 1;
$db_botao = true;

if(isset($alterar) || isset($excluir) || isset($incluir)){
  $sqlerro = false;
}

if(isset($processar)){
  $result = $clconextsaldo->sql_record($clconextsaldo->sql_query('','ces01_codcon,ces01_reduz,ces01_anousu,ces01_inst','',"ces01_reduz = $ces01_reduz"));
  db_fieldsmemory($result,0);
}
elseif(isset($incluir)){
  db_inicio_transacao();

  $clconextsaldo->sql_record($clconextsaldo->sql_query('','*','',"ces01_reduz = $ces01_reduz and ces01_fonte = $ces01_fonte and ces01_anousu = " . db_getsession('DB_anousu')));
  if($clconextsaldo->numrows > 0){
    db_msgbox('Esse lancançamento já existe!');
  }else{
  $clconextsaldo->incluir($ces01_sequencial);
  if ($clconextsaldo->erro_status!="0"){
    $ces01_fonte = $ces01_valor = $o15_descr = '';
  } elseif($clconextsaldo->erro_status=="0") {
    echo $clconextsaldo->erro_msg;
  }
  }
  db_fim_transacao();
}
elseif(isset($alterar)){
  db_inicio_transacao();
  $db_opcao = 2;
  $clconextsaldo->sql_record($clconextsaldo->sql_query('','*','',
    "ces01_sequencial != $ces01_sequencial and ces01_reduz = $ces01_reduz and ces01_fonte = $ces01_fonte and ces01_valor = $ces01_valor and ces01_anousu = " . db_getsession('DB_anousu')));
  if($clconextsaldo->numrows > 0){
    db_msgbox("Esse lancançamento já existe.\nVerifique os dados informados!");
  }else {
    $clconextsaldo->alterar($ces01_sequencial);
    if ($clconextsaldo->erro_status!="0"){
      db_msgbox('Alteração efetuada com sucesso!');
      $ces01_fonte = $ces01_valor = $o15_descr = '';
      $db_opcao = 1;
    }
  }
  db_fim_transacao();
}
elseif(isset($excluir)){
  db_inicio_transacao();
  $db_opcao = 2;
  $clconextsaldo->excluir($ces01_sequencial);
  if ($clconextsaldo->erro_status!="0"){
    $ces01_fonte = $ces01_valor = $o15_descr = '';
    $db_opcao = 1;
  }
  db_fim_transacao();
}else if(isset($opcao)){

  $result = $clconextsaldo->sql_record($clconextsaldo->sql_query_file('', '*', '',
      "ces01_anousu = " . db_getsession('DB_anousu') ." and ces01_inst = ". db_getsession('DB_instit') .
      " and ces01_reduz = " . $ces01_reduz . " and ces01_sequencial = $ces01_sequencial"
  ));

  if($result!=false && $clconextsaldo->numrows>0){
    db_fieldsmemory($result,0);

    if($opcao == 'alterar'){
      $db_opcao = 2;
    }
    if($opcao == 'excluir'){
      $db_opcao = 3;
    }
  }
}
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<center>
  <fieldset style=" margin-top: 30px; width: 800px; height: 300px;">
    <legend>Saldo EXT Fonte</legend>
	<?
	include("forms/db_frmconextsaldo.php");
	?>
      </fieldset>
    </center>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<script>
js_tabulacaoforms("form1","ces01_codcon",true,1,"ces01_codcon",true);
</script>
<?
/*if(isset($incluir)){
  if($clconextsaldo->erro_status=="0"){
    $clconextsaldo->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clconextsaldo->erro_campo!=""){
      echo "<script> document.form1.".$clconextsaldo->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clconextsaldo->erro_campo.".focus();</script>";
    }
  }else{
    $clconextsaldo->erro(true,true);
  }
}*/
?>
