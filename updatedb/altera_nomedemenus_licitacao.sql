BEGIN;
SELECT fc_startsession();
UPDATE db_itensmenu set descricao = 'Responsáveis pela licitação' where id_item = 4796;
UPDATE db_itensmenu set descricao = 'Comissão de licitação' where id_item = 3000045;

UPDATE db_syscampo set descricao = 'Comissão de licitação', rotulo = 'Comissão de licitação', rotulorel = 'Comissão de licitação'  where codcam = 2009525;
UPDATE db_syscampo set rotulo = 'Responsáveis pela licitação', rotulorel = 'Responsáveis pela licitação'  where codcam = 7909;
COMMIT;