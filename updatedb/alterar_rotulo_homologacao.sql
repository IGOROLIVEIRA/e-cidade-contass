begin;
select fc_startsession();
update db_syscampo set descricao = 'Sequencial da Licitação', rotulo  = 'Sequencial da Licitaçao', rotulorel  = 'Sequencial da Licitação' where nomecam = 'l202_licitacao';
commit;
