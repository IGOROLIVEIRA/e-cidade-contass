<?
//MODULO: licitacao
include("dbforms/db_classesgenericas.php");
$clcredenciamento->rotulo->label();
$cliframe_seleciona = new cl_iframe_seleciona;

?>

<script>
function js_submit() {

      var dados="";
      var itens = new Array();
      var iframe = document.getElementById('ativ');
      var campos = iframe.contentWindow.document.getElementsByTagName('input');
      var j = 0;  
      for (i=0;i<campos.length;i++) {
        campo = campos[i];
        if (campo.type == 'checkbox'){

          if (campo.checked) {
            itens[j] = campo.value;
            j++;
          }
        }
      }
      document.getElementById('l205_itens').value = itens;
      document.form1.submit();
    }
</script>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tl205_sequencial?>">
       <?=@$Ll205_sequencial?>
    </td>
    <td> 
<?
db_input('l205_sequencial',10,$Il205_sequencial,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tl205_fornecedor?>">
       <?=@$Ll205_fornecedor?>
    </td>
    <td> 
       <?
       db_selectrecord("l205_fornecedor",$result_forn,true,$db_opcao);
       ?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tl205_datacred?>"> 
       <?=@$Ll205_datacred?>
    </td>
    <td> 
<?
db_inputdata('l205_datacred',@$l205_datacred_dia,@$l205_datacred_mes,@$l205_datacred_ano,true,'text',1,"")
?>
    </td>
  </tr>
     <tr>
    <td align="right"  nowrap title="<?=@$Tl205_inscriestadual?>">
       <?=@$Ll205_inscriestadual?>
    </td>
    <td> 
    <?
    db_input('l205_inscriestadual',14,$Il205_inscriestadual,true,'text',3)
    //$l205_licitacao = $l20_codigo;
    
    ?>
    </td>
  </tr>

  <tr>
    <td> 
    <input name="l205_itens[]" type="hidden" id="l205_itens" value="">
    <input name="pc20_codorc" type="hidden" id="pc20_codorc" value="<? echo $pc20_codorc ?>">
    <input name="l205_licitacao" type="hidden" id="l205_licitacao" value="<? echo $l20_codigo ?>">
    </td>
  </tr>
  </table>
  </center>

<?
 if(!empty($l20_codigo)) {
                
                $sCampos  = " distinct l21_ordem, l21_codigo, pc81_codprocitem, pc11_seq, pc11_codigo, pc11_quant, pc11_vlrun, ";
                $sCampos .= " m61_descr, pc01_codmater, pc01_descrmater, pc11_resum, pc23_obs";
                $sOrdem   = "l21_ordem";
                $sWhere   = "l21_codliclicita = {$l20_codigo} ";
                // die($clliclicitem->sql_query_inf(null, $sCampos, $sOrdem, $sWhere));
                $sSqlItemLicitacao = $clliclicitem->sql_query_inf(null, $sCampos, $sOrdem, $sWhere);
                $result=$clliclicitem->sql_record($sSqlItemLicitacao);
                $numrows = $clliclicitem->numrows;
                if ($numrows > 0) {
                  $sWhere   = "l21_codliclicita = {$l20_codigo} and l205_fornecedor = {$l205_fornecedor} and l205_licitacao = {$l20_codigo}";
                  $sql     = $clcredenciamento->itensCredenciados(null, $sCampos, $sOrdem, $sWhere);
                  $result  = $clcredenciamento->sql_record($sql);
                  $numrows = $clcredenciamento->numrows;
                  if ($numrows > 0) {
                    $db_opcao     = 1;
                    //$sql_marca    = $sql;
                    $sql_disabled = $sql;
                     echo 
                    "<script> 
                    document.getElementById('l205_inscriestadual').style.backgroundColor = '#DEB887';
                    document.getElementById('l205_inscriestadual').readOnly = true;
                    </script>";
                  }else{
                    $db_opcao     = 1;
                    "<script> 
                    document.getElementById('l205_datacred').style.backgroundColor = '#FFF';
                    document.getElementById('l205_datacred').readOnly = false;
                    document.getElementById('l205_inscriestadual').style.backgroundColor = '#FFF';
                    document.getElementById('l205_inscriestadual').readOnly = false;
                    </script>";
                  }

                }
  }
?>

<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" <? if($db_opcao == 1){ ?> onclick="js_submit()" <? } ?> type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input id="db_opcao" type="submit" value="Excluir" name="excluir" tabindex="3">
<input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
 <center>
    <table>
          <?
           $cliframe_seleciona->sql=@$sSqlItemLicitacao;
           $cliframe_seleciona->campos  = $sCampos;
           $cliframe_seleciona->legenda="Itens";
           $cliframe_seleciona->iframe_width = '100%';
           //$cliframe_seleciona->desabilitados

           if($db_opcao == 2) {
             $cliframe_seleciona->sql_marca=@$sql_marca;
           }
           if ($db_opcao == 1 || $db_opcao == 3 || $db_opcao == 33) {
             $cliframe_seleciona->sql_disabled=@$sql_disabled;
           }
           $cliframe_seleciona->iframe_nome ="itens_teste"; 
           $cliframe_seleciona->chaves = "pc81_codprocitem";
           $cliframe_seleciona->iframe_seleciona(1);
           
           ?>
    </table>
  </center>

</form>
<script>

function js_pesquisa(){
  js_OpenJanelaIframe('','db_iframe_credenciamento','func_credenciamento.php?funcao_js=parent.js_preenchepesquisa|l205_fornecedor','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_credenciamento.hide();
  <?
  echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  ?>
}

function js_forn(){
  
   var param1 = document.form1.pc20_codorc.value;
   var param2 = document.form1.l205_licitacao.value;
   var param3 = document.form1.l205_fornecedor.value;
   
   top.corpo.iframe_db_cred.location.href='lic1_credenciamento001?pc20_codorc='+param1+'&l20_codigo='+param2+'&l205_fornecedor='+param3;   
}

function js_mostracgm(erro,chave){
  document.form1.l205_inscriestadual.value = chave;
  if(erro==true){
    document.form1.pc21_numcgm.focus();
    document.form1.pc21_numcgm.value = '';
  }
}
function js_mostracgm1(chave1){
  document.form1.l205_inscriestadual.value = chave1;
  func_nome.hide();
}

function js_ProcCod_l205_fornecedor(proc,res) {
	var sel1 = document.forms[0].elements[proc];
	var sel2 = document.forms[0].elements[res];
	for(var i = 0;i < sel1.options.length;i++) {
	if(sel1.options[sel1.selectedIndex].value == sel2.options[i].value)
	sel2.options[i].selected = true;
	}
	js_forn();
}

</script>
