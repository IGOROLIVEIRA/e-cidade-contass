<?
//MODULO: sicom
include("dbforms/db_classesgenericas.php");
$cliframe_alterar_excluir = new cl_iframe_alterar_excluir;
$clempcontratos->rotulo->label();
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
     $si173_sequencial = "";
     //$si173_codcontrato = "";
     $si173_empenho = "";
     $si173_anoempenho = "";
   }
} 
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tsi173_sequencial?>">
       <?=@$Lsi173_sequencial?>
    </td>
    <td> 
<?
db_input('si173_sequencial',10,$Isi173_sequencial,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi173_codcontrato?>">
       <?=@$Lsi173_codcontrato?>
    </td>
    <td> 
<?
db_input('si173_codcontrato',15,$Isi173_codcontrato,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi173_empenho?>">
       <?=@$Lsi173_empenho?>
    </td>
    <td> 
<?
db_input('si173_empenho',15,$Isi173_empenho,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi173_anoempenho?>">
       <?=@$Lsi173_anoempenho?>
    </td>
    <td> 
<?
$si173_anoempenho = db_getsession("DB_anousu");
db_input('si173_anoempenho',4,$Isi173_anoempenho,true,'text',3,"")
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
	 $chavepri= array("si173_sequencial"=>@$si173_sequencial);
	 $cliframe_alterar_excluir->chavepri=$chavepri;
	 $cliframe_alterar_excluir->sql     = $clempcontratos->sql_query_file(null,'*',null,"si173_codcontrato = $si173_codcontrato");
	 $cliframe_alterar_excluir->campos  ="si173_sequencial,si173_codcontrato,si173_empenho,si173_anoempenho";
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
