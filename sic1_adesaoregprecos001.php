<?
require("libs/db_stdlib.php");
require("libs/db_conecta.php");
include("libs/db_sessoes.php");
include("libs/db_usuariosonline.php");
include("classes/db_adesaoregprecos_classe.php");
include("classes/db_itensregpreco_classe.php");
include("dbforms/db_funcoes.php");
include("classes/db_condataconf_classe.php");
parse_str($HTTP_SERVER_VARS["QUERY_STRING"]);
db_postmemory($HTTP_POST_VARS);

$clcflicita        = new cl_cflicita;
$cladesaoregprecos = new cl_adesaoregprecos;
$clitensregpreco   = new cl_itensregpreco;

$db_botao = true;
$sqlerro  = false;

$db_opcao = isset($alterar) ? 2 : 1;

if(isset($incluir) || isset($alterar)){

  $dataAux = $si06_dataadesao_ano+1;
  $resultado = db_query("select * from adesaoregprecos where si06_dataadesao >= '$si06_dataadesao_ano-01-01 00:00:00' 
  and si06_dataadesao < '$dataAux-01-01 00:00:00' and si06_numeroadm = $si06_numeroadm");

  $objeto = db_utils::fieldsMemory($resultado, 0);

  echo var_dump($objeto);

  if($objeto->si06_dataadesao != null){
        $erro_msg = 'Erro, o número do processo de adesão informado já está sendo utilizado no exercício de ' . $si06_dataadesao_ano;
        $sqlerro = true;
  }

    if(!intval($si06_edital) && !$sqlerro){
        $erro_msg = 'Valor do campo Edital inválido. Verifique!';
        $sqlerro = true;
    }

    
	$sDataAta = join('-', array_reverse(explode('/', $si06_dataata)));
	$sDataAbertura = join('-', array_reverse(explode('/', $si06_dataabertura)));

	if($sDataAta > $sDataAbertura && !$sqlerro){
		$sqlerro = true;
		$erro_msg = 'Data da Ata é maior que a Data de Abertura!';
	}

	$oDaoPcProc = db_utils::getDao('pcproc');
	$rsProc = $oDaoPcProc->sql_record($oDaoPcProc->sql_query_file($si06_processocompra));
	$sDataCotacao = db_utils::fieldsMemory($rsProc, 0)->pc80_data;

	if($sDataCotacao > $sDataAbertura && !$sqlerro){
		$sqlerro = true;
		$erro_msg = 'Data da Cotação é maior que a Data de Abertura!';
	}

}
if(!$sqlerro){
	if(isset($incluir)){
		$db_opcao = 1;

		db_inicio_transacao();

//  /**
//    * Verificar Encerramento Periodo Contabil
//    */
//  if (!empty($si06_dataadesao)) {
//    $clcondataconf = new cl_condataconf;
//    if (!$clcondataconf->verificaPeriodoContabil($si06_dataadesao)) {
//      $cladesaoregprecos->erro_msg = $clcondataconf->erro_msg;
//      $cladesaoregprecos->erro_status="0";
//      $sqlerro  = true;
//    }
//  }

		/**
		 * Verificar Encerramento Periodo Patrimonial
		 */
		if (!empty($si06_dataadesao)) {
			$clcondataconf = new cl_condataconf;
			if (!$clcondataconf->verificaPeriodoPatrimonial($si06_dataadesao)) {
				$cladesaoregprecos->erro_msg = $clcondataconf->erro_msg;
				$cladesaoregprecos->erro_status="0";
				$sqlerro  = true;
			}
		}

		if (!$sqlerro) {
			$cladesaoregprecos->si06_anocadastro = db_getsession('DB_anousu');
			if(db_getsession('DB_anousu') >= 2020){
				$cladesaoregprecos->si06_edital = $si06_edital;
				$cladesaoregprecos->si06_cadinicial = 1;
				$cladesaoregprecos->si06_exercicioedital = db_getsession('DB_anousu');
			}
			$cladesaoregprecos->incluir(null);
		}
		if($cladesaoregprecos->erro_status=="0"){

			$cladesaoregprecos->erro(true,false);
			$db_botao=true;
			echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
			if($cladesaoregprecos->erro_campo!=""){
				echo "<script> document.form1.".$cladesaoregprecos->erro_campo.".style.backgroundColor='#99A9AE';</script>";
				echo "<script> document.form1.".$cladesaoregprecos->erro_campo.".focus();</script>";
			}
		}else{
			if(!$sqlerro){
				$sSql = "select * from adesaoregprecos order by si06_sequencial desc limit 1;";
				$rsResult = pg_query($sSql);
				db_fieldsmemory($rsResult,0);
				$_SESSION["codigoAdesao"] = $si06_sequencial;
				echo "<script>
                alert('Inclusão efetuada com sucesso');
                parent.document.formaba.db_itens.disabled=false;
                parent.mo_camada('db_itens');
                top.corpo.iframe_db_itens.location.href='sic1_itensregpreco001.php?codigoAdesao=".$si06_sequencial."';
            </script>";
			}
			//$cladesaoregprecos->erro(true,true);
		}
		db_fim_transacao();
	}

    if(isset($alterar)){
      db_inicio_transacao();
      $db_opcao = 2;
      $sqlerro  = false;

    //  /**
    //    * Verificar Encerramento Periodo Contabil
    //    */
    //  if (!empty($si06_dataadesao)) {
    //    $clcondataconf = new cl_condataconf;
    //    if (!$clcondataconf->verificaPeriodoContabil($si06_dataadesao)) {
    //      $cladesaoregprecos->erro_msg = $clcondataconf->erro_msg." $si06_dataadesao";
    //      $cladesaoregprecos->erro_status="0";
    //      $sqlerro  = true;
    //    }
    //  }

        /**
         * Verificar Encerramento Periodo Patrimonial
         */
        $dataadesao = db_utils::fieldsMemory(db_query($cladesaoregprecos->sql_query_file($si06_sequencial,"si06_dataadesao")),0)->si06_dataadesao;

        if (!empty($si06_dataadesao)) {
            $clcondataconf = new cl_condataconf;
            if (!$clcondataconf->verificaPeriodoPatrimonial($dataadesao) || !$clcondataconf->verificaPeriodoPatrimonial($si06_dataadesao)) {
                $cladesaoregprecos->erro_msg = $clcondataconf->erro_msg;
                $cladesaoregprecos->erro_status="0";
                $sqlerro  = true;
            }
        }

      if ($sqlerro == false) {
         $cladesaoregprecos->alterar($si06_sequencial);
      }

        if($si06_processoporlote == 2){
            $sSqlItens = $clitensregpreco->sql_query(null, "itensregpreco.*", null, "si07_sequencialadesao = {$si06_sequencial}");
            $rsItens   = $clitensregpreco->sql_record($sSqlItens);

            for($count = 0; $count < pg_num_rows($rsItens); $count++){
                $oItem = db_utils::fieldsMemory($rsItens, $count);

                $clitensregpreco->si07_descricaolote = '';
                $clitensregpreco->si07_numerolote    = '';
                $clitensregpreco->si07_sequencialadesao = $si06_sequencial;
                $clitensregpreco->alterar($oItem->si07_sequencial);
            }
        }
      db_fim_transacao();
      $_SESSION["codigoAdesao"] = $si06_sequencial;
      echo "<script>
        parent.document.formaba.db_itens.disabled=false;
        top.corpo.iframe_db_itens.location.href='sic1_itensregpreco001.php?codigoAdesao=".$si06_sequencial."';
        </script>";

    }else if(isset($chavepesquisa) || isset($_SESSION["codigoAdesao"])){
        $db_opcao = 2;
       if (!isset($chavepesquisa)) {
        $chavepesquisa = $_SESSION["codigoAdesao"];
       }
       unset($_SESSION["codigoAdesao"]);
       $result = $cladesaoregprecos->sql_record($cladesaoregprecos->sql_query($chavepesquisa));
       db_fieldsmemory($result,0);
       $db_botao = true;

    }

    if(isset($excluir)){
        if(!$si06_sequencial){
            $sqlerro = true;
            $erro_msg = 'Adesão de Registro de Preço ainda não cadastrada.';
        }else{
			db_inicio_transacao();
			$db_opcao = 3;

			/**
			 * Verificar Encerramento Periodo Patrimonial
			 */
			$dataadesao = db_utils::fieldsMemory(db_query($cladesaoregprecos->sql_query_file($si06_sequencial,"si06_dataadesao")),0)->si06_dataadesao;

			if(!empty($si06_dataadesao)) {
				$clcondataconf = new cl_condataconf;
				if(!$clcondataconf->verificaPeriodoPatrimonial($dataadesao)) {
					$cladesaoregprecos->erro_msg = $clcondataconf->erro_msg;
					$cladesaoregprecos->erro_status="0";

					$sqlerro  = true;
					$erro_msg=$clcondataconf->erro_msg;
				}
			}

			if ($sqlerro == false) {
				$clitensregpreco = new cl_itensregpreco;
				$clitensregpreco->excluir(null," si07_sequencialadesao = $si06_sequencial");
				$cladesaoregprecos->excluir($si06_sequencial);
			}

			db_fim_transacao();
        }

    }else if(isset($chavepesquisa) || isset($_SESSION["codigoAdesao"])){
       //$db_opcao = 3;
       if (!isset($chavepesquisa)) {
        $chavepesquisa = $_SESSION["codigoAdesao"];
       }
       unset($_SESSION["codigoAdesao"]);
       echo "<script>
        parent.document.formaba.db_itens.disabled=false;
        top.corpo.iframe_db_itens.location.href='sic1_itensregpreco001.php?codigoAdesao=".$chavepesquisa."';
        </script>";
       $result = $cladesaoregprecos->sql_record($cladesaoregprecos->sql_query($chavepesquisa,"*,cgm.z01_nome as z01_nomeorg,c.z01_nome as z01_nomeresp"));
       db_fieldsmemory($result,0);
       $db_botao = true;

    }

}

if($sqlerro){
	echo "<script>";
	echo "alert('$erro_msg');";
	echo "</script>";
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
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 40px;">
  <tr>
    <td height="430" align="left" valign="top" bgcolor="#CCCCCC">
    <center>
	<?
	include("forms/db_frmadesaoregprecos.php");
	?>
    </center>
	</td>
  </tr>
</table>
</body>
</html>
<script>
//js_tabulacaoforms("form1","si06_orgaogerenciador",true,1,"si06_orgaogerenciador",true);
</script>
<?
/*if(isset($incluir)){
  if($cladesaoregprecos->erro_status=="0"){

    $cladesaoregprecos->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($cladesaoregprecos->erro_campo!=""){
      echo "<script> document.form1.".$cladesaoregprecos->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$cladesaoregprecos->erro_campo.".focus();</script>";
    }
  }else{
    $cladesaoregprecos->erro(true,true);
  }
}*/
if(isset($alterar)){
  if($cladesaoregprecos->erro_status=="0"){
    $cladesaoregprecos->erro(true,false);
    $db_botao=true;
    echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    if($cladesaoregprecos->erro_campo!=""){
      echo "<script> document.form1.".$cladesaoregprecos->erro_campo.".style.backgroundColor='#99A9AE';</script>";
      echo "<script> document.form1.".$cladesaoregprecos->erro_campo.".focus();</script>";
    }
  }else{
    $cladesaoregprecos->erro(true,false);
    $db_opcao=22;
  }
}
if($db_opcao==22 && !$sqlerro){
  echo "<script>document.form1.pesquisar.click();</script>";
}
if(isset($excluir) && !$sqlerro){
  if($cladesaoregprecos->erro_status=="0"){
    $cladesaoregprecos->erro(true,false);
  }else{
    $cladesaoregprecos->erro(true,true);
  }
}
if($db_opcao==33){
  echo "<script>document.form1.pesquisar.click();</script>";
}

?>
