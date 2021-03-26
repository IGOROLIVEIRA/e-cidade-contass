<?
//MODULO: orcamento
$clcronogramamesdesembolso->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("o41_descr");
$clrotulo->label("o41_descr");
$clrotulo->label("o40_descr");
$clrotulo->label("o41_descr");
$clrotulo->label("o41_descr");
$clrotulo->label("o41_descr");
$clrotulo->label("o40_descr");
$clrotulo->label("o41_descr");
$clrotulo->label("o41_descr");
$clrotulo->label("o40_descr");
$clrotulo->label("o41_descr");
$clrotulo->label("o41_descr");
$clrotulo->label("o40_descr");
?>
<form name="form1" method="post" action="">
<fieldset style="width: 1000px;">
    <legend><b>Cronograma Mensal de Desembolso</b></legend>
<table border="0">
  <tr>
    <td>
    </td>
    <td>
<?
db_input('o202_sequencial',11,$Io202_sequencial,true,'hidden',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$To202_unidade?>">
       <?=@$Lo202_orgao?>
    </td>
    <td>
       <?
          $sWhere  = " o40_anousu     = ".db_getSession("DB_anousu");
          $sWhere .= " and o41_instit = ".db_getSession("DB_instit");
          $sWhere .= " and exists (select 1 from orcdotacao inner join orcelemento on orcdotacao.o58_codele = orcelemento.o56_codele  where o58_orgao=o40_orgao and o58_anousu=o40_anousu and o58_unidade=o41_unidade and substring(o56_elemento,1,3) != '399')";
          //echo $clorcunidade->sql_query(null,null,null,"distinct o40_orgao,o40_descr","o40_descr",$sWhere);
          $result = $clorcunidade->sql_record($clorcunidade->sql_query(
                                             null,null,null,"distinct o40_orgao,o40_descr","o40_descr",$sWhere));
          if (@pg_numrows($result) == 0) {
            echo "<strong>Sistema não localizou nenhum orgão com unidades vinculadas na instituição selecionada!</strong>";
          } else {
            db_selectrecord("o40_orgao",@$result,true,$db_opcao,'','','','',"js_getUnidades(this.value);");
          }
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$To202_orgao?>">
       <?=@$Lo202_unidade?>
    </td>
    <td>
       <?
          if (empty($o40_orgao)){
            @db_fieldsmemory($result,0);
          }
          if (isset($o40_orgao)) {
            $result = $clorcunidade->sql_record($clorcunidade->sql_query_file(null,
                                                                              null,
                                                                              null,
                                                                              "o41_unidade,o41_descr","o41_descr",
                                                                              "o41_anousu = " . db_getsession("DB_anousu") . " and o41_orgao=$o40_orgao and o41_instit = ".db_getSession("DB_instit")." and exists (select 1 from orcdotacao inner join orcelemento on orcdotacao.o58_codele = orcelemento.o56_codele  where o58_orgao=o41_orgao and o58_anousu=o41_anousu and o58_unidade=o41_unidade and substring(o56_elemento,1,3) != '399')"));
            db_selectrecord("o41_unidade",@$result,true,$db_opcao,"","","","","js_carregar_cronograma()");
          }
        ?>
    </td>
  </tr>
  <tr>
    <td colspan="2"><input name="divisao" type="button" id="db_opcao" value="Divisão Automática" onclick="js_divisao_automatica();" /></td>
  </tr>
  </table>

<?
if (isset($aDespesa) && count($aDespesa) > 0) {
?>

<table style="width: 1100px; table-layout: fixed;">
  <tr>
  <td style="width: 34%;">
  <div style="margin-bottom: 14px;">
  <table>
  <tr class="linha-tabela" >
    <td colspan="2"><b>Grupos</b></td>
  </tr>
    <?
foreach ($aDespesa as $sKey => $oDespesa) {
  $aNiveis[] = $sKey;
  ${"totalorcado{$sKey}"} = trim(db_formatar($oDespesa->nTotalOrcado,"f"));
    ?>
  <tr style= "white-space: nowrap;">
    <td >
    <b><?=$aTipoDespesa[$sKey] ?></b>
    </td>
    <td >
    <b>Total Orçado:</b>
    <?
    db_input("totalorcado{$sKey}",14,4,true,'text',3,"")
    ?>
    </td>
  </tr>
  <?
    }
  ?>
  </table>
  </div>
  </td>

  <td>
  <div style="overflow-x: auto;">
  <table>
  <tr class="linha-tabela">
    <td nowrap title="<?=@$To202_janeiro?>">
       <?=@$Lo202_janeiro?>
    </td>
    <td nowrap title="<?=@$To202_fevereiro?>">
       <?=@$Lo202_fevereiro?>
    </td>
    <td nowrap title="<?=@$To202_marco?>">
       <?=@$Lo202_marco?>
    </td>
    <td nowrap title="<?=@$To202_abril?>">
       <?=@$Lo202_abril?>
    </td>
    <td nowrap title="<?=@$To202_maio?>">
       <?=@$Lo202_maio?>
    </td>
    <td nowrap title="<?=@$To202_junho?>">
       <?=@$Lo202_junho?>
    </td>
    <td nowrap title="<?=@$To202_julho?>">
       <?=@$Lo202_julho?>
    </td>
    <td nowrap title="<?=@$To202_agosto?>">
       <?=@$Lo202_agosto?>
    </td>
    <td nowrap title="<?=@$To202_setembro?>">
       <?=@$Lo202_setembro?>
    </td>
    <td nowrap title="<?=@$To202_outubro?>">
       <?=@$Lo202_outubro?>
    </td>
    <td nowrap title="<?=@$To202_novembro?>">
       <?=@$Lo202_novembro?>
    </td>
    <td nowrap title="<?=@$To202_dezembro?>">
       <?=@$Lo202_dezembro?>
    </td>
</tr>
  <?
foreach ($aDespesa as $sKey => $oDespesa) {
  ?>
<tr class="" >

    <td>
<?
db_input("o202_janeiro{$sKey}",11,$Io202_janeiro,true,'text',$db_opcao,"onChange='js_somaLinha(this,{$sKey})'")
?>
    </td>
    <td>
<?
db_input("o202_fevereiro{$sKey}",11,$Io202_fevereiro,true,'text',$db_opcao,"onChange='js_somaLinha(this,{$sKey})'")
?>
    </td>
    <td>
<?
db_input("o202_marco{$sKey}",11,$Io202_marco,true,'text',$db_opcao,"onChange='js_somaLinha(this,{$sKey})'")
?>
    </td>
    <td>
<?
db_input("o202_abril{$sKey}",11,$Io202_abril,true,'text',$db_opcao,"onChange='js_somaLinha(this,{$sKey})'")
?>
    </td>
    <td>
<?
db_input("o202_maio{$sKey}",11,$Io202_maio,true,'text',$db_opcao,"onChange='js_somaLinha(this,{$sKey})'")
?>
    </td>
    <td>
<?
db_input("o202_junho{$sKey}",11,$Io202_junho,true,'text',$db_opcao,"onChange='js_somaLinha(this,{$sKey})'")
?>
    </td>
    <td>
<?
db_input("o202_julho{$sKey}",11,$Io202_julho,true,'text',$db_opcao,"onChange='js_somaLinha(this,{$sKey})'")
?>
    </td>
    <td>
<?
db_input("o202_agosto{$sKey}",11,$Io202_agosto,true,'text',$db_opcao,"onChange='js_somaLinha(this,{$sKey})'")
?>
    </td>
    <td>
<?
db_input("o202_setembro{$sKey}",11,$Io202_setembro,true,'text',$db_opcao,"onChange='js_somaLinha(this,{$sKey})'")
?>
    </td>
    <td>
<?
db_input("o202_outubro{$sKey}",11,$Io202_outubro,true,'text',$db_opcao,"onChange='js_somaLinha(this,{$sKey})'")
?>
    </td>
    <td>
<?
db_input("o202_novembro{$sKey}",11,$Io202_novembro,true,'text',$db_opcao,"onChange='js_somaLinha(this,{$sKey})'")
?>
    </td>
    <td>
<?
db_input("o202_dezembro{$sKey}",11,$Io202_dezembro,true,'text',$db_opcao,"onChange='js_somaLinha(this,{$sKey})'")
?>
    </td>
  </tr>
  <?
  }
  ?>
  </div>
  </table>
  </td>
  <td style="width: 11%">
  <table>
  <div style="margin-bottom: -14px;">
  <tr class="linha-tabela">
    <td>
      <b>Total Programado:</b>
    </td>
  </tr>
  <?
  foreach ($aDespesa as $sKey => $oDespesa) {
  ?>
  <tr>
    <td>
      <?
      db_input("totalprogramado{$sKey}",14,4,true,'text',3,"")
      ?>
    </td>
  </tr>
  <?
  }
  ?>
  </div>
  </table>
  </td>
  </tr>
  </table>
  <?
} else {
  ?>
  <span><b>Sem Informação <?=$o41_unidadedescr ?></b><br><br></span>
  <?
}
?>
<input type="hidden" name="niveis" id="niveis" value="<?=implode(',',$aNiveis) ?>">
<input name="salvar" type="submit" id="salvar" value="Salvar">
<input name="imprimir" type="button" id="imprimir" value="Imprimir" onclick="js_pesquisa();" >
</fieldset>
</form>
</form>
<script>
function js_pesquisao202_unidade(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orcunidade','func_orcunidade.php?funcao_js=parent.js_mostraorcunidade1|o41_orgao|o41_descr','Pesquisa',true);
  }else{
     if(document.form1.o202_unidade.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orcunidade','func_orcunidade.php?pesquisa_chave='+document.form1.o202_unidade.value+'&funcao_js=parent.js_mostraorcunidade','Pesquisa',false);
     }else{
       document.form1.o41_descr.value = '';
     }
  }
}
function js_mostraorcunidade(chave,erro){
  document.form1.o41_descr.value = chave;
  if(erro==true){
    document.form1.o202_unidade.focus();
    document.form1.o202_unidade.value = '';
  }
}
function js_mostraorcunidade1(chave1,chave2){
  document.form1.o202_unidade.value = chave1;
  document.form1.o41_descr.value = chave2;
  db_iframe_orcunidade.hide();
}
function js_pesquisao202_orgao(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orcunidade','func_orcunidade.php?funcao_js=parent.js_mostraorcunidade1|o41_anousu|o41_descr','Pesquisa',true);
  }else{
     if(document.form1.o202_orgao.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orcunidade','func_orcunidade.php?pesquisa_chave='+document.form1.o202_orgao.value+'&funcao_js=parent.js_mostraorcunidade','Pesquisa',false);
     }else{
       document.form1.o41_descr.value = '';
     }
  }
}
function js_mostraorcunidade(chave,erro){
  document.form1.o41_descr.value = chave;
  if(erro==true){
    document.form1.o202_orgao.focus();
    document.form1.o202_orgao.value = '';
  }
}
function js_mostraorcunidade1(chave1,chave2){
  document.form1.o202_orgao.value = chave1;
  document.form1.o41_descr.value = chave2;
  db_iframe_orcunidade.hide();
}
function js_pesquisao202_anousu(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orcorgao','func_orcorgao.php?funcao_js=parent.js_mostraorcorgao1|o40_orgao|o40_descr','Pesquisa',true);
  }else{
     if(document.form1.o202_anousu.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orcorgao','func_orcorgao.php?pesquisa_chave='+document.form1.o202_anousu.value+'&funcao_js=parent.js_mostraorcorgao','Pesquisa',false);
     }else{
       document.form1.o40_descr.value = '';
     }
  }
}
function js_mostraorcorgao(chave,erro){
  document.form1.o40_descr.value = chave;
  if(erro==true){
    document.form1.o202_anousu.focus();
    document.form1.o202_anousu.value = '';
  }
}
function js_mostraorcorgao1(chave1,chave2){
  document.form1.o202_anousu.value = chave1;
  document.form1.o40_descr.value = chave2;
  db_iframe_orcorgao.hide();
}
function js_pesquisao202_unidade(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orcunidade','func_orcunidade.php?funcao_js=parent.js_mostraorcunidade1|o41_unidade|o41_descr','Pesquisa',true);
  }else{
     if(document.form1.o202_unidade.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orcunidade','func_orcunidade.php?pesquisa_chave='+document.form1.o202_unidade.value+'&funcao_js=parent.js_mostraorcunidade','Pesquisa',false);
     }else{
       document.form1.o41_descr.value = '';
     }
  }
}
function js_mostraorcunidade(chave,erro){
  document.form1.o41_descr.value = chave;
  if(erro==true){
    document.form1.o202_unidade.focus();
    document.form1.o202_unidade.value = '';
  }
}
function js_mostraorcunidade1(chave1,chave2){
  document.form1.o202_unidade.value = chave1;
  document.form1.o41_descr.value = chave2;
  db_iframe_orcunidade.hide();
}
function js_pesquisao202_anousu(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orcunidade','func_orcunidade.php?funcao_js=parent.js_mostraorcunidade1|o41_unidade|o41_descr','Pesquisa',true);
  }else{
     if(document.form1.o202_anousu.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orcunidade','func_orcunidade.php?pesquisa_chave='+document.form1.o202_anousu.value+'&funcao_js=parent.js_mostraorcunidade','Pesquisa',false);
     }else{
       document.form1.o41_descr.value = '';
     }
  }
}
function js_mostraorcunidade(chave,erro){
  document.form1.o41_descr.value = chave;
  if(erro==true){
    document.form1.o202_anousu.focus();
    document.form1.o202_anousu.value = '';
  }
}
function js_mostraorcunidade1(chave1,chave2){
  document.form1.o202_anousu.value = chave1;
  document.form1.o41_descr.value = chave2;
  db_iframe_orcunidade.hide();
}
function js_pesquisao202_unidade(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orcunidade','func_orcunidade.php?funcao_js=parent.js_mostraorcunidade1|o41_anousu|o41_descr','Pesquisa',true);
  }else{
     if(document.form1.o202_unidade.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orcunidade','func_orcunidade.php?pesquisa_chave='+document.form1.o202_unidade.value+'&funcao_js=parent.js_mostraorcunidade','Pesquisa',false);
     }else{
       document.form1.o41_descr.value = '';
     }
  }
}
function js_mostraorcunidade(chave,erro){
  document.form1.o41_descr.value = chave;
  if(erro==true){
    document.form1.o202_unidade.focus();
    document.form1.o202_unidade.value = '';
  }
}
function js_mostraorcunidade1(chave1,chave2){
  document.form1.o202_unidade.value = chave1;
  document.form1.o41_descr.value = chave2;
  db_iframe_orcunidade.hide();
}
function js_pesquisao202_orgao(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orcorgao','func_orcorgao.php?funcao_js=parent.js_mostraorcorgao1|o40_orgao|o40_descr','Pesquisa',true);
  }else{
     if(document.form1.o202_orgao.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orcorgao','func_orcorgao.php?pesquisa_chave='+document.form1.o202_orgao.value+'&funcao_js=parent.js_mostraorcorgao','Pesquisa',false);
     }else{
       document.form1.o40_descr.value = '';
     }
  }
}
function js_mostraorcorgao(chave,erro){
  document.form1.o40_descr.value = chave;
  if(erro==true){
    document.form1.o202_orgao.focus();
    document.form1.o202_orgao.value = '';
  }
}
function js_mostraorcorgao1(chave1,chave2){
  document.form1.o202_orgao.value = chave1;
  document.form1.o40_descr.value = chave2;
  db_iframe_orcorgao.hide();
}
function js_pesquisao202_anousu(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orcunidade','func_orcunidade.php?funcao_js=parent.js_mostraorcunidade1|o41_anousu|o41_descr','Pesquisa',true);
  }else{
     if(document.form1.o202_anousu.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orcunidade','func_orcunidade.php?pesquisa_chave='+document.form1.o202_anousu.value+'&funcao_js=parent.js_mostraorcunidade','Pesquisa',false);
     }else{
       document.form1.o41_descr.value = '';
     }
  }
}
function js_mostraorcunidade(chave,erro){
  document.form1.o41_descr.value = chave;
  if(erro==true){
    document.form1.o202_anousu.focus();
    document.form1.o202_anousu.value = '';
  }
}
function js_mostraorcunidade1(chave1,chave2){
  document.form1.o202_anousu.value = chave1;
  document.form1.o41_descr.value = chave2;
  db_iframe_orcunidade.hide();
}
function js_pesquisao202_orgao(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orcunidade','func_orcunidade.php?funcao_js=parent.js_mostraorcunidade1|o41_unidade|o41_descr','Pesquisa',true);
  }else{
     if(document.form1.o202_orgao.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orcunidade','func_orcunidade.php?pesquisa_chave='+document.form1.o202_orgao.value+'&funcao_js=parent.js_mostraorcunidade','Pesquisa',false);
     }else{
       document.form1.o41_descr.value = '';
     }
  }
}
function js_mostraorcunidade(chave,erro){
  document.form1.o41_descr.value = chave;
  if(erro==true){
    document.form1.o202_orgao.focus();
    document.form1.o202_orgao.value = '';
  }
}
function js_mostraorcunidade1(chave1,chave2){
  document.form1.o202_orgao.value = chave1;
  document.form1.o41_descr.value = chave2;
  db_iframe_orcunidade.hide();
}
function js_pesquisao202_orgao(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orcorgao','func_orcorgao.php?funcao_js=parent.js_mostraorcorgao1|o40_anousu|o40_descr','Pesquisa',true);
  }else{
     if(document.form1.o202_orgao.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orcorgao','func_orcorgao.php?pesquisa_chave='+document.form1.o202_orgao.value+'&funcao_js=parent.js_mostraorcorgao','Pesquisa',false);
     }else{
       document.form1.o40_descr.value = '';
     }
  }
}
function js_mostraorcorgao(chave,erro){
  document.form1.o40_descr.value = chave;
  if(erro==true){
    document.form1.o202_orgao.focus();
    document.form1.o202_orgao.value = '';
  }
}
function js_mostraorcorgao1(chave1,chave2){
  document.form1.o202_orgao.value = chave1;
  document.form1.o40_descr.value = chave2;
  db_iframe_orcorgao.hide();
}
function js_pesquisao202_anousu(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orcunidade','func_orcunidade.php?funcao_js=parent.js_mostraorcunidade1|o41_orgao|o41_descr','Pesquisa',true);
  }else{
     if(document.form1.o202_anousu.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orcunidade','func_orcunidade.php?pesquisa_chave='+document.form1.o202_anousu.value+'&funcao_js=parent.js_mostraorcunidade','Pesquisa',false);
     }else{
       document.form1.o41_descr.value = '';
     }
  }
}
function js_mostraorcunidade(chave,erro){
  document.form1.o41_descr.value = chave;
  if(erro==true){
    document.form1.o202_anousu.focus();
    document.form1.o202_anousu.value = '';
  }
}
function js_mostraorcunidade1(chave1,chave2){
  document.form1.o202_anousu.value = chave1;
  document.form1.o41_descr.value = chave2;
  db_iframe_orcunidade.hide();
}
function js_pesquisao202_orgao(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orcunidade','func_orcunidade.php?funcao_js=parent.js_mostraorcunidade1|o41_orgao|o41_descr','Pesquisa',true);
  }else{
     if(document.form1.o202_orgao.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orcunidade','func_orcunidade.php?pesquisa_chave='+document.form1.o202_orgao.value+'&funcao_js=parent.js_mostraorcunidade','Pesquisa',false);
     }else{
       document.form1.o41_descr.value = '';
     }
  }
}
function js_mostraorcunidade(chave,erro){
  document.form1.o41_descr.value = chave;
  if(erro==true){
    document.form1.o202_orgao.focus();
    document.form1.o202_orgao.value = '';
  }
}
function js_mostraorcunidade1(chave1,chave2){
  document.form1.o202_orgao.value = chave1;
  document.form1.o41_descr.value = chave2;
  db_iframe_orcunidade.hide();
}
function js_pesquisao202_anousu(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orcorgao','func_orcorgao.php?funcao_js=parent.js_mostraorcorgao1|o40_anousu|o40_descr','Pesquisa',true);
  }else{
     if(document.form1.o202_anousu.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orcorgao','func_orcorgao.php?pesquisa_chave='+document.form1.o202_anousu.value+'&funcao_js=parent.js_mostraorcorgao','Pesquisa',false);
     }else{
       document.form1.o40_descr.value = '';
     }
  }
}
function js_mostraorcorgao(chave,erro){
  document.form1.o40_descr.value = chave;
  if(erro==true){
    document.form1.o202_anousu.focus();
    document.form1.o202_anousu.value = '';
  }
}
function js_mostraorcorgao1(chave1,chave2){
  document.form1.o202_anousu.value = chave1;
  document.form1.o40_descr.value = chave2;
  db_iframe_orcorgao.hide();
}
function js_pesquisa(){
  js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_cronogramamesdesembolso','func_cronogramamesdesembolso.php?funcao_js=parent.js_preenchepesquisa|o202_sequencial','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_cronogramamesdesembolso.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}

