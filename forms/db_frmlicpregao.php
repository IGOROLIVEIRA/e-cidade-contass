<?
//MODULO: licitacao
$cllicpregao->rotulo->label();
$l45_instit = db_getsession("DB_instit");

      if($db_opcao==1){
 	   $db_action="lic1_licpregao004.php";
      }else if($db_opcao==2||$db_opcao==22){
 	   $db_action="lic1_licpregao005.php";
      }else if($db_opcao==3||$db_opcao==33){
 	   $db_action="lic1_licpregao006.php";
      }

?>
<form name="form1" method="post" action="<?=$db_action?>">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tl45_sequencial?>">
       <?=@$Ll45_sequencial?>
    </td>
    <td>
	<?
	db_input('l45_sequencial',10,$Il45_sequencial,true,'text',3,"")
	?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tl45_data?>">
       <?=@$Ll45_data?>
    </td>
    <td>
	<?
	db_inputdata('l45_data',@$l45_data_dia,@$l45_data_mes,@$l45_data_ano,true,'text',$db_opcao,"")
	?>
    </td>
  </tr>


  <tr>
    <td nowrap title="<?=@$Tl45_descrnomeacao?>">
       <?=@$Ll45_descrnomeacao?>
    </td>
    <td>
    <?
       $arr_tipo = array("1"=>"1- Portaria ","2"=>"2- Decreto");
       db_select("l45_descrnomeacao",$arr_tipo,true,$db_opcao);
    ?>
    </td>
  </tr>


  <tr>
    <td nowrap title="<?=@$Tl45_numatonomeacao?>">
       <?=@$Ll45_numatonomeacao?>
    </td>
    <td>
	<?
	db_input('l45_numatonomeacao',20,$Il45_numatonomeacao,true,'text',$db_opcao,"")
	?>
    </td>
  </tr>

  <tr>
    <td nowrap title="<?=@$Tl45_validade?>">
       <?=@$Ll45_validade?>
    </td>
    <td>
	<?
	db_inputdata('l45_validade',@$l45_validade_dia,@$l45_validade_mes,@$l45_validade_ano,true,'text',$db_opcao,"")//l45_tipo
	?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tl45_tipo?>">
       <?=@$Ll45_tipo?>
    </td>
    <td>
	<?
	$al45_tipo = array('1'=>'Permanente','2'=>'Especial');
	db_select('l45_tipo',$al45_tipo,true,$db_opcao,"");
	?>
    </td>
    <?
    db_input('l45_instit',6,$Il45_instit,true,'hidden',3,"");
    ?>
  </tr>
  </table>
  </center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo.iframe_licpregao','db_iframe_licpregao','func_licpregao.php?funcao_js=parent.js_preenchepesquisa|l45_sequencial','Pesquisa',true,'0','1');
}
function js_preenchepesquisa(chave){
  db_iframe_licpregao.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
