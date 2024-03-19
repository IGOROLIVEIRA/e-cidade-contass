<?

require_once(modification("libs/db_stdlib.php"));
require_once(modification("libs/db_utils.php"));
require_once(modification("libs/db_conecta.php"));
require_once(modification("libs/db_sessoes.php"));
require_once(modification("libs/db_usuariosonline.php"));
require_once(modification("dbforms/db_funcoes.php"));
require_once(modification("libs/db_liborcamento.php"));
require_once("classes/db_metasarrecadacaoreceita_classe.php");
db_postmemory($HTTP_POST_VARS);

$clorcmetasarrecadacaoreceita = new cl_metasarrecadacaoreceita;

$db_opcao = 1;
$db_botao = true;
try {
  $instit = db_getsession("DB_instit");
  $anousu = db_getsession("DB_anousu");
  db_inicio_transacao();

  if (isset($salvar)) {

    $clorcmetasarrecadacaoreceita->o203_exercicio  = $o203_exercicio;
    $clorcmetasarrecadacaoreceita->o203_bimestre01 = str_replace(array(','), '.',(str_replace(array('.'), '',$o203_bimestre01)));
    $clorcmetasarrecadacaoreceita->o203_bimestre02 = str_replace(array(','), '.',(str_replace(array('.'), '',$o203_bimestre02)));
    $clorcmetasarrecadacaoreceita->o203_bimestre03 = str_replace(array(','), '.',(str_replace(array('.'), '',$o203_bimestre03)));
    $clorcmetasarrecadacaoreceita->o203_bimestre04 = str_replace(array(','), '.',(str_replace(array('.'), '',$o203_bimestre04)));
    $clorcmetasarrecadacaoreceita->o203_bimestre05 = str_replace(array(','), '.',(str_replace(array('.'), '',$o203_bimestre05)));
    $clorcmetasarrecadacaoreceita->o203_bimestre06 = str_replace(array(','), '.',(str_replace(array('.'), '',$o203_bimestre06)));
    $clorcmetasarrecadacaoreceita->o203_totalbimestres = str_replace(array('R$', '.', ','), '', floatval($o203_totalbimestres));
    $clorcmetasarrecadacaoreceita->o203_instit     = $instit;

    $dbwhere = " o203_exercicio = '{$anousu}' ";
    $rsResult = $clorcmetasarrecadacaoreceita->sql_record($clorcmetasarrecadacaoreceita->sql_query(null,'*','', $dbwhere));
    db_fieldsmemory($rsResult, 0);

    if($clorcmetasarrecadacaoreceita->numrows > 0){ 
      $clorcmetasarrecadacaoreceita->alterar($o203_sequencial);    
    } else {
       $clorcmetasarrecadacaoreceita->incluir();
    } 
     
    if ($clorcmetasarrecadacaoreceita->erro_status=="0") {
        throw new Exception("Erro ao incluir/alterar ".$clorcmetasarrecadacaoreceita->erro_msg);
    }
  }

  db_fim_transacao();
} catch (Exception $oErro) {

  db_fim_transacao(true);
  $clorcmetasarrecadacaoreceita->erro_status = '0';
  $clorcmetasarrecadacaoreceita->erro_msg = $oErro->getMessage();
}
$dbwhere = " o203_exercicio = '{$anousu}' ";
$rsResult = $clorcmetasarrecadacaoreceita->sql_record($clorcmetasarrecadacaoreceita->sql_query(null,'*','', $dbwhere));
db_fieldsmemory($rsResult, 0);
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
<style type="text/css">
  .linha-tabela {
    background-color: #999999;
  }
  .tbody {
  overflow: auto;
}
</style>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
  <br><br>

  <center>
   <?
   include("forms/db_frmmetasarrecadacaoreceita.php");
   ?>
 </center>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<script>
// js_tabulacaoforms("form1","o202_unidade",true,1,"o202_unidade",true);
</script>
<?
if(isset($salvar)){
  if($clorcmetasarrecadacaoreceita->erro_status=="0"){
    $clorcmetasarrecadacaoreceita->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clorcmetasarrecadacaoreceita->erro_campo!=""){
      echo "<script> document.form1.".$clorcmetasarrecadacaoreceita->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clorcmetasarrecadacaoreceita->erro_campo.".focus();</script>";
    }
  }else{
    $clorcmetasarrecadacaoreceita->erro(true,false);
  }
}
?>
