BEGIN;

SELECT fc_putsession('DB_instit', '1');

update divida set v01_proced = 28 where v01_coddiv = 1984833;
update arrecad set k00_receit = 764 where k00_numpre in (select v01_numpre from divida where v01_coddiv = 1984833);

update divida set v01_proced = 28 where v01_coddiv = 1984834;
update arrecad set k00_receit = 764 where k00_numpre in (select v01_numpre from divida where v01_coddiv = 1984834);

update divida set v01_proced = 28 where v01_coddiv = 1984829;
update arrecad set k00_receit = 764 where k00_numpre in (select v01_numpre from divida where v01_coddiv = 1984829);

update divida set v01_proced = 28 where v01_coddiv = 1984830;
update arrecad set k00_receit = 764 where k00_numpre in (select v01_numpre from divida where v01_coddiv = 1984830);

update divida set v01_proced = 28 where v01_coddiv = 1984831;
update arrecad set k00_receit = 764 where k00_numpre in (select v01_numpre from divida where v01_coddiv = 1984831);

update divida set v01_proced = 28 where v01_coddiv = 1984827;
update arrecad set k00_receit = 764 where k00_numpre in (select v01_numpre from divida where v01_coddiv = 1984827);

update divida set v01_proced = 28 where v01_coddiv = 1984825;
update arrecad set k00_receit = 764 where k00_numpre in (select v01_numpre from divida where v01_coddiv = 1984825);

update divida set v01_proced = 28 where v01_coddiv = 1984828;
update arrecad set k00_receit = 764 where k00_numpre in (select v01_numpre from divida where v01_coddiv = 1984828);

update divida set v01_proced = 28 where v01_coddiv = 1984759;
update arrecad set k00_receit = 764 where k00_numpre in (select v01_numpre from divida where v01_coddiv = 1984759);

update divida set v01_proced = 28 where v01_coddiv = 1984760;
update arrecad set k00_receit = 764 where k00_numpre in (select v01_numpre from divida where v01_coddiv = 1984760);
