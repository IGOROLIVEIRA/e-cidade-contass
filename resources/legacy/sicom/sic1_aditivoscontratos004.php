<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_aditivoscontratos_classe.php");
include("classes/db_itensaditivados_classe.php");
include("classes/db_contratos_classe.php");
$clcontratos = new cl_contratos;
$claditivoscontratos = new cl_aditivoscontratos;
  /*
$clitensaditivados = new cl_itensaditivados;
  */
db_postmemory($HTTP_POST_VARS);
   $db_opcao = 1;
$db_botao = true;
if(isset($incluir)){
  $sqlerro=false;
  db_inicio_transacao();

  /*$result = $claditivoscontratos->sql_record($claditivoscontratos->sql_query_file(null,"si174_nroseqtermoaditivo","si174_sequencial desc limit 1","si174_nrocontrato = ".$si174_nrocontrato));

  if(pg_num_rows($result) == 0) {
    $claditivoscontratos->si174_nroseqtermoaditivo = 1;    
  }else{
    if(empty($si174_nroseqtermoaditivo)){
      $claditivoscontratos->si174_nroseqtermoaditivo = db_utils::fieldsMemory($result,0)->si174_nroseqtermoaditivo + 1;
    }else{

      $result = $claditivoscontratos->sql_record($claditivoscontratos->sql_query_file(null,"si174_nroseqtermoaditivo","si174_sequencial desc limit 1","si174_nrocontrato = ".$si174_nrocontrato ."si174_nroseqtermoaditivo = ".$si174_nroseqtermoaditivo));
      if(pg_num_rows($result) == 0) {
        $claditivoscontratos->si174_nroseqtermoaditivo = $si174_nroseqtermoaditivo;
      } else{
        echo "<script> alert('Nro seq do Termo Aditivo já existe para este contrato') </script>";
        return false;
      }

    }

  }*/

  $claditivoscontratos->incluir($si174_sequencial);
  if($claditivoscontratos->erro_status==0){
    $sqlerro=true;
  } 
  $erro_msg = $claditivoscontratos->erro_msg; 
  db_fim_transacao($sqlerro);
   $si174_sequencial= $claditivoscontratos->si174_sequencial;
   $db_opcao = 1;
   $db_botao = true;
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
<fieldset   style="margin-left:40px; margin-top: 20px;">
<legend><b>Aditivos Contratos</b></legend>
  <?
  include("forms/db_frmaditivoscontratos.php");
  ?>
</fieldset>
</center>
</body>
</html>
<?
if(isset($incluir)){
  if($sqlerro==true){
    db_msgbox($erro_msg);
    if($claditivoscontratos->erro_campo!=""){
      echo "<script> document.form1.".$claditivoscontratos->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$claditivoscontratos->erro_campo.".focus();</script>";
    };
  }else{
   db_msgbox($erro_msg);
   db_redireciona("sic1_aditivoscontratos005.php?liberaaba=true&chavepesquisa=$si174_sequencial");
  }
}
?>
