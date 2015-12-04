<?
//MODULO: contabilidade
include("dbforms/db_classesgenericas.php");
$cliframe_alterar_excluir = new cl_iframe_alterar_excluir;
$clconvdetalhaconcedentes->rotulo->label();
if(isset($db_opcaoal)){
   $db_opcao=33;
    $db_botao=false;
}else if(isset($opcao) && $opcao=="alterar"){
    $db_botao=true;
    $db_opcao = 2;
}else if(isset($opcao) && $opcao=="excluir"){
    $db_opcao = 3;
    $db_botao=true;
}else{  
    $db_opcao = 1;
    $db_botao=true;
    if(isset($novo) || isset($alterar) ||   isset($excluir) || (isset($incluir) && $sqlerro==false ) ){
     $c207_nrodocumento = "";
     $c207_esferaconcedente = "";
     $c207_valorconcedido = "";
     $c207_sequencial = "";
   }
} 
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tc207_sequencial?>">
       <?=@$Lc207_sequencial?>
    </td>
    <td> 
<?
db_input('c207_sequencial',12,$Ic207_sequencial,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc207_nrodocumento?>">
       <?=@$Lc207_nrodocumento?>
    </td>
    <td> 
<?
db_input('c207_nrodocumento',14,$Ic207_nrodocumento,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc207_esferaconcedente?>">
       <?=@$Lc207_esferaconcedente?>
    </td>
    <td> 
<?
$x = array("1"=>"Federal","2"=>"Estadual","3"=>"Municipal");
db_select('c207_esferaconcedente',$x,true,$db_opcao,"");
//db_input('c207_esferaconcedente',1,$Ic207_esferaconcedente,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tc207_valorconcedido?>">
       <?=@$Lc207_valorconcedido?>
    </td>
    <td> 
<?
db_input('c207_valorconcedido',14,$Ic207_valorconcedido,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  
<?
db_input('c207_codconvenio',12,$Ic207_codconvenio,true,'hidden',$db_opcao,"")
?>
  
  </tr>
    <td colspan="2" align="center">
 <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?>  >
 <input name="novo" type="button" id="cancelar" value="Novo" onclick="js_cancelar();" <?=($db_opcao==1||isset($db_opcaoal)?"style='visibility:hidden;'":"")?> >
    </td>
  </tr>
  </table>
 <table>
  <tr>
    <td valign="top"  align="center">  
    <?
	 $chavepri= array("c207_sequencial"=>@$c207_sequencial);
	 $cliframe_alterar_excluir->chavepri=$chavepri;
	 $cliframe_alterar_excluir->sql     = $clconvdetalhaconcedentes->sql_query_file(null,"*",null,"c207_codconvenio = $c207_codconvenio");
	 $cliframe_alterar_excluir->campos  ="c207_sequencial,c207_nrodocumento,c207_esferaconcedente,c207_valorconcedido,c207_codconvenio";
	 $cliframe_alterar_excluir->legenda="ITENS LANÇADOS";
	 $cliframe_alterar_excluir->iframe_height ="160";
	 $cliframe_alterar_excluir->iframe_width ="700";
	 $cliframe_alterar_excluir->iframe_alterar_excluir($db_opcao);
    ?>
    </td>
   </tr>
 </table>
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
