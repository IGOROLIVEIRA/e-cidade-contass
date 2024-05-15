<?
//MODULO: sicom
$clinfocomplementares->rotulo->label();
$clrotulo = new rotulocampo;
?>
<form name="form1" method="post" action="">
    <center>
        <fieldset style="margin-left: 80px; margin-top: 10px;">
            <legend>Informações Complementares</legend>
            <?
            //db_input('si08_sequencial',10,$Isi08_sequencial,true,'hidden',3,"")
            ?>
            <table border="0">
                <tr>
                    <td nowrap title="<?= @$Tsi08_tratacodunidade ?>">
                        <?= @$Lsi08_tratacodunidade ?>
                    </td>
                    <td>
                        <?
                        $x = array("1" => "NÃO", "2" => "SIM");
                        db_select('si08_tratacodunidade', $x, true, $db_opcao, "");
                        //db_input('si01_sequencial',10,$Isi01_sequencial,true,'text',3,"")
                        ?>
                    </td>
                </tr>

                <tr>
                    <td nowrap title="<?= @$Tsi08_tipoliquidante ?>">
                        <?= @$Lsi08_tipoliquidante ?>
                    </td>
                    <td>
                        <?
                        $x = array("1" => "POR UNIDADE", "2" => "POR USUÁRIO");
                        db_select('si08_tipoliquidante', $x, true, $db_opcao, "");
                        //db_input('si01_sequencial',10,$Isi01_sequencial,true,'text',3,"")
                        ?>
                    </td>
                </tr>


                <tr>
                    <td>
                        <b>Orçamento por modalidade de aplicação: </b>
                    </td>
                    <td>
                        <?
                        /**
                         * Campo adicionado por causa do sicom balancete em 2015
                         */
                        $x = array("0" => "NÃO", "1" => "SIM");
                        db_select('si08_orcmodalidadeaplic', $x, true, $db_opcao, "");
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="Código da unidade orçamentária padrão para o exercicio atual">
                        <b>Cod. UnidadeSub:</b>
                    </td>
                    <td>
                        <?php db_input('si08_codunidadesub',13,'',false,'text',$db_opcao,"","","","",8); ?>
                    </td>
                </tr>
            </table>
        </fieldset>
    </center>
    <input name="btnSalvar" type="submit" id="db_opcao" value="Salvar">

</form>