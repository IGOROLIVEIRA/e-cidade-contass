select fc_startsession();
begin;
insert into orcparamrel( o42_codparrel ,o42_orcparamrelgrupo ,o42_descrrel ,o42_notapadrao ) values (nextval('orcparamrel_o42_codparrel_seq'),4 ,'ANEXO IV - GASTO COM PESSOAL' ,'ANEXO IV - GASTO COM PESSOAL' );
insert into orcparamrelperiodos( o113_sequencial ,o113_periodo ,o113_orcparamrel ) values ( 749 ,17 ,4000003 );
insert into orcparamrelperiodos( o113_sequencial ,o113_periodo ,o113_orcparamrel ) values ( 749 ,18 ,4000003 );
insert into orcparamrelperiodos( o113_sequencial ,o113_periodo ,o113_orcparamrel ) values ( 749 ,19 ,4000003 );
insert into orcparamrelperiodos( o113_sequencial ,o113_periodo ,o113_orcparamrel ) values ( 749 ,20 ,4000003 );
insert into orcparamrelperiodos( o113_sequencial ,o113_periodo ,o113_orcparamrel ) values ( 749 ,21 ,4000003 );
insert into orcparamrelperiodos( o113_sequencial ,o113_periodo ,o113_orcparamrel ) values ( 749 ,22 ,4000003 );
insert into orcparamrelperiodos( o113_sequencial ,o113_periodo ,o113_orcparamrel ) values ( 749 ,23 ,4000003 );
insert into orcparamrelperiodos( o113_sequencial ,o113_periodo ,o113_orcparamrel ) values ( 749 ,24 ,4000003 );
insert into orcparamrelperiodos( o113_sequencial ,o113_periodo ,o113_orcparamrel ) values ( 749 ,25 ,4000003 );
insert into orcparamrelperiodos( o113_sequencial ,o113_periodo ,o113_orcparamrel ) values ( 749 ,26 ,4000003 );
insert into orcparamrelperiodos( o113_sequencial ,o113_periodo ,o113_orcparamrel ) values ( 749 ,27 ,4000003 );
insert into orcparamrelperiodos( o113_sequencial ,o113_periodo ,o113_orcparamrel ) values ( 749 ,28 ,4000003 );
insert into orcparamseq( o69_codparamrel ,o69_codseq ,o69_descr ,o69_grupo ,o69_grupoexclusao ,o69_nivel ,o69_libnivel ,o69_librec ,o69_libsubfunc ,o69_libfunc ,o69_verificaano ,o69_labelrel ,o69_manual ,o69_totalizador ,o69_ordem ,o69_nivellinha ,o69_observacao ,o69_desdobrarlinha ,o69_origem ) values ( 4000003 ,1 ,'RECEITA CORRENTE DO MUNICÍPIO' ,0 ,0 ,0 ,'f' ,'f' ,'f' ,'f' ,'f' ,'RECEITA CORRENTE DO MUNICÍPIO' ,'t' ,'f' ,1,1 ,'' ,'f' ,0 );
insert into orcparamseq( o69_codparamrel ,o69_codseq ,o69_descr ,o69_grupo ,o69_grupoexclusao ,o69_nivel ,o69_libnivel ,o69_librec ,o69_libsubfunc ,o69_libfunc ,o69_verificaano ,o69_labelrel ,o69_manual ,o69_totalizador ,o69_ordem ,o69_nivellinha ,o69_observacao ,o69_desdobrarlinha ,o69_origem ) values ( 4000003 ,2 ,'SENTENÇAS JUDICIAIS ANTERIORES' ,1 ,0 ,1 ,'f' ,'f' ,'f' ,'f' ,'f' ,'Sentenças Judiciais Anteriores' ,'t' ,'f' ,2 ,1 ,'Sentenças Judiciais Anteriores' ,'f' ,0 )

insert into db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Relatório diário das Despesas','Relatório diário das Despesas','emp2_empenhospagos001.php',1,1,'Relatório diário das Despesas','t');
insert into db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Transferências Bancárias','Transferências Bancárias','con2_transfbanc001.php',1,1,'Transferências Bancárias','t');
insert into db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'DEMONST DÍVIDAS FUNDADAS','DEMONST DÍVIDAS FUNDADAS','con2_ddc001.php',1,1,'DEMONST DÍVIDAS FUNDADAS','t');
insert into db_menu values (4000292,(select max(id_item)-2 from db_itensmenu),12,209);
insert into db_menu values (4000292,(select max(id_item)-1 from db_itensmenu),12,209);
insert into db_menu values (4000292,(select max(id_item) from db_itensmenu),12,209);

commit;