<?php

use Phinx\Migration\AbstractMigration;

class CreateDicionarioPregrao extends AbstractMigration
{
    public function up()
    {
        $this->execute("INSERT INTO db_syscampo (codcam, nomecam, conteudo, descricao, valorinicial, rotulo, tamanho, nulo, maiusculo, autocompl, aceitatipo, tipoobj, rotulorel) VALUES ((select max(codcam)+1 from db_syscampo), 'l21_reservado', 'bool', 'ME/EPP', '', 'ME/EPP', 3, false, false, false, 1, 'text', 'ME/EPP')");
        $this->execute("INSERT INTO db_sysarqcamp (codarq, codcam, seqarq, codsequencia) VALUES (1261, (select codcam from db_syscampo where nomecam = 'l21_reservado'), 5, 0)");
    }
}
