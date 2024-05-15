select fc_startsession();
begin;
update db_itensmenu set descricao = 'Configuração de Processo Licitatório', help = 'Configuração de Processo Licitatório' where id_item = 4689;
update db_syscampo set rotulo = 'Processo Licitatório', rotulorel = 'Processo Licitatório' where nomecam = 'l20_edital';
commit;