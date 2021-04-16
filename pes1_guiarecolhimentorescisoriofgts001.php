<?
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
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");

$oRotulo   = new rotulocampo();
$oRotulo->label('rh90_anousu');
$oRotulo->label('rh90_mesusu');
$oRotulo->label("z01_nome");

?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<?
  db_app::load('scripts.js,estilos.css,prototype.js, dbmessageBoard.widget.js, windowAux.widget.js');
  db_app::load('dbtextField.widget.js, dbcomboBox.widget.js, DBViewGeracaoAutorizacao.classe.js, grid.style.css');
  db_app::load('datagrid.widget.js, strings.js, arrays.js, DBHint.widget.js, ');
?>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<form name="form1" method="post" action="">
<table align="center" style="padding-top: 25px;">
  <tr> 
    <td>
      <fieldset>
        <legend>
          <b>Geração GRRF</b>
        </legend>
        <table>
          <tr>
            <td>
              <b>Tipo de Processamento:</b>
            </td>
            <td>
              <?php
                $aTipoProcessamento = array("1" => "Geral",
                                            "2" => "Selecionados");
                db_select("iTipoProcessamento", $aTipoProcessamento, true, 1, "onchange='js_exibirServidores()'");
              ?>
            </td>
          </tr>
          <tr>
            <td>
              <b>Competência ( Mês / Ano ) :</b>
            </td>
            <td>
              <?php
                 $anousu = db_anofolha();
                 $mesusu = db_mesfolha();
               
                 db_input('mesusu',2,true,$Irh90_anousu,'text',1);
                 echo "/";
                 db_input('anousu',4,true,$Irh90_mesusu,'text',1);                 
              ?>
            </td>
          </tr>
          <tr>
            <td nowrap align="right" title="Data recolhimento FGTS">
                <b>Data recolhimento FGTS:</b>
            </td>
            <td><?
                db_inputdata("dtrecfgts", @$dtrecfgts_dia, @$dtrecfgts_mes, @$dtrecfgts_ano, true, 'text',1);
                ?>
            </td>
          </tr>
        </table>
        <table>
          <tr>
            <td align="center">
              <fieldset>
                <legend>
                  <b>CONTATO</b>
                </legend>
                <table>
                  <tr>
                    <td nowrap align="right" title="Nome do contato"><b>Nome:</b>
                    </td>
                    <td><?
                    db_input('z01_nome',40,$Iz01_nome,true,'text',1,"","contato")
                    ?>
                    </td>
                    <td nowrap align="right" title="Fone"><b>Fone:</b>
                    </td>
                    <td><?
                    db_input('fone',10,1,true,'text',1,"","")
                    ?>
                    </td>
                  </tr>
                </table>
              </fieldset>
            </td>
          </tr>
        </table>
        <table>
            <tr>
                <td nowrap align="right" title="Código CNAE fiscal"><b>Código CNAE fiscal:</b>
                </td>
                <td><?
                    $cnae = "8411600";
                    db_input('cnae',10,1,true,'text',1,"","")
                    ?>
                </td>
            </tr>
        </table>
      </fieldset>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">
      <input type="button" id="processar" value="Processar" onClick="js_processar();">
    </td>
  </tr>          
