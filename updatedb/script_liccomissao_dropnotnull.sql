BEGIN;
select fc_startsession();
alter table liccomissaocgm alter column l31_liccomissao DROP NOT NULL;

COMMIT;
