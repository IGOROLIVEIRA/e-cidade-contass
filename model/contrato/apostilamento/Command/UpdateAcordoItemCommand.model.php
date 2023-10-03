<?php

require_once('model/contrato/apostilamento/Command/SalvaDotacoesCommand.php');
class UpdateAcordoItemCommand
{
    public function execute($itens, $iAcordo, $si03_sequencial)
    {
        foreach ($itens as $item) {
            $oDaoAcordoItem  = db_utils::getDao("acordoitem");
            $oDaoAcordoItem->ac20_valorunitario = $item->valorunitario;
            $oDaoAcordoItem->ac20_valortotal = $item->valorunitario * $item->quantidade;

            $sql =  $oDaoAcordoItem->getIdByAcordoPcmaterApostilamento(
                $iAcordo,
                $item->codigoitem,
                $si03_sequencial
            );

            $result =  $oDaoAcordoItem->sql_record($sql);
            $ac20Sequencial = db_utils::fieldsMemory($result, 0)->ac20_sequencial;

            $oDaoAcordoItem->updateByApostilamento($ac20Sequencial);

            if (!empty($item->dotacoes)) {
                $salvaDotacoes = new SalvaDotacoesCommand();
                $salvaDotacoes->execute($item->dotacoes, $ac20Sequencial);
            }

            if ($oDaoAcordoItem->erro_status == "0") {
                throw new Exception($oDaoAcordoItem->erro_msg);
            }
        }
    }
}
