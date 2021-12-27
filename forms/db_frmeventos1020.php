<?
//MODULO: esocial
$cleventos1020->rotulo->label();
?>
<style>
    #eso08_codempregadorlotacao {
        width: 160px;
        height: 17px;
    }

    #eso08_codtipolotacao {
        width: 120px;
    }

    #eso08_codtipoinscricao {
        width: 120px;
    }
</style>
<form name="form1" method="post" action="">
    <fieldset id="fieldset1" style="margin-top: 30px">
        <legend>Detalhamento das informações da Lotação</legend>
        <table border="0">
            <tr style="display: none">
                <td nowrap title="<?= @$Teso08_sequencial ?>">
                    <input name="oid" type="hidden" value="<?= @$oid ?>">
                    <strong>Sequencial:</strong>
                </td>
                <td>
                    <?
                    db_input('eso08_sequencial', 20, $Ieso08_sequencial, true, 'text', 3, "")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?= @$Teso08_codempregadorlotacao ?>">
                    <strong>Informar o código atribuído pelo empregador para a lotação tributária:</strong>
                </td>
                <td>
                    <?
                    db_textarea('eso08_codempregadorlotacao', 0, 0, $Ieso08_codempregadorlotacao, true, 'text', $db_opcao, "")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?= @$Teso08_codtipolotacao ?>">
                    <strong>Preencher com o código correspondente ao tipo de lotação:</strong>
                </td>
                <td>
                    <?
                    //db_input('eso08_codtipolotacao',2,$Ieso08_codtipolotacao,true,'text',$db_opcao,"")
                    $x = array(
                        "0" => "Selecione",
                        "1" => "Classificação da atividade econômica exercida pela Pessoa Jurídica para fins de atribuição de código FPAS",
                        "2" => "Obra de Construção Civil - Empreitada Parcial ou Subempreitada",
                        "3" => "Pessoa Física tomadora de serviços prestados mediante cessão de mão de obra, exceto contratante de cooperativa",
                        "4" => "Pessoa Jurídica tomadora de serviços prestados mediante cessão de mão de obra, exceto contratante de cooperativa, nos termos da Lei 8.212/1991",
                        "5" => "Pessoa Jurídica tomadora de serviços prestados por cooperados por intermédio de cooperativa de trabalho, exceto aqueles prestados a entidade beneficente/isenta",
                        "6" => "Entidade beneficente/isenta tomadora de serviços prestados por cooperados por intermédio de cooperativa de trabalho",
                        "7" => "Pessoa Física tomadora de serviços prestados por cooperados por intermédio de cooperativa de trabalho",
                        "8" => "Operador portuário tomador de serviços de trabalhadores avulsos",
                        "9" => "Contratante de trabalhadores avulsos não portuários por intermédio de sindicato",
                        "10" => "Embarcação inscrita no Registro Especial Brasileiro - REB",
                        "21" => "Classificação da atividade econômica ou obra própria de construção civil da Pessoa Física",
                        "24" => "Empregador doméstico",
                        "90" => "Atividades desenvolvidas no exterior por trabalhador vinculado ao Regime Geral de Previdência Social (expatriados)",
                        "91" => "Atividades desenvolvidas por trabalhador estrangeiro vinculado a Regime de Previdência Social no exterior"
                    );
                    db_select('eso08_codtipolotacao', $x, true, $db_opcao, "");
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?= @$Teso08_codtipoinscricao ?>">
                    <strong>Preencher com o código correspondente ao tipo de inscrição:</strong>
                </td>
                <td>
                    <?
                    $x = array(
                        "0" => "Selecione",
                        "1" => "CNPJ",
                        "2" => "CPF",
                        "3" => "CAEPF (Cadastro de Atividade Econômica de Pessoa Física)",
                        "4" => "CNO (Cadastro Nacional de Obra)",
                        "5" => "CGC",
                        "6" => "CEI"
                    );
                    db_select('eso08_codtipoinscricao', $x, true, $db_opcao, "");
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?= @$Teso08_numeroinscricao ?>">
                    <strong>Preencher com o número de inscrição (CNPJ, CPF, CNO) ao qual pertence a lotação tributária:</strong>
                </td>
                <td>
                    <?
                    db_input('eso08_numeroinscricao', 14, $Ieso08_numeroinscricao, true, 'text', $db_opcao, "")
                    ?>
                </td>
            </tr>
        </table>
    </fieldset>
    <fieldset id="fieldset2" style="margin-top: 30px">
        <legend>Informações de FPAS e Terceiros relativos à lotação tributária</legend>
        <table>
            <tr>
                <td nowrap title="<?= @$Teso08_codfpas ?>">
                    <strong>Preencher com o código relativo ao FPAS:</strong>
                </td>
                <td>
                    <?
                    $x = array(
                        "11" => "Selecione",
                        "3003576" => "Indústria, Escritório e Depósito de Empresa Industrial, Indústria de carnes e derivados entre outros",
                        "3003577" => "Comércio atacadista, Varejista, Estabelecimento de serviço de saúde, Comércio transportador entre outros",
                        "3003578" => "Sindicado e associação, trabalhador avulso ou empregador",
                        "3003579" => "Indústria de cana-de-açúcar e laticínios, extração de madeira, matadouro e abatedouro entre outros",
                        "3003580" => "Empresa de navegação marítima, fluvial e lacustre, Empresa de administração e exploração de portos entre outros",
                        "3003581" => "Empresa aeroviária",
                        "3003582" => "Empresa de comunicação, publicidade, josrnalista.",
                        "3003583" => "Estabelecimento de ensino - Sociedade cooperativa",
                        "3003584" => "Órgão de poder público",
                        "3003585" => "Cartório e tabelionato",
                        "3003586" => "Produtor Rural pessoa física, jurídica, consórcio simplificado de produtores rurais, agroindústria",
                        "3003587" => "Empresa optante pelo simples nacional, transporte rodoviário, transporte simples entre outros",
                        "3003588" => "Tomador de serviço de transportador rodoviário autônomo",
                        "3003589" => "Sociedade beneficente de assistência social",
                        "3003590" => "Associação desportiva que mantém equipe de futebol profissional",
                        "3003591" => "Empresa de trabalho temporário",
                        "3003592" => "Órgão gestor de mão-de-obra",
                        "3003593" => "Banco comercial e de investimento, Banco de desenvolvimento - caixa eletrônico entre outros",
                        "3003594" => "Empresa adquirente, consumidora, consignatária ou cooperativa, produtor rural de pessoa física e jurídica",
                        "3003595" => "Associação desportiva que mantém equipe de futebol profissional",
                        "3003596" => "Sindicato federação e confederação patronal rural, Atividade cooperativista rural entre outros",
                        "3003597" => "Estabelecimento Rural e industrial de sociedade cooperatival",
                        "3003598" => "Tomador de serviço de trabalhador avulso",
                        "3003599" => "Setor indutrial de agroindústria e tomador de serviço trabalhador avulso",
                        "3003600" => "Empregador Doméstico",
                        "3003601" => "Missões diplomáticas e outros organismos a elas equiparados",
                    );
                    db_select('eso08_codfpas', $x, true, $db_opcao, "");
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?= @$Teso08_codterceiros ?>">
                    <strong>Preencher com o código de Terceiros:</strong>
                </td>
                <td>
                    <?
                    db_input('eso08_codterceiros', 4, $Ieso08_codterceiros, true, 'text', $db_opcao, "")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?= @$Teso08_codterceiroscombinado ?>">
                    <strong>Informar o código combinado dos Terceiros para os quais o recolhimento está suspenso em virtude de processos judiciais:</strong>
                </td>
                <td>
                    <?
                    db_input('eso08_codterceiroscombinado', 4, $Ieso08_codterceiroscombinado, true, 'text', $db_opcao, "")
                    ?>
                </td>
            </tr>
        </table>
    </fieldset>
    <fieldset id="fieldset3" style="margin-top: 30px">
        <legend>Identificação do processo judicial</legend>
        <table>
            <tr>
                <td nowrap title="<?= @$Teso08_codterceirosprocjudicial ?>">
                    <strong>Informar o código de Terceiro:</strong>
                </td>
                <td>
                    <?
                    db_input('eso08_codterceirosprocjudicial', 20, $Ieso08_codterceirosprocjudicial, true, 'text', $db_opcao, "")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?= @$Teso08_nroprocessojudicial ?>">
                    <strong>Informar um número de processo judicial cadastrado através do evento S-1070:</strong>
                </td>
                <td>
                    <?
                    db_input('eso08_nroprocessojudicial', 20, $Ieso08_nroprocessojudicial, true, 'text', $db_opcao, "")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?= @$Teso08_codindicasuspensao ?>">
                    <strong>Código do indicativo da suspensão, atribuído pelo empregador em S-1070:</strong>
                </td>
                <td>
                    <?
                    db_input('eso08_codindicasuspensao', 20, $Ieso08_codindicasuspensao, true, 'text', $db_opcao, "")
                    ?>
                </td>
            </tr>
        </table>
    </fieldset>
    <fieldset id="fieldset4" style="margin-top: 30px">
        <legend>Informação complementar que apresenta identificação do contratante de obra de construção civil sob regime de empreitada parcial ou subempreitada</legend>
        <table>
            <tr>
                <td nowrap title="<?= @$Teso08_tipoinscricaocontratante ?>">
                    <strong>Tipo de inscrição do contratante:</strong>
                </td>
                <td>
                    <?
                    $x = array("0" => "Selecione", "1" => "CNPJ", "2" => "CPF");
                    db_select('eso08_tipoinscricaocontratante', $x, true, $db_opcao, "");
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?= @$Teso08_numeroinscricaocontratante ?>">
                    <strong>Número de inscrição (CNPJ/CPF) do contratante:</strong>
                </td>
                <td>
                    <?
                    db_input('eso08_numeroinscricaocontratante', 14, $Ieso08_numeroinscricaocontratante, true, 'text', $db_opcao, "")
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?= @$Teso08_tipoinscricaoproprietario ?>">
                    <strong>Tipo de inscrição do proprietário do CNO:</strong>
                </td>
                <td>
                    <?
                    $x = array("0" => "Selecione", "1" => "CNPJ", "2" => "CPF");
                    db_select('eso08_tipoinscricaoproprietario', $x, true, $db_opcao, "");
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?= @$Teso08_nroinscricaoproprietario ?>">
                    <strong>Preencher com o número de inscrição (CNPJ/CPF) do proprietário do CNO:</strong>
                </td>
                <td>
                    <?
                    db_input('eso08_nroinscricaoproprietario', 14, $Ieso08_nroinscricaoproprietario, true, 'text', $db_opcao, "")
                    ?>
                </td>
            </tr>
        </table>
    </fieldset>
    <fieldset id="fieldset5" style="margin-top: 30px">
        <legend>Informações do operador portuário:</legend>
        <table>
            <tr>
                <td nowrap title="<?= @$Teso08_aliquotarat ?>">
                    <strong>Preencher com a alíquota RAT definida na legislação vigente para a atividade (CNAE) preponderante:</strong>
                </td>
                <td>
                    <?
                    $x = array("0" => "Selecione", "1" => "1", "2" => "2", "3" => "3");
                    db_select('eso08_aliquotarat', $x, true, $db_opcao, "");
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?= @$Teso08_fatoracidentario ?>">
                    <strong>Fator Acidentário de Prevenção FAP:</strong>
                </td>
                <td>
                    <?
                    db_input('eso08_fatoracidentario', 5, $Ieso08_fatoracidentario, true, 'text', $db_opcao, "")
                    ?>
                </td>
            </tr>
        </table>
    </fieldset>
    </center>
    <div style="margin-left: 40%; margin-top: 10px">
        <input name="<?= ($db_opcao == 1 ? "incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "alterar" : "excluir")) ?>" type="submit" id="db_opcao" value="<?= ($db_opcao == 1 ? "Incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "Alterar" : "Excluir")) ?>" <?= ($db_botao == false ? "disabled" : "") ?>>
        <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();">
    </div>
</form>
<script>
    function js_pesquisa() {
        js_OpenJanelaIframe('top.corpo', 'db_iframe_eventos1020', 'func_eventos1020.php?funcao_js=parent.js_preenchepesquisa|0', 'Pesquisa', true);
    }

    function js_preenchepesquisa(chave) {
        db_iframe_eventos1020.hide();
        <?
        if ($db_opcao != 1) {
            echo " location.href = '" . basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]) . "?chavepesquisa='+chave";
        }
        ?>
    }
    var ofieldset3 = new DBToogle('fieldset3', false);
    var ofieldset4 = new DBToogle('fieldset4', false);
    var ofieldset5 = new DBToogle('fieldset5', false);
</script>
