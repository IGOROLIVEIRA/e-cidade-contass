<?php


class SalvaDotacoesCommand
{
    public function execute($dotacoes, $idAcordoItem)
    {

        $this->excluiDotações($idAcordoItem);

        foreach ($dotacoes as $dotacao) {

            $oDaoAcordoItemDotacao = db_utils::getDao("acordoitemdotacao");
             $oDaoAcordoItemDotacao->ac22_acordoitem = $idAcordoItem;
             $oDaoAcordoItemDotacao->ac22_anousu     = db_getsession('DB_anousu');
             $oDaoAcordoItemDotacao->ac22_valor      = (float)$dotacao->valor;
             $oDaoAcordoItemDotacao->ac22_coddot     = $dotacao->dotacao;
             $oDaoAcordoItemDotacao->ac22_quantidade = "" . $dotacao->quantidade . "";
             $oDaoAcordoItemDotacao->incluir(null);
             if ($oDaoAcordoItemDotacao->erro_status == 0) {
                 $sErroMsg  = "Erro ao salvar item";
                 $sErroMsg .= "Não foi possivel incluir dotacao ({$dotacao->dotacao})\n.{$oDaoAcordoItemDotacao->erro_msg}";
                 throw new Exception($sErroMsg);
             }
        }
    }

    private function excluiDotações($idAcordoItem)
    {
        $oDaoAcordoItemDotacaoReserva = db_utils::getDao("orcreservaacordoitemdotacao");
        $oDaoReserva                  = db_utils::getDao("orcreserva");
        $oDaoAcordoItemDotacao = db_utils::getDao("acordoitemdotacao");
        $sSqlDotacoes          = $oDaoAcordoItemDotacao->sql_query_file(
            null,
            "*",
            null,
            "ac22_acordoitem={$idAcordoItem}"
        );

        $rsDotacoes           = $oDaoAcordoItemDotacao->sql_record($sSqlDotacoes);
        $aDotacoesCadastradas = db_utils::getCollectionByRecord($rsDotacoes);
        foreach ($aDotacoesCadastradas as $oDotacaoCadastrada) {

            $sSqlReserva = $oDaoAcordoItemDotacaoReserva->sql_query_file(
                null,
                "*",
                null,
                "o84_acordoitemdotacao =
                {$oDotacaoCadastrada->ac22_sequencial}"
            );

            $rsReservaItem = $oDaoAcordoItemDotacaoReserva->sql_record($sSqlReserva);
            if ($oDaoAcordoItemDotacaoReserva->numrows > 0) {

                $oDadosReserva = db_utils::fieldsMemory($rsReservaItem, 0);
                $oDaoAcordoItemDotacaoReserva->excluir($oDadosReserva->o84_sequencial);
                $oDaoReserva->excluir($oDadosReserva->o84_orcreserva);
            }
            $oDaoAcordoItemDotacao->excluir($oDotacaoCadastrada->ac22_sequencial);
        }
    }
}
