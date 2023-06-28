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
        $sql = "
        SELECT DISTINCT
            pcorcam.*
        FROM liclicitem
        LEFT JOIN pcorcamitemlic ON l21_codigo = pc26_liclicitem
        LEFT JOIN pcorcamval ON pc26_orcamitem = pc23_orcamitem
        LEFT JOIN pcorcamjulg ON pcorcamval.pc23_orcamitem = pcorcamjulg.pc24_orcamitem
        AND pcorcamval.pc23_orcamforne = pcorcamjulg.pc24_orcamforne
        LEFT JOIN pcorcamforne ON pc21_orcamforne = pc23_orcamforne
        left join pcorcamitem on pc22_orcamitem=pc26_orcamitem
        LEFT JOIN pcorcam on pc20_codorc=pc22_codorc and pc20_codorc=pc21_codorc
        WHERE l21_codliclicita =  $l21_codliclicita";

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