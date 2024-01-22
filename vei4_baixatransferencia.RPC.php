<?php
require_once('classes/db_transferenciaveiculos_classe.php');
require_once('classes/db_veiculostransferencia_classe.php');
require_once('classes/db_veicbaixa_classe.php');
require_once('classes/db_veiccentral_classe.php');
require_once('classes/db_veiccadcentral_classe.php');
require_once('classes/db_veicresp_classe.php');
require_once('classes/db_veiculoscomb_classe.php');
require_once('classes/db_tipoveiculos_classe.php');
require_once("std/db_stdClass.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_utils.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/JSON.php");

db_postmemory($_POST);

$oJson  = new services_json();
$oParam = $oJson->decode(str_replace("\\","",$_POST["json"]));

$oRetorno          = new stdClass();
$oRetorno->status  = 1;

$nInstit = db_getsession('DB_instit');
$nAnoUsu = date("Y", db_getsession("DB_datausu"));

switch ($oParam->exec){

    case "buscaVeiculosDepartamentos":

        try {

            $rsBusca = buscaVeiculosDepartamentos($oParam->departamento_atual, $nInstit);
            $aBuscaVeiculos = db_utils::getCollectionByRecord($rsBusca);

            $oRetorno->veiculos = array();

            foreach ($aBuscaVeiculos as $aVeiculos) {

                $oNovoVeiculo = new stdClass();
                $oNovoVeiculo->codigo          = $aVeiculos->ve01_codigo;
                $oNovoVeiculo->placa           = utf8_encode($aVeiculos->ve01_placa);
                $oNovoVeiculo->tipo            = utf8_encode($aVeiculos->case);
                $oNovoVeiculo->condigoAnterior = $aVeiculos->ve01_codigoant;
                $oNovoVeiculo->unidadeAnterior = $aVeiculos->ve01_codunidadesub;

                $oRetorno->veiculos[] = $oNovoVeiculo;

            }

        } catch (Exception $e) {
            $oRetorno->erro = $e->getMessage();
        }

        break; // buscaVeiculosDepartamentos

    case 'insereTransfVeiculo':


        try {
            db_inicio_transacao();

            $oRetorno->veiculos[] = $oParam->veiculos;
            $oData = new stdClass();
            $oData->data  = new DBDate($oParam->data);
            $data  = $oData->data->getDate();
            $oRetorno->data = $oParam->data;

            $oRetorno->departamento_atual = $oParam->departamento_atual;
            $oRetorno->departamento_destino = $oParam->departamento_destino;

            $oTransferencia = new cl_transferenciaveiculos;
            $oTransferencia->ve80_motivo           = $oParam->motivo;
            $oTransferencia->ve80_dt_transferencia = $data;
            $oTransferencia->ve80_id_usuario       = db_getsession('DB_id_usuario');
            $oTransferencia->ve80_coddeptoatual    = $oRetorno->departamento_atual;
            $oTransferencia->ve80_coddeptodestino  = $oRetorno->departamento_destino;
            $oTransferencia->incluir(null);

            if ($oTransferencia->erro_status == "0") {
                throw new Exception($oTransferencia->erro_msg);
            }

            $rsTransferencia = buscaTransferencia();
            $oRetorno->transferencia = $transferencia = db_utils::fieldsMemory($rsTransferencia,0);
            $rsUnidadeSubAnterior = buscaVeiculos($oParam->veiculos);
            $rsUnidadeAtual   = buscaUnidade($oParam->departamento_atual, $nAnoUsu ,$nInstit);
            $rsUnidadeDestino = buscaUnidade($oParam->departamento_destino, $nAnoUsu ,$nInstit);

            $aUnidadeAnterior = db_utils::fieldsMemory($rsUnidadeAtual,0);
            $aUnidadeAtual    = db_utils::fieldsMemory($rsUnidadeDestino,0);
            $aVeiculos        = db_utils::fieldsMemory($rsUnidadeSubAnterior,0);

            $rsVeiculos    = buscaVeiculos($oParam->veiculos);
            $dadosVeiculos = db_utils::getCollectionByRecord($rsVeiculos);

            foreach ($dadosVeiculos as $dadosVeiculo) {

                $oVeicTransf = new cl_veiculostransferencia;
                $oVeicTransf->ve81_transferencia      = $transferencia->ve80_sequencial;
                $oVeicTransf->ve81_codigo             = $dadosVeiculo->ve01_codigo;
                $oVeicTransf->ve81_codigoant          = $dadosVeiculo->ve01_codigoant;
                $oVeicTransf->ve81_placa              = $dadosVeiculo->ve01_placa;
                $oVeicTransf->ve81_codunidadesubatual = $aUnidadeAtual->codunidadesub;
                if($aVeiculos->ve01_codunidadesub == ""){
                    $oVeicTransf->ve81_codunidadesubant = $aUnidadeAnterior->codunidadesub;
                }else{
                    $oVeicTransf->ve81_codunidadesubant   = $aVeiculos->ve01_codunidadesub;
                }
                //OC 9284

                //situacao 1
                if(($dadosVeiculo->ve01_codigoant == null || $dadosVeiculo->ve01_codigoant == 0) && ($dadosVeiculo->ve01_codunidadesub == null || $dadosVeiculo->ve01_codunidadesub == 0)){
                    $oVeicTransf->ve81_codigonovo = $dadosVeiculo->si09_codorgaotce.$aUnidadeAtual->codunidadesub.$oVeicTransf->ve81_codigo;
                }
                //situacao 2
                if(($dadosVeiculo->ve01_codigoant != null || $dadosVeiculo->ve01_codigoant != 0) && ($dadosVeiculo->ve01_codunidadesub != null || $dadosVeiculo->ve01_codunidadesub != 0)){
                    $oVeicTransf->ve81_codigonovo = $dadosVeiculo->si09_codorgaotce.$aUnidadeAtual->codunidadesub.$oVeicTransf->ve81_codigo;
                }
                //situacao 3
                if(($dadosVeiculo->ve01_codigoant == null || $dadosVeiculo->ve01_codigoant == 0) && ($dadosVeiculo->ve01_codunidadesub != null || $dadosVeiculo->ve01_codunidadesub != 0)){
                    $oVeicTransf->ve81_codigonovo = $dadosVeiculo->si09_codorgaotce.$aUnidadeAtual->codunidadesub.$oVeicTransf->ve81_codigo;
                }
                //situacao 4
                if(($dadosVeiculo->ve01_codigoant != null || $dadosVeiculo->ve01_codigoant != 0) && ($dadosVeiculo->ve01_codunidadesub == null || $dadosVeiculo->ve01_codunidadesub == 0)){
                    $oVeicTransf->ve81_codigonovo = $dadosVeiculo->si09_codorgaotce.$aUnidadeAtual->codunidadesub.$oVeicTransf->ve81_codigo;
                }

                //FIM OC 9284
                $oVeicTransf->incluir(null);

                if ($oVeicTransf->erro_status == "0") {
                    throw new Exception($oVeicTransf->erro_msg);
                }

                $clveiccentral = new cl_veiccentral();
                $rsCentralVeiculo = $clveiccentral->sql_record($clveiccentral->sql_query_file(null,"ve40_sequencial","","ve40_veiculos = $dadosVeiculo->ve01_codigo"));
                $aCentralExcluir = db_utils::fieldsMemory($rsCentralVeiculo,0)->ve40_sequencial;
                //excluir central
                $clveiccentral->excluir($aCentralExcluir);

                if ($clveiccentral->erro_status == "0") {
                    throw new Exception($clveiccentral->erro_msg);
                }

                //busco nova central
                $rsNovaCentral = $clveiccentral->sql_record($clveiccentral->getCodCentralPorDepart(null,"DISTINCT ve40_veiccadcentral",null,"db_depart.coddepto = $oParam->departamento_destino"));
                $aNovaCentral = db_utils::fieldsMemory($rsNovaCentral,0)->ve40_veiccadcentral;

                //Inserir nova central
                $clveiccentral->ve40_veiccadcentral = $aNovaCentral;
                $clveiccentral->ve40_veiculos = $dadosVeiculo->ve01_codigo;
                $clveiccentral->incluir(null);

                if ($clveiccentral->erro_status == "0") {
                    throw new Exception($clveiccentral->erro_msg);
                }

            }

            db_fim_transacao();
        } catch (Exception $eExeption) {
            $oRetorno->erro  = $eExeption->getMessage();
            $oRetorno->status   = 2;
        }

        break; // inseretransveiculo

}

