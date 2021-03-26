<?
include("dbforms/db_classesgenericas.php");

$cliframe_alterar_excluir = new cl_iframe_alterar_excluir;
$clconextsaldo->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("c60_codcon");

?>
<form name="form1" method="post" action="">
<center>
<table border="0">

<?
  db_input('ces01_sequencial',10,$Ices01_sequencial,true,'hidden',$db_opcao,"")
?>

  <tr>
    <td nowrap title="<?=@$Tces01_reduz?>">
      <?
        db_ancora('Reduzido do PCASP',"js_pesquisaces01_reduz(true);",$db_opcao);
      ?>
    </td>
    <td>
      <?
        db_input('ces01_reduz',10,$Ices01_reduz,true,'text',$db_opcao," onchange='js_pesquisaces01_reduz(false);'");
        db_input('ces01_codcon',10,$Ices01_codcon,true,'hidden',$db_opcao,"");
      ?>
      <?
        db_input('descricao',50,'',true,'text',3,'')
      ?>
      <input name="processar" type="submit" id="db_opcao" value="Processar">
    </td>
  </tr>
    <?
    if($ces01_reduz) {
        ?>
        <tr>
            <td nowrap title="Fonte">
                <?
                db_ancora('Fonte', "js_pesquisaces01_fonte(true);", $db_opcao);
                ?>
            </td>
            <td>
                <?
                db_input('ces01_fonte', 10, $Ices01_fonte, true, 'text', $db_opcao, " onchange='js_pesquisaces01_fonte(false);'")
                ?>
                <?
                db_input('o15_descr', 30, '', true, 'text', 3, '')
                ?>
            </td>
        </tr>
        <tr>
            <td nowrap title="Valor">
                <strong>Valor: </strong>
            </td>
            <td>
                <?
                db_input('ces01_valor', 10, $Ices01_valor, true, 'text', $db_opcao, "")
                ?>
            </td>
        </tr>
        <?
        $ces01_anousu = db_getsession('DB_anousu');
        db_input('ces01_anousu', 10, $Ices01_anousu, true, 'hidden', 3, "")
        ?>


        <?
        $ces01_inst = db_getsession('DB_instit');
        db_input('ces01_inst', 10, $Ices01_inst, true, 'hidden', 3, "")
        ?>

    <?
    }
    ?>



  </table>
  </center>
<?
if($ces01_reduz) {
?>
<input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
<input name="limpa" type="button" onclick='js_limpa();'  value="Limpar">
<? } ?>
    <center>
    <table>
        <?
        if($ces01_reduz) {

            $sql = $clconextsaldo->sql_query_file('', '*', '',
                "ces01_anousu = " . db_getsession('DB_anousu') ." and ces01_inst = ". db_getsession('DB_instit') .
                " and ces01_reduz = " . $ces01_reduz
                );

            $chavepri= array("ces01_sequencial"=>@$ces01_sequencial);
            $cliframe_alterar_excluir->chavepri=$chavepri;
            $cliframe_alterar_excluir->sql     = $sql;
            $cliframe_alterar_excluir->campos = "ces01_sequencial, ces01_codcon, ces01_reduz, ces01_fonte, ces01_valor";
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
function js_pesquisaces01_reduz(mostra){
    if(mostra==true){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_conplano','func_conplano.php?filtroCodsis=7&funcao_js=parent.js_mostraconplano1|c60_codcon|c61_reduz|c60_descr','Pesquisa',true);
    }else{
        if(document.form1.ces01_reduz.value != ''){
            js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_conplano','func_conplano.php?pesquisa_chave='+document.form1.ces01_reduz.value+'&reduz=true&filtroCodsis=7&funcao_js=parent.js_mostraconplano','Pesquisa',false);
        }else{
            document.form1.c61_reduz.value = '';
        }
    }
}
function js_mostraconplano(chave,erro){
    document.form1.descricao.value = chave;
    if(erro==true){
        document.form1.ces01_reduz.focus();
        document.form1.ces01_reduz.value = '';
    }
}
function js_mostraconplano1(chave1,chave2,chave3){
    document.form1.ces01_codcon.value = chave1;
    document.form1.ces01_reduz.value = chave2;
    document.form1.descricao.value = chave3;
    db_iframe_conplano.hide();
}

function js_pesquisa(){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_conextsaldo','func_conextsaldo.php?funcao_js=parent.js_preenchepesquisa|ces01_sequencial','Pesquisa',true);
}
function js_preenchepesquisa(chave){
    db_iframe_conextsaldo.hide();
    <?
    if($db_opcao!=1){
        echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
    }
    ?>
}

function js_pesquisaces01_fonte(mostra){
    if(mostra==true){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orctiporec','func_orctiporec.php?funcao_js=parent.js_mostraorctiporec1|o15_codigo|o15_descr','Pesquisa',true);
    }else{
        if(document.form1.ces01_fonte.value != ''){
            js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_orctiporec','func_orctiporec.php?pesquisa_chave='+document.form1.ces01_fonte.value+'&funcao_js=parent.js_mostraorctiporec','Pesquisa',false);
        }else{
            document.form1.o15_descr.value = '';
        }
    }
}
function js_mostraorctiporec(chave,erro){
    document.form1.o15_descr.value = chave;
    if(erro==true){
        document.form1.ces01_fonte.focus();
        document.form1.ces01_fonte.value = '';
    }
}
function js_mostraorctiporec1(chave1,chave2){
    document.form1.ces01_fonte.value = chave1;
    document.form1.o15_descr.value = chave2;
    db_iframe_orctiporec.hide();
}
function js_limpa(){
    location.href='con1_conextsaldo001.php';
}
</script>
