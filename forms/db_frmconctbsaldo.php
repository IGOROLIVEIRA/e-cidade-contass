<?
include("dbforms/db_classesgenericas.php");

$cliframe_alterar_excluir = new cl_iframe_alterar_excluir;
$clconctbsaldo->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("c60_codcon");
?>
<form name="form1" method="post" action="">
<center>
<table border="0">

<?
db_input('ces02_sequencial',10,$Ices02_sequencial,true,'hidden',$db_opcao,"")
?>

  <tr>
    <td nowrap title="<?=@$Tces02_codcon?>">
       <?
       db_ancora('Plano de contas',"js_pesquisaces02_codcon(true);",$db_opcao);
       ?>
    </td>
    <td> 
<?
db_input('ces02_codcon',10,$Ices02_codcon,true,'tctb',$db_opcao," onchange='js_pesquisaces02_codcon(false);'")
?>
       <?
db_input('descricao',10,'',true,'tctb',3,'')

       ?>
    </td>
  </tr>

        <tr>
            <td nowrap title="Reduzido">
                <strong>Reduzido: </strong>
            </td>
            <td>
                <?
                db_input('ces02_reduz', 10, $Ices02_reduz, true, 'tctb', 3, "")
                ?>
            </td>
        </tr>
    <?
    if($ces02_codcon) {
        ?>
        <tr>
            <td nowrap title="Fonte">
                <?
                db_ancora('Fonte', "js_pesquisaces02_fonte(true);", $db_opcao);
                ?>
            </td>
            <td>
                <?
                db_input('ces02_fonte', 10, $Ices02_fonte, true, 'tctb', $db_opcao, " onchange='js_pesquisaces02_fonte(false);'")
                ?>
                <?
                db_input('o15_descr', 60, '', true, 'tctb', 3, '')
                ?>
            </td>
        </tr>
        <tr>
            <td nowrap title="Valor">
                <strong>Valor: </strong>
            </td>
            <td>
                <?
                db_input('ces02_valor', 10, $Ices02_valor, true, 'tctb', $db_opcao, "")
                ?>
            </td>
        </tr>
        <?
        $ces02_anousu = db_getsession('DB_anousu');
        db_input('ces02_anousu', 10, $Ices02_anousu, true, 'hidden', 3, "")
        ?>


        <?
        $ces02_inst = db_getsession('DB_instit');
        db_input('ces02_inst', 10, $Ices02_inst, true, 'hidden', 3, "")
        ?>

    <?
    }
    ?>



  </table>
  </center>
<?
if($ces02_codcon) {
?>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<? }else{ ?>
    <input name="processar" type="submit" id="db_opcao" value="Processar">
<? } ?>
    <center>
    <table>
        <?
        if($ces02_codcon) {

            $sql = $clconctbsaldo->sql_query_file('', '*', '',
                "ces02_anousu = " . db_getsession('DB_anousu') ." and ces02_inst = ". db_getsession('DB_instit') .
                " and ces02_codcon = " . $ces02_codcon
                );

            $chavepri= array("ces02_sequencial"=>@$ces02_sequencial);
            $cliframe_alterar_excluir->chavepri=$chavepri;
            $cliframe_alterar_excluir->sql     = $sql;
            $cliframe_alterar_excluir->campos = "ces02_sequencial, ces02_codcon, ces02_reduz, ces02_fonte, ces02_valor";
            $cliframe_alterar_excluir->legenda="ITENS LANÇADOS";
            $cliframe_alterar_excluir->iframe_height ="160";
            $cliframe_alterar_excluir->iframe_width ="700";
            $cliframe_alterar_excluir->iframe_alterar_excluir($db_opcao);
        }
        ?>
    </table>
    </center>

</form>
<script>
function js_pesquisaces02_codcon(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('top.corpo','db_iframe_conplano','func_conplano.php?funcao_js=parent.js_mostraconplano1|c60_codcon|c60_codcon|c61_reduz','Pesquisa',true);
  }else{
     if(document.form1.ces02_codcon.value != ''){ 
        js_OpenJanelaIframe('top.corpo','db_iframe_conplano','func_conplano.php?pesquisa_chave='+document.form1.ces02_codcon.value+'&funcao_js=parent.js_mostraconplano','Pesquisa',false);
     }else{
       document.form1.c60_codcon.value = ''; 
     }
  }
}
function js_mostraconplano(chave,erro){
  document.form1.c60_codcon.value = chave; 
  if(erro==true){ 
    document.form1.ces02_codcon.focus(); 
    document.form1.ces02_codcon.value = ''; 
  }
}
function js_mostraconplano1(chave1,chave2,chave3){
  document.form1.ces02_codcon.value = chave1;
  document.form1.descricao.value = chave2;
  document.form1.ces02_reduz.value = chave3;
  db_iframe_conplano.hide();
}
function js_pesquisaces02_codcon(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('top.corpo','db_iframe_conplano','func_conplano.php?funcao_js=parent.js_mostraconplano1|c60_codcon|c60_descr|c61_reduz','Pesquisa',true);
  }else{
     if(document.form1.ces02_codcon.value != ''){ 
        js_OpenJanelaIframe('top.corpo','db_iframe_conplano','func_conplano.php?pesquisa_chave='+document.form1.ces02_codcon.value+'&funcao_js=parent.js_mostraconplano','Pesquisa',false);
     }else{
       document.form1.c60_codcon.value = ''; 
     }
  }
}
function js_mostraconplano(chave,erro){
  document.form1.c60_codcon.value = chave; 
  if(erro==true){ 
    document.form1.ces02_codcon.focus(); 
    document.form1.ces02_codcon.value = ''; 
  }
}
function js_mostraconplano1(chave1,chave2,chave3){
  document.form1.ces02_codcon.value = chave1;
  document.form1.descricao.value = chave2;
  document.form1.ces02_reduz.value = chave3;
  db_iframe_conplano.hide();
}
function js_pesquisa(){
  js_OpenJanelaIframe('top.corpo','db_iframe_conctbsaldo','func_conctbsaldo.php?funcao_js=parent.js_preenchepesquisa|ces02_sequencial','Pesquisa',true);
}
function js_preenchepesquisa(chave){
  db_iframe_conctbsaldo.hide();
  <?
  if($db_opcao!=1){
    echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
  }
  ?>
}

function js_pesquisaces02_fonte(mostra){
    if(mostra==true){
        js_OpenJanelaIframe('top.corpo','db_iframe_orctiporec','func_orctiporec.php?funcao_js=parent.js_mostraorctiporec1|o15_codigo|o15_descr','Pesquisa',true);
    }else{
        if(document.form1.ces02_fonte.value != ''){
            js_OpenJanelaIframe('top.corpo','db_iframe_orctiporec','func_orctiporec.php?pesquisa_chave='+document.form1.ces02_fonte.value+'&funcao_js=parent.js_mostraorctiporec','Pesquisa',false);
        }else{
            document.form1.o15_descr.value = '';
        }
    }
}
function js_mostraorctiporec(chave,erro){
    document.form1.o15_descr.value = chave;
    if(erro==true){
        document.form1.ces02_fonte.focus();
        document.form1.ces02_fonte.value = '';
    }
}
function js_mostraorctiporec1(chave1,chave2){
    document.form1.ces02_fonte.value = chave1;
    document.form1.o15_descr.value = chave2;
    db_iframe_orctiporec.hide();
}
</script>
