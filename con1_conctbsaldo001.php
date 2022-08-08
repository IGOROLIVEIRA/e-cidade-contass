<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_conctbsaldo_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);

$clconctbsaldo = new cl_conctbsaldo;

$db_opcao = 1;
$db_botao = true;

if(isset($alterar) || isset($excluir) || isset($incluir)){
  $sqlerro = false;
}

if(isset($processar)){
  $result = $clconctbsaldo->sql_record($clconctbsaldo->sql_query('','ces02_codcon,ces02_reduz,ces02_anousu,ces02_inst','',"ces02_reduz = $ces02_reduz"));
  db_fieldsmemory($result,0);
}
elseif(isset($incluir)){
  db_inicio_transacao();

  $clconctbsaldo->sql_record($clconctbsaldo->sql_query('','*','',"ces02_reduz = $ces02_reduz and ces02_fonte = $ces02_fonte and ces02_anousu = " .db_getsession('DB_anousu')));
  if($clconctbsaldo->numrows > 0){
    db_msgbox('Esse lancançamento já existe!');
  }else{
    $clconctbsaldo->incluir($ces02_sequencial);
    if ($clconctbsaldo->erro_msg != "0"){
      $ces02_fonte = $ces02_valor = $o15_descr = '';
    } elseif ($clconctbsaldo->erro_msg == "0"){
      echo $clconctbsaldo->erro_msg;
    }
  }
  db_fim_transacao();
}
elseif(isset($alterar)){
  db_inicio_transacao();
  $db_opcao = 2;
  $clconctbsaldo->sql_record($clconctbsaldo->sql_query('','*','',
    "ces02_sequencial != $ces02_sequencial and ces02_reduz = $ces02_reduz and ces02_fonte = $ces02_fonte and ces02_valor = $ces02_valor and ces02_anousu = " .db_getsession('DB_anousu')));
  if($clconctbsaldo->numrows > 0){
    db_msgbox("Esse lancançamento já existe!\nVerifique os dados informados.");
  }else {
    $clconctbsaldo->alterar($ces02_sequencial);
    if ($clconctbsaldo->erro_status!="0"){
      db_msgbox('Alteração efetuada com sucesso!');
      $ces02_fonte = $ces02_valor = $o15_descr = '';
      $db_opcao = 1;
    }
  }
  db_fim_transacao();
}
elseif(isset($excluir)){
  db_inicio_transacao();
  $db_opcao = 2;
  $clconctbsaldo->excluir($ces02_sequencial);
  if ($clconctbsaldo->erro_status!="0"){
    $ces02_fonte = $ces02_valor = $o15_descr = '';
    $db_opcao = 1;
  }
  db_fim_transacao();
}else if(isset($opcao)){

  $result = $clconctbsaldo->sql_record($clconctbsaldo->sql_query_file('', '*', '',
      "ces02_anousu = " . db_getsession('DB_anousu') ." and ces02_inst = ". db_getsession('DB_instit') .
      " and ces02_reduz = " . $ces02_reduz . " and ces02_sequencial = $ces02_sequencial"
  ));

  if($result!=false && $clconctbsaldo->numrows>0){
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
<meta http-equiv="Content-Type" content="tctb/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<center>
  <fieldset style=" margin-top: 30px; width: 800px; height: 300px;">
    <legend>Saldo CTB Fonte</legend>
	<?
	include("forms/db_frmconctbsaldo.php");
	?>
      </fieldset>
    </center>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<script>
js_tabulacaoforms("form1","ces02_codcon",true,1,"ces02_codcon",true);
</script>
<?
/*if(isset($incluir)){
  if($clconctbsaldo->erro_status=="0"){
    $clconctbsaldo->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clconctbsaldo->erro_campo!=""){
      echo "<script> document.form1.".$clconctbsaldo->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clconctbsaldo->erro_campo.".focus();</script>";
    }
  }else{
    $clconctbsaldo->erro(true,true);
  }
}*/
?>
