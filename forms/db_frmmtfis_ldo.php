<?
//MODULO: orcamento
$clmtfis_ldo->rotulo->label();
?>
<form name="form1" method="post" action="">
    <center>
        <table border="0">
            <tr>
                <td nowrap title="mtfis_sequencial">
                    <strong>Sequencial:</strong>
                </td>
                <td>
                    <?
                    db_input('mtfis_sequencial',10,$Imtfis_sequencial,true,'text',3,"")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="mtfis_anoinicialldo">
                    <strong>ANO INICIAL LDO:</strong>
                </td>
                <td>
                    <?
                    db_input('mtfis_anoinicialldo',4,$Imtfis_anoinicialldo,true,'text',$db_opcao,"")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="mtfis_pibano1">
                    <strong>PIB DO ANO 1:</strong>
                </td>
                <td>
                    <?
                    db_input('mtfis_pibano1',14,$Imtfis_pibano1,true,'text',$db_opcao,"")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="mtfis_pibano2">
                    <strong>PIB DO ANO 2:</strong>
                </td>
                <td>
                    <?
                    db_input('mtfis_pibano2',14,$Imtfis_pibano2,true,'text',$db_opcao,"")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="mtfis_pibano3">
                    <strong>PIB DO ANO 3:</strong>
                </td>
                <td>
                    <?
                    db_input('mtfis_pibano3',14,$Imtfis_pibano3,true,'text',$db_opcao,"")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="mtfis_rclano1">
                    <strong>RCL DO ANO 1:</strong>
                </td>
                <td>
                    <?
                    db_input('mtfis_rclano1',14,$Imtfis_rclano1,true,'text',$db_opcao,"")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="mtfis_rclano2">
                    <strong>RCL DO ANO 2:</strong>
                </td>
                <td>
                    <?
                    db_input('mtfis_rclano2',14,$Imtfis_rclano2,true,'text',$db_opcao,"")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="mtfis_rclano3">
                    <strong>RCL DO ANO 3:</strong>
                </td>
                <td>
                    <?
                    db_input('mtfis_rclano3',14,$Imtfis_rclano3,true,'text',$db_opcao,"")
                    ?>
                </td>
            </tr>

            <?
            //db_input('mtfis_instit',10,$Imtfis_instit,true,'text',$db_opcao,"")
            ?>

        </table>
    </center>
    <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
    <?php if($db_opcao==2){ ?>
        <input name="excluir" type="submit" id="db_opcao" value="Excluir" <?=($db_botao==false?"disabled":"")?> >
    <?php } ?>
    <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
</form>
<script>
    function js_pesquisa(){
        js_OpenJanelaIframe('','db_iframe_mtfis_ldo','func_mtfis_ldo.php?funcao_js=parent.js_preenchepesquisa|mtfis_sequencial','Pesquisa',true);
    }
    function js_preenchepesquisa(chave){
        //db_iframe_mtfis_ldo.hide();
        <?

        echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";

        ?>
    }
</script>
