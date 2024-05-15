<?
//MODULO: Obras
$cllicitemobra->rotulo->label();
?>
<style>
    #obr06_descricaotabela {
        width: 858px;
        height: 29px;
    }

    #l20_objeto,
    #pc80_resumo {
        width: 543px;
    }
</style>
<form name="form1" method="post" action="">
    <fieldset style="margin-top: 40px; width: 100%; max-width: 1230px;">
        <legend>Cadastro de itens obra</legend>
        <table border="0">
            <tr id="acoraLicitacao">
                <td width="150">
                    <? db_ancora("Sequencial da Licitação:", "js_pesquisa_liclicita(true)", $db_opcao); ?>
                </td>
                <td>
                    <?
                    db_input('l20_codigo', 11, $Il20_codigo, true, 'text', $db_opcao, "onchange=js_pesquisa_liclicita(false)");
                    db_input('l20_objeto', 40, $Il20_objeto, true, 'text', 3, "");
                    ?>
                </td>
            </tr>
            <tr id="acoraProcessoCompra">
                <td width="150">
                    <? db_ancora("Processo de Compras:", "js_pesquisa_pcproc(true)", $db_opcao); ?>
                </td>
                <td>
                    <?
                    db_input('pc80_codproc', 11, $Ipc80_codproc, true, 'text', $db_opcao, "onchange=js_pesquisa_pcproc(false)");
                    db_input('pc80_resumo', 40, $Ipc80_resumo, true, 'text', 3, "");
                    ?>
                </td>
            </tr>
        </table>
    </fieldset>

    <fieldset style="margin-top: 20px; width: 100%; max-width: 1230px;">
        <legend>Edição em bloco</legend>
        <table style="margin-top: 5px;">
            <tr>
                <td nowrap title="<?= @$Tobr06_tabela ?>">
                    <?= @$Lobr06_tabela ?>
                </td>
                <td>
                    <?
                    $aTab = array(
                        "0" => "Selecione",
                        "1" => "1 - Tabela SINAP",
                        "2" => "2 - Tabela SICRO",
                        "3" => "3 - Outras Tabelas Oficiais",
                        "4" => "4 - Cadastro Próprio"
                    );
                    db_select('obr06_tabela', $aTab, true, $db_opcao, " onchange='js_validatabela(this.value)'")
                    ?>
                </td>
                <td id="td_obr06_versaotabela" nowrap title="<?= @$Tobr06_versaotabela ?>" style="display: none;">
                    <?= @$Lobr06_versaotabela ?>
                    <?
                    db_input('obr06_versaotabela', 15, $Iobr06_versaotabela, true, 'text', $db_opcao, "")
                    ?>
                </td>
            </tr>
            <tr id="tr_obr06_descricaotabela" style="display: none;">
                <td nowrap title="<?= @$Tobr06_descricaotabela ?>">
                    <?= @$Lobr06_descricaotabela ?>
                </td>
                <td colspan="3">
                    <?
                    db_textarea('obr06_descricaotabela', 0, 0, $Iobr06_descricaotabela, true, 'text', $db_opcao, "", "", "", '250')
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="<?= @$Tobr06_dtcadastro ?>">
                    <?= @$Lobr06_dtcadastro ?>
                </td>
                <td>
                    <?
                    if (!isset($obr06_dtcadastro)) {
                        $obr06_dtcadastro_dia = date('d', db_getsession("DB_datausu"));
                        $obr06_dtcadastro_mes = date('m', db_getsession("DB_datausu"));
                        $obr06_dtcadastro_ano = date('Y', db_getsession("DB_datausu"));
                    }
                    db_inputdata('obr06_dtcadastro', @$obr06_dtcadastro_dia, @$obr06_dtcadastro_mes, @$obr06_dtcadastro_ano, true, 'text', $db_opcao);
                    ?>
                </td>
                <td id="td_obr06_codigotabela" style="display: none;">
                    <?= @$Lobr06_codigotabela ?>
                    <?
                    db_input('obr06_codigotabela', 15, $Iobr06_codigotabela, true, 'text', $db_opcao, "")
                    ?>
                </td>
            </tr>
        </table>
        <input name="Aplicar" type="button" id="Aplicar" value="Aplicar" style="width: 100px; margin-top: 7px; margin-bottom: 5px" onclick="js_aplicar();">
    </fieldset>

    <?php
   
    $ano = 0;
    if (!empty($l20_codigo)) {
        
        // Carrega a data da licitação
        $sResultLic = $clliclicita->sql_record($clliclicita->sql_query($l20_codigo, " distinct l20_anousu "));
        if ($clliclicita->numrows > 0) {
            $lic = db_utils::fieldsMemory($sResultLic, 0);
            $ano = (int) $lic->l20_anousu;
        }
        
        $sCampos  = " distinct pc01_codmater,pc01_descrmater,obr06_tabela,obr06_descricaotabela,obr06_dtregistro,obr06_dtcadastro,obr06_codigotabela,obr06_versaotabela,l21_ordem";
        $sOrdem   = "l21_ordem";
        $sWhere   = "l21_codliclicita = {$l20_codigo} and pc01_obras = 't' and pc10_instit = " . db_getsession('DB_instit');
        
        // Verifica o ano da licitação hotfix OC21089
        if ($ano < 2024) {
            $sSqlItemLicitacao = $cllicitemobra->sql_query_itens_obras_licitacao_sem_ordem(null, $sCampos, $sOrdem, $sWhere);
        } else {
            $sSqlItemLicitacao = $cllicitemobra->sql_query_itens_obras_licitacao(null, $sCampos, $sOrdem, $sWhere);
        }
        
        $sResultitens = $cllicitemobra->sql_record($sSqlItemLicitacao);
        $aItensObras = db_utils::getCollectionByRecord($sResultitens);
        $numrows = $cllicitemobra->numrows;
    }

    if (!empty($pc80_codproc)) {

        // Carrega data processo compra hotfix OC21089
        $sResultProc = $clproccop->sql_record($clproccop->sql_query($pc80_codproc, " distinct pc80_data "));
        if ($clproccop->numrows > 0) {
            $proc = db_utils::fieldsMemory($sResultProc, 0);
            $ano = (int)substr($proc->pc80_data, 0, 4);
        }

        $sCampos  = " distinct pc01_codmater,pc01_descrmater,obr06_tabela,obr06_descricaotabela,obr06_dtregistro,obr06_dtcadastro,obr06_codigotabela,obr06_versaotabela,pc11_seq";
        $sOrdem   = "pc11_seq";
        $sWhere   = "pc80_codproc = {$pc80_codproc} and pc01_obras = 't' and pc10_instit = " . db_getsession('DB_instit');
        
        
        // Verifica o ano do processo de compra  hotfix OC21089
        if ($ano < 2024) {
            $sSqlItemProcessodeCompras = $cllicitemobra->sql_query_itens_obras_processodecompras_sem_seq(null, $sCampos, $sOrdem, $sWhere);
        } else {
            $sSqlItemProcessodeCompras = $cllicitemobra->sql_query_itens_obras_processodecompras(null, $sCampos, $sOrdem, $sWhere);
        }
        
        $sResultitens = $cllicitemobra->sql_record($sSqlItemProcessodeCompras);
        $aItensObras = db_utils::getCollectionByRecord($sResultitens);
        $numrows = $cllicitemobra->numrows;
    }

    ?>

    <div style="margin-top: 20px; width: 100%; max-width: 1252px;; max-height: 420px; overflow-y: scroll;">
        <table class="DBgrid">
            <thead>
                <tr>
                    <td class="table_header" style="width: 35px; height:30px;" onclick="marcarTodos();">M</td>
                    <td class="table_header" style="width: 75px">Ordem</td>
                    <td class="table_header" style="width: 75px">Item</td>
                    <td class="table_header" style="width: 353px">Descrição Item</td>
                    <td class="table_header" style="width: 215px">Tabela</td>
                    <td class="table_header" style="width: 87px"> Cód. Tabela</td>
                    <td class="table_header" style="width: 90px"> Versão</td>
                    <td class="table_header" style="width: 315px">Descrição Tabela</td>
                    <td class="table_header" style="width: 87px">Ação</td>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($aItensObras as $key => $aItem) :
                    
                    // A ordem foi adicionada para diferenciar os itens com o mesmo código de matérial
                    if(isset($aItem->l21_ordem)) {
                        $ordem = $aItem->l21_ordem;
                    } else if (isset($aItem->pc11_seq)) {
                        $ordem = $aItem->pc11_seq;
                    }

                    //hotfix OC21089
                    $iItem = $aItem->pc01_codmater . ($aItem->obr06_tabela == "" ? "0" : $aItem->obr06_tabela);
                    if ($ano >= 2024) {
                        $iItem .= "-" . $ordem;
                    }
                ?>
                    <tr class="normal" id="<?= "linha_" . $iItem  ?>">
                        <input type="hidden" id=<?= 'obr06_dtcadastro_' . $iItem ?> value="<?= $aItem->obr06_dtcadastro ?>">

                        <th class="table_header" style="width: 35px">
                            <input type="checkbox" class="marca_itens[<?= $iItem ?>]" name="aItonsMarcados" value="<?= $iItem ?>" id="<?= $iItem ?>">
                        </th>

                        <th class="linhagrid" style="width: 35px">
                            <?= $ordem ?>
                            <input type="hidden" name="obr06_ordem" value="<?=$ordem ?>" id="obr06_ordem_<?=$iItem?>">
                        </th>

                        <td class="linhagrid" style="width: 75px">
                            <?= $aItem->pc01_codmater ?>
                            <input type="hidden" name="obr06_pcmater" value="<?= $aItem->pc01_codmater ?>" id="obr06_pcmater_<?=$iItem?>">
                        </td>
                        <td class="linhagrid" style="width: 353px">
                            <?= $aItem->pc01_descrmater ?>
                            <input type="hidden" name="pc01_descrmater" value="<?= $aItem->pc01_descrmater ?>" id="pc01_descrmater_<?= $iItem ?>">
                        </td>
                        <td class="linhagrid" style="width: 215px">
                            <select name="tabela" id="<?= 'obr06_tabela_' . $iItem ?>" onchange='js_validatabelaLinha(this.id)'>
                                <option value="0">Selecione</option>
                                <option <?php echo $aItem->obr06_tabela == "1" ? "selected" : ""; ?> value="1">1 - Tabela SINAP</option>
                                <option <?php echo $aItem->obr06_tabela == "2" ? "selected" : ""; ?> value="2">2 - Tabela SICRO</option>
                                <option <?php echo $aItem->obr06_tabela == "3" ? "selected" : ""; ?> value="3">3 - Outras Tabelas Oficiais</option>
                                <option <?php echo $aItem->obr06_tabela == "4" ? "selected" : ""; ?> value="4">4 - Cadastro Próprio</option>
                            </select>
                        </td>
                        <td class="linhagrid" style="width: 87px">
                            <input type="text" name="" value="<?= $aItem->obr06_codigotabela ?>" id="<?= 'obr06_codigotabela_' . $iItem ?>" <?= $aItem->obr06_tabela === "4" ? "disabled style='background-color: #E6E4F1;width: 80px;'" : "style='width: 80px'" ?>>
                        </td>
                        <td class="linhagrid" style="width: 90px">
                            <input type="text" name="" value="<?= $aItem->obr06_versaotabela ?>" id="<?= 'obr06_versaotabela_' . $iItem ?>" <?= $aItem->obr06_tabela === "4" ? "disabled style='background-color: #E6E4F1;width: 80px;'" : "style='width: 80px'" ?>>
                        </td>
                        <td class="linhagrid" style="width: 315px">
                            <input type="text" name="" value="<?= mb_convert_encoding($aItem->obr06_descricaotabela, "ISO-8859-1", "UTF-8") ?>" id="<?= 'obr06_descricaotabela_' . $iItem ?>" <?= $aItem->obr06_tabela !== "3" ? "disabled style='background-color: #E6E4F1'" : "" ?>>
                        </td>
                        <td class="linhagrid" style="width: 87px">
                            <input type="button" name="" value="Excluir" id="<?= $iItem ?>" onclick="excluirLinha('<?= $iItem ?>')">
                        </td>
                    </tr>
                <?php
                endforeach;
                ?>
            </tbody>
        </table>
        <?
        if ($numrows <= 0) {
            echo "<div>Nenhum Item Encontrado !</div>";
        }
        ?>
    </div>
    <div>
        <br>
        <input id="Salvar" type="button" value="Salvar" name="Salvar" onclick="js_salvarItens()">
        <input id="db_opcao" type="button" value="Excluir" name="excluir" onclick="js_excluirItensObra()">
    </div>