function js_getUnidades(iOrgao){

  sWhere = " and exists (select 1 from orcdotacao where o58_orgao=o41_orgao and o58_anousu=o41_anousu and o58_unidade=o41_unidade) ";
  strJson = '{"method":"getUnidades","iOrgao":"'+iOrgao+'","sWhere":"'+sWhere+'"}';
  sUrl    = 'con4_db_departRPC.php';
  oAjax   = new Ajax.Request(
    sUrl,
    {
     method: 'post',
     parameters: 'json='+strJson,
     onComplete: js_retornoUnidades
   }
   );
}

function js_retornoUnidades(oAjax){

  oUnidades = eval("("+oAjax.responseText+")");
  $('o41_unidade').options.length      = 0;
  $('o41_unidadedescr').options.length = 0;
  $('o41_unidadedescr').disabled = false;
  $('o41_unidade').disabled      = false;
  for (iInd = 0; iInd < oUnidades.length; iInd++){

    oOptionId    = new Option(oUnidades[iInd].o41_unidade, oUnidades[iInd].o41_unidade);
    $('o41_unidade').add(oOptionId,null);
    oOptionDescr = new Option(js_urldecode(oUnidades[iInd].o41_descr), oUnidades[iInd].o41_unidade);
    $('o41_unidadedescr').add(oOptionDescr,null);
  }
  js_carregar_cronograma();
}

