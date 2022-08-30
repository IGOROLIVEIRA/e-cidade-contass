<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2009  DBselller Servicos de Informatica             
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
?>
<form name="form1" method="post" action="">
    <fieldset>
        <legend><b>Cadastro de Agentes Arrecadadores</b></legend>
        <table border="0" width="700">
            <tr>
                <td nowrap title="Sequencial"><b>Sequencial:</b></td>
                <td>
                    <?
                    db_input('k174_sequencial', 10, $Ik174_sequencial, true, 'text', 3, "", "", "", "", 3);
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="Código do Banco"><b>Código do Banco:</b></td>
                <td>
                    <?
                    db_input('k174_codigobanco', 10, $Ik174_codigobanco, true, 'text', $db_opcao, "", "", "", "", 3);
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="Descrição de Banco"><b>Descrição de Banco:</b></td>
                <td>
                    <?
                    db_input('k174_descricao', 65, $k174_descricao, true, 'text', $db_opcao, "", "", "", "", 100);
                    ?>
                </td>
            </tr>
            <tr>
                <td nowrap title="Conta Bancária">
                    <?
                    db_ancora("Conta Bancária:", "js_pesquisaConta(true);", $db_opcao);
                    ?>
                </td>
                <td colspan='3'>
                    <?
                    db_input('k174_idcontabancaria', 10, $Ik174_idcontabancaria, true, 'text', $db_opcao, "onchange='js_pesquisaConta(false);'");
                    db_input('k13_descr', 50, $Ik13_descr, true, 'text', 3);
                    ?>
                </td>
            </tr>
            <!-- CGM -->
            <tr>
                <td nowrap title="CGM">
                    <? db_ancora("CGM", "js_pesquisaCgm(true);", $db_opcao); ?>
                </td>
                <td colspan='3'>
                    <?
                    db_input('k174_numcgm', 10, $Ik174_numcgm, true, 'text', 2, "onchange='js_pesquisaCgm(false);'");
                    db_input('z01_nome', 50, $Iz01_nome, true, 'text', 3);
                    ?>
                </td>
            </tr>
        </table>
    </fieldset>
    <br>
    <center>
        <input name="<?= ($db_opcao == 1 ? "incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "alterar" : "excluir")) ?>" type="submit" id="db_opcao" value="<?= ($db_opcao == 1 ? "Incluir" : ($db_opcao == 2 || $db_opcao == 22 ? "Alterar" : "Excluir")) ?>" <?= ($db_botao == false ? "disabled" : "") ?>>
        <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();">
    </center>
</form>
<script>
    function js_pesquisaConta(lMostra) {

        var sFuncao = 'funcao_js=parent.js_mostraSaltes|k13_conta|k13_descr';
        var sPesquisa = 'func_saltesrecurso.php?recurso=0&' + sFuncao + '&data_limite=<?= date("Y-m-d", db_getsession("DB_datausu")) ?>'

        if (!lMostra) {
            if ($F('k174_idcontabancaria') == '') {
                $('k13_descr').value = '';
            } else {
                sFuncao = 'funcao_js=parent.js_preencheSaltes';
                sPesquisa = 'func_saltesrecurso.php?pesquisa_chave=' + $('k174_idcontabancaria').value + '&' + sFuncao + '&data_limite=<?= date("Y-m-d", db_getsession("DB_datausu")) ?>'
            }
        }

        js_OpenJanelaIframe('top.corpo', 'db_iframe_saltes', sPesquisa + '&data_limite=<?= date("Y-m-d", db_getsession("DB_datausu")) ?>', 'Pesquisa', lMostra);
    }

    function js_mostraSaltes(iCodigoConta, sDescricao) {
        $('k174_idcontabancaria').value = iCodigoConta;
        $('k13_descr').value = sDescricao;
        db_iframe_saltes.hide();
    }

    function js_preencheSaltes(iCodigoConta, sDescricao, lErro) {
        $('k174_idcontabancaria').value = iCodigoConta;
        $('k13_descr').value = sDescricao;
    }

    function js_pesquisa() {
        js_OpenJanelaIframe('top.corpo', 'db_iframe_agentearrecadador', 'func_agentearrecadador.php?funcao_js=parent.js_preenchepesquisa|k174_sequencial', 'Pesquisa', true);
    }

    function js_preenchepesquisa(chave) {
        db_iframe_agentearrecadador.hide();
        <?
        if ($db_opcao != 1) {
            echo " location.href = '" . basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]) . "?chavepesquisa='+chave";
        }
        ?>
    }

    /**
     * Pesquisa CGM
     */
    function js_pesquisaCgm(lMostra) {

        if (lMostra == true) {
            js_OpenJanelaIframe('top.corpo', 'db_iframe_cgm', 'func_nome.php?funcao_js=parent.js_mostraCgm|z01_numcgm|z01_nome', 'Pesquisa', true);
        } else {
            js_OpenJanelaIframe('top.corpo', 'db_iframe_cgm', 'func_nome.php?pesquisa_chave=' + $('k174_numcgm').value + '&funcao_js=parent.js_preencheCgm', 'Pesquisa', false);
        }
    }

    function js_mostraCgm(iCodigoCgm, sDescricao) {

        $('k174_numcgm').value = iCodigoCgm;
        $('z01_nome').value = sDescricao;
        db_iframe_cgm.hide();
    }

    function js_preencheCgm(lErro, sDescricao) {

        $('z01_nome').value = sDescricao;

        if (lErro) {
            $('k174_numcgm').focus();
            $('k174_numcgm').value = '';
            $('z01_nome').value = sDescricao;
        }
    }
</script>