</table>
</form>
<?
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<script>
   
  var sUrlRPC = 'pes4_guiarecolhimentorescisoriofgts.RPC.php';
  var oParam  = new Object();
  
  function js_processar() {
  
    if(!js_verificaAnoMes()) {
        return false;
    }
    if (!js_verificaCampos()) {
        return false
    }
    
    oParam.iAnoUsu            = $F('anousu');
    oParam.iMesUsu            = $F('mesusu');

    js_pesquisaGeracao();
  }   

 function js_pesquisaGeracao() {
    
    js_divCarregando('Aguarde, processando...', 'msgbox');
    
    oParam.sMethod = 'verificaGeracaoGRRF';
    
    var oAjax   = new Ajax.Request( 
                                   sUrlRPC, 
                                   {
                                     method: 'post', 
                                     parameters: 'json='+Object.toJSON(oParam), 
                                     onComplete: js_retornoGeracao 
                                   }
                                  );      
  
  }
  
  function js_retornoGeracao(oAjax) {

    var oRetorno = eval("("+oAjax.responseText+")");
    
    js_removeObj('msgbox');
    
    if ( oRetorno.iStatus == 2 ) {
    
      alert(oRetorno.sMsg.urlDecode());
      return false;
    } else {
    
      if ( oRetorno.lGerado ) {
        
        var sMsg ='GRRF já gerado para a competência informada!\n'
                 +'Deseja cancelar a mesma ?';
        
        if ( confirm(sMsg) ) {
          js_cancelaGeracao();
        } else {
          js_dowloadArquivo(oRetorno.iCodGRRF);
        }
          
      } else {
        js_gerarArquivo();
      }
    }
  }
   
  function js_cancelaGeracao() {
  
    js_divCarregando('Aguarde, cancelando GRRF...', 'msgbox');
    
    oParam.sMethod = 'cancelaGeracaoGRRF';
    
    var oAjax   = new Ajax.Request( 
                                   sUrlRPC, 
                                   {
                                     method: 'post', 
                                     parameters: 'json='+Object.toJSON(oParam), 
                                     onComplete: js_retornoCancelamentoGeracao 
                                   }
                                  ); 
  }
  
  function js_retornoCancelamentoGeracao(oAjax) {

    var oRetorno = eval("("+oAjax.responseText+")");
    
    js_removeObj('msgbox');
    
    if ( oRetorno.iStatus == 2 ) {
      alert(oRetorno.sMsg.urlDecode());
      return false;
    } else {
      js_gerarArquivo();    
    }
  }
   
  function js_gerarArquivo() {
    
    js_divCarregando('Aguarde, gerando arquivo GRRF...', 'msgbox');
    oParam.selecionados = '';
    if ($('iTipoProcessamento').value == '2') {
        let aServidores = [];
        oGridServidores.getSelection('object').each((oServidor, index) => aServidores.push(oServidor.aCells[0].getValue()));
        oParam.selecionados = aServidores.join(",");
    }
    
    oParam.iAnoUsu = $F('anousu');
    oParam.iMesUsu = $F('mesusu');
    oParam.contato = $F('contato');
    oParam.fone = $F('fone');
    oParam.dtrecfgts = $F('dtrecfgts');
    oParam.cnae = $F('cnae');
    oParam.sMethod   = 'gerarArquivo';
    var oAjax   = new Ajax.Request( sUrlRPC, {
                                         method: 'post',
                                         parameters: 'json='+Object.toJSON(oParam), 
                                         onComplete: js_retornoGerarArquivo  
                                       }
                                 );

  } 

  function js_retornoGerarArquivo(oAjax) {
    var oRetorno = eval("("+oAjax.responseText+")");
    
    js_removeObj('msgbox');
    
    if ( oRetorno.iStatus == 2 ) {
      alert(oRetorno.sMsg.urlDecode());
      return false;
    } else {
      alert("Arquivo gerado com sucesso!");
      js_dowloadArquivo(oRetorno.iCodGRRF);
    }
  }
   
  function js_dowloadArquivo(iCodGRRF) {
    
    js_divCarregando('Aguarde ...','msgBox');
    
    oParam.sMethod   = 'downloadAquivo';
    oParam.iCodGRRF = iCodGRRF;
    var oAjax   = new Ajax.Request( sUrlRPC, {
                                         method: 'post',
                                         parameters: 'json='+Object.toJSON(oParam), 
                                         onComplete: js_retornoDownloadArquivo  
                                       }
                                 );
  }
  
  function js_retornoDownloadArquivo(oAjax){

    var sRetorno = eval("("+oAjax.responseText+")");
    
    js_removeObj("msgBox");
    if ($('iTipoProcessamento').value == '2') {
        js_fecharWindow();
        $('iTipoProcessamento').value = '1'
    }

    if (sRetorno.iStatus == 2 ) {

    alert(sRetorno.sMsg.urlDecode());
    return false;
    } else {

    var sArquivo = sRetorno.sCaminhoArquivo.urlDecode()+'#Arquivo para envio GRRF';
    var sLista   = sArquivo;
    js_montarlista(sLista,'form1');       
    }
  }

/* INICIA CODIGO DO GRID */
function js_exibirServidores() {

    if ($('iTipoProcessamento').value == '1') {
        return false;
    }

    if(!js_verificaAnoMes()) {
        $('iTipoProcessamento').value = 1;
        return false;
    }

    if(!js_verificaCampos()) {
        $('iTipoProcessamento').value = 1;
        return false;
    }

    var oParam     = new Object();
    oParam.sMethod = 'getServidoresRescisao';
    oParam.iAnoUsu = $F("anousu");
    oParam.iMesUsu = $F("mesusu");

    js_divCarregando('Carregando Servidores com Rescisão...', "msgBox");
    var oAjax = new Ajax.Request(sUrlRPC,
                              {method:'post',
                               parameters:'json='+Object.toJSON(oParam),
                               onComplete: js_montaWindowGridServidores});
}

