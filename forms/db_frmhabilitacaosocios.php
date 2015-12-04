<?
//MODULO: licitacao
include("dbforms/db_classesgenericas.php");
$cliframe_alterar_excluir = new cl_iframe_alterar_excluir;
$clhabilitacaosocios->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("z01_nome");
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
     $l207_socio = "";
     $l207_tipopart = "";
     $l207_habilitacao = "";
   }
} 

$result_cgm = $clhabilitacaosocios->sql_record($clhabilitacaosocios->sql_query_file($l207_sequencial,'z01_nome,z01_numcgm as l207_socio, l207_tipopart'));
db_fieldsmemory($result_cgm,0);

?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tl207_sequencial?>">
       <?=@$Ll207_sequencial?>
    </td>
    <td> 
<?
db_input('l207_sequencial',10,$Il207_sequencial,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tl207_socio?>">
       <?
       db_ancora(@$Ll207_socio,"js_pesquisal207_socio(true);",$db_opcao);
       ?>
    </td>
    <td> 
<?



db_input('l207_socio',10,$Il207_socio,true,'text',$db_opcao," onchange='js_pesquisal207_socio(false);'")
?>
       <?
db_input('z01_nome',40,$Iz01_nome,true,'text',3,'')
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tl207_tipopart?>">
       <?=@$Ll207_tipopart?>
    </td>
    <td> 
<?
//db_input('l207_tipopart',10,$Il207_tipopart,true,'text',$db_opcao,"")
$x = array("1"=>"Representante Legal","2"=>"Demais Membros","3"=>"MicroEmpreendedor Individual");
db_select("l207_tipopart",$x,true,$db_opcao);
?>
    </td>
  </tr>
  <tr>

    <td> 
<?
db_input('l207_habilitacao',10,$Il207_habilitacao,true,'hidden',$db_opcao,"")
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
	 $chavepri= array("l207_sequencial"=>@$l207_sequencial);
	 $cliframe_alterar_excluir->chavepri=$chavepri;
	 $cliframe_alterar_excluir->sql     = $clhabilitacaosocios->sql_query_file($l207_sequencial,'*','',"l207_habilitacao = $l207_habilitacao");
	 $cliframe_alterar_excluir->campos  ="l207_sequencial,l207_socio,z01_nome,l207_tipopart,l207_habilitacao";
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
function js_pesquisal207_socio(mostra) {
  if(mostra==true){
    js_OpenJanelaIframe('','db_iframe_cgm','func_cgm.php?funcao_js=parent.js_mostracgm1|z01_numcgm|z01_nome','Pesquisa',true,'0','1','775','390');
  }else{
     if(document.form1.l207_socio.value != ''){ 
        js_OpenJanelaIframe('','db_iframe_cgm','func_cgm.php?pesquisa_chave='+document.form1.l207_socio.value+'&funcao_js=parent.js_mostracgm','Pesquisa',false);
     }else{
       document.form1.z01_nome.value = ''; 
     }
  }
}
function js_mostracgm(chave,erro){
  document.form1.z01_nome.value = chave; 
  if(erro==true){ 
    document.form1.l207_socio.focus(); 
    document.form1.l207_socio.value = ''; 
  }
}
function js_mostracgm1(chave1,chave2){
  document.form1.l207_socio.value = chave1;
  document.form1.z01_nome.value = chave2;
  db_iframe_cgm.hide();
}
</script>
