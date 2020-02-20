<?
//MODULO: Obras
$cllicitemobra->rotulo->label();
?>
<form name="form1" method="post" action="">
  <center>
    <fieldset style="margin-left: 239px;margin-top: 15px">
      <legend>Item Obra</legend>
      <table border="0">
        <tr>
          <td nowrap title="<?=@$Tobr06_sequencial?>">
            <input name="oid" type="hidden" value="<?=@$oid?>">
            <?=@$Lobr06_sequencial?>
          </td>
          <td>
            <?
            db_input('obr06_sequencial',11,$Iobr06_sequencial,true,'text',3,"")
            ?>
          </td>
        </tr>
        <tr>
          <td>
            <?
            db_ancora("Material:","js_pesquisa_codmater(true)",$db_opcao);
            ?>
          </td>
          <td>
            <?
            db_input('obr06_pcmater',11,$Iobr06_pcmater,true,'text',$db_opcao,"onchange=js_pesquisa_codmater(false)");
            db_input('pc01_descrmater',40,$Ipc01_descrmater,true,'text',3,"");
            ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="<?=@$Tobr06_tabela?>">
            <?=@$Lobr06_tabela?>
          </td>
          <td>
            <?
            $aTab = array("0"=>"Selecione","1" => "1 - Tabela SINAP", "2" => "2 - Tabela SIPRO", "3" => "3 - Outras Tabelas Oficiais");
            db_select('obr06_tabela',$aTab,true,$db_opecao,"")
            ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="<?=@$Tobr06_descricaotabela?>">
            <?=@$Lobr06_descricaotabela?>
          </td>
          <td>
            <?
            db_textarea('obr06_descricaotabela',0,0,$Iobr06_descricaotabela,true,'text',$db_opcao,"","","",'250')
            ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="<?=@$Tobr06_codigotabela?>">
            <?=@$Lobr06_codigotabela?>
          </td>
          <td>
            <?
            db_input('obr06_codigotabela',15,$Iobr06_codigotabela,true,'text',$db_opcao,"")
            ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="<?=@$Tobr06_versaotabela?>">
            <?=@$Lobr06_versaotabela?>
          </td>
          <td>
            <?
            db_input('obr06_versaotabela',15,$Iobr06_versaotabela,true,'text',$db_opcao,"")
            ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="<?=@$Tobr06_dtregistro?>">
            <?=@$Lobr06_dtregistro?>
          </td>
          <td>
            <?
            db_inputdata('obr06_dtregistro',@$obr06_dtregistro_dia,@$obr06_dtregistro_mes,@$obr06_dtregistro_ano,true,'text',$db_opcao,"")
            ?>
          </td>
        </tr>
      </table>
    </fieldset>
  </center>
  <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
  <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
  function js_pesquisa(){
    js_OpenJanelaIframe('top.corpo','db_iframe_licitemobra','func_licitemobra.php?funcao_js=parent.js_preenchepesquisa|0','Pesquisa',true);
  }
  function js_preenchepesquisa(chave){
    db_iframe_licitemobra.hide();
    <?
    if($db_opcao!=1){
      echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
    }
    ?>
  }
  js_carregar();

  function js_pesquisa_codmater(mostra){
    if(mostra==true){
      js_OpenJanelaIframe('','db_iframe_mater','func_pcmater.php?obras=true&funcao_js=parent.js_mostra1|pc01_codmater|pc01_descrmater','Pesquisa',true);
    }else{
      if(document.form1.obr06_pcmater.value != ''){
        js_OpenJanelaIframe('','db_iframe_mater','func_pcmater.php?obras=true&pesquisa_chave='+document.form1.obr06_pcmater.value+'&funcao_js=parent.js_mostra','Pesquisa',false);
      }else{
        document.form1.pc01_descrmater.value = "";
      }
    }
  }
  function js_mostra(chave,erro){
    document.form1.pc01_descrmater.value = chave;
    if(erro==true){
      document.form1.obr06_pcmater.focus();
      document.form1.pc01_descrmater.value = '';
    }else{
      document.form1.pc01_descrmater.value=chave;
    }
  }
  function js_mostra1(chave1,chave2){
    document.form1.obr06_pcmater.value = chave1;
    document.form1.pc01_descrmater.value = chave2;
    db_iframe_mater.hide();
  }
  function js_carregar() {
    let db_opcao = <?=$db_opcao?>;
    if(db_opcao != 1){
      js_pesquisa_codmater(false);
    }
  }
</script>
