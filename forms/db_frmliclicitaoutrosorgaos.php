<?
//MODULO: licitacao
$clliclicitaoutrosorgaos->rotulo->label();
?>
<form name="form1" method="post" action="">
<center>
<table border="0">
  <tr>
    <td nowrap title="<?=@$Tlic211_sequencial?>">
       <?=@$Llic211_sequencial?>
    </td>
    <td> 
<?
db_input('lic211_sequencial',8,$Ilic211_sequencial,true,'text',3,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tlic211_orgao?>">
       <?
       db_ancora(@$Llic211_orgao,"js_pesquisalic211_orgao(true);",$db_opcao);
       ?>
    </td>
    <td> 
<?
db_input('lic211_orgao',8,$Ilic211_orgao,true,'text',($db_opcao)," onchange='js_pesquisalic211_orgao(false);'")
?>
<?
db_input('z01_nome',40,$Iz01_nome,true,'text',3,'')
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tlic211_processo?>">
       <?=@$Llic211_processo?>
    </td>
    <td> 
<?
db_input('lic211_processo',4,$Ilic211_processo,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tlic211_numero?>">
       <?=@$Llic211_numero?>
    </td>
    <td> 
<?
db_input('lic211_numero',4,$Ilic211_numero,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tlic211_anousu?>">
       <?=@$Llic211_anousu?>
    </td>
    <td> 
<?
//$lic211_anousu = db_getsession('DB_anousu');
db_input('lic211_anousu',4,$Ilic211_anousu,true,'text',$db_opcao,"")
?>
    </td>
  </tr>
  <tr>
    <td nowrap title="<?=@$Tlic211_tipo?>">
       <?=@$Llic211_tipo?>
    </td>
    <td> 
<?
$tipos = array(0 => '0 - Selecione',
               5 => '5 - Licitação realizada por outro órgão ou entidade',
               6 => '6 - Dispensa ou Inexigibilidade realizada por outro órgão ou entidade',
               7 => '7 - Licitação - Regime Diferenciado de Contratações',
               8 => '8 - Licitação realizada por consorcio público',
               9 => '9 - Licitação realizada por outro ente da federação'
              );
db_select('lic211_tipo',$tipos,true,$db_opcao,"onchange='js_verificartipo()'");
?>
    </td>
  </tr>
  <tr id="trcodorgaoresplicit" style="display: <?= $db_opcao == 2 ? 'table-row' : 'none' ?> ;">
     <td nowrap title="<?=@$Tlic211_codorgaoresplicit?>">
            <?=@$Llic211_codorgaoresplicit?>
     </td>
     <td>
<?
db_input('lic211_codorgaoresplicit',4,$Ilic211_codorgaoresplicit,true,'text',$db_opcao,"")
?>
     </td>
  </tr>
    <tr id="trcodunisubres" style="display: <?= $db_opcao == 2 ? 'table-row' : 'none' ?> ;">
        <td nowrap title="<?=@$Tlic211_codunisubres?>">
            <?=@$Llic211_codunisubres?>
        </td>
        <td>
            <?
            db_input('lic211_codunisubres',4,$Ilic211_codunisubres,true,'text',$db_opcao,"")
            ?>
        </td>
    </tr>
  </table>
  </center>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
    <?php if ($db_opcao != 1):?>
        <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
    <?php endif;?>
</form>
<script>

function js_pesquisa(){
  js_OpenJanelaIframe('top.corpo','db_iframe_liclicitaoutrosorgaos','func_liclicitaoutrosorgaos.php?tipodescr=true&funcao_js=parent.js_preenchepesquisa|lic211_sequencial','Pesquisa',true);
}

function js_preenchepesquisa(chave){
  db_iframe_liclicitaoutrosorgaos.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}
function js_pesquisalic211_orgao(mostra){
    if(mostra==true){
        js_OpenJanelaIframe('','db_iframe_nomes','func_nome.php?funcao_js=parent.js_mostracgm1|z01_numcgm|z01_nome|z01_cgccpf|z01_incest|z01_uf','Pesquisa',true,'0');
    }else{
        if(document.form1.lic211_orgao.value != ''){
            js_OpenJanelaIframe('','db_iframe_nomes','func_nome.php?pesquisa_chave='+document.form1.lic211_orgao.value+'&funcao_js=parent.js_mostracgm','Pesquisa',false,'0','1','775','390');
        }else{
            document.form1.z01_nome.value = '';
        }
    }
}
function js_mostracgm(chave,chave2){
    document.form1.z01_nome.value = chave2;

    if(erro==true){
        document.form1.z01_nome.focus();
    }
}
function js_mostracgm1(chave1,chave2){
    document.form1.lic211_orgao.value = chave1;
    document.form1.z01_nome.value = chave2;
    db_iframe_nomes.hide();
}
function js_verificartipo() {
    value = document.form1.lic211_tipo.value;
    if (value == 5 || value == 6){
        document.getElementById('trcodorgaoresplicit').style.display = "";
        document.getElementById('trcodunisubres').style.display = "";
    } else if (value == 7){
        document.getElementById('trcodorgaoresplicit').style.display = "none";
        document.getElementById('trcodunisubres').style.display = "";
    } else {
        document.getElementById('trcodorgaoresplicit').style.display = "none";
        document.getElementById('trcodunisubres').style.display = "none";

    } if(value != 5 || value != 6){
        document.form1.lic211_codorgaoresplicit.value = "";
        document.form1.lic211_codunisubres.value = "";
    }
}

</script>
