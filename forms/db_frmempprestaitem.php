<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2013  DBselller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

//MODULO: empenho
include("dbforms/db_classesgenericas.php");
$cliframe_alterar_excluir = new cl_iframe_alterar_excluir;
$clempprestaitem->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("e45_tipo");
$clrotulo->label("nome");
$clrotulo->label("e60_codemp");
$clrotulo->label("e45_codmov");
$clrotulo->label("pc01_codmater");
$clrotulo->label("pc01_descrmater");

if (isset($tranca)) {
    $db_opcao = 33;
    $db_botao = false;
} elseif (isset($db_opcaoal)) {
    $db_opcao = 33;
    $db_botao = false;
} else if (isset($opcao) && $opcao == "alterar") {
    $db_botao = true;
    $db_opcao = 2;
} else if (isset($opcao) && $opcao == "excluir") {
    $db_opcao = 3;
    $db_botao = true;
} else {
    $db_opcao = 1;
    $db_botao = true;
    if (isset($novo) || isset($alterar) || isset($excluir) || (isset($incluir) && $sqlerro == false)) {
        $e46_codigo = "";
        $e46_valor = "";
        $e46_descr = "";
        $e46_id_usuario = "";
        $e46_cnpj = "";
        $e46_cpf = "";
        $e46_nome = "";
        $e46_obs = "";
        $e46_codmater = "";
        $pc01_descrmater = "";
        $e46_valorunit = "";
        $e46_desconto = "";
        $e46_quantidade = "";
    }
}
?>
<form name="form1" method="post" action="">
    <center>
        <fieldset style="width: 500px">
            <legend><b>Cadastro de Itens</b></legend>
            <table border="0">
                <tr>
                    <td nowrap title="<?= @$Te60_codemp ?>">
                        <?= $Le60_codemp ?>
                    </td>
                    <td>
                        <?
                        db_input('e60_codemp', 10, $Ie60_codemp, true, 'text', 3);

                        db_input('e46_numemp', 10, $Ie46_numemp, true, 'hidden', 1);
                        db_input('e46_codigo', 10, $Ie46_codigo, true, 'hidden', 1);
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?php echo $Te45_codmov; ?>">
                        <?php echo $Le45_codmov; ?>
                    </td>
                    <td>
                        <?php db_input('e45_codmov', 10, $Ie45_codmov, true); ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?= @$Te46_nome ?>">
                        <?= @$Le46_nome ?>
                    </td>
                    <td>
                        <?
                        db_input('e46_nome', 40, $Ie46_nome, true, 'text', $db_opcao, "")
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?= @$Te46_nota ?>">
                        <?= @$Le46_nota ?>
                    </td>
                    <td>
                        <?
                        db_input('e46_nota', 20, $Ie46_nota, true, 'text', $db_opcao, "")
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?= @$Te46_codmater ?>">
                        <?
                        db_ancora(@$Le46_codmater, "js_pesquisa(true);", $db_opcao);
                        ?>
                    </td>
                    <td>
                        <?
                        db_input('e46_codmater', 8, $Ie46_codmater, true, 'text', 1, " onchange='js_pesquisa(false);'",'','','',10)
                        ?>
                        <?
                        db_input('pc01_descrmater', 30, @$Ipc01_descrmater, true, 'text', 3, '')
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?= @$Te46_valorunit ?>">
                        <?= @$Le46_valorunit ?>
                    </td>
                    <td>
                        <?
                        db_input('e46_valorunit', 10, $Ie46_valorunit, true, 'text', $db_opcao, "onchange='js_calcula();'")
                        ?>
                        <span style="float:right;">

                        <b> Desconto:</b>
                        <? db_input('e46_desconto', 10, $Ie46_desconto, true, 'text', $db_opcao, "") ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?= @$Te46_quantidade ?>">
                        <?= @$Le46_quantidade ?>
                    </td>
                    <td>
                        <?
                        db_input('e46_quantidade', 10, $Ie46_quantidade, true, 'text', $db_opcao, "onchange='js_calcula();'")
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?= @$Te46_valor ?>">
                        <?= @$Le46_valor ?>
                    </td>
                    <td>
                        <?
                        db_input('e46_valor', 10, $Ie46_valor, true, 'text', 3, "")
                        ?>


                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?= @$Te46_cnpj ?>">
                        <?= @$Le46_cnpj ?>
                    </td>
                    <td>
                        <?
                        db_input('e46_cnpj', 18, $Ie46_cnpj, true, 'text', $db_opcao, "onkeypress='mascaraMutuario(this,cpfCnpj,14)'")
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?= @$Te46_cpf ?>">
                        <?= @$Le46_cpf ?>
                    </td>
                    <td>
                        <?
                        db_input('e46_cpf', 14, $Ie46_cpf, true, 'text', $db_opcao, "onkeypress='mascaraMutuario(this,cpfCnpj,11)'")
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?= @$Te46_obs ?>">
                        <?= @$Le46_obs ?>
                    </td>
                    <td>
                        <?
                        db_textarea('e46_obs', 2, 38, $Ie46_obs, true, 'text', $db_opcao, "")
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?= @$Te46_descr ?>" colspan="2">
                        <fieldset>
                            <legend><b><?= @$Le46_descr ?></b></legend>
                            <?
                            db_textarea('e46_descr', 5, 60, $Ie46_descr, true, 'text', $db_opcao, "")
                            ?>

                        </fieldset>
                    </td>
                </tr>
                </tr>
            </table>
        </fieldset>
        <table>
            <td colspan="2" align="center">
                <input
                    name="<?= ($db_opcao == 1 ? "incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "alterar" : "excluir")) ?>"
                    type="submit" id="db_opcao"
                    value="<?= ($db_opcao == 1 ? "Incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "Alterar" : "Excluir")) ?>" <?= ($db_botao == false ? "disabled" : "") ?> >
                <input <?= ($db_botao == false ? "disabled" : "") ?> name="novo" type="button" id="cancelar"
                                                                     value="Novo"
                                                                     onclick="js_cancelar();" <?= ($db_opcao == 1 || isset($db_opcaoal) ? "style='visibility:hidden;'" : "") ?> >
            </td>
            </tr>
        </table>
        <table>
            <tr>
                <td valign="top" align="center">
                    <?
                    $sWhere = ($tranca == "true" ? " and e46_obs = '' " : "");

                    $clemppresta->sql_record($clemppresta->sql_query_emp(null, 'e45_acerta', '', "e45_acerta is null and e45_numemp=$e46_numemp"));

                    if ($clemppresta->numrows == 0) {
                        $db_opcao = 33;
                    }
                    $chavepri = array("e46_numemp" => $e46_numemp, "e46_codigo" => @$e46_codigo);
                    $cliframe_alterar_excluir->chavepri = $chavepri;
                    $cliframe_alterar_excluir->sql = $clempprestaitem->sql_query_file(null, "*", "", "e46_emppresta=$oGet->e45_sequencial {$sWhere}");
                    $cliframe_alterar_excluir->campos = "e46_codigo,e46_nome,e46_nota,e46_codmater,e46_quantidade,e46_valor,e46_desconto,e46_cnpj,e46_cpf";
                    $cliframe_alterar_excluir->legenda = "ITENS LAN\C7ADOS";
                    $cliframe_alterar_excluir->iframe_height = "160";
                    $cliframe_alterar_excluir->iframe_width = "700";
                    $cliframe_alterar_excluir->iframe_alterar_excluir($db_opcao);
                    ?>
                </td>
            </tr>
        </table>
    </center>
    <input type="hidden" name="controlaserv" id="controlaserv" value="">
