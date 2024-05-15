<?
require_once("model/relatorios/Relatorio.php");
require_once("std/DBDate.php");
include("libs/db_sql.php");
require_once("libs/db_utils.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_app.utils.php");
require_once("classes/db_pcforne_classe.php");

$oForne = new cl_pcforne;
db_postmemory($HTTP_GET_VARS);
$head1 = "";
$head3 = "FORNECEDORES BLOQUEADOS";
$where = '';

//ini_set('display_errors', 1);
//error_reporting(E_ALL);

if($data_ini){
	$dataInicial = new DBDate($data_ini);
	$dataInicial = $dataInicial->getDate();
	$head5 = "Período: a partir de {$data_ini}";
}

if($data_fim){
	$dataFinal = new DBDate($data_fim);
	$dataFinal = $dataFinal->getDate();
	$head5 = "Período: até {$data_fim}";
}

if(!$data_ini && !$data_fim){
	$head5 = "Período: não informado";
}elseif($data_ini && $data_fim){
	$head5 = "Período: de {$data_ini} a {$data_fim}";
}

$head6 = "Filtrar por: ";
switch ($tipo_fornecedor){
	case 't':
        $head6 .= "Todos";

        $where .= ' (pc60_databloqueio_ini is not null) or (pc60_databloqueio_fim is not null) ';
		break;

	case 'a':
		  /* Impedimentos não vigentes */
		  $head6 .= "Impedimentos não vigentes";
      
      $where = " ((pc60_databloqueio_ini BETWEEN '{$dataInicial}' AND '{$dataFinal}') OR pc60_databloqueio_ini < '{$dataFinal}') 
                    AND (pc60_databloqueio_fim BETWEEN '{$dataInicial}' AND '{$dataFinal}') ";
    
		break;

	case 'i':
        /* Impedimentos vigentes */
		$head6 .= "Impedimentos vigentes";
    
    $where = " ((pc60_databloqueio_ini BETWEEN '{$dataInicial}' AND '{$dataFinal}') OR pc60_databloqueio_ini < '{$dataFinal}') 
                  AND pc60_databloqueio_fim > '{$dataFinal}'";

		break;
}

$orderBy .= 'z01_nome asc ';

$mPDF  = new Relatorio('', 'A4'); //RELATORIO LANDSCAPE, PARA PORTRAIT, DEIXE SOMENTE A4
$mPDF->addInfo($head1, 1);
$mPDF->addInfo($head3, 3);
$mPDF->addInfo($head4, 4);
$mPDF->addInfo($head5, 5);
$mPDF->addInfo($head6, 6);
db_inicio_transacao();
try {
  /*CONSULTA*/

  $sSql        = $oForne->sql_query(null,"*",$orderBy . ' limit 500 ', $where);
  $rsSql       = db_query($sSql);
  $rsResultado = db_utils::getCollectionByRecord($rsSql);

  if(!$rsSql) {
    throw new DBException('Erro ao Executar Query' . pg_last_error());
  }
  db_fim_transacao(false); //OK Sem problemas. Commit
}
catch(Exception $oException) {
  db_fim_transacao(true); //Erro, executou rollback
  db_redireciona("db_erros.php?fechar=true&db_erro=Não forão encontrados registros.");
  print_r($oException);
}
/*CARREGA O HTML NO BUFFER*/
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>Relatório</title>
  <link rel="stylesheet" type="text/css" href="estilos/relatorios/padrao.style.css">

</head>
<body>
  <div class="content">
    <table id="table" style=" width:100%; border-collapse: collapse; font-size:10px;">

      <?php

      if(!pg_num_rows($rsSql)):
          ?>
          <tr>
              <td>
                  <br/><br/>
                  <b>
                      <?php
                      if($data_ini && $data_fim){
                            $trecho_complementar = " para o período de $data_ini a $data_fim";
                      }

                      if($data_ini && !$data_fim){
                          $trecho_complementar = " a partir do período inicial de $data_ini";
                      }

					  if(!$data_ini && $data_fim){
						  $trecho_complementar = " até o período final de $data_fim";
					  }

                      ?>
                    Em consulta realizada <?= $trecho_complementar ?>, o sistema verificou que não há fornecedores com 
                    impedimentos <?=$tipo_fornecedor == 'a' ? 'não' : ''?> vigentes no referido período.
                  </b>
                  <br/><br/><br/>
              </td>
          </tr>

      <?php endif;

      foreach($rsResultado as $oRegistro):
        ?>
      <tr>
        <td align="right">
          <b>Fornecedor: </b>

        </td>
        <td align="left">
          <?php echo $oRegistro->z01_nome; ?>
        </td>
        <td>
          <b>Início do bloqueio: </b> <?php echo (db_formatar($oRegistro->pc60_databloqueio_ini, "d")!="")?db_formatar($oRegistro->pc60_databloqueio_ini, "d"):"Não informado"; ?>
        </td>
        <td>
          <b>Fim do bloqueio: </b> <?php echo (db_formatar($oRegistro->pc60_databloqueio_fim, "d")!="")?db_formatar($oRegistro->pc60_databloqueio_fim, "d"):"Não informado"; ?>
        </td>
      </tr>

      <tr>
        <td></td>
        <td colspan="3"><b>Motivo:</b> <?php echo $oRegistro->pc60_motivobloqueio; ?></td>
      </tr>
      <tr>
        <td colspan="4">
          <br>

        </td>
      </tr>
      <?php
      endforeach;

      ?>

      <tr>
        <td colspan="4">
          <br>
          <hr>
          <b>Total de registros:</b> <?php echo pg_num_rows($rsSql); ?>
        </td>
      </tr>
      <tr>
        <!-- RODAPÉ -->
      </tr>
    </table>
  </div>
</body>
</html>

<?php
$html = ob_get_contents();
ob_end_clean();
try {
  $mPDF->WriteHTML(utf8_encode($html));
  $mPDF->Output();
}
catch(Exception $e) {
  print_r($e->getMessage());
}
?>
