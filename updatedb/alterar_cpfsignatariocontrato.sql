begin;
select fc_startsession();
update db_syscampo set rotulo='CPF Resp do Contrato no Orgão' ,descricao='CPF Resp do Contrato no Orgão' ,rotulorel='CPF Resp do Contrato no Orgão' where nomecam = 'si172_cpfsignatariocontratante';
commit;
