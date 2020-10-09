<?
//MODULO: recursoshumanos
$clrhestagiocurricular->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("rh01_numcgm");
$clrotulo->label("rh01_numcgm");
?>
<form name="form1" method="post" action="">
<center>
<fieldset>
  <legend>Cadastro de Estágio</legend>
  <table border="0">
    <tr>
      <td colspan="2"> 
      <?
      db_input('h83_sequencial',8,$Ih83_sequencial,true,'hidden',$db_opcao,"")
      ?>
      </td>
    </tr>
    <tr>
      <td nowrap title="<?=@$Th83_regist?>">
         <?
         db_ancora(@$Lh83_regist,"js_pesquisah83_regist(true);",$db_opcao);
         ?>
      </td>
      <td> 
        <?
        db_input('h83_regist',8,$Ih83_regist,true,'text',$db_opcao," onchange='js_pesquisah83_regist(false);'")
        ?>
        <?
        db_input('z01_nome',35,$Iz01_nome,true,'text',3,'')
        ?>
      </td>
    </tr>
    <tr>
      <td nowrap title="<?=@$Th83_instensino?>">
         <?=@$Lh83_instensino?>
      </td>
      <td> 
      <?
      db_input('h83_instensino',45,$Ih83_instensino,true,'text',$db_opcao,"")
      ?>
      </td>
    </tr>
    <tr>
      <td nowrap title="<?=@$Th83_cnpjinstensino?>">
         <?=@$Lh83_cnpjinstensino?>
      </td>
      <td> 
      <?
      db_input('h83_cnpjinstensino',14,$Ih83_cnpjinstensino,true,'text',$db_opcao,"")
      ?>
      </td>
    </tr>
    <tr>
      <td nowrap title="<?=@$Th83_curso?>">
         <?=@$Lh83_curso?>
      </td>
      <td> 
      <?
      db_input('h83_curso',45,$Ih83_curso,true,'text',$db_opcao,"")
      ?>
      </td>
    </tr>
    <tr>
      <td nowrap title="<?=@$Th83_matricula?>">
         <?=@$Lh83_matricula?>
      </td>
      <td> 
      <?
      db_input('h83_matricula',8,$Ih83_matricula,true,'text',$db_opcao,"")
      ?>
      </td>
    </tr>
    <tr>
      <td nowrap title="<?=@$Th83_dtinicio?>">
         <?=@$Lh83_dtinicio?>
      </td>
      <td> 
      <?
      db_inputdata('h83_dtinicio',@$h83_dtinicio_dia,@$h83_dtinicio_mes,@$h83_dtinicio_ano,true,'text',$db_opcao,"")
      ?>
      </td>
    </tr>
    <tr>
      <td nowrap title="<?=@$Th83_dtfim?>">
         <?=@$Lh83_dtfim?>
      </td>
      <td> 
      <?
      db_inputdata('h83_dtfim',@$h83_dtfim_dia,@$h83_dtfim_mes,@$h83_dtfim_ano,true,'text',$db_opcao,"")
      ?>
      </td>
    </tr>
    <tr>
      <td nowrap title="<?=@$Th83_cargahorariatotal?>">
         <?=@$Lh83_cargahorariatotal?>
      </td>
      <td> 
      <?
      db_input('h83_cargahorariatotal',8,$Ih83_cargahorariatotal,true,'text',$db_opcao,"")
      ?>
      </td>
    </tr>
    <tr>
      <td nowrap title="<?=@$Th83_supervisor?>">
         <?
         db_ancora(@$Lh83_supervisor,"js_pesquisah83_supervisor(true);",$db_opcao);
         ?>
      </td>
      <td> 
        <?
        db_input('h83_supervisor',8,$Ih83_supervisor,true,'text',$db_opcao," onchange='js_pesquisah83_supervisor(false);'")
        ?>
        <?
        db_input('z01_nome_supervisor',35,$Iz01_nome,true,'text',3,'')
        ?>
      </td>
    </tr>
  </table>
</fieldset>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</center>
</form>
<script>
function js_pesquisah83_supervisor(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('top.corpo','db_iframe_rhpessoal','func_rhpessoal.php?funcao_js=parent.js_mostrarhpessoal_supervisor1|rh01_regist|z01_nome','Pesquisa',true);
  }else{
     if(document.form1.h83_supervisor.value != ''){ 
        js_OpenJanelaIframe('top.corpo','db_iframe_rhpessoal','func_rhpessoal.php?pesquisa_chave='+document.form1.h83_supervisor.value+'&funcao_js=parent.js_mostrarhpessoal_supervisor','Pesquisa',false);
     }else{
       document.form1.z01_nome_supervisor.value = ''; 
     }
  }
}
function js_mostrarhpessoal_supervisor(chave,erro){
  document.form1.z01_nome_supervisor.value = chave; 
  if(erro==true){ 
    document.form1.h83_supervisor.focus(); 
    document.form1.h83_supervisor.value = ''; 
  }
}
function js_mostrarhpessoal_supervisor1(chave1,chave2){
  document.form1.h83_supervisor.value = chave1;
  document.form1.z01_nome_supervisor.value = chave2;
  db_iframe_rhpessoal.hide();
}
function js_pesquisah83_regist(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('top.corpo','db_iframe_rhpessoal','func_rhpessoal.php?funcao_js=parent.js_mostrarhpessoal1|rh01_regist|z01_nome','Pesquisa',true);
  }else{
     if(document.form1.h83_regist.value != ''){ 
        js_OpenJanelaIframe('top.corpo','db_iframe_rhpessoal','func_rhpessoal.php?pesquisa_chave='+document.form1.h83_regist.value+'&funcao_js=parent.js_mostrarhpessoal','Pesquisa',false);
     }else{
       document.form1.z01_nome.value = ''; 
     }
  }
}
function js_mostrarhpessoal(chave,erro){
  document.form1.z01_nome.value = chave; 
  if(erro==true){ 
    document.form1.h83_regist.focus(); 
    document.form1.h83_regist.value = ''; 
  }
}
function js_mostrarhpessoal1(chave1,chave2){
  document.form1.h83_regist.value = chave1;
  document.form1.z01_nome.value = chave2;
  db_iframe_rhpessoal.hide();
}
function js_pesquisa(){
  js_OpenJanelaIframe('top.corpo','db_iframe_rhestagiocurricular','func_rhestagiocurricular.php?funcao_js=parent.js_preenchepesquisa|h83_sequencial','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_rhestagiocurricular.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
