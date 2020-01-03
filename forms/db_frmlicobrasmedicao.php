<?
//MODULO: Obras
$cllicobrasmedicao->rotulo->label();
?>
<form name="form1" method="post" action="">
  <center>
    <table border="0">
      <tr>
        <td nowrap title="<?=@$Tobr03_sequencial?>">
          <input name="oid" type="hidden" value="<?=@$oid?>">
          <?=@$Lobr03_sequencial?>
        </td>
        <td>
          <?
          db_input('obr03_sequencial',11,$Iobr03_sequencial,true,'text',3,"")
          ?>
        </td>
      </tr>
      <tr>
        <td>
          <?
          db_ancora('Nº Obra: ','js_pesquisa_obra(true)',$db_opcao);
          ?>
        </td>
        <td>
          <?
          db_input('obr03_seqobra',11,$Iobr03_seqobra,true,'text',$db_opcao,"onchange='js_pesquisa_obra(false)'")
          ?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?=@$Tobr03_dtlancamento?>">
          <?=@$Lobr03_dtlancamento?>
        </td>
        <td>
          <?
          db_inputdata('obr03_dtlancamento',@$obr03_dtlancamento_dia,@$obr03_dtlancamento_mes,@$obr03_dtlancamento_ano,true,'text',$db_opcao,"")
          ?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?=@$Tobr03_nummedicao?>">
          <?=@$Lobr03_nummedicao?>
        </td>
        <td>
          <?
          db_input('obr03_nummedicao',11,$Iobr03_nummedicao,true,'text',$db_opcao,"")
          ?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?=@$Tobr03_tipomedicao?>">
          <?=@$Lobr03_tipomedicao?>
        </td>
        <td>
          <?
          db_input('obr03_tipomedicao',11,$Iobr03_tipomedicao,true,'text',$db_opcao,"")
          ?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?=@$Tobr03_dtiniciomedicao?>">
          <?=@$Lobr03_dtiniciomedicao?>
        </td>
        <td>
          <?
          db_inputdata('obr03_dtiniciomedicao',@$obr03_dtiniciomedicao_dia,@$obr03_dtiniciomedicao_mes,@$obr03_dtiniciomedicao_ano,true,'text',$db_opcao,"")
          ?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?=@$Tobr03_outrostiposmedicao?>">
          <?=@$Lobr03_outrostiposmedicao?>
        </td>
        <td>
          <?
          db_textarea('obr03_outrostiposmedicao',0,0,$Iobr03_outrostiposmedicao,true,'text',$db_opcao,"")
          ?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?=@$Tobr03_descmedicao?>">
          <?=@$Lobr03_descmedicao?>
        </td>
        <td>
          <?
          db_textarea('obr03_descmedicao',0,0,$Iobr03_descmedicao,true,'text',$db_opcao,"")
          ?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?=@$Tobr03_dtfimmedicao?>">
          <?=@$Lobr03_dtfimmedicao?>
        </td>
        <td>
          <?
          db_inputdata('obr03_dtfimmedicao',@$obr03_dtfimmedicao_dia,@$obr03_dtfimmedicao_mes,@$obr03_dtfimmedicao_ano,true,'text',$db_opcao,"")
          ?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?=@$Tobr03_dtentregamedicao?>">
          <?=@$Lobr03_dtentregamedicao?>
        </td>
        <td>
          <?
          db_inputdata('obr03_dtentregamedicao',@$obr03_dtentregamedicao_dia,@$obr03_dtentregamedicao_mes,@$obr03_dtentregamedicao_ano,true,'text',$db_opcao,"")
          ?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?=@$Tobr03_vlrmedicao?>">
          <?=@$Lobr03_vlrmedicao?>
        </td>
        <td>
          <?
          db_input('obr03_vlrmedicao',11,$Iobr03_vlrmedicao,true,'text',$db_opcao,"")
          ?>
        </td>
      </tr>
      <tr>
        <td nowrap title="<?=@$Tobr03_instit?>">
          <?=@$Lobr03_instit?>
        </td>
        <td>
          <?
          db_input('obr03_instit',11,$Iobr03_instit,true,'text',$db_opcao,"")
          ?>
        </td>
      </tr>
    </table>
  </center>
  <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
  <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
  function js_pesquisa(){
    js_OpenJanelaIframe('top.corpo','db_iframe_licobrasmedicao','func_licobrasmedicao.php?funcao_js=parent.js_preenchepesquisa|0','Pesquisa',true);
  }
  function js_preenchepesquisa(chave){
    db_iframe_licobrasmedicao.hide();
    <?
    if($db_opcao!=1){
      echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
    }
    ?>
  }

  /**
   * funcao para retornar obras
   */
  function js_pesquisa_obra(mostra){
    if(mostra==true){

      js_OpenJanelaIframe('top.corpo',
        'db_iframe_licobrasituacao',
        'func_licobras.php?funcao_js=parent.js_preencheObra|obr01_sequencial|l20_edital|l20_numero|l03_descr',
        'Pesquisa Obras',true);
    }else{

      if(document.form1.obr02_seqobra.value != ''){

        js_OpenJanelaIframe('top.corpo',
          'db_iframe_licobrasituacao',
          'func_licobras.php?pesquisa_chave='+
          document.form1.obr02_seqobra.value+'&funcao_js=parent.js_preencheObra2',
          'Pesquisa',false);
      }else{
        document.form1.obr02_seqobra.value = '';
      }
    }
  }
  /**
   * funcao para preencher licitacao  da ancora
   */
  function js_preencheObra(codigo,edital,numero,descrcompra)
  {
    document.form1.obr02_seqobra.value = codigo;
    document.form1.tipocompra.value = descrcompra;
    document.form1.l20_edital.value = edital;
    document.form1.l20_numero.value = numero;
    db_iframe_licobrasituacao.hide();
  }

  function js_preencheObra2(edital,descrcompra,numero,erro) {
    document.form1.tipocompra.value = descrcompra;
    document.form1.l20_numero.value = numero;
    document.form1.l20_edital.value = edital;

    if(erro==true){
      document.form1.obr02_seqobra.focus();
    }
  }

</script>
