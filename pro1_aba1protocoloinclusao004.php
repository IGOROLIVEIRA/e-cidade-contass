<?
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

require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/JSON.php");
require_once("dbforms/db_funcoes.php");
include("classes/db_db_depart_classe.php");
include("classes/db_db_depusu_classe.php");
include("classes/db_departdiv_classe.php");

$sDbIdUsuario    = db_getsession("DB_id_usuario");
$sqlU = "select id_usuario, nome from db_usuarios where id_usuario = ".$sDbIdUsuario;
$rs = db_query($sqlU);
$usuario =  db_fieldsmemory($rs,0);

$sDBDepartamento = db_getsession('DB_coddepto');
$sqlD = "select coddepto p101_coddeptoorigem, descrdepto descrdeptoo from db_depart where coddepto = ".$sDBDepartamento;
$rsD = db_query($sqlD);
$departamento =  db_fieldsmemory($rsD,0);

?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">

<script type="text/javascript" src="scripts/scripts.js"></script>

<link href="estilos.css" rel="stylesheet" type="text/css">

<style type="text/css">
strong {
  width: 106px;
  display: inline-block;
  text-align: right;
}
.container {
  width: 48%;
}
.formulario {
  margin-left: 10px;
  padding-bottom: 8px;
  float: left;
  display: inline-flex;
}

#motivo {
  line-height: 40px;
  vertical-align: top;
}

.datahora {
  width:84px;
  text-align: center;
  background-color: #DEB887;
}

</style>

</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="desabilitaAbas();">
<div class="container">
  <form name="form1" method="post" action="">
  <center>
    <fieldset>
      <legend id="titulo"><strong>Dados Processo</strong></legend>
      <div class="formulario" style="margin-top: 15px;">
        <strong>Protocolo:&nbsp;</strong>
        <?= db_input("p101_sequencial",10,"",true,"text",3,"","","","text-align: center"); ?>
        <strong style="margin-left: -53px;">Data:&nbsp;</strong>
        <input type="text" id="data" value="" readonly="true" class="datahora">
        <strong style="margin-left: -52px;">Hora:&nbsp;</strong>
        <input type="text" id="hora" value="" readonly="true" class="datahora">
      </div>
      <div class="formulario">
        <strong>Usuário:&nbsp;</strong>
        <div>
          <?= db_input("id_usuario",10,"",true,"text",3,"","","","text-align: center"); ?>
          <?= db_input("nome",37,"",true,"text",3); ?>
        </div>
      </div>
      <div class="formulario">
      <strong>Depto. Origem:&nbsp;</strong>
        <div>
          <?=
            db_input('p101_coddeptoorigem',10,"",true,'text',3,"","","","text-align: center;");
            db_input('descrdeptoo',37,"",true,'text',3,'');
          ?>
      </div>
      </div>
      <div class="formulario">
        <div>
          <?= db_ancora("<strong><u>Depto. Destino:&nbsp;</u></strong>","js_pesquisap101_coddeptodestino(true);","");?>
        </div>
        <div>
          <?=
            db_input('p101_coddeptodestino',10,"",true,'text',""," onchange='js_pesquisap101_coddeptodestino(false);'","","","text-align: center;");
            db_input('descrdeptod',37,"",true,'text',3,'');
          ?>
        </div>
      </div>

      <div class="formulario">
        <strong id="motivo">Observação:&nbsp;</strong>
        <textarea style="width: 358px;" maxlength="200" name="p101_observacao"></textarea>
      </div>
      <div class="formulario" id="anulado" style="display: none">
        <strong>Anulação:&nbsp;</strong>
        <input type="text" value="" id="dt_anulado" readonly="true" class="datahora">
      </div>
    </fieldset>
    <div style="text-align: center;">
      <input id="inclui" style="display: inline-block;" type="button" value="Incluir" onclick="incluir();">
      <input id="imprimi" style="display: none;" type="button" value="Imprimir" onclick="imprimir(document.form1.p101_sequencial.value);">
      <input type="button" value="Pesquisar" onclick="pesquisar();">
      <input id="alterar" style="display: none;" type="button" value="Alterar" onclick="alterarProtocolo(document.form1.p101_sequencial.value);">
      <input id="anular" style="display: none;" type="button" value="Anular" onclick="anularProtocolo(document.form1.p101_sequencial.value);">
      <input type="button" value="Limpar" onclick="limpar();">
      <input id="copiar" style="display: none;" type="button" value="Copiar" onclick="copiarProtocolo();">
    </div>
  </center>
  </form>
