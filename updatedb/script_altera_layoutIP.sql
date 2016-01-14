BEGIN;

SELECT fc_startsession();

/**
Inserindo e atualizando campos no layout MTFIS
 */

UPDATE db_layoutlinha set db51_tamlinha = 356 where db51_codigo = 432;

INSERT INTO db_layoutcampos (db52_codigo,db52_layoutlinha,db52_nome,db52_descr,db52_layoutformat,db52_posicao,db52_default,db52_tamanho,db52_ident,db52_imprimir,db52_alinha,db52_obs,db52_quebraapos)
      VALUES (1010708,432,'tipoRegistro','Tipo de registro',14,1,'',2,'f','t','d','',0);

INSERT INTO db_layoutcampos (db52_codigo,db52_layoutlinha,db52_nome,db52_descr,db52_layoutformat,db52_posicao,db52_default,db52_tamanho,db52_ident,db52_imprimir,db52_alinha,db52_obs,db52_quebraapos)
      VALUES (1010709,432,'vlCorrenteRecPrimariasAdv','Valor corrente da Receita',14,279,'',14,'f','t','d','',0);

INSERT INTO db_layoutcampos (db52_codigo,db52_layoutlinha,db52_nome,db52_descr,db52_layoutformat,db52_posicao,db52_default,db52_tamanho,db52_ident,db52_imprimir,db52_alinha,db52_obs,db52_quebraapos)
      VALUES (1010710,432,'vlConstanteRecPrimariasAdv','Valor constante da Receita',14,280,'',14,'f','t','d','',0);

INSERT INTO db_layoutcampos (db52_codigo,db52_layoutlinha,db52_nome,db52_descr,db52_layoutformat,db52_posicao,db52_default,db52_tamanho,db52_ident,db52_imprimir,db52_alinha,db52_obs,db52_quebraapos)
      VALUES (1010711,432,'vlCorrenteDspPrimariasGeradas','Valor corrente da Despesa',14,281,'',14,'f','t','d','',0);

INSERT INTO db_layoutcampos (db52_codigo,db52_layoutlinha,db52_nome,db52_descr,db52_layoutformat,db52_posicao,db52_default,db52_tamanho,db52_ident,db52_imprimir,db52_alinha,db52_obs,db52_quebraapos)
      VALUES (1010712,432,'vlConstanteDspPrimariasGeradas','Valor constante da Despesas',14,282,'',14,'f','t','d','',0);

INSERT INTO db_layoutcampos (db52_codigo,db52_layoutlinha,db52_nome,db52_descr,db52_layoutformat,db52_posicao,db52_default,db52_tamanho,db52_ident,db52_imprimir,db52_alinha,db52_obs,db52_quebraapos)
      VALUES (1010713,432,'pcPIBrecPrimariasAdv','Percentual do PIB das receitas',14,283,'',7,'f','t','d','',0);

INSERT INTO db_layoutcampos (db52_codigo,db52_layoutlinha,db52_nome,db52_descr,db52_layoutformat,db52_posicao,db52_default,db52_tamanho,db52_ident,db52_imprimir,db52_alinha,db52_obs,db52_quebraapos)
      VALUES (1010714,432,'pcPIBDspPrimariasGeradas','Percentual do PIB das despesas',14,283,'',7,'f','t','d','',0);

/**
Inserindo layout CONSID
 */

INSERT INTO db_layouttxt (db50_codigo,db50_descr,db50_quantlinhas,db50_obs,db50_layouttxtgrupo)
  VALUES (100218,'SICOM IP CONSID',0,'Este arquivo destina-se ao registro',3);

  INSERT INTO db_layoutlinha (db51_codigo,db51_layouttxt,db51_descr,db51_tipolinha,db51_tamlinha,db51_linhasantes,db51_linhasdepois,db51_obs,db51_separador,db51_compacta)
    VALUES (100699,100218,'Consideracoes',3,7,0,0,'',';','f');

    INSERT INTO db_layoutcampos (db52_codigo,db52_layoutlinha,db52_nome,db52_descr,db52_layoutformat,db52_posicao,db52_default,db52_tamanho,db52_ident,db52_imprimir,db52_alinha,db52_obs,db52_quebraapos)
      VALUES (1010715,100699,'tipoRegistro','Tipo de registro',14,1,99,2,'f','t','d','',0);





COMMIT;


