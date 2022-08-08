<?
//MODULO: educação
$clatestvaga->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("ed18_i_codigo");
$clrotulo->label("ed31_i_codigo");
$clrotulo->label("ed52_i_codigo");
$clrotulo->label("ed11_i_codigo");
$clrotulo->label("ed15_i_codigo");
$clrotulo->label("ed47_i_codigo");
$clrotulo->label("nome");
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
 <tr>
  <td nowrap title="<?=@$Ted102_i_codigo?>">
   <?=@$Led102_i_codigo?>
  </td>
  <td>
   <?db_input('ed102_i_codigo',15,$Ied102_i_codigo,true,'text',3,"")?>
  </td>
 </tr>
 <tr>
  <td colspan="2">
   <fieldset style="width:93%"><legend><b>Situação Atual</b></legend>
   <table>
    <tr>
     <td nowrap title="<?=@$Ted102_i_aluno?>">
      <?db_ancora(@$Led102_i_aluno,"js_pesquisaed102_i_aluno(true);",$db_opcao);?>
     </td>
     <td>
      <?db_input('ed102_i_aluno',15,$Ied102_i_aluno,true,'text',3,"")?>
      <?db_input('ed47_v_nome',40,@$Ied47_v_nome,true,'text',3,"")?>
     </td>
    </tr>
    <tr>
     <td>
      <b>Escola Atual:</b>
     </td>
     <td>
      <?db_input('codigoescola',15,@$codigoescola,true,'text',3,'')?>
      <?db_input('nomeescola',40,@$nomeescola,true,'text',3,'')?>
     </td>
    </tr>
    <tr>
     <td>
      <b>Curso:</b>
     </td>
     <td>
      <?db_input('codigocurso',15,@$codigocurso,true,'text',3,'')?>
      <?db_input('nomecurso',40,@$nomecurso,true,'text',3,'')?>
     </td>
    </tr>
    <tr>
     <td>
      <b>Situação:</b>
     </td>
     <td>
      <?db_input('situacao',50,@$situacao,true,'text',3,'')?>
     </td>
    </tr>
    <tr>
     <td>
      <b>Série:</b>
     </td>
     <td>
      <?db_input('codigoserie',15,@$codigoserie,true,'text',3,'')?>
      <?db_input('nomeserie',40,@$nomeserie,true,'text',3,'')?>
     </td>
    </tr>
    <tr>
     <td>
      <b>Ano:</b>
     </td>
     <td>
      <?db_input('anocal',15,@$anocal,true,'text',3,'')?>
     </td>
    </tr>
   </table>
   </fieldset>
  </td>
 </tr>
 <tr>
  <td nowrap title="<?=@$Ted102_i_escola?>">
   <?db_ancora(@$Led102_i_escola,"",3);?>
  </td>
  <td>
   <?db_input('ed102_i_escola',15,$Ied102_i_escola,true,'text',3,"")?>
   <?db_input('ed18_c_nome',50,@$Ied18_c_nome,true,'text',3,'')?>
  </td>
 </tr>
 <tr>
  <td nowrap title="<?=@$Ted102_i_base?>">
   <?db_ancora(@$Led102_i_base,"js_pesquisaed102_i_base(true);",$db_opcao);?>
  </td>
  <td>
   <?db_input('ed102_i_base',15,$Ied102_i_base,true,'text',$db_opcao," onchange='js_pesquisaed102_i_base(false);'")?>
   <?db_input('ed31_c_descr',50,@$Ied31_c_descr,true,'text',3,'')?>
  </td>
 </tr>
 <tr>
  <td nowrap title="Curso">
   <b>Curso:</b>
  </td>
  <?
  if($db_opcao==3){
   ?>
   <td>
    <?db_input('ed29_i_codigo',15,@$Ied29_i_codigo,true,'text',3,'')?>
    <?db_input('ed29_c_descr',50,@$Ied29_c_descr,true,'text',3,'')?>
   </td>
   <?
  }else{
   ?>
   <td>
    <?db_input('codcursodest',15,@$Icodcursodest,true,'text',3,'')?>
    <?db_input('nomecursodest',50,@$Inomecursodest,true,'text',3,'')?>
   </td>
   <?
  }
  ?>
 </tr>
 <tr>
  <td nowrap title="<?=@$Ted34_i_serie?>">
   <?db_ancora("<b>Serie</b>","js_pesquisaed34_i_serie(true);",$db_opcao);?>
  </td>
  <td>
  <?db_input('ed102_i_serie',15,@$Ied102_i_serie,true,'text',3," onchange='js_pesquisaed102_i_serie(false);'")?>
   <?db_input('ed11_c_descr',50,@$Ied11_c_descr,true,'text',3,'')?>
  </td>
 </tr>
 <tr>
  <td nowrap title="<?=@$Ted102_i_turno?>">
   <?db_ancora(@$Led102_i_turno,"js_pesquisaed102_i_turno(true);",$db_opcao);?>
  </td>
  <td>
   <?db_input('ed102_i_turno',15,$Ied102_i_turno,true,'text',$db_opcao," onchange='js_pesquisaed102_i_turno(false);'")?>
   <?db_input('ed15_c_nome',50,@$Ied15_c_nome,true,'text',3,'')?>
  </td>
 </tr>
 <tr>
  <td nowrap title="<?=@$Ted102_i_calendario?>">
   <?db_ancora(@$Led102_i_calendario,"js_pesquisaed102_i_calendario(true);",$db_opcao);?>
  </td>
  <td>
   <?db_input('ed102_i_calendario',15,$Ied102_i_calendario,true,'text',$db_opcao," onchange='js_pesquisaed102_i_calendario(false);'")?>
   <?db_input('ed52_c_descr',50,@$Ied52_c_descr,true,'text',3,'')?>
  </td>
 </tr>
 <tr>
  <td nowrap title="<?=@$Ted102_d_data?>">
   <?=@$Led102_d_data?>
  </td>
  <td>
   <?db_inputdata('ed102_d_data',@$ed102_d_data_dia,@$ed102_d_data_mes,@$ed102_d_data_ano,true,'text',3,"")?>
  </td>
 </tr>
 <tr>
  <td nowrap title="<?=@$Ted102_t_obs?>">
   <?=@$Led102_t_obs?>
  </td>
  <td>
   <?db_textarea('ed102_t_obs',4,54,$Ied102_t_obs,true,'text',$db_opcao,"")?>
  </td>
 </tr>
