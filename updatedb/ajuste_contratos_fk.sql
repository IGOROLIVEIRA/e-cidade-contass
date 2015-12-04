begin;
select fc_startsession();
alter table contratos drop constraint contratos_fornecedor_fk;
alter table contratos add constraint contratos_fornecgm_fk foreign key (si172_fornecedor) references cgm(z01_numcgm);
commit;