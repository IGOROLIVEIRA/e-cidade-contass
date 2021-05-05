<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2012  DBselller Servicos de Informatica
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

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_saltes_classe.php");

db_postmemory($HTTP_POST_VARS);
db_postmemory($HTTP_GET_VARS);
$db_opcao = 1;
$db_botao = true;
$clsaltes = new cl_saltes;

?>
<html>
    <head>
        <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
        <script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
        <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
        <script language="JavaScript" type="text/javascript" src="scripts/AjaxRequest.js"></script>
        <link href="estilos.css" rel="stylesheet" type="text/css">
    </head>
    <body style="background-color: #CCCCCC;" >
        <div class="container">
			<form name="form1" method="post" action="">
                <?
                                                db_input('k173_conta',70,$conta,true,'text',3,'');
                                            ?>
                <fieldset style="margin-top: 20px; width: 750px;">
                    <legend><b>Lançamento de pendencia</b></legend>
                    <table width="100%">
                        <tr>
                            <td  valign="top">
                                <fieldset >
                                    <table border="0" width="100%">
                                        <tr>
                                            <td><b>Tipo de Lançamento:</b></td>
                                            <td align="left" colspan="4">
                                            <?
                                                $tipo_lancamento = array("Selecione", "IMPLANTAÇÃO", "PENDÊNCIA");
                                                db_select("tipo_lancamento", $tipo_lancamento, true, 1, "style='width:100%'");
                                            ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Movimento:</b></td>
                                            <td align="left">
                                            <?
                                                $tipo_movimento = array("0" => "Selecione", "E" => "Entrada", "S" => "Saída");
                                                db_select("tipo_movimento", $tipo_movimento, true, 1, "style='width:100%'");
                                            ?>
                                            </td>
                                            <td><b>Tipo de Movimento:</b></td>
                                            <td align="left" >
                                            <?
                                                $tipo_lancamento = array("Selecione", "PGTO. EMPENHO", "EST. PGTO EMPENHO", "REC. ORÇAMENTÁRIA",
                                                        "EST. REC. ORÇAMENTÁRIA", "PGTO EXTRA ORÇAMENTÁRIO", "EST. PGTO EXTRA ORÇAMENTÁRIO",
                                                        "REC. EXTRA ORÇAMENTÁRIA", "EST. REC. EXTRA ORÇAMENTÁRIA", "PERDAS", "ESTORNO PERDAS",
                                                        "TRANSFERÊNCIA", "EST. TRANSFERÊNCIA");
                                                db_select("tipo_lancamento", $tipo_lancamento, true, 1, "style='width:100%'");
                                            ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td nowrap title="<?=@$Tz01_numcgm?>">
                                            <?
                                                db_ancora("<b>Credor:</b>","js_pesquisaz01_numcgm(true);",$db_opcao);
                                            ?>
                                            </td>
                                            <td  nowrap>
                                            <?
                                                db_input('z01_numcgm',25,$Iz01_numcgm,true,'text',$db_opcao," onchange='js_pesquisaz01_numcgm(false);'");
                                                ?>
                                            </td>
                                            <td colspan="2">
                                                <?
                                                db_input('z01_nome',70,$Iz01_nome,true,'text',3,'');
                                            ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>OP/REC/SLIP:</b></td>
                                            <td nowrap>
                                                <? db_input('op',25, $conta ,true,'text',1,''); ?>
                                            </td>
                                            <td><b>Doc. Extrato:</b></td>
                                            <td nowrap align="">
                                                <? db_input('op',50,$Iz01_nome,true,'text',1,''); ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Data Lançamento:</b></td>
                                            <td nowrap>
                                                <? db_inputdata("data_inicial", 25, null, null, true, "text", 1, "onchange='js_verifica_campos(); style='width:100%'"); ?>
                                            </td>
                                        </tr>


                                            <tr>

                                                <td><b>Valor:</b></td>
                                                <td align="left">
                                                    <? db_input("saldo_final_extrato", 25, null, null, true, "text", 1); ?>
                                                </td>
                                            </tr>
                                            <td colspan="4">
      <fieldset>
        <legend><strong>Observação</strong></legend>
          <textarea title="Observação

Campo:k81_obs                                 " name="k81_obs" type="text" id="k81_obs" rows="1" cols="40" onblur=" js_ValidaMaiusculo(this,'f',event); " onkeyup=" js_ValidaCampos(this,0,'Observação','t','f',event); " oninput="" style="background-color:#E6E4F1;width:100%" autocomplete="off"></textarea>
      </fieldset>
    </td>
                                        </table>
                                    </fieldset>
                                </td>


                            </tr>
                             <tr>
                <td colspan='4' style='text-align: center'>

                        <input name="salvar" id='salvar' type="button"  value="Salvar"/>
                        <input name="voltar" id='voltar' type="button"  value="Voltar"/>

                </td>
            </tr>
                        </table>
                    </fieldset>
                </td>
            </tr>

        </table>
</form>
</div>
	</body>
</html>
<script>
    sDataDia = "<?=date("d/m/Y",db_getsession("DB_datausu"))?>";
    function js_pesquisaz01_numcgm(mostra){
        if(mostra==true){
            js_OpenJanelaIframe('',
                'func_nome',
                'func_nome.php?funcao_js=parent.js_mostracgm1|z01_numcgm|z01_nome',
                'Pesquisar CGM',
                true,
                22,
                0,
                document.body.getWidth() - 12,
                document.body.scrollHeight - 30);
        }else{
            if(document.form1.z01_numcgm.value != ''){

                js_OpenJanelaIframe('',
                    'func_nome',
                    'func_nome.php?pesquisa_chave='+document.form1.z01_numcgm.value+
                    '&funcao_js=parent.js_mostracgm',
                    'Pesquisar CGM',
                    false,
                    22,
                    0,
                    document.width-12,
                    document.body.scrollHeight-30);
            }else{
                document.form1.z01_nome.value = '';
            }
        }
    }
    function js_mostracgm(erro,chave){
        document.form1.z01_nome.value = chave;
        if(erro==true){
            document.form1.z01_numcgm.focus();
            document.form1.z01_numcgm.value = '';
        }
    }
        function js_mostracgm1(chave1,chave2){

        document.form1.z01_numcgm.value = chave1;
        document.form1.z01_nome.value   = chave2;
        func_nome.hide();

    }
</script>
