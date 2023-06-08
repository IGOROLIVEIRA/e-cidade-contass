<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
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

require_once ("libs/db_stdlib.php");
require_once ("libs/db_conecta.php");
require_once ("libs/db_sessoes.php");
require_once ("libs/db_usuariosonline.php");

include("classes/db_empempenho_classe.php");
include("classes/db_empautoriza_classe.php");
include("classes/db_cgm_classe.php");
include("classes/db_matordem_classe.php");



require_once ("dbforms/db_funcoes.php");

$db_opcao = 1;
db_postmemory($HTTP_SERVER_VARS);
db_postmemory($_POST);

$clrotulo     = new rotulocampo;
$clcgm        = new cl_cgm;
$clmatordem   = new cl_matordem;
$clempempenho = new cl_empempenho;
$clempautoriza  = new cl_empautoriza;

$clcgm->rotulo->label();
$clmatordem->rotulo->label();
$clempempenho->rotulo->label();
$clrotulo->label("z01_nome");

$rotulo         = new rotulocampo();

?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >

<center>
<div style="margin-top: 25px; width: 570px;">
  <form method="post" action="" name="form1">
    <fieldset>
      <legend>
        <b>Consulta de Processos</b>
      </legend>
      <table>
        <tr id="autori">
            <td align="left" nowrap > <? db_ancora('Autorizacao',"js_pesquisa_aut(true);",1);?>  </td>
            <td align="left" nowrap>
                <?
                db_input("e54_autori",10,$Ie54_autori,true,"text",4,"onclick='js_pesquisa_aut(false);'");
                // db_input("z01_nome1",40,"",true,"text",3);
                ?></td>
        </tr>

        <tr id="numempenho">
              <td align="left" nowrap title="Número do Empenho:">
                  <? db_ancora("Número do Empenho:","js_pesquisa_empenho(true);",1); ?>
              </td>
              <td align="left" nowrap>
                  <? db_input("e60_numemp",10,$Ie60_numemp,true,"text",4); ?>
              </td>
        </tr>

        <tr id="codordem">
            <td  align="left" nowrap title="<?=$Tm51_codordem?>"><?db_ancora('Ordem de Compra',"js_pesquisa_matordem(true);",1);?></td>
            <td align="left" nowrap>
                <? db_input("m51_codordem",10,$Im51_codordem,true,"text",4,"onchange='js_pesquisa_matordem(false);'");
                ?></td>
        </tr>

        <tr id="ordempag">
            <td  align="left" nowrap title="Ordem de pagamento">
                <?db_ancora('Ordem de pagamento',"js_buscae53_codord(true)",1);?>
            </td>
            <td align="left" nowrap>
                <? db_input("e53_codord",10,$Ie53_codord,true,"text",4,"onchange='js_buscae53_codord(false);'"); ?>
            </td>
        </tr>

        <tr id="slip">
            <td  align="left" nowrap title="Slip">
                <?db_ancora('Slip',"js_pesquisak17_codigo(true)",1);?>
            </td>
            <td align="left" nowrap>
                <? db_input("k17_codigo",10,$Ik17_codigo,true,"text",4,"onchange='js_pesquisak17_codigo(false);'"); ?>
            </td>
        </tr>
      </table>
    </fieldset>

    <input type="button" name="db_opcao" value="Consultar" onclick="js_consultaProcesso();">
    <input type="button" value="Nova Pesquisa" onclick="js_cancelar()">
  </form>
</div>
</center>

<?php db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit")); ?>

</body>
</html>
<script type="text/javascript">

function js_consultaProcesso() {

  var sUrl = 'pro3_consultaprotocolo.php';

  js_OpenJanelaIframe('CurrentWindow.corpo', 'db_iframe', sUrl+'?e54_autori='+document.form1.e54_autori.value+'&e60_numemp='+document.form1.e60_numemp.value+'&m51_codordem='
      +document.form1.m51_codordem.value+'&e53_codord='+document.form1.e53_codord.value+'&k17_codigo='+document.form1.k17_codigo.value
      , 'Pesquisa de Processos', true);
}


