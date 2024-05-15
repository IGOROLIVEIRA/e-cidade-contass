<?php

use Phinx\Migration\AbstractMigration;

class Oc13846 extends AbstractMigration
{
    public function up()
    {
        $sql = <<<SQL
        ALTER TABLE public.mtfis_ldo ALTER COLUMN mtfis_pibano1 TYPE double precision USING mtfis_pibano1::double precision;
ALTER TABLE public.mtfis_ldo ALTER COLUMN mtfis_pibano2 TYPE double precision USING mtfis_pibano2::double precision;
ALTER TABLE public.mtfis_ldo ALTER COLUMN mtfis_pibano3 TYPE double precision USING mtfis_pibano3::double precision;
ALTER TABLE public.mtfis_ldo ALTER COLUMN mtfis_rclano1 TYPE double precision USING mtfis_rclano1::double precision;
ALTER TABLE public.mtfis_ldo ALTER COLUMN mtfis_rclano2 TYPE double precision USING mtfis_rclano2::double precision;
ALTER TABLE public.mtfis_ldo ALTER COLUMN mtfis_rclano3 TYPE double precision USING mtfis_rclano3::double precision;

ALTER TABLE public.mtfis_anexo ALTER COLUMN mtfisanexo_valorcorrente1 TYPE double precision USING mtfisanexo_valorcorrente1::double precision;
ALTER TABLE public.mtfis_anexo ALTER COLUMN mtfisanexo_valorcorrente2 TYPE double precision USING mtfisanexo_valorcorrente2::double precision;
ALTER TABLE public.mtfis_anexo ALTER COLUMN mtfisanexo_valorcorrente3 TYPE double precision USING mtfisanexo_valorcorrente3::double precision;
ALTER TABLE public.mtfis_anexo ALTER COLUMN mtfisanexo_valorconstante1 TYPE double precision USING mtfisanexo_valorconstante1::double precision;
ALTER TABLE public.mtfis_anexo ALTER COLUMN mtfisanexo_valorconstante2 TYPE double precision USING mtfisanexo_valorconstante2::double precision;
ALTER TABLE public.mtfis_anexo ALTER COLUMN mtfisanexo_valorconstante3 TYPE double precision USING mtfisanexo_valorconstante3::double precision;

INSERT INTO configuracoes.db_layouttxt
(db50_codigo, db50_descr, db50_quantlinhas, db50_obs, db50_layouttxtgrupo)
VALUES(100222, 'SICOM IP MTFIS 2021', 0, 'Detalhamento das Metas Fiscais', 3);

INSERT INTO configuracoes.db_layoutlinha
(db51_codigo, db51_layouttxt, db51_descr, db51_tipolinha, db51_tamlinha, db51_linhasantes, db51_linhasdepois, db51_obs, db51_separador, db51_compacta)
VALUES(100707, 100222, 'DETALHAMENTO DAS METAS FISCAIS', 3, 354, 0, 0, '', ';', false);

INSERT INTO configuracoes.db_layoutcampos
(db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos)
VALUES(1010878, 100707, 'exercicio', 'EXERCICIO DA META FISCAL', 14, 1, '', 4, false, true, 'd', '', 0);
INSERT INTO configuracoes.db_layoutcampos
(db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos)
VALUES(1010879, 100707, 'vlCorrenteReceitaTotal', 'VALOR CORRENTE DA RECEITA TOTAL', 14, 5, '', 14, false, true, 'd', '', 0);
INSERT INTO configuracoes.db_layoutcampos
(db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos)
VALUES(1010880, 100707, 'vlCorrenteRecImpTaxContrMelh', 'Valor Corrente das Receitas I', 14, 19, '', 14, false, true, 'd', '', 0);
INSERT INTO configuracoes.db_layoutcampos
(db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos)
VALUES(1010881, 100707, 'vlCorrenteRecContribuicoes', 'Valor Corrente das Receitas C', 14, 33, '', 14, false, true, 'd', '', 0);
INSERT INTO configuracoes.db_layoutcampos
(db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos)
VALUES(1010882, 100707, 'vlCorrenteRecTransfCorr', 'Valor Corrente das Receitas de T', 14, 47, '', 14, false, true, 'd', '', 0);
INSERT INTO configuracoes.db_layoutcampos
(db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos)
VALUES(1010883, 100707, 'vlCorrenteDemaisRecPrimCorr', 'Valor Corrente das Demais R', 14, 61, '', 14, false, true, 'd', '', 0);
INSERT INTO configuracoes.db_layoutcampos
(db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos)
VALUES(1010884, 100707, 'vlCorrenteRecPrimCap', 'Valor Corrente das Receitas P C', 14, 75, '', 14, false, true, 'd', '', 0);
INSERT INTO configuracoes.db_layoutcampos
(db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos)
VALUES(1010885, 100707, 'vlCorrenteDespesaTotal', 'Valor Corrente da D T', 14, 89, '', 14, false, true, 'd', '', 0);
INSERT INTO configuracoes.db_layoutcampos
(db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos)
VALUES(1010886, 100707, 'vlCorrenteDespPessEncSoc', 'Valor Corrente das Despesas P E S', 14, 103, '', 14, false, true, 'd', '', 0);
INSERT INTO configuracoes.db_layoutcampos
(db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos)
VALUES(1010887, 100707, 'vlCorrenteOutrasDespCorr', 'Valor Corrente das Outras D C', 14, 117, '', 14, false, true, 'd', '', 0);
INSERT INTO configuracoes.db_layoutcampos
(db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos)
VALUES(1010888, 100707, 'vlCorrenteDespPrimCap', 'Valor Corrente das  Despesas P C', 14, 131, '', 14, false, true, 'd', '', 0);
INSERT INTO configuracoes.db_layoutcampos
(db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos)
VALUES(1010889, 100707, 'vlCorrentePagRPDespPrim', 'Valor Corrente dos Pagamento', 14, 145, '', 14, false, true, 'd', '', 0);
INSERT INTO configuracoes.db_layoutcampos
(db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos)
VALUES(1010890, 100707, 'vlCorrenteJurEncVarMonAtiv', 'Valor Corrente dos Juros', 14, 159, '', 14, false, true, 'd', '', 0);
INSERT INTO configuracoes.db_layoutcampos
(db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos)
VALUES(1010891, 100707, 'vlCorrenteJurEncVarMonPass', 'Valor Corrente dos Juros', 14, 163, '', 14, false, true, 'd', '', 0);
INSERT INTO configuracoes.db_layoutcampos
(db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos)
VALUES(1010892, 100707, 'vlCorrenteDividaPublicaConsolidada', 'Valor Corrente da D P C', 14, 177, '', 14, false, true, 'd', '', 0);
INSERT INTO configuracoes.db_layoutcampos
(db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos)
VALUES(1010893, 100707, 'vlCorrenteDividaConsolidadaLiquida', 'Valor Corrente da D C L', 14, 191, '', 7, false, true, 'd', '', 0);
INSERT INTO configuracoes.db_layoutcampos
(db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos)
VALUES(1010894, 100707, 'vlConstanteReceitaTotal', 'Valor Constante da Receita Total', 14, 205, '', 7, false, true, 'd', '', 0);
INSERT INTO configuracoes.db_layoutcampos
(db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos)
VALUES(1010895, 100707, 'vlConstanteRecImpTaxContrMelh', 'Valor Constante das R I', 14, 219, '', 7, false, true, 'd', '', 0);
INSERT INTO configuracoes.db_layoutcampos
(db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos)
VALUES(1010896, 100707, 'vlConstanteRecContribuicoes', 'Valor Constante das R C', 14, 233, '', 7, false, true, 'd', '', 0);
INSERT INTO configuracoes.db_layoutcampos
(db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos)
VALUES(1010897, 100707, 'vlConstanteRecTransfCorr', 'Valor Constante das R T', 14, 247, '', 7, false, true, 'd', '', 0);
INSERT INTO configuracoes.db_layoutcampos
(db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos)
VALUES(1010898, 100707, 'vlConstanteDemaisRecPrimCorr', 'Valor Constante D R', 14, 261, '', 7, false, true, 'd', '', 0);
INSERT INTO configuracoes.db_layoutcampos
(db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos)
VALUES(1010899, 100707, 'vlConstanteRecPrimCap', 'Valor Constante das R P', 14, 275, '', 7, false, true, 'd', '', 0);
INSERT INTO configuracoes.db_layoutcampos
(db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos)
VALUES(1010900, 100707, 'vlConstanteDespesaTotal', 'Valor Corrente da Despesa Total', 14, 289, '', 14, false, true, 'd', '', 0);
INSERT INTO configuracoes.db_layoutcampos
(db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos)
VALUES(1010901, 100707, 'vlConstanteDespPessEncSoc', 'Valor Constante das Despesas', 14, 303, '', 14, false, true, 'd', '', 0);
INSERT INTO configuracoes.db_layoutcampos
(db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos)
VALUES(1010902, 100707, 'vlConstanteOutrasDespCorr', 'Valor Constante das O D C', 14, 317, '', 7, false, true, 'd', '', 0);
INSERT INTO configuracoes.db_layoutcampos
(db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos)
VALUES(1010903, 100707, 'vlConstanteDespPrimCap', 'Valor Constante das  Despesas P C', 14, 331, '', 14, false, true, 'd', '', 0);
INSERT INTO configuracoes.db_layoutcampos
(db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos)
VALUES(1010904, 100707, 'vlConstantePagRPDespPrim', 'Valor Constante dos P Restos', 14, 345, '', 14, false, true, 'd', '', 0);
INSERT INTO configuracoes.db_layoutcampos
(db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos)
VALUES(1010905, 100707, 'vlConstanteJurEncVarMonAtiv', 'Valor Constante dos Juros E', 14, 359, '', 14, false, true, 'd', '', 0);
INSERT INTO configuracoes.db_layoutcampos
(db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos)
VALUES(1010906, 100707, 'vlConstanteJurEncVarMonPass', 'Valor Constante dos Juros E V', 14, 373, '', 14, false, true, 'd', '', 0);
INSERT INTO configuracoes.db_layoutcampos
(db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos)
VALUES(1010907, 100707, 'vlConstanteDividaPublicaConsolidada', 'Valor Constante D P', 14, 387, '', 7, false, true, 'd', '', 0);
INSERT INTO configuracoes.db_layoutcampos
(db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos)
VALUES(1010908, 100707, 'vlConstanteDividaConsolidadaLiquida', 'Valor Constante da D L', 14, 401, '', 7, false, true, 'd', '', 0);
INSERT INTO configuracoes.db_layoutcampos
(db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos)
VALUES(1010909, 100707, 'vlCorrenteRecPrimariasAdv', 'Valor corrente da Receita', 14, 415, '', 7, false, true, 'd', '', 0);
INSERT INTO configuracoes.db_layoutcampos
(db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos)
VALUES(1010910, 100707, 'vlConstanteRecPrimariasAdv', 'Valor constante da Receita p a PPP', 14, 429, '', 7, false, true, 'd', '', 0);
INSERT INTO configuracoes.db_layoutcampos
(db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos)
VALUES(1010911, 100707, 'vlCorrenteDspPrimariasGeradas', 'Valor corrente da D p g PPP', 14, 443, '', 7, false, true, 'd', '', 0);
INSERT INTO configuracoes.db_layoutcampos
(db52_codigo, db52_layoutlinha, db52_nome, db52_descr, db52_layoutformat, db52_posicao, db52_default, db52_tamanho, db52_ident, db52_imprimir, db52_alinha, db52_obs, db52_quebraapos)
VALUES(1010912, 100707, 'vlConstanteDspPrimariasGeradas', 'Valor constante da D p g PPP', 14, 457, '', 7, false, true, 'd', '', 0);


SQL;
        $this->execute($sql);
    }
}