function js_urldecode(sString){

  sString = sString.replace(/\+/g," ");
  sString = unescape(sString);
  return sString;

}
var aCampos = ["o202_janeiro","o202_fevereiro","o202_marco","o202_abril","o202_maio","o202_junho","o202_julho","o202_agosto","o202_setembro","o202_outubro","o202_novembro","o202_dezembro"];
function js_somaLinha(campo,sNivel) {
  //alert(campo);
  var vlTotalProgramado = new Number(0);
  var vlTotalOrcado = js_strToFloat($('totalorcado'+sNivel).value).valueOf();
  aCampos.each(function (sNomeCampo) {
    //console.log($(sNomeCampo+sNivel).value);
    vlTotalProgramado += new Number($(sNomeCampo+sNivel).value);
  });
  if (js_round(vlTotalProgramado,2) > vlTotalOrcado) {
    alert("Valor Programado maior que valor Orçado para este grupo");
    campo.value = "";
  } else {
    $("totalprogramado"+sNivel).value = js_round(vlTotalProgramado,2);
  }
}

function js_divisao_automatica() {
  var aNiveis = $('niveis').value.split(",");
  //console.log(aNiveis);
  aNiveis.each(function (sNivel) {
    var vlTotalOrcado = js_strToFloat($('totalorcado'+sNivel).value).valueOf();
    $("totalprogramado"+sNivel).value = vlTotalOrcado;
    var vlMes = js_round((vlTotalOrcado/12),2);
    aCampos.each(function (sCampo) {
      $(sCampo+sNivel).value = vlMes;
    });
    if ((vlMes*12) != vlTotalOrcado) {
      $("o202_dezembro"+sNivel).value = js_round(vlMes-((vlMes*12)-vlTotalOrcado),2) ;
    }
  });
}

function js_carregar_cronograma() {
  var newURL =
  window.location.protocol + "//" +
  window.location.host + "/" +
  window.location.pathname + "?" +
  "o40_orgao=" + $("o40_orgao").value + "&" +
  "o41_unidade=" + $("o41_unidade").value;
  window.location.assign(newURL);
}
</script>
