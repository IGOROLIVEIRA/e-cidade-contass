<?
include("classes/db_pcmater_classe.php");
//MODULO: sicom
include("dbforms/db_classesgenericas.php");
$clpcmater = new cl_pcmater;
$cliframe_alterar_excluir = new cl_iframe_alterar_excluir;
$clitensaditivados->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("pc01_codmater");
$clrotulo->label("pc01_descrmater");
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
     //$si175_codaditivo = "";
     $si175_sequencial = "";
     $si175_coditem = "";
     $si175_tipoalteracaoitem = "";
     $si175_quantacrescdecresc = "";
     $si175_valorunitarioitem = "";
     $pc01_descrmater = "";
   }
} 
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tsi175_sequencial?>">
       <?=@$Lsi175_sequencial?>
    </td>
    <td> 
<?
db_input('si175_sequencial',10,$Isi175_sequencial,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi175_codaditivo?>">
       <?=@$Lsi175_codaditivo?>
    </td>
    <td> 
<?
db_input('si175_codaditivo',15,$Isi175_codaditivo,true,'text',3,"")
?>
    </td>
  </tr>

  <tr>
    <td nowrap title="<?=@$Tpc01_codmater?>" align="right">
       <?
       db_ancora(@$Lpc01_codmater,"js_pesquisa(true);",1);
       ?>
    </td>
    <td> 
<?
db_input('si175_coditem',8,$Ipc01_codmater,true,'text',1," onchange='js_pesquisa(false);'")
?>
       <?
db_input('pc01_descrmater',50,@$Ipc01_descrmater,true,'text',3,'')
       ?>
    </td>
  </tr>


  <tr>
    <td nowrap title="<?=@$Tsi175_tipoalteracaoitem?>">
       <?=@$Lsi175_tipoalteracaoitem?>
    </td>
    <td> 
<?
$x = array("1"=>"Acréscimo","2"=>"Decréscimo","3"=>"Não houve alteração de valor");
db_select('si175_tipoalteracaoitem',$x,true,$db_opcao,"");

//db_input('si175_tipoalteracaoitem',1,$Isi175_tipoalteracaoitem,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi175_quantacrescdecresc?>">
       <?=@$Lsi175_quantacrescdecresc?>
    </td>
    <td> 
<?
db_input('si175_quantacrescdecresc',14,$Isi175_quantacrescdecresc,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tsi175_valorunitarioitem?>">
       <?=@$Lsi175_valorunitarioitem?>
    </td>
    <td> 
<?
db_input('si175_valorunitarioitem',14,$Isi175_valorunitarioitem,true,'text',$db_opcao,"")
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
    $campos = "si175_sequencial,si175_codaditivo,si175_coditem,
     case si175_tipoalteracaoitem 
     when 1 then 'Acréscimo' when 2 then 'Decréscimo' 
     else 'Não houve alteração de valor' end as si175_tipoalteracaoitem
    ,si175_quantacrescdecresc,si175_valorunitarioitem";
   $chavepri= array("si175_sequencial"=>@$si175_sequencial);
   $cliframe_alterar_excluir->chavepri=$chavepri;
   $cliframe_alterar_excluir->sql     = $clitensaditivados->sql_query_file(null,$campos,null,"si175_codaditivo = $si175_codaditivo");
   $cliframe_alterar_excluir->campos  ="si175_sequencial,si175_codaditivo,si175_coditem,si175_tipoalteracaoitem,si175_quantacrescdecresc,si175_valorunitarioitem";
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
function js_pesquisa(mostra){
  if (mostra==true){
      js_OpenJanelaIframe('','db_iframe_pcmater','func_pcmater.php?funcao_js=parent.js_mostra1|pc01_codmater|pc01_descrmater','Pesquisa',true);
  }else{
    js_OpenJanelaIframe('','db_iframe_pcmater','func_pcmater.php?pesquisa_chave='+document.form1.si175_coditem.value+'&funcao_js=parent.js_mostra','Pesquisa',false);
    }
    if(document.form1.si175_coditem.value==""){
      document.form1.pc01_descrmater.value="";
    }
}
function js_mostra(nome,erro){
  document.form1.pc01_descrmater.value=nome;
  if (erro==true){
    document.form1.si175_coditem.value="";
    document.form1.si175_coditem.focus();
  } 
}
function js_mostra1(cod,nome){
  document.form1.si175_coditem.value=cod;
  document.form1.pc01_descrmater.value=nome;
  db_iframe_pcmater.hide();
}

function js_cancelar(){
  var opcao = document.createElement("input");
  opcao.setAttribute("type","hidden");
  opcao.setAttribute("name","novo");
  opcao.setAttribute("value","true");
  document.form1.appendChild(opcao);
  document.form1.submit();
}
</script>
