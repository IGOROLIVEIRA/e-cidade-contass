<?php

use Classes\PostgresMigration;

class Oc14713 extends PostgresMigration
{

    public function up()
    {
        $this->addFieldDtFechamento();
        $this->addFieldDiasLiberarContraCheque();
    }

    public function down()
    {
        $this->removeFieldDtFechamento();
        $this->removeFieldDiasLiberarContraCheque();
    }

    public function addFieldDtFechamento()
    {
        $sSql = "ALTER TABLE cfpess ADD COLUMN r11_dtfechamento date;
        INSERT INTO db_syscampo VALUES ((SELECT MAX(codcam)+1 FROM db_syscampo),'r11_dtfechamento','date','Data de fechamento da folha', '', 'Data de fechamento da folha', 8, 't', 'f', 'f', NULL, NUll, 'Data de fechamento da folha');
        INSERT INTO db_sysarqcamp VALUES (536, (SELECT MAX(codcam) FROM db_syscampo), (SELECT max(seqarq)+1 FROM db_sysarqcamp WHERE codarq=536));
        ";

        $this->execute($sSql);
    }

    public function addFieldDiasLiberarContraCheque()
    {
        $sSql = "ALTER TABLE cfpess ADD COLUMN r11_diasliberarcontracheque int4 default 0;
        INSERT INTO db_syscampo VALUES ((SELECT MAX(codcam)+1 FROM db_syscampo),'r11_diasliberarcontracheque','int4','Dias Liberação Contra-cheque', 0, 'Dias Liberação Contra-cheque', 8, 'f', 'f', 'f', 1, 'text', 'Dias Liberação Contra-cheque');
        INSERT INTO db_sysarqcamp VALUES (536, (SELECT MAX(codcam) FROM db_syscampo), (SELECT max(seqarq)+1 FROM db_sysarqcamp WHERE codarq=536));
        ";

        $this->execute($sSql);
    }

    public function removeFieldDtFechamento() 
    {
        $sSql = "ALTER TABLE cfpess DROP COLUMN r11_dtfechamento;
        DELETE FROM db_sysarqcamp WHERE codcam = (SELECT codcam FROM db_syscampo WHERE nomecam = 'r11_dtfechamento');
        DELETE FROM db_syscampo WHERE codcam = (SELECT codcam FROM db_syscampo WHERE nomecam = 'r11_dtfechamento');
        ";

        $this->execute($sSql);
    }

    public function removeFieldDiasLiberarContraCheque()
    {
        $sSql = "ALTER TABLE cfpess DROP COLUMN r11_diasliberarcontracheque;
        DELETE FROM db_sysarqcamp WHERE codcam = (SELECT codcam FROM db_syscampo WHERE nomecam = 'r11_diasliberarcontracheque');
        DELETE FROM db_syscampo WHERE codcam = (SELECT codcam FROM db_syscampo WHERE nomecam = 'r11_diasliberarcontracheque');
        ";

        $this->execute($sSql);
    }

}
