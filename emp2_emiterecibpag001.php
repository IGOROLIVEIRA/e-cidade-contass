<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBselller Servicos de Informatica
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
require_once("libs/db_app.utils.php");

$clrotulo = new rotulocampo;
$clrotulo->label("e60_codemp");
$clrotulo->label("e60_numemp");
$clrotulo->label("e81_codmov");
$db_opcao = 1;

db_app::load("scripts.js,
              strings.js,
              prototype.js,
              widgets/DBLancador.widget.js,
              widgets/DBToogle.widget.js,
              estilos.css,
            ");
?>

<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">

</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
<table width="790" height='18'  border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
    <tr>
        <td width="360">&nbsp;</td>
        <td width="263">&nbsp;</td>
        <td width="25">&nbsp;</td>
        <td width="140">&nbsp;</td>
    </tr>
</table>
<center>
<table valign="top" marginwidth="0" width="600" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td align="center" valign="top" bgcolor="#CCCCCC">
            <form name='form1'>
            <fieldset>
            <table>
                <tr>
                    <td nowrap title="<?=@$Te60_codemp?>">
                        <? db_ancora(@$Le60_codemp,"js_pesquisae60_codemp(true);",1); ?>
                    </td>
                    <td>
                        <? db_input('e60_codemp',13,$Ie60_codemp,true,'text',$db_opcao," onchange='js_pesquisae60_codemp(false);'","e60_codemp")  ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?=@$Te60_numemp?>">
                        <? db_ancora(@$Le60_numemp,"js_pesquisae60_numemp(true);",1); ?>
                    </td>
                    <td>
                        <? db_input('e60_numemp',13,$Ie60_numemp,true,'text',$db_opcao," onchange='js_pesquisae60_numemp(false);'")  ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="<?=@$Te50_codord?>">
                        <b><? db_ancora("Ordem de Pagamento:","js_pesquisae50_codord(true);",1); ?></b>
                    </td>
                    <td>
                        <? db_input('e50_codord',13,$Ie50_codord,true,'text',$db_opcao," onchange='js_pesquisae50_codord(false);'")  ?>
                    </td>
                </tr>
                <tr>
                    <td nowrap title="Nº Recibo"><b>Nº Recibo:</b></td>
                    <td>
                        <? db_input('e81_codmov',13,$Ie81_codmov,true,'text',$db_opcao)  ?>
                    </td>
                </tr>
                <tr>
                    <td align="left" >
                        <b> Período:</b>
                    </td>
                    <td>
                        <?  db_inputdata('dtini',@$dia,@$mes,@$ano,true,'text',1,"");
                            echo " a ";
                            db_inputdata('dtfim',@$dia,@$mes,@$ano,true,'text',1,"");
                        ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div id='ctnLancadorCredor'></div>
                    <td>
                </tr>
            </table>
            </fieldset>
            </form>
        </td>
    </tr>
    <tr>
        <td colspan='2' align='center'>
            <input name='pesquisar' type='button' value='Emitir' onclick='js_abre();'>
        </td>
    </tr>
</table>
</center>
<?
    db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<script>

//ctnLancadorCredor
var oLancadorCredor = new DBLancador('LancadorCredor');
    oLancadorCredor.setLabelAncora("Credor:");
    oLancadorCredor.setTextoFieldset("Credores");
    oLancadorCredor.setTituloJanela("Pesquisar Credores");
    oLancadorCredor.setNomeInstancia("oLancadorCredor");
    oLancadorCredor.setParametrosPesquisa("func_nome.php", ["z01_numcgm", "z01_nome"]);
    oLancadorCredor.setGridHeight(150);
    oLancadorCredor.show($("ctnLancadorCredor"));

function getCredores(){

    var aCredores  = [];
    var aSelecionados = oLancadorCredor.getRegistros();

    aSelecionados.each( function( oDados, iIndice){
        aCredores.push( oDados.sCodigo );
    });

    return aCredores;

}


function js_abre(){

    var obj             = document.form1;
    var e50_codord      = obj.e50_codord.value;
    var e60_codemp      = obj.e60_codemp.value;
    var e60_numemp      = obj.e60_numemp.value;
    var e81_codmov      = obj.e81_codmov.value;
    var dtini           = obj.dtini;
    var dtfim           = obj.dtfim;
    var dtini_dia       = obj.dtini_dia.value;
    var dtini_mes       = obj.dtini_mes.value;
    var dtini_ano       = obj.dtini_ano.value;
    var dtfim_dia       = obj.dtfim_dia.value;
    var dtfim_mes       = obj.dtfim_mes.value;
    var dtfim_ano       = obj.dtfim_ano.value;
    var aCredores       = getCredores();

    var query          = '';

    if(e50_codord != ''){
        query += "&e50_codord="+e50_codord;
    }

    if(e81_codmov != ''){
        query += "&e81_codmov="+e81_codmov;
    }

    if(dtini != ''){

        if((dtini_dia != '') && (dtini_mes != '') && (dtini_ano != '')){
            query +="&dtini="+dtini_ano+"X"+dtini_mes+"X"+dtini_dia;
        }

    }

    if(dtfim != ''){

        if ((dtfim_dia != '') && (dtfim_mes != '') && (dtfim_ano != '')) {
            query +="&dtfim="+dtfim_ano+"X"+dtfim_mes+"X"+dtfim_dia;
        }

    }

    if(e60_codemp != ''){
        query += "&e60_codemp="+obj.e60_codemp.value;
    }

    if(e60_numemp != ''){
       query += "&e60_numemp="+e60_numemp;
    }

    if(query == '' && aCredores.length < 1){
        alert("Informe algum empenho, ordem de pagamento ou nº do recibo!");
    } else {

        var sUrl = 'emp2_emiterecibpag002.php?aCredor=' + aCredores + query;
        jan = window.open(sUrl,
                       '',
                       'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
        jan.moveTo(0,0);

    }

}

function js_pesquisae60_codemp(mostra){

    var obj         = document.form1;
    var e60_codemp  = obj.e60_codemp.value;
    var sUrl1       = 'func_empempenho.php?funcao_js=parent.js_mostracodemp1|e60_codemp|e60_anousu';

    if(mostra==true){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_empempenho',sUrl1,'Pesquisa',true);
    }

}

function js_mostracodemp1(chave1,chave2){

    var obj = document.form1;
    obj.e60_codemp.value = chave1 + "/" + chave2;
    db_iframe_empempenho.hide();

}

function js_pesquisae60_numemp(mostra){

    if(mostra==true){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_empempenho','func_empempenho.php?funcao_js=parent.js_mostranumemp1|e60_numemp','Pesquisa',true);
    } else {

        if(document.form1.e60_numemp.value != ''){
            js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_empempenho','func_empempenho.php?pesquisa_chave='+document.form1.e60_numemp.value+'&funcao_js=parent.js_mostranumemp','Pesquisa',false);
        }else{
            document.form1.e60_numemp.value = '';
        }
    }

}

function js_mostranumemp(chave,erro){

    if(erro==true){

        document.form1.e50_codemp.focus();
        document.form1.e50_codemp.value = '';
    }

}

function js_mostranumemp1(chave1,x){

    document.form1.e60_numemp.value = chave1;
    db_iframe_empempenho.hide();

}

function js_pesquisae50_codord(mostra){

    if(mostra==true){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_pagordem','func_pagordem.php?funcao_js=parent.js_mostracodordem1|e50_codord','Pesquisa',true);
    } else {

        if(document.form1.e50_codord.value != ''){
            js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_pagordem','func_pagordem.php?pesquisa_chave='+document.form1.e50_codord.value+'&funcao_js=parent.js_mostracodordem','Pesquisa',false);
        } else {
            document.form1.e50_codord.value = '';
        }

    }
}

function js_mostracodordem(chave,erro){

    if(erro==true){

        document.form1.e50_codord.focus();
        document.form1.e50_codord.value = '';

    }

}

function js_mostracodordem1(chave1,x){

    document.form1.e50_codord.value = chave1;
    db_iframe_pagordem.hide();

}

</script>
