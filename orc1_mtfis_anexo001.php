<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_mtfis_anexo_classe.php");
include("dbforms/db_funcoes.php");
db_postmemory($HTTP_POST_VARS);
$clmtfis_anexo = new cl_mtfis_anexo;
$db_opcao = 1;
$db_botao = true;
$aEspecificacoes = array('Receita Total','Receitas Primárias (I)','Receitas Primárias Correntes','Receitas de Impostos, Taxas e Contribuições de Melhoria','Receitas de Contribuições','Receitas de Transferências Correntes','Demais Receitas Primárias Correntes','Receitas Primárias de Capital','Despesa Total','Despesas Primárias (II)','Despesas Primárias Correntes','Despesas de  Pessoal e Encargos Sociais','Outras Despesas Correntes','Despesas Primárias de Capital','Pagamento de Restos a Pagar de Despesas Primárias','Resultado Primário (III) = (I - II)','Juros, Encargos e Variáveis Monetárias Ativos (IV)','Juros, Encargos e Variáveis Monetárias Passivos (V)','Resultado Nominal (VI) = (III + (IV -V)','Dívida Pública Consolidada','Dívida Consolidada Líquida','Receita primária advindas de PPP','Despesas primária geradas por PPP','Impacto do saldo das PPPs (IX) = (VII - VIII)');
if(isset($incluir)){
  db_inicio_transacao();
  $clmtfis_anexo->sql_record($clmtfis_anexo->sql_query(null,'*','',"mtfisanexo_ldo = $mtfisanexo_ldo"));
  if($clmtfis_anexo->numrows > 0) {
    $clmtfis_anexo->excluir(null, "mtfisanexo_ldo = $mtfisanexo_ldo");
  }
  for($cont=1;count($aEspecificacoes) >= $cont; $cont++) {
    $especificacao = 'mtfisanexo_especificacao'.$cont;
    $clmtfis_anexo->mtfisanexo_especificacao = $$especificacao;
    for($cont2=1;3 >= $cont2; $cont2++) {
      if($cont2 == 1) {
        $valorcorrente  = 'mtfisanexo_valorcorrente1_'.$cont;
        $valorconstante = 'mtfisanexo_valorconstante1_'.$cont;
        $clmtfis_anexo->mtfisanexo_valorcorrente1  = $$valorcorrente;
        $clmtfis_anexo->mtfisanexo_valorconstante1 = $$valorconstante;
      }
      if($cont2 == 2) {
        $valorcorrente  = 'mtfisanexo_valorcorrente2_'.$cont;
        $valorconstante = 'mtfisanexo_valorconstante2_'.$cont;
        $clmtfis_anexo->mtfisanexo_valorcorrente2  = $$valorcorrente;
        $clmtfis_anexo->mtfisanexo_valorconstante2 = $$valorconstante;
      }
      if($cont2 == 3) {
        $valorcorrente  = 'mtfisanexo_valorcorrente3_'.$cont;
        $valorconstante = 'mtfisanexo_valorconstante3_'.$cont;
        $clmtfis_anexo->mtfisanexo_valorcorrente3  = $$valorcorrente;
        $clmtfis_anexo->mtfisanexo_valorconstante3 = $$valorconstante;
      }
    }
    if($clmtfis_anexo->mtfisanexo_valorcorrente1 == "")
      $clmtfis_anexo->mtfisanexo_valorcorrente1 = '0';

    if($clmtfis_anexo->mtfisanexo_valorcorrente2 == "")
      $clmtfis_anexo->mtfisanexo_valorcorrente2 = '0';

    if($clmtfis_anexo->mtfisanexo_valorcorrente3 == "")
      $clmtfis_anexo->mtfisanexo_valorcorrente3 = '0';

    if($clmtfis_anexo->mtfisanexo_valorconstante1 == "")
      $clmtfis_anexo->mtfisanexo_valorconstante1 = '0';

    if($clmtfis_anexo->mtfisanexo_valorconstante2 == "")
      $clmtfis_anexo->mtfisanexo_valorconstante2 = '0';

    if($clmtfis_anexo->mtfisanexo_valorconstante3 == "")
      $clmtfis_anexo->mtfisanexo_valorconstante3 = '0';

      $clmtfis_anexo->mtfisanexo_ldo = $mtfisanexo_ldo;
      $clmtfis_anexo->incluir($mtfisanexo_sequencial);

  }
  db_fim_transacao();
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
	include("forms/db_frmmtfis_anexo.php");
	?>
    </center>
	</td>
  </tr>
</table>
</body>
</html>
<?
if(isset($incluir)){
    echo "<script> alert('Incluído com sucesso'); </script>";
}
?>
