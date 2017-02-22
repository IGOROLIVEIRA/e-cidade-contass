BEGIN;

select setval('iptubase_j01_matric_seq',(select max(j01_matric) from iptubase));

COMMIT;
