<?php
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_licatareg_classe.php");
include("dbforms/db_funcoes.php");
require_once("libs/db_utils.php");
require_once("libs/db_app.utils.php");
db_postmemory($HTTP_POST_VARS);
$cllicatareg = new cl_licatareg;
$db_opcao = 1;
$db_botao = true;
$sqlerro=false;
if(isset($incluir)){
  $datainicial = DateTime::createFromFormat('d/m/Y', $l221_dataini);
  $datafinal = DateTime::createFromFormat('d/m/Y', $l221_datafinal);
  
  if($l221_licitacao == "" || $l221_licitacao == null){
    $sqlerro=true;
    db_msgbox("Escolha uma Licitação!");
    
  }else if($l221_numata == "" || $l221_numata == null){
    $sqlerro=true;
    db_msgbox("Informe o número da Ata!");
  }else if($l221_fornecedor == 0){
    $sqlerro=true;
    db_msgbox("Selecione um fornecedor!");
  }else if($l221_dataini == "" || $l221_dataini == null){
    $sqlerro=true;
    db_msgbox("Insira uma Data Inicial!");
  }else if($l221_datafinal == "" || $l221_datafinal == null){
    $sqlerro=true;
    db_msgbox("Insira uma Data Final!");
  }else if($datainicial>$datafinal){
    $sqlerro=true;
    db_msgbox("Data inicial é maior que data final!");
  }
    $rsLicatareg = $cllicatareg->sql_record("select * from licatareg where l221_licitacao= $l221_licitacao and l221_fornecedor= $l221_fornecedor and l221_exercicio = '$l221_exercicio'");
    if(pg_num_rows($rsLicatareg)>0){
      $sqlerro=true;
      db_msgbox("Fornecedor dessa Licitação já inserido!");
    }

    $rsLicatareg = $cllicatareg->sql_record("select * from licatareg where l221_numata= '$l221_numata' and l221_exercicio= '$l221_exercicio'");
    if(pg_num_rows($rsLicatareg)>0 && $sqlerro == false){
      $sqlerro=true;
      db_msgbox("número da ata já inserido nesse ecercício!");
    }

  if($sqlerro == false){
    

      db_inicio_transacao();
      $cllicatareg->l221_licitacao = $l221_licitacao;
      $cllicatareg->l221_numata = $l221_numata;
      $cllicatareg->l221_exercicio = $l221_exercicio;
      $cllicatareg->l221_fornecedor = $l221_fornecedor;
      $cllicatareg->l221_dataini = $l221_dataini;
      $cllicatareg->l221_datafinal = $l221_datafinal;
      if($l221_datapublica != "" || $l221_datapublica != null){
        $cllicatareg->l221_datapublica = $l221_datapublica;
      }
      if($l221_veiculopublica != "" || $l221_veiculopublica != null){
        $cllicatareg->l221_veiculopublica = $l221_veiculopublica;
      }
      
      
      $cllicatareg->incluir();
      $codigo = $cllicatareg->l221_sequencial;
      $licitacao =$cllicatareg->l221_licitacao;
      $fornecedor = $cllicatareg->l221_fornecedor;
      
      db_fim_transacao();
    
  }
}
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >


    <center>
      
          <?php
            include("forms/db_frmlicatareg.php");
          ?>
    </center>


</body>
</html>
<script>
js_tabulacaoforms("form1","l221_numata",true,1,"l221_numata",true);
</script>
<?php
if (isset($incluir)) {

        if($sqlerro==false){
				echo " <script>
                parent.iframe_licatareg.location.href = 'lic1_licatareg002.php?chavepesquisa= $codigo';
                parent.iframe_licataregitem.location.href = 'lic1_licataregitem001.php?l222_licatareg= $codigo&licitacao=$licitacao&fornecedor=$fornecedor';
                parent.document.formaba.licataregitem.disabled=false;
		            parent.mo_camada('licataregitem');
	            </script> ";
        }

}
?>
