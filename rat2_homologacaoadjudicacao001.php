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
db_postmemory($HTTP_POST_VARS);


$clrotulo = new rotulocampo;
$clrotulo->label("l20_codigo");
?>

<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">  
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>

    <script>
        function js_emite(){
            var gerar = document.getElementById("gerar").value;
            var imprimir = document.getElementById("tipoImprimir").value;
            var nome = "";
        
            if(gerar==1){
                var ilicita = document.getElementById("l202_licitacao").value;
                var data = document.getElementById("dataHom").value;
                var sequencial = document.getElementById("sequencial").value;
                var valor = "";
                if(imprimir==1){
                    jan = window.open('lic1_homologacaoadjudica004.php?impjust=$impjustificativa&codigo_preco='+ilicita+'&nome='+nome+'&sequencial='+sequencial+'&data='+data+'&valor='+valor+'&quant_casas=2&tipoprecoreferencia=',
                     'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
	            jan.moveTo(0,0);
                }else if(imprimir==2){
                    jan = window.open('lic1_homologacaoadjudica005.php?impjust=$impjustificativa&codigo_preco='+ilicita+'&nome='+nome+'&sequencial='+sequencial+'&data='+data+'&valor='+valor+'&quant_casas=2&tipoprecoreferencia=',
                     'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
	                jan.moveTo(0,0);
                }
            }else if(gerar==2){

                var ilicita = document.getElementById("l202_licitacao1").value;
                var data = document.getElementById("dataAdju").value;
                
                if(imprimir==1){
                    jan = window.open('lic1_adjudicacaolicitacao004.php?impjust=$impjustificativa&codigo_preco='+ilicita+'&nome='+nome+'&data='+data+'&quant_casas=2&tipoprecoreferencia=',
                     'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
                }
                if(imprimir==2){
                    jan = window.open('lic1_adjudicacaolicitacao005.php?impjust=$impjustificativa&codigo_preco='+ilicita+'&nome='+nome+'&quant_casas=2&tipoprecoreferencia=',
                     'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
	                jan.moveTo(0,0);
                }
            }
            /*
            jan = window.open('rat2_ratificacaoprocnovo002.php?l20_codigo='+document.form1.l20_codigo.value,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
            jan.moveTo(0,0);
            document.form1.l20_codigo.value=''; */

        }
    </script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" bgcolor="#cccccc">
<table width="790" border="0" cellpadding="0" cellspacing="0" bgcolor="#5786B2">
    <tr>
        <td width="360" height="18">&nbsp;</td>
        <td width="263">&nbsp;</td>
        <td width="25">&nbsp;</td>
        <td width="140">&nbsp;</td>
    </tr>
</table>
 
<fieldset style="width: 300px;margin:auto;margin-top:30px;">
        <legend><b>Relatório de Homologação e Adjudicação</b></legend>
<table  align="center">

    <form name="form1" method="post" action="">
        <tr>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
        </tr>
        <tr>
            <td  align="left" nowrap title="<?=$Tl20_codigo?>">
                <b>
                    Relatório:
                </b>
            </td>

            <td align="left" nowrap>
                <? 
                $aValores1 = array(
                    0 => 'Selecione',
                    1 => 'Homologação',
                    2 => 'Adjudicação',
                );
                db_select('gerar', $aValores1, true, $db_opcao,"onchange='js_liberar_Ancora()';");
                ?>
                
                </td>
                
        </tr>
        <tr id="homolo" style="display: none;">
            <td  align="left" nowrap title="<?=$Tl20_codigo?>">
                <b>
                    <?db_ancora("Licitação","js_pesquisal202_licitacao(true);",$db_opcao);?>&nbsp;:
                    
                </b>
            </td>

            <td align="left" nowrap>
                <? db_input('l202_licitacao',10,$Il202_licitacao,true,'text',3," onchange='js_pesquisal202_licitacao(false);'")
                ?></td>
                <input type="hidden" id="dataHom">
                <input type="hidden" id="sequencial">
        </tr>

        <tr id="adjudi" style="display: none;">
            <td nowrap title="<?=@$Tl202_licitacao?>">
                <?
                db_ancora("Licitação","js_pesquisal202_licitacao1(true);",$db_opcao);
                ?>
            </td>
            <td>
                <?
                db_input('l202_licitacao1',10,$Il202_licitacao,true,'text',3," onchange='js_pesquisal202_licitacao1(false);'")
                ?>
                <input type="hidden" id="dataAdju">
            </td>
        </tr>

        <tr>
            <td  align="left" nowrap title="<?=$Tl20_codigo?>">
                <b>
                    Imprimir:
                </b>
            </td>

            <td align="left" nowrap>
                <? 
                $aValores = array(
                
                    1 => 'PDF',
                    2 => 'WORD',
                );
                db_select('tipoImprimir', $aValores, true, $db_opcao,"");
                ?>
                
                </td>
                
        </tr>
        
        <tr>
            <td >&nbsp;</td>
            <td >&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2" align = "center">
                <input  name="emite2" id="emite2" type="button" value="Processar" onclick="js_emite();" >
            </td>
        </tr>

    </form>
    
</table>
</fieldset>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>

<script>

    function js_liberar_Ancora(){
        var op = document.getElementById("gerar").value;
        if(op==1){
            document.getElementById("homolo").style.display = "table-row";
            document.getElementById("adjudi").style.display = "none"; 
        }
        if(op==2){
            document.getElementById("adjudi").style.display = "table-row";
            document.getElementById("homolo").style.display = "none"; 
        }
    }

    function js_pesquisal202_licitacao(mostra){
        let opcao = "<?= $db_opcao?>";
        var situacao = 0;
        var homologacao = 0;
        if(mostra==true){
            js_OpenJanelaIframe('top.corpo','db_iframe_liclicita','func_lichomologa.php?situacao='+situacao+
                '&funcao_js=parent.js_mostraliclicita3|l20_codigo|l20_objeto|l20_numero|l202_datahomologacao|l202_sequencial&validafornecedor=1&homologacao='+homologacao,'Pesquisa',true);
        }else{
            if(document.form1.l202_licitacao.value != ''){
                js_OpenJanelaIframe('top.corpo','db_iframe_liclicita','func_lichomologa.php?situacao='+situacao+
                    '&pesquisa_chave='+document.form1.l202_licitacao.value+'&funcao_js=parent.js_mostraliclicita4&validafornecedor=1&homologacao='+homologacao,'Pesquisa',false);
            }

        }
    }

        function js_mostraliclicita4(chave,erro){

        }

        function js_mostraliclicita3(chave1,chave2,chave3,chave4,chave5){
                    document.form1.l202_licitacao.value = chave1;
                        aData = chave4.split('-');
                        let dataHomo =  aData[2]+'/'+aData[1]+'/'+aData[0];
                        document.getElementById("dataHom").value = dataHomo;
                        document.getElementById("sequencial").value = chave5;
                    db_iframe_liclicita.hide();

        }    

        function js_pesquisal202_licitacao1(mostra){
        
                var situacao = 0;
                var adjudicacao = 3;
            
                if(mostra==true){
                    js_OpenJanelaIframe('top.corpo','db_iframe_liclicita','func_licadjudica.php?situacao='+situacao+
                        '&funcao_js=parent.js_mostraliclicita1|l20_codigo|l20_objeto|l20_numero|l202_dataadjudicacao&validafornecedor=1&adjudicacao='+adjudicacao,'Pesquisa',true);
                }else{
                    if(document.form1.l202_licitacao1.value != ''){
                        js_OpenJanelaIframe('top.corpo','db_iframe_liclicita','func_licadjudica.php?situacao='+situacao+
                            '&pesquisa_chave='+document.form1.l202_licitacao1.value+'&funcao_js=parent.js_mostraliclicita&validafornecedor=1&adjudicacao='+adjudicacao,'Pesquisa',false);
                    }

                }
     }

    function js_mostraliclicita(chave,erro){

        document.form1.pc50_descr.value = chave;
        if(erro==true){
            iLicitacao = '';
            document.form1.l202_licitacao.focus();
            document.form1.l202_licitacao.value = '';
        }else{
            iLicitacao = document.form1.l202_licitacao.value;
            js_init()
        }
    }
    function js_mostraliclicita1(chave1,chave2,chave3,chave4){
        iLicitacao = chave1;
        document.form1.l202_licitacao1.value = chave1;       
       
            aData = chave4.split('-');
            let dataAdju =  aData[2]+'/'+aData[1]+'/'+aData[0];
            //document.form1.dataAdju.value = dataAdju;
            document.getElementById("dataAdju").value = dataAdju;
        
        db_iframe_liclicita.hide();

    }

    function js_getReponsavel() {
        var oParam = new Object();
        oParam.iLicitacao   = document.getElementById('l20_codigo').value;
        oParam.exec = "getResponsavelAdju";
        //js_divCarregando('Aguarde, pesquisando Itens', 'msgBox');
        var oAjax = new Ajax.Request(
            'lic1_homologacaoadjudica.RPC.php', {
                method: 'post',
                parameters: 'json=' + Object.toJSON(oParam),
                onComplete: js_retornoGetResponsavel
            }
        );
    }

    function js_retornoGetResponsavel(oAjax) {
        alert("teste");
        //js_removeObj('msgBox');
        

        var oRetornoitens = JSON.parse(oAjax.responseText);
        oRetornoitens.itens.each(function(oLinha, iLinha) {
                //document.getElementById("respAdjudicodigo").value = oLinha.codigo;
                document.getElementById("nome").value = oLinha.nome;

        });

    }

    //js_pesquisa_liclicita(true);
</script>