</div>
</body>
<script type="text/javascript" src="scripts/prototype.js"></script>
<script type="text/javascript" src="scripts/strings.js"></script>
<script type="text/javascript">

function novoAjax(params, onComplete) {

  var request = new Ajax.Request('pro4_protocolos.RPC.php', {
    method:'post',
    parameters:'json='+Object.toJSON(params),
    onComplete: onComplete
  });

}

function js_pesquisap101_coddeptoorigem(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('','db_iframe_depart','func_db_depart.php?funcao_js=parent.js_mostradb_depart1|coddepto|descrdepto&chave_t93_depart='+document.form1.p101_coddeptoorigem.value,'Pesquisa',true);
  }else{
     if(document.form1.p101_coddeptoorigem.value != ''){
        js_OpenJanelaIframe('','db_iframe_depart','func_db_depart.php?pesquisa_chave='+document.form1.p101_coddeptoorigem.value+'&funcao_js=parent.js_mostradb_depart&chave_t93_depart='+document.form1.p101_coddeptoorigem.value,'Pesquisa',false);
     }else{
       document.form1.p101_coddeptoorigem.value = '';
     }
  }
}
function js_mostradb_depart(chave,erro){
  document.form1.descrdeptoo.value = chave;
  if(erro==true){
    document.form1.p101_coddeptoorigem.focus();
    document.form1.p101_coddeptoorigem.value = '';
  }
}
function js_mostradb_depart1(chave1,chave2){
  document.form1.p101_coddeptoorigem.value = chave1;
  document.form1.descrdeptoo.value = chave2;
  db_iframe_depart.hide();
}


function js_pesquisap101_coddeptodestino(mostra){
  if(mostra==true){
    js_OpenJanelaIframe('','db_iframe_depart','func_db_depart.php?funcao_js=parent.js_mostradb_departdestino1|coddepto|descrdepto','Pesquisa',true);
  }else{
     if(document.form1.p101_coddeptodestino.value != ''){
        js_OpenJanelaIframe('','db_iframe_depart','func_db_depart.php?pesquisa_chave='+document.form1.p101_coddeptodestino.value+'&funcao_js=parent.js_mostradb_departdestino','Pesquisa',false);
     }else{
       document.form1.p101_coddeptodestino.value = '';
     }
  }
}
function js_mostradb_departdestino(chave,erro){
  document.form1.descrdeptod.value = chave;
  if(erro==true){
    document.form1.p101_coddeptodestino.focus();
    document.form1.p101_coddeptodestino.value = '';
  }
}
function js_mostradb_departdestino1(chave1,chave2){
  document.form1.p101_coddeptodestino.value = chave1;
  document.form1.descrdeptod.value = chave2;
  db_iframe_depart.hide();
}

function pesquisar() {
  js_OpenJanelaIframe('','db_iframe_protocolos','func_protocolos.php?funcao_js=parent.js_pesquisaProtocolo|p101_sequencial|id_usuario|nome|p101_coddeptoorigem|descrdeptoo|p101_coddeptodestino|descrdeptod|p101_dt_protocolo|p101_hora|p101_dt_anulado','Pesquisa',true);
}

