<?
//MODULO: orcamento
include("dbforms/db_classesgenericas.php");
$cliframe_alterar_excluir = new cl_iframe_alterar_excluir;
$clorcalteracaopercloa->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("o138_numerolei");
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
    if(isset($novo) || isset($alterar) ||   isset($excluir) || (isset($incluir) && $sqlerro==false ) ){
     $o201_sequencial = "";
    	//$o201_orcprojetolei = "";
     $o201_tipoleialteracao = "";
     $o201_artleialteracao  = "";
     $o201_descrartigo      = "";
     $o201_percautorizado    = "";
   }
}
?>
<form name="form1" method="post" action="">
<center>
<fieldset>
<table border="0">
  <tr>
    <td nowrap title="<?=@$To201_sequencial?>">
       <?=@$Lo201_sequencial?>
    </td>
    <td>
<?
db_input('o201_sequencial',11,$Io201_sequencial,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$To201_orcprojetolei?>">
       <?=@$Lo201_orcprojetolei?>
    </td>
    <td>
<?
db_input('o201_orcprojetolei',11,$Io201_orcprojetolei,true,'text',3)
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$To201_tipoleialteracao?>">
       <?=@$Lo201_tipoleialteracao?>
    </td>
    <td>
<?
$x = array("1"=>"Abertura de créditos suplementares","2"=>"Contratação de operações de crédito","3"=>"Contratação de operações de crédito por antecipação de receita");
//db_input('o201_tipoleialteracao',11,$Io201_tipoleialteracao,true,'text',$db_opcao,"")
db_select('o201_tipoleialteracao', $x, true,$db_opcao);
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$To201_artleialteracao?>">
       <?=@$Lo201_artleialteracao?>
    </td>
    <td>
<?
db_input('o201_artleialteracao',6,$Io201_artleialteracao,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$To201_descrartigo?>">
       <?=@$Lo201_descrartigo?>
    </td>
    <td>
<?
db_textarea('o201_descrartigo',7,60,$Io201_descrartigo,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$To201_percautorizado?>">
       <?=@$Lo201_percautorizado?>
    </td>
    <td>
<?
db_input('o201_percautorizado',14,$Io201_percautorizado,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  </table>

  <table>
  <tr>
    <td valign="top"  align="center">
    <?
	 $chavepri= array("o201_sequencial"=>@$o201_sequencial);
	 $cliframe_alterar_excluir->chavepri=$chavepri;
	 $cliframe_alterar_excluir->sql     = $clorcalteracaopercloa->sql_query_file(null,"*",null,"o201_orcprojetolei=$o201_orcprojetolei");
	 $cliframe_alterar_excluir->campos  ="o201_sequencial,o201_orcprojetolei,o201_tipoleialteracao,o201_artleialteracao,o201_descrartigo,o201_percautorizado";
	 $cliframe_alterar_excluir->legenda="";
	 $cliframe_alterar_excluir->iframe_height ="160";
	 $cliframe_alterar_excluir->iframe_width ="700";
	 $cliframe_alterar_excluir->iframe_alterar_excluir(1);
    ?>
    </td>
   </tr>
 </table>
  </fieldset>
  </center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >

</form>
<script>
function js_pesquisao201_orcprojetolei(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orcprojetolei','func_orcprojetolei.php?funcao_js=parent.js_mostraorcprojetolei1|o138_sequencial|o138_numerolei','Pesquisa',true);
  }else{
     if(document.form1.o201_orcprojetolei.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orcprojetolei','func_orcprojetolei.php?pesquisa_chave='+document.form1.o201_orcprojetolei.value+'&funcao_js=parent.js_mostraorcprojetolei','Pesquisa',false);
     }else{
       document.form1.o138_numerolei.value = '';
     }
  }
}
function js_mostraorcprojetolei(chave,erro){
  document.form1.o138_numerolei.value = chave;
  if(erro==true){
    document.form1.o201_orcprojetolei.focus();
    document.form1.o201_orcprojetolei.value = '';
  }
}
function js_mostraorcprojetolei1(chave1,chave2){
  document.form1.o201_orcprojetolei.value = chave1;
  document.form1.o138_numerolei.value = chave2;
  db_iframe_orcprojetolei.hide();
}
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orcalteracaopercloa','func_orcalteracaopercloa.php?funcao_js=parent.js_preenchepesquisa|o201_sequencial','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_orcalteracaopercloa.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
