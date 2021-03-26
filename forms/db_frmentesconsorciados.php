<?
//MODULO: contabilidade
$clentesconsorciados->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("z01_nome");
?>

<form name="form1" method="post" action="">
<?
db_input('c215_sequencial',11,$Ic215_sequencial,true,'hidden',$db_opcao,"")
?>
<center>
  <fieldset>
    <legend>Entes Consorciados</legend>

    <table border="0">
      <tr>
        <td nowrap title="<?=@$Tc215_cgm?>">
           <?
           db_ancora(@$Lc215_cgm,"js_pesquisac215_cgm(true);",$db_opcao);
           ?>
        </td>
        <td>
    <?
    db_input('c215_cgm',11,$Ic215_cgm,true,'text',$db_opcao," onchange='js_pesquisac215_cgm(false);'")
    ?>
           <?
    db_input('z01_nome',40,$Iz01_nome,true,'text',3,'')
           ?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?=@$Tc215_datainicioparticipacao?>">
           <?=@$Lc215_datainicioparticipacao?>
        </td>
        <td>
    <?
    db_inputdata('c215_datainicioparticipacao',@$c215_datainicioparticipacao_dia,@$c215_datainicioparticipacao_mes,@$c215_datainicioparticipacao_ano,true,'text',$db_opcao,"")
    ?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?=@$Tc215_datafimparticipacao?>">
           <?=@$Lc215_datafimparticipacao?>
        </td>
        <td>
    <?
    db_inputdata('c215_datafimparticipacao',@$c215_datafimparticipacao_dia,@$c215_datafimparticipacao_mes,@$c215_datafimparticipacao_ano,true,'text',$db_opcao,"")
    ?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?=@$Tc215_percentualrateio?>">
          <?=@$Lc215_percentualrateio?>
        </td>
        <td>
          <?php
            db_input('c215_percentualrateio',11,$Ic215_percentualrateio,true,'text',$db_opcao,"")
          ?> %
        </td>
      </tr>
    </table>

    <br>

    <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
    <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="pesquisarEnteConsorciado();" >
  </fieldset>
</center>
</form>
<script>
function js_pesquisac215_cgm(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_cgm','func_cgm.php?funcao_js=parent.js_mostracgm1|z01_numcgm|z01_nome','Pesquisa',true);
  }else{
     if(document.form1.c215_cgm.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_cgm','func_cgm.php?pesquisa_chave='+document.form1.c215_cgm.value+'&funcao_js=parent.js_mostracgm','Pesquisa',false);
     }else{
       document.form1.z01_nome.value = '';
     }
  }
}
function js_mostracgm(chave,erro){
  document.form1.z01_nome.value = chave;
  if(erro==true){
    document.form1.c215_cgm.focus();
    document.form1.c215_cgm.value = '';
  }
}
function js_mostracgm1(chave1,chave2){
  document.form1.c215_cgm.value = chave1;
  document.form1.z01_nome.value = chave2;
  db_iframe_cgm.hide();
}
function pesquisarEnteConsorciado(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_entesconsorciados','func_entesconsorciados.php?funcao_js=parent.preencheEnteConsorciado|c215_sequencial','Pesquisa',true);
}
function preencheEnteConsorciado(chave){

  db_iframe_entesconsorciados.hide();
  location.href = 'con1_entesconsorciados002.php?chavepesquisa=' + chave;

}
</script>
