begin;

alter table flpgo102013 add column si195_codreduzidopessoa integer default 0;

update pg_attribute set attnum = attnum+1 where attname = 'si195_codreduzidopessoa' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102013');
update pg_attribute set attnum = attnum+1 where attname = 'si195_inst' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102013');
update pg_attribute set attnum = attnum+1 where attname = 'si195_mes' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102013');
update pg_attribute set attnum = attnum+1 where attname = 'si195_vlrabateteto' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102013');
update pg_attribute set attnum = attnum+1 where attname = 'si195_vlrdeducoesobrigatorias' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102013');
update pg_attribute set attnum = attnum+1 where attname = 'si195_vlrremuneracaoliquida' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102013');
update pg_attribute set attnum = attnum+1 where attname = 'si195_natsaldoliquido' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102013');
update pg_attribute set attnum = attnum+1 where attname = 'si195_vlrremuneracaobruta' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102013');
update pg_attribute set attnum = attnum+1 where attname = 'si195_natsaldobruto' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102013');
update pg_attribute set attnum = attnum+1 where attname = 'si195_datexclusao' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102013');
update pg_attribute set attnum = attnum+1 where attname = 'si195_datefetexercicio' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102013');
update pg_attribute set attnum = attnum+1 where attname = 'si195_vlrcargahorariasemanal' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102013');
update pg_attribute set attnum = attnum+1 where attname = 'si195_dsclotacao' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102013');
update pg_attribute set attnum = attnum+1 where attname = 'si195_indcessao' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102013');
update pg_attribute set attnum = attnum+1 where attname = 'si195_reqcargo' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102013');
update pg_attribute set attnum = attnum+1 where attname = 'si195_sglcargo' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102013');
update pg_attribute set attnum = attnum+1 where attname = 'si195_dsccargo' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102013');
update pg_attribute set attnum = attnum+1 where attname = 'si195_datconcessaoaposentadoriapensao' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102013');
update pg_attribute set attnum = attnum+1 where attname = 'si195_indsituacaoservidorpensionista' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102013');
update pg_attribute set attnum = attnum+1 where attname = 'si195_indtipopagamento' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102013');
update pg_attribute set attnum = attnum+1 where attname = 'si195_regime' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102013');

update pg_attribute set attnum = 4 where attname = 'si195_codreduzidopessoa' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102013');




alter table flpgo102014 add column si195_codreduzidopessoa integer default 0;

update pg_attribute set attnum = attnum+1 where attname = 'si195_codreduzidopessoa' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102014');
update pg_attribute set attnum = attnum+1 where attname = 'si195_inst' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102014');
update pg_attribute set attnum = attnum+1 where attname = 'si195_mes' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102014');
update pg_attribute set attnum = attnum+1 where attname = 'si195_vlrabateteto' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102014');
update pg_attribute set attnum = attnum+1 where attname = 'si195_vlrdeducoesobrigatorias' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102014');
update pg_attribute set attnum = attnum+1 where attname = 'si195_vlrremuneracaoliquida' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102014');
update pg_attribute set attnum = attnum+1 where attname = 'si195_natsaldoliquido' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102014');
update pg_attribute set attnum = attnum+1 where attname = 'si195_vlrremuneracaobruta' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102014');
update pg_attribute set attnum = attnum+1 where attname = 'si195_natsaldobruto' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102014');
update pg_attribute set attnum = attnum+1 where attname = 'si195_datexclusao' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102014');
update pg_attribute set attnum = attnum+1 where attname = 'si195_datefetexercicio' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102014');
update pg_attribute set attnum = attnum+1 where attname = 'si195_vlrcargahorariasemanal' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102014');
update pg_attribute set attnum = attnum+1 where attname = 'si195_dsclotacao' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102014');
update pg_attribute set attnum = attnum+1 where attname = 'si195_indcessao' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102014');
update pg_attribute set attnum = attnum+1 where attname = 'si195_reqcargo' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102014');
update pg_attribute set attnum = attnum+1 where attname = 'si195_sglcargo' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102014');
update pg_attribute set attnum = attnum+1 where attname = 'si195_dsccargo' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102014');
update pg_attribute set attnum = attnum+1 where attname = 'si195_datconcessaoaposentadoriapensao' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102014');
update pg_attribute set attnum = attnum+1 where attname = 'si195_indsituacaoservidorpensionista' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102014');
update pg_attribute set attnum = attnum+1 where attname = 'si195_indtipopagamento' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102014');
update pg_attribute set attnum = attnum+1 where attname = 'si195_regime' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102014');

update pg_attribute set attnum = 4 where attname = 'si195_codreduzidopessoa' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102014');



