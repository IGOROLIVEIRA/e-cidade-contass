<?php

use Phinx\Migration\AbstractMigration;

class Oc12724 extends AbstractMigration
{
    public function up()
    {
        $this->insertMenu("Termo de Rescisão", "pes2_termorescisao001.php", 1);
        $this->insertMenu("Termo de Rescisão (novo)", "pes4_termorescisaonovo001.php", 2);
        $this->insertMenu("Termo de Quitação", "pes4_termorescisaoquitacao001.php", 3);
        $this->insertMenu("Termo de Homologação", "pes4_termorescisaohomologacao001.php", 4);
    }

    public function down()
    {
        $this->deleteMenu("pes2_termorescisao001.php");
        $this->deleteMenu("pes4_termorescisaonovo001.php");
        $this->deleteMenu("pes4_termorescisaoquitacao001.php");
        $this->deleteMenu("pes4_termorescisaohomologacao001.php");
    }

    private function getIdMenu($file)
    {
        $idMenu = $this->fetchRow("SELECT id_item FROM configuracoes.db_itensmenu WHERE funcao = '{$file}' ORDER BY id_item DESC");
        return current($idMenu);
    }

    private function insertMenu($description, $file, $sequencia)
    {
        $sql = "
        INSERT INTO configuracoes.db_itensmenu
        VALUES (
        (SELECT max(id_item)+1
        FROM configuracoes.db_itensmenu),'{$description}',
        '{$description}',
        '{$file}',
        1,
        1,
        '{$description}',
        't');

        INSERT INTO configuracoes.db_menu
        VALUES(5238,
        (SELECT max(id_item)
        FROM configuracoes.db_itensmenu),$sequencia,
        952);
        ";

        $this->execute($sql);
    }

    private function deleteMenu($file)
    {
        $idMenu = $this->getIdMenu($file);
        $sql = "
        DELETE FROM configuracoes.db_menu WHERE id_item_filho = {$idMenu};
        DELETE FROM configuracoes.db_itensmenu WHERE id_item = {$idMenu};
        ";
        $this->execute($sql);
    }

}
