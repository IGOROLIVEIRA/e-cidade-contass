-- [OC21216] Altera a receita de algumas dividas ativas
BEGIN;

SELECT fc_putsession('DB_instit', '1');

update divida set v01_vlrhis = 902169.02 where v01_coddiv = 1984833;

update divida set v01_vlrhis = 1018034.79 where v01_coddiv = 1984834;

update divida set v01_vlrhis = 3936734.26 where v01_coddiv = 1984829;

update divida set v01_vlrhis = 902169.02 where v01_coddiv = 1984830;

update divida set v01_vlrhis = 1018034.79 where v01_coddiv = 1984831;

update divida set v01_vlrhis = 629879.15 where v01_coddiv = 1984832;

update divida set v01_vlrhis = 3936734.26 where v01_coddiv = 1984826;

update divida set v01_vlrhis = 902169.02 where v01_coddiv = 1984827;

update divida set v01_vlrhis = 1018034.79 where v01_coddiv = 1984825;

update divida set v01_vlrhis = 629879.15 where v01_coddiv = 1984828;

update divida set v01_vlrhis = 902169.02 where v01_coddiv = 1984759;

update divida set v01_vlrhis = 3936734.26 where v01_coddiv = 1984760;

