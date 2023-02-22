<?php

use Phinx\Migration\AbstractMigration;

class Oc19758v3 extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL
            begin;    

            ALTER TABLE public.consvalorestransf ADD c201_codacompanhamento text NULL;

            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
            VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c201_codacompanhamento', 'text', 'Codigo de Acompanhamento', 'null', 'Codigo de Acompanhamento', 4, FALSE, FALSE, FALSE, 0, 'text', 'Codigo de Acompanhamento');

            ALTER TABLE public.consexecucaoorc ADD c202_codacompanhamento text NULL;

            INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel)
            VALUES ((SELECT max(codcam)+1 FROM db_syscampo), 'c202_codacompanhamento', 'text', 'Codigo de Acompanhamento', 'null', 'Codigo de Acompanhamento', 4, FALSE, FALSE, FALSE, 0, 'text', 'Codigo de Acompanhamento');

            ALTER TABLE public.consor202023 ADD si17_codacompanhamento text NULL;

            ALTER TABLE public.consor302023 ADD si18_codacompanhamento text NULL;
   

            commit;
SQL;
        $this->execute($sql);
    }
}