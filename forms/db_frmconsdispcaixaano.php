<?
//MODULO: contabilidade
include("dbforms/db_classesgenericas.php");
//$cliframe_alterar_excluir = new cl_iframe_alterar_excluir;
$clconsdispcaixaano->rotulo->label();
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
     $c203_sequencial = "";
    	//$c203_consconsorcios = "";
     $c203_valor = "";
     $c203_anousu = "";
   }*/
} 
?>
<form name="form1" method="post" action="">
<center>
<fieldset style="margin-left: 80px; margin-top: 10px;">
<legend>Disponibilidade de Caixa 31/12</legend>
<table border="0">
  <tr>
    <td nowrap title="<?//=@$Tc203_sequencial?>">
       <?//=@$Lc203_sequencial?>
    </td>
    <td> 
<?
db_input('c203_sequencial',11,$Ic203_sequencial,true,'hidden',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc203_consconsorcios?>">
       <?=@$Lc203_consconsorcios?>
    </td>
    <td> 
<?
db_input('c203_consconsorcios',10,$Ic203_consconsorcios,true,'text',3,"")
?>
    </td>
  </tr>
    <tr>
    <td nowrap title="Código da fonte de recursos">
       <b>Fonte de Recursos: </b>
    </td>
    <td> 
<?
if(db_getsession('DB_anousu') > 2022)
  db_input('c203_codfontrecursos',10,$Ic203_codfontrecursos,true,'text',$db_opcao,"","","","",7);
else
  db_input('c203_codfontrecursos',10,$Ic203_codfontrecursos,true,'text',$db_opcao,"");
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc203_valor?>">
       <?=@$Lc203_valor?>
    </td>
    <td> 
<?
db_input('c203_valor',11,$Ic203_valor,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc203_anousu?>">
       <?=@$Lc203_anousu?>
    </td>
    <td> 
<?
$c203_anousu = db_getsession('DB_anousu');
db_input('c203_anousu',10,$Ic203_anousu,true,'text',3,"")
?>
    </td>
  </tr>
  </tr>
    <td colspan="2" align="center">
 <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?>  >
 <!-- <input name="novo" type="button" id="cancelar" value="Novo" onclick="js_cancelar();"  -->
  <?//=($db_opcao==1||isset($db_opcaoal)?"style='visibility:hidden;'":"")?> 
  <!-- >  -->
    </td>
  </tr>
  </table>
<!-- <table>
  <tr>
    <td valign="top"  align="center">  -->  
    <?/*
	 $chavepri= array("c203_sequencial"=>@$c203_sequencial);
	 $cliframe_alterar_excluir->chavepri=$chavepri;
	 $cliframe_alterar_excluir->sql     = $clconsdispcaixaano->sql_query_file($c203_sequencial);
	 $cliframe_alterar_excluir->campos  ="c203_sequencial,c203_consconsorcios,c203_valor,c203_anousu";
	 $cliframe_alterar_excluir->legenda="ITENS LANÇADOS";
	 $cliframe_alterar_excluir->iframe_height ="160";
	 $cliframe_alterar_excluir->iframe_width ="700";
	 $cliframe_alterar_excluir->iframe_alterar_excluir($db_opcao);*/
    ?>
    <!-- </td>
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
