<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBseller Servicos de Informatica
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
require_once("libs/db_app.utils.php");
require_once("libs/db_utils.php");
require_once("dbforms/db_funcoes.php");
require_once("classes/db_db_config_classe.php");


/**
 * Busca todos os arquivos disponiveis
 */
$oSkin  = new SkinService();
$aSkins = $oSkin->getSkins();

$cldbconfig         = new cl_db_config();

if(isset($_POST['oRdenarPor'])){

  $valor = $_POST['oRdenarPor'];
  $codigoEmp = $_POST['codigo'];
  echo "<script>alert($codigoEmp)</script>";
  $cldbconfig->orderdepart = $valor;
  $cldbconfig->alterarOrdenacao($codigoEmp);
  echo "<script>alert('Parâmetro salvo com sucesso!')</script>";
}

$codigo = db_getsession("DB_instit");
$result = $cldbconfig->sql_record($cldbconfig->sql_query(null,"*",null,"codigo = {$codigo}"));

if($cldbconfig->numrows>0){
  $resultado = db_utils::fieldsMemory($result,0);
  $valorOrde = $resultado->orderdepart;

  if($valorOrde!=null){
    $oRdenarPor = $valorOrde;
  }
}

?>
<html>
  <head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <?php
      db_app::load("estilos.css, scripts.js, strings.js, prototype.js, widgets/DBToogle.widget.js");
    ?>
  </head>
  <body class="body-default">
    <div class="container" style="width:700px !important;">
      <form name="form1" method="post" action="con4_parametrosinstituicao001.php" enctype="multipart/form-data">

        <fieldset>

          <legend>Parâmetros por Instituição</legend>

          <fieldset>
            <legend>Ordenar Setores</legend>

            <table>
              <tr>
                <td nowrap title="Skin Padrão" style="width:137px;">
                  <label class="bold" for="sSkinDefault" id="lbl_sSkinDefault">Ordenar por:</label>
                </td>
                <td>
                  <?php 
                  $valores = array("1"=>"Ordem Alfabética", "2"=>"Ordem Crescente", "3"=>"Ordem Decrescente", "4"=>"Ordenar por Prioridade");
                  db_select('oRdenarPor', $valores, true, 1,"style='width:172px;'"); 
                  ?>
                  <input type="hidden" id="codigo" name="codigo" value="<?echo db_getsession("DB_instit");?>">
                </td>
              </tr>
            </table>


          </fieldset>

          

        <input name="incluir" type="submit" id="db_opcao" value="Salvar" >

      </form>
    </div>
    <?php db_menu( db_getsession("DB_id_usuario"),
                   db_getsession("DB_modulo"),
                   db_getsession("DB_anousu"),
                   db_getsession("DB_instit") ); ?>
  </body>
  <script type="text/javascript">

    /**
     * Toogle do Skin do Usuário
     */
    var oSkinUsuario     = new DBToogle('parametrosSkinUsuario',false);

    var sUrlRPC          = 'con4_parametros.RPC.php';
    var sCaminhoMensagem = 'configuracao.configuracao.con4_parametros001.'

    /**
     * Salvamos os parametros
     */
    function js_processar() {
       
      

      if ( $F('oRdenarPor') == "") {
        
        alert( _M( sCaminhoMensagem + 'valida_zero', {'sCampo' : 'Dias para expirar link de ativação'}));
        return false;
      }

      var oParametros               = new Object();
      oParametros.exec              = 'salvarPorInstituicao';
      oParametros.soRdenarPor      = $('oRdenarPor').value;
      oParametros.scodigo          = $('codigo').value;
      alert(oParametros.soRdenarPor);

      var oDadosRequisicao          = new Object();
      oDadosRequisicao.method       = 'POST';
      oDadosRequisicao.parameters   = 'json='+Object.toJSON(oParametros);
      oDadosRequisicao.onComplete   = function(oAjax){
  
        var oRetorno = eval("("+oAjax.responseText+")");
        if (oRetorno.iStatus == "2") {

          alert( oRetorno.sMessage.urlDecode() );
          return;
        }

        alert( oRetorno.sMessage.urlDecode() );
        return;
      }
      var oAjax  = new Ajax.Request( sUrlRPC, oDadosRequisicao );
    }

  </script>
</html>