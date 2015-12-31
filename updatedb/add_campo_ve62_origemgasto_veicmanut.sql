begin;
--Cria campo na tabela
alter table veicmanut add column ve62_origemgasto integer ;
--Cadastra no discionario
create temp table w_db_syscampo on commit drop as
select 							 (select max(codcam)+1 from db_syscampo) as codcam
                               ,'ve62_origemgasto'::character(40) nomecam
                               ,'int4'::character(40) conteudo
                               ,'Origem do Gasto'::text descricao
                               ,''::character(100) valorinicial
                               ,'Origem do Gasto'::character(50) rotulo
                               ,4 tamanho
                               ,'false'::boolean nulo
                               ,'false'::boolean maiusculo
                               ,'false'::boolean autocompl
                               ,1 aceitatipo
                               ,'text'::character(20) tipoobj
                               ,'Origem do Gasto'::character(40) rotulorel;

insert into db_syscampo select * from w_db_syscampo;

insert into db_sysarqcamp
select
	(select codarq from db_sysarquivo where nomearq = 'veicmanut'),
	(select codcam from w_db_syscampo),
	(select max(seqarq)+1 from db_sysarqcamp where codarq in (select codarq from db_sysarquivo where nomearq = 'veicmanut')) seqarq,
	0;

commit;