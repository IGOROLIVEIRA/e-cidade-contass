begin;
select fc_startsession();
update db_syscampo set rotulo='CPF do Prefeito' ,descricao='CPF do Prefeito' ,rotulorel='CPF do Prefeito' where nomecam = 'si172_cpfsignatariocontratante';
commit;
