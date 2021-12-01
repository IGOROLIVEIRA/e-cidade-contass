<?php

use Phinx\Migration\AbstractMigration;

class RemoverChaveEstrangeiraRubricas extends AbstractMigration
{

    public function up()
    {
        $sql = "
        ALTER TABLE rhrubricas DROP CONSTRAINT rhrubricas_rh27_codincidfgts_fkey;
        ALTER TABLE rhrubricas DROP CONSTRAINT rhrubricas_rh27_codincidirrf_fkey;
        ALTER TABLE rhrubricas DROP CONSTRAINT rhrubricas_rh27_codincidprev_fkey;
        ALTER TABLE rhrubricas DROP CONSTRAINT rhrubricas_rh27_codincidregime_fkey;
        ";

        $this->execute($sql);
    }

    public function down()
    {
        $sql = "
        ALTER TABLE rhrubricas ADD FOREIGN KEY (rh27_codincidprev) REFERENCES avaliacaoperguntaopcao(db104_sequencial);
        ALTER TABLE rhrubricas ADD FOREIGN KEY (rh27_codincidirrf) REFERENCES avaliacaoperguntaopcao(db104_sequencial);
        ALTER TABLE rhrubricas ADD FOREIGN KEY (rh27_codincidfgts) REFERENCES avaliacaoperguntaopcao(db104_sequencial);
        ALTER TABLE rhrubricas ADD FOREIGN KEY (rh27_codincidregime) REFERENCES avaliacaoperguntaopcao(db104_sequencial);
        ";

        $this->execute($sql);
    }
}
