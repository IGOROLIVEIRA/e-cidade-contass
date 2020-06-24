<?
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2012  DBselller Servicos de Informatica
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
require_once("libs/db_utils.php");
require_once("std/db_stdClass.php");
require_once("libs/db_libdicionario.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
require_once("classes/db_licobrasanexo_classe.php");

db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
$clrotulo = new rotulocampo;

$lFail    = false;
if(isset($uploadfile)) {

  //codigo da medicao
  $medicao = $_GET["medicao"];

  //legenda da foto
  $legenda = $_GET["descricao"];

  // Nome do novo arquivo
  $nomearq = $_FILES["uploadfile"]["name"];

  $extensao = strtolower(substr($nomearq,-4));

  if($extensao == ".pdf"){
    $novo_nome = md5(time()).$extensao;
  }else{
    $novo_nome = md5(time()).$extensao;
  }

  $diretorio = "imagens/obras/";

  // Nome do arquivo temporário gerado no /tmp
  $nometmp = $_FILES["uploadfile"]["tmp_name"];

  // Seta o nome do arquivo destino do upload
  $arquivoDocument = "$diretorio"."$novo_nome";


  if($extensao != ".pdf"){
    db_msgbox("Arquivo inválido! O arquivo selecionado deve ser do tipo PDF");
    unlink($nometmp);
    $lFail = true;
    return false;
  }

  $cllicobrasanexo = new cl_licobrasanexo();
  $cllicobrasanexo->obr04_licobrasmedicao = $medicao;
  $cllicobrasanexo->obr04_codimagem       = $novo_nome;
  $cllicobrasanexo->obr04_legenda         = "foto sem legenda";
  $cllicobrasanexo->incluir();

  // Faz um upload do arquivo para o local especificado
  if(  move_uploaded_file($_FILES["uploadfile"]["tmp_name"],$diretorio.$novo_nome)) {

    $href = $arquivoDocument;

  }else{

    db_msgbox("Erro ao enviar arquivo.");
    unlink($nometmp);
    $lFail = true;
    return false;
  }
}
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <link href="estilos.css" rel="stylesheet" type="text/css">
  <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
  <?php
  db_app::load("scripts.js, prototype.js, widgets/windowAux.widget.js,strings.js");
  db_app::load("widgets/dbtextField.widget.js, dbViewCadEndereco.classe.js");
  db_app::load("dbmessageBoard.widget.js, dbautocomplete.widget.js,dbcomboBox.widget.js, datagrid.widget.js");
  db_app::load("estilos.css,grid.style.css");
  ?>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<div id="teste2">
  <input type="text" value="<?=@$novo_nome;?>" id="nomeanexo">
</div>
</body>
</html>
<script>
  <? if (isset($_GET["clone"]) && !isset($href)) {
  echo "var cloneFormulario='{$_GET["clone"]}';\n";
  ?>

  if (parent.$(cloneFormulario)) {
    var formteste = parent.$(cloneFormulario).cloneNode(true);
    $('teste2').appendChild(formteste);
    formteste.submit();
  }
  <?}?>

</script>
