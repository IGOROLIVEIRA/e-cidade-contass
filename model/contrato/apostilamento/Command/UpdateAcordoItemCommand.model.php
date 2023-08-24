<?php

class UpdateAcordoItemCommand
{
    public function execute($itens, $iAcordo, $si03_sequencial)
    {
        foreach ($itens as $item) {
            $oDaoAcordoItem  = db_utils::getDao("acordoitem");
            $oDaoAcordoItem->ac20_valorunitario = $item->valorunitario;
            $oDaoAcordoItem->ac20_valortotal = $item->valorunitario * $item->quantidade;

            $oDaoAcordoItem->updateByApostilamento(
                $iAcordo,
                $item->codigoitem,
                $si03_sequencial
            );

            if ($oDaoAcordoItem->erro_status == "0") {
                throw new Exception($oDaoAcordoItem->erro_msg);
            }
        }

    }
}
