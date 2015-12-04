<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_orcorgao_classe.php");
include("classes/db_orcunidade_classe.php");
include("classes/db_rhlota_classe.php");
include("classes/db_rhlotaexe_classe.php");
include("classes/db_lotacao_classe.php");
include("classes/db_cfpess_classe.php");
include("dbforms/db_funcoes.php");
include("dbforms/db_classesgenericas.php");
db_postmemory($HTTP_POST_VARS);
$clrhlota = new cl_rhlota;
$clrhlotaexe = new cl_rhlotaexe;
$clcfpess = new cl_cfpess;
$cllotacao = new cl_lotacao;
$cldb_estrut = new cl_db_estrut;
$clorcorgao = new cl_orcorgao;
$clorcunidade = new cl_orcunidade;

$db_opcao = 1;
$db_botao = true;
if(isset($incluir)){
  $sqlerro=false;
  //rotina para verificar a estrutura 
//  $cldb_estrut->db_estrut_inclusao($r70_estrut,$mascara,"rhlota","r70_estrut","r70_analitica");      
//  if($cldb_estrut->erro_status==0){
//     $erro_msg = $cldb_estrut->erro_msg;
//     $sqlerro=true;
//  }
  if($sqlerro==false){
    $anofolha = db_anofolha();
    $mesfolha = db_mesfolha();
    db_inicio_transacao();
    
    //rotina que pega o campo estrut da tabela cfpess
      $result = $clcfpess->sql_record($clcfpess->sql_query_file($anofolha,$mesfolha,"r11_codestrut"));
      if($clcfpess->numrows>0){
	db_fieldsmemory($result,0);
      }else{
	echo 'Não existem registros na tabela cfpess para o ano '.$anofolha.' e mês '.$mesfolha.' ...';
	exit;
      }
    //final 

    //rotina de inclusao na tabela rhlota
      $clrhlota->r70_codestrut= $r11_codestrut;
      $clrhlota->r70_estrut   = str_replace(".","",$r70_estrut);
      $clrhlota->r70_descr    = $r70_descr    ;
      $clrhlota->r70_analitica= "$r70_analitica";
      $clrhlota->incluir($r70_codigo);
      $r70_codigo = $clrhlota->r70_codigo;
      if($clrhlota->erro_status==0){
	$sqlerro=true;
	$erro_msg = $clrhlota->erro_msg;
      }else{
	$ok_msg = $clrhlota->erro_msg;
      }
    //final
  }  
  if($sqlerro==false && $r70_analitica=="t" ){
    //rotina de inclusao na tabela lotacao
      $clrhlotaexe->rh26_orgao = $o40_orgao;
      $clrhlotaexe->rh26_unidade = $o41_unidade;
      $clrhlotaexe->incluir($anofolha,$r70_codigo);
      if($clrhlotaexe->erro_status==0){
	$sqlerro=true;
	$erro_msg = $clrhlotaexe->erro_msg;
      }
      //
    /*
      $result = $cllotacao->sql_record($cllotacao->sql_query_file(null,null,$r70_codigo)); 
      if($clresultlota->numrows>0){
         $clresultlota->alterar($anofolha,$mesfolha,$r70_codigo);
      }else{
         $clresultlota->incluir($anofolha,$mesfolha,$r70_codigo);
      }
      $cllotacao->r13_anousu = $anofolha;
      $cllotacao->r13_mesusu = $mesfolha;
      $cllotacao->r13_descr  = $r13_descr ;
      $cllotacao->r13_reduz  = $r13_reduz ;
      $cllotacao->r13_proati = $r13_proati;
      $cllotacao->r13_painat = $r13_painat;
      $cllotacao->r13_descro = $r13_descro;
      $cllotacao->r13_descru = $r13_descru;
      $cllotacao->r13_subele = $r13_subele;
      $cllotacao->r13_calend = $r13_calend;
      $cllotacao->r13_rproat = $r13_rproat ; 
      $cllotacao->r13_rpaina = $r13_rpaina;
      $cllotacao->incluir($anofolha,$mesfolha,$r70_codigo);
      $erro_msg = $cllotacao->erro_msg;
      if($cllotacao->erro_status==0){
	$sqlerro=true;
      }
      */
    //final  
  }  
  db_fim_transacao($sqlerro);
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
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC"> 
    <center>
	<?
	include("forms/db_frmrhlota.php");
	?>
    </center>
	</td>
  </tr>
</table>
</body>
</html>
<?
if(isset($incluir)){
  if($sqlerro==true){
    db_msgbox($erro_msg);
    if($clrhlota->erro_campo!=""){
      echo "<script> document.form1.".$clrhlota->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clrhlota->erro_campo.".focus();</script>";
    };
  }else{
    if($r70_analitica=="t"){
     db_redireciona("pes1_rhlota005.php?chavepesquisa=$r70_codigo&liberaaba=true");
    }else{
     db_redireciona("pes1_rhlota004.php");
    }
  };
};
?>
