
-- Ocorrência 6968 - SCRIPT 01
BEGIN;
SELECT fc_startsession();

-- Início do script

-- Alteração da descrição do menu atual
update db_itensmenu set descricao = 'Dem. Fiscais LRF (anteriores a 2018)', help = 'Dem. Fiscais LRF (anteriores a 2018)', desctec = 'Dem. Fiscais LRF (anteriores a 2018)'
   where id_item = (
      select db_itensmenu.id_item
       from db_itensmenu
        inner join db_menu on db_menu.id_item_filho = db_itensmenu.id_item
        where descricao = 'Demonstrativos Fiscais(LRF)'
         and modulo = 209
    );

-- Inserção do primeiro menu
INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu), 'Demonstrativos Fiscais (LRF)', 'Demonstrativos Fiscais (LRF) 2018', '', 1, 1, 'Demonstrativos Fiscais (LRF) 2018', 't');
INSERT INTO db_menu VALUES (3331, (select max(id_item) from db_itensmenu), (select max(menusequencia) + 1 from db_menu where modulo = 209 and id_item = 3331), 209);

--RREO
INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu), 'RREO', 'RREO 2018', '', 1, 1, 'RREO 2018', 't');
INSERT INTO db_menu VALUES ((select id_item from db_itensmenu where help = 'Demonstrativos Fiscais (LRF) 2018' and desctec = 'Demonstrativos Fiscais (LRF) 2018'), (select max(id_item) from db_itensmenu), 1, 209);

--RREO
INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu),
  'Anexo I - Balanço Orçamentário',
  'Anexo I - Balanço Orçamentário',
  'con2_lrfbalorc001.php?newlrf=true', 1, 1,
  'Anexo I', 't');
INSERT INTO db_menu VALUES ((select max(id_item)-1 from db_itensmenu), (select max(id_item) from db_itensmenu), 1, 209);

INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu),
  'Anexo II - Dem. Desp. Função/Subfunção (Novo)',
  'Anexo II - Dem. Desp. Função/Subfunção (Novo)',
  'con2_anexodemonstrativofuncaosubfuncao001.php?newlrf=true', 1, 1,
  '', 't');
INSERT INTO db_menu VALUES ((select max(id_item)-2 from db_itensmenu), (select max(id_item) from db_itensmenu), 2, 209);

INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu),
  'Anexo III - Dem.da Rec. Corrente Líquida',
  'Anexo III - Dem.da Rec. Corrente Líquida',
  'con2_lrfreceitacorrente001.php?newlrf=true', 1, 1,
  'Anexo III', 't');
INSERT INTO db_menu VALUES ((select max(id_item)-3 from db_itensmenu), (select max(id_item) from db_itensmenu), 3, 209);

INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu),
  'Anexo IV - Dem.das Rec e Desp do RPPS',
  'Anexo IV - Dem.das Rec e Desp do RPPS',
  'con2_lrfrecdesprpps001.php?newlrf=true', 1, 1,
  'Anexo IV', 't');
INSERT INTO db_menu VALUES ((select max(id_item)-4 from db_itensmenu), (select max(id_item) from db_itensmenu), 4, 209);

INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu),
  'Anexo VII - Dem.dos Restos a Pagar',
  'Anexo VII - Dem.dos Restos a Pagar',
  'con2_lrfdemonstrativorp001.php?newlrf=true', 1, 1,
  'Anexo VII', 't');
INSERT INTO db_menu VALUES ((select max(id_item)-5 from db_itensmenu), (select max(id_item) from db_itensmenu), 7, 209);

INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu),
  'Anexo VIII - Dem.das Rec.e Desp.com MDE',
  'Anexo VIII - Dem.das Rec.e Desp.com MDE',
  'con2_lrfmdefundeb001.php?newlrf=true', 1, 1,
  'Anexo VIII', 't');
INSERT INTO db_menu VALUES ((select max(id_item)-6 from db_itensmenu), (select max(id_item) from db_itensmenu), 8, 209);

INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu),
  'Anexo XI - Dem Rec Op de Cred e Desp Cap',
  'Anexo XI - Dem. Rec. Op. de Cred. e Desp. Cap.',
  'con2_lrfdemrecopcreddespcap001.php?newlrf=true', 1, 1,
  'Anexo XI - Dem. Rec. Op. de Cred. e Desp. Cap.', 't');
INSERT INTO db_menu VALUES ((select max(id_item)-7 from db_itensmenu), (select max(id_item) from db_itensmenu), 9, 209);

INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu),
  'Anexo XII - Dem.dos Imp.e Desp.com Saúde',
  'Anexo XVI - Dem.dos Imp.e Desp.com Saúde',
  'con2_lrfimpostossaude001.php?newlrf=true', 1, 1,
  'Anexo XVI', 't');
INSERT INTO db_menu VALUES ((select max(id_item)-8 from db_itensmenu), (select max(id_item) from db_itensmenu), 10, 209);

INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu),
  'Anexo XIV - Dem Alien At Aplic Recursos',
  'Anexo XIV - Dem. Alien. At. Aplic. Recursos.',
  'con2_lrfdemalienataplicrecursos001.php?newlrf=true', 1, 1,
  'Anexo XIV - Dem. Alien. At. Aplic. Recursos.', 't');
INSERT INTO db_menu VALUES ((select max(id_item)-9 from db_itensmenu), (select max(id_item) from db_itensmenu), 11, 209);

INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu),
  'Anexo XVII - Demonstrativo das PPPs',
  'Anexo XVII - Demonstrativo das PPPs',
  'con2_lrfanexoxvii001.php?newlrf=true', 1, 1,
  'Relatório RREO Anexo XVII', 't');
INSERT INTO db_menu VALUES ((select max(id_item)-10 from db_itensmenu), (select max(id_item) from db_itensmenu), 12, 209);


--RGF
INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu), 'RGF', 'RGF 2018', '', 1, 1, 'RGF 2018', 't');
INSERT INTO db_menu VALUES ((select id_item from db_itensmenu where help = 'Demonstrativos Fiscais (LRF) 2018' and desctec = 'Demonstrativos Fiscais (LRF) 2018'), (select max(id_item) from db_itensmenu), 2, 209);

INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu),
  'Anexo I - Dem. da Despesa com Pessoal',
  'Anexo I - Dem. da Despesa com Pessoal',
  'con2_lrfdesppessoal001_2010.php?newlrf=true', 1, 1,
  'Anexo I - Dem. da Despesa com Pessoal', 't');
INSERT INTO db_menu VALUES ((select max(id_item)-1 from db_itensmenu), (select max(id_item) from db_itensmenu), 1, 209);

INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu),
  'Anexo II - Dem. da Dívida Cons. Líquida',
  'Anexo II - Dem. da Dívida Cons. Líquida',
  'con2_lrfdivida001.php?newlrf=true', 1, 1,
  'Anexo II - Dem. da Dívida Cons. Líquida', 't');
INSERT INTO db_menu VALUES ((select max(id_item)-2 from db_itensmenu), (select max(id_item) from db_itensmenu), 2, 209);

INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu),
  'Anexo III - Dem. Gar. e Contr.de Valores',
  'Anexo III - Demonstrativo  Gararantias. e Contragarantias de valores',
  'con2_lrfgarantias001.php?newlrf=true', 1, 1,
  'Anexo III - Demonstrativo  Gararantias. e Contragarantias de valores', 't');
INSERT INTO db_menu VALUES ((select max(id_item)-3 from db_itensmenu), (select max(id_item) from db_itensmenu), 3, 209);

INSERT INTO db_itensmenu VALUES ((select max(id_item) + 1 from db_itensmenu),
  'Anexo IV - Dem. Das. Oper. De Crédito',
  'Anexo IV - Dem. Das. Oper. De Crédito',
  'con2_opercredito001.php?newlrf=true', 1, 1,
  'Anexo IV - Dem. Das. Oper. De Crédito', 't');
INSERT INTO db_menu VALUES ((select max(id_item)-4 from db_itensmenu), (select max(id_item) from db_itensmenu), 4, 209);

-- Fim do script

COMMIT;