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


require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_utils.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_rhpesrescisao_classe.php");

db_postmemory($HTTP_POST_VARS);

$clrhpesrescisao = new cl_rhpesrescisao;
$rotulocampo = new rotulocampo;

$rotulocampo->label("h83_regist");
$rotulocampo->label("z01_nome");

?>
<html>
  <head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <style type="text/css">
      #datai{
        width: 78px;
      }
    </style>
  </head>
  <body class="body-default">
    <div class="container">
      <form name="form1" method="post" action="" >
        <fieldset>
          <legend>Termo de Estágio</legend>

          <table>
            <tr>
              <td nowrap title="<?=@$Th83_regist?>">
                 <?
                   db_ancora(@$Lh83_regist,"js_pesquisah83_regist(true);",$db_opcao);
                 ?>
              </td>
              <td>
                <?
                  db_input('h83_regist',8,$Ih83_regist,true,'text',$db_opcao," onchange='js_pesquisah83_regist(false);'")
                ?>
                <?
                  db_input('z01_nome',35,$Iz01_nome,true,'text',3,'')
                ?>
              </td>
            </tr>
            <tr>
              <td nowrap title="Data Emissão">
                <label class="bold" for="dataemissao" id="lbl_dataemissao">Data Emissão:</label>
              </td>
              <td>
                <?php
                  db_inputdata("dataemissao", @$dataemissao_dia, @$dataemissao_mes, @$dataemissao_ano, true, 'text', 1);
                ?>
              </td>
            </tr>
          </table>
        </fieldset>

        <input name="relatorio" id="relatorio" type="button" value="Processar" onclick="js_emite();" >

      </form>
    </div>

    <?php
      db_menu( db_getsession("DB_id_usuario"),
               db_getsession("DB_modulo"),
               db_getsession("DB_anousu"),
               db_getsession("DB_instit") );
    ?>
  </body>
  <script>

    function js_limparCampos(){

      $('h83_regist').value = '';
      $('z01_nome').value    = '';
      $('dataemissao').value    = '';
    }

    function js_emite() {

      if (isNaN(document.form1.h83_regist.value)) {

        alert("Matrícula Inválida.");
        $('h83_regist').value = '';
        document.form1.h83_regist.focus();
        return false
      }

      if (document.form1.h83_regist.value == '') {
        alert("Selecione um Estagiário.");
        document.form1.h83_regist.focus();
        return false
      }

      if (document.form1.dataemissao_dia.value == '') {
        alert("Preencha uma data para emissão.");
        document.form1.dataemissao.focus();
        return false
      }

      qry  = "?regist="+ document.form1.h83_regist.value;
      qry += "&dataemissao=" + document.form1.dataemissao_ano.value+'-'+document.form1.dataemissao_mes.value+'-'+document.form1.dataemissao_dia.value;

      jan = window.open( 'rec2_termoestagio002.php' + qry,
                         '',
                         'width=' + (screen.availWidth-5) + ',height='+(screen.availHeight-40) + ',scrollbars=1,location=0 ' );
      jan.moveTo(0,0);

      js_limparCampos();
    }

    function js_pesquisah83_regist(mostra) {
      if(mostra==true){
        js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_rhpessoal','func_rhestagiocurricular.php?funcao_js=parent.js_mostrarhpessoal1|h83_regist|z01_nome','Pesquisa',true);
      }else{
         if(document.form1.h83_regist.value != ''){
            js_OpenJanelaIframe('CurrentWindow.corpo','db_iframe_rhpessoal','func_rhestagiocurricular.php?pesquisa_chave='+document.form1.h83_regist.value+'&funcao_js=parent.js_mostrarhpessoal','Pesquisa',false);
         }else{
           document.form1.z01_nome.value = '';
         }
      }
    }
    function js_mostrarhpessoal(chave,erro) {
      document.form1.z01_nome.value = chave;
      if(erro==true){
        document.form1.h83_regist.focus();
        document.form1.h83_regist.value = '';
      }
    }
    function js_mostrarhpessoal1(chave1,chave2) {
      document.form1.h83_regist.value = chave1;
      document.form1.z01_nome.value = chave2;
      db_iframe_rhpessoal.hide();
    }
  </script>
</html>
