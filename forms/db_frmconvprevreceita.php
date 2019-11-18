<form name="form1" method="post" action="" >
    <fieldset style="width: 600px;">
        <legend><b>Associação de Convênio à Previsão da Receita</b></legend>
        <center>
            <table border="0">
                <tr>
                    <td nowrap title="<?=@$Tc229_fonte?>">
                        <?=@$Lc229_fonte?>
                    </td>
                    <td>
                        <?
                        db_input('c229_fonte',0,$Ic229_fonte,true,'hidden',3,"");
                        db_input('sReceita',80,'',true,'text',3,"")
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?=@$Tc229_convenio?>">
                        <?
                        db_ancora($Lc229_convenio, "js_pesquisaConvenio();", 1);
                        ?>
                    </td>
                    <td>
                        <?
                        db_input('c229_convenio', 8, $Tc229_convenio, true, 'text', 1, "");
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?=@$Tc229_vlprevisto?>">
                        <?=@$Lc229_vlprevisto?>
                    </td>
                    <td>
                        <?
                        db_input('c229_vlprevisto', 8, $Ic229_vlprevisto, true, 'float', 1, "");
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?=@$Tc229_vlprevisto?>">
                        <b>Valor a Atribuir:</b>
                    </td>
                    <td>
                        <?
                        db_input('valor_atribuir', 8, 'Valor a Atribuir', true, 'float', 3, "");
                        ?>
                    </td>
                </tr>
            </table>
        </center>
    </fieldset>
    <input name="incluir" type="submit" id="incluir" value="Incluir">
    <input name="pesquisar" type="submit" id="pesquisar" value="Pesquisar">
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
    <table align="center">
        <tr>
            <td valign="center">
                <?
                $chavepri= array("c229_fonte"=>@$c229_fonte);
                $cliframe_alterar_excluir->chavepri=$chavepri;
                if (isset($c229_fonte)&&@$c229_fonte!=""){
                    $cliframe_alterar_excluir->sql = $clprevconvenioreceita->sql_query($c229_fonte,'','*',"","");
                }
                //$cliframe_alterar_excluir->sql_disabled = $clmatrequiitem->sql_query_atend(null,'*',null,"m41_codmatrequi=$m40_codigo and m43_codigo is not null");
                $cliframe_alterar_excluir->campos  ="c229_fonte,c229_convenio,c229_vlprevisto,c229_anousu";
                $cliframe_alterar_excluir->legenda="CONVÊNIOS ASSOCIADOS";
                $cliframe_alterar_excluir->msg_vazio ="Não foi encontrado nenhum registro.";
                $cliframe_alterar_excluir->textocabec ="darkblue";
                $cliframe_alterar_excluir->textocorpo ="black";
                $cliframe_alterar_excluir->fundocabec ="#aacccc";
                $cliframe_alterar_excluir->fundocorpo ="#ccddcc";
                $cliframe_alterar_excluir->iframe_width ="900";
                $cliframe_alterar_excluir->iframe_height ="300";
                $lib=1;
                if ($db_opcao==3||$db_opcao==33){
                    $lib=4;
                }
                $cliframe_alterar_excluir->opcoes = @$lib;
                $cliframe_alterar_excluir->iframe_alterar_excluir(@$db_opcao);
                db_input('db_opcao',10,'',true,'hidden',3);
                ?>
            </td>
        </tr>
    </table>
</form>
<script>
    function js_pesquisaConvenio() {
        alert('pesquisa convenio');
    }
</script>