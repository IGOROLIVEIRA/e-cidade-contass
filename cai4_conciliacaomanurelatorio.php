<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_conciliacao_classe.php");
include("dbforms/db_funcoes.php");	
include("libs/db_utils.php");
db_postmemory($HTTP_POST_VARS);
$clconciliacao = new cl_conciliacao;

?>

<?
//MODULO: caixa
$clconciliacao->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("db83_descricao");
?>
<script>
function js_verifica(){
	
  var datainicio = document.form1.k199_periodoini.value;
  var datafim =document.form1.k199_periodofinal.value;
  
  var convertedataini = parseInt(datainicio.split("/")[2].toString() + datainicio.split("/")[1].toString() + datainicio.split("/")[0].toString());
  var convertedatafim = parseInt(datafim.split("/")[2].toString() + datafim.split("/")[1].toString() + datafim.split("/")[0].toString());
  //alert(convertedataini);
  
  if(convertedataini>convertedatafim){
	alert('A data inicial, não deve ser superior a data final. Verifique! ');
    return false;
  }
  return true;
}

</script>


<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Typcai4_conciliacaomanurelatorio.phpe" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
  
 <center>
	
	<form name="form1" method="post" action="" onsubmit="return js_verifica();">
<center>
<fieldset style="width: 700px;margin-left: 2px; margin-top: 100px;">
<legend style="font-weight: bold;"> Relatório de Conciliação Manual</legend>
<table border="0">

  <tr>
  <td nowrap title="<?=@$Tk199_codconta?>">
       <?
       $db_opcao=1;
       db_ancora(@$Lk199_codconta,"js_pesquisak199_codconta(true);",$db_opcao);
       ?>
    </td>
    <td> 
       <?
		db_input('k199_codconta',8,$Ik199_codconta,true,'text',3," onchange='js_pesquisak199_codconta(false);'")
	   ?>
       <?
		db_input('db83_descricao',40,$Idb83_descricao,true,'text',3,'')
       ?>
    </td>
  </tr>  
  <tr>
        <td nowrap title="<?=@$Tk199_periodofinal?>">
       <?=@$Lk199_periodofinal?>
    </td>
    <td>
    <?
    	db_inputdata('k199_periodoini',@$k199_periodoini_dia,@$k199_periodoini_mes,@$k199_periodoini_ano,true,'text',$db_opcao,"")
    ?> 
   <b>a</b> 
	<?
		db_inputdata('k199_periodofinal',@$k199_periodofinal_dia,@$k199_periodofinal_mes,@$k199_periodofinal_ano,true,'text',$db_opcao,"")
	?>
  </table>
  </fieldset>
  </center>
<!-- <input name="emitir" type="button" size="10" id="emitir" value="Emitir" onclick="js_emite();" >-->
<!--<input name="limpar" type="button" size="3" id="limpar" value="Limpar" onclick="js_limpar();" >-->
<input name="<?=($db_opcao==1?"emitir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Emitir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?>">

</form>

</body>
</html>

<?
	if(isset($emitir)){
	
	$sql=" select k199_periodofinal from conciliacao where k199_periodofinal='{$k199_periodofinal}' and k199_codconta='{$k199_codconta}'  and k199_periodoini='{$k199_periodoini}'";
	
	$result = db_query($sql);
 	$row=pg_num_rows($result);
 	
 	if($row==0){
 		echo "<script>alert('Não possui uma conciliação  com este período. Verifique!')</script>";
 	}
 	else
 	{
	 	 $sql=" SELECT k199_periodofinal FROM conciliacao WHERE k199_periodofinal='{$k199_periodofinal}' AND k199_codconta='{$k199_codconta}'  AND k199_periodoini='{$k199_periodoini}' AND k199_status= 1 ";
	 	 $result = db_query($sql);
	 	 $row=pg_num_rows($result);
		 
	 	 if($row==0){
		 	 echo "<script>
		 	 var x=confirm('A conciliacao que se encontra  neste período, está em aberto. Deseja emitir relatório nessas condições?');
		 	 if(x){
			 		  jan = window.open('cai4_relatorioconmanusql.php?&banco='+document.form1.db83_descricao.value+'&codigoconta='+document.form1.k199_codconta.value+'&periodoinicio='+document.form1.k199_periodoini.value+'&periodofim='+document.form1.k199_periodofinal.value,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
			 		 }else{
			 		 		window.location.replace(window.location.href);
		 				  }
		 	 </script>";
	 	  }else{
	 	  	echo "<script> jan = window.open('cai4_relatorioconmanusql.php?&banco='+document.form1.db83_descricao.value+'&codigoconta='+document.form1.k199_codconta.value+'&periodoinicio='+document.form1.k199_periodoini.value+'&periodofim='+document.form1.k199_periodofinal.value,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');</script>";
	 	  }
 	}
}

?>	

<script>

function js_limpar()
{
	//parent.document.form1.k199_saldofinalextrato.value;
	document.form1.k199_codconta.value='';
	document.form1.db83_descricao.value='';
	document.form1.k199_periodoini.value='';
	document.form1.k199_periodofinal.value='';
	alert('Preencha os campos para a emissão do relatório!');
}

function js_pesquisak199_codconta(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('','db_iframe_contabancaria','func_contabancaria.php?funcao_js=parent.js_mostracontabancaria1|db83_sequencial|db83_descricao','Pesquisa',true);
  }else{
     if(document.form1.k199_codconta.value != ''){ 
       js_OpenJanelaIframe('','db_iframe_contabancaria','func_contabancaria.php?pesquisa_chave='+document.form1.k199_codconta.value+'&funcao_js=parent.js_mostracontabancaria','Pesquisa',false);
     }else{
       document.form1.db83_descricao.value = ''; 
     }
  }
}
function js_mostracontabancaria(chave,erro){
  document.form1.db83_descricao.value = chave; 
  if(erro==true){ 
    document.form1.k199_codconta.focus(); 
    document.form1.k199_codconta.value = ''; 
  }
}
function js_mostracontabancaria1(chave1,chave2){
  document.form1.k199_codconta.value = chave1;
  document.form1.db83_descricao.value = chave2;
  db_iframe_contabancaria.hide();
}

function js_preenchepesquisa(chave){
  db_iframe_conciliacao.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
    </center>
    <?
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>

