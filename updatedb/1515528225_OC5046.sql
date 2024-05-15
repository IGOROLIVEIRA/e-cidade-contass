
-- Ocorrência 5046
BEGIN;                   
SELECT fc_startsession();

--delete from db_layoutcampos where db52_codigo = 1010757 and db52_layoutlinha = 634;
--delete from db_layoutcampos where db52_codigo = 1010756 and db52_layoutlinha = 636;
delete from db_layoutcampos where db52_codigo = 9548 and db52_layoutlinha = 636;
--delete from db_layoutcampos where db52_codigo = 1010755 and db52_layoutlinha = 636;


UPDATE db_layoutcampos
SET db52_codigo = 9592,
    db52_layoutlinha = 634,
    db52_nome = 'data_evento',
    db52_descr = 'DATA DE EVENTO',
    db52_layoutformat = 1,
    db52_posicao = 189,
    db52_default = 'N',
    db52_tamanho = 8,
    db52_ident = 'f',
    db52_imprimir = 't',
    db52_alinha = 'd',
    db52_obs = '',
    db52_quebraapos = 0
WHERE db52_codigo = 9592;

INSERT INTO db_layoutcampos(db52_codigo,db52_layoutlinha,db52_nome,db52_descr,db52_layoutformat,db52_posicao,db52_default,db52_tamanho,db52_ident,db52_imprimir,db52_alinha,db52_obs,db52_quebraapos)
VALUES (1010757,
        634,
        'Pipe',
        'PIPE',
        13,
        198,
        '',
        1,
        'f',
        't',
        'd',
        '',
        0);

INSERT INTO db_layoutcampos(db52_codigo,db52_layoutlinha,db52_nome,db52_descr,db52_layoutformat,db52_posicao,db52_default,db52_tamanho,db52_ident,db52_imprimir,db52_alinha,db52_obs,db52_quebraapos)
VALUES (1010756,
        636,
        'branco',
        'BRANCO',
        1,
        78,
        '',
        0,
        'f',
        't',
        'd',
        '',
        0);

INSERT INTO db_layoutcampos(db52_codigo,db52_layoutlinha,db52_nome,db52_descr,db52_layoutformat,db52_posicao,db52_default,db52_tamanho,db52_ident,db52_imprimir,db52_alinha,db52_obs,db52_quebraapos)
VALUES (9548,
        636,
        'pensao',
        'PENSAO',
        1,
        79,
        'S',
        1,
        'f',
        't',
        'd',
        '',
        0);

INSERT INTO db_layoutcampos(db52_codigo,db52_layoutlinha,db52_nome,db52_descr,db52_layoutformat,db52_posicao,db52_default,db52_tamanho,db52_ident,db52_imprimir,db52_alinha,db52_obs,db52_quebraapos)
VALUES (1010755,
        636,
        'previdencia',
        'PREVIDENCIA',
        1,
        80,
        'N',
        1,
        'f',
        't',
        'd',
        '',
        0);



UPDATE db_layoutcampos
    set db52_posicao = 81
WHERE db52_codigo = 9576 and db52_layoutlinha = 636;


COMMIT;

