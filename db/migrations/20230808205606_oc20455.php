<?php

use Phinx\Migration\AbstractMigration;

class Oc20455 extends AbstractMigration
{
    public function up()
    {
        $sql = "
        INSERT INTO db_itensmenu VALUES (
            (SELECT max(id_item)+1 FROM db_itensmenu),
            'Controle de Datas',
            'Controle de Datas',
            '',
            1,
            1,
            'Controle de Datas',
            't');

        INSERT INTO db_menu VALUES(
                                   (SELECT id_item FROM db_itensmenu WHERE descricao LIKE '%(Patrimonial)%'),
                                   (SELECT max(id_item) from db_itensmenu),
                                   5,
                                   1);

        INSERT INTO db_itensmenu VALUES (
                            (SELECT max(id_item)+1 FROM db_itensmenu),
                            'Material / Serviço',
                            'Material / Serviço',
                            'm4_controledatas_materialservico.php',
                            1,
                            1,
                            'Material / Serviço',
                            't');

        INSERT INTO db_menu VALUES(
                    (SELECT id_item FROM db_itensmenu WHERE desctec = 'Controle de Datas'),
                    (SELECT max(id_item) from db_itensmenu),
                    1,
                    1);

        INSERT INTO db_itensmenu VALUES (
                                    (SELECT max(id_item)+1 FROM db_itensmenu),
                                    'Solicitação de Compra',
                                    'Solicitação de Compra',
                                    'm4_controledatas_solicitacaocompra.php',
                                    1,
                                    1,
                                    'Solicitação de Compra',
                                    't');

        INSERT INTO db_menu VALUES(
                    (SELECT id_item FROM db_itensmenu WHERE desctec = 'Controle de Datas'),
                    (SELECT max(id_item) from db_itensmenu),
                    2,
                    1);

        INSERT INTO db_itensmenu VALUES (
                                    (SELECT max(id_item)+1 FROM db_itensmenu),
                                    'Processo de Compra',
                                    'Processo de Compra',
                                    'm4_controledatas_processocompra.php',
                                    1,
                                    1,
                                    'Processo de Compra',
                                    't');

        INSERT INTO db_menu VALUES(
                    (SELECT id_item FROM db_itensmenu WHERE desctec = 'Controle de Datas'),
                    (SELECT max(id_item) from db_itensmenu),
                    3,
                    1);

        INSERT INTO db_itensmenu VALUES (
                                    (SELECT max(id_item)+1 FROM db_itensmenu),
                                    'Orçamentos',
                                    'Orçamentos',
                                    'm4_controledatas_orcamentos.php',
                                    1,
                                    1,
                                    'Orçamentos',
                                    't');

        INSERT INTO db_menu VALUES(
                    (SELECT id_item FROM db_itensmenu WHERE desctec = 'Controle de Datas'),
                    (SELECT max(id_item) from db_itensmenu),
                    4,
                    1);
        ";

        $this->execute($sql);
    }
}
