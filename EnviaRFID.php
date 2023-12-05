<?php

function enviaDadosRFid($oParam)
{

  switch ($oParam->exec) {

    case 'salvar':

      $iDBInstituicao = db_getsession("DB_instit");
      $dadosApi = db_query("select * from cfpatriinstituicao where t59_instituicao = $iDBInstituicao "); // consulta de Dados da API
      $dadosApi = db_utils::fieldsMemory($dadosApi, 0);

      if ($dadosApi->t59_ativo == 't') {

        $token = require("conectaAPI.php");

        if ($oParam->t52_bem != "") {
          $placaBem = db_query("select * from bens where t52_bem = $oParam->t52_bem");                // consulta de Dados dos Bens
          $placaBem = db_utils::fieldsMemory($placaBem, 0);
        }

        if ($oParam->t64_codcla != "") {
          $t64_codcla = db_query("select t64_descr from clabens where t64_codcla = $oParam->t64_codcla");                           // consulta de Dados da classicaï¿½ï¿½o dos Bens
          $t64_codcla = db_utils::fieldsMemory($t64_codcla, 0);
        }

        if ($oParam->t52_numcgm != "") {
          $t52_numcgm = db_query("select z01_nome from cgm where z01_numcgm = $oParam->t52_numcgm");                                // consulta de Dados do CGM dos Bens
          $t52_numcgm = db_utils::fieldsMemory($t52_numcgm, 0);
        }

        if ($oParam->t45_sequencial != "") {
          $t45_sequencial = db_query("select t45_descricao from benstipoaquisicao where t45_sequencial = $oParam->t45_sequencial"); // consulta de Dados da Requisiï¿½ï¿½o da Aquisiï¿½ï¿½o dos Bens
          $t45_sequencial = db_utils::fieldsMemory($t45_sequencial, 0);
        }

        if ($oParam->t52_depart != "") {
          $t52_depart = db_query("select descrdepto from db_depart where coddepto = $oParam->t52_depart");                           // consulta de Dados dos Departamentos
          $t52_depart = db_utils::fieldsMemory($t52_depart, 0);
        }

        if ($oParam->divisao != "") {
          $divisao = db_query("select t30_descr from departdiv where t30_codigo = $oParam->divisao");                               // consulta de Dados das Divisï¿½es dos Departamentos
          $divisao = db_utils::fieldsMemory($divisao, 0);
        }

        if ($oParam->t04_sequencial != "") {
          $t04_sequencial = db_query("select z01_nome from benscadcedente inner join cgm on z01_numcgm = t04_numcgm where t04_sequencial = $oParam->t04_sequencial");  // consulta de Dados do Convenio
          $t04_sequencial = db_utils::fieldsMemory($t04_sequencial, 0);
        }

        if ($oParam->t56_situac != "") {
          $t56_situac = db_query("select t70_descr from situabens where t70_situac = $oParam->t56_situac");                         // consulta de Dados da Situaï¿½ï¿½o do Bem
          $t56_situac = db_utils::fieldsMemory($t56_situac, 0);
        }

        if ($oParam->cod_depreciacao != "") {
          $cod_depreciacao = db_query("select t46_descricao from benstipodepreciacao where t46_sequencial = $oParam->cod_depreciacao");  // consulta de Dados da Depreciaï¿½ï¿½o
          $cod_depreciacao = db_utils::fieldsMemory($cod_depreciacao, 0);
        }

        if ($oParam->t67_sequencial != "") {
          $t67_sequencial = db_query("select t67_descricao from bensmedida where t67_sequencial = $oParam->t67_sequencial");        // consulta de Dados da Medida
          $t67_sequencial = db_utils::fieldsMemory($t67_sequencial, 0);
        }

        if ($oParam->t65_sequencial != "") {
          $t65_sequencial = db_query("select t65_descricao from bensmarca where t65_sequencial = $oParam->t65_sequencial");                        // consulta de Dados do Modelo
          $t65_sequencial = db_utils::fieldsMemory($t65_sequencial, 0);
        }

        if ($oParam->t66_sequencial != "") {
          $t66_sequencial = db_query("select t66_descricao from bensmodelo where t66_sequencial = $oParam->t66_sequencial");                        // consulta de Dados do Modelo
          $t66_sequencial = db_utils::fieldsMemory($t66_sequencial, 0);
        }

        $arraybens = array(
          'Codigo_bem'          => $oParam->t52_bem,
          'Placa_impressa'      => $oParam->sPlaca,
          'Data_da_aquisicao'   => $oParam->t52_dtaqu,
          'Classificacao'       => $t64_codcla->t64_descr,
          'Fornecedor'          => $t52_numcgm->z01_nome,
          'Descricao_aquisicao' => $t45_sequencial->t45_descricao,
          'Departamento'        => $t52_depart->descrdepto,
          'Divisao'             => $divisao->t30_descr,
          'Convenio'            => $t04_sequencial->z01_nome,
          'Situacao_bem'        => $t56_situac->t70_descr,
          'Valor_aquisicao'     => $oParam->vlAquisicao,
          'Valor_residual'      => $oParam->vlResidual,
          'Valor_depreciavel'   => $oParam->vlAquisicao -  $oParam->vlResidual,
          'Valor_atual'         => $oParam->vlTotal,
          'Tipo_depreciacao'    => $cod_depreciacao->t46_descricao,
          'Vida_util'           => $oParam->vidaUtil,
          'Medida'              => $t67_sequencial->t67_descricao,
          'Modelo'              => $t66_sequencial->t66_descricao,
          'Marca'               => $t65_sequencial->t65_descricao,
          'Codigo_item_nota'    => $oParam->iCodigoItemNota,
          'Contabilizado'      => $oParam->contabilizado,
          'Observacoes'         => $oParam->obser,

        );
        if ($oParam->cod_lote) { // Quando o Bem é Global
          $arraybensglobal = array(
            'Codigo_lote'       => $oParam->cod_lote,
            'Quant_lote'        => $oParam->quant_lote,
            'Descricao_lote'    => $oParam->descr_lote,
            'Itbql'             => $oParam->t54_itbql,
            'Observacoesimovel' => $oParam->observacoesimovel,
            'Cod_notafiscal'    => $oParam->cod_notafiscal,
            'Empenho'           => $oParam->t53_empen,
            'Cod_ordemdecompra' => $oParam->cod_ordemdecompra,
            'Garantia'          => $oParam->garantia,
            'Empenhosistema'    => $oParam->empenhosistema
          );
          $arraybens = array_merge($arraybens, $arraybensglobal);
        }

        $arraybensjson = json_encode(DBString::utf8_encode_all($arraybens));

        $bens = array('data' => $arraybensjson, 'PlacaAnterior' => $oParam->t41_placa, 'Descricao' => $oParam->t52_descr);
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://teste.aplicartecnologia.com.br/webservice/add/bem?a=a',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_SSL_VERIFYHOST => false,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => $bens,
          CURLOPT_HTTPHEADER => array(
            'Authorization: ' . $token
          ),
        ));
        $response = curl_exec($curl);
        if (curl_errno($curl))
          echo curl_error($curl);
        else {
          $decode = json_decode($response, true);
        }

        if ($placaBem->t52_codexterno != '') {
           atualizarbens($decode['msg']['id'], $oParam->t52_bem);
        }

        if (!$decode['status'] || $decode['status'] != 'success') {
          salvarBenspendentes($arraybens, $oParam->t41_placa, $oParam->t52_descr);
        }
        
        curl_close($curl);
        if ($decode) {
            if ($decode['status'] == 'error'  &&  $decode['msg'] == 'Placa repetida') {
              return $decode['msg'];
          }
        }
       
        return $decode['status'];
      }
      return $dadosApi->t59_ativo;
      break;

    case 'baixarBem':

      $iDBInstituicao = db_getsession("DB_instit");
      $iMotivo     = $oParam->iMotivo;
      $dDataBaixa  = $oParam->dtBaixa;
      $sObservacao = $oParam->sObservacao;
      $iDestino    = $oParam->iDestino;
      $iCodigoBem  = $oParam->aBens[0];

      $dadosApi = db_query("select * from cfpatriinstituicao where t59_instituicao = $iDBInstituicao "); // consulta de Dados da API
      $dadosApi = db_utils::fieldsMemory($dadosApi, 0);

      $placaBem = db_query("select * from bens where t52_bem = $iCodigoBem");                // consulta de Dados dos Bens
      $placaBem = db_utils::fieldsMemory($placaBem, 0);

      $motivoBaixa = db_query("select t51_descr from bensmotbaixa where t51_motivo = $iMotivo");     // consulta de Dados dos motivos da baixa
      $motivoBaixa = db_utils::fieldsMemory($motivoBaixa, 0);

      $dDataBaixa = implode("", array_reverse(explode("/", $dDataBaixa))) . "000000";
      
      if ($dadosApi->t59_ativo == 't') {
        $token = require("conectaAPI.php");

        $arrayBaixa = array([
          'PlacaAtual'       => "",
          'PlacaAnterior'    => $placaBem->t52_ident,
        ]);

        $dadosbaixa = array('DataBaixa' => $dDataBaixa, 'MotivoBaixa' => $motivoBaixa->t51_descr, 'Observacao' => $sObservacao, 'Bens' => $arrayBaixa);

        $json = json_encode(DBString::utf8_encode_all($dadosbaixa));

        $Dados = array('Dados' => $json);

        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://teste.aplicartecnologia.com.br/ws/add/baixa',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_SSL_VERIFYHOST => false,
          CURLOPT_SSL_VERIFYPEER => false,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => $Dados,
          CURLOPT_HTTPHEADER => array(
            'Authorization: ' . $token
          ),
        ));

        $response = curl_exec($curl);
        if (curl_errno($curl))
          echo curl_error($curl);
        else {
          $decode = json_decode($response, true);
        }

        curl_close($curl);
        if (!$decode || substr($decode['msg']['id'], 4, 3) != 200) {       
          salvarBaixapendentes($motivoBaixa->t51_descr, $sObservacao, $placaBem->t52_ident,$iCodigoBem);
          return 'erro';
        } 

        if ($decode && substr($decode['msg']['id'], 4, 3) == 200) {
          return 'success';
        }
        
      }
      return $dadosApi->t59_ativo;
      break;
    case 'enviarBenspendentes':

      $iDBInstituicao = db_getsession("DB_instit");
      $dadosApi = db_query("select * from cfpatriinstituicao where t59_instituicao = $iDBInstituicao "); // consulta de Dados da API
      $dadosApi = db_utils::fieldsMemory($dadosApi, 0);

      if ($dadosApi->t59_ativo == 't') {

        $token = require("conectaAPI.php");

        $clbemcontrolerfid = new cl_benscontrolerfid();

        foreach ($oParam->aBens as $aBens) {

          $sSqlBemcontrolerfid =  $clbemcontrolerfid->sql_query_file(null, "*", null, " t214_codigobem = $aBens->codigobem and t214_controlerfid = 2 ");
          $rsBemcontrolerfid = $clbemcontrolerfid->sql_record($sSqlBemcontrolerfid);

          if (pg_num_rows($rsBemcontrolerfid) > 0) {
            $oDadosBens      = new stdClass();
            $oBens = db_utils::fieldsMemory($rsBemcontrolerfid, 0);
          }

          $arraybens = array(
            'Codigo_bem'          => $oBens->t214_codigobem,
            'Placa_impressa'      => $oBens->t214_placabem,
            'Data_da_aquisicao'   => $oBens->t214_data_da_aquisicao,
            'Classificacao'       => $oBens->t214_classificacao,
            'Fornecedor'          => $oBens->t214_fornecedor,
            'Descricao_aquisicao' => $oBens->t214_descricao_aquisicao,
            'Departamento'        => $oBens->t214_departamento,
            'Divisao'             => $oBens->t214_divisao,
            'Convenio'            => $oBens->t214_convenio,
            'Situacao_bem'        => $oBens->t214_situacao_bem,
            'Valor_aquisicao'     => $oBens->t214_valor_aquisicao,
            'Valor_residual'      => $oBens->t214_valor_residual,
            'Valor_depreciavel'   => $oBens->t214_valor_depreciavel,
            'Valor_atual'         => $oBens->t214_valor_atual,
            'Tipo_depreciacao'    => $oBens->t214_tipo_depreciacao,
            'Vida_util'           => $oBens->t214_vida_util,
            'Medida'              => $oBens->t214_medida,
            'Modelo'              => $oBens->t214_modelo,
            'Marca'               => $oBens->t214_marca,
            'Codigo_item_nota'    => $oBens->t214_codigo_item_nota,
            'Contabilizado'       => $oBens->t214_contabilizado,
            'Observacoes'         => $oBens->t214_observacoes,

          );
          if ($oBens->t214_codigo_lote) { // Quando o Bem é Global
            $arraybensglobal = array(
              'Codigo_lote'       => $oBens->t214_codigo_lote,
              'Quant_lote'        => $oBens->t214_quant_lote,
              'Descricao_lote'    => $oBens->t214_descricao_lote,
              'Itbql'             => $oBens->t214_itbql,
              'Observacoesimovel' => $oBens->t214_observacoesimovel,
              'Cod_notafiscal'    => $oBens->t214_cod_notafiscal,
              'Empenho'           => $oBens->t214_empenho,
              'Cod_ordemdecompra' => $oBens->t214_cod_ordemdecompra,
              'Garantia'          => $oBens->t214_garantia,
              'Empenhosistema'    => $oBens->t214_empenhosistema
            );
            $arraybens = array_merge($arraybens, $arraybensglobal);
          }

          $arraybensjson = json_encode(DBString::utf8_encode_all($arraybens));

          $bens = array('data' => $arraybensjson, 'PlacaAnterior' => $oBens->t214_placabem, 'Descricao' => $oBens->t214_descbem);
          $curl = curl_init();
          curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://teste.aplicartecnologia.com.br/webservice/add/bem?a=a',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $bens,
            CURLOPT_HTTPHEADER => array(
              'Authorization: ' . $token
            ),
          ));
          $response = curl_exec($curl);
          if (curl_errno($curl))
            echo curl_error($curl);
          else {
            $decode = json_decode($response, true);
          }
          if ($decode['msg'] == 'Placa repetida' || $decode['status'] == 'success') {
             excluirBenspendentes($oBens->t214_codigobem, 2);
          }
          curl_close($curl);
        }
        if ($decode['msg'] == 'Placa repetida' ) {
          return 'placarepetida';
        }

        if ($decode['status'] == 'success') {
          return 'success';
        }
      
        return 'erro';
      }
      return $dadosApi->t59_ativo;
      break;

    case 'enviarBaixaspendentes':

      $iDBInstituicao = db_getsession("DB_instit");
      $dadosApi = db_query("select * from cfpatriinstituicao where t59_instituicao = $iDBInstituicao "); // consulta de Dados da API
      $dadosApi = db_utils::fieldsMemory($dadosApi, 0);

      if ($dadosApi->t59_ativo == 't') {

        $token = require("conectaAPI.php");

        $clbemcontrolerfid = new cl_benscontrolerfid();

        foreach ($oParam->aBens as $aBens) {

          $sSqlBemcontrolerfid =  $clbemcontrolerfid->sql_query_file(null, "*", null, " t214_codigobem = $aBens->codigobem and t214_controlerfid = 3 ");
          $rsBemcontrolerfid = $clbemcontrolerfid->sql_record($sSqlBemcontrolerfid);

          if (pg_num_rows($rsBemcontrolerfid) > 0) {
            $oDadosBens      = new stdClass();
            $oBens = db_utils::fieldsMemory($rsBemcontrolerfid, 0);
          }

          $arrayBaixa = array([
            'PlacaAtual'       => "",
            'PlacaAnterior'    => $oBens->t214_placabem,
          ]);

          $dDataBaixa = implode("", (explode("-", $oBens->t214_dtlancamento))) . "000000";

          $dadosbaixa = array('DataBaixa' => $dDataBaixa, 'MotivoBaixa' => $oBens->t214_departamento, 'Observacao' => $oBens->t214_observacoes, 'Bens' => $arrayBaixa);

          $json = json_encode(DBString::utf8_encode_all($dadosbaixa));

          $Dados = array('Dados' => $json);

          $curl = curl_init();
          curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://teste.aplicartecnologia.com.br/ws/add/baixa',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $Dados,
            CURLOPT_HTTPHEADER => array(
              'Authorization: ' . $token
            ),
          ));

          $response = curl_exec($curl);
          if (curl_errno($curl))
            echo curl_error($curl);
          else {
            $decode = json_decode($response, true);
          }
       
          if (substr($decode['msg']['id'], 4, 3) == 200)
            excluirBenspendentes($oBens->t214_codigobem, 3);
          curl_close($curl);
        }
        if (substr($decode['msg']['id'], 4, 3) == 200) {
          return 'success';
        }
        return 'erro';
      }
      return $dadosApi->t59_ativo;
      break;
  }
}
function salvarBenspendentes($oParam, $placa, $descricao)
{
  if (!$oParam['Codigo_bem']) {
    $codigobem = db_query("select * from bens where t52_ident = '$placa'");
    $codigobem = db_utils::fieldsMemory($codigobem, 0);
    $oParam['Codigo_bem'] = $codigobem->t52_bem;
  }

  $clbemcontrolerfid = new cl_benscontrolerfid(); 
  $clbemcontrolerfid->t214_codigobem = $oParam['Codigo_bem'];
  $clbemcontrolerfid->t214_placabem = $placa ? $placa : "0";
  $clbemcontrolerfid->t214_descbem = $descricao ? $descricao : "0";
  $clbemcontrolerfid->t214_placa_impressa = $oParam['Placa_impressa'] ? $oParam['Placa_impressa'] : 0;
  $clbemcontrolerfid->t214_usuario = db_getsession('DB_id_usuario');
  $clbemcontrolerfid->t214_dtlancamento = date('Y-m-d', db_getsession('DB_datausu'));
  $clbemcontrolerfid->t214_instit = db_getsession('DB_instit');
  $clbemcontrolerfid->t214_data_da_aquisicao = ($oParam['Data_da_aquisicao']) ? $oParam['Data_da_aquisicao'] : "0";
  $clbemcontrolerfid->t214_classificacao = ($oParam['Classificacao']) ? $oParam['Classificacao'] : "0";
  $clbemcontrolerfid->t214_fornecedor = ($oParam['Fornecedor']) ? $oParam['Fornecedor'] : "0";
  $clbemcontrolerfid->t214_descricao_aquisicao = ($oParam['Descricao_aquisicao']) ? $oParam['Descricao_aquisicao'] : "0";
  $clbemcontrolerfid->t214_departamento = ($oParam['Departamento']) ? $oParam['Departamento'] : "0";
  $clbemcontrolerfid->t214_divisao = ($oParam['Divisao']) ? $oParam['Divisao'] : "0";
  $clbemcontrolerfid->t214_convenio = ($oParam['Convenio']) ? $oParam['Convenio'] : "0";
  $clbemcontrolerfid->t214_situacao_bem = ($oParam['Situacao_bem']) ? $oParam['Situacao_bem'] : "0";
  $clbemcontrolerfid->t214_valor_aquisicao = ($oParam['Valor_aquisicao']) ? $oParam['Valor_aquisicao'] : "0";
  $clbemcontrolerfid->t214_valor_residual = ($oParam['Valor_residual']) ? $oParam['Valor_residual'] : "0";
  $clbemcontrolerfid->t214_valor_depreciavel = ($oParam['Valor_depreciavel']) ? $oParam['Valor_depreciavel'] : "0";
  $clbemcontrolerfid->t214_tipo_depreciacao = ($oParam['Tipo_depreciacao']) ? $oParam['Tipo_depreciacao'] : "0";
  $clbemcontrolerfid->t214_valor_atual = ($oParam['Valor_atual']) ? $oParam['Valor_atual'] : "0";
  $clbemcontrolerfid->t214_vida_util = ($oParam['Vida_util']) ? $oParam['Vida_util'] : "0";
  $clbemcontrolerfid->t214_medida = ($oParam['Medida']) ? $oParam['Medida'] : "0";
  $clbemcontrolerfid->t214_modelo = ($oParam['Modelo']) ? $oParam['Modelo'] : "0";
  $clbemcontrolerfid->t214_marca = ($oParam['Marca']) ? $oParam['Marca'] : "0";
  $clbemcontrolerfid->t214_codigo_item_nota = ($oParam['Codigo_item_nota']) ? $oParam['Codigo_item_nota'] : "0";
  $clbemcontrolerfid->t214_contabilizado = ($oParam['Contabilizado']) ? $oParam['Contabilizado'] : "0";
  $clbemcontrolerfid->t214_observacoes = ($oParam['Observacoes']) ? $oParam['Observacoes'] : "0";
  $clbemcontrolerfid->t214_codigo_lote = ($oParam['Codigo_lote']) ? $oParam['Codigo_lote'] : "0";
  $clbemcontrolerfid->t214_quant_lote = ($oParam['Quant_lote']) ? $oParam['Quant_lote'] : "0";
  $clbemcontrolerfid->t214_descricao_lote = ($oParam['Descricao_lote']) ? $oParam['Descricao_lote'] : "0";
  $clbemcontrolerfid->t214_itbql = ($oParam['Itbql']) ? $oParam['Itbql'] : "0";
  $clbemcontrolerfid->t214_observacoesimovel = ($oParam['Observacoesimovel']) ? $oParam['Observacoesimovel'] : "0";
  $clbemcontrolerfid->t214_cod_notafiscal = ($oParam['Cod_notafiscal']) ? $oParam['Cod_notafiscal'] : "0";
  $clbemcontrolerfid->t214_empenho = ($oParam['Empenho']) ? $oParam['Empenho'] : "0";
  $clbemcontrolerfid->t214_cod_ordemdecompra = ($oParam['Cod_ordemdecompra']) ? $oParam['Cod_ordemdecompra'] : "0";
  $clbemcontrolerfid->t214_garantia = ($oParam['Garantia']) ? $oParam['Garantia'] : "0";
  $clbemcontrolerfid->t214_empenhosistema = ($oParam['Empenhosistema']) ? $oParam['Empenhosistema'] : "0";
  $clbemcontrolerfid->t214_controlerfid = 2;

  $sSqlBuscaDadosBem          = $clbemcontrolerfid->sql_query_file(null, " * ", null, " t214_placabem = $clbemcontrolerfid->t214_placabem and t214_controlerfid = $clbemcontrolerfid->t214_controlerfid");
  $rsBuscaDadosBem            = $clbemcontrolerfid->sql_record($sSqlBuscaDadosBem);

  if ($clbemcontrolerfid->numrows > 0) {
    $clbemcontrolerfid->alterar($clbemcontrolerfid->t214_codigobem);
    return;
  }

  $clbemcontrolerfid->incluir();
  return;
}
function excluirBenspendentes($t214_codigobem, $controle)
{
  $clbemcontrolerfid = new cl_benscontrolerfid();
  $clbemcontrolerfid->excluir("", "t214_codigobem = $t214_codigobem and t214_controlerfid = $controle");
  return;
}
function salvarBaixapendentes($motivodabaixa, $observacao, $placa, $iCodigoBem)
{
 
  $descricaoBem = db_query("select * from bens where t52_bem = $iCodigoBem");                // consulta de Dados dos Bens
  $descricaoBem = db_utils::fieldsMemory($descricaoBem, 0);
 
  $clbemcontrolerfid = new cl_benscontrolerfid();
  $clbemcontrolerfid->t214_codigobem           = $iCodigoBem;
  $clbemcontrolerfid->t214_placabem            = $placa;
  $clbemcontrolerfid->t214_descbem             = $descricaoBem->t52_descr;
  $clbemcontrolerfid->t214_usuario             = db_getsession('DB_id_usuario');
  $clbemcontrolerfid->t214_dtlancamento        = date('Y-m-d', db_getsession('DB_datausu'));
  $clbemcontrolerfid->t214_instit              = db_getsession('DB_instit');
  $clbemcontrolerfid->t214_observacoes         = $observacao;
  $clbemcontrolerfid->t214_departamento        = $motivodabaixa;
  $clbemcontrolerfid->t214_controlerfid        = 3;

  $sSqlBuscaDadosBem          = $clbemcontrolerfid->sql_query_file(null, " * ", null, " t214_placabem = $placa and t214_controlerfid = $clbemcontrolerfid->t214_controlerfid");
  $rsBuscaDadosBem            = $clbemcontrolerfid->sql_record($sSqlBuscaDadosBem);

  if ($clbemcontrolerfid->numrows > 0) {
    $clbemcontrolerfid->alterar($clbemcontrolerfid->t214_codigobem);
    return;
  }
  $clbemcontrolerfid->incluir();
  return;
}
function atualizarbens($codexterno, $codbem)
{
  $clbens = new cl_bens();
  $clbens->t52_bem        = $codbem;
  $clbens->t52_codexterno = $codexterno;
  $clbens->alterar($codbem);
}