</form>
<script>
    function js_dataFormat(strData, formato) {

        if (formato == 'b') {
            aData = strData.split('/');
            return aData[2] + '-' + aData[1] + '-' + aData[0];
        } else {
            aData = strData.split('-');
            return aData[2] + '/' + aData[1] + '/' + aData[0];
        }
    }

    function js_pesquisa() {
        js_OpenJanelaIframe('top.corpo', 'db_iframe_liclicita', 'func_licitemobra.php?funcao_js=parent.js_preenchepesquisa|0', 'Pesquisa', true);
    }

    function js_preenchepesquisa(chave) {
        db_iframe_liclicita.hide();
        <?
        if ($db_opcao != 1) {
            echo " location.href = '" . basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]) . "?chavepesquisa='+chave";
        }
        ?>
    }

    // Busca json demorando muito tempo
    // js_carregar_tabela();

    verificaAncora();
    /**
     * funcao para retornar licitacao
     */
    function js_pesquisa_liclicita(mostra) {

        verificaAncora();

        if (mostra == true) {

            js_OpenJanelaIframe('top.corpo',
                'db_iframe_liclicita',
                'func_liclicita.php?itemobra=true&funcao_js=parent.js_preencheLicitacao|l20_codigo|l20_objeto',
                'Pesquisa Licitações', true);
        } else {
            if (document.form1.l20_codigo.value != '') {

                js_OpenJanelaIframe('top.corpo',
                    'db_iframe_liclicita',
                    'func_liclicita.php?itemobra=true&pesquisa_chave=' +
                    document.form1.l20_codigo.value + '&funcao_js=parent.js_preencheLicitacao2',
                    'Pesquisa', false);
            } else {
                document.form1.l20_codigo.value = '';
            }
        }
    }

    /**
     * funcao para preencher licitacao  da ancora
     */
    function js_preencheLicitacao(codigo, objeto) {
        document.form1.l20_codigo.value = codigo;
        document.form1.l20_objeto.value = objeto;
        document.form1.pc80_codproc.value = '';
        document.form1.pc80_resumo.value = '';

        db_iframe_liclicita.hide();

        // Envia formulário para carregar itens da obra
        document.form1.submit();
    }

    function js_preencheLicitacao2(objeto, erro) {
        document.form1.l20_objeto.value = objeto;
        document.form1.pc80_codproc.value = '';
        document.form1.pc80_resumo.value = '';

        if (erro == true) {
            alert("Nenhuma licitação encontrada.");
            document.form1.l20_objeto.value = "";
        }

        // Envia formulário para carregar itens da obra
        document.form1.submit();
    }

    function js_carregar() {
        let db_opcao = <?= $db_opcao ?>;
        if (db_opcao != 1) {
            js_pesquisa_codmater(false);
        }
    }

    function verificaAncora() {
        var codLicitacao = document.form1.l20_codigo.value.trim();
        var codProcessoCompra = document.form1.pc80_codproc.value.trim();

        // Exibir ambas as âncoras por padrão
        ocultarAncoraLicitacao(false);
        ocultarAncoraProcessoCompra(false);

        // Verificar se codLicitacao não está vazio e ocultar a âncora do processo de compra
        if (codLicitacao !== "") {
            ocultarAncoraProcessoCompra(true);
        }

        // Verificar se codProcessoCompra não está vazio e ocultar a âncora da licitação
        else if (codProcessoCompra !== "") {
            ocultarAncoraLicitacao(true);
        }
    }

    /**
     * Função para ocultar/mostrar a ancora de licitação
     */
    function ocultarAncoraLicitacao(opcao) {
        var element = document.getElementById("acoraLicitacao");
        if (element) {
            element.style.display = opcao === true ? 'none' : 'block';
        }
    }

    /**
     * Função para ocultar/mostrar a ancora de processo de compra
     */
    function ocultarAncoraProcessoCompra(opcao) {
        var element = document.getElementById("acoraProcessoCompra");
        if (element) {
            element.style.display = opcao === true ? 'none' : 'block';
        }
    }

    /**
     * funcao para retornar processo de compra
     */
    function js_pesquisa_pcproc(mostra) {

        verificaAncora();

        if (mostra == true) {
            js_OpenJanelaIframe('top.corpo', 'db_iframe_pcproc', 'func_pcproc.php?funcao_js=parent.js_mostrapcproc|pc80_codproc|pc80_resumo', 'Pesquisa', true);
        } else {
            if (document.form1.pc80_codproc.value != '') {
                js_OpenJanelaIframe('top.corpo', 'db_iframe_pcproc', 'func_pcproc.php?pesquisa_chave=' + document.form1.pc80_codproc.value + '&itemobras=true&funcao_js=parent.js_mostrapcproc1', 'Pesquisa', false);
            }
        }
    }

    /**
     * funcao para carregar processo de compra
     */
    function js_mostrapcproc(chave, chave2) {
        document.form1.pc80_codproc.value = chave;
        document.form1.pc80_resumo.value = chave2;
        db_iframe_pcproc.hide();

        // Envia formulário para carregar itens da obra
        document.form1.submit();
    }

    function js_mostrapcproc1(chave1, chave2, erro) {
        document.form1.pc80_codproc.value = chave1;
        document.form1.pc80_resumo.value = chave2;
        document.form1.l20_codigo.value = '';
        document.form1.l20_objeto.value = '';

        if (erro == true) {
            alert("Nenhuma processo de compra encontrado.");
            document.form1.pc80_codproc.focus();
            document.form1.pc80_codproc.value = '';
            document.form1.pc80_resumo.value = '';
        }

        // Envia formulário para carregar itens da obra
        document.form1.submit()
    }

    /**
     * Retorna todos os itens
     */

    function aItens() {
        var itensNum = document.getElementsByName("aItonsMarcados");

        return Array.prototype.map.call(itensNum, function(item) {
            return item;
        });
    }

    /**
     * Marca todos os itens
     */
    function marcarTodos() {

        // Valida a opção de edição em blocos
        mostraOcultaCamposEdicaoEmBloco();

        aItens().forEach(function(item) {

            var check = item.classList.contains('marcado');

            if (check) {
                item.classList.remove('marcado');
            } else {
                item.classList.add('marcado');
            }
            item.checked = !check;

        });
    }

    function js_carregar_tabela() {
        let licitacao = document.form1.l20_codigo.value;
        let processodecompras = document.form1.pc80_codproc.value;
        try {
            BuscarItensAjax({
                exec: 'getItensObra',
                l20_codigo: licitacao,
                pc80_codproc: processodecompras
            }, preenchercampos);
        } catch (e) {
            alert(e.toString());
        }
        return false;
    }

    function BuscarItensAjax(params, onComplete) {
        js_divCarregando('Aguarde Buscando Informações', 'div_aguarde');
        var request = new Ajax.Request('obr1_obras.RPC.php', {
            method: 'post',
            parameters: 'json=' + JSON.stringify(params),
            onComplete: function(oRetornoitems) {
                js_removeObj('div_aguarde');
                onComplete(oRetornoitems);
            }
        });
    }

    function preenchercampos(oRetornoitems) {
        var oRetornoitens = JSON.parse(oRetornoitems.responseText);

        oRetornoitens.itens.forEach(function(item, x) {
            let tabela = item.obr06_tabela;

            if (tabela.empty() === true) {
                tabela = 0;
            } else {
                tabela = item.obr06_tabela;
            }

            document.getElementById('obr06_tabela_' + item.pc01_codmater + tabela).value = tabela;
            document.getElementById('obr06_versaotabela_' + item.pc01_codmater + tabela).value = item.obr06_versaotabela;
            document.getElementById('obr06_descricaotabela_' + item.pc01_codmater + tabela).value = item.obr06_descricaotabela;
            document.getElementById('obr06_codigotabela_' + item.pc01_codmater + tabela).value = item.obr06_codigotabela;
            if (item.obr06_dtregistro != "") {
                //document.getElementById('obr06_dtregistro_' + item.pc01_codmater + tabela).value = js_dataFormat(item.obr06_dtregistro, 'u');
                document.getElementById('obr06_dtcadastro_' + item.pc01_codmater + tabela).value = js_dataFormat(item.obr06_dtcadastro, 'u');
            }
        });
    }

    function js_aplicar() {

        var checkedCheckbox = document.querySelector('input[name="aItonsMarcados"]:checked');
        if (checkedCheckbox === null) {
            alert("Usuário: É necessário marcar pelo menos um item para fazer a alteração.");
            return;
        }

        let tabela = document.getElementById('obr06_tabela').value;
        let versaotabela = document.getElementById('obr06_versaotabela').value;
        let descricaotabela = document.getElementById('obr06_descricaotabela').value;
        let dtcadastro = document.getElementById('obr06_dtcadastro').value;
        let codigodatabela = document.getElementById('obr06_codigotabela').value;

        aItens().forEach(function(item) {
            if (item.checked === true) {
                document.getElementById('obr06_tabela_' + item.id).value = tabela;

                habilitaDesabilitaTabela(tabela, item.id);

                let inputVersaoTabela = document.getElementById('obr06_versaotabela_' + item.id);
                if (inputVersaoTabela.disabled === false) {
                    inputVersaoTabela.style.backgroundColor = '#FFFFFF';
                    inputVersaoTabela.value = versaotabela;
                }

                let inputDescricaoTabela = document.getElementById('obr06_descricaotabela_' + item.id);
                if (inputDescricaoTabela.disabled === false) {
                    inputDescricaoTabela.style.backgroundColor = '#FFFFFF';
                    inputDescricaoTabela.value = descricaotabela;
                }

                document.getElementById('obr06_dtcadastro_' + item.id).value = dtcadastro;
                document.getElementById('obr06_codigotabela_' + item.id).value = codigodatabela;
            }
        })

    }

    /**
     * Botão Aplicar
     */

    function js_habilita_campos_da_tabela() {
        aItens().forEach(function(item) {
            document.getElementById('obr06_tabela_' + item.id).value = tabela;
            habilitaDesabilitaTabela(tabela, item.id);
        })
    }

    /**
     * Retorna itens marcados
     */

    function getItensMarcados() {
        return aItens().filter(function(item) {
            return item.checked;
        });
    }

    /**
     * Verifica se existe erro de validação em algum campo
     */
    function itemEValido(item) {
        if (item.obr06_codigotabela === "" && item.obr06_tabela !== "4") {
            return false;
        }

        if ((item.obr06_tabela === "1" || item.obr06_tabela === "2") && item.obr06_versaotabela === "") {
            return false;
        }

        if ((item.obr06_tabela === "3") && (item.obr06_versaotabela === "" || item.obr06_descricaotabela === "")) {
            return false;
        }

        return true;
    }

    /**
     * Salvar Itens
     */
    function js_salvarItens() {
        const itens = getItensMarcados();

        if (itens.length < 1) {
            alert('Selecione pelo menos um item da lista.');
            return false;
        }

        const itensEnviar = [];

        try {
            let temErro = false;

            itens.forEach(function(item) {

                const coditem = item.id;
                const linha = document.getElementById("linha_" + coditem);
                linha.style.backgroundColor = "#FFFFFF";

                const novoItem = NovoItem(coditem);

                if (!itemEValido(novoItem)) {
                    temErro = true;
                    linha.style.backgroundColor = "#6E9D88";
                }
                itensEnviar.push(novoItem);
            });

            /**
             * Valida se todos os itens selecionados para salvar estão com
             * a data de cadastro aplicada.
             */
            const dtcadastro = document.getElementById('obr06_dtcadastro').value;
            const itensSemDataCadastro = itensEnviar.filter(item => !item.obr06_dtcadastro);

            const ano = <?= $ano ?>;

            if (itensSemDataCadastro.length > 0) {
                var resposta = confirm('Usuário: A data não foi aplicada ao itens. Deseja continuar?');
                if (resposta) {
                    itensEnviar.forEach(function(item) {
                        if (!item.obr06_dtcadastro) {
                            item.obr06_dtcadastro = dtcadastro;
                            const id = (ano >= 2024) ? 'obr06_dtcadastro_' + item.obr06_pcmater + '-' + item.obr06_ordem : 'obr06_dtcadastro_' + item.obr06_pcmater;
                            document.getElementById(id).value = dtcadastro;
                        }
                    });
                } else {
                    return false;
                }
            }

            if (temErro) {
                alert("Usuário: Verificar campos obrigatórios sem preenchimento do(s) Item(ns) grifado(s)");
            } else {
                salvarItemAjax({
                    exec: 'SalvarItemObra',
                    itens: itensEnviar,
                    ano: "<?=$ano?>"
                }, retornoAjax);
            }
        } catch (e) {
            console.debug(e);
            alert(e.toString());
        }
        return false;
    }

    function NovoItem(coditem) {
        const obr06_pcmater = coditem.split("-")[0];
        const obr06_tabela = document.getElementById('obr06_tabela_' + coditem).value;
        const obr06_dtcadastro = document.getElementById('obr06_dtcadastro_' + coditem).value;
        const obr06_ordem = document.getElementById('obr06_ordem_' + coditem).value;

        let obr06_descricaotabela = null;
        let obr06_codigotabela = null;
        let obr06_versaotabela = null;

        if (obr06_tabela !== "4") {
            obr06_codigotabela = document.getElementById('obr06_codigotabela_' + coditem).value;
        }

        if ((obr06_tabela === "1" || obr06_tabela === "2")) {
            obr06_versaotabela = document.getElementById('obr06_versaotabela_' + coditem).value;
        }

        if (obr06_tabela === "3") {
            obr06_versaotabela = document.getElementById('obr06_versaotabela_' + coditem).value;
            obr06_descricaotabela = document.getElementById('obr06_descricaotabela_' + coditem).value;
        }

        return {
            obr06_pcmater,
            obr06_tabela,
            obr06_descricaotabela,
            obr06_codigotabela,
            obr06_versaotabela,
            obr06_dtcadastro,
            obr06_ordem
        }
    }

    function salvarItemAjax(params, onComplete) {
        js_divCarregando('Aguarde salvando', 'div_aguarde');
        var request = new Ajax.Request('obr1_obras.RPC.php', {
            method: 'post',
            parameters: 'json=' + JSON.stringify(params),
            onComplete: function(res) {
                js_removeObj('div_aguarde');
                onComplete(res);
            }
        });
    }

    function retornoAjax(res) {
        var response = JSON.parse(res.responseText);
        if (response.status == 2) {
            alert(response.message.urlDecode());
        } else {
            alert("Item salvo com sucesso!");
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Select all checkboxes with the name 'aItonsMarcados'
        var checkboxes = document.querySelectorAll('input[name="aItonsMarcados"]');

        // Iterate over them
        checkboxes.forEach(function(checkbox) {
            // Add a change event listener to each checkbox
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    mostraOcultaCamposEdicaoEmBloco();
                }
            });
        });
    });

    function mostraOcultaCamposEdicaoEmBloco() {
        const tipoTabela = document.getElementById("obr06_tabela").value;

        const td_obr06_versaotabela = document.getElementById("td_obr06_versaotabela");
        const tr_obr06_descricaotabela = document.getElementById("tr_obr06_descricaotabela");
        const td_obr06_codigotabela = document.getElementById("td_obr06_codigotabela");

        // Oculta todos
        td_obr06_versaotabela.style.display = 'none';
        tr_obr06_descricaotabela.style.display = 'none';
        td_obr06_codigotabela.style.display = 'none';

        // Se tabela for igual 1 e 2
        if (tipoTabela === "1" || tipoTabela === "2") {
            td_obr06_versaotabela.style.display = '';
            return;
        }

        // Se a tabela for igual a 3
        if (tipoTabela === "3") {
            td_obr06_versaotabela.style.display = '';
            tr_obr06_descricaotabela.style.display = '';
            return;
        }
    }

    function habilitaDesabilitaTabela(value, campo) {
        let tipoTabela;
        let versaoTabela;
        let descricaoTabela;

        if (campo) {
            tipoTabela = document.getElementById('obr06_tabela_' + campo).value;
            versaoTabela = document.getElementById("obr06_versaotabela_" + campo);
            descricaoTabela = document.getElementById("obr06_descricaotabela_" + campo);
            codigoTabela = document.getElementById("obr06_codigotabela_" + campo);
        } else {
            tipoTabela = document.getElementById("obr06_tabela").value;
            versaoTabela = document.getElementById("obr06_versaotabela");
            descricaoTabela = document.getElementById("obr06_descricaotabela");
            codigoTabela = document.getElementById("obr06_codigotabela");

            versaoTabela.value = '';
            descricaoTabela.value = '';
        }

        versaoTabela.disabled = true;
        versaoTabela.style.backgroundColor = '#E6E4F1';

        descricaoTabela.disabled = true;
        descricaoTabela.style.backgroundColor = '#E6E4F1';

        codigoTabela.disabled = true;
        codigoTabela.style.backgroundColor = '#E6E4F1';

        const option = parseInt(campo ? tipoTabela : value);

        switch (option) {
            case 1:
            case 2:
                // Se 1 - Tabela SINAP ou 2 - Tabela SICRO somente habilitar o campo "Versão da Tabela"
                versaoTabela.disabled = false;
                versaoTabela.style.backgroundColor = '#FFFFFF';

                codigoTabela.disabled = false;
                codigoTabela.style.backgroundColor = '#FFFFFF';
                break;
            case 3:
                // Se 3 - Outras Tabelas Oficiais somente os campos "Versão da Tabela" e "Descrição da Tabela"
                versaoTabela.disabled = false;
                versaoTabela.style.backgroundColor = '#FFFFFF';

                descricaoTabela.disabled = false;
                descricaoTabela.style.backgroundColor = '#FFFFFF';

                codigoTabela.disabled = false;
                codigoTabela.style.backgroundColor = '#FFFFFF';
                break;
            default:
                // Se 4 - Cadastro Próprio desabilitar todos os campos
                break;
        }
    }


    function js_validatabela(value) {
        habilitaDesabilitaTabela(value);
        //aplicaTabelaNosCampos(value);
        mostraOcultaCamposEdicaoEmBloco();
    }

    function aplicaTabelaNosCampos(value) {
        aItens().forEach(function(item) {
            if (item.checked === true) {
                habilitaDesabilitaTabela(value, item.id);
            }
        })
    }

    function js_validatabelaLinha(value) {
        let campo = value.substring(13);

        let tipotabela = document.getElementById('obr06_tabela_' + campo).value;

        habilitaDesabilitaTabela(tipotabela, campo);
    }

    /**
     * Excluir Itens
     */

    function js_excluirItensObra() {
        let itens = getItensMarcados();

        if (itens.length < 1) {
            alert('Selecione pelo menos um item da lista.');
            return false;
        }

        var itensEnviar = [];

        try {
            itens.forEach(function(item) {
                let coditem = item.id;

                var novoItem = {
                    obr06_pcmater: coditem.split("-")[0],
                    obr06_ordem: document.getElementById('obr06_ordem_' + coditem).value,
                };
                
                itensEnviar.push(novoItem);
            });
            excluirItemAjax({
                exec: 'ExcluirItemObra',
                ano: "<?= $ano ?>",
                itens: itensEnviar,
            }, retornoexclusaoAjax);
        } catch (e) {
            alert(e.toString());
        }
        return false;
    }

    function excluirItemAjax(params, callback) {
        js_divCarregando('Aguarde Excluindo', 'div_aguarde');
        var request = new Ajax.Request('obr1_obras.RPC.php', {
            method: 'post',
            parameters: 'json=' + JSON.stringify(params),
            onComplete: function(res) {
                js_removeObj('div_aguarde');
                callback(res);
            }
        });
    }

    function retornoexclusaoAjax(res) {
        var response = JSON.parse(res.responseText);
        if (response.status != 1) {
            alert(response.message);
        } else {
            response.itens.forEach(function(item, x) {
                document.getElementById('obr06_tabela_' + item).value = 0;
                document.getElementById('obr06_versaotabela_' + item).value = "";
                document.getElementById('obr06_descricaotabela_' + item).value = "";
                document.getElementById('obr06_dtcadastro_' + item).value = "";
                document.getElementById('obr06_codigotabela_' + item).value = "";
            })
            alert("Item Excluido com sucesso!")
        }
    }

    function excluirLinha(codigo) {
        var itensEnviar = [];
        try {
            var novoItem = {
                obr06_pcmater: codigo.split("-")[0],
                obr06_ordem: document.getElementById('obr06_ordem_' + codigo).value,
            };
            itensEnviar.push(novoItem);
            excluirlinhaAjax({
                exec: 'ExcluirItemObra',
                ano: "<?= $ano ?>",
                itens: itensEnviar,
            }, retornoexclusaolinhaAjax);
        } catch (e) {
            alert(e.toString());
        }
        return false;
    }

    function excluirlinhaAjax(params, callback) {
        js_divCarregando('Aguarde Excluindo', 'div_aguarde');
        var request = new Ajax.Request('obr1_obras.RPC.php', {
            method: 'post',
            parameters: 'json=' + JSON.stringify(params),
            onComplete: function(res) {
                js_removeObj('div_aguarde');
                callback(res);
            }
        });
    }

    function retornoexclusaolinhaAjax(res) {
        var response = JSON.parse(res.responseText);
        if (response.status != 1) {
            alert(response.message);
        } else {
            response.itens.forEach(function(item, x) {
                document.getElementById('obr06_tabela_' + item).value = 0;
                document.getElementById('obr06_versaotabela_' + item).value = "";
                document.getElementById('obr06_descricaotabela_' + item).value = "";
                document.getElementById('obr06_dtcadastro_' + item).value = "";
                document.getElementById('obr06_codigotabela_' + item).value = "";
            })
            alert("Item Excluido com sucesso!")
        }
    }
</script>