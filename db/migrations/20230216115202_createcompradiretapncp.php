<?php

use Phinx\Migration\AbstractMigration;

class Createcompradiretapncp extends AbstractMigration
{
    public function up()
    {
        $sql = "
            alter table pcproc add column pc80_numdispensa int8;
            alter table pcproc add column pc80_dispvalor bool;
            alter table pcproc add column pc80_orcsigiloso bool;
            alter table pcproc add column pc80_subcontratacao bool;
            alter table pcproc add column pc80_dadoscomplementares text;        
            alter table pcproc add column pc80_amparolegal int8;

            INSERT INTO db_menu VALUES(32,(select id_item from db_itensmenu where descricao='PNCP'),51,28);

            INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu), 'Dispensa por Valor', 'Dispensa por Valor', 'com1_pncpdispensaporvalor001.php', 1, 1, 'Dispensa por Valor', 't');
            INSERT INTO db_menu VALUES((select id_item from db_itensmenu where desctec like'%PNCP' and funcao = ' '),(select max(id_item) from db_itensmenu),1,28);

            INSERT INTO db_itensmenu VALUES ((select max(id_item)+1 from db_itensmenu), 'Anexos PNCP', 'Anexos PNCP', 'com1_pncpanexosdispensaporvalor001.php', 1, 1, 'Anexos PNCP', 't');
            INSERT INTO db_menu VALUES((select id_item from db_itensmenu where descricao like'%Processo de compras'),(select max(id_item) from db_itensmenu),5,28);

            alter table liccontrolepncp add column l213_processodecompras int8;        

        ";
    }
}
