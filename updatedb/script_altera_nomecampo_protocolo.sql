select fc_startsession();
begin;
update db_syscampo set rotulo = 'Protocolo Geral', rotulorel = 'Protocolo Geral' where codcam = 18208;
update db_syscampo set rotulo = 'Tipo de Processo' where codcam = 2430;
commit;