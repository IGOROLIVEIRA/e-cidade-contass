select fc_startsession();
begin;
begin; update db_syscampo set conteudo = 'float8', aceitatipo = 4 where nomecam = 'ac20_quantidade';
commit;
