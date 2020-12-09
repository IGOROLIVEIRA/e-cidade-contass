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
require_once("std/DBDate.php");

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
            $vVeiculos = null;
            $vVeiculos = verificaTransferenciaVeicMes($oParam->veiculos,$oParam->data);
            $oRetorno->e = $vVeiculos;

            if ($vVeiculos != null) {
                $oRetorno->status   = 3;
                throw new Exception("Erro ao realizar Transferência!\nMOTIVO: Não é permitido mais de uma transferência de um veículo na mesma competência,\nou com datas menores a última transferência do veículo!\nCódigo(s) do(s) Veículo(s): ".implode(", ",$oParam->veiculos));
            }

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

            if ($oTransferencia->erro_status != 1) {
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

                $oBaixa = new cl_veicbaixa;
                $oBaixa->ve04_veiculo = $dadosVeiculo->ve01_codigo;
                $oBaixa->ve04_data    = $data;
                $oBaixa->ve04_hora    = date("H:i");
                $oBaixa->ve04_usuario = db_getsession('DB_id_usuario');
                $oBaixa->ve04_motivo  = $oParam->motivo;
                $oBaixa->ve04_veiccadtipobaixa = 7;
                $oBaixa->incluir(null);

                if ($oVeicTransf->erro_status != 1) {
                    throw new Exception($oVeicTransf->erro_msg);
                }

                if ($oBaixa->erro_status != 1) {
                    throw new Exception($oBaixa->erro_msg);
                }

            }

            foreach ($oParam->veiculos as $veiculo){
                $clveiculos = new cl_veiculos();
                $clveicretirada = new cl_veicretirada();

                $rsveiculo = $clveiculos->sql_record($clveiculos->sql_query_veiculo($veiculo));
                $aVeiculo = db_utils::fieldsMemory($rsveiculo,0);

                $rsultimamedida = $clveiculos->sql_record($clveiculos->sql_query_ultimamedida($veiculo));
                $aUltimamedida = db_utils::fieldsMemory($rsultimamedida,0);

                $dtsession = date("Y-m-d", db_getsession("DB_datausu"));

                //Novo Veiculo
                $clveiculos->ve01_placa                 = $aVeiculo->ve01_placa;
                $clveiculos->ve01_veiccadtipo           = $aVeiculo->ve01_veiccadtipo;
                $clveiculos->ve01_veiccadmarca          = $aVeiculo->ve01_veiccadmarca;
                $clveiculos->ve01_veiccadmodelo         = $aVeiculo->ve01_veiccadmodelo;
                $clveiculos->ve01_veiccadcor            = $aVeiculo->ve01_veiccadcor;
                $clveiculos->ve01_veiccadproced         = $aVeiculo->ve01_veiccadproced;
                $clveiculos->ve01_veiccadcateg          = $aVeiculo->ve01_veiccadcateg;
                $clveiculos->ve01_chassi                = $aVeiculo->ve01_chassi;
                $clveiculos->ve01_ranavam               = $aVeiculo->ve01_ranavam;
                $clveiculos->ve01_placanum              = $aVeiculo->ve01_placanum;
                $clveiculos->ve01_certif                = $aVeiculo->ve01_certif;
                $clveiculos->ve01_quantpotencia         = $aVeiculo->ve01_quantpotencia;
                $clveiculos->ve01_medidaini             = $aUltimamedida->ultimamedida;
                $clveiculos->ve01_quantcapacidad        = $aVeiculo->ve01_quantcapacidad;
                $clveiculos->ve01_veiccadtipocapacidade = $aVeiculo->ve01_veiccadtipocapacidade;
                $clveiculos->ve01_dtaquis               = $dtsession;
                $clveiculos->ve01_veiccadcategcnh       = $aVeiculo->ve01_veiccadcategcnh;
                $clveiculos->ve01_anofab                = $aVeiculo->ve01_anofab;
                $clveiculos->ve01_anomod                = $aVeiculo->ve01_anomod;
                $clveiculos->ve01_ceplocalidades        = $aVeiculo->ve01_ceplocalidades;
                $clveiculos->ve01_ativo                 = $aVeiculo->ve01_ativo;
                $clveiculos->ve01_veictipoabast         = $aVeiculo->ve01_veictipoabast;
                $clveiculos->ve01_nroserie              = $aVeiculo->ve01_nroserie;
                $clveiculos->ve01_codigoant             = $aVeiculo->ve01_codigoant;
                $clveiculos->ve01_codunidadesub         = $aUnidadeAtual->codunidadesub;
                $clveiculos->ve01_instit                = $aVeiculo->ve01_instit;
                $clveiculos->incluir(null,$aVeiculo->ve01_veiccadtipo);

                //criando a veicresp
                $clveicresp = new cl_veicresp();
                $clveicresp->ve02_veiculo = $clveiculos->ve01_codigo;
                $clveicresp->ve02_numcgm  = $aVeiculo->ve02_numcgm;
                $clveicresp->incluir(null);

                //cria a tipoveiculos
                $cltipoveiculos = new cl_tipoveiculos();
                $cltipoveiculos->si04_veiculos      = $clveiculos->ve01_codigo;
                $cltipoveiculos->si04_tipoveiculo   = $aVeiculo->si04_tipoveiculo;
                $cltipoveiculos->si04_especificacao = $aVeiculo->si04_especificacao;
                $cltipoveiculos->si04_situacao      = $aVeiculo->si04_situacao;
                $cltipoveiculos->si04_descricao     = $aVeiculo->si04_descricao;
                $cltipoveiculos->si04_numcgm        = $aVeiculo->si04_numcgm;
                $cltipoveiculos->incluir(null);

                //criando a veiculoscomb
                $clveiculoscomb = new cl_veiculoscomb();
                $clveiculoscomb->ve06_veiccadcomb = $aVeiculo->ve06_veiccadcomb;
                $clveiculoscomb->ve06_veiculos = $clveiculos->ve01_codigo;
                $clveiculoscomb->ve06_padrao = $aVeiculo->ve06_padrao;
                $clveiculoscomb->incluir(null);

                //incluindo central nova
                $clveiccadcentral = new cl_veiccadcentral();
                $rsVeiccadcentral = $clveiccadcentral->sql_record($clveiccadcentral->sql_query_file(null,"*",null,"ve36_coddepto = $oParam->departamento_destino"));
                $destino = db_utils::fieldsMemory($rsVeiccadcentral,0);

                $clveiccentral = new cl_veiccentral();
                $clveiccentral->ve40_veiccadcentral = $destino->ve36_sequencial;
                $clveiccentral->ve40_veiculos = $clveiculos->ve01_codigo;
                $clveiccentral->incluir(null);
            }

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

