<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
include("classes/db_veiculos_classe.php");
include("classes/db_veicresp_classe.php");
include("classes/db_veicpatri_classe.php");
include("classes/db_veicparam_classe.php");
include("classes/db_veictipoabast_classe.php");
include("classes/db_veiccentral_classe.php");
include("classes/db_veicabast_classe.php");
include_once("classes/db_tipoveiculos_classe.php");

parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);

$clveiculos      = new cl_veiculos;
$clveicresp      = new cl_veicresp;
$clveicpatri     = new cl_veicpatri;
$clveicparam     = new cl_veicparam;
$clveictipoabast = new cl_veictipoabast;
$clveiccentral   = new cl_veiccentral;
$clveicabast     = new cl_veicabast;
$cltipoveiculos  = new cl_tipoveiculos;

$db_opcao = 22;
$db_botao = false;
if(isset($alterar)){
  $sqlerro=false;
  db_inicio_transacao();
  $db_opcao = 2;

if (isset($ve01_placa) && $ve01_placa==null){
    $erro_msg = "Informar a placa do veiculo.Verifique.";
    $sqlerro  = true;
    db_msgbox($erro_msg);

}


if (isset($ve01_veiccadmarca) && $ve01_veiccadmarca=="0"){
      $erro_msg = "Informar a marca .Verifique.";
      $sqlerro  = true;
      db_msgbox($erro_msg);
}


if (isset($ve01_veiccadmodelo) && $ve01_veiccadmodelo==null){
        $erro_msg = "Informar o modelo .Verifique.";
        $sqlerro  = true;
        db_msgbox($erro_msg);
}

if (isset($ve01_veiccadcor) && $ve01_veiccadcor=="0"){
          $erro_msg = "Informar a cor .Verifique.";
          $sqlerro  = true;
          db_msgbox($erro_msg);
}

if (isset($ve01_chassi) && $ve01_chassi==null){
            $erro_msg = "Informar o chassi .Verifique.";
            $sqlerro  = true;
            db_msgbox($erro_msg);
}

if (isset($ve01_ranavam) && $ve01_ranavam==null){
              $erro_msg = "Informar o renavam .Verifique.";
              $sqlerro  = true;
              db_msgbox($erro_msg);
}

if (isset($ve01_placanum) && $ve01_placanum==null){
          $erro_msg = "Informar a placa em número .Verifique.";
          $sqlerro  = true;
          db_msgbox($erro_msg);
}
if (isset($ve01_certif) && $ve01_certif==null){
          $erro_msg = "Informar o número do certificado .Verifique.";
          $sqlerro  = true;
          db_msgbox($erro_msg);
}

if (isset($ve01_quantpotencia) && $ve01_quantpotencia==null){
            $erro_msg = "Informar quantidade de potência .Verifique.";
            $sqlerro  = true;
            db_msgbox($erro_msg);
}


if (isset($ve01_veictipoabast) && $ve01_veictipoabast==null){
          $erro_msg = "Informar o tipo de abastecimento .Verifique.";
          $sqlerro  = true;
          db_msgbox($erro_msg);
}

if (isset($ve01_medidaini) && $ve01_medidaini==null){
          $erro_msg = "Informar a medida inicial .Verifique.";
          $sqlerro  = true;
          db_msgbox($erro_msg);
}

if (isset($ve01_quantcapacidad) && $ve01_quantcapacidad==null){
          $erro_msg = "Informar a quantidade capacidade .Verifique.";
          $sqlerro  = true;
          db_msgbox($erro_msg);
}


if (isset($ve01_dtaquis) && $ve01_dtaquis==null){
          $erro_msg = "Informar a data de aquisição .Verifique.";
          $sqlerro  = true;
          db_msgbox($erro_msg);
}

if (isset($ve06_veiccadcomb) && $ve06_veiccadcomb==null){
          $erro_msg = "Informar o combustível.Verifique.";
          $sqlerro  = true;
          db_msgbox($erro_msg);
}
if (isset($ve01_anofab) && $ve01_anofab==null){
          $erro_msg = "Informar o ano de fabricação .Verifique.";
          $sqlerro  = true;
          db_msgbox($erro_msg);
}

if (isset($ve01_anomod) && $ve01_anomod==null){
          $erro_msg = "Informar o ano do modelo .Verifique.";
          $sqlerro  = true;
          db_msgbox($erro_msg);
}




$result = $clveiculos->sql_record($clveiculos->sql_query_file(null,"ve01_veictipoabast as tipoabast ",null,"ve01_codigo = $ve01_codigo"));
  if ($clveiculos->numrows>0){
      db_fieldsmemory($result,0);
      if ($tipoabast!=$ve01_veictipoabast and $tipoabast!="true"){
          $result = $clveicabast->sql_record($clveicabast->sql_query_file(null,"ve70_codigo",null,"ve70_veiculos= $ve01_codigo"));
          if ($clveicabast->numrows>0){
                 $sqlerro  = true;
                 $erro_msg = "Já existe abastecimento cadastrado para este veículo.Verifique.";
                 $clveicabast->erro_campo = "ve70_codigo";
       }
    }
}






  $result = $clveiculos->sql_record($clveiculos->sql_query_file(null,"ve01_placa",null,"ve01_codigo != $ve01_codigo and ve01_placa = '$ve01_placa'"));
  if ($clveiculos->numrows > 0){
    $sqlerro  = true;
    $erro_msg = "Placa já cadastrada para outro veículo. Verifique.";
    $clveiculos->erro_campo = "ve01_placa";
  }

  $result = $clveiculos->sql_record($clveiculos->sql_query_file(null,"*",null,"ve01_codigo != $ve01_codigo and ve01_ranavam = $ve01_ranavam"));
  if ($clveiculos->numrows > 0){
    $sqlerro  = true;
    $erro_msg = "Renavam já cadastrado para outro veículo. Verifique.";
    $clveiculos->erro_campo = "ve01_ranavam";
  }

  $result = $clveiculos->sql_record($clveiculos->sql_query_file(null,"*",null,"ve01_codigo != $ve01_codigo and ve01_chassi = '$ve01_chassi'"));
  if ($clveiculos->numrows > 0){
    $sqlerro  = true;
    $erro_msg = "Chassi já cadastrado para outro veículo. Verifique.";
    $clveiculos->erro_campo = "ve01_chassi";
  }

  if ($sqlerro==false){
    $clveiculos->alterar($ve01_codigo);
    $erro_msg=$clveiculos->erro_msg;
    if($clveiculos->erro_status=="0"){
    	$sqlerro=true;
    }
  }

  /*
   * Altera tipo veiculo para sicom
   */
  if ($sqlerro==false){
    $cltipoveiculos->alterar($ve01_codigo);
    $erro_msg=$cltipoveiculos->erro_msg;
    if($cltipoveiculos->erro_status=="0"){
    	$sqlerro=true;
    }
  }

  if ($sqlerro==false) {

    $result_resp = $clveicresp->sql_record($clveicresp->sql_query_file(null,"ve02_codigo",null," ve02_veiculo = $ve01_codigo "));
    /**
     * Exclui o responsavel, e inclui novamente
     */
    if ($clveicresp->numrows > 0 ) {

       $clveicresp->excluir( null, "ve02_veiculo={$ve01_codigo}");
       if ($clveicresp->erro_status=="0") {

         $sqlerro=true;
         $erro_msg=$clveicresp->erro_msg;
        }

     }
 	   if ($ve02_numcgm!= 0 ){

 	     $clveicresp->ve02_numcgm=$ve02_numcgm;
       $clveicresp->ve02_veiculo=$clveiculos->ve01_codigo;
       $clveicresp->incluir(null);
       if ($clveicresp->erro_status=="0"){

         $sqlerro=true;
         $erro_msg=$clveicresp->erro_msg;
       }
    }
  }

  if ($sqlerro==false) {

  	$result_patri = $clveicpatri->sql_record($clveicpatri->sql_query(null,"ve03_codigo",null," ve03_veiculo = $ve01_codigo "));
  	if ($clveicpatri->numrows > 0) {

  	  db_fieldsmemory($result_patri,0);
  	/**
  	 * exclui e incluimos novamente
  	 */
  	  $clveicpatri->excluir(null, "ve03_veiculo = {$ve01_codigo}");
  	  if ($clveicpatri->erro_status == "0") {

        $sqlerro  = true;
        $erro_msg = $clveicpatri->erro_msg;
      }
  	}

  	if (isset($ve03_bem)&&$ve03_bem != '') {

  		$clveicpatri->ve03_veiculo=$clveiculos->ve01_codigo;
  		$clveicpatri->incluir(null);
  		if ($clveicpatri->erro_status=="0") {
  	 		$sqlerro=true;
  	 		$erro_msg=$clveicpatri->erro_msg;
  		}
  	}
  }
  db_fim_transacao($sqlerro);
}else if(isset($chavepesquisa)){
   $db_opcao = 2;
   $result = $clveiculos->sql_record($clveiculos->sql_query($chavepesquisa));
   db_fieldsmemory($result,0);

   $db_botao = true;
   $result_resp = $clveicresp->sql_record($clveicresp->sql_query(null,"*",null," ve02_veiculo = $chavepesquisa "));
   if ($clveicresp->numrows>0){
     db_fieldsmemory($result_resp,0);
   }
   $result_patri = $clveicpatri->sql_record($clveicpatri->sql_query(null,"*",null," ve03_veiculo = $chavepesquisa "));
   if ($clveicpatri->numrows>0){
     db_fieldsmemory($result_patri,0);
   }

   if (isset($codveictipoabast) && trim($codveictipoabast)!= ""){
     $ve01_veictipoabast = $codveictipoabast;
   }

   $result_veictipoabast = $clveictipoabast->sql_record($clveictipoabast->sql_query($ve01_veictipoabast));
   if ($clveictipoabast->numrows > 0){
     db_fieldsmemory($result_veictipoabast,0);
   }

   //Result para modulo sicom
   $result_tipoveiculos = $cltipoveiculos->sql_record($cltipoveiculos->sql_query(null,"*",null," si04_veiculos = $chavepesquisa"));
   if ($cltipoveiculos->numrows > 0){
     db_fieldsmemory($result_tipoveiculos,0);
   }

?>
    <script>
       parent.document.formaba.veicitensobrig.disabled=false;
       CurrentWindow.corpo.iframe_veicitensobrig.location.href='vei1_veicitensobrig001.php?ve09_veiculos=<?=@$chavepesquisa?>';
       parent.document.formaba.veicutilizacao.disabled=false;
       CurrentWindow.corpo.iframe_veicutilizacao.location.href='vei1_veicutilizacao001.php?ve15_veiculos=<?=@$chavepesquisa?>';
       parent.document.formaba.veiccentral.disabled=false;
       CurrentWindow.corpo.iframe_veiccentral.location.href='vei1_veiccentralveiculos001.php?ve09_veiculos=<?=@$chavepesquisa?>';
<?
   if (isset($liberaaba) && $liberaaba == true){
?>
       parent.mo_camada('veicitensobrig');
<?
   }
?>
    </script>
<?
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
	include("forms/db_frmveiculos.php");
	?>
    </center>
	</td>
  </tr>
</table>
</body>
</html>
<?
if(isset($alterar)){
  if($clveiculos->erro_status=="0"&&$sqlerro==true){
    //$clveiculos->erro(true,false);
    db_msgbox($erro_msg);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clveiculos->erro_campo!=""){
      echo "<script> document.form1.".$clveiculos->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clveiculos->erro_campo.".focus();</script>";
    }
  }else{
    if ($sqlerro==false){
      $clveiculos->erro(true,true);
    } else {
      db_msgbox($erro_msg);
      $db_botao=true;
      echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
      if($clveiculos->erro_campo!=""){
        echo "<script> document.form1.".$clveiculos->erro_campo.".style.backgroundColor='#99A9AE';</script>";
        echo "<script> document.form1.".$clveiculos->erro_campo.".focus();</script>";
      }
    }
  }
}

if (isset($chavepesquisa)&&isset($ve01_ativo)&&trim($ve01_ativo)=="0"){
  db_msgbox("Um veículo baixado não pode ser alterado!");
  unset($chavepesquisa);
	echo "<script>document.form1.alterar.disabled=true;</script>";
}

if($db_opcao==22){
  echo "<script>document.form1.pesquisar.click();</script>";
}

?>
<script>
js_tabulacaoforms("form1","ve01_placa",true,1,"ve01_placa",true);
</script>
