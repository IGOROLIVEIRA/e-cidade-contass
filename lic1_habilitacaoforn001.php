<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_habilitacaoforn_classe.php");
include("dbforms/db_funcoes.php");
require_once("classes/db_pcorcamforne_classe.php");
include("dbforms/db_liclicita_classe.php");
db_postmemory($HTTP_POST_VARS);
$clhabilitacaoforn = new cl_habilitacaoforn;
$clhabilitacaoforn->rotulo->label();
$clpcorcamforne    = new cl_pcorcamforne;
$clliclicita = new cl_liclicita;
$clcgm = new cl_cgm;

$db_opcao = 22;
$db_botao = false;
$erro = '';
if(isset($alterar) || isset($excluir) || isset($incluir)){
  $sqlerro = false;
}

if(isset($incluir) || isset($alterar)){
  $sqlLicitacao = $clliclicita->sql_query($l206_licitacao,'distinct l44_sequencial', null, null);
  $rsLicitacao = $clliclicita->sql_record($sqlLicitacao);
  $modalidade = db_utils::fieldsMemory($rsLicitacao, 0);
  $modalid = $modalidade->l44_sequencial;
  $sqlAbertura = $clliclicita->sql_query(null,"l20_datacria",null,"l20_codigo = $l206_licitacao");
  $rsAbertura = $clliclicita->sql_record($sqlAbertura);
  $data = db_utils::fieldsMemory($rsAbertura,0);
  $dtaberturaform = implode("/",(array_reverse(explode("-",$data->l20_datacria))));
  $dtabertura = DateTime::createFromFormat('d/m/Y',  $dtaberturaform);
  $dthabilitacao = DateTime::createFromFormat('d/m/Y',  $l206_datahab);
  $sqlCgm = $clcgm->sql_query($l206_fornecedor, 'distinct z01_cgccpf', null, null);
  $rsCgm = $clcgm->sql_record($sqlCgm);
  $cgm = db_utils::fieldsMemory($rsCgm, 0);

//    if(strlen($cgm->z01_cgccpf) == 14) {
//
//        if ($modalid == '49' || $modalid == '50' || $modalid == '53' || $modalid == '103') {
//            if ($l206_datavalidadefgts == '')
//                $erro_msg = 'Campo Data de Validade FGTS não informado';
//            if ($l206_dataemissaofgts == '')
//                $erro_msg = 'Campo Data de Emissão FGTS não informado';
//            if ($l206_numcertidaofgts == "")
//                $erro_msg = 'Campo Número de Certidão FGTS não informado';
//            if ($l206_datavalidadeinss == "")
//                $erro_msg = 'Campo Data de Validade INSS não informado';
//            if ($l206_dataemissaoinss == "")
//                $erro_msg = 'Campo Data de Emissão INSS não informado';
//            if ($l206_numcertidaoinss == "")
//                $erro_msg = 'Campo Número de Certidão INSS não informado';
//            if ($dthabilitacao == false)
//                $erro_msg = 'Campo Data de Habilitação não informado';
//            if ($dthabilitacao != false) {
//                if ($dthabilitacao < $dtabertura)
//                    $erro_msg = 'Data da habilitação deve ser igual ou maior que a data da abertura!';
//            }
//        }
//    }else{

//    }
    //    if($modalid == '48' || $modalid == '52' || $modalid == '53' || $modalid == '51'){
    //
    //    }

    if($dthabilitacao == false){
        $erro_msg = 'Campo Data de Habilitação não informado';
    }

  if($erro_msg){
    $sqlerro = true;
  }

}

if(isset($incluir)){
  if($sqlerro==false){
    db_inicio_transacao();
    $clhabilitacaoforn->incluir($l206_sequencial);
    $erro_msg = $clhabilitacaoforn->erro_msg;
    if($clhabilitacaoforn->erro_status==0){
      $sqlerro=true;
    }
    db_fim_transacao($sqlerro);
 }
}else if(isset($alterar)){
  if($sqlerro==false){
    db_inicio_transacao();
    $clhabilitacaoforn->alterar($l206_sequencial);
    $erro_msg = $clhabilitacaoforn->erro_msg;
    if($clhabilitacaoforn->erro_status==0){
      $sqlerro=true;
    }
    db_fim_transacao($sqlerro);
  }
}else if(isset($excluir)){
  if($sqlerro==false){
    db_inicio_transacao();
    $clhabilitacaoforn->excluir($l206_sequencial);
    $erro_msg = $clhabilitacaoforn->erro_msg;
    if($clhabilitacaoforn->erro_status==0){
      $sqlerro=true;
    }
    db_fim_transacao($sqlerro);
  }
}else if(isset($opcao)){
   $result = $clhabilitacaoforn->sql_record($clhabilitacaoforn->sql_query($l206_sequencial));
   if($result!=false && $clhabilitacaoforn->numrows>0){
     db_fieldsmemory($result,0);
   }
}

?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
  <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/prototype.js"></script>
  <script language="JavaScript" type="text/javascript" src="scripts/strings.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="100" marginheight="20" onLoad="a=1" >
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
    <center>
	<?
	include("forms/db_frmhabilitacaoforn.php");
	?>
    </center>
	</td>
  </tr>
</table>
</body>
</html>
<script>
js_tabulacaoforms("form1","l206_fornecedor",true,1,"l206_fornecedor",true);

var param2 = $('l206_licitacao').value;

top.corpo.iframe_db_cred.location.href='lic1_credenciamento001.php?l20_codigo='+param2;

</script>
<?
/*if(isset($incluir)){
  if($clhabilitacaoforn->erro_status=="0"){
    $clhabilitacaoforn->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clhabilitacaoforn->erro_campo!=""){
      echo "<script> document.form1.".$clhabilitacaoforn->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clhabilitacaoforn->erro_campo.".focus();</script>";
    }
  }else{
    $clhabilitacaoforn->erro(true,true);
  }
}*/
if(isset($alterar) || isset($excluir) || isset($incluir)){
    db_msgbox($erro_msg);
    // die();
    // if($erro_msg)
    //   print_r('1:'.$erro_msg);
    // if($erro_campo){
    //   print_r('2'.$erro_campo);
    // }
    // if($erro){
    //   db_msgbox('3.'.$erro);
    // }

    if($clhabilitacaoforn->erro_campo!=""){
      echo "<script> document.form1.".$clhabilitacaoforn->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clhabilitacaoforn->erro_campo.".focus();</script>";
    }
}
?>
