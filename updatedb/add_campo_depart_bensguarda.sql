begin;
select fc_startsession();
alter table bensguarda add column t21_depart int8;
alter table bensguarda add constraint bensguarda_depart_fk FOREIGN KEY (t21_depart) REFERENCES db_depart(coddepto);

update bensguarda set t21_depart = (select t52_depart from bens where t52_bem = (select t22_bem from bensguardaitem where t22_bensguarda = t21_codigo limit 1)) where t21_depart is null;

update bensguarda set t21_depart = 1 where t21_depart is null;
commit;