function js_pesquisaProtocolo(chave1, chave2, chave3, chave4, chave5, chave6, chave7, chave8, chave9, chave10) {

  var id_sessao = <?php echo db_getsession("DB_id_usuario"); ?>;
  document.form1.p101_sequencial.value      = chave1;
  pesquisaProtocolo(chave1);
  document.form1.id_usuario.value           = chave2;
  document.form1.nome.value                 = chave3;
  document.form1.p101_coddeptoorigem.value  = chave4;
  document.form1.descrdeptoo.value          = chave5;
  document.form1.p101_coddeptodestino.value = chave6;
  document.form1.descrdeptod.value          = chave7;
  document.form1.data.value                 = chave8;
  document.form1.hora.value                 = chave9;

  if (chave2 == id_sessao || id_sessao == 1) {
    document.getElementById('anular').style.display = "inline-block";
    document.getElementById('alterar').style.display = "inline-block";
    document.getElementById('copiar').style.display = "inline-block";
  } else {
    document.getElementById('anular').style.display = "none";
    document.getElementById('alterar').style.display = "none";
    document.getElementById('copiar').style.display = "none";
  }

  if (chave10 == '') {
      document.getElementById('anulado').style.display = "none";
  } else {
      document.getElementById('anular').style.display = "none";
      document.getElementById('alterar').style.display = "none";
      document.getElementById('anulado').style.display = "inline-block";
      document.form1.dt_anulado.value = chave10;
  }


  document.getElementById('inclui').style.display  = "none";
  document.getElementById('imprimi').style.display = "inline-block";


  parent.document.formaba.autorizacaodeempenho.disabled=false;
  CurrentWindow.corpo.iframe_autorizacaodeempenho.location.href='pro1_aba2protprocesso004.php?pesquisa=1&protocolo='+chave1;

  parent.document.formaba.empenho.disabled=false;
  CurrentWindow.corpo.iframe_empenho.location.href='pro1_aba3protprocesso004.php?pesquisa=1&protocolo='+chave1;

  parent.document.formaba.ordemdecompra.disabled=false;
  CurrentWindow.corpo.iframe_ordemdecompra.location.href='pro1_aba4protprocesso004.php?pesquisa=1&protocolo='+chave1;

  parent.document.formaba.ordemdepagamento.disabled=false;
  CurrentWindow.corpo.iframe_ordemdepagamento.location.href='pro1_aba5protprocesso004.php?pesquisa=1&protocolo='+chave1;

  parent.document.formaba.slip.disabled=false;
  CurrentWindow.corpo.iframe_slip.location.href='pro1_aba6protprocesso004.php?pesquisa=1&protocolo='+chave1;

  db_iframe_protocolos.hide();
}

function incluir() {

  datahora   = new Date;
  intMinutes = datahora.getMinutes();
  if (intMinutes < 10) {
    minutes = "0"+intMinutes;
  } else {
      minutes = intMinutes;
  }

  var hora = datahora.getHours() + ":" + minutes;
  var usuario    = document.form1.id_usuario.value;
  var origem     = document.form1.p101_coddeptoorigem.value;
  var destino    = document.form1.p101_coddeptodestino.value;
  var observacao = document.form1.p101_observacao.value;

  var origemVazio     = origem  == '';
  var destinoVazio    = destino == '';
  var observacaoVazio = observacao  == '';

  if (origemVazio) {
    alert('Informe o departamento origem!');
    return;
  }
  else if (destinoVazio) {
    alert('Informe o departamento destino!');
    return;
  }
  else if (origem == destino) {
    alert('Os departamentos origem e destino devem ser diferentes!');
    return;
  }
  else {
    incluirprotocolo(usuario, origem, destino, observacao, hora);
  }
}
function incluirprotocolo(iUsuario, iOrigem, iDestino, iObservacao, iHora) {
  var params = {
    exec: 'insereProtocolo',
    usuario: iUsuario,
    origem: iOrigem,
    destino: iDestino,
    observacao: iObservacao,
    hora: iHora
  };

  novoAjax(params, function(e) {
    var oRetorno = JSON.parse(e.responseText);
      if (oRetorno.status == 1) {
        document.form1.p101_sequencial.value = oRetorno.protocolo;
        datahora   = new Date;
        intMinutes = datahora.getMinutes();
        if (intMinutes < 10) {
          minutes = "0"+intMinutes;
        } else {
            minutes = intMinutes;
        }
        document.form1.data.value = ("0" + datahora.getDate()).substr(-2) + "/" + ("0" + (datahora.getMonth() + 1)).substr(-2) + "/" + datahora.getFullYear();
        document.form1.hora.value = datahora.getHours() + ":" + minutes;
        document.getElementById('inclui').style.display  = "none";
        document.getElementById('imprimi').style.display = "inline-block";
        document.getElementById('alterar').style.display = "inline-block";
        document.getElementById('anular').style.display = "inline-block";
        document.getElementById('copiar').style.display = "inline-block";

        parent.document.formaba.autorizacaodeempenho.disabled=false;
        CurrentWindow.corpo.iframe_autorizacaodeempenho.location.href='pro1_aba2protprocesso004.php?protocolo='+oRetorno.protocolo;

        parent.document.formaba.empenho.disabled=false;
        CurrentWindow.corpo.iframe_empenho.location.href='pro1_aba3protprocesso004.php?protocolo='+oRetorno.protocolo;

        parent.document.formaba.ordemdecompra.disabled=false;
        CurrentWindow.corpo.iframe_ordemdecompra.location.href='pro1_aba4protprocesso004.php?protocolo='+oRetorno.protocolo;

        parent.document.formaba.ordemdepagamento.disabled=false;
        CurrentWindow.corpo.iframe_ordemdepagamento.location.href='pro1_aba5protprocesso004.php?protocolo='+oRetorno.protocolo;

        parent.document.formaba.slip.disabled=false;
        CurrentWindow.corpo.iframe_slip.location.href='pro1_aba6protprocesso004.php?protocolo='+oRetorno.protocolo;
      } else {
          alert(oRetorno.erro);
        return;
      }
    });
}

