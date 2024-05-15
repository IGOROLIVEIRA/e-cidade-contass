<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_avaliacaoS1000_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$clavaliacaoS1000 = new cl_avaliacaoS1000;
$db_opcao = 1;
$db_botao = true;
if(isset($incluir)){
  db_inicio_transacao();
  $clavaliacaoS1000->eso05_instit = db_getsession('DB_instit');
  $clavaliacaoS1000->incluir();
  db_fim_transacao();
}else if(isset($chavepesquisa)){
  $db_opcao = 3;
  $result = $clavaliacaoS1000->sql_record($clavaliacaoS1000->sql_query($chavepesquisa));
  db_fieldsmemory($result,0);
  $db_botao = true;
}
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/numbers.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/widgets/DBToogle.widget.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body>
<center>
  <table style="margin-top: 30px;">
    <tr>
      <td>
        <?
        include("forms/db_frmavaliacaoS1000.php");
        ?>
      </td>
    </tr>
  </table>
</center>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<script>
  js_tabulacaoforms("form1","eso05_codclassificacaotributaria",true,1,"eso05_codclassificacaotributaria",true);
</script>
<?
if(isset($incluir)){
  if($clavaliacaoS1000->erro_status=="0"){
    $clavaliacaoS1000->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clavaliacaoS1000->erro_campo!=""){
      echo "<script> document.form1.".$clavaliacaoS1000->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clavaliacaoS1000->erro_campo.".focus();</script>";
    }
  }else{
    $clavaliacaoS1000->erro(true,true);
  }
}
?>
