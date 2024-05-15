BEGIN;

select fc_startsession();

alter table flpgo102016 alter column si195_numcpf TYPE varchar(11);
alter table flpgo102015 alter column si195_numcpf TYPE varchar(11);
alter table flpgo102014 alter column si195_numcpf TYPE varchar(11);
alter table flpgo102013 alter column si195_numcpf TYPE varchar(11);

COMMIT;