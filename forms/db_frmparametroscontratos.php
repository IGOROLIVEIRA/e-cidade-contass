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
       Liberar autoriza��o de empenho sem assinatura do contrato:
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
       Liberar cadastro de contratos sem vig�ncia:
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
       Liberar autotiza��o de empenho sem assinatura de aditivo?:
    </td>
    <td>
<?
$x = array("f"=>"NAO","t"=>"SIM");
db_select('pc01_liberarsemassinaturaaditivo',$x,true,$db_opcao,"");
?>
    </td>
  </tr>
 </table>
 <table style="width: 100px" >
     <tr align="center">
         <td>
             <strong>Aten��o ao liberar esse Par�metro o sistema irar permitir a execu��o de contratos que n�o
                 estejam assinados. Contratos N�o assinados n�o s�o gerados no SICOM - CONTRATOS</strong>
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
  js_OpenJanelaIframe('top.corpo','db_iframe_parametroscontratos','func_parametroscontratos.php?funcao_js=parent.js_preenchepesquisa|0','Pesquisa',true);
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
