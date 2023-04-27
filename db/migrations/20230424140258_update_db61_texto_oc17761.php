<?php

use Phinx\Migration\AbstractMigration;

class UpdateDb61TextoOc17761 extends AbstractMigration
{

    public function up()
    {
        $sql = '
        BEGIN;
        UPDATE configuracoes.db_paragrafopadrao
        SET db61_texto = \'
            $this->objpdf->rect($xcol,$xlin+217,66,51,2,\'\'DF\'\',\'\'1234\'\');
            $this->objpdf->rect($xcol+68,$xlin+217,66,51,2,\'\'DF\'\',\'\'1234\'\');
            $this->objpdf->rect($xcol+136,$xlin+217,66,51,2,\'\'DF\'\',\'\'1234\'\');
            $this->objpdf->setfillcolor(0,0,0);

            $y = 260;

            $this->objpdf->Setfont(\'\'Arial\'\',\'\'B\'\',8);
            // ASSINATURAS DA AUTORIZACAO
            $cont  = "AUTORIZO"."_______________________________";
            $ord   = "AUTORIZO"."_______________________________";
            $visto = "VISTO";

            $ass_cont   = $this->assinatura(1006,$cont);
            $ass_ord    = $this->assinatura(1002,$ord);
            $ass_visto  = $this->assinatura(5000,$visto);

            $this->objpdf->SetXY(2.5,$y);
            $this->objpdf->MultiCell(70,4,$ass_cont,0,"C",0);
            $this->objpdf->SetXY(71,$y);

            $this->objpdf->text($xcol+95,$xlin+223,\'\'AUTORIZO\'\');

            $this->objpdf->MultiCell(70,4,$ass_ord,0,"C",0);
            $this->objpdf->SetXY(137,$y);
            $this->objpdf->MultiCell(70,4,$ass_visto,0,"C",0);
            $this->objpdf->setfillcolor(0,0,0);

            $this->objpdf->text($xcol+3,$xlin+233,$this->municpref.\'\', \'\'.substr($this->emissao,8,2).\'\' DE \'\'.strtoupper(db_mes(substr($this->emissao,5,2))).\'\'
             DE \'\'.db_getsession("DB_anousu").\'\'.\'\');\'
        WHERE db61_descr = \'PARAGRAFO AUTORIZACAO\';
        COMMIT;
        ';
        $this->execute($sql);
    }

    public function down()
    {
        $sql = '
        BEGIN;
        UPDATE configuracoes.db_paragrafopadrao
        SET db61_texto = \'
            $this->objpdf->rect($xcol,$xlin+217,66,55,2,\'\'DF\'\',\'\'1234\'\');
            $this->objpdf->rect($xcol+68,$xlin+217,66,55,2,\'\'DF\'\',\'\'1234\'\');
            $this->objpdf->rect($xcol+136,$xlin+217,66,55,2,\'\'DF\'\',\'\'1234\'\');
            $this->objpdf->setfillcolor(0,0,0);

            $y = 260;

            $this->objpdf->Setfont(\'\'Arial\'\',\'\'B\'\',8);
            // ASSINATURAS DA AUTORIZACAO
            $cont  = "AUTORIZO"."_______________________________";
            $ord   = "AUTORIZO"."_______________________________";
            $visto = "VISTO";

            $ass_cont   = $this->assinatura(1006,$cont);
            $ass_ord    = $this->assinatura(1002,$ord);
            $ass_visto  = $this->assinatura(5000,$visto);

            $this->objpdf->SetXY(2.5,$y);
            $this->objpdf->MultiCell(70,4,$ass_cont,0,"C",0);
            $this->objpdf->SetXY(71,$y);

            $this->objpdf->text($xcol+95,$xlin+223,\'\'AUTORIZO\'\');

            $this->objpdf->MultiCell(70,4,$ass_ord,0,"C",0);
            $this->objpdf->SetXY(137,$y);
            $this->objpdf->MultiCell(70,4,$ass_visto,0,"C",0);
            $this->objpdf->setfillcolor(0,0,0);

            $this->objpdf->text($xcol+3,$xlin+233,$this->municpref.\'\', \'\'.substr($this->emissao,8,2).\'\' DE \'\'.strtoupper(db_mes(substr($this->emissao,5,2))).\'\'
             DE \'\'.db_getsession("DB_anousu").\'\'.\'\');\'
        WHERE db61_descr = \'PARAGRAFO AUTORIZACAO\';
        COMMIT;
        ';
        $this->execute($sql);
    }
}
