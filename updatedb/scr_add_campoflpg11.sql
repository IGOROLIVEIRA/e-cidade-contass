begin;

alter table flpgo112013 add column si196_codreduzidopessoa integer default 0;
update pg_attribute set attnum = attnum+1 where attname = 'si196_codreduzidopessoa' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo112013');
update pg_attribute set attnum = attnum+1 where attname = 'si196_reg10' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo112013');
update pg_attribute set attnum = attnum+1 where attname = 'si196_inst' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo112013');
update pg_attribute set attnum = attnum+1 where attname = 'si196_mes' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo112013');
update pg_attribute set attnum = attnum+1 where attname = 'si196_vlrremuneracaodetalhada' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo112013');
update pg_attribute set attnum = attnum+1 where attname = 'si196_natsaldodetalhe' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo112013');
update pg_attribute set attnum = attnum+1 where attname = 'si196_descoutros' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo112013');
update pg_attribute set attnum = attnum+1 where attname = 'si196_tiporemuneracao' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo112013');
update pg_attribute set attnum = 4 where attname = 'si196_codreduzidopessoa' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo112013');



alter table flpgo112014 add column si196_codreduzidopessoa integer default 0;
update pg_attribute set attnum = attnum+1 where attname = 'si196_codreduzidopessoa' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo112014');
update pg_attribute set attnum = attnum+1 where attname = 'si196_reg10' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo112014');
update pg_attribute set attnum = attnum+1 where attname = 'si196_inst' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo112014');
update pg_attribute set attnum = attnum+1 where attname = 'si196_mes' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo112014');
update pg_attribute set attnum = attnum+1 where attname = 'si196_vlrremuneracaodetalhada' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo112014');
update pg_attribute set attnum = attnum+1 where attname = 'si196_natsaldodetalhe' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo112014');
update pg_attribute set attnum = attnum+1 where attname = 'si196_descoutros' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo112014');
update pg_attribute set attnum = attnum+1 where attname = 'si196_tiporemuneracao' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo112014');
update pg_attribute set attnum = 4 where attname = 'si196_codreduzidopessoa' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo112014');



alter table flpgo112015 add column si196_codreduzidopessoa integer default 0;
update pg_attribute set attnum = attnum+1 where attname = 'si196_codreduzidopessoa' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo112015');
update pg_attribute set attnum = attnum+1 where attname = 'si196_reg10' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo112015');
update pg_attribute set attnum = attnum+1 where attname = 'si196_inst' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo112015');
update pg_attribute set attnum = attnum+1 where attname = 'si196_mes' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo112015');
update pg_attribute set attnum = attnum+1 where attname = 'si196_vlrremuneracaodetalhada' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo112015');
update pg_attribute set attnum = attnum+1 where attname = 'si196_natsaldodetalhe' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo112015');
update pg_attribute set attnum = attnum+1 where attname = 'si196_descoutros' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo112015');
update pg_attribute set attnum = attnum+1 where attname = 'si196_tiporemuneracao' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo112015');
update pg_attribute set attnum = 4 where attname = 'si196_codreduzidopessoa' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo112015');



alter table flpgo112016 add column si196_codreduzidopessoa integer default 0;
update pg_attribute set attnum = attnum+1 where attname = 'si196_codreduzidopessoa' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo112016');
update pg_attribute set attnum = attnum+1 where attname = 'si196_reg10' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo112016');
update pg_attribute set attnum = attnum+1 where attname = 'si196_inst' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo112016');
update pg_attribute set attnum = attnum+1 where attname = 'si196_mes' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo112016');
update pg_attribute set attnum = attnum+1 where attname = 'si196_vlrremuneracaodetalhada' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo112016');
update pg_attribute set attnum = attnum+1 where attname = 'si196_natsaldodetalhe' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo112016');
update pg_attribute set attnum = attnum+1 where attname = 'si196_descoutros' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo112016');
update pg_attribute set attnum = attnum+1 where attname = 'si196_tiporemuneracao' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo112016');
update pg_attribute set attnum = 4 where attname = 'si196_codreduzidopessoa' and attrelid in (select distinct a.attrelid FROM pg_attribute a INNER JOIN pg_class c ON c.oid = a.attrelid WHERE  c.relname = 'flpgo112016');

commit;