function js_montaWindowGridServidores (oAjax) {    
    var iAnoUsu = $F("anousu");
    var iMesUsu = $F("mesusu");

    js_removeObj("msgBox");
    var oRetorno = JSON.parse(oAjax.responseText);

    if (oRetorno.iStatus == 2) {
        alert(oRetorno.sMessage.urlDecode());
        return false;
    }

    if (oRetorno.aListaServidores.length == 0) {
        alert(`Não foram encontrados servidores com rescisão em ${iMesUsu}/${iAnoUsu}`);
        $('iTipoProcessamento').value = 1;
        return false;
    }

    var iHeight   = document.body.clientHeight-150;
    var iWidth    = document.body.clientWidth-50;
    var iWidthContainer = (iWidth-30);
    oWindowAux    = new windowAux('oWindowAux', 'Selecionar Servidores', iWidth, iHeight);
    var sContent  = "<div style='width: "+iWidthContainer+"px;' id='cntGrid'></div>";
      sContent += "<p align='center'><input type='button' id='processarSelecionados' value='Processar' onClick='js_processar();'>";
      sContent += "<input style='margin-left: 5px;' type='button' value='Fechar' onclick='js_fecharWindow();' /></p>";
    oWindowAux.setContent(sContent);

    var aHeader     = new Array();
      aHeader[0]  = "Matrícula";
      aHeader[1]  = "Nome";
      aHeader[2]  = "Rescisão";

    var aCellWidth     = new Array();
      aCellWidth[0]  = "10";
      aCellWidth[1]  = "80";
      aCellWidth[2]  = "10";

    var aCellAlign     = new Array();
      aCellAlign[0]  = "center";
      aCellAlign[1]  = "left";
      aCellAlign[2]  = "center";

    oGridServidores = new DBGrid('cntGrid');
    oGridServidores.nameInstance = 'oGridServidores';
    oGridServidores.setCheckbox(0);
    oGridServidores.allowSelectColumns(true);
    oGridServidores.setHeader(aHeader);
    oGridServidores.setCellWidth(aCellWidth);
    oGridServidores.setCellAlign(aCellAlign);
    oGridServidores.setHeight(300);
    oGridServidores.show($('cntGrid'));

    /**
    * Seta tamanho para a coluna "M" (Marcar Todos)
    */
    $('col1').style.width='7px';

    oWindowAux.show();
    oWindowAux.setShutDownFunction(function(){
        js_fecharWindow();
    });
    js_preencheGrid(oRetorno.aListaServidores);
}

function js_preencheGrid(aListaServidores) {
    oGridServidores.clearAll(true);
    aListaServidores.each(function (oServidor, iIndice) {

    var aLinha     = new Array();
        aLinha[0]  = oServidor.rh01_regist;
        aLinha[1]  = oServidor.z01_nome.urlDecode();
        aLinha[2]  = oServidor.rh05_recis.split('-').reverse().join('/');

    oGridServidores.addRow(aLinha, false, false);
    });
    oGridServidores.renderRows();
}

function js_fecharWindow() {
    oWindowAux.destroy();
}

/* FUNCOES PARA VERIFICACAO */
function js_verificaAnoMes() {
    var sAnoUsu = new String($F('anousu'));
    var sMesUsu = new String($F('mesusu'));
 
    if ( sAnoUsu.trim() == '' || sMesUsu.trim() == '' ) {
        alert('Competência não informada!');
        return false;
    }

    if ( sMesUsu < 1 || sMesUsu > 13  ) {
        alert('Mês inválido!');
        return false; 
    }
    return true;
}

function js_verificaCampos() {
    if (document.form1.contato.value == "") {
        alert("Informe o nome do contato.");
        document.form1.contato.focus();
        return false;
    } else if (document.form1.fone.value == "") {
        alert("Informe o fone de contato.");
        document.form1.fone.focus();
        return false;
    } else if (document.form1.dtrecfgts.value == "") {
        alert("Informe a Data recolhimento FGTS.");
        document.form1.dtrecfgts.focus();
        return false;
    }
    return true;
}
</script>