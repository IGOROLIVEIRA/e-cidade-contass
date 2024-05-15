begin;
update db_itensmenu set libcliente = false where id_item in
(5724,7830,587072,7180,7822,7831,9350,96,7791,4879,5696,3380,3742,9767,6819,3747,3507,2559,3856,4013,4069,4754,3474,7032,7055,7185,9235,4045,9358,9160,4953,4249,5159,8018,8093,4076,4753,5279,5002,4176,9252,4792,4796,3000037,3000033,3000,41,5492,5490,5219,8131,5478,4750,8056,8602,8983,8590,8120,8790,8116,8136);

update db_itensmenu set libcliente = true where id_item = 55;

delete from db_menu where id_item_filho = 4097 and modulo = 116;

update db_sysmodulo set ativo = false where codmod = 53;
commit;

/*
Menu 55 foi inativado equivocadamente.
Ajustado, sendo inativado o menu 7055, e reativado o menu 55.
*/