<?
//MODULO: licitacao
include("dbforms/db_classesgenericas.php");
$cliframe_alterar_excluir = new cl_iframe_alterar_excluir; 
$cllicpregaocgm->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("z01_nome");
if(isset($db_opcaoal)){
   $db_opcao=33;
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
     $l46_tipo = "";
     $l46_numcgm = "";
     $l46_cargo = "";
     $l46_naturezacargo = "";
      //$l46_licpregao = "";
     $z01_nome="";
     if(isset($novo)) {
     	$l46_sequencial = "";
     }
   }
}
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?//=@$Tl46_sequencial?>">
       <?//=@$Ll46_sequencial?>
    </td>
    <td> 
		<?//l46_licpregao
		db_input('l46_sequencial',10,$Il46_sequencial,true,'hidden',3,"")
		?>
    </td>
  </tr>
  
  <tr>
    <td nowrap title="<?=@$Tl46_licpregao?>">
       <b>Sequencial Pregao:</b>
    </td>
    <td> 
		<?//l46_licpregao
		db_input('l46_licpregao',10,$Il46_licpregao,true,'text',3,"")
		?>
    </td>
  </tr>
  
   <tr>
    <td nowrap title="<?=@$Tl46_tipo?>">
       <?=@$Ll46_tipo?>
    </td>
    <td> 
	<?
	$al46_tipo = array('1'=>'1-Leiloeiro','2'=>'2-Membro/Equipe de Apoio','3'=>'3-Presidente','4'=>'4-Secretário','5'=>'5-Servidor Designado','6'=>'6-Pregoeiro');
	db_select('l46_tipo',$al46_tipo,true,$db_opcao,"");
	?>
    </td>
  </tr>
  
    
      <tr>
    <td nowrap title="<?=@$Tl46_cargo?>">
       <?=@$Ll46_cargo?>
    </td>
    <td> 
	<?
	db_input('l46_cargo',54,$Il46_cargo,true,'text',$db_opcao,"")
	?>
    </td>
  </tr>
    
    
    
    
   <tr>
    <td nowrap title="<?=@$Tl46_naturezacargo?>">
       <?=@$Ll46_naturezacargo?>
    </td>
    <td> 
	<?
	$al46_naturezacargo = array('1'=>'1-Servidor Efetivo','2'=>'2-Empregado Temporário','3'=>'3-Cargo em Comissão','4'=>'4-Empregado Público','5'=>'5-Agente Político','6'=>'6-Outra');
	db_select('l46_naturezacargo',$al46_naturezacargo,true,$db_opcao,"");
	?>
    </td>
  </tr>
  

  
  <tr>
    <td nowrap title="<?=@$Tl46_numcgm?>">
       <?
       db_ancora(@$Ll46_numcgm,"js_pesquisal46_numcgm(true);",$db_opcao);
       ?>
    </td>
    <td> 
	   <?
		db_input('l46_numcgm',10,$Il46_numcgm,true,'text',$db_opcao," onchange='js_pesquisal46_numcgm(false);'")
	   ?>
       <?
		db_input('z01_nome',65,$Iz01_nome,true,'text',3,'')
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
	 $chavepri= array("l46_sequencial"=>@$l46_sequencial);
	 $cliframe_alterar_excluir->chavepri=$chavepri;//,"*",null,"si54_seqriscofiscal=".$si54_seqriscofiscal);
	 $cliframe_alterar_excluir->sql     = $cllicpregaocgm->sql_query(null,"z01_nome,l46_sequencial,case when l46_tipo = 1 then '1-Leiloeiro' when l46_tipo = 2 then '2-Membro/Equipe de Apoio' 
	 when l46_tipo = 3 then '3-Presidente' when l46_tipo = 4 then '4-Secretário' when l46_tipo = 5 then '5-Servidor Designado' 
	 when l46_tipo = 6 then '6-Pregoeiro' end as l46_tipo 
	 ,l46_cargo,case when l46_naturezacargo = 1 then '1-Servidor Efetivo' when l46_naturezacargo = 2 then '2-Empregado Temporário' 
	 when l46_naturezacargo = 3 then '3-Cargo em Comissão' when l46_naturezacargo = 4 then '4-Empregado Público' when l46_naturezacargo = 5 then '5-Agente Político'
	 when l46_naturezacargo = 6 then '6-Outra' end as l46_naturezacargo",null,"l46_licpregao=$l46_licpregao");
	 $cliframe_alterar_excluir->campos  ="z01_nome,l46_tipo ,l46_cargo,l46_naturezacargo";
	 $cliframe_alterar_excluir->legenda="ITENS LANÇADOS";
	 $cliframe_alterar_excluir->iframe_height ="160";
	 $cliframe_alterar_excluir->iframe_width ="700";
	 $cliframe_alterar_excluir->iframe_alterar_excluir(1);
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
function js_pesquisal46_numcgm(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('top.corpo.iframe_licpregaocgm','db_iframe_cgm','func_cgm.php?funcao_js=parent.js_mostracgm1|z01_numcgm|z01_nome','Pesquisa',true,'0','1');
  }else{
     if(document.form1.l46_numcgm.value != ''){ 
        js_OpenJanelaIframe('top.corpo.iframe_licpregaocgm','db_iframe_cgm','func_cgm.php?pesquisa_chave='+document.form1.l46_numcgm.value+'&funcao_js=parent.js_mostracgm','Pesquisa',false);
     }else{
       document.form1.z01_nome.value = ''; 
     }
  }
}
function js_mostracgm(erro,chave){
  document.form1.z01_nome.value = chave; 
  if(erro==true){ 
    document.form1.l46_numcgm.focus(); 
    document.form1.l46_numcgm.value = ''; 
  }
}
function js_mostracgm1(chave1,chave2){
  document.form1.l46_numcgm.value = chave1;
  document.form1.z01_nome.value = chave2;
  db_iframe_cgm.hide();
}
</script>
