<?
//MODULO: acordos
$clparametroscontratos->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tpc01_liberaautorizacao?>">
    <input name="oid" type="hidden" value="<?=@$oid?>">
       Liberar autorização de empenho sem assinatura do contrato:
    </td>
    <td>
<?
$x = array("f"=>"NAO","t"=>"SIM");
db_select('pc01_liberaautorizacao',$x,true,$db_opcao,"");
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$pc01_liberarcadastrosemvigencia?>">
    <input name="oid" type="hidden" value="<?=@$oid?>">
       Liberar cadastro de contratos sem vigência:
    </td>
    <td>
<?
$x = array("f"=>"NAO","t"=>"SIM");
db_select('pc01_liberarcadastrosemvigencia',$x,true,$db_opcao,"");
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$pc01_liberarsemassinaturaaditivo?>">
    <input name="oid" type="hidden" value="<?=@$oid?>">
       Liberar autotização de empenho sem assinatura de aditivo?:
    </td>
    <td>
<?
$x = array("f"=>"NAO","t"=>"SIM");
db_select('pc01_liberarsemassinaturaaditivo',$x,true,$db_opcao,"");
?>
    </td>
  </tr>

  <tr>
    <td nowrap title="<?=@$pc01_libcontratodepart?>">
    <input name="oid" type="hidden" value="<?=@$oid?>">
       Controlar a alteração de dados do contrato por departamento?:
    </td>
    <td>
<?
$x = array("f"=>"NAO","t"=>"SIM");
db_select('pc01_libcontratodepart',$x,true,$db_opcao,"");
?>
    </td>
  </tr>
 </table>
<table>
    <tr>
        <td>
            <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
        </td>
    </tr>
</table>



</form>
<script>
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_parametroscontratos','func_parametroscontratos.php?funcao_js=parent.js_preenchepesquisa|0','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_parametroscontratos.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
</script>
