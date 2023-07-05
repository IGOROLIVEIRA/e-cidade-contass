<?php

use Phinx\Migration\AbstractMigration;

class Oc19317 extends AbstractMigration
{
    public function up()
    {
       $sSql = "SELECT setval('db_layouttxt_db50_codigo_seq',
                                  (SELECT max(db50_codigo)+1
                                   FROM db_layouttxt));

                SELECT setval('db_layoutlinha_db51_codigo_seq',
                  (SELECT max(db51_codigo)+1
                   FROM configuracoes.db_layoutlinha));

                SELECT setval('db_layoutcampos_db52_codigo_seq',
                                  (SELECT max(db52_codigo)+1
                                   FROM configuracoes.db_layoutcampos));

                INSERT INTO configuracoes.db_layouttxt
                VALUES(nextval('db_layouttxt_db50_codigo_seq'),
                       'SICOM IP MTFIS 2023',
                       0,
                       'Detalhamento das Metas Fiscais - 2023',
                       3);

                INSERT INTO configuracoes.db_layoutlinha
                VALUES(nextval('db_layoutlinha_db51_codigo_seq'),

                       (SELECT db50_codigo FROM configuracoes.db_layouttxt
                        WHERE db50_descr = 'SICOM IP MTFIS 2023'),

                       'DETALHAMENTO DAS METAS FISCAIS - IP 2023',
                       3,
                       354,
                       0,
                       0,
                       '',
                       ';',
                       FALSE);

