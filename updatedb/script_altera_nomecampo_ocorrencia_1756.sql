select fc_startsession();
begin;
update db_syscampo set rotulo = 'Protocolo Geral', rotulorel = 'Protocolo Geral' where nomecam = 'p63_codproc';
commit;