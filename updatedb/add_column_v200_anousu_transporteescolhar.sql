begin;
--Cria campo na tabela
alter table transporteescolar add column v200_anousu integer ;
--Cadastra no discionario
create temp table w_db_syscampo on commit drop as
select 							2011703 codcam
                               ,'v200_anousu'::character(40) nomecam
                               ,'int4'::character(40) conteudo
                               ,'aaaaaaa'::text descricao
                               ,''::character(100) valorinicial
                               ,'Ano'::character(50) rotulo
                               ,4 tamanho
                               ,'false'::boolean nulo
                               ,'false'::boolean maiusculo
                               ,'false'::boolean autocompl
                               ,1 aceitatipo
                               ,'text'::character(20) tipoobj
                               ,'Ano'::character(40) rotulorel;

insert into db_syscampo select * from w_db_syscampo;

insert into db_sysarqcamp
select 
	(select codarq from db_sysarquivo where nomearq = 'transporteescolar'),
	(select codcam from w_db_syscampo),
	(select max(seqarq)+1 from db_sysarqcamp where codarq in (select codarq from db_sysarquivo where nomearq = 'transporteescolar')) seqarq,
	0;

commit;