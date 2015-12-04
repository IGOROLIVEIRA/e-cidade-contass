BEGIN;
select fc_startsession();
update db_itensmenu set descricao = 'Manutenção Estrutural PCASP', help = 'Manutenção Estrutural PCASP', desctec = 'Manutenção Estrutural PCASP'  where id_item = 9994;
COMMIT;