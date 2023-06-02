<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("libs/db_utils.php");
include("classes/db_consvalorestransf_classe.php");
include("classes/db_consconsorcios_classe.php");
include("dbforms/db_funcoes.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);
$clconsvalorestransf = new cl_consvalorestransf;
$clconsconsorcios = new cl_consconsorcios;
$db_opcao = 22;
$db_botao = false;
$iAnoUsu  = db_getsession('DB_anousu');
if(isset($alterar) || isset($excluir) || isset($incluir)){
  $sqlerro = false;
  /*
$clconsvalorestransf->c201_sequencial = $c201_sequencial;
$clconsvalorestransf->c201_consconsorcios = $c201_consconsorcios;
$clconsvalorestransf->c201_mescompetencia = $c201_mescompetencia;
$clconsvalorestransf->c201_valortransf = $c201_valortransf;
$clconsvalorestransf->c201_enviourelatorios = $c201_enviourelatorios;
  */
}
if(isset($incluir)){echo $c201_sequencial;
  if($sqlerro==false){
    db_inicio_transacao();
    
    $sWhere       = "c201_mescompetencia = {$c201_mescompetencia}  and c201_anousu = {$iAnoUsu} and c201_consconsorcios = {$c201_consconsorcios}";
    $sSqlVerifica = $clconsvalorestransf->sql_query_file(null, "*", null, $sWhere);
    $rsVerifica   = $clconsvalorestransf->sql_record($sSqlVerifica);

    if ($clconsvalorestransf->numrows > 0) {

        for ($i = 0; $i < $clconsvalorestransf->numrows; $i++) {
            
            $oVerifica = db_utils::fieldsMemory($rsVerifica, $i);

            if ($oVerifica->c201_codfontrecursos == $c201_codfontrecursos) {
                
                $erro_msg = "Já existe lançamentos para mês e fonte informados.";         
                $sqlerro  = true; 
                break; 

            } elseif ($oVerifica->c201_enviourelatorios != $c201_enviourelatorios) {

                $erro_msg = "Campo Enviou Relatórios diferente do informado anteriormente para o mês."; 
                $sqlerro  = true;
                break;
            }
        }

    }

    if (!$sqlerro) {

        $clconsvalorestransf->incluir();
        $erro_msg = $clconsvalorestransf->erro_msg;
        if($clconsvalorestransf->erro_status==0){
            $sqlerro = true;
        }

    }
    db_fim_transacao($sqlerro);
  }
}else if(isset($alterar)){
  if($sqlerro==false){
    db_inicio_transacao();
    $clconsvalorestransf->alterar($c201_sequencial);
    $erro_msg = $clconsvalorestransf->erro_msg;
    if($clconsvalorestransf->erro_status==0){
      $sqlerro=true;
    }
    db_fim_transacao($sqlerro);
  }
}else if(isset($excluir)){
  if($sqlerro==false){
    db_inicio_transacao();

    require_once("classes/db_consexecucaoorc_classe.php");
    $clconsexecucaoorc  = new cl_consexecucaoorc;
    $sSqlWhere          = " c202_consconsorcios = {$c201_consconsorcios} 
                            and c202_mescompetencia = {$c201_mescompetencia} 
                            and c202_anousu = {$iAnoUsu} 
                            and (c202_valorempenhado <> 0
                                or c202_valorempenhadoanu <> 0
                                or c202_valorliquidado <> 0
                                or c202_valorliquidadoanu <> 0
                                or c202_valorpago <> 0
                                or c202_valorpagoanu <> 0)";
    $sSqlExecOrc        = $clconsexecucaoorc->sql_query_file(null, "*", null, $sSqlWhere);
    $rsResult           = db_query($sSqlExecOrc);

    if (pg_num_rows($rsResult) > 0) {
        $erro_msg = "Há informações salvas na aba execução orçamentária referentes ao mês em questão. \n\nSerá necessário primeiro excluir as informações da aba execução orçamentária.";
        $sqlerro=true;
    } else {
        
        $clconsvalorestransf->excluir($c201_sequencial);
        $erro_msg = $clconsvalorestransf->erro_msg;
        if($clconsvalorestransf->erro_status==0){
          $sqlerro=true;
        }
    }

    db_fim_transacao($sqlerro);
  }
}else if(isset($opcao)){
   $result = $clconsvalorestransf->sql_record($clconsvalorestransf->sql_query($c201_sequencial));
   if($result!=false && $clconsvalorestransf->numrows>0){
     db_fieldsmemory($result,0);
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
	include("forms/db_frmconsvalorestransf.php");
	?>
    </center>
	</td>
  </tr>
</table>
</body>
</html>
<?
if(isset($alterar) || isset($excluir) || isset($incluir)){
    db_msgbox($erro_msg);
    if($clconsvalorestransf->erro_campo!=""){
        echo "<script> document.form1.".$clconsvalorestransf->erro_campo.".style.backgroundColor='#99A9AE';</script>";
        echo "<script> document.form1.".$clconsvalorestransf->erro_campo.".focus();</script>";
    } else if (isset($excluir)) {
    	db_redireciona("con1_consvalorestransf001.php?c201_consconsorcios=$c201_consconsorcios&db_opcaoal=33");
    }
}
?>
