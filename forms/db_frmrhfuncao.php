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

//MODULO: pessoal
$clrhfuncao->rotulo->label();

if ($db_opcao == 2) {
    $sTituloFormulario = "Alteração";
} else if ($db_opcao == 3) {
    $sTituloFormulario = "Exclusão";
} else {
    $sTituloFormulario = "Cadastro";
}
?>
<form name="form1" method="post" action="">
    <center>
        <fieldset style="width: 500px;">
            <legend style="font-weight: bold;">&nbsp;<?=$sTituloFormulario;?> de Cargos&nbsp;</legend>
            <table width="100%">
                <tr>
                    <td width="100" nowrap title="<?=@$Trh37_funcao?>"><?=@$Lrh37_funcao?></td>
                    <td>
                        <?
                        db_input('rh37_funcao', 10, $Irh37_funcao, true, 'text', $db_opcao, "")
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?=@$Trh37_descr?>"><?=@$Lrh37_descr?></td>
                    <td>
                        <?
                        db_input('rh37_descr', 44, $Irh37_descr, true, 'text', $db_opcao,"")
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?=@$Trh37_funcaogrupo?>">
                        <?
                        db_ancora($Lrh37_funcaogrupo,'js_buscagrupo(true);',1);
                        ?>
                    </td>
                    <td>
                        <?
                        db_input('rh37_funcaogrupo'     , 10, $Irh37_funcaogrupo, true, 'text', $db_opcao, "onchange='js_buscagrupo(false);'");
                        db_input('rh37_funcaogrupodescr', 30, '', true, 'text', 3, '');
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?=@$Trh37_vagas?>"><?=@$Lrh37_vagas?></td>
                    <td>
                        <?
                        db_input('rh37_vagas', 10, $Irh37_vagas, true, 'text', $db_opcao, "")
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?=@$Trh37_cbo?>"><?=@$Lrh37_cbo?></td>
                    <td>
                        <?
                        db_input('rh37_cbo', 10, $Irh37_cbo, true, 'text', $db_opcao, "")
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?=@$Trh37_class?>"><?=@$Lrh37_class?></td>
                    <td>
                        <?
                        db_input('rh37_class', 10, $Irh37_class, true, 'text', $db_opcao, "");
                        ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="Requisito do Cargo"><b>Requisito do Cargo: </b></td>
                    <td>
                        <?
                        $areqCargo = array("1"=>"Nível superior completo ou nível médio com especialização (Ex: Magistrados, Técnicos em Contabilidade, etc)",
                            "2"=>"Profissão regulamentada privativa de profissionais de saúde (Ex: Médicos, Assistentes Sociais, Técnicos em Enfermagem etc)",
                            "3"=>"Professor",
                            "4"=>"Outras",
                            "5"=>"Agente Policico");
                        db_select('rh37_reqcargo', $areqCargo, true, $db_opcao,"onchange='js_showOutros(value);js_verificacargo(value)'");
                        ?>
                    </td>
                </tr>
                <tr id="trexerceratividade" style="display:<?= $db_opcao == 2 ? 'table-row' : 'none' ?>;">
                    <td>
                        <strong>Professor exerce suas atividades em sala de aula?</strong>
                    </td>
                    <td>
                        <?
                        $sTipo = array(
                                ""  => "Selecione",
                                "t" => "Sim",
                                "f" => "Não"
                        );
                        db_select('rh37_exerceatividade', $sTipo, true, $db_opcao,"onchange=''");
                        ?>
                    </td>
                </tr>
            </table>
            <table>
      <tr id="atividadedocargo" style="display:<?= $db_opcao == 2 ? 'table-row' : '' ?>;">
                    <td nowrap title="Atividade do cargo"><b>Escolaridade do cargo: </b></td>
                    <td>
                        <?
                        db_textarea('rh37_atividadedocargo',5,60,$Irh37_atividadedocargo,true,'text',$db_opcao,"","","","150");
                        ?>
                    </td>
                </tr>
            </table>

            <table>
                <tr>
                    <td nowrap title="<?=@$Trh37_ativo?>"><?=@$Lrh37_ativo?></td>
                    <td>
                        <?
                        $aAtivo = array("t"=>"Sim","f"=>"Não");
                        db_select('rh37_ativo', $aAtivo, true, $db_opcao,"");
                        ?>
                    </td>
                </tr>
                <fieldset>
                    <legend style="font-weight: bold;">&nbsp;Lei&nbsp;</legend>
                    <?
                    db_textarea('rh37_lei',5,60,$Irh37_lei,true,'text',$db_opcao,"");
                    ?>
                </fieldset>

            </table>
        </fieldset>
    </center>
    <br />
    <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" <?=($db_botao==false?"disabled":"")?>" >
    <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisa();">
</form>

<script>

    <?
    if($db_opcao==1){
        echo "CurrentWindow.corpo.document.form1.rh37_reqcargo.value='4'";
    }
    ?>

    function js_showOutros(value) {

        if (value == 4) {
            document.getElementById('atividadedocargo').style.display = '';
            document.getElementById('trexerceratividade').style.display = 'none';
            document.getElementById('rh37_exerceatividade').value = 0;

        } else {
            document.getElementById('atividadedocargo').style.display = 'none';
        }
    }
    js_showOutros(document.getElementById('rh37_reqcargo').value);

    function js_buscagrupo(mostra) {
        if(mostra==true){
            var sUrlOpen = 'func_rhfuncaogrupo.php?funcao_js=parent.js_preencheGrupo|rh100_sequencial|rh100_descricao';
            js_OpenJanelaIframe('CurrentWindow.corpo', 'db_iframe_rhfuncao', sUrlOpen, 'Pesquisa', true);
        }else{
            if(document.form1.rh37_funcaogrupo.value != ''){
                var iFuncaoGrupo  = document.form1.rh37_funcaogrupo.value;
                var sUrlOpenGrupo = 'func_rhfuncaogrupo.php?pesquisa_chave='+iFuncaoGrupo+'&funcao_js=parent.js_mostrargrupos';
                js_OpenJanelaIframe('CurrentWindow.corpo', 'db_iframe_rhfuncao', sUrlOpenGrupo, 'Pesquisa', false);
            }else{
                document.form1.rh37_funcaogrupodescr.value = '';
            }
        }
    }

    function js_mostrargrupos(chave,erro) {
        document.form1.rh37_funcaogrupodescr.value   = chave;
        if (erro==true) {
            document.form1.rh37_funcaogrupo.focus();
            document.form1.rh37_funcaogrupo.value = '';
        }
    }

    function js_preencheGrupo(chave, descricao) {
        document.form1.rh37_funcaogrupo.value      = chave;
        document.form1.rh37_funcaogrupodescr.value = descricao;
        db_iframe_rhfuncao.hide();
    }


    function js_pesquisa(){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_rhfuncao','func_rhfuncao.php?funcao_js=parent.js_preenchepesquisa|rh37_funcao','Pesquisa',true);
    }
    function js_preenchepesquisa(chave){
        db_iframe_rhfuncao.hide();
        <?
        if($db_opcao!=1){
            echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
        }
        ?>
    }

    function validaCampos() {
        if (document.form1.rh37_reqcargo.value == 3) {
            if(document.getElementById('rh37_exerceatividade').value == "") {
                alert("O campo Atividade do cargo é obrigatório");
                return false;
            }
        }

        return true;
    }

    function js_verificacargo(value) {
        if (value == 3){
            document.getElementById('trexerceratividade').style.display = ''
        }else{
            document.getElementById('trexerceratividade').style.display = 'none'
        }
    }
</script>
