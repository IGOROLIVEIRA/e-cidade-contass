<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("libs/db_liborcamento.php");
include("dbforms/db_funcoes.php");
include("dbforms/db_classesgenericas.php");
include("classes/db_solicitem_classe.php");
include("classes/db_solicitempcmater_classe.php");
include("classes/db_pcdotac_classe.php");
include("classes/db_pcparam_classe.php");
include("classes/db_pcmaterele_classe.php");
include("classes/db_pcmater_classe.php");
include("classes/db_orcorgao_classe.php");
include("classes/db_orcdotacao_classe.php");
include("classes/db_empautidot_classe.php");
include("classes/db_db_depart_classe.php");
include("classes/db_orcreserva_classe.php");
include("classes/db_orcreservasol_classe.php");
include("classes/db_orcelemento_classe.php");
db_postmemory($HTTP_GET_VARS);
db_postmemory($HTTP_POST_VARS);
//db_postmemory($HTTP_POST_VARS,2);db_postmemory($HTTP_GET_VARS,2);
$clsolicitem = new cl_solicitem;
$clsolicitempcmater = new cl_solicitempcmater;
$clpcdotac = new cl_pcdotac;
$clpcparam = new cl_pcparam;
$clpcmaterele = new cl_pcmaterele;
$clpcmater = new cl_pcmater;
$clorcorgao = new cl_orcorgao;
$clorcdotacao = new cl_orcdotacao;
$clempautidot = new cl_empautidot;
$cldb_depart = new cl_db_depart;
$clorcreserva = new cl_orcreserva;
$clorcreservasol = new cl_orcreservasol;
$clorcelemento = new cl_orcelemento;

$db_opcao = 1;
$db_botao = true;
if(isset($opcao) && $opcao=="alterar"){
  $db_opcao = 2;
}else if(isset($opcao) && $opcao=="excluir"){
  $db_opcao = 3;
}

$sqlerro=false;
if(isset($incluir) || isset($alterar) || isset($excluir)){
  if(!isset($pc13_coddot) || (isset($pc13_coddot) && $pc13_coddot=="")){
    $sqlerro=true;
    if(isset($incluir)){
      $operacao = "Inclusão"; 
    }else if(isset($alterar)){
      $operacao = "Alteração"; 
    }else if(isset($excluir)){
      $operacao = "Exclusão"; 
    }
    $erro_msg = "Usuário: \\n\\n$operacao não efetuada.\\nCódigo da dotação não informado. \\n\\nAdministrador";
  }
  if($sqlerro==false){
    db_inicio_transacao();
    $clpcdotac->sql_record("update empparametro set e39_anousu = e39_anousu where e39_anousu =".db_getsession("DB_anousu"));
  }
}

$altcoddot = false;
$result_gerareserva = $clpcparam->sql_record($clpcparam->sql_query_file(db_getsession("DB_instit"),"pc30_gerareserva"));
db_fieldsmemory($result_gerareserva,0);

if($pc30_gerareserva=='t'){
  if((isset($alterar) || isset($excluir))){
    $result_altext = $clorcreservasol->sql_record($clorcreservasol->sql_query_orcreserva(null,null,"o80_codres,o80_valor","","o80_coddot = $pc13_coddot and o82_solicitem = $pc13_codigo"));
    if($clorcreservasol->numrows>0){
      db_fieldsmemory($result_altext,0,true);
      if($o80_valor<$pc13_valor){
	$altcoddot = true;
      }
    }
  }
  if((isset($pesquisa_dot) || isset($pc13_coddot) && $pc13_coddot!="") && $sqlerro==false){
    //===================================================>>
    //*******rotina que verifica se ainda existe saldo disponivel******************//
    //rotina para calcular o saldo final
    $result= db_dotacaosaldo(8,2,2,"true","o58_coddot=$pc13_coddot" ,db_getsession("DB_anousu")) ;
    db_fieldsmemory($result,0,true);
    $tot = ((0+$atual_menos_reservado) - (0+$pc13_valor));   
  }
}

