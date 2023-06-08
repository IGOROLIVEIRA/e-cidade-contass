<?php
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_utils.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_sql.php");

require ("classes/db_protpagordem_classe.php");
require ("classes/db_protempautoriza_classe.php");
require ("classes/db_protmatordem_classe.php");
require ("classes/db_protocolos_classe.php");
require ("classes/db_protempenhos_classe.php");
require ('classes/db_protslip_classe.php');
require ("classes/db_empempenho_classe.php");

db_postmemory($HTTP_POST_VARS);
db_postmemory($HTTP_GET_VARS);

$clprotocolos = new cl_protocolos();
$clempempenho = new cl_empempenho();

$campos = 'distinct p101_sequencial, a.descrdepto as descrorigem,b.descrdepto as descrdestino,p101_observacao,p101_sequencial,p101_hora,p101_coddeptoorigem,p101_coddeptodestino,p101_dt_protocolo, p101_dt_anulado';

if(!empty($e54_autori)){
    $result = $clprotocolos->sql_record($clprotocolos->sql_consulta_protocolo('',"$campos",'p101_sequencial desc',"p102_autorizacao = $e54_autori"));
    $sTipo  = 'AUTORIZAÇÃO';
    $sValor = $e54_autori;
    $iProtocolo = db_utils::fieldsMemory($result, 0)->p101_sequencial;
}elseif(!empty($e60_numemp)){
    $result = $clprotocolos->sql_record($clprotocolos->sql_consulta_protocolo('',"$campos,p103_numemp",'p101_sequencial desc',"p103_numemp = $e60_numemp"));
    $sTipo = 'EMPENHO';
    $iProtocolo = db_utils::fieldsMemory($result, 0)->p101_sequencial;
    $resultempenho = $clempempenho->sql_record($clempempenho->sql_query_file($e60_numemp));
    $sValor = db_utils::fieldsMemory($resultempenho, 0)->e60_codemp.'/'.db_utils::fieldsMemory($resultempenho, 0)->e60_anousu;

}elseif(!empty($m51_codordem)){
    $result = $clprotocolos->sql_record($clprotocolos->sql_consulta_protocolo('',"$campos",'p101_sequencial desc',"p104_codordem = $m51_codordem"));
    $sTipo = 'ORDEM DE COMPRA';
    $sValor = $m51_codordem;
    $iProtocolo = db_utils::fieldsMemory($result, 0)->p101_sequencial;
}elseif(!empty($e53_codord)){
    $result = $clprotocolos->sql_record($clprotocolos->sql_consulta_protocolo('',"$campos",'p101_sequencial desc',"p105_codord = $e53_codord"));
    $sTipo = 'ORDEM DE PAGAMENTO';
    $sValor = $e53_codord;
    $iProtocolo = db_utils::fieldsMemory($result, 0)->p101_sequencial;
}elseif(!empty($k17_codigo)){
    $result = $clprotocolos->sql_record($clprotocolos->sql_consulta_protocolo('',"$campos",'p101_sequencial desc',"p106_slip = $k17_codigo"));
    $sTipo = 'SLIP';
    $sValor = $k17_codigo;
    $iProtocolo = db_utils::fieldsMemory($result, 0)->p101_sequencial;
}

    $iProtocolo = db_utils::fieldsMemory($result, 0)->p101_sequencial;

?>

<html>
<head>
    <title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta http-equiv="Expires" CONTENT="0">
    <script language="JavaScript" type="text/javascript" src="scripts/scripts.js"></script>
    <link href="estilos.css" rel="stylesheet" type="text/css">
    <script>
        function js_imprime(cod){
            jan = window.open('pro2_relconspro002.php?codproc='+cod,'','width='+(screen.availWidth-5)+',height='+(screen.availHeight-40)+',scrollbars=1,location=0 ');
            jan.moveTo(0,0);
        }
    </script>
    </head>
<body>
      <table  border=0>
          <tr>
              <td  nowrap><b><? echo $sTipo ?>: </b></td>
              <td nowrap><? echo $sValor ?> </td>
          </tr>
          <tr>
              <td>&nbsp</td>
          </tr> <tr>
              <td>&nbsp</td>
          </tr> <tr>
              <td>&nbsp</td>
          </tr>


      </table>
        <table bgcolor='#cccccc' width='100%' cellspacing=0 cellpading=0 border=1>
          <tr>
              <td colspan=7 align='center'><b>Andamentos</b></td>
          </tr>
          <tr>
              <td width="5%" align='center'><b>Protocolo</b></td>
              <td width="5%" align='center'><b>Data</b></td>
              <td width="5%" align='center'><b>Hora</b></td>
              <td width="30%" align='center'><b>Departamento Origem</b></td>
              <td width="30%" align='center'><b>Departamento Destino</b></td>
              <td width="25%" align='center'><b>Observação</b></td>
              <td width="25%" align='center'><b>Data da Anulação</b></td>

          </tr>
          <?
          if(pg_num_rows($result) > 0 ) {
              for ($iCont = 0; $iCont < pg_num_rows($result); $iCont++) {

                  $oAndamento = db_utils::fieldsMemory($result, $iCont);

                  ?>
                  <tr>
                      <td width="5%" align='center'><? echo $oAndamento->p101_sequencial ?></td>
                      <td width="5%"
                          align='center'><? echo implode('/', array_reverse(explode('-', $oAndamento->p101_dt_protocolo))) ?></td>
                      <td width="5%" align='center'><? echo $oAndamento->p101_hora ?></td>
                      <td width="30%" align='center'><? echo $oAndamento->p101_coddeptoorigem ?>
                          -<? echo $oAndamento->descrorigem ?></td>
                      <td width="30%" align='center'><? echo $oAndamento->p101_coddeptodestino ?>
                          -<? echo $oAndamento->descrdestino ?></td>
                      <td width="25%" align='center'><? echo $oAndamento->p101_observacao ?></td>
                      <? if(!empty($oAndamento->p101_dt_anulado)){ ?>
                      <td width="25%" align='center'><? echo implode('/', array_reverse(explode('-', $oAndamento->p101_dt_anulado)))  ?></td>
                      <? }else{ ?>
                      <td width="25%" align='center'></td>
                      <? } ?>
                  </tr>

                  <?
              }
          }else{
              ?>
              <tr>
                  <td colspan=7 align='center'><b>Nenhum protocolo encontrado para este documento</b></td>
              </tr>
              <?
          }
          ?>
          </table>

</body>
</html>
