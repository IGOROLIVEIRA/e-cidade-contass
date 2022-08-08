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
require_once("dbforms/db_funcoes.php");
require_once("libs/db_app.utils.php");
require_once("classes/db_entesconsorciados_classe.php");

$clentesconsorciados = new cl_entesconsorciados;
$clentesconsorciados->rotulo->label();

$clrotulo = new rotulocampo;
$clrotulo->label("c215_cgm");
$clrotulo->label("z01_nome");

$db_opcao = 1;

db_postmemory($HTTP_POST_VARS);
db_postmemory($_GET);

?>
<html>
<head>
  <?php
    db_app::load('scripts.js, estilos.css');
  ?>
</head>

<body bgcolor="#CCCCCC">
<form name="form1" id="form1">

  <fieldset style="width: 420px; margin: 35px auto 10px auto">
    <legend><strong>Relatório de Rateio</strong></legend>

    <table align="center">
      <tr>
        <td>
          <strong>
          <?php
            db_ancora("Ente Consorciado:","js_pesquisac215_cgm(true);",$db_opcao);
          ?>
          </strong>
        </td>

        <td>
          <?php
            db_input('c215_sequencial',8,@$c215_sequencial, true, 'hidden', 1, '');
            db_input('c215_cgm',8,@$c215_cgm, true, 'text', 1, "onchange='js_pesquisac215_cgm(false);'");
            db_input('z01_nome',30,$Iz01_nome,true,'text',3,'');
          ?>
        </td>
      </tr>

      <tr>
        <td>
          <strong>Mês:</strong>
        </td>

        <td>
          <?php
            $aMeses = array("01"=>"Janeiro", "02"=>"Fevereiro", "03"=>"Março", "04"=>"Abril", "05"=>"Maio",
              "06"=>"Junho", "07"=>"Julho", "08"=>"Agosto", "09"=>"Setembro", "10"=>"Outubro", "11"=>"Novembro",
              "12"=>"Dezembro");
            db_select('mes', $aMeses, true, 4, "style='width: 295px'");
          ?>
        </td>
      </tr>

      <tr>
        <td>
          <strong>Impressão Por:</strong>
        </td>
        <td>
          <?php
            $aTipoArquivo = array("pdf" => "PDF", "csv" => "CSV");
            db_select('tipoarquivo', $aTipoArquivo, true, 4, "style='width: 295px'");
          ?>
        </td>
      </tr>

    </table>

  </fieldset>

  <div style="text-align: center">
    <input name="gerar" type="button" value="Processar" onclick="js_consultar();">
  </div>

  <?
    db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
  ?>

<script>
function js_pesquisac215_cgm (mostra) {
  if (mostra==true) {
    js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_entesconsorciados','func_entesconsorciados.php?funcao_js=parent.js_mostra|c215_cgm|z01_nome|c215_sequencial','Pesquisa',true);
  } else {
    codent =  document.form1.c215_cgm.value;
    if (codent != '') {
      js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_entesconsorciados','func_entesconsorciados.php?codente='+codent+'&funcao_js=parent.js_mostra02','Pesquisa',false);
    } else {
      document.form1.z01_nome.value = '';
    }
  }
}
function js_mostra(codent, nome, sequencial){
  db_iframe_entesconsorciados.hide();
  document.form1.c215_cgm.value = codent;
  document.form1.z01_nome.value = nome;
  document.form1.c215_sequencial.value = sequencial;
}

function js_mostra02(chave, seq, erro){
  if(erro==true){
    document.form1.c215_cgm.focus();
    document.form1.c215_cgm.value = '';
    document.form1.c215_sequencial.value = '';
    document.form1.z01_nome.value = chave;
  } else {
    document.form1.z01_nome.value = chave;
    document.form1.c215_sequencial.value = seq;
  }
}

function js_consultar(){

  sQuery = '1=1';

  oForm  = document.form1;

  if (oForm.c215_cgm.value == '') {
    alert('Nenhum Ente Consorciado Informado!');
    return false;
  }

  sQuery += "&c215_cgm="        + oForm.c215_cgm.value;
  sQuery += "&c215_sequencial=" + oForm.c215_sequencial.value;
  sQuery += "&mes="             + oForm.mes.value;
  sQuery += "&tipoarquivo="     + oForm.tipoarquivo.value;

  jan = window.open('con2_relatoriorateio002.php?query=' + sQuery, '', 'width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');

  jan.moveTo(0,0);


}
</script>
</form>
</body>
</html>
