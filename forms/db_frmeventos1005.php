<?
//MODULO: esocial
$cleventos1005->rotulo->label();
?>
<form name="form1" method="post" action="">
    <fieldset id = "fieldset1" style="margin-top: 30px">
        <legend>Identificação do estabelecimento, obra de construção civil ou unidade de órgão público</legend>
        <table border="0">
            <tr style="display: none">
                <td nowrap title="<?=@$Teso06_sequencial?>">
                    <input name="oid" type="hidden" value="<?=@$eso06_sequencial?>">
                    <?=@$Leso06_sequencial?>
                </td>
                <td>
                    <?
                    db_input('eso06_sequencial',10,$Ieso06_sequencial,true,'text',3,"")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?=@$Teso06_tipoinscricao?>">
                    <strong>Preencher com o código correspondente ao tipo de inscrição:</strong>
                </td>
                <td>
                    <?
                    $x = array("0"=>"Selecione","1"=>"CNPJ","3"=>"CAEPF","4"=>"CNO");
                    db_select('eso06_tipoinscricao',$x,true,$db_opcao,"");
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?=@$Teso06_nroinscricaoobra?>">
                    <strong>Informar o número de inscrição do estabelecimento, obra de construção civil ou órgão público:</strong>
                </td>
                <td>
                    <?
                    db_input('eso06_nroinscricaoobra',14,$Ieso06_nroinscricaoobra,true,'text',$db_opcao,"")
                    ?>
                </td>
            </tr>
        </table>
    </fieldset>
    <fieldset id = "fieldset2">
        <legend>Detalhamento das informações do estabelecimento, obra de construção civil ou unidade de órgão público:</legend>
        <table>
            <tr>
                <td nowrap title="<?=@$Teso06_codcnaf?>">
                    <strong>Preencher com o código CNAE conforme legislação vigente, referente à atividade econômica preponderante do estabelecimento:</strong>
                </td>
                <td>
                    <?
                    db_input('eso06_codcnaf',7,$Ieso06_codcnaf,true,'text',$db_opcao,"")
                    ?>
                </td>
            </tr>
        </table>
    </fieldset>
    <fieldset id = "fieldset3">
        <legend>Informações de apuração da alíquota GILRAT do estabelecimento:</legend>
        <table>
            <tr>
                <td nowrap title="<?=@$Teso06_aliquotarat?>">
                    <strong>Informar a alíquota RAT, quando divergente da legislação vigente para a atividade (CNAE) preponderante:</strong>
                </td>
                <td>
                    <?
                    db_input('eso06_aliquotarat',1,$Ieso06_aliquotarat,true,'text',$db_opcao,"")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?=@$Teso06_fatoracidentario?>">
                    <strong>Fator Acidentário de Prevenção - FAP</strong>
                </td>
                <td>
                    <?
                    db_input('eso06_fatoracidentario',5,$Ieso06_fatoracidentario,true,'text',$db_opcao,"")
                    ?>
                </td>
            </tr>
        </table>
    </fieldset>
    <fieldset id = "fieldset4">
        <legend>Processo administrativo ou judicial em que houve decisão/sentença favorável ao contribuinte modificando a alíquota RAT da empresa:</legend>
        <table>
            <tr>
                <td nowrap title="<?=@$Teso06_codtipoprocessorat?>">
                    <strong>Preencher com o código correspondente ao tipo de processo:</strong>
                </td>
                <td>
                    <?
                    $x = array("0"=>"Selecione","1"=>"Administrativo","2"=>"Judicial");
                    db_select('eso06_codtipoprocessorat',$x,true,$db_opcao,"");
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?=@$Teso06_nroprocessos1070rat?>">
                    <strong>Informar um número de processo cadastrado através do evento S-1070:</strong>
                </td>
                <td>
                    <?
                    db_input('eso06_nroprocessos1070rat',21,$Ieso06_nroprocessos1070rat,true,'text',$db_opcao,"")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?=@$Teso06_codindicativosuspensaos1070rat?>">
                    <strong>Código do indicativo da suspensão, atribuído pelo empregador em S-1070:</strong>
                </td>
                <td>
                    <?
                    db_input('eso06_codindicativosuspensaos1070rat',14,$Ieso06_codindicativosuspensaos1070rat,true,'text',$db_opcao,"")
                    ?>
                </td>
            </tr>
        </table>
    </fieldset>
    <fieldset id = "fieldset5">
        <legend>Processo administrativo/judicial em que houve decisão ou sentença favorável ao contribuinte suspendendo ou alterando a alíquota FAP aplicável ao contribuinte:</legend>
        <table>
            <tr>
                <td nowrap title="<?=@$Teso06_codtipoprocessofap?>">
                    <strong>Preencher com o código correspondente ao tipo de processo</strong>
                </td>
                <td>
                    <?
                    $x = array("0"=>"Selecione","1"=>"Administrativo","2"=>"Judicial","3"=>"Processo FAP de exercício anterior a 2019");
                    db_select('eso06_codtipoprocessofap',$x,true,$db_opcao,"");
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?=@$Teso06_nroprocessos1070fap?>">
                    <strong>Informar um número de processo cadastrado através do evento S-1070:</strong>
                </td>
                <td>
                    <?
                    db_input('eso06_nroprocessos1070fap',21,$Ieso06_nroprocessos1070fap,true,'text',$db_opcao,"")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?=@$Teso06_codindicativosuspensaos1070fap?>">
                    <strong>Código do indicativo da suspensão, atribuído pelo empregador em S-1070:</strong>
                </td>
                <td>
                    <?
                    db_input('eso06_codindicativosuspensaos1070fap',14,$Ieso06_codindicativosuspensaos1070fap,true,'text',$db_opcao,"")
                    ?>
                </td>
            </tr>
        </table>
    </fieldset>
    <fieldset id = "fieldset6">
        <legend>Informações relativas ao Cadastro de Atividade Econômica da Pessoa Física - CAEPF:</legend>
        <table>
            <tr>
                <td nowrap title="<?=@$Teso06_tipocaepf?>">
                    <strong>Tipo de CAEPF:</strong>
                </td>
                <td>
                    <?
                    $x = array("0"=>"Selecione","1"=>"Contribuinte individual","3"=>"Produtor rural","4"=>"Segurado especial");
                    db_select('eso06_tipocaepf',$x,true,$db_opcao,"");
                    ?>
                </td>
            </tr>
        </table>
    </fieldset>
    <fieldset id = "fieldset7">
        <legend>Cadastro Nacional de Obras:</legend>
        <table>
            <tr>
                <td nowrap title="<?=@$Teso06_subscontribuicaoobra?>">
                    <strong>Indicativo de substituição da contribuição patronal de obra de construção civil:</strong>
                </td>
                <td>
                    <?
                    $x = array("0"=>"Selecione","3003747"=>"Contribuição Patronal Substituída","3003748"=>"Contribuição Patronal Não Substituída");
                    db_select('eso06_subscontribuicaoobra',$x,true,$db_opcao,"");
                    ?>
                </td>
            </tr>
        </table>
    </fieldset>
    <fieldset id = "fieldset8">
        <legend>Informações relacionadas à contratação de aprendiz:</legend>
        <table>
            <tr>
                <td nowrap title="<?=@$Teso06_nroprocessojudicia?>">
                    <strong>Preencher com o número do processo judicia:</strong>
                </td>
                <td>
                    <?
                    db_input('eso06_nroprocessojudicia',20,$Ieso06_nroprocessojudicia,true,'text',$db_opcao,"")
                    ?>
                </td>
            </tr>
        </table>
    </fieldset>
    <fieldset id = "fieldset9">
        <legend>Identificação da(s) entidade(s) educativa(s) ou de prática desportiva:</legend>
        <table>
            <tr>
                <td nowrap title="<?=@$Teso06_nroinscricaoenteducativa?>">
                    <strong>Informar o número de inscrição da entidade educativa ou de prática desportiva:</strong>
                </td>
                <td>
                    <?
                    db_input('eso06_nroinscricaoenteducativa',14,$Ieso06_nroinscricaoenteducativa,true,'text',$db_opcao,"")
                    ?>
                </td>
            </tr>
        </table>
    </fieldset>
    <fieldset id = "fieldset10">
        <legend>Informações sobre a contratação de pessoa com deficiência (PCD):</legend>
        <table>
            <tr>
                <td nowrap title="<?=@$Teso06_nroprocessocontratacaodeficiencia?>">
                    <strong>Informar o número de inscrição da entidade educativa ou de prática desportiva:</strong>
                </td>
                <td>
                    <?
                    db_input('eso06_nroprocessocontratacaodeficiencia',20,$Ieso06_nroprocessocontratacaodeficiencia,true,'text',$db_opcao,"")
                    ?>
                </td>
            </tr>
        </table>
    </fieldset>
    <div style="margin-left: 40%; margin-top: 10px">
        <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?> >
        <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();" >
    </div>
</form>
<script>
    function js_pesquisa(){
        js_OpenJanelaIframe('top.corpo','db_iframe_eventos1005','func_eventos1005.php?funcao_js=parent.js_preenchepesquisa|0','Pesquisa',true);
    }
    function js_preenchepesquisa(chave){
        db_iframe_eventos1005.hide();
        <?
        if($db_opcao!=1){
            echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
        }
        ?>
    }
    var ofieldset3 = new DBToogle('fieldset3', false);
    var ofieldset4 = new DBToogle('fieldset4', false);
    var ofieldset5 = new DBToogle('fieldset5', false);
    var ofieldset6 = new DBToogle('fieldset6', false);
    var ofieldset7 = new DBToogle('fieldset7', false);
    var ofieldset8 = new DBToogle('fieldset8', false);
    var ofieldset9 = new DBToogle('fieldset9', false);
    var ofieldset10 = new DBToogle('fieldset10', false);
</script>
