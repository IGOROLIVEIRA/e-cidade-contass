begin;
select fc_startsession();
update db_syscampo set tamanho = 250 where nomecam in ('v200_escola','v200_localidade');
update db_syscampo set descricao = 'Nome do Estabelecimento de ensino - Deverá ser informado o nome da escola e o campo deverá estar ajustado para tamanho de 250 caracteres.' where nomecam in ('v200_escola');
update db_itensmenu set descricao = 'Transporte Escolar (Ed. Basica)', help = 'Transporte Escolar (Ed. Basica)' where id_item =  3000021;
commit;
