<?
//MODULO: sicom
$clprojecaoatuarial10->rotulo->label();
if($db_opcao==1){
    $db_action="sic1_projecaoatuarial10004.php";
}else if($db_opcao==2||$db_opcao==22){
    $db_action="sic1_projecaoatuarial10005.php";
}else if($db_opcao==3||$db_opcao==33){
    $db_action="sic1_projecaoatuarial10006.php";
}
?>
<form name="form1" method="post" action="<?=$db_action?>">
    <center>
        <table border="0">
            <tr>
                <td nowrap title="<?=@$Tsi168_sequencial?>">
                    <?=@$Lsi168_sequencial?>
                </td>
                <td>
                    <?
                    db_input('si168_sequencial',10,$Isi168_sequencial,true,'text',3,"","","","width: 122px;")
                    ?>
                </td>
            </tr>

            <tr>
                <td nowrap title="">
                    <b>Exercício Anterior:</b>
                </td>
                <td>
                    <?
                    db_input('si168_exercicio',4,1,true,'text',$db_opcao,"","","","width: 122px;")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?=@$Tsi168_vlsaldofinanceiroexercicioanterior?>">
                    <?=@$Lsi168_vlsaldofinanceiroexercicioanterior?>
                </td>
                <td>
                    <?
                    db_input('si168_vlsaldofinanceiroexercicioanterior',14,$Isi168_vlsaldofinanceiroexercicioanterior,true,'text',$db_opcao,"")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?=@$Tsi168_vlreceitaprevidenciaria?>">
                    <?=@$Lsi168_vlreceitaprevidenciaria?>
                </td>
                <td>
                    <?php
                    db_input('si168_vlreceitaprevidenciaria',14,$Isi168_vlreceitaprevidenciaria,true,'text',$db_opcao,"");
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?=@$Tsi168_vldespesaprevidenciaria?>">
                    <?=@$Lsi168_vldespesaprevidenciaria?>
                </td>
                <td>
                    <?php
                    db_input('si168_vldespesaprevidenciaria',14,$Isi168_vldespesaprevidenciaria,true,'text',$db_opcao,"");
                    ?>
                </td>
            </tr>
            <tr>
                <td>
                        <strong>Tipo de plano</strong>
                </td>
                <td>
                    <?php
                    db_select('si168_tipoplano',array(0 => 'Selecione',1 => 'Plano previdenciário', 2 => 'Plano financeiro'),true,1,"onchange=''");
                    ?>
                </td>
            </tr>
            <?
            $si168_dtcadastro_dia = date("d");
            $si168_dtcadastro_mes = date("m");
            $si168_dtcadastro_ano = date("Y");
            db_inputdata('si168_dtcadastro',@$si168_dtcadastro_dia,@$si168_dtcadastro_mes,@$si168_dtcadastro_ano,true,'hidden',$db_opcao,"")
            ?>

            <?
            $si168_instit = db_getsession("DB_instit");
            db_input('si168_instit',10,$Isi168_instit,true,'hidden',$db_opcao,"")
            ?>

        </table>
    </center>
    <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
    <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
    function js_pesquisa(){
        js_OpenJanelaIframe('CurrentWindow.corpo.iframe_projecaoatuarial10','db_iframe_projecaoatuarial10','func_projecaoatuarial10.php?funcao_js=parent.js_preenchepesquisa|si168_sequencial','Pesquisa',true,'0','1','775','390');
    }
    function js_preenchepesquisa(chave){
        db_iframe_projecaoatuarial10.hide();
        <?
        if($db_opcao!=1){
            echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
        }
        ?>
    }
</script>
