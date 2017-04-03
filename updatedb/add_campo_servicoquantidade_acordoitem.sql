begin;
select fc_startsession();
alter table acordoitem add column ac20_servicoquantidade boolean default false;
commit;
