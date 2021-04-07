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

require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
$clrotulo = new rotulocampo;
$clrotulo->label("k17_codigo");
db_postmemory($HTTP_POST_VARS);
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script>
function js_abre(){
  if(document.form1.k17_codigo.value == ""){
    document.form1.k17_codigo.style.backgroundColor='#99A9AE';
    document.form1.k17_codigo.focus();
    alert("Informe o c�digo Slip.");
  }else{
    jan = window.open('cai1_slip003.php?numslip='+document.form1.k17_codigo.value,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
    jan.moveTo(0,0);
    document.form1.k17_codigo.style.backgroundColor='';
  }
}
</script>
<link href="estilos.css" rel="stylesheet" type="text/css">
  </head>
  <body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="document.form1.k17_codigo.focus();" bgcolor="#cccccc">
    <table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
      <tr>
	<td width="360" height="18">&nbsp;</td>
	<td width="263">&nbsp;</td>
	<td width="25">&nbsp;</td>
	<td width="140">&nbsp;</td>
      </tr>
    </table>
<center>
<form name="form1" method="post">

<table border='0'>
<tr height="20px">
<td ></td>
<td ></td>
</tr>
  <tr>
    <td  align="left" nowrap title="<?=$Tk17_codigo?>"> <? db_ancora(@$Lk17_codigo,"js_pesquisak17_codigo(true);",1);?>  </td>
    <td align="left" nowrap>
      <?
         db_input("k17_codigo",8,$Ik17_codigo,true,"text",4,"onchange='js_pesquisak17_codigo(false);'");
      ?>
    </td>
  </tr>
  <tr>
        <td align="center" valign="top">
            <form name='form1'>
                <fieldset>
                    <legend><b>Emite Empenho</b></legend>
                    <table>
                        <tr>
                            <td align="center">
                                <strong>Op��es:</strong>
                                <select name="ver">
                                    <option name="condicao" value="com">Com os CGM selecionados</option>
                                    <option name="condicao" value="sem">Sem os CGM selecionadas</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td nowrap width="50%">
                                <?
                                // $aux = new cl_arquivo_auxiliar;
                                $aux->cabecalho      = "<strong>CGM</strong>";
                                $aux->codigo         = "z01_numcgm"; //chave de retorno da func
                                $aux->descr          = "z01_nome";   //chave de retorno
                                $aux->nomeobjeto     = 'lista';
                                $aux->funcao_js      = 'js_mostra';
                                $aux->funcao_js_hide = 'js_mostra1';
                                $aux->sql_exec       = "";
                                $aux->func_arquivo   = "func_nome.php";  //func a executar
                                $aux->isfuncnome     = true;
                                $aux->nomeiframe     = "db_iframe_cgm";
                                $aux->localjan       = "";
                                $aux->onclick        = "";
                                $aux->db_opcao       = 2;
                                $aux->tipo           = 2;
                                $aux->top            = 0;
                                $aux->linhas         = 10;
                                $aux->vwhidth        = 400;
                                $aux->funcao_gera_formulario();
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td >
                                <? db_ancora(@$Le60_codemp,"js_pesquisae60_codemp(true);",1); ?>
                            </td>
                            <td>
                                <? db_input('e60_codemp',13,$Ie60_codemp,true,'text',$db_opcao," onchange='js_pesquisae60_codemp(false);'","e60_codemp")  ?>
                                <strong> � </strong>
                                <? db_input('e60_codemp',13,$Ie60_codemp,true,'text',$db_opcao,"","e60_codemp_fim" )  ?>
                            </td>
                        </tr>
                        <tr>
                            <td nowrap title="<?=@$Te60_numemp?>">
                                <? db_ancora(@$Le60_numemp,"js_pesquisae60_numemp(true);",1); ?>
                            </td>
                            <td>
                                <? db_input('e60_numemp',15,$Ie60_numemp,true,'text',$db_opcao," onchange='js_pesquisae60_numemp(false);'")  ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong> Per�odo:</strong>
                            </td>
                            <td>
                                <?
                                db_inputdata('dtini',@$dia,@$mes,@$ano,true,'text',1,"");
                                echo " � ";
                                db_inputdata('dtfim',@$dia,@$mes,@$ano,true,'text',1,"");
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Tipo:</strong>
                            </td>
                            <td>
                                <select id="tipos" name="tipos">
                                    <option name="padrao" value="1">Padr�o</option>
                                    <option name="anexo" value="2">Com Anexos</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                </fieldset>
            </form>
        </td>
    </tr>
  <tr height="20px">
  <td ></td>
  <td ></td>
  </tr>
  <tr>
  <td colspan="2" align="center">
    <input name="relatorio" type="button" onclick='js_abre();'  value="Gerar relat�rio">
  </td>
  </tr>
  </table>
  </form>
</center>
<? db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));?>
<script>
//--------------------------------
function js_pesquisak17_codigo(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('top.corpo','db_iframe_slip','func_slip.php?funcao_js=parent.js_mostraslip1|k17_codigo','Pesquisa',true);
  }else{
     if(document.form1.k17_codigo.value != ''){
        js_OpenJanelaIframe('top.corpo','db_iframe_slip','func_slip.php?pesquisa_chave='+document.form1.k17_codigo.value+'&funcao_js=parent.js_mostraslip','Pesquisa',false);
     }else{
       document.form1.t52_descr.value = '';
     }
  }
}
function js_mostraslip(chave,erro){
  if(erro==true){
    document.form1.k17_codigo.focus();
    document.form1.k17_codigo.value = '';
  }
}
function js_mostraslip1(chave1){
  document.form1.k17_codigo.value = chave1;
  db_iframe_slip.hide();
}
//--------------------------------
</script>
</body>
</html>
