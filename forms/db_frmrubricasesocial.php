<?
//MODULO: pessoal
$clrubricasesocial->rotulo->label();
?>
<div style="width: 40%;">


  <form name="form1" method="post" action="">
    <center>


    <fieldset >
        <Legend><strong>Rúbricas</strong></Legend>
        <table border="0">
          <tr>
            <td nowrap title="<?=@$Te990_sequencial?>">

             <?=@$Le990_sequencial?>
           </td>
           <td>
            <?
            db_input('e990_sequencial',10,$Ie990_sequencial,true,'text',($db_opcao!=1)?3:1,"")
            ?>
          </td>
        </tr>
        <tr>
          <td nowrap title="<?=@$Te990_descricao?>">
           <?=@$Le990_descricao?>
         </td>
         <td>
          <?
          db_input('e990_descricao',50,'',true,'text',$db_opcao,"")
          ?>
        </td>
      </tr>
    </table>

  </fieldset>
</center>
</div>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script type="text/javascript">



  function js_pesquisa(){
    db_iframe.jan.location.href = 'func_rubricasesocial.php?funcao_js=parent.js_preenchepesquisa|0';
    db_iframe.mostraMsg();
    db_iframe.show();
    db_iframe.focus();
  }
  function js_preenchepesquisa(chave){
    db_iframe.hide();
    //console.log('pes2_rubricasesocial002.php'+"?chavepesquisa="+chave);
    <?php if($db_opcao==3): ?>
    location.href = 'pes2_rubricasesocial003.php'+"?chavepesquisa="+chave;
    <?php else: ?>
    parent.location.href = 'pes2_rubricasesocial002.php'+"?chavepesquisa="+chave;
    <?php endif; ?>
  }



</script>
<?
$func_iframe = new janela('db_iframe','');
$func_iframe->posX=1;
$func_iframe->posY=20;
$func_iframe->largura=780;
$func_iframe->altura=430;
$func_iframe->titulo='Pesquisa';
$func_iframe->iniciarVisivel = false;
$func_iframe->mostrar();
?>
<script type="text/javascript">
  <?php if($db_opcao != 1): ?>
  <?php if(!isset($chavepesquisa)){
    echo " js_pesquisa(); ";
  }else {
    echo ' parent.mo_camada("basesrubricasesocial"); ';
  }
  endif;
  ?>
</script>
