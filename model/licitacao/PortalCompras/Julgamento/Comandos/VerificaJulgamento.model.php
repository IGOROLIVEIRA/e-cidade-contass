<?php

require_once("classes/db_pcorcamjulg_classe.php");

class VerificaJulgamento
{
    /**
     * Retorna id dos julgamentos importados
     *
     * @param integer $l21_codliclicita
     * @return array
     */
    public function getIdJulgamentoImportado(int $l21_codliclicita): array
    {
        $clliclicitem                = new cl_liclicitem;
        $sql = $clliclicitem->sql_queryverificajulgamento($l21_codliclicita);
        $result = db_utils::fieldsMemory($clliclicitem->sql_record($sql),0);


        if ($result->pc20_importado === 't')  {
            return [
                'status'=> true,
                'id' => (int)$result->pc20_codorc
            ];
        }

        return ['status' => false];
    }
}