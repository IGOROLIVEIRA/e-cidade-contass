<?php

use Phinx\Migration\AbstractMigration;

class Oc21026V3 extends AbstractMigration
{
    public function up()
    {

    $sql = <<<SQL

    BEGIN;

    SELECT fc_startsession();

    UPDATE orcamento.orcsubfuncao
    SET o53_descr='ASSISTÊNCIA À PESSOA COM DEFICIÊNCIA', o53_finali='ASSISTÊNCIA À PESSOA COM DEFICIÊNCIA'
    WHERE o53_subfuncao=242;

    UPDATE orcamento.orcsubfuncao
    SET o53_descr='TRANSPORTE HIDROVIÁRIO', o53_finali='TRANSPORTE HIDROVIÁRIO'
    WHERE o53_subfuncao=784;

    COMMIT;

SQL;
        $this->execute($sql);
    } 
}