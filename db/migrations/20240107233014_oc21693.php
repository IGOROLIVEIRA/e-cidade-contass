<?php

use Phinx\Migration\AbstractMigration;

class Oc21693 extends AbstractMigration
{
    public function up()
    {
        $sSql = " 
            ALTER TABLE public.mtfis_ldo ADD mtfis_mfrpps int8 NULL;
            
            select
                setval('db_layouttxt_db50_codigo_seq',
                (
                select
                    max(db50_codigo)+ 1
                from
                    db_layouttxt));
            
            select
                setval('db_layoutlinha_db51_codigo_seq',
                (
                select
                    max(db51_codigo)+ 1
                from
                    configuracoes.db_layoutlinha));
            
            select
                setval('db_layoutcampos_db52_codigo_seq',
                (
                select
                    max(db52_codigo)+ 1
                from
                    configuracoes.db_layoutcampos));
            
            insert
                into
                configuracoes.db_layouttxt
            values(nextval('db_layouttxt_db50_codigo_seq'),
                                    'SICOM IP MTFIS 2024',
                                    0,
                                    'Detalhamento das Metas Fiscais - 2024',
                                    3);
            
            insert
                into
                configuracoes.db_layoutlinha
            values(nextval('db_layoutlinha_db51_codigo_seq'),
            
                                    (
            select
                db50_codigo
            from
                configuracoes.db_layouttxt
            where
                db50_descr = 'SICOM IP MTFIS 2024'),
            
                                    'DETALHAMENTO DAS METAS FISCAIS - IP 2024',
                                    3,
                                    354,
                                    0,
                                    0,
                                    '',
                                    ';',
                                    false);
            
            insert
                into
                configuracoes.db_layoutcampos
            values(nextval('db_layoutcampos_db52_codigo_seq'),
            
                            (
            select
                db51_codigo
            from
                configuracoes.db_layoutlinha
            where
                db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2024'),
            
                            'exercicio',
            'EXERCICIO DA META FISCAL',
            14,
            1,
            '',
            4,
            false,
            true,
            'd',
            '',
            0);
            
            insert
                into
                configuracoes.db_layoutcampos
            values(nextval('db_layoutcampos_db52_codigo_seq'),
            
                            (
            select
                db51_codigo
            from
                configuracoes.db_layoutlinha
            where
                db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2024'),
            
                            'vlMetasFiscaisRPPS',
            'Metas Fiscais RPPS',
            14,
            5,
            '',
            2,
            false,
            true,
            'd',
            '',
            0);
            
            insert
                into
                configuracoes.db_layoutcampos
            values(nextval('db_layoutcampos_db52_codigo_seq'),
            
                            (
            select
                db51_codigo
            from
                configuracoes.db_layoutlinha
            where
                db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2024'),
            
                            'vlCorrenteReceitaTotal',
            'VALOR CORRENTE DA RECEITA TOTAL',
            14,
            7,
            '',
            14,
            false,
            true,
            'd',
            '',
            0);
            
            insert
                into
                configuracoes.db_layoutcampos
            values(nextval('db_layoutcampos_db52_codigo_seq'),
            
                            (
            select
                db51_codigo
            from
                configuracoes.db_layoutlinha
            where
                db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2024'),
            
                            'vlCorrenteRecImpTaxContrMelh',
            'Valor Corrente das Receitas I',
            14,
            21,
            '',
            14,
            false,
            true,
            'd',
            '',
            0);
            
            insert
                into
                configuracoes.db_layoutcampos
            values(nextval('db_layoutcampos_db52_codigo_seq'),
            
                            (
            select
                db51_codigo
            from
                configuracoes.db_layoutlinha
            where
                db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2024'),
            
                            'vlCorrenteRecTransfCorr',
            'Valor Corrente das Receitas de T',
            14,
            49,
            '',
            14,
            false,
            true,
            'd',
            '',
            0);
            
            insert
                into
                configuracoes.db_layoutcampos
            values(nextval('db_layoutcampos_db52_codigo_seq'),
            
                            (
            select
                db51_codigo
            from
                configuracoes.db_layoutlinha
            where
                db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2024'),
            
                            'vlCorrenteDemaisRecPrimCorr',
            'Valor Corrente das Demais R',
            14,
            63,
            '',
            14,
            false,
            true,
            'd',
            '',
            0);
            
            insert
                into
                configuracoes.db_layoutcampos
            values(nextval('db_layoutcampos_db52_codigo_seq'),
            
                            (
            select
                db51_codigo
            from
                configuracoes.db_layoutlinha
            where
                db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2024'),
            
                            'vlCorrenteRecPrimCap',
            'Valor Corrente das Receitas P C',
            14,
            77,
            '',
            14,
            false,
            true,
            'd',
            '',
            0);
            
            insert
                into
                configuracoes.db_layoutcampos
            values(nextval('db_layoutcampos_db52_codigo_seq'),
            
                            (
            select
                db51_codigo
            from
                configuracoes.db_layoutlinha
            where
                db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2024'),
            
                            'vlCorrenteDespesaTotal',
            'Valor Corrente da D T',
            14,
            91,
            '',
            14,
            false,
            true,
            'd',
            '',
            0);
            
            insert
                into
                configuracoes.db_layoutcampos
            values(nextval('db_layoutcampos_db52_codigo_seq'),
            
                            (
            select
                db51_codigo
            from
                configuracoes.db_layoutlinha
            where
                db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2024'),
            
                            'vlCorrenteDespPessEncSoc',
            'Valor Corrente das Despesas P E S',
            14,
            105,
            '',
            14,
            false,
            true,
            'd',
            '',
            0);
            
            insert
                into
                configuracoes.db_layoutcampos
            values(nextval('db_layoutcampos_db52_codigo_seq'),
            
                            (
            select
                db51_codigo
            from
                configuracoes.db_layoutlinha
            where
                db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2024'),
            
                            'vlCorrenteOutrasDespCorr',
            'Valor Corrente das Outras D C',
            14,
            119,
            '',
            14,
            false,
            true,
            'd',
            '',
            0);
            
            insert
                into
                configuracoes.db_layoutcampos
            values(nextval('db_layoutcampos_db52_codigo_seq'),
            
                            (
            select
                db51_codigo
            from
                configuracoes.db_layoutlinha
            where
                db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2024'),
            
                            'vlCorrenteDespPrimCap',
            'Valor Corrente das  Despesas P C',
            14,
            133,
            '',
            14,
            false,
            true,
            'd',
            '',
            0);
            
            insert
                into
                configuracoes.db_layoutcampos
            values(nextval('db_layoutcampos_db52_codigo_seq'),
            
                            (
            select
                db51_codigo
            from
                configuracoes.db_layoutlinha
            where
                db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2024'),
            
                            'vlCorrentePagRPDespPrim',
            'Valor Corrente dos Pagamento',
            14,
            147,
            '',
            14,
            false,
            true,
            'd',
            '',
            0);
            
            insert
                into
                configuracoes.db_layoutcampos
            values(nextval('db_layoutcampos_db52_codigo_seq'),
            
                            (
            select
                db51_codigo
            from
                configuracoes.db_layoutlinha
            where
                db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2024'),
            
                            'vlCorrenteDividaPublicaConsolidada',
            'Valor Corrente da D P C',
            14,
            179,
            '',
            14,
            false,
            true,
            'd',
            '',
            0);
            
            insert
                into
                configuracoes.db_layoutcampos
            values(nextval('db_layoutcampos_db52_codigo_seq'),
            
                            (
            select
                db51_codigo
            from
                configuracoes.db_layoutlinha
            where
                db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2024'),
            
                            'vlCorrenteDividaConsolidadaLiquida',
            'Valor Corrente da D C L',
            14,
            193,
            '',
            7,
            false,
            true,
            'd',
            '',
            0);
            
            insert
                into
                configuracoes.db_layoutcampos
            values(nextval('db_layoutcampos_db52_codigo_seq'),
            
                            (
            select
                db51_codigo
            from
                configuracoes.db_layoutlinha
            where
                db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2024'),
            
                            'vlConstanteReceitaTotal',
            'Valor Constante da Receita Total',
            14,
            207,
            '',
            7,
            false,
            true,
            'd',
            '',
            0);
            
            insert
                into
                configuracoes.db_layoutcampos
            values(nextval('db_layoutcampos_db52_codigo_seq'),
            
                            (
            select
                db51_codigo
            from
                configuracoes.db_layoutlinha
            where
                db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2024'),
            
                            'vlConstanteRecImpTaxContrMelh',
            'Valor Constante das R I',
            14,
            221,
            '',
            7,
            false,
            true,
            'd',
            '',
            0);
            
            insert
                into
                configuracoes.db_layoutcampos
            values(nextval('db_layoutcampos_db52_codigo_seq'),
            
                            (
            select
                db51_codigo
            from
                configuracoes.db_layoutlinha
            where
                db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2024'),
            
                            'vlConstanteRecTransfCorr',
            'Valor Constante das R T',
            14,
            249,
            '',
            7,
            false,
            true,
            'd',
            '',
            0);
            
            insert
                into
                configuracoes.db_layoutcampos
            values(nextval('db_layoutcampos_db52_codigo_seq'),
            
                            (
            select
                db51_codigo
            from
                configuracoes.db_layoutlinha
            where
                db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2024'),
            
                            'vlConstanteDemaisRecPrimCorr',
            'Valor Constante D R',
            14,
            263,
            '',
            7,
            false,
            true,
            'd',
            '',
            0);
            
            insert
                into
                configuracoes.db_layoutcampos
            values(nextval('db_layoutcampos_db52_codigo_seq'),
            
                            (
            select
                db51_codigo
            from
                configuracoes.db_layoutlinha
            where
                db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2024'),
            
                            'vlConstanteRecPrimCap',
            'Valor Constante das R P',
            14,
            277,
            '',
            7,
            false,
            true,
            'd',
            '',
            0);
            
            insert
                into
                configuracoes.db_layoutcampos
            values(nextval('db_layoutcampos_db52_codigo_seq'),
            
                            (
            select
                db51_codigo
            from
                configuracoes.db_layoutlinha
            where
                db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2024'),
            
                            'vlConstanteDespesaTotal',
            'Valor Corrente da Despesa Total',
            14,
            291,
            '',
            14,
            false,
            true,
            'd',
            '',
            0);
            
            insert
                into
                configuracoes.db_layoutcampos
            values(nextval('db_layoutcampos_db52_codigo_seq'),
            
                            (
            select
                db51_codigo
            from
                configuracoes.db_layoutlinha
            where
                db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2024'),
            
                            'vlConstanteDespPessEncSoc',
            'Valor Constante das Despesas',
            14,
            305,
            '',
            14,
            false,
            true,
            'd',
            '',
            0);
            
            insert
                into
                configuracoes.db_layoutcampos
            values(nextval('db_layoutcampos_db52_codigo_seq'),
            
                            (
            select
                db51_codigo
            from
                configuracoes.db_layoutlinha
            where
                db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2024'),
            
                            'vlConstanteOutrasDespCorr',
            'Valor Constante das O D C',
            14,
            319,
            '',
            7,
            false,
            true,
            'd',
            '',
            0);
            
            insert
                into
                configuracoes.db_layoutcampos
            values(nextval('db_layoutcampos_db52_codigo_seq'),
            
                            (
            select
                db51_codigo
            from
                configuracoes.db_layoutlinha
            where
                db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2024'),
            
                            'vlConstanteDespPrimCap',
            'Valor Constante das  Despesas P C',
            14,
            333,
            '',
            14,
            false,
            true,
            'd',
            '',
            0);
            
            insert
                into
                configuracoes.db_layoutcampos
            values(nextval('db_layoutcampos_db52_codigo_seq'),
            
                            (
            select
                db51_codigo
            from
                configuracoes.db_layoutlinha
            where
                db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2024'),
            
                            'vlConstantePagRPDespPrim',
            'Valor Constante dos P Restos',
            14,
            347,
            '',
            14,
            false,
            true,
            'd',
            '',
            0);
            
            insert
                into
                configuracoes.db_layoutcampos
            values(nextval('db_layoutcampos_db52_codigo_seq'),
            
                            (
            select
                db51_codigo
            from
                configuracoes.db_layoutlinha
            where
                db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2024'),
            
                            'vlConstanteDividaPublicaConsolidada',
            'Valor Constante D P',
            14,
            389,
            '',
            7,
            false,
            true,
            'd',
            '',
            0);
            
            insert
                into
                configuracoes.db_layoutcampos
            values(nextval('db_layoutcampos_db52_codigo_seq'),
            
                            (
            select
                db51_codigo
            from
                configuracoes.db_layoutlinha
            where
                db51_descr = 'DETALHAMENTO DAS METAS FISCAIS - IP 2024'),
            
                            'vlConstanteDividaConsolidadaLiquida',
            'Valor Constante da D L',
            14,
            403,
            '',
            7,
            false,
            true,
            'd',
            '',
            0);
   ";
        $this->execute($sSql);
    }
}