                INSERT INTO configuracoes.db_layoutcampos
                VALUES(nextval('db_layoutcampos_db52_codigo_seq'),

               (SELECT db51_codigo FROM configuracoes.db_layoutlinha
                WHERE db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2023'),

               'exercicio', 'EXERCICIO DA META FISCAL', 14, 1, '', 4, false, true, 'd', '', 0);


                INSERT INTO configuracoes.db_layoutcampos
                VALUES(nextval('db_layoutcampos_db52_codigo_seq'),

               (SELECT db51_codigo FROM configuracoes.db_layoutlinha
                WHERE db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2023'),

               'vlCorrenteReceitaTotal', 'VALOR CORRENTE DA RECEITA TOTAL', 14, 5, '', 14, false, true, 'd', '', 0);


                INSERT INTO configuracoes.db_layoutcampos
                VALUES(nextval('db_layoutcampos_db52_codigo_seq'),

               (SELECT db51_codigo FROM configuracoes.db_layoutlinha
                WHERE db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2023'),

               'vlCorrenteRecImpTaxContrMelh', 'Valor Corrente das Receitas I', 14, 19, '', 14, false, true, 'd', '', 0);


                INSERT INTO configuracoes.db_layoutcampos
                VALUES(nextval('db_layoutcampos_db52_codigo_seq'),

               (SELECT db51_codigo FROM configuracoes.db_layoutlinha
                WHERE db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2023'),

               'vlCorrenteRecTransfCorr', 'Valor Corrente das Receitas de T', 14, 47, '', 14, false, true, 'd', '', 0);


                INSERT INTO configuracoes.db_layoutcampos
                VALUES(nextval('db_layoutcampos_db52_codigo_seq'),

               (SELECT db51_codigo FROM configuracoes.db_layoutlinha
                WHERE db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2023'),

               'vlCorrenteDemaisRecPrimCorr', 'Valor Corrente das Demais R', 14, 61, '', 14, false, true, 'd', '', 0);


                INSERT INTO configuracoes.db_layoutcampos
                VALUES(nextval('db_layoutcampos_db52_codigo_seq'),

               (SELECT db51_codigo FROM configuracoes.db_layoutlinha
                WHERE db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2023'),

               'vlCorrenteRecPrimCap', 'Valor Corrente das Receitas P C', 14, 75, '', 14, false, true, 'd', '', 0);


                INSERT INTO configuracoes.db_layoutcampos
                VALUES(nextval('db_layoutcampos_db52_codigo_seq'),

               (SELECT db51_codigo FROM configuracoes.db_layoutlinha
                WHERE db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2023'),

               'vlCorrenteDespesaTotal', 'Valor Corrente da D T', 14, 89, '', 14, false, true, 'd', '', 0);


                INSERT INTO configuracoes.db_layoutcampos
                VALUES(nextval('db_layoutcampos_db52_codigo_seq'),

               (SELECT db51_codigo FROM configuracoes.db_layoutlinha
                WHERE db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2023'),

               'vlCorrenteDespPessEncSoc', 'Valor Corrente das Despesas P E S', 14, 103, '', 14, false, true, 'd', '', 0);


                INSERT INTO configuracoes.db_layoutcampos
                VALUES(nextval('db_layoutcampos_db52_codigo_seq'),

               (SELECT db51_codigo FROM configuracoes.db_layoutlinha
                WHERE db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2023'),

               'vlCorrenteOutrasDespCorr', 'Valor Corrente das Outras D C', 14, 117, '', 14, false, true, 'd', '', 0);


                INSERT INTO configuracoes.db_layoutcampos
                VALUES(nextval('db_layoutcampos_db52_codigo_seq'),

               (SELECT db51_codigo FROM configuracoes.db_layoutlinha
                WHERE db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2023'),

               'vlCorrenteDespPrimCap', 'Valor Corrente das  Despesas P C', 14, 131, '', 14, false, true, 'd', '', 0);


                INSERT INTO configuracoes.db_layoutcampos
                VALUES(nextval('db_layoutcampos_db52_codigo_seq'),

               (SELECT db51_codigo FROM configuracoes.db_layoutlinha
                WHERE db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2023'),

               'vlCorrentePagRPDespPrim', 'Valor Corrente dos Pagamento', 14, 145, '', 14, false, true, 'd', '', 0);


                INSERT INTO configuracoes.db_layoutcampos
                VALUES(nextval('db_layoutcampos_db52_codigo_seq'),

               (SELECT db51_codigo FROM configuracoes.db_layoutlinha
                WHERE db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2023'),

               'vlCorrenteDividaPublicaConsolidada', 'Valor Corrente da D P C', 14, 177, '', 14, false, true, 'd', '', 0);


                INSERT INTO configuracoes.db_layoutcampos
                VALUES(nextval('db_layoutcampos_db52_codigo_seq'),

               (SELECT db51_codigo FROM configuracoes.db_layoutlinha
                WHERE db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2023'),

               'vlCorrenteDividaConsolidadaLiquida', 'Valor Corrente da D C L', 14, 191, '', 7, false, true, 'd', '', 0);


                INSERT INTO configuracoes.db_layoutcampos
                VALUES(nextval('db_layoutcampos_db52_codigo_seq'),

               (SELECT db51_codigo FROM configuracoes.db_layoutlinha
                WHERE db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2023'),

               'vlConstanteReceitaTotal', 'Valor Constante da Receita Total', 14, 205, '', 7, false, true, 'd', '', 0);


                INSERT INTO configuracoes.db_layoutcampos
                VALUES(nextval('db_layoutcampos_db52_codigo_seq'),

               (SELECT db51_codigo FROM configuracoes.db_layoutlinha
                WHERE db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2023'),

               'vlConstanteRecImpTaxContrMelh', 'Valor Constante das R I', 14, 219, '', 7, false, true, 'd', '', 0);


                INSERT INTO configuracoes.db_layoutcampos
                VALUES(nextval('db_layoutcampos_db52_codigo_seq'),

               (SELECT db51_codigo FROM configuracoes.db_layoutlinha
                WHERE db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2023'),

               'vlConstanteRecTransfCorr', 'Valor Constante das R T', 14, 247, '', 7, false, true, 'd', '', 0);


                INSERT INTO configuracoes.db_layoutcampos
                VALUES(nextval('db_layoutcampos_db52_codigo_seq'),

               (SELECT db51_codigo FROM configuracoes.db_layoutlinha
                WHERE db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2023'),

               'vlConstanteDemaisRecPrimCorr', 'Valor Constante D R', 14, 261, '', 7, false, true, 'd', '', 0);


                INSERT INTO configuracoes.db_layoutcampos
                VALUES(nextval('db_layoutcampos_db52_codigo_seq'),

               (SELECT db51_codigo FROM configuracoes.db_layoutlinha
                WHERE db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2023'),

               'vlConstanteRecPrimCap', 'Valor Constante das R P', 14, 275, '', 7, false, true, 'd', '', 0);


                INSERT INTO configuracoes.db_layoutcampos
                VALUES(nextval('db_layoutcampos_db52_codigo_seq'),

               (SELECT db51_codigo FROM configuracoes.db_layoutlinha
                WHERE db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2023'),

               'vlConstanteDespesaTotal', 'Valor Corrente da Despesa Total', 14, 289, '', 14, false, true, 'd', '', 0);


                INSERT INTO configuracoes.db_layoutcampos
                VALUES(nextval('db_layoutcampos_db52_codigo_seq'),

               (SELECT db51_codigo FROM configuracoes.db_layoutlinha
                WHERE db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2023'),

               'vlConstanteDespPessEncSoc', 'Valor Constante das Despesas', 14, 303, '', 14, false, true, 'd', '', 0);


                INSERT INTO configuracoes.db_layoutcampos
                VALUES(nextval('db_layoutcampos_db52_codigo_seq'),

               (SELECT db51_codigo FROM configuracoes.db_layoutlinha
                WHERE db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2023'),

               'vlConstanteOutrasDespCorr', 'Valor Constante das O D C', 14, 317, '', 7, false, true, 'd', '', 0);


                INSERT INTO configuracoes.db_layoutcampos
                VALUES(nextval('db_layoutcampos_db52_codigo_seq'),

               (SELECT db51_codigo FROM configuracoes.db_layoutlinha
                WHERE db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2023'),

               'vlConstanteDespPrimCap', 'Valor Constante das  Despesas P C', 14, 331, '', 14, false, true, 'd', '', 0);


                INSERT INTO configuracoes.db_layoutcampos
                VALUES(nextval('db_layoutcampos_db52_codigo_seq'),

               (SELECT db51_codigo FROM configuracoes.db_layoutlinha
                WHERE db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2023'),

               'vlConstantePagRPDespPrim', 'Valor Constante dos P Restos', 14, 345, '', 14, false, true, 'd', '', 0);


                INSERT INTO configuracoes.db_layoutcampos
                VALUES(nextval('db_layoutcampos_db52_codigo_seq'),

               (SELECT db51_codigo FROM configuracoes.db_layoutlinha
                WHERE db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2023'),

               'vlConstanteDividaPublicaConsolidada', 'Valor Constante D P', 14, 387, '', 7, false, true, 'd', '', 0);


                INSERT INTO configuracoes.db_layoutcampos
                VALUES(nextval('db_layoutcampos_db52_codigo_seq'),

               (SELECT db51_codigo FROM configuracoes.db_layoutlinha
                WHERE db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2023'),

               'vlConstanteDividaConsolidadaLiquida', 'Valor Constante da D L', 14, 401, '', 7, false, true, 'd', '', 0);";

       $this->execute($sSql);

    }
}
