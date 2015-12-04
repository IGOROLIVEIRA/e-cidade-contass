<?
//MODULO: sicom
include("dbforms/db_classesgenericas.php");
$cliframe_alterar_excluir = new cl_iframe_alterar_excluir;
$clprojecaoatuarial20->rotulo->label();
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
     $si169_sequencial = "";
     $si169_exercicio = "";
     $si169_vlreceitaprevidenciaria = "";
     $si169_vldespesaprevidenciaria = "";
     $si169_dtcadastro = "";
     $si169_instit = "";
   }
} 
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tsi169_sequencial?>">
       <?=@$Lsi169_sequencial?>
    </td>
    <td> 
<?
db_input('si169_sequencial',10,$Isi169_sequencial,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi169_exercicio?>">
       <?=@$Lsi169_exercicio?>
    </td>
    <td> 
<?
db_input('si169_exercicio',4,$Isi169_exercicio,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi169_vlreceitaprevidenciaria?>">
       <?=@$Lsi169_vlreceitaprevidenciaria?>
    </td>
    <td> 
<?
db_input('si169_vlreceitaprevidenciaria',14,$Isi169_vlreceitaprevidenciaria,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi169_vldespesaprevidenciaria?>">
       <?=@$Lsi169_vldespesaprevidenciaria?>
    </td>
    <td> 
<?
db_input('si169_vldespesaprevidenciaria',14,$Isi169_vldespesaprevidenciaria,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  
<?
$si169_dtcadastro_dia = date("d");
$si169_dtcadastro_mes = date("m");
$si169_dtcadastro_ano = date("Y");
db_inputdata('si169_dtcadastro',@$si169_dtcadastro_dia,@$si169_dtcadastro_mes,@$si169_dtcadastro_ano,true,'hidden',$db_opcao,"")
?>
  

<?
$si169_instit = db_getsession("DB_instit");
db_input('si169_instit',10,$Isi169_instit,true,'hidden',$db_opcao,"")
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
	 $chavepri= array("si169_sequencial"=>@$si169_sequencial);
	 $cliframe_alterar_excluir->chavepri=$chavepri;
	 $cliframe_alterar_excluir->sql     = $clprojecaoatuarial20->sql_query_file($si169_sequencial);
	 $cliframe_alterar_excluir->campos  ="si169_sequencial,si169_exercicio,si169_vlreceitaprevidenciaria,si169_vldespesaprevidenciaria,si169_dtcadastro,si169_instit";
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
