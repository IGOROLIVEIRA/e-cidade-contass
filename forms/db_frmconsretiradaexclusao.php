<?
//MODULO: contabilidade
include("dbforms/db_classesgenericas.php");
//$cliframe_alterar_excluir = new cl_iframe_alterar_excluir;
$clconsretiradaexclusao->rotulo->label();
if(isset($db_opcaoal)){
   $db_opcao=33;
    //$db_botao=false;
    $db_botao=true;
}else if(isset($opcao) && $opcao=="alterar"){
    $db_botao=true;
    $db_opcao = 2;
}else if(isset($opcao) && $opcao=="excluir"){
    $db_opcao = 3;
    $db_botao=true;
}else{  
    $db_opcao = 1;
    $db_botao=true;
    /*if(isset($novo) || isset($alterar) ||   isset($excluir) || (isset($incluir) && $sqlerro==false ) ){
     $c204_sequencial = "";
    	//$c204_consconsorcios = "";
     $c204_tipoencerramento = "";
     $c204_dataencerramento = "";
   }*/
} 
?>
<form name="form1" method="post" action="">
<center>
<fieldset style="margin-left: 80px; margin-top: 10px;">
<legend>Retirada/Exclusão do Ente Consorciado ou Extinção do Consórcio</legend>
<table border="0">
  <tr>
    <td nowrap title="<?//=@$Tc204_sequencial?>">
       <?//=@$Lc204_sequencial?>
    </td>
    <td> 
<?
db_input('c204_sequencial',10,$Ic204_sequencial,true,'hidden',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc204_consconsorcios?>">
       <?=@$Lc204_consconsorcios?>
    </td>
    <td> 
<?
db_input('c204_consconsorcios',10,$Ic204_consconsorcios,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc204_tipoencerramento?>">
       <?=@$Lc204_tipoencerramento?>
    </td>
    <td> 
<?
$x = array("1"=>"Retirada/Exclusão do Ente Consorciado","2"=>"Extinção do Consórcio");
db_select('c204_tipoencerramento',$x,true,$db_opcao,"");
//db_input('c204_tipoencerramento',10,$Ic204_tipoencerramento,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc204_dataencerramento?>">
       <?=@$Lc204_dataencerramento?>
    </td>
    <td> 
<?
db_inputdata('c204_dataencerramento',@$c204_dataencerramento_dia,@$c204_dataencerramento_mes,@$c204_dataencerramento_ano,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  </tr>
    <td colspan="2" align="center">
 <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?>  >
<!-- <input name="novo" type="button" id="cancelar" value="Novo" onclick="js_cancelar();"  --> 
	  <?//=($db_opcao==1||isset($db_opcaoal)?"style='visibility:hidden;'":"")?> <!-- > -->
    </td>
  </tr>
  </table>
<!-- <table>
  <tr>
    <td valign="top"  align="center">  -->   
    <?/*
	 $chavepri= array("c204_sequencial"=>@$c204_sequencial);
	 $cliframe_alterar_excluir->chavepri=$chavepri;
	 $cliframe_alterar_excluir->sql     = $clconsretiradaexclusao->sql_query_file($c204_sequencial);
	 $cliframe_alterar_excluir->campos  ="c204_sequencial,c204_consconsorcios,c204_tipoencerramento,c204_dataencerramento";
	 $cliframe_alterar_excluir->legenda="ITENS LANÇADOS";
	 $cliframe_alterar_excluir->iframe_height ="160";
	 $cliframe_alterar_excluir->iframe_width ="700";
	 $cliframe_alterar_excluir->iframe_alterar_excluir($db_opcao);*/
    ?>
 <!--  </td>  
   </tr>
 </table>  --> 
 </fieldset>
  </center>
</form>
<script>
function js_cancelar(){
  var opcao = document.createElement("input");
  opcao.setAttribute("type","hidden");
  opcao.setAttribute("name","novo");
  opcao.setAttribute("value","true");
  document.form1.appendChild(opcao);
  document.form1.submit();
}
</script>
