<?php
if (!function_exists('fc_tipocertidaomatricula')) {
    /**
     * Fun��o que busca o tipo certid�o consultando a PL no banco de dados
     * @param $iOrigem
     * @param $sTipoOrigem
     * @param $sData
     * @param $iRegraCnd
     * @return string
     */
    function fc_tipocertidaomatricula($iOrigem, $sTipoOrigem, $sData, $iRegraCnd)
    {
        $aRetorno = DB::select("
            SELECT fc_tipocertidao AS tipocertidao
              FROM fc_tipocertidao({$iOrigem}, '{$sTipoOrigem}', '{$sData}', '', {$iRegraCnd})
        ")[0];

        return $aRetorno->tipocertidao;
    }
}

if (!function_exists('fc_iptu_fracionalote')) {
    /**
     * Fun��o que busca a fra��o ideal da matricula
     * @param $iMatric
     * @param $iAnousu
     * @return integer
     */
    function fc_iptu_fracionalote($iMatric, $iAnousu)
    {
        $aRetorno = DB::select("
            SELECT rnfracao AS fracaoideal
              FROM fc_iptu_fracionalote({$iMatric}, {$iAnousu}, false, false)
        ")[0];

        return $aRetorno->fracaoideal;
    }
}

if (!function_exists('fc_busca_envolvidos')) {
    /**
     * Fun��o que busca os CGMs envolvidos na origem
     * @param $iPrincipal
     * @param $iRegra
     * @param $sTipoOrigem
     * @param $iCodOrigem
     * @return array
     */
    function fc_busca_envolvidos($iPrincipal, $iRegra, $sTipoOrigem, $iCodOrigem)
    {
        $aRetorno = DB::select("
        SELECT *
          FROM fc_busca_envolvidos('{$iPrincipal}', {$iRegra}, '{$sTipoOrigem}', {$iCodOrigem})
        ");

        return $aRetorno;
    }
}

if (!function_exists('fc_executa_baixa_banco')) {
    /**
     * Fun��o que faz a classifica��o para baixa de banco
     * @param $iCodret
     * @param $sData
     * @return array
     */
    function fc_executa_baixa_banco($iCodret, $sData)
    {
        $rRetorno = db_query("
            SELECT *
              FROM fc_executa_baixa_banco({$iCodret}, '{$sData}')
        ");

        if (!$rRetorno) {
            throw new \Exception("Erro ao executar a PL fc_executa_baixa_banco. ".pg_last_error());
        }

        return \db_utils::fieldsMemory($rRetorno, 0);
    }
}
