<?php

use Phinx\Migration\AbstractMigration;

class AltLayoutOc13532 extends AbstractMigration
{

    public function up()
    {
        $sql = <<<SQL
        INSERT INTO db_layoutlinha (db51_codigo, db51_layouttxt, db51_descr, db51_tipolinha, db51_tamlinha, db51_linhasantes, db51_linhasdepois, db51_obs, db51_separador, db51_compacta) VALUES ((SELECT max(db51_codigo)+1 FROM db_layoutlinha), (SELECT db50_codigo FROM db_layouttxt WHERE db50_descr = 'CNAB240 BANCO SICOOB'), 'TRAILLER DE ARQUIVO', 5, 240, 0, 0, '', '', false);

        INSERT INTO db_layoutcampos (db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos) VALUES ((SELECT max(db52_codigo)+1 FROM db_layoutcampos), (SELECT max(db51_codigo) FROM db_layoutlinha), 'db90_codban', 'CODIGO DO BANCO NA COMPENSACAO', 2, 1, '', 3, false, true, 'e', '', 0);
        INSERT INTO db_layoutcampos (db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos) VALUES ((SELECT max(db52_codigo)+1 FROM db_layoutcampos), (SELECT max(db51_codigo) FROM db_layoutlinha), 'loteservico', 'LOTE DE SERVICO', 2, 4, '9999', 4, false, true, 'e', '', 0);
        INSERT INTO db_layoutcampos (db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos) VALUES ((SELECT max(db52_codigo)+1 FROM db_layoutcampos), (SELECT max(db51_codigo) FROM db_layoutlinha), 'registrotraillerarq', 'REGISTRO TRAILLER DE ARQUIVO', 1, 8, '9', 1, true, true, 'd', '', 0);
        INSERT INTO db_layoutcampos (db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos) VALUES ((SELECT max(db52_codigo)+1 FROM db_layoutcampos), (SELECT max(db51_codigo) FROM db_layoutlinha), 'usofebraban1', 'USO EXCLUSIVO FEBRABAN/CNAB', 1, 9, '', 9, false, true, 'd', '', 0);
        INSERT INTO db_layoutcampos (db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos) VALUES ((SELECT max(db52_codigo)+1 FROM db_layoutcampos), (SELECT max(db51_codigo) FROM db_layoutlinha), 'quantidadelotesarq', 'QUANTIDADE DE LOTES DO ARQUIVO', 2, 18, '', 6, false, true, 'e', '', 0);
        INSERT INTO db_layoutcampos (db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos) VALUES ((SELECT max(db52_codigo)+1 FROM db_layoutcampos), (SELECT max(db51_codigo) FROM db_layoutlinha), 'quantidaderegistarq', 'QUANTIDADE DE REGISTROS DO ARQUIVO', 2, 24, '', 6, false, true, 'e', '', 0);
        INSERT INTO db_layoutcampos (db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos) VALUES ((SELECT max(db52_codigo)+1 FROM db_layoutcampos), (SELECT max(db51_codigo) FROM db_layoutlinha), 'quantidadecontasconc', 'QUANTIDADE DE CONTAS PARA CONCILIO', 2, 30, '', 6, false, true, 'e', '', 0);
        INSERT INTO db_layoutcampos (db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos) VALUES ((SELECT max(db52_codigo)+1 FROM db_layoutcampos), (SELECT max(db51_codigo) FROM db_layoutlinha), 'usofebraban2', 'USO EXCLUSIVO FEBRABAN/CNAB', 1, 36, '', 205, false, true, 'd', '', 0);


        DELETE FROM db_layoutcampos WHERE (db52_layoutlinha, db52_nome) = ((SELECT db51_codigo FROM db_layouttxt JOIN db_layoutlinha ON db50_codigo = db51_layouttxt WHERE db50_descr = 'CNAB240 BANCO SICOOB' AND db51_descr = 'REGISTRO - SEGMENTO B'), 'usofebraban2');

        INSERT INTO db_layoutcampos (db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos) VALUES ((SELECT max(db52_codigo)+1 FROM db_layoutcampos), (SELECT db51_codigo FROM db_layouttxt JOIN db_layoutlinha ON db50_codigo = db51_layouttxt WHERE db50_descr = 'CNAB240 BANCO SICOOB' AND db51_descr = 'REGISTRO - SEGMENTO B'), 'avisofavorecido', 'AVISO AO FAVORECIDO', 1, 226, '0', 1, false, true, 'd', '', 0);
        INSERT INTO db_layoutcampos (db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos) VALUES ((SELECT max(db52_codigo)+1 FROM db_layoutcampos), (SELECT db51_codigo FROM db_layouttxt JOIN db_layoutlinha ON db50_codigo = db51_layouttxt WHERE db50_descr = 'CNAB240 BANCO SICOOB' AND db51_descr = 'REGISTRO - SEGMENTO B'), 'UsoSIAPE', 'USO EXCLUSIVO PARA O SIAPE', 1, 227, '', 6, false, true, 'd', '', 0);
        INSERT INTO db_layoutcampos (db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos) VALUES ((SELECT max(db52_codigo)+1 FROM db_layoutcampos), (SELECT db51_codigo FROM db_layouttxt JOIN db_layoutlinha ON db50_codigo = db51_layouttxt WHERE db50_descr = 'CNAB240 BANCO SICOOB' AND db51_descr = 'REGISTRO - SEGMENTO B'), 'usofebraban2', 'USO EXCLUSIVO FEBRABAN/CNAB', 1, 233, '', 8, false, true, 'd', '', 0);


SQL;
        $this->execute($sql);
    }

    public function down()
    {

    }
}