</table>
</center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> onclick="document.form1.db_opcao.style.visibility='hidden'" <?=isset($incluir)||isset($excluir)?"style='visibility:hidden;'":""?>>
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
function js_pesquisaed34_i_serie(mostra){
 if(document.form1.ed102_i_base.value==""){
  alert("Informe a base!");
 }else{
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_serieatest','func_serieatest.php?curso1='+document.form1.codigocurso.value+'&curso2='+document.form1.codcursodest.value+'&serie='+document.form1.codigoserie.value+'&base='+document.form1.ed102_i_base.value+'&funcao_js=parent.js_mostraserie1|ed34_i_serie|ed11_c_descr','Pesquisa de Serie',true);
 }
}
function js_mostraserie1(chave1,chave2){
 document.form1.ed102_i_serie.value = chave1;
 document.form1.ed11_c_descr.value = chave2;
 db_iframe_serieatest.hide();
}
function js_pesquisaed102_i_base(mostra){
 if(document.form1.ed102_i_aluno.value==""){
  alert("Informe o aluno!");
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_aluno','func_alunoatest.php?funcao_js=parent.js_mostraaluno1|ed47_i_codigo|ed47_v_nome|dl_codigoescola|dl_escola|dl_codigocurso|dl_curso|dl_codigoserie|dl_serie|ed56_c_situacao','Pesquisa de Alunos',true);
 }else{
  if(mostra==true){
   js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_base','func_baseatest.php?serie='+document.form1.codigoserie.value+'&curso='+document.form1.codigocurso.value+'&funcao_js=parent.js_mostrabase1|ed31_i_codigo|ed31_c_descr|ed29_i_codigo|dl_curso','Pesquisa de Bases Curriculares',true);
  }else{
   if(document.form1.ed102_i_base.value != ''){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_base','func_baseatest.php?serie='+document.form1.codigoserie.value+'&curso='+document.form1.codigocurso.value+'&pesquisa_chave='+document.form1.ed102_i_base.value+'&funcao_js=parent.js_mostrabase','Pesquisa',false);
   }else{
    document.form1.ed31_c_descr.value = '';
   }
  }
 }
}
function js_mostrabase(chave1,chave2,chave3,erro){
 document.form1.ed31_c_descr.value = chave1;
 document.form1.codcursodest.value = chave2;
 document.form1.nomecursodest.value = chave3;
 if(erro==true){
  document.form1.ed102_i_base.focus();
  document.form1.ed102_i_base.value = '';
  document.form1.ed102_i_serie.value = '';
  document.form1.ed11_c_descr.value = '';
  document.form1.codcursodest.value = '';
  document.form1.nomecursodest.value = '';
 }
}
function js_mostrabase1(chave1,chave2,chave3,chave4){
 document.form1.ed102_i_base.value = chave1;
 document.form1.ed31_c_descr.value = chave2;
 document.form1.codcursodest.value = chave3;
 document.form1.nomecursodest.value = chave4;
 document.form1.ed102_i_serie.value = '';
 document.form1.ed11_c_descr.value = '';
 db_iframe_base.hide();
}
function js_pesquisaed102_i_calendario(mostra){
 if(document.form1.ed102_i_aluno.value==""){
  alert("Informe o aluno!");
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_aluno','func_alunoatest.php?funcao_js=parent.js_mostraaluno1|ed47_i_codigo|ed47_v_nome|dl_codigoescola|dl_escola|dl_codigocurso|dl_curso|dl_codigoserie|dl_serie|ed56_c_situacao','Pesquisa de Alunos',true);
 }else{
  if(mostra==true){
   js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_calendario','func_calendarioatest.php?anocal='+document.form1.ed102_i_aluno.value+'&funcao_js=parent.js_mostracalendario1|ed52_i_codigo|ed52_c_descr|ed52_i_ano','Pesquisa de Calendários',true);
  }else{
   if(document.form1.ed102_i_calendario.value != ''){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_calendario','func_calendarioatest.php?anocal='+document.form1.ed102_i_aluno.value+'&pesquisa_chave='+document.form1.ed102_i_calendario.value+'&funcao_js=parent.js_mostracalendario','Pesquisa',false);
   }else{
    document.form1.ed52_c_descr.value = '';
   }
  }
 }
}
function js_mostracalendario(chave,chave1,erro){
 document.form1.ed52_c_descr.value = chave;
 if(erro==true){
  document.form1.ed102_i_calendario.focus();
  document.form1.ed102_i_calendario.value = '';
 }else{
  situacaoaluno =  document.form1.situacao.value.replace(/^\s+|\s+$/g, '');
  if(Number(document.form1.anocal.value)!=Number(chave1) && situacaoaluno!="APROVADO" && situacaoaluno!="REPETENTE" && situacaoaluno!="EVADIDO" && situacaoaluno!="CANCELADO"){
   alert("Aluno selecionado no atestado pertence a um calendário com ano diferente ("+document.form1.anocal.value+") do calendário selecionado ("+chave1+")!");
   document.form1.ed52_c_descr.value = '';
   document.form1.ed102_i_calendario.value = '';
   document.form1.ed102_i_calendario.focus();
  }
 }
}
function js_mostracalendario1(chave1,chave2,chave3){
 situacaoaluno =  document.form1.situacao.value.replace(/^\s+|\s+$/g,'');
 if(Number(document.form1.anocal.value)!=Number(chave3) && situacaoaluno!="APROVADO" && situacaoaluno!="REPETENTE" && situacaoaluno!="EVADIDO" && situacaoaluno!="CANCELADO"){
  alert("Aluno selecionado no atestado pertence a um calendário com ano diferente ("+document.form1.anocal.value+") do calendário selecionado ("+chave3+")!");
  document.form1.ed52_c_descr.value = '';
  document.form1.ed102_i_calendario.value = '';
  document.form1.ed102_i_calendario.focus();
 }else{
  document.form1.ed102_i_calendario.value = chave1;
  document.form1.ed52_c_descr.value = chave2;
  db_iframe_calendario.hide();
 }
}
function js_pesquisaed102_i_turno(mostra){
 if(document.form1.ed102_i_aluno.value==""){
  alert("Informe o aluno!");
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_aluno','func_alunoatest.php?funcao_js=parent.js_mostraaluno1|ed47_i_codigo|ed47_v_nome|dl_codigoescola|dl_escola|dl_codigocurso|dl_curso|dl_codigoserie|dl_serie|ed56_c_situacao','Pesquisa de Alunos',true);
 }else if(document.form1.ed102_i_base.value==""){
  alert("Informe a base curricular!");
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_base','func_baseatest.php?serie='+document.form1.codigoserie.value+'&curso='+document.form1.codigocurso.value+'&funcao_js=parent.js_mostrabase1|ed31_i_codigo|ed31_c_descr|ed29_i_codigo|dl_curso','Pesquisa de Bases Curriculares',true);
 }else{
  if(mostra==true){
   js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_turno','func_turnoturma.php?curso='+document.form1.codcursodest.value+'&funcao_js=parent.js_mostraturno1|ed15_i_codigo|ed15_c_nome','Pesquisa de Turnos',true);
  }else{
   if(document.form1.ed102_i_turno.value != ''){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_turno','func_turnoturma.php?curso='+document.form1.codigocurso.value+'&pesquisa_chave='+document.form1.ed102_i_turno.value+'&funcao_js=parent.js_mostraturno','Pesquisa',false);
   }else{
    document.form1.ed15_c_nome.value = '';
   }
  }
 }
}
function js_mostraturno(chave,erro){
 document.form1.ed15_c_nome.value = chave;
 if(erro==true){
  document.form1.ed102_i_turno.focus();
  document.form1.ed102_i_turno.value = '';
 }
}
function js_mostraturno1(chave1,chave2){
 document.form1.ed102_i_turno.value = chave1;
 document.form1.ed15_c_nome.value = chave2;
 db_iframe_turno.hide();
}
function js_pesquisaed102_i_aluno(mostra){
 if(mostra==true){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_aluno','func_alunoatest.php?funcao_js=parent.js_mostraaluno1|ed47_i_codigo|ed47_v_nome|dl_codigoescola|dl_escola|dl_codigocurso|dl_curso|dl_codigoserie|dl_serie|ed56_c_situacao|ed52_i_ano','Pesquisa de Alunos',true);
 }
}
function js_mostraaluno1(chave1,chave2,chave3,chave4,chave5,chave6,chave7,chave8,chave9,chave10){
 document.form1.ed102_i_aluno.value = chave1;
 document.form1.ed47_v_nome.value = chave2;
 document.form1.codigoescola.value = chave3;
 document.form1.nomeescola.value = chave4;
 document.form1.codigocurso.value = chave5;
 document.form1.nomecurso.value = chave6;
 document.form1.codigoserie.value = chave7;
 document.form1.nomeserie.value = chave8;
 document.form1.situacao.value = chave9;
 document.form1.anocal.value = chave10;
 document.form1.ed102_i_base.value = "";
 document.form1.ed31_c_descr.value = "";
 document.form1.ed102_i_serie.value = "";
 document.form1.ed11_c_descr.value = "";
 document.form1.ed102_i_turno.value = "";
 document.form1.ed15_c_nome.value = "";
 document.form1.ed102_i_calendario.value = "";
 document.form1.ed52_c_descr.value = "";
 db_iframe_aluno.hide();
}
function js_pesquisa(){
 js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_atestvaga','func_atestvaga.php?funcao_js=parent.js_preenchepesquisa|ed102_i_codigo','Pesquisa',true);
}
function js_preenchepesquisa(chave){
 db_iframe_atestvaga.hide();
 <?
 if($db_opcao!=1){
   echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
 }
 ?>
}
</script>
