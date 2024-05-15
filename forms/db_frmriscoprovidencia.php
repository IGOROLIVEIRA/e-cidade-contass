<?
//MODULO: sicom
include("dbforms/db_classesgenericas.php");
$cliframe_alterar_excluir = new cl_iframe_alterar_excluir;
$clriscoprovidencia->rotulo->label();
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
     
     $si54_dscprovidencia = "";
     $si54_valorassociado = "";
   }
} 
?>
<form name="form1" method="post" action="">
<center>
<fieldset style="width: 800px; margin-left: 200px; margin-top: 80px;"><legend
	style="font-weight: bold;"> Risco Providência</legend>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tsi54_seqriscofiscal?>">
       <b>Código Sequencial do Risco:</b>
    </td>
    <td> 
	<?
	db_input('si54_seqriscofiscal',8,$Isi54_seqriscofiscal,true,'text',3,"")
	?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi54_sequencial?>">
       <b>Código Sequencial Providência:</b>
    </td>
    <td> 
	<?
	db_input('si54_sequencial',8,$Isi54_sequencial,true,'text',3,"")
	?>
    </td>
  </tr>
  
  
  <tr>
    <td nowrap title="<?=@$Tsi54_dscprovidencia?>">
       <?=@$Lsi54_dscprovidencia?>
    </td>
    <td> 
<?
db_textarea("si54_dscprovidencia",7,40, "", true, "text", $db_opcao, "", "", "",500);
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi54_valorassociado?>">
       <?=@$Lsi54_valorassociado?>
    </td>
    <td> 
<?
db_input('si54_valorassociado',15,$Isi54_valorassociado,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
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
	 $chavepri= array("si54_sequencial"=>@$si54_sequencial);
	 $cliframe_alterar_excluir->chavepri=$chavepri;
	 $cliframe_alterar_excluir->sql     = $clriscoprovidencia->sql_query_file($si54_sequencial,"*",null,"si54_seqriscofiscal=".$si54_seqriscofiscal);
	 $cliframe_alterar_excluir->campos  ="si54_sequencial,si54_dscprovidencia,si54_valorassociado";
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
