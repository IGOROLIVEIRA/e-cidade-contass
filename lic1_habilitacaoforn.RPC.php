<?php
require_once 'libs/db_stdlib.php';
require_once 'libs/db_conecta.php';
require_once 'libs/db_sessoes.php';
require_once 'libs/db_usuariosonline.php';
require_once 'libs/JSON.php';
require_once 'libs/db_utils.php';
require_once ("classes/db_liclicita_classe.php");
require_once ("classes/db_cgm_classe.php");

$oJson             = new services_json();
$oParam            = $oJson->decode(str_replace("\\","",$_POST["json"]));
$oErro             = new stdClass();
$oRetorno          = new stdClass();
$clliclicita       = new cl_liclicita();
$clcgm             = new cl_cgm();

$oRetorno->status  = 1;

switch ($oParam->exec) {
    case 'verificaforn':
        $rsTipoCompra = $clliclicita->sql_record($clliclicita->getTipocomTribunal($oParam->l20_codigo));
        db_fieldsmemory($rsTipoCompra, 0)->l03_pctipocompratribunal;

        if($l03_pctipocompratribunal == "100" || $l03_pctipocompratribunal == "101" || $l03_pctipocompratribunal == "103" || $l03_pctipocompratribunal == "104"){
            $rsfornecedor = $clcgm->sql_record($clcgm->sql_query_file($oParam->fornecedor));
            db_fieldsmemory($rsfornecedor, 0)->z01_cgccpf;
            if(strlen($z01_cgccpf) == 11){
                $oRetorno->liberarhabilitacao = false;
            }else{
                $oRetorno->liberarhabilitacao = true;
            }
        }else{
            $oRetorno->liberarhabilitacao = true;
        }
    break;
}
echo json_encode($oRetorno);