$sqlerrosaldo=false;
if(isset($incluir) && $sqlerro==false){
  if($pc13_quant<=0 && $pc13_valor<=0){
    $sqlerro=true;
    $erro_msg = "Usuário: \\n\\nInforme corretamente a quantidade ou o valor da dotação. \\n\\nAdministrador:";
  }
  if(((isset($atual_menos_reservado) && $atual_menos_reservado<$pc13_valor) || (isset($tot) && $tot<0)) && $sqlerro==false && $pc30_gerareserva=='t'){
    $sqlerrosaldo=true;      
  }
  if($sqlerro==false){
    $clpcdotac->pc13_anousu = $pc13_anousu; 
    $clpcdotac->pc13_coddot = $pc13_coddot;
    $clpcdotac->pc13_codigo = $pc13_codigo;
    $clpcdotac->pc13_depto  = $pc13_depto;
    $clpcdotac->pc13_quant  = $pc13_quant;
    $clpcdotac->pc13_valor  = $pc13_valor;
    //select para buscar o código do elemento
    //die($clorcelemento->sql_query_file(null,"o56_codele",""," o56_elemento='$o56_elemento'"));
    if(isset($o56_codele) && $o56_codele!=""){
      $result_codele = $clorcelemento->sql_record($clorcelemento->sql_query_file(null,null,"o56_codele",""," o56_elemento='$o56_elemento' and o56_anousu=".db_getsession("DB_anousu")));
      if($clorcelemento->numrows>0){
        db_fieldsmemory($result_codele,0);
      }
    }
    if((!isset($o56_codele) || (isset($o56_codele) && $o56_codele=="")) && isset($pc13_coddot)){
      $result_codele = $clorcdotacao->sql_record($clorcdotacao->sql_query_file($pc13_anousu,$pc13_coddot,"o58_codele as o56_codele"));
      if($clorcdotacao->numrows>0){
        db_fieldsmemory($result_codele,0);
      }
    }
    $clpcdotac->pc13_codele = @$o56_codele;
    $clpcdotac->incluir($pc13_codigo,$pc13_anousu,$pc13_coddot);
    if($clpcdotac->erro_status==0){
      $sqlerro=true;
    }
    $erro_msg = $clpcdotac->erro_msg;
  }
  if($pc30_gerareserva=='t'){
    if($sqlerro==false && isset($sqlerrosaldo) && $sqlerrosaldo==false){
      $clorcreserva->o80_anousu = db_getsession("DB_anousu");
      $clorcreserva->o80_coddot = $pc13_coddot;
      $clorcreserva->o80_dtfim  = date('Y',db_getsession('DB_datausu'))."-12-31";
      $clorcreserva->o80_dtini  = date('Y-m-d',db_getsession('DB_datausu'));
      $clorcreserva->o80_dtlanc =  date('Y-m-d',db_getsession('DB_datausu'));
      $clorcreserva->o80_valor  = $pc13_valor;
      $clorcreserva->o80_descr  = " ";
      $clorcreserva->o80_justificativa  = " ";
      $clorcreserva->incluir(null);
      $o80_codres = $clorcreserva->o80_codres;
      if($clorcreserva->erro_status==0){
	$sqlerro=true;
	$erro_msg = $clorcreserva->erro_msg;
      }
      if($sqlerro==false){
	$clorcreservasol->incluir($o80_codres,$pc13_codigo);
	if($clorcreservasol->erro_status==0){
	  $sqlerro=true;
	  $erro_msg = $clorcreservasol->erro_msg;
	}
      }
    }else if($sqlerro==false && isset($sqlerrosaldo) && $sqlerrosaldo==true){
      $erro_msg .= "Atenção: \\nDotação sem saldo disponível disponível.\\nReserva da dotação não efetuada.";
    }
  }
  db_fim_transacao($sqlerro);
}else if(isset($alterar) && $sqlerro==false){
  if($pc13_quant<=0 && $pc13_valor<=0){
    $sqlerro=true;
    $erro_msg = "Usuário: \\n\\nInformado corretamente a quantidade ou o valor da dotação. \\n\\nAdministrador:";
  }  
  if($pc30_gerareserva=='t'){
    if($altcoddot==true){ 
      if(($o80_valor+$atual_menos_reservado)<$pc13_valor && $sqlerro==false){
	$sqlerrosaldo=true;      
      }
    }
    if(($atual_menos_reservado<$pc13_valor || $tot<0) && $sqlerro==false){
      $sqlerrosaldo=true;      
    }
  }

  if($sqlerro==false){
    $clpcdotac->pc13_anousu = $pc13_anousu; 
    $clpcdotac->pc13_coddot = $pc13_coddot;
    $clpcdotac->pc13_codigo = $pc13_codigo;
    $clpcdotac->pc13_depto  = $pc13_depto;
    $clpcdotac->pc13_quant  = $pc13_quant;
    $clpcdotac->pc13_valor  = $pc13_valor;
    
    //select para buscar o código do elemento
    $result_codele = $clorcelemento->sql_record($clorcelemento->sql_query_file(null,null,"o56_codele",""," o56_elemento='$o56_elemento' and o56_anousu=".db_getsession("DB_anousu")));
    if($clorcelemento->numrows>0){
      db_fieldsmemory($result_codele,0);
    }     
    $clpcdotac->pc13_codele = $o56_codele;      

    $clpcdotac->alterar($pc13_codigo,$pc13_anousu,$pc13_coddot);
    if($clpcdotac->erro_status==0){
      $sqlerro=true;
    }
    $erro_msg = $clpcdotac->erro_msg;
    if($pc30_gerareserva=='t'){
      if($sqlerro==false && $sqlerrosaldo==false){
	if(isset($o80_codres) && $o80_codres!=""){
	  $clorcreserva->atualiza_valor($o80_codres,$pc13_valor);
	}else{
	  $clorcreserva->o80_anousu = db_getsession("DB_anousu");
	  $clorcreserva->o80_coddot = $pc13_coddot;
	  $clorcreserva->o80_dtfim  = date('Y',db_getsession('DB_datausu'))."-12-31";
	  $clorcreserva->o80_dtini  = date('Y-m-d',db_getsession('DB_datausu'));
	  $clorcreserva->o80_dtlanc =  date('Y-m-d',db_getsession('DB_datausu'));
	  $clorcreserva->o80_valor  = $pc13_valor;
	  $clorcreserva->o80_descr  = " ";
    $clorcreserva->o80_justificativa  = " ";
	  $clorcreserva->incluir(null);
	  $o80_codres = $clorcreserva->o80_codres;
	  if($clorcreserva->erro_status==0){
	    $sqlerro=true;
	    $erro_msg = $clorcreserva->erro_msg;
	  }
	  if($sqlerro==false){
	    $clorcreservasol->incluir($o80_codres,$pc13_codigo);
	    if($clorcreservasol->erro_status==0){
	      $sqlerro=true;
	      $erro_msg = $clorcreservasol->erro_msg;
	    }
	  }
	}
      }else if($sqlerro==false && $sqlerrosaldo==true){
	$erro_msg .= "Atenção: \\nDotação sem saldo disponível disponível.\\nReserva da dotação não efetuada.";
	if($sqlerro==false){
	  $clorcreservasol->excluir($o80_codres,$pc13_codigo);
	  if($clorcreservasol->erro_status==0){
	    $sqlerro=true;
	    $erro_msg = $clorcreservasol->erro_msg;
	  }
	}
	if($sqlerro==false){
	  $clorcreserva->excluir($o80_codres);
	  if($clorcreserva->erro_status==0){
	    $sqlerro=true;
	    $erro_msg = $clorcreserva->erro_msg;
	  }
	}
      }
    }
    db_fim_transacao($sqlerro);   
  }
}else if(isset($excluir) && $sqlerro==false){
  $sqlerro=false;
  if(isset($o80_codres)){
    if($sqlerro==false){
      $clorcreservasol->excluir($o80_codres,$pc13_codigo);
      if($clorcreservasol->erro_status==0){
	$sqlerro=true;
	$erro_msg = $clorcreservasol->erro_msg;
      }
    }
    if($sqlerro==false){
      $clorcreserva->excluir($o80_codres);
      if($clorcreserva->erro_status==0){
	$sqlerro=true;
	$erro_msg = $clorcreserva->erro_msg;
      }
    }
  }
  if($sqlerro==false){
    $clpcdotac->excluir($pc13_codigo,$pc13_anousu,$pc13_coddot);
    if($clpcdotac->erro_status==0){
      $sqlerro=true;
    }
    $erro_msg = $clpcdotac->erro_msg;
  }
  db_fim_transacao($sqlerro);
}