/**
 * Valida formatacao do campo numero do processo
 * - aceita somente numeros e o caracter /
 *
 * @param string $sNumero
 * @access public
 * @return bool
 */
function js_validarNumero(sNumero) {

  var lCaracteresValidos = new RegExp(/^[0-9\/]+$/).test(sNumero);
  var iPosicaoBarra      = sNumero.indexOf('/');
  var iQuantidadeBarras  = iPosicaoBarra > 0 ? sNumero.match(/\//g).length : 0;

  /**
   * Contem caracter difernete de 0-9 e /
   */
  if ( !lCaracteresValidos ) {
    return false;
  }

  /**
   * Informou primeiro caracter /
   */
  if ( iPosicaoBarra == 0 ) {
    return false;
  }

  /**
   * Informou mais de uma barra
   */
  if ( iQuantidadeBarras > 1 ) {
    return false;
  }

  /**
   * Não informou nenhum numero apos a barra
   */
  if ( iPosicaoBarra > 0 && empty(sNumero.split('/')[1]) ) {
    return false;
  }

  return true;

}


$('e54_autori').setAttribute('readOnly',true);
$('e60_numemp').setAttribute('readOnly',true);
$('m51_codordem').setAttribute('readOnly',true);
$('e53_codord').setAttribute('readOnly',true);
$('k17_codigo').setAttribute('readOnly',true);
$('e54_autori').setAttribute('style','background-color: rgb(222, 184, 135); color: rgb(0, 0, 0);');
$('e60_numemp').setAttribute('style','background-color: rgb(222, 184, 135); color: rgb(0, 0, 0);');
$('m51_codordem').setAttribute('style','background-color: rgb(222, 184, 135); color: rgb(0, 0, 0);');
$('e53_codord').setAttribute('style','background-color: rgb(222, 184, 135); color: rgb(0, 0, 0);');
$('k17_codigo').setAttribute('style','background-color: rgb(222, 184, 135); color: rgb(0, 0, 0);');

//-Ordem Pagamento


function js_buscae53_codord(mostra){
    if(mostra==true){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_pagordemele','func_pagordemele.php?funcao_js=parent.js_mostracodord1|e53_codord','Pesquisa',true);
    }else{
        if(document.form1.e53_codord.value != ''){
            js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_pagordemele','func_pagordemele.php?pesquisa_chave='+document.form1.e53_codord.value+'&funcao_js=parent.js_mostracodord','Pesquisa',false);
        }else{
            document.form1.e53_codord.value = '';
        }
    }
}

function js_mostracodord(chave,erro){
    if(erro==true){
        document.form1.e53_codord.value = '';
        document.form1.e53_codord.focus();
    }
}

function js_mostracodord1(chave1){
    document.form1.e53_codord.value = chave1;
    $('autori').style.display     = 'none';
    $('numempenho').style.display = 'none';
    $('codordem').style.display   = 'none';
    $('slip').style.display       = 'none';
    //document.form1.z01_nome2.value = chave2;
    db_iframe_pagordemele.hide();
}

//Orderm de compra
function js_pesquisa_matordem(mostra){
    if(mostra==true){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_matordem','func_matordemanulada.php?funcao_js=parent.js_mostramatordem1|m51_codordem|','Pesquisa',true);
    }else{
        if(document.form1.m51_codordem.value != ''){
            js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_matordem','func_matordemanulada.php?pesquisa_chave='+document.form1.m51_codordem.value+'&funcao_js=parent.js_mostramatordem','Pesquisa',false);
        }else{
            document.form1.m51_codordem.value = '';
        }
    }
}
function js_mostramatordem(chave,erro){
    document.form1.m51_codordem.value = chave1;
    if(erro==true){
        document.form1.m51_codordem.value = '';
        document.form1.m51_codordem.focus();
    }
}
function js_mostramatordem1(chave1){
    document.form1.m51_codordem.value = chave1;
    $('autori').style.display     = 'none';
    $('numempenho').style.display = 'none';
    $('ordempag').style.display   = 'none';
    $('slip').style.display       = 'none';

    db_iframe_matordem.hide();
}
//------------------------------------------------------


//-Empenho
function js_pesquisa_empenho(mostra){
    if(mostra==true){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_empempenho','func_empempenho.php?funcao_js=parent.js_mostraempenho1|e60_numemp','Pesquisa',true);
    }else{
        if(document.form1.e60_numemp.value != ''){
            js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_empempenho','func_empempenho.php?pesquisa_chave='+document.form1.e60_numemp.value+'&funcao_js=parent.js_mostraempenho','Pesquisa',false);
        }else{
            document.form1.z01_nome1.value = '';
        }
    }
}
function js_mostraempenho(erro,chave){
    document.form1.z01_nome1.value = chave;
    if(erro==true){
        document.form1.e60_numemp.focus();
        document.form1.z01_nome1.value = '';
    }
}
function js_mostraempenho1(chave1){
    document.form1.e60_numemp.value = chave1;
    $('autori').style.display   = 'none';
    $('codordem').style.display = 'none';
    $('ordempag').style.display = 'none';
    $('slip').style.display     = 'none';
    // document.form1.z01_nome1.value = chave2;
    db_iframe_empempenho.hide();
}


//--------------------------------


//-AUTORIZACAO
function js_pesquisa_aut(mostra){
    if(mostra==true){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_empautoriza','func_empautoriza.php?funcao_js=parent.js_mostraautori1|e54_autori','Pesquisa',true);
    }else{
        if(document.form1.e54_autori.value != ''){
            js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_empautoriza','func_empautoriza.php?pesquisa_chave='+document.form1.e54_autori.value+'&funcao_js=parent.js_mostraautori','Pesquisa',false);
        }else{
            // document.form1.z01_nome1.value = '';
        }
    }
}
function js_mostraautori(erro,chave){
    // document.form1.z01_nome1.value = chave;
    if(erro==true){
        document.form1.e54_autori.focus();
        //  document.form1.z01_nome1.value = '';
    }
}
function js_mostraautori1(chave1){
    // alert(chave1);

    document.form1.e54_autori.value = chave1;
    $('numempenho').style.display = 'none';
    $('codordem').style.display   = 'none';
    $('ordempag').style.display   = 'none';
    $('slip').style.display       = 'none';

    // document.form1.z01_nome1.value = chave2;
    db_iframe_empautoriza.hide();
}

// - Slip
function js_pesquisak17_codigo(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_slip','func_slip.php?protocolo=1&funcao_js=parent.js_mostraslip1|k17_codigo','Pesquisa',true);
  }else{
    slip01 = new Number(document.form1.k17_codigo.value);
    if(slip01 != ""){
       js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_slip','func_slip.php?&pesquisa_chave='+slip01+'&funcao_js=parent.js_mostraslip','Pesquisa',false);
    }else{
        //document.form1.k17_codigo.value='';
    }
  }
}
function js_mostraslip(chave1, erro){
  /*document.form1.z01_nome.value = chave2;
  document.form1.dattab.value   = chave3;
  document.form1.valtab.value   = chave4;*/
  if(erro==true){
    document.form1.k17_codigo.focus();
    document.form1.k17_codigo.value = '';
  }

}

function js_mostraslip1(chave1){
  document.form1.k17_codigo.value = chave1;
  $('autori').style.display     = 'none';
  $('numempenho').style.display = 'none';
  $('codordem').style.display   = 'none';
  $('ordempag').style.display   = 'none';

  db_iframe_slip.hide();
}

function js_cancelar(){
    var opcao = document.createElement("input");
    opcao.setAttribute("type","hidden");
    opcao.setAttribute("name","novo");
    opcao.setAttribute("value","true");

    $('e54_autori').value   = "";
    $('e60_numemp').value   = "";
    $('m51_codordem').value = "";
    $('e53_codord').value   = "";
    $('k17_codigo').value   = "";


    document.form1.appendChild(opcao);
    document.form1.submit();
}

</script>
