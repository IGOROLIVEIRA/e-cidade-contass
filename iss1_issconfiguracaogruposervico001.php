<?php
require_once 'libs/db_stdlib.php';
require_once 'libs/db_conecta.php';
require_once 'libs/db_sessoes.php';
require_once 'libs/db_usuariosonline.php';
require_once 'libs/db_utils.php';
require_once 'libs/db_app.utils.php';

require_once 'dbforms/db_funcoes.php';
require_once 'classes/db_issconfiguracaogruposervico_classe.php';

db_postmemory($HTTP_POST_VARS);

$oPost = db_utils::postMemory($_POST);

$oDaoConfiguracaoGrupo = new cl_issconfiguracaogruposervico();

$db_opcao = 1;
$db_botao = true;

if ( isset($oPost->incluir) ) {

  db_inicio_transacao();
  $oDaoConfiguracaoGrupo->incluir($q136_sequencial);
  db_fim_transacao();
}
?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<?php db_app::load("estilos.css, grid.style.css, scripts.js, strings.js, prototype.js"); ?>
</head>
<body class="body-default">
<div class="container">
		<?php include 'forms/db_frmissconfiguracaogruposervico.php'; ?>
	</center>

	<?php db_menu(db_getsession("DB_id_usuario"), db_getsession("DB_modulo"), db_getsession("DB_anousu"), db_getsession("DB_instit")); ?>
</div>
<script>
js_tabulacaoforms("form1", "q136_issgruposervico", true, 1, "q136_issgruposervico", true);
</script>

<?php
if ( isset($oPost->incluir) ) {

  if ( $oDaoConfiguracaoGrupo->erro_status =="0" ) {

    $oDaoConfiguracaoGrupo->erro(true, false);
    $db_botao = true;

    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";

    if ( $oDaoConfiguracaoGrupo->erro_campo != "") {

      echo "<script> document.form1.".$oDaoConfiguracaoGrupo->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$oDaoConfiguracaoGrupo->erro_campo.".focus();</script>";
    }

  }else{

    $oDaoConfiguracaoGrupo->erro(true,true);
  }
}
?>

</body>
</html>