function buscaVeiculosDepartamentos($departamento, $Instit) {
    $rsBusca = db_query("
            select veiculos.ve01_codigo,
              veiculos.ve01_placa,
              case tipoveiculos.si04_tipoveiculo
                  when 1 then 'Aeronaves'
                  when 2 then 'Embarcações'
                  when 3 then 'Veículos'
                  when 4 then 'Maquinário'
                  when 5 then 'Equipamentos'
                  when 99 then 'Outros'
              end,
              veiculos.ve01_codigoant,
              veiculos.ve01_codunidadesub
            from veiculos
              left  join veicbaixa      on veicbaixa.ve04_codigo          = veiculos.ve01_codigo
              left  join veicretirada   on veicretirada.ve60_codigo       = veiculos.ve01_codigo
              left  join veicdevolucao  on veicdevolucao.ve61_codigo      = veiculos.ve01_codigo
              inner join tipoveiculos   on tipoveiculos.si04_veiculos     = veiculos.ve01_codigo
              inner join veiccentral    on veiccentral.ve40_veiculos      = veiculos.ve01_codigo
              inner join veiccadcentral on veiccadcentral.ve36_sequencial = veiccentral.ve40_veiccadcentral
              inner join db_depart      on db_depart.coddepto             = veiccadcentral.ve36_coddepto
              where (db_depart.instit = {$Instit} and db_depart.coddepto  = {$departamento})
                and veiculos.ve01_codigo not in (select veicbaixa.ve04_veiculo from veicbaixa)
            order by veiculos.ve01_codigo
            ");

    return $rsBusca;

}

function buscaVeiculos($veiculos) {
    $rsBusca = db_query("
              select ve01_codigo, ve01_codigoant, ve01_placa, ve01_codunidadesub, si09_codorgaotce
               from veiculos
               inner join infocomplementaresinstit ON si09_instit = ve01_instit
                where ve01_codigo in(".implode(",",$veiculos).")
            ");

    return $rsBusca;

}

function buscaUnidade($departamento, $AnoUsu, $Instit) {
    $rsUnidade = db_query("
          select
            CASE WHEN ( o41_codtri::INT != 0 AND  o40_codtri::INT = 0)
                    THEN lpad( o40_orgao,2,0) || lpad( o41_codtri,3,0)
                WHEN ( o41_codtri::INT = 0 AND  o40_codtri::INT != 0)
                    THEN lpad( o40_codtri,2,0) || lpad( o41_unidade,3,0)
                WHEN ( o41_codtri::INT != 0 AND  o40_codtri::INT != 0)
                    THEN lpad( o40_codtri,2,0) || lpad( o41_codtri,3,0)
            ELSE lpad( o40_orgao,2,0)||lpad( o41_unidade,3,0) END AS codunidadesub
          from db_depart
          inner join db_departorg on db_departorg.db01_coddepto = db_depart.coddepto
          inner join orcorgao     on orcorgao.o40_orgao         = db_departorg.db01_orgao and db_departorg.db01_anousu = orcorgao.o40_anousu
          inner join orcunidade   on orcunidade.o41_unidade     = db_departorg.db01_unidade and orcunidade.o41_anousu = {$AnoUsu} and orcunidade.o41_instit = {$Instit}
          where db_departorg.db01_coddepto = {$departamento}
            and db_departorg.db01_anousu   = {$AnoUsu}
            and orcunidade.o41_orgao = (
                    select orcorgao.o40_orgao
                     from db_depart
                      inner join db_departorg on db_departorg.db01_coddepto = db_depart.coddepto
                      inner join orcorgao     on orcorgao.o40_orgao         = db_departorg.db01_orgao and db_departorg.db01_anousu = orcorgao.o40_anousu
                      where db_departorg.db01_coddepto = {$departamento}
                      and db_departorg.db01_anousu   = {$AnoUsu}
                )
          ");
    return $rsUnidade;
}

function alteraVeiculo($veiculos, $departamento_destino, $anterior, $Instit) {

    $veiccadcentral = db_query("
                      select veiccadcentral.ve36_sequencial from db_depart
                      inner join veiccadcentral on veiccadcentral.ve36_coddepto = db_depart.coddepto
                        where db_depart.instit = {$Instit} and  ve36_coddepto   = {$departamento_destino}");
    $destino = db_utils::fieldsMemory($veiccadcentral,0);

    $resultado = db_query("
    BEGIN;
      update veiccentral
        set ve40_veiccadcentral = {$destino->ve36_sequencial} where ve40_veiculos in (".implode(",",$veiculos).");

      update veiculos
        set ve01_codunidadesub  = {$anterior->codunidadesub} where ve01_codigo in (".implode(",",$veiculos).");
    COMMIT;
  ");

    return $resultado;

}

function alteraSituacaoViculo($veiculo) {
    $resultado = db_query("
    BEGIN;
      update veiculos
        set ve01_ativo  = 2 where ve01_codigo = {$veiculo};
    COMMIT;
  ");

    return $resultado;
}

function buscaTransferencia() {

    $resultado = db_query("select max(ve80_sequencial) as ve80_sequencial from transferenciaveiculos");
    return $resultado;
}

function verificaTransferenciaVeicMes($placa, $data) {
    $vVeiculos = array();
    $sSql = "
      select veiculos.ve81_placa, to_char(t.ve80_dt_transferencia,'MM') ve80_dt_transferencia,
        to_char(t.ve80_dt_transferencia,'DD') dia_transferencia,
        to_char(t.ve80_dt_transferencia,'YYYY') ano_transferencia
        from transferenciaveiculos t
          inner join
            ( select ve81_placa, max(ve81_transferencia) ve81_transferencia
                from veiculostransferencia
                  group by ve81_placa
                    order by ve81_placa
            ) veiculos on veiculos.ve81_transferencia = t.ve80_sequencial
              where veiculos.ve81_placa = '$placa'
                group by veiculos.ve81_placa, t.ve80_sequencial
                 order by veiculos.ve81_placa
    ";
    $resultado = db_query($sSql);

    $uTransferencias = db_utils::getCollectionByRecord($resultado,0);
    $anoAtual = substr(str_replace('/', '', $data),-4);
    $mesAtual = substr(str_replace('/', '', $data),-6,2);
    $diaAtual = substr(str_replace('/', '', $data),-9,2);

    foreach ($uTransferencias as $uTransferencia) {
        if($anoAtual >= $uTransferencia->ano_transferencia){
            if($mesAtual > $uTransferencia->ve80_dt_transferencia)
                $vVeiculos = null;
            else $vVeiculos[] = $uTransferencia->ve81_placa;
        }
        else $vVeiculos[] = $uTransferencia->ve81_codigo;
    }

    foreach ($uTransferencias as $uTransferencia) {
        if($anoAtual == $uTransferencia->ano_transferencia){
              if($mesAtual == $uTransferencia->ve80_dt_transferencia)
                $vVeiculos = $uTransferencia->ve81_placa;
            else $vVeiculos = null;
        } else {
                $vVeiculos = null;
        }
    }

    return $vVeiculos;
}

if (isset($oRetorno->erro)) {
    $oRetorno->erro = utf8_encode($oRetorno->erro);
}

echo $oJson->encode($oRetorno);
?>
