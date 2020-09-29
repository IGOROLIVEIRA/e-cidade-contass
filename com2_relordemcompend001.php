<?php
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

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("dbforms/db_funcoes.php");
include("classes/db_matordem_classe.php");
include("classes/db_empparametro_classe.php");

$clmatordem     = new cl_matordem;
$clempparametro = new cl_empparametro;
$iAnoUsu        = db_getsession("DB_anousu");

$sSqlEmpParam   = $clempparametro->sql_query_file ($iAnoUsu,$campos="e30_prazoentordcompra",null,"");
$rsEmpParam     = $clempparametro->sql_record($sSqlEmpParam);
$iDiasPrazo     = db_utils::fieldsMemory($rsEmpParam, 0)->e30_prazoentordcompra;
?>
<html>
    <head>
        <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
        <meta http-equiv="Expires" CONTENT="0">
        <?php
            db_app::load("scripts.js, strings.js, prototype.js");
            db_app::load("estilos.css, grid.style.css");
        ?>
    </head>
    
    <body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
        <table align="center" width="30%">
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>
                    <form name="form1" method="post" action="">
                        <fieldset class="fildset-principal">
                            <legend>
                                <b>Ordens de compra pendentes de entrada</b>
                            </legend>
                            
                            <table align="left" border="0" class="table-campos">
                                <tr>
                                    <td  align="left" nowrap title="<?=$Tz01_numcgm?>">
                                        <?db_ancora("Fornecedor","js_pesquisa_cgm(true);",1);?>
                                    </td>
                                    <td align="left" nowrap>
                                        <?
                                        db_input("m51_numcgm",10,$Iz01_numcgm,true,"text",4,"onchange='js_pesquisa_cgm(false);'");
                                        db_input("z01_nome",38,"",true,"text",3);
                                        ?>

                                    </td>
                                </tr>
                                <tr>
                                    <td nowrap>
                                        <b>Filtrar por:</b>
                                    </td>
                                    <td>
                                        <select name="lFiltro" id="lFiltro">
                                            <option value="t">Pendentes há mais de <?= $iDiasPrazo ?> dias</option>
                                            <option value="f">Todas</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td nowrap>
                                        <b>Quebra por fornecedor:</b>
                                    </td>
                                    <td>
                                        <select name="lQuebra" id="lQuebra">
                                            <option value="t">SIM</option>
                                            <option value="f" selected>NÃO</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </fieldset>
                        <table align="center">
                            <tr>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2" align = "center">
                                    <input  name="emite" id="emite" type="button" value="Imprimir" onclick="js_emite();" >
                                </td>
                            </tr>
                        </table>
                    </form>
                </td>
            </tr>
        </table>
        <?php
            db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
        ?>
    </body>
</html>
<script>

    function js_pesquisa_cgm(mostra){
        
        if(mostra==true){
            js_OpenJanelaIframe('top.corpo','db_iframe_cgm','func_cgm_empenho.php?funcao_js=parent.js_mostracgm1|e60_numcgm|z01_nome','Pesquisa',true);
        }else{
            if(document.form1.m51_numcgm.value != ''){
                js_OpenJanelaIframe('top.corpo','db_iframe_cgm','func_cgm_empenho.php?pesquisa_chave='+document.form1.m51_numcgm.value+'&funcao_js=parent.js_mostracgm','Pesquisa',false);
            }else{
                document.form1.z01_nome.value = '';
            }
        }
        
    }
        
    function js_mostracgm(chave,erro){

        document.form1.z01_nome.value = chave;
        
        if(erro==true){
            document.form1.z01_nome.value = '';
            document.form1.m51_numcgm.focus();
        }
    
    }
    
    function js_mostracgm1(chave1,chave2){
        
        document.form1.m51_numcgm.value = chave1;
        document.form1.z01_nome.value = chave2;
        db_iframe_cgm.hide();
        
    }
    
    function js_emite() {

        var lFiltro = $("lFiltro").value;
        var lQuebra = $("lQuebra").value;
        var iCgm    = $("m51_numcgm").value;
        var sQuery  = '';

        sQuery += '?lFiltro='+lFiltro;
        sQuery += '&iDiasPrazo='+<?= $iDiasPrazo ?>;
        sQuery += '&lQuebra='+lQuebra;
        sQuery += '&iCgm='+iCgm;

        sUrl = 'com2_relordemcompend002.php';

        jan = window.open(sUrl+sQuery,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0');

        jan.moveTo(0,0);

    }
</script>