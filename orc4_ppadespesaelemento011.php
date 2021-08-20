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

/**
 *
 * @author I
 * @revision $Author: dbmatheus.felini $
 * @version $Revision: 1.3 $
 */
require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_ppaestimativa_classe.php");
require_once("libs/db_liborcamento.php");
require_once("classes/db_orcorgao_classe.php");
require_once("classes/db_orcfuncao_classe.php");
require_once("classes/db_orctiporec_classe.php");
require_once("classes/db_orcunidade_classe.php");

$clppaestimativa = new cl_ppaestimativa();
$clorcorgao      = new cl_orcorgao();
$clorcfuncao     = new cl_orcfuncao();
$clorctiporec    = new cl_orctiporec();
$clorcunidade    = new cl_orcunidade();
$oPost           = db_utils::postMemory($_POST);
$clppaestimativa->rotulo->label();
$clrotulo = new rotulocampo;
$clrotulo->label("o01_descricao");
$clrotulo->label("o01_anoinicio");
$clrotulo->label("o01_anofinal");
$clrotulo->label("o01_sequencial");
$clrotulo->label("o01_numerolei");
$clrotulo->label("o40_orgao");
$clrotulo->label("o52_funcao");
$clrotulo->label("o15_codigo");
$clrotulo->label("o41_unidade");
$db_opcao = 1;
$lProcessaManual = false;
if (isset($oPost->o05_ppalei) && $oPost->o05_ppalei != "") {

  $oDaoPPALei = db_utils::getDao("ppalei");
  $sSqlLei    = $oDaoPPALei->sql_query($oPost->o05_ppalei);
  $rsLei      = $oDaoPPALei->sql_record($sSqlLei);
  if ($oDaoPPALei->numrows > 0) {

     $oLei          = db_utils::fieldsMemory($rsLei, 0);
     $o01_anoinicio = $oLei->o01_anoinicio;
     $o01_anofinal  = $oLei->o01_anofinal;
     $o01_descricao = $oLei->o01_descricao;
     $o01_numerolei = $oLei->o01_numerolei;
   /*
    * Verificamos se já foi feito o processamento da estimativa da lei.
    * caso já foi feito, carregamos o programa para edição manual dos valores.
    */
   $sSqlEstimativas = $clppaestimativa->sql_query(null,"*",
                                                  "o119_ppalei limit 1",
                                                  "o119_ppalei = {$oPost->o05_ppalei}");
   $rsEstmativas    = $clppaestimativa->sql_record($sSqlEstimativas);
   if ($clppaestimativa->numrows > 0) {
     $lProcessaManual = true;
   }

  }
}
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<?
db_app::load("scripts.js");
db_app::load("estilos.css");
db_app::load("prototype.js");
db_app::load("strings.js");
?>
<script language="JavaScript" type="text/javascript" src="scripts/ppaUserInterface.js"></script>
<style type="text/css">
    #o40_orgao, #o52_funcao, #o41_unidade {
        width: 55px;
    }
    #o40_orgaodescr, #o52_funcaodescr, #o15_codigodescr, #o41_unidadedescr {
        width: 440px;
    }
    #o01_descricao {
        width: 410px;
    }
    #o01_anoinicio, #o01_anofinal, #o01_numerolei {
        width: 112px;
    }
