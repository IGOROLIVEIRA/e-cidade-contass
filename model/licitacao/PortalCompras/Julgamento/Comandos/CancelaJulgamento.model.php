<?php

require_once("classes/db_liclicitaimportarjulgamento_classe.php");

class CancelaJulgamento
{
    /**
     * Executa cancelamento de julgamento
     *
     * @param integer $pc20_codorc
     * @param integer $l20_codigo
     * @return array
     */
    public function execute(int $pc20_codorc, int $l20_codigo, bool $lRegistroPreco): array
    {

        $climportjulgamento = new cl_liclicitaimportarjulgamento;

        if ($lRegistroPreco) {
            $climportjulgamento->cancelaJulgamentoRegistroPreco($pc20_codorc, $l20_codigo);
        } else {
            $climportjulgamento->cancelaJulgamentoComum($pc20_codorc, $l20_codigo);
        }

        if ($climportjulgamento->erro_status === 0) {
            return [
                'status' => false,
                'messagem' => $climportjulgamento->erro_msg
            ];
        }

        return [
            'status' => true,
            'messagem' => "Julgamento cancelado com sucesso"
        ];
    }
}
