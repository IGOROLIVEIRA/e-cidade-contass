<?php

use Phinx\Migration\AbstractMigration;

class Oc14425Hotfix extends AbstractMigration
{
     public function up()
    {
        $sql = '
                BEGIN;
                INSERT INTO db_tipodoc VALUES (1507, \'ASSINATURA DA CONCILIACAO\');

                DELETE FROM db_documentopadrao WHERE db60_coddoc = 0;
                INSERT INTO db_documentopadrao VALUES ((SELECT max(db60_coddoc) FROM db_documentopadrao)+1, \'ASSINATURA DA CONCILIACAO\', 1507, 1);

                DELETE FROM db_paragrafopadrao WHERE db61_codparag = 0;
                INSERT INTO db_paragrafopadrao VALUES
                ((SELECT MAX(db61_codparag) FROM db_paragrafopadrao)+1, \'ASSINATURA DA CONCILIACAO\', \'
                $xlin = 20;
                $xcol = 10;

                // Tipo dos Responsáveis
                $pdf->text($xcol + 22,  $xlin + 155, \'\'SECRETÁRIO DE FINANÇAS\'\');
                $pdf->text($xcol + 96,  $xlin + 155, \'\'CONTADOR\'\');
                $pdf->text($xcol + 165, $xlin + 155, \'\'TESOUREIRO\'\');
                $pdf->text($xcol + 230, $xlin + 155, \'\'PREFEITO MUNICIPAL\'\');

                // Linha da Assinatura
                $pdf->line($xcol + 10,  $xlin + 150, $xcol + 65,  $xlin + 150);
                $pdf->line($xcol + 75,  $xlin + 150, $xcol + 130, $xlin + 150);
                $pdf->line($xcol + 145, $xlin + 150, $xcol + 200, $xlin + 150);
                $pdf->line($xcol + 215, $xlin + 150, $xcol + 270, $xlin + 150);

                $pdf->SetFont(\'\'Arial\'\',\'\'\'\',6);

                // Nome dos Responsáveis
                $pdf->text($xcol + 35,  $xlin + 160, \'\'NOME 1\'\');
                $pdf->text($xcol + 33,  $xlin + 163, \'\'Identificador\'\');
                $pdf->text($xcol + 100, $xlin + 160, \'\'NOME 2\'\');
                $pdf->text($xcol + 98,  $xlin + 163, \'\'Identificador\'\');
                $pdf->text($xcol + 170, $xlin + 160, \'\'NOME 3\'\');
                $pdf->text($xcol + 168, $xlin + 163, \'\'Identificador\'\');
                $pdf->text($xcol + 240, $xlin + 160, \'\'NOME 4\'\');
                $pdf->text($xcol + 238, $xlin + 163, \'\'Identificador\'\');
                COMMIT;
            ';

        // $this->execute($sql);
        $sql = "INSERT INTO db_docparagpadrao VALUES (" . $this->getDb60CodDoc("ASSINATURA DA CONCILIACAO") . ", " . $this->getDb61CodParag("ASSINATURA DA CONCILIACAO") . ", 1)";
        // $this->execute($sql);
    }

    public function getDb61CodParag($descricao)
    {
        $sql = "SELECT db61_codparag FROM db_paragrafopadrao WHERE db61_descr = '{$descricao}'";
        $row = $this->fetchAll($sql);
        foreach ($row as $data) {
            return $data["db61_codparag"];
        }
    }

    public function getDb60CodDoc($descricao) {
        $sql = "SELECT db60_coddoc FROM db_documentopadrao WHERE db60_descr = '{$descricao}'";
        $row = $this->fetchAll($sql);
        foreach ($row as $data) {
            return $data["db60_coddoc"];
        }
    }

    public function down()
    {

    }
}
