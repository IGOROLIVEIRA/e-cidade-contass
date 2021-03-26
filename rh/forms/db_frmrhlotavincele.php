<?
//MODULO: pessoal
include("dbforms/db_classesgenericas.php");
$cliframe_alterar_excluir = new cl_iframe_alterar_excluir;
$clrhlotavinc->rotulo->label();
$clrhlotavincativ->rotulo->label();
$clrhlotavincele->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("o55_descr");
$clrotulo->label("o56_descr");
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Trh25_codlotavinc?>">
       <?
       db_ancora(@$Lrh25_codlotavinc,"",3);
       ?>
    </td>
    <td>
<?
db_input('rh25_codlotavinc',8,$Irh25_codlotavinc,true,'text',3)
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Trh25_codigo?>">
       <?
       db_ancora(@$Lrh25_codigo,"",3);
       ?>
    </td>
    <td>
<?
db_input('rh25_codigo',8,$Irh25_codigo,true,'text',3)
?>
<?
db_input('rh25_descr',50,$Irh25_descr,true,'text',3);
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Trh39_projativ?>">
       <?
       db_ancora(@$Lrh39_projativ,"js_pesquisarh39_projativ(true)",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('rh39_projativ',8,$Irh39_projativ,true,'text',$db_opcao,"onchange='js_pesquisarh39_projativ(false)'");
db_input('rh39_anousu',4,$Irh39_anousu,true,'text',3);
db_input('o55_descr',44,$Io55_descr,true,'text',3);
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Trh28_codeledef?>">
       <?
       db_ancora(@$Lrh28_codeledef,"js_pesquisarh28_codeledef(true)",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('rh28_codeledef',8,$Irh28_codeledef,true,'text',$db_opcao,"onchange='js_pesquisarh28_codeledef(false)'");
db_input('o56_descr',50,$Io56_descr,true,'text',3);
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Trh28_codelenov?>">
       <?
       db_ancora(@$Lrh28_codelenov,"js_pesquisarh28_codelenov(true)",$db_opcao);
       ?>
    </td>
    <td>
<?
db_input('rh28_codelenov',8,$Irh28_codelenov,true,'text',$db_opcao,"onchange='js_pesquisarh28_codelenov(false)'");
db_input('o56_descr',50,$Io56_descr,true,'text',3,"","o56_descrnov");
?>
    </td>
  </tr>
  <tr>
    <td colspan="2" align="center">
      <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?>>
      <?
      if($db_opcao!=1){
	echo '<input name="novo" type="button" id="cancelar" value="Novo" onclick="js_cancelar();" >&nbsp;';
      }
      ?>
    </td>
  </tr>
  </table>
 <table>
  <tr>
    <td valign="top"  align="center">
    <?
         $where = "";
	 if(isset($rh25_codlotavinc) && trim($rh25_codlotavinc)!=""){
	   $where .= " rh28_codlotavinc = $rh25_codlotavinc ";
	 }else if(isset($rh25_codlotavinc) && trim($rh25_codlotavinc)!=""){
	   $where .= " rh28_codlotavinc = $rh28_codlotavinc ";
	 }

	 if(isset($default) && trim($default)!=""){
	   $where .= " and rh28_codeledef <> $default ";
	 }
	 $chavepri= array("rh28_codlotavinc"=>@$rh28_codlotavinc,"rh28_codeledef"=>$rh28_codeledef);
	 $cliframe_alterar_excluir->chavepri=$chavepri;
	 $cliframe_alterar_excluir->sql = $clrhlotavincele->sql_query_ele(null,null,"rh28_codeledef,orcelemento.o56_descr,rh28_codelenov,a.o56_descr,o55_projativ,o55_descr,o55_anousu","rh28_codlotavinc,rh28_codeledef",$where);
	 //echo $clrhlotavincele->sql_query_ele(null,null,"rh28_codeledef,orcelemento.o56_descr,rh28_codelenov,a.o56_descr,o55_projativ,o55_descr,o55_anousu","rh28_codlotavinc,rh28_codeledef",$where);
	 $cliframe_alterar_excluir->campos  = "rh28_codeledef,o56_descr,rh28_codelenov,o56_descr,o55_projativ,o55_descr,o55_anousu";
	 $cliframe_alterar_excluir->legenda = "ITENS LANÇADOS";
	 $cliframe_alterar_excluir->iframe_height = "160";
	 $cliframe_alterar_excluir->iframe_width  = "700";
	 $cliframe_alterar_excluir->opcoes  = $opcoesae;
	 $cliframe_alterar_excluir->iframe_alterar_excluir(1);
    ?>
    </td>
   </tr>
 </table>
  </center>
</form>
<script>
function js_pesquisarh39_projativ(mostra){
  if(document.form1.rh28_codeledef.value==""){
    parent.document.form1.chave2.value = '';
    parent.document.form1.chave3.value = '';
  }
  if(document.form1.rh28_codelenov.value==""){
    parent.document.form1.chave4.value = '';
    parent.document.form1.chave5.value = '';
  }
  <?
  if($opcao=="alterar"){
    echo "CurrentWindow.corpo.iframe_rhlotavinc.document.form1.chave.value  = document.form1.rh39_anousu.value;";
    echo "CurrentWindow.corpo.iframe_rhlotavinc.document.form1.chave1.value = document.form1.rh39_projativ.value;";
    echo "CurrentWindow.corpo.iframe_rhlotavinc.document.form1.chave2.value = document.form1.rh28_codeledef.value;";
    echo "CurrentWindow.corpo.iframe_rhlotavinc.document.form1.chave3.value = document.form1.o56_descr.value;";
    echo "CurrentWindow.corpo.iframe_rhlotavinc.document.form1.chave4.value = document.form1.rh28_codelenov.value;";
    echo "CurrentWindow.corpo.iframe_rhlotavinc.document.form1.chave5.value = document.form1.o56_descrnov.value;";
  }
  ?>
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo.iframe_rhlotavinc','db_iframe_orcprojativ','func_orcprojativ.php?funcao_js=parent.js_mostraprojativ2|o55_anousu|o55_projativ&anousu=<?=(db_getsession("DB_anousu"))?>','Pesquisa',true,'0','1','775','390');
  }else{
    if(document.form1.rh39_projativ.value!=""){
      js_OpenJanelaIframe('CurrentWindow.corpo.iframe_rhlotavinc','db_iframe_orcprojativ','func_orcprojativ.php?pesquisa_chave='+document.form1.rh39_projativ.value+'&funcao_js=parent.js_mostraprojativ2&mostraprojativ=true','Pesquisa',false,'0','1','775','390');
    }else{
      document.form1.o55_descr.value = "";
      document.form1.rh39_anousu.value = "";
      document.form1.rh39_projativ.focus();
      parent.document.form1.chave.value = '';
      parent.document.form1.chave1.value = '';
    }
  }
}
function js_pesquisarh28_codeledef(mostra){
  if(document.form1.rh39_projativ.value==""){
    parent.document.form1.chave.value = '';
    parent.document.form1.chave1.value = '';
  }
  if(document.form1.rh28_codelenov.value==""){
    parent.document.form1.chave4.value = '';
    parent.document.form1.chave5.value = '';
  }
  <?
  if($opcao=="alterar"){
    echo "CurrentWindow.corpo.iframe_rhlotavinc.document.form1.chave.value  = document.form1.rh39_anousu.value;";
    echo "CurrentWindow.corpo.iframe_rhlotavinc.document.form1.chave1.value = document.form1.rh39_projativ.value;";
    echo "CurrentWindow.corpo.iframe_rhlotavinc.document.form1.chave2.value = document.form1.rh28_codeledef.value;";
    echo "CurrentWindow.corpo.iframe_rhlotavinc.document.form1.chave3.value = document.form1.o56_descr.value;";
    echo "CurrentWindow.corpo.iframe_rhlotavinc.document.form1.chave4.value = document.form1.rh28_codelenov.value;";
    echo "CurrentWindow.corpo.iframe_rhlotavinc.document.form1.chave5.value = document.form1.o56_descrnov.value;";
  }
  ?>
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo.iframe_rhlotavinc','db_iframe_orcelemento','func_orcelementodef.php?funcao_js=parent.js_mostraorcelemento|o56_codele|o56_descr','Pesquisa',true,'0','1','775','390');
  }else{
    if(document.form1.rh28_codeledef.value != ''){
       js_OpenJanelaIframe('CurrentWindow.corpo.iframe_rhlotavinc','db_iframe_orcelemento','func_orcelementodef.php?pesquisa_chave='+document.form1.rh28_codeledef.value+'&funcao_js=parent.js_mostraorcelemento&mostradescr=true','Pesquisa',false,'0','1','775','390');
    }else{
      document.form1.rh28_codeledef.value = '';
      document.form1.o56_descr.value = '';
      parent.document.form1.chave2.value = '';
      parent.document.form1.chave3.value = '';
    }
  }
}
function js_pesquisarh28_codelenov(mostra){
  if(document.form1.rh39_projativ.value==""){
    parent.document.form1.chave.value = '';
    parent.document.form1.chave1.value = '';
  }
  if(document.form1.rh28_codeledef.value==""){
    parent.document.form1.chave2.value = '';
    parent.document.form1.chave3.value = '';
  }
  <?
  if($opcao=="alterar"){
    echo "CurrentWindow.corpo.iframe_rhlotavinc.document.form1.chave.value  = document.form1.rh39_anousu.value;";
    echo "CurrentWindow.corpo.iframe_rhlotavinc.document.form1.chave1.value = document.form1.rh39_projativ.value;";
    echo "CurrentWindow.corpo.iframe_rhlotavinc.document.form1.chave2.value = document.form1.rh28_codeledef.value;";
    echo "CurrentWindow.corpo.iframe_rhlotavinc.document.form1.chave3.value = document.form1.o56_descr.value;";
    echo "CurrentWindow.corpo.iframe_rhlotavinc.document.form1.chave4.value = document.form1.rh28_codelenov.value;";
    echo "CurrentWindow.corpo.iframe_rhlotavinc.document.form1.chave5.value = document.form1.o56_descrnov.value;";
  }
  ?>
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo.iframe_rhlotavinc','db_iframe_orcelemento','func_orcelementonov.php?funcao_js=parent.js_mostraorcelemento1|o56_codele|o56_descr','Pesquisa',true,'0','1','775','390');
  }else{
    if(document.form1.rh28_codelenov.value != ''){
       js_OpenJanelaIframe('CurrentWindow.corpo.iframe_rhlotavinc','db_iframe_orcelemento','func_orcelementonov.php?pesquisa_chave='+document.form1.rh28_codelenov.value+'&funcao_js=parent.js_mostraorcelemento1&mostradescr=true','Pesquisa',true,'0','1','775','390');
    }else{
      document.form1.rh28_codelenov.value = '';
      document.form1.o56_descrnov.value = '';
      parent.document.form1.chave4.value = '';
      parent.document.form1.chave5.value = '';
    }
  }
}
function js_cancelar(){
  document.location.href = "pes1_rhlotavincele001.php?lotacao="+document.form1.rh25_codigo.value+"&lotavinc="+document.form1.rh25_codlotavinc.value;
  /*
  var opcao = document.createElement("input");
  opcao.setAttribute("type","hidden");
  opcao.setAttribute("name","incluirnovo");
  opcao.setAttribute("value","true");
  document.form1.appendChild(opcao);
  document.form1.submit();
  */
}
</script>
