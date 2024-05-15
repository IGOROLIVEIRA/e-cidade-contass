<?php

use Phinx\Migration\AbstractMigration;

class Menuss1000s1005 extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        $sql = "
               --ALTERANDO A FUNCAO DO FOMULARIO S1000

                    UPDATE db_itensmenu
                    SET funcao = 'con4_manutencaoformulario001.php?esocial=1',
                        descricao = 'S-1000 - Informações do Empregador/Contribuinte/Órgão Público'
                    WHERE id_item =
                            (SELECT db_itensmenu.id_item
                             FROM db_menu
                             INNER JOIN db_itensmenu ON db_itensmenu.id_item = db_menu.id_item_filho
                             WHERE descricao = 'Informações do Empregador - S1000 e S1005');
                    
                    --INSERINDO NOVO MENU PARA FORMULARIO S1005
                    
                    INSERT INTO db_itensmenu
                    VALUES (
                                (SELECT max(id_item)+1
                                 FROM db_itensmenu), 'S-1005 - Tabela de Estabelecimentos, Obras ou Unidades de Órgãos Públicos',
                                                     'S-1005 - Tabela de Estabelecimentos, Obras ou Unidades de Órgãos Públicos',
                                                     ' con4_manutencaoformulario001.php?esocial=26',
                                                     1,
                                                     1,
                                                     'S-1005 - Tabela de Estabelecimentos, Obras ou Unidades de Órgãos Públicos',
                                                     't');
                    
                    INSERT INTO db_menu
                    VALUES(
                               (SELECT id_item
                                FROM db_itensmenu
                                WHERE descricao = 'Tabelas'
                                    AND help = 'Tabelas'
                                    AND desctec = 'Tabelas'
                                    AND id_item > 300000),
                               (SELECT max(id_item)
                                FROM db_itensmenu),2,
                                                   10216);
                    
                    UPDATE db_itensmenu
                    SET descricao = 'Eventos iniciais e de Tabelas'
                    WHERE id_item IN
                            (SELECT id_item
                             FROM db_itensmenu
                             WHERE descricao = 'Tabelas'
                                 AND help = 'Tabelas'
                                 AND desctec = 'Tabelas'
                                 AND id_item > 300000);
        ";

        $this->execute($sql);

    }
}
