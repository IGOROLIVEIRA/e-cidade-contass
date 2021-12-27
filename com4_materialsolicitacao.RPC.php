<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */

require_once "libs/db_stdlib.php";
require_once "libs/db_conecta.php";
require_once "libs/db_sessoes.php";
require_once "libs/db_usuariosonline.php";
require_once "dbforms/db_funcoes.php";
require_once "libs/JSON.php";

$oJson             = new services_json();
$oParam            = $oJson->decode(str_replace("\\","",$_POST["json"]));
$oRetorno          = new stdClass();
$oRetorno->erro    = false;
$oRetorno->message = '';

try {

  db_inicio_transacao();

  switch ($oParam->exec) {

    case "getDadosMaterial":

      if (empty($oParam->iCodigoMaterial)) {
        throw new Exception("Código do material não informado.");
      }

      $oDaoMaterial = new cl_pcmater();
      $sSqlMaterial = $oDaoMaterial->sql_query_file( null, "pcmater.pc01_complmater", null, "pc01_codmater = {$oParam->iCodigoMaterial}");
      $rsMateiral   = $oDaoMaterial->sql_record( $sSqlMaterial );

      if ($oDaoMaterial->numrows < 1) {
        throw new Exception("Material {$oParam->iCodigoMaterial} não encontrado.");
      }

      $oDadosMaterial = db_utils::fieldsMemory($rsMateiral, 0);

      $oRetorno->dados = new StdClass();
      $oRetorno->dados->descricaocomplemento = urlencode($oDadosMaterial->pc01_complmater);

      break;

      case "getDadosElementos":

          $clpcmaterele = new cl_pcmaterele();
          $sql_record = $clpcmaterele->sql_record($clpcmaterele->sql_query($oParam->pc_mat, null, "o56_codele,o56_descr,o56_elemento", "o56_descr"));
          $dad_select = array ();
          for ($i = 0; $i < $clpcmaterele->numrows; $i++) {
              db_fieldsmemory($sql_record, $i);
              
              $dad_select[$i][0] = $o56_codele;
              $dad_select[$i][1] = $o56_elemento;
              $dad_select[$i][2] = urlencode($o56_descr);
          }

          $arrayRetornoEle = array();
                foreach ($dad_select as $keyRow => $Row){
    
                    $objValorEle = new stdClass();
                    foreach ($Row as $keyCel => $cell){

                        if($keyCel == 0){
                            $objValorEle->codigo   =  $cell;
                        }
                        if($keyCel == 1){
                          $objValorEle->elemento    =  $cell;
                        }
                        if($keyCel == 2){
                          $objValorEle->nome    =  $cell;
                        }
                    }
                    
                    $arrayRetornoEle[] = $objValorEle;
                }
      
          $oRetorno->dados = $arrayRetornoEle;

       break; 
  }

  db_fim_transacao(false);

} catch (Exception $eErro) {

  db_fim_transacao(true);
  $oRetorno->erro  = true;
  $oRetorno->message = urlencode($eErro->getMessage());
}

echo $oJson->encode($oRetorno);