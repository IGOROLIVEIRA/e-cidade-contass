<?php
//ini_set('display_errors','on');

require_once("libs/db_stdlib.php");
require_once("libs/db_utils.php");
require_once("std/db_stdClass.php");
require_once("libs/db_libdicionario.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
include("dbforms/db_funcoes.php");
require_once("classes/db_pcorcam_classe.php");

db_postmemory($HTTP_POST_VARS);
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);

if(isset($uploadfile)) {

    $novo_nome = $_FILES["uploadfile"]["name"];

    // Nome do novo arquivo
    $nomearq = $_FILES["uploadfile"]["name"];

    $extensao = strtolower(substr($nomearq,-5));

    $diretorio = "libs/Pat_xls_import/";

    // Nome do arquivo temporário gerado no /tmp
    $nometmp = $_FILES["uploadfile"]["tmp_name"];

    // Seta o nome do arquivo destino do upload
    $arquivoDocument = "$diretorio"."$novo_nome";


    if($extensao != ".xlsx"){
        db_msgbox("Arquivo inválido! O arquivo selecionado deve ser do tipo .xlsx");
        unlink($nometmp);
        $lFail = true;
        return false;
    }

    $clpcorcam   = new cl_pcorcam();
    $result_fornecedores = $clpcorcam->sql_record($clpcorcam->sql_query_pcorcam_itemsol(null,"DISTINCT pc81_codproc",null,"pc20_codorc = $pc20_codorc  AND pc21_orcamforne = $pc21_orcamforne"));
    db_fieldsmemory($result_fornecedores,0);

    $nomepadrao = "prc_".$pc81_codproc."_".db_getsession('DB_instit')."."."xlsx";

    if($nomearq != $nomepadrao){
        db_msgbox("Arquivo inválido! O arquivo selecionado deve ser do padrão e-cidade");
        unlink($nometmp);
        $lFail = true;
        return false;
    }

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