if(isset($opcao) && $opcao!="incluir"){
  $result_pcdotac = $clpcdotac->sql_record($clpcdotac->sql_query_depart(@$pc13_codigo,@$pc13_anousu,@$pc13_coddot,"pc13_coddot,pc13_quant,pc13_valor,pc13_depto,pc13_codele,descrdepto"));
  if($clpcdotac->numrows>0){
    db_fieldsmemory($result_pcdotac,0);
  }
}
if(isset($pesquisa_dot)){
  $result_descrdepto = $cldb_depart->sql_record($cldb_depart->sql_query_file($pc13_depto,"descrdepto"));
  if($cldb_depart->numrows>0){
    db_fieldsmemory($result_descrdepto,0);
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
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<?if(!isset($consulta)){?>
<table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
  <tr> 
    <td width="360" height="18">&nbsp;</td>
    <td width="263">&nbsp;</td>
    <td width="25">&nbsp;</td>
    <td width="140">&nbsp;</td>
  </tr>

</table>
<?}?>
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC"> 
    <center>
      <?
      include("forms/db_frmseldotac.php");
      ?>
    </center>
    </td>
  </tr>
</table>
<?
  if(!isset($consulta)){
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
  }
?>
</body>
</html>
<?
if(isset($alterar) || isset($excluir) || isset($incluir)){
  if($sqlerro==true){
    $erro_msg = str_replace("\n","\\n",$erro_msg);
    db_msgbox($erro_msg);
    if($clsolicitem->erro_campo!=""){
      echo "<script> document.form1.".$clpcdotac->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clpcdotac->erro_campo.".focus();</script>";
    }
  }else{
    echo "<script> document.location.href='com1_seldotac001.php?pc13_codigo=$pc13_codigo&pc11_numero=$pc11_numero&pc16_codmater=$pc16_codmater'</script>";
  }
}
?>
