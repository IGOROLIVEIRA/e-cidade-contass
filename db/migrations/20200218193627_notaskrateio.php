<?php

use Phinx\Migration\AbstractMigration;

class Notaskrateio extends AbstractMigration
{
    public function up()
    {
        $sSql = "INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'o55_rateio', 'bool', 'Rateio', false, 'Rateio', 1, false, false, false, 5, 'text', 'o55_rateio');

                 INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES ((select max(codarq) from db_sysarquivo), (select codcam from db_syscampo where nomecam = 'o55_rateio'), 8, 0);
                 
                 ALTER TABLE orcprojativ ADD column o55_rateio bool;
                 
                 UPDATE db_syscampo SET descricao='Rateio', rotulo='Rateio', rotulorel= 'Rateio' WHERE nomecam LIKE '%o55_rateio%';
                 ";

        $this->execute($sSql);
    }
}