alter table flpgo102015 add column si195_codreduzidopessoa integer default 0;

update pg_attribute set attnum = attnum+1 where attname = 'si195_codreduzidopessoa' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102015');
update pg_attribute set attnum = attnum+1 where attname = 'si195_inst' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102015');
update pg_attribute set attnum = attnum+1 where attname = 'si195_mes' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102015');
update pg_attribute set attnum = attnum+1 where attname = 'si195_vlrabateteto' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102015');
update pg_attribute set attnum = attnum+1 where attname = 'si195_vlrdeducoesobrigatorias' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102015');
update pg_attribute set attnum = attnum+1 where attname = 'si195_vlrremuneracaoliquida' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102015');
update pg_attribute set attnum = attnum+1 where attname = 'si195_natsaldoliquido' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102015');
update pg_attribute set attnum = attnum+1 where attname = 'si195_vlrremuneracaobruta' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102015');
update pg_attribute set attnum = attnum+1 where attname = 'si195_natsaldobruto' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102015');
update pg_attribute set attnum = attnum+1 where attname = 'si195_datexclusao' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102015');
update pg_attribute set attnum = attnum+1 where attname = 'si195_datefetexercicio' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102015');
update pg_attribute set attnum = attnum+1 where attname = 'si195_vlrcargahorariasemanal' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102015');
update pg_attribute set attnum = attnum+1 where attname = 'si195_dsclotacao' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102015');
update pg_attribute set attnum = attnum+1 where attname = 'si195_indcessao' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102015');
update pg_attribute set attnum = attnum+1 where attname = 'si195_reqcargo' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102015');
update pg_attribute set attnum = attnum+1 where attname = 'si195_sglcargo' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102015');
update pg_attribute set attnum = attnum+1 where attname = 'si195_dsccargo' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102015');
update pg_attribute set attnum = attnum+1 where attname = 'si195_datconcessaoaposentadoriapensao' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102015');
update pg_attribute set attnum = attnum+1 where attname = 'si195_indsituacaoservidorpensionista' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102015');
update pg_attribute set attnum = attnum+1 where attname = 'si195_indtipopagamento' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102015');
update pg_attribute set attnum = attnum+1 where attname = 'si195_regime' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102015');

update pg_attribute set attnum = 4 where attname = 'si195_codreduzidopessoa' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102015');



alter table flpgo102016 add column si195_codreduzidopessoa integer default 0;

update pg_attribute set attnum = attnum+1 where attname = 'si195_codreduzidopessoa' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102016');
update pg_attribute set attnum = attnum+1 where attname = 'si195_inst' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102016');
update pg_attribute set attnum = attnum+1 where attname = 'si195_mes' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102016');
update pg_attribute set attnum = attnum+1 where attname = 'si195_vlrabateteto' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102016');
update pg_attribute set attnum = attnum+1 where attname = 'si195_vlrdeducoesobrigatorias' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102016');
update pg_attribute set attnum = attnum+1 where attname = 'si195_vlrremuneracaoliquida' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102016');
update pg_attribute set attnum = attnum+1 where attname = 'si195_natsaldoliquido' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102016');
update pg_attribute set attnum = attnum+1 where attname = 'si195_vlrremuneracaobruta' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102016');
update pg_attribute set attnum = attnum+1 where attname = 'si195_natsaldobruto' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102016');
update pg_attribute set attnum = attnum+1 where attname = 'si195_datexclusao' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102016');
update pg_attribute set attnum = attnum+1 where attname = 'si195_datefetexercicio' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102016');
update pg_attribute set attnum = attnum+1 where attname = 'si195_vlrcargahorariasemanal' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102016');
update pg_attribute set attnum = attnum+1 where attname = 'si195_dsclotacao' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102016');
update pg_attribute set attnum = attnum+1 where attname = 'si195_indcessao' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102016');
update pg_attribute set attnum = attnum+1 where attname = 'si195_reqcargo' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102016');
update pg_attribute set attnum = attnum+1 where attname = 'si195_sglcargo' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102016');
update pg_attribute set attnum = attnum+1 where attname = 'si195_dsccargo' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102016');
update pg_attribute set attnum = attnum+1 where attname = 'si195_datconcessaoaposentadoriapensao' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102016');
update pg_attribute set attnum = attnum+1 where attname = 'si195_indsituacaoservidorpensionista' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102016');
update pg_attribute set attnum = attnum+1 where attname = 'si195_indtipopagamento' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102016');
update pg_attribute set attnum = attnum+1 where attname = 'si195_regime' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102016');

update pg_attribute set attnum = 4 where attname = 'si195_codreduzidopessoa' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo102016');


commit;