function buscaTransferencia() {

    $resultado = db_query("select max(ve80_sequencial) as ve80_sequencial from transferenciaveiculos");
    return $resultado;
}

function verificaTransferenciaVeicMes($veiculos, $data) {
    $vVeiculos = array();
    $resultado = db_query("
      select veiculos.ve81_codigo, to_char(t.ve80_dt_transferencia,'MM') ve80_dt_transferencia,
        to_char(t.ve80_dt_transferencia,'DD') dia_transferencia,
        to_char(t.ve80_dt_transferencia,'YYYY') ano_transferencia
        from transferenciaveiculos t
          inner join
            ( select ve81_codigo, max(ve81_transferencia) ve81_transferencia
                from veiculostransferencia
                  group by ve81_codigo
                    order by ve81_codigo
            ) veiculos on veiculos.ve81_transferencia = t.ve80_sequencial
              where veiculos.ve81_codigo in (".implode(",",$veiculos).")
                group by veiculos.ve81_codigo, t.ve80_sequencial
                 order by veiculos.ve81_codigo
    ");

    $uTransferencias = db_utils::getCollectionByRecord($resultado,0);

    $anoAtual = substr(str_replace('/', '', $data),-4);
    $mesAtual = substr(str_replace('/', '', $data),-6,2);
    $diaAtual = substr(str_replace('/', '', $data),-9,2);

    foreach ($uTransferencias as $uTransferencia) {
        if($anoAtual >= $uTransferencia->ano_transferencia){
            if($mesAtual > $uTransferencia->ve80_dt_transferencia)
                $vVeiculos = null;
            else $vVeiculos[] = $uTransferencia->ve81_codigo;
        }
        else $vVeiculos[] = $uTransferencia->ve81_codigo;
    }

    foreach ($uTransferencias as $uTransferencia) {
        if($anoAtual == $uTransferencia->ano_transferencia){
              if($mesAtual == $uTransferencia->ve80_dt_transferencia)
                $vVeiculos = $uTransferencia->ve81_codigo;
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
