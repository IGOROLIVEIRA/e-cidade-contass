<?
require("libs/db_stdlib.php");
require("libs/db_utils.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_orcprojetolei_classe.php");
include("classes/db_orcorcsuplemtipo_classe.php");
include("classes/db_orcsuplem_classe.php");
include("dbforms/db_funcoes.php");

db_postmemory($HTTP_POST_VARS);
$clorcprojetolei         = new cl_orcprojetolei;
$clorcsuplemtipo         = new cl_orcsuplemtipo;
$clorcsuplem         = new cl_orcsuplem;

$db_opcao = 1;
$db_botao = true;
if (isset($incluir)) {

  $lErro    = false;
  $sErroMsg = "";
  db_inicio_transacao();

  $clorcprojetolei->o138_instit = db_getsession("DB_instit");
  $clorcprojetolei->incluir(null);
  if ($clorcprojetolei->erro_status == 0) {

    $sErroMsg .= $clorcprojetolei->erro_msg;
    $lErro     = true;
  }
  /**
   * incluimos uma lei de orçamento para esse projeto
   */
  if (!$lErro) {

    $oDaoOrcLei = db_utils::getDao("orclei");
    $oDaoOrcLei->o45_dataini = db_getsession("DB_anousu")."-01-01";
    $oDaoOrcLei->o45_datafim = db_getsession("DB_anousu")."-12-31";
    $oDaoOrcLei->o45_descr   = "Lei do Projeto de lei {$o138_numerolei}";
    $oDaoOrcLei->o45_numlei  = "{$o138_numerolei}";
    $oDaoOrcLei->o45_datalei = "{$o138_data}";
    if ($o138_altpercsuplementacao == 1) {
      $oDaoOrcLei->o45_tipolei = 4;
    } {
      $oDaoOrcLei->o45_tipolei = 3;
    }
    
    $oDaoOrcLei->incluir(null);
    if ($oDaoOrcLei->erro_status == 0) {

      $lErro     = true;
      $sErroMsg .= $oDaoOrcLei->erro_msg;
    }
  }

  /**
   * incluimos a ligação da lei com o projeto de lei
   */
  if (!$lErro) {

    $oDaoOrcLeiProjeto = db_utils::getDao("orcleiorcprojetolei");
    $oDaoOrcLeiProjeto->o140_orcprojetolei = $clorcprojetolei->o138_sequencial;
    $oDaoOrcLeiProjeto->o140_orclei        = $oDaoOrcLei->o45_codlei;
    $oDaoOrcLeiProjeto->incluir(null);
    if ($oDaoOrcLeiProjeto->erro_status == 0) {

      $lErro     = true;
      $sErroMsg .= $oDaoOrcLeiProjeto->erro_msg;
    }
  }

  /**
   * incluimos o decreto
   */
  if (!$lErro) {

    $oDaoDecreto               = db_utils::getDao("orcprojeto");
    $oDaoDecreto->o39_anousu   = db_getsession("DB_anousu");
    $oDaoDecreto->o39_codlei   = $oDaoOrcLei->o45_codlei;
    $oDaoDecreto->o39_data     = date("Y-m-d", db_getsession("DB_datausu"));
    $oDaoDecreto->o39_descr    = "Decreto do Projeto de lei {$o138_numerolei}";
    $oDaoDecreto->o39_lei      = "{$o138_numerolei}";
    $oDaoDecreto->o39_numero   = "{$o138_numerolei}";
    $oDaoDecreto->o39_texto    = "Decreto do Projeto de lei {$o138_numerolei}";
    $oDaoDecreto->o39_tipoproj = "2";
    //$oDaoDecreto->o39_tiposuplementacao = $o39_tiposuplementacao;
    $oDaoDecreto->incluir(null);
    if ($oDaoDecreto->erro_status == 0) {

      $lErro     = true;
      $sErroMsg .= $oDaoDecreto->erro_msg;
    }
  }
  /**
   * incluimos a ligação do projeto com o decreto
   */
  if (!$lErro) {

    $oDaoProjetoDecreto = db_utils::getDao("orcprojetoorcprojetolei");
    $oDaoProjetoDecreto->o139_orcprojeto    = $oDaoDecreto->o39_codproj;
    $oDaoProjetoDecreto->o139_orcprojetolei = $clorcprojetolei->o138_sequencial;
    $oDaoProjetoDecreto->incluir(null);
    if ($oDaoProjetoDecreto->erro_status == 0) {

      $lErro     = true;
      $sErroMsg .= $oDaoProjetoDecreto->erro_msg;
    }
  }
  if ($lErro) {

    $clorcprojetolei->erro_status = "0";
    $clorcprojetolei->erro_msg    = $sErroMsg;
  }
  db_fim_transacao($lErro);

}
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >
<table width="790" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
    <center>
	<?
	include("forms/db_frmorcprojetolei.php");
	?>
    </center>
	</td>
  </tr>
</table>
</body>
</html>

<script>
js_tabulacaoforms("form1","o138_numerolei",true,1,"o138_numerolei",true);
</script>
<?
if(isset($incluir)){
  if($clorcprojetolei->erro_status=="0"){

    $clorcprojetolei->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clorcprojetolei->erro_campo!=""){
      echo "<script> document.form1.".$clorcprojetolei->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clorcprojetolei->erro_campo.".focus();</script>";
    }
  }else {
  	db_msgbox($clorcprojetolei->erro_msg);
      echo "
      <script>
             parent.document.formaba.db_leialtorc.disabled=false;
             top.corpo.iframe_db_leialtorc.location.href='orc1_orcleialtorcamentaria001.php?o200_orcprojetolei=".@$clorcprojetolei->o138_sequencial."';
             parent.mo_camada('db_leialtorc');
      </script>
     ";
   // db_redireciona("orc1_orcleialtorcamentaria001.php?o200_orcprojetolei=".$clorcprojetolei->o138_sequencial." ");

    /**
     * redirecionamos para a inclusão do projeto
     */
  }
}
?>
