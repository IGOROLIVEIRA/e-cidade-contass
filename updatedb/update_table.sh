begin;
CREATE TABLE IF NOT EXISTS updatedb
(
  codscript SERIAL,
  nomescript varchar(250) not null,
  dataexec date,
  CONSTRAINT updatedb_codscript_pk PRIMARY KEY (codscript)
);

commit;

begin;

DELETE FROM updatedb WHERE codscript NOT IN (SELECT MAX(codscript) As IdMaximo FROM updatedb GROUP BY nomescript);

commit;

begin;

select setval('db_itensmenu_id_item_seq', (select max(id_item) from configuracoes.db_itensmenu) );

commit;

copy (select nomescript from updatedb) to '/tmp/scripts_executados'