</style>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">
<center>
<form name='form1' method='post'>
    <table>
        <tr>
            <td>
                <fieldset>
                <legend>
                    <b>PPA Por Elemento</b>
                </legend>
                <table>
                    <td nowrap title="<?=@$To05_ppalei?>">
                        <? db_ancora("<b>Lei do PPA</b>","js_pesquisao05_ppalei(true);",$db_opcao); ?>
                    </td>
                    <td colspan="2">
                        <? db_input('o05_ppalei',10,$Io01_sequencial,true,'text',$db_opcao," onchange='js_pesquisao05_ppalei(false);'") ?>
                        <? db_input('o01_descricao',40,$Io01_descricao,true,'text',3,'') ?>
                    </td>
                    <tr>
                        <td nowrap title="<?=@$To05_ppaversao?>">
                            <b>Versão:</b>
                        </td>
                        <td id='verppa' colspan="2">
                        </td>
                    </tr>
                    <tr>
                        <td nowrap title="<?=@$To01_anoinicio?>">
                            <?=@$Lo01_anoinicio?>
                        </td>
                        <td>
                            <? db_input('o01_anoinicio',10,$Io01_anoinicio,true,'text',3,"") ?>
                            <?=@$Lo01_anofinal?>
                            <? db_input('o01_anofinal',10,$Io01_anofinal,true,'text',3,"") ?>
                        </td>
                        <td nowrap title="<?=@$To01_numerolei?>">
                            <?=@$Lo01_numerolei?>
                            <? db_input('o01_numerolei',10,$Io01_numerolei,true,'text',3,"") ?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap title="<?=@$To40_orgao?>">
                            <?=@$Lo40_orgao?>
                        </td>
                        <td colspan="2">
                            <? 
                            $sWhere = "o40_instit = ".db_getsession("DB_instit")." and o40_anousu = ".db_getsession("DB_anousu");
                            $rsOrgao = $clorcorgao->sql_record($clorcorgao->sql_query(null,null,"o40_orgao, o40_descr", "o40_orgao", $sWhere));
                            db_selectrecord("o40_orgao",$rsOrgao,true,1,"","","","0");                    
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap title="<?=@$To52_funcao?>">
                            <?=@$Lo52_funcao?>
                        </td>
                        <td colspan="2">
                            <? 
                            $rsFuncao = $clorcfuncao->sql_record($clorcfuncao->sql_query(null,"o52_funcao, o52_descr", null, ""));
                            db_selectrecord("o52_funcao",$rsFuncao,true,1,"","","","0");                    
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap title="<?=@$To41_unidade?>">
                            <?=@$Lo41_unidade?>
                        </td>
                        <td colspan="2">
                            <? 
                            $sWhere = "o41_instit = ".db_getsession("DB_instit")." and o41_anousu = ".db_getsession("DB_anousu");
                            $rsUnidade = $clorcunidade->sql_record($clorcunidade->sql_query(null,null,null,"o41_unidade, o41_descr", "o41_unidade", $sWhere));
                            db_selectrecord("o41_unidade",$rsUnidade,true,1,"","","","0");                    
                            ?>
                        </td>
                    </tr>      
                    <tr>
                        <td nowrap title="<?=@$To15_codigo?>">
                            <?=@$Lo15_codigo?>
                        </td>
                        <td colspan="2">
                            <? 
                            $sWhere = " o15_datalimite is null or o15_datalimite > '".date('Y-m-d',db_getsession('DB_datausu'))."'";
                            $rsRecurso = $clorctiporec->sql_record($clorctiporec->sql_query(null,"o15_codigo, o15_descr", "o15_codigo", $sWhere));
                            db_selectrecord("o15_codigo",$rsRecurso,true,1,"","","","0");                    
                            ?>
                        </td>
                    </tr>     
                </table>
                <center>
                    <? 
                    db_selinstit('',300,100);
                    db_input('filtra_despesa', 10,'',true, 'hidden', 3);
                    ?>
                </center>
                </fieldset>
            </td>
        </tr>
        <tr>
            <td colspan='2' align="center">
                <input name="imprime" type="button" id="imprime" value="Imprime"
                    onclick='js_imprimeRelatorio()'>
            </td>
        </tr>
    </table>
</form>
</center>
</body>
</html>
<script>
sUrlRPC       = 'orc4_ppaRPC.php';
lJaProcessado = <?=$lProcessaManual?"true":"false"; ?>;


function js_pesquisao05_ppalei(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo.iframe_g1',
                        'db_iframe_ppalei',
                        'func_ppalei.php?funcao_js=parent.js_mostrappalei1|o01_sequencial|o01_descricao',
                        'Pesquisa de Leis para o PPA',
                        true);
  }else{
     if(document.form1.o05_ppalei.value != ''){
        js_OpenJanelaIframe('CurrentWindow.corpo.iframe_g1',
                            'db_iframe_ppalei',
                            'func_ppalei.php?pesquisa_chave='
                            +document.form1.o05_ppalei.value+'&funcao_js=parent.js_mostrappalei',
                            'Leis PPA',
                            false);
     }else{
       document.form1.o01_descricao.value = '';
     }
  }
}
function js_mostrappalei(chave, erro) {

  document.form1.o01_descricao.value = chave;
  if(erro==true){
    document.form1.o05_ppalei.focus();
    document.form1.o05_ppalei.value = '';
    js_limpaComboBoxPerspectivaPPA();
  } else {
    document.form1.submit();
  }

}
function js_mostrappalei1(chave1,chave2){

  document.form1.o05_ppalei.value = chave1;
  document.form1.o01_descricao.value = chave2;
  db_iframe_ppalei.hide();
  document.form1.submit();

}

function js_imprimeRelatorio() {

  variavel = 1;
  iProcessado = $('o05_ppaversao').options[$('o05_ppaversao').selectedIndex].processadodespesa;
  if (iProcessado == 1) {

    var sQuery  = "?ppalei="+$F('o05_ppalei');
    sQuery += "&anoini="+$F('o01_anoinicio');
    sQuery += "&anofin="+$F('o01_anofinal');
    sQuery += "&ppaversao="+$F('o05_ppaversao');
    document.form1.filtra_despesa.value = parent.iframe_filtro.js_atualiza_variavel_retorno();

    jan = window.open('','safo' + variavel,'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
    document.form1.target = 'safo' + variavel;
    document.form1.action = "orc4_ppadespesaelemento002.php";
    document.form1.submit();

  } else {

    alert('Não existem estimativas calculadas!');
    return false;


  }

}
js_drawSelectVersaoPPA($('verppa'));
<?
 if (isset($oPost->o05_ppalei) && $oPost->o05_ppalei != "") {
   echo "js_getVersoesPPA({$oPost->o05_ppalei})\n";
 }
?>
</script>