function desabilitaAbas(){
  parent.document.formaba.autorizacaodeempenho.disabled=true;
  parent.document.formaba.empenho.disabled=true;
  parent.document.formaba.ordemdecompra.disabled=true;
  parent.document.formaba.ordemdepagamento.disabled=true;
  parent.document.formaba.slip.disabled=true;
}

function imprimir(protocolo) {

    var query = "";
      query += ("protocolo=" + protocolo),

      jan = window.open(
        "pro2_protocolo002.php?" + query,
        "",
        'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0'
      );
      jan.moveTo(0,0);
}

function pesquisaProtocolo(protocolo) {
  var params = {
    exec: 'pesquisaProtocolo',
    protocolo:protocolo
  };

  novoAjax(params, function(e) {
    var oRetorno = JSON.parse(e.responseText);
      if (oRetorno.status == 1) {
        document.form1.p101_observacao.value = oRetorno.protocolo.p101_observacao;
      } else {
        alert(oRetorno.erro);
      }
    });
}

function alterarProtocolo(protocolo) {
  var destino    = document.form1.p101_coddeptodestino.value;
  var observacao = document.form1.p101_observacao.value;

  var params = {
    exec: 'alteraProtocolo',
    protocolo:protocolo,
    destino: destino,
    observacao: observacao
  };

  novoAjax(params, function(e) {
    var oRetorno = JSON.parse(e.responseText);
      if (oRetorno.status == 1) {
        alert("Alteração realizadas com sucesso!");
      } else {
        alert(oRetorno.erro);
      }
    });
}

function anularProtocolo(protocolo) {
  var params = {
    exec: 'anularProtocolo',
    protocolo:protocolo
  };

  novoAjax(params, function(e) {
    var oRetorno = JSON.parse(e.responseText);
      if (oRetorno.status == 1) {
        alert("Protocolo anulado com sucesso!");
        window.location.reload();
        return;
      } else {
        alert(oRetorno.erro);
      }
    });
}

function copiarProtocolo() {
  js_OpenJanelaIframe('','db_iframe_protocolos','func_protocolos.php?funcao_js=parent.salvarCopiaProtocolo|p101_sequencial','Pesquisa',true);
}

function salvarCopiaProtocolo(p101_sequencial) {
  var protocolo = document.form1.p101_sequencial.value;
  var salvar = confirm("Deseja copiar os dados do protocolo "+p101_sequencial+" para o protocolo atual?");
  if (salvar == true) {
    var params = {
      exec: 'salvaCopiaProtocolo',
      protocolo:protocolo,
      copiaProtocolo:p101_sequencial
    };

    novoAjax(params, function(e) {
      var oRetorno = JSON.parse(e.responseText);
        if (oRetorno.status == 1) {
          CurrentWindow.corpo.iframe_autorizacaodeempenho.location.href='pro1_aba2protprocesso004.php?protocolo='+protocolo;
          CurrentWindow.corpo.iframe_empenho.location.href='pro1_aba3protprocesso004.php?protocolo='+protocolo;
          CurrentWindow.corpo.iframe_ordemdecompra.location.href='pro1_aba4protprocesso004.php?protocolo='+protocolo;
          CurrentWindow.corpo.iframe_ordemdepagamento.location.href='pro1_aba5protprocesso004.php?protocolo='+protocolo;
          CurrentWindow.corpo.iframe_slip.location.href='pro1_aba6protprocesso004.php?protocolo='+protocolo;
          alert("Protocolo copiado com sucesso!");
          db_iframe_protocolos.hide();
        } else {
          alert(oRetorno.erro);
        }
    });
  }
  else {
      return;
  }
}

function limpar() {
  window.location.reload();
  document.form1.p101_sequencial.value = "";
  document.form1.p101_coddeptodestino.value = "";
  document.form1.p101_observacao.value = "";
}
</script>
</html>

