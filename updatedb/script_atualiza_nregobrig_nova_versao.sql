begin;
select fc_startsession();
update conplano set c60_nregobrig = 17 where c60_codsis = 6 and c60_anousu > 2014;
update conplano set c60_nregobrig = 16 where c60_codsis = 5 and c60_anousu > 2014;
update conplano set c60_nregobrig = 15 where c60_codsis = 7 and c60_anousu > 2014;
commit;
