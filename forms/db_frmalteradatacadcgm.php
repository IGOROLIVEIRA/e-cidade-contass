<?php
/*
  *     E-cidade Software Publico para Gestao Municipal
  *  Copyright (C) 2014  DBseller Servicos de Informatica
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

require_once("classes/db_cgm_classe.php");
$clcgm = new cl_cgm;
$clcgm->rotulo->label();

?>

<form name="form1" method="post" action="">
    <table width="590" border="0" cellspacing="0" cellpadding="0">
        <tr align="center" valign="top">
            <td>
                <fieldset>
                    <legend><b>AlteraÁ„o de Data de Cadastro de CGM</b></legend>

                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td align="left" nowrap title="<?= $Tz01_numcgm ?>">
								<?
								db_ancora('CGM:', "js_pesquisaz09_numcgm(true);", 1);
								?>
                            </td>
                            <td align="left" nowrap>
								<?
								db_input("z09_numcgm", 10, $Iz01_numcgm, true, "text", 3, "onchange='js_pesquisaz09_numcgm(false);'");
								db_input("z01_nome", 45, $Iz01_nome, true, "text", 3);
								?>
                            </td>
                        </tr>
                        <tr></tr>
                        <tr>
                            <td align="left" nowrap="">
                                <b>Data de Cadastro:</b>
                            </td>
                            <td align="left" nowrap="">
								<?php
								db_inputdata("z09_datacadastro", '', '', '', true, 'text', $db_opcao);
								?>
                            </td>
                        </tr>
                        <tr></tr>
                        <tr>
                            <td align="left">
                                <b>Motivo da AlteraÁ„o: </b>
                            </td>
                            <td align="left">
								<?php
								db_textarea('z09_motivo', 3, 56, 'z09_motivo', true, 'text', $db_opcao, "onKeyUp='js_changeMotivo(this.value);'")
								?>
                            </td>
                        </tr>
                    </table>
                </fieldset>
                <input name="incluir" type="submit" value="Incluir" id="db_opcao" ">
            </td>
        </tr>
    </table>
</form>

<?php
db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit"));
?>
<script type="text/javascript">

    function js_pesquisaz09_numcgm(mostra) {
        js_OpenJanelaIframe('top.corpo', 'func_nome', 'func_nome.php?funcao_js=parent.js_mostranumcgm|z01_numcgm|z01_nome', 'Pesquisa', true);
    }

    function js_mostranumcgm(chave1, chave2) {
        js_buscaz09_cadast(chave1);
        document.form1.z09_numcgm.value = chave1;
        document.form1.z01_nome.value = chave2;
        func_nome.hide();
    }

    function js_buscaz09_cadast(numcgm){
        let oParam  = new Object();
        oParam.exec = 'getDataCadCGM';
        oParam.numcgm = numcgm;

        let oAjax      = new Ajax.Request('prot1_cadgeralmunic.RPC.php',
            {method:'post',
                parameters:'json='+Object.toJSON(oParam),
                onComplete: res => {
                    let response = JSON.parse(res.responseText);
                    document.form1.z09_datacadastro.value = js_formatar(response.z09_cadastro, 'd');
                }
            }
        )
    }

    function js_limpaCampos(){
        document.form1.z09_numcgm.value = '';
        document.form1.z01_nome.value = '';
        document.form1.z09_datacadastro.value = '';
        document.form1.z09_motivo.value = '';
    }

    function js_changeMotivo(motivo){
        let novaString = '';
        novaString = motivo.replace(/[¿¡¬√ƒ≈]/g, "A");
        novaString = novaString.replace(/[‡·‚„‰Â]/g, "a");
        novaString = novaString.replace(/[»… À?]/g, "E");
        novaString = novaString.replace(/[ËÈÍÎ?]/g, "e");
        novaString = novaString.replace(/[ÃÕŒœ?]/g, "I");
        novaString = novaString.replace(/[ÏÌÓÔÓ]/g, "i");
        novaString = novaString.replace(/[“‘’÷”’]/g, "O");
        novaString = novaString.replace(/[ÚÛÙˆı]/g, "o");
        novaString = novaString.replace(/[⁄€?‹⁄]/g, "U");
        novaString = novaString.replace(/[˘˙˚¸?]/g, "u");
        novaString = novaString.replace(/[Á]/g, "c");
        novaString = novaString.replace(/[«]/g, "C");
        let stringFinal = novaString.replace(/[^a-z0-9 ]/gi,'');
        document.form1.z09_motivo.value = stringFinal.toUpperCase();
    }

</script>
