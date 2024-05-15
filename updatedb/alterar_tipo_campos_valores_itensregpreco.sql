begin;
select fc_startsession();
alter table itensregpreco alter column  si07_precounitario type double precision;
alter table itensregpreco alter column  si07_quantidadeaderida type double precision;
alter table itensregpreco alter column  si07_quantidadelicitada type double precision;

update db_syscampo set conteudo='float8',tamanho=15,aceitatipo=4 where nomecam in ('si07_precounitario','si07_quantidadelicitada','si07_quantidadeaderida');
commit;
