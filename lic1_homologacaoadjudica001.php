<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_homologacaoadjudica_classe.php");
include("classes/db_parecerlicitacao_classe.php");
include("classes/db_precomedio_classe.php");
include("classes/db_liclicita_classe.php");
include("dbforms/db_funcoes.php");

db_postmemory($HTTP_POST_VARS);
$clhomologacaoadjudica = new cl_homologacaoadjudica;
$clitenshomologacao    = new cl_itenshomologacao;
$clparecerlicitacao    = new cl_parecerlicitacao;
$clprecomedio          = new cl_precomedio;
$clliclicita           = new cl_liclicita;

$db_opcao = 1;
$db_botao = true;
if(isset($incluir)){

  if($l20_usaregistropreco == 'f' && empty($l202_dataadjudicacao)) {
    echo "<script>alert('Campo Data Adjudicação é Obrigatório');</script>";
    db_redireciona('lic1_homologacaoadjudica001.php');
  }

  $parecer     = pg_num_rows($clparecerlicitacao->sql_record($clparecerlicitacao->sql_query(null,'*',null,"l200_licitacao = $l202_licitacao ")));
  $precomedio  = pg_num_rows($clprecomedio->sql_record($clprecomedio->sql_query(null,'*',null,'l209_licitacao ='.$l202_licitacao)));
  
  if ( $clhomologacaoadjudica->verificaPrecoReferencia($l202_licitacao) >= 1 || $precomedio >= 1 ) {
    
    if ($parecer >= 1) {

      $tipoparecer     = pg_num_rows($clparecerlicitacao->sql_record($clparecerlicitacao->sql_query(null,'*',null,"l200_licitacao = $l202_licitacao and l200_tipoparecer = 3 ")));

      if ($tipoparecer < 1) {
        echo
        "<script>alert('Tipo do Parecer não é Juridico - Julgamento')</script>";
        db_redireciona('lic1_homologacaoadjudica001.php');
      }

      $parecer2     = pg_num_rows($clparecerlicitacao->sql_record($clparecerlicitacao->sql_query(null,'*',null,"l200_licitacao = $l202_licitacao and l200_data <= '$l202_datahomologacao' and l200_data <= '$l202_dataadjudicacao' ")));

      if ($parecer2 >= 1) {

        db_inicio_transacao();

        $clhomologacaoadjudica->incluir($l202_sequencial);

        $l203_itens = explode(',', $l203_itens[0]);

        foreach ($l203_itens as $item) {
          $clitenshomologacao->l203_item = $item;
          $clitenshomologacao->l203_homologaadjudicacao = $clhomologacaoadjudica->l202_sequencial;
          $clitenshomologacao->incluir(null);
        }

        $clhomologacaoadjudica->alteraLicitacao($l202_licitacao, 10);

        db_fim_transacao();

      }else{

        $clliclicita->sql_record($clliclicita->sql_query('','*',''," l20_codigo = $l202_licitacao and l20_usaregistropreco = 't' "));

        if ($clliclicita->numrows == 1) {

          $parecer3     = pg_num_rows($clparecerlicitacao->sql_record($clparecerlicitacao->sql_query(null,'*',null,"l200_licitacao = $l202_licitacao and l200_data <= '$l202_datahomologacao' ")));
          if ($parecer3 >= 1) {

            db_inicio_transacao();

            $clhomologacaoadjudica->incluir($l202_sequencial);

            $l203_itens = explode(',', $l203_itens[0]);

            foreach ($l203_itens as $item) {
              $clitenshomologacao->l203_item = $item;
              $clitenshomologacao->l203_homologaadjudicacao = $clhomologacaoadjudica->l202_sequencial;
              $clitenshomologacao->incluir(null);
            }

            $clhomologacaoadjudica->alteraLicitacao($l202_licitacao, 10);

            db_fim_transacao();

          }else{
            echo
            "<script>alert('Data da Homologação é menor que a data do parecer')</script>";
            db_redireciona('lic1_homologacaoadjudica001.php');
          }

        }else{

        echo
        "<script>alert('Data da Homologação ou Adjudicação é menor que a data do parecer')</script>";
        db_redireciona('lic1_homologacaoadjudica001.php');

        }

      }

    }else if($parecer < 1 || empty($parecer)){

      echo 
        "<script>alert('Falta Cadastro do Parecer')</script>";

      db_redireciona('lic1_homologacaoadjudica001.php');
    
    }

  }else if($clhomologacaoadjudica->verificaPrecoReferencia($l202_licitacao) < 1){

    echo 
        "<script>alert('Falta Preco Referencia')</script>";

    db_redireciona('lic1_homologacaoadjudica001.php');
  }

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
 <center>
  <fieldset style=" margin-top: 30px; width: 500px; height: 400px;">
  <legend>Homologacao Adjudicacao</legend>
	<?
	include("forms/db_frmhomologacaoadjudica.php");
	?>
    </fieldset>
  </center>
<?
db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>
</body>
</html>
<script>
js_tabulacaoforms("form1","l202_licitacao",true,1,"l202_licitacao",true);
</script>
<?
if(isset($incluir)){
  if($clhomologacaoadjudica->erro_status=="0"){
    $clhomologacaoadjudica->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($clhomologacaoadjudica->erro_campo!=""){
      echo "<script> document.form1.".$clhomologacaoadjudica->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$clhomologacaoadjudica->erro_campo.".focus();</script>";
    }
  }else{
    $clhomologacaoadjudica->erro(true,true);
  }
}
?>