</form>
<script>
    <?php if($clempprestaitem->erro_status != 0) : ?>

    if(confirm("Deseja adicionar outro \n item a esta mesma nota?") == true){
      document.form1.e46_nota.value = '<?php echo $_POST['e46_nota']; ?>';
      document.form1.e46_nota.readOnly = true;
      document.form1.e46_nota.style.background = "#DEB887";
      document.form1.e46_nota.style.color = "#643f4a";
    } else {
      document.form1.e46_nota.value = '';
    }
    <?php endif;?>
    <?php if ($clempprestaitem->erro_status == 0 && $novo != true) : ?>
      var verifica = '<?php echo $_POST['controlaserv']; ?>';
      if (verifica == "true") {
        document.form1.e46_quantidade.disabled = true;
        document.form1.e46_quantidade.value = '1';
      }
    <?php endif;?>
    <?php if($db_opcao == 2) : ?>
      js_OpenJanelaIframe('', 'db_iframe_pcmater', 'func_pcmater.php?pesquisa_chave=' + document.form1.e46_codmater.value + '&funcao_js=parent.js_mostra', 'Pesquisa', false);
    <?php endif;?>
    function js_pesquisa(mostra) {
        if (mostra == true) {
            js_OpenJanelaIframe('', 'db_iframe_pcmater', 'func_pcmater.php?funcao_js=parent.js_mostra1|pc01_codmater|pc01_descrmater|pc01_servico', 'Pesquisa', true);
        } else {
           if (document.form1.e46_codmater.value != '') {
              js_OpenJanelaIframe('', 'db_iframe_pcmater', 'func_pcmater.php?pesquisa_chave=' + document.form1.e46_codmater.value + '&funcao_js=parent.js_mostra', 'Pesquisa', false);
           }
        }
        if (document.form1.e46_codmater.value == "") {
            document.form1.e46_descrmater.value = "";
        }
    }
    function js_mostra(nome, servico, erro) {
        document.form1.pc01_descrmater.value = nome;
        if (erro == true) {
            document.form1.e46_codmater.value = "";
            document.form1.e46_codmater.focus();
        }
        js_validaServico(servico);
    }
    function js_mostra1(cod, nome, servico) {
        document.form1.e46_codmater.value = cod;
        document.form1.pc01_descrmater.value = nome;
        db_iframe_pcmater.hide();
        js_validaServico(servico);
    }
    function js_cancelar() {
        var opcao = document.createElement("input");
        opcao.setAttribute("type", "hidden");
        opcao.setAttribute("name", "novo");
        opcao.setAttribute("value", "true");
        document.form1.appendChild(opcao);
        document.form1.e46_nota.value = "";
        document.form1.e46_quantidade.value = "";
        document.form1.submit();
    }

    function js_validaServico(serv){
        if(serv == "t"){
            document.form1.e46_quantidade.disabled = true;
            document.form1.e46_quantidade.value = '1';
            document.form1.controlaserv.value = true;
        }else{
            document.form1.e46_quantidade.disabled = false;
            <?php if ($db_opcao != 2) : ?>
              document.form1.e46_quantidade.value = '';
            <?php endif; ?>
            document.form1.controlaserv.value = false;
        }
        js_calcula();
    }

    function js_calcula(){
        var vlUn  = document.form1.e46_valorunit.value;
        var quant = document.form1.e46_quantidade.value;
        document.form1.e46_valor.value = (vlUn * quant);
    }

    // Pega o c\F3digo da movimentacao do campo na primeira aba
    document.form1.e45_codmov.value = CurrentWindow.corpo.iframe_emppresta.document.form1.e45_codmov.value;

    /**
     * Mascaras
     */

    function mascaraMutuario(o,f,l){
        v_obj=o
        v_fun=f
        v_len=l
        setTimeout('execmascara()',1)
    }

    function execmascara(){
        v_obj.value=v_fun(v_obj.value,v_len)
    }

    function cpfCnpj(v){

        //Remove tudo o que n\E3o \E9 d\EDgito
        v=v.replace(/\D/g,"")

        if (v_len > 11) { //CNPJ

            //Coloca ponto entre o segundo e o terceiro d\EDgitos
            v=v.replace(/^(\d{2})(\d)/,"$1.$2")

            //Coloca ponto entre o quinto e o sexto d\EDgitos
            v=v.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3")

            //Coloca uma barra entre o oitavo e o nono d\EDgitos
            v=v.replace(/\.(\d{3})(\d)/,".$1/$2")

            //Coloca um h\EDfen depois do bloco de quatro d\EDgitos
            v=v.replace(/(\d{4})(\d)/,"$1-$2")

        } else { //CPF

            //Coloca um ponto entre o terceiro e o quarto d\EDgitos
            v=v.replace(/(\d{3})(\d)/,"$1.$2")

            //Coloca um ponto entre o terceiro e o quarto d\EDgitos
            //de novo (para o segundo bloco de n\FAmeros)
            v=v.replace(/(\d{3})(\d)/,"$1.$2")

            //Coloca um h\EDfen entre o terceiro e o quarto d\EDgitos
            v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2")

        }

        return v

    }
</script>
