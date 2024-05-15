-- Ocorrência 4607

BEGIN;

select fc_startsession();

select nextval('db_layoutlinha_db51_codigo_seq');
insert into db_layoutlinha( db51_codigo ,db51_layouttxt ,db51_descr ,db51_tipolinha ,db51_tamlinha ,db51_linhasantes ,db51_linhasdepois ,db51_obs ,db51_separador ,db51_compacta ) values ( 592 ,198 ,'INFPA' ,3 ,87 ,0 ,0 ,'' ,'|' ,'0' );
update db_layoutlinha set db51_codigo = 592 , db51_layouttxt = 198 , db51_descr = 'INFPA' , db51_tipolinha = 3 , db51_tamlinha = 87 , db51_linhasantes = 0 , db51_linhasdepois = 0 , db51_obs = '' , db51_separador = '|' , db51_compacta = '1' where db51_codigo = 592;

select nextval('db_layoutcampos_db52_codigo_seq');
insert into db_layoutcampos( db52_codigo ,db52_layoutlinha ,db52_nome ,db52_descr ,db52_layoutformat ,db52_posicao ,db52_default ,db52_tamanho ,db52_ident ,db52_imprimir ,db52_alinha ,db52_obs ,db52_quebraapos ) values ( 1010747 ,592 ,'identificador_registro' ,'IDENTIFICADOR_REGISTRO' ,1 ,1 ,'' ,5 ,'t' ,'t' ,'d' ,'' ,0 );
select nextval('db_layoutcampos_db52_codigo_seq');
insert into db_layoutcampos( db52_codigo ,db52_layoutlinha ,db52_nome ,db52_descr ,db52_layoutformat ,db52_posicao ,db52_default ,db52_tamanho ,db52_ident ,db52_imprimir ,db52_alinha ,db52_obs ,db52_quebraapos ) values ( 1010748 ,592 ,'cpf' ,'CPF' ,1 ,6 ,'' ,11 ,'f' ,'t' ,'d' ,'' ,0 );
select nextval('db_layoutcampos_db52_codigo_seq');
insert into db_layoutcampos( db52_codigo ,db52_layoutlinha ,db52_nome ,db52_descr ,db52_layoutformat ,db52_posicao ,db52_default ,db52_tamanho ,db52_ident ,db52_imprimir ,db52_alinha ,db52_obs ,db52_quebraapos ) values ( 1010749 ,592 ,'dtnasc' ,'DTNASC' ,4 ,6 ,'' ,8 ,'f' ,'t' ,'e' ,'' ,0 );
select nextval('db_layoutcampos_db52_codigo_seq');
insert into db_layoutcampos( db52_codigo ,db52_layoutlinha ,db52_nome ,db52_descr ,db52_layoutformat ,db52_posicao ,db52_default ,db52_tamanho ,db52_ident ,db52_imprimir ,db52_alinha ,db52_obs ,db52_quebraapos ) values ( 1010750 ,592 ,'tipo' ,'TIPO' ,2 ,14 ,'' ,2 ,'f' ,'t' ,'e' ,'' ,0 );
select nextval('db_layoutcampos_db52_codigo_seq');
insert into db_layoutcampos( db52_codigo ,db52_layoutlinha ,db52_nome ,db52_descr ,db52_layoutformat ,db52_posicao ,db52_default ,db52_tamanho ,db52_ident ,db52_imprimir ,db52_alinha ,db52_obs ,db52_quebraapos ) values ( 1010752 ,592 ,'nome' ,'NOME' ,1 ,7 ,'' ,60 ,'f' ,'t' ,'d' ,'' ,0 );
insert into db_layoutcampos( db52_codigo ,db52_layoutlinha ,db52_nome ,db52_descr ,db52_layoutformat ,db52_posicao ,db52_default ,db52_tamanho ,db52_ident ,db52_imprimir ,db52_alinha ,db52_obs ,db52_quebraapos ) values ( 1010753 ,592 ,'pipe' ,'PIPE' ,13 ,77 ,'' ,1 ,'f' ,'t' ,'d' ,'' ,0 );

update db_layoutcampos set db52_codigo = 1010747 , db52_layoutlinha = 592 , db52_nome = 'identificador_registro' , db52_descr = 'IDENTIFICADOR_REGISTRO' , db52_layoutformat = 1 , db52_posicao = 1 , db52_default = 'INFPA' , db52_tamanho = 5 , db52_ident = 't' , db52_imprimir = 't' , db52_alinha = 'd' , db52_obs = '' , db52_quebraapos = 0 where db52_codigo = 1010747;
update db_layoutcampos set db52_codigo = 1010748 , db52_layoutlinha = 592 , db52_nome = 'cpf' , db52_descr = 'CPF' , db52_layoutformat = 1 , db52_posicao = 6 , db52_default = '' , db52_tamanho = 11 , db52_ident = 'f' , db52_imprimir = 't' , db52_alinha = 'd' , db52_obs = '' , db52_quebraapos = 0 where db52_codigo = 1010748;
update db_layoutcampos set db52_codigo = 1010749 , db52_layoutlinha = 592 , db52_nome = 'dtnasc' , db52_descr = 'DTNASC' , db52_layoutformat = 10 , db52_posicao = 17 , db52_default = '' , db52_tamanho = 8 , db52_ident = 'f' , db52_imprimir = 't' , db52_alinha = 'd' , db52_obs = '' , db52_quebraapos = 0 where db52_codigo = 1010749;
update db_layoutcampos set db52_codigo = 1010752 , db52_layoutlinha = 592 , db52_nome = 'nome' , db52_descr = 'NOME' , db52_layoutformat = 1 , db52_posicao = 25 , db52_default = '' , db52_tamanho = 60 , db52_ident = 'f' , db52_imprimir = 't' , db52_alinha = 'd' , db52_obs = '' , db52_quebraapos = 0 where db52_codigo = 1010752;
update db_layoutcampos set db52_codigo = 1010750 , db52_layoutlinha = 592 , db52_nome = 'tipo' , db52_descr = 'TIPO' , db52_layoutformat = 15 , db52_posicao = 85 , db52_default = '' , db52_tamanho = 2 , db52_ident = 'f' , db52_imprimir = 't' , db52_alinha = 'd' , db52_obs = '' , db52_quebraapos = 0 where db52_codigo = 1010750;
update db_layoutcampos set db52_codigo = 1010753 , db52_layoutlinha = 592 , db52_nome = 'pipe' , db52_descr = 'PIPE' , db52_layoutformat = 13 , db52_posicao = 87 , db52_default = '' , db52_tamanho = 1 , db52_ident = 'f' , db52_imprimir = 't' , db52_alinha = 'd' , db52_obs = '' , db52_quebraapos = 0 where db52_codigo = 1010753;

COMMIT;