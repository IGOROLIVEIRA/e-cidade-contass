<?
define("TAREFA", true);

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_tarefa_classe.php");
include("classes/db_tarefasituacao_classe.php");
include("classes/db_tarefalog_classe.php");
include("classes/db_tarefalogsituacao_classe.php");
include("dbforms/db_funcoes.php");

parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);

$cltarefa            = new cl_tarefa;
$cltarefasituacao    = new cl_tarefasituacao;
$cltarefalog         = new cl_tarefalog;
$cltarefalogsituacao = new cl_tarefalogsituacao;

$db_opcao = 1;
$db_botao = true;
if (isset($incluir)) {
  $sqlerro = false;
  
  $result = $cltarefalog->sql_record($cltarefalog->sql_query(null,"at43_horafim",null,"at43_tarefa=$at43_tarefa and (at43_horafim is null or at43_horafim='')"));
  if ($cltarefalog->numrows > 0) {
    $sqlerro  = true;
    $erro_msg = "Tarefa ".$at43_tarefa." possui andamento(s) em aberto";
  }
 
  if ($sqlerro == false) {
    $cltarefalog->at43_tarefa    = $at43_tarefa;
    $cltarefalog->at43_usuario   = @$at43_usuario;
    $cltarefalog->at43_tipomov   = $at43_tipomov;
    $cltarefalog->at43_progresso = "0";
    $cltarefalog->at43_diafim    = $at43_diaini_ano."-".$at43_diaini_mes."-".$at43_diaini_dia;
    $cltarefalog->at43_usuario   = db_getsession("DB_id_usuario");
    $cltarefalog->at43_horafim   = " ";
    
    db_inicio_transacao();
    
    $cltarefalog->incluir(null);
    $erro_msg = $cltarefalog->erro_msg;
    if ($cltarefalog->erro_status==0) {
      $sqlerro=true;
    } else {
      $cltarefalogsituacao->at48_tarefalog = $cltarefalog->at43_sequencial;
      $cltarefalogsituacao->at48_situacao  = "1";
      $cltarefalogsituacao->incluir(null);
      $erro_msg2 = $cltarefalogsituacao->erro_msg;
      if ($cltarefalogsituacao->erro_status==0) {
        $sqlerro  = true;
        $erro_msg = $erro_msg2;
      }
      
      if ($sqlerro == false) {
        $result = $cltarefasituacao->sql_record($cltarefasituacao->sql_query(null,"at47_sequencial",null,"at47_tarefa=" . $cltarefalog->at43_tarefa));
        if ($cltarefasituacao->numrows > 0) {
          db_fieldsmemory($result,0);
          $cltarefasituacao->at47_sequencial = $at47_sequencial;
        }
        
        if ($cltarefalog->at43_progresso == 100) {
          $cltarefasituacao->at47_situacao = 3;
        } else {
          $cltarefasituacao->at47_situacao = $cltarefalogsituacao->at48_situacao;
        }
        
        if ($cltarefasituacao->numrows > 0) {
          $cltarefasituacao->alterar($at47_sequencial);
        } else {
          $cltarefasituacao->at47_tarefa = $cltarefalog->at43_tarefa;
          $cltarefasituacao->incluir(null);
        }
        
        if ($cltarefasituacao->erro_status == 0) {
          $sqlerro  = true;
          $erro_msg = $cltarefasituacao->erro_msg;
        }
      }
    }
    
    db_fim_transacao($sqlerro);
    
    if ($sqlerro == false) {
      $at43_tarefa     = "";
      $db_descr        = "";
      $at43_sequencial = "";
      $at43_descr      = "";
      $at43_obs        = "";
      $at43_diaini_dia = "";
      $at43_diaini_mes = "";
      $at43_diaini_ano = "";
      $at43_diafim_dia = "";
      $at43_diafim_mes = "";
      $at43_diafim_ano = "";
      $at43_problema   = "";
      $at43_avisar     = "";
      $at43_horainidia = "";
      $at43_horafim    = "";
      $at43_progresso  = "";
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
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC"> 
    <center>
        <?
	   include("forms/db_frmtarefaandam.php");
	?>
    </center>
	</td>
  </tr>
</table>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<?
if(isset($incluir)){
    db_msgbox($erro_msg);
    if($cltarefalog->erro_campo!=""){
        echo "<script> document.form1.".$cltarefalog->erro_campo.".style.backgroundColor='#99A9AE';</script>";
        echo "<script> document.form1.".$cltarefalog->erro_campo.".focus();</script>";
    }
}
?>
