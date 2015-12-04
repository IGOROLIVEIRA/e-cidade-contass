begin;
select fc_startsession();
update pcorcamfornelic set pc31_liclicita = ( select distinct l20_codigo from liclicita 
inner join liclicitem on liclicitem.l21_codliclicita = liclicita.l20_codigo 
inner join pcorcamitemlic on pcorcamitemlic.pc26_liclicitem = liclicitem.l21_codigo 
inner join pcorcamitem on pcorcamitemlic.pc26_orcamitem = pcorcamitem.pc22_orcamitem 
inner join pcorcam on pcorcam.pc20_codorc = pcorcamitem.pc22_codorc 
inner join pcorcamforne on pcorcam.pc20_codorc = pcorcamforne.pc21_codorc 
where pcorcamforne.pc21_orcamforne = pcorcamfornelic.pc31_orcamforne),
pc31_regata = 1, pc31_renunrecurso = 1 
where pc31_liclicita is null;
commit;
