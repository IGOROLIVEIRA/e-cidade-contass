<?php

use Phinx\Migration\AbstractMigration;

class Oc18194hotfix extends AbstractMigration
{
    
      public function up()
    {

    $sql = <<<SQL

    BEGIN;

    SELECT fc_startsession();

        -- Inserindo menu  Anexo VI - Dem. Simplif. do Relatório de Gestão Fiscal (E, DF, M)
    INSERT INTO db_itensmenu VALUES ((SELECT max(id_item)+1 FROM db_itensmenu),' Anexo VI - Dem. Simplif. do Relatório de Gestão Fiscal (E, DF, M)', ' Anexo VI - Dem. Simplif. do Relatório de Gestão Fiscal (E, DF, M)','con2_lrfdemsimplif001.php',1,1,' Anexo VI - Dem. Simplif. do Relatório de Gestão Fiscal (E, DF, M)','t');
      
    INSERT INTO db_menu VALUES
      ((SELECT id_item FROM db_itensmenu
      WHERE descricao LIKE 'RGF' and desctec LIKE 'RGF 2018'),

      (SELECT max(id_item) FROM db_itensmenu),

      (SELECT max(menusequencia)+1 FROM db_menu
      WHERE id_item =
          (SELECT id_item FROM db_itensmenu WHERE descricao LIKE 'RGF' and desctec LIKE 'RGF 2018')
      AND modulo = 209),

      209);


insert into orcparamrel( o42_codparrel ,o42_orcparamrelgrupo ,o42_descrrel ,o42_notapadrao ) 
values 
(4000004,4 ,'Anexo VI - Demonstrativo Simplificado do Relatório de Gestão Fiscal - Estado, DF e Município ' ,'Anexo VI - Demonstrativo Simplificado do Relatório de Gestão Fiscal - Estado, DF e Município ' );

insert into orcparamseq( o69_codparamrel ,o69_codseq ,o69_descr ,o69_grupo ,o69_grupoexclusao ,o69_nivel ,o69_libnivel ,o69_librec ,o69_libsubfunc ,o69_libfunc ,o69_verificaano ,o69_labelrel ,o69_manual ,o69_totalizador ,o69_ordem ,o69_nivellinha ,o69_observacao ,o69_desdobrarlinha ,o69_origem ) 
values 
( 4000004 ,1 ,'Receita Corrente Líquida' ,1 ,0 ,1 ,'f' ,'f' ,'f' ,'f' ,'f' ,'Receita Corrente Líquida' ,'t' ,'f' ,1 ,1 ,'Receita Corrente Líquida' ,'f' ,0 );

insert into orcparamseq( o69_codparamrel ,o69_codseq ,o69_descr ,o69_grupo ,o69_grupoexclusao ,o69_nivel ,o69_libnivel ,o69_librec ,o69_libsubfunc ,o69_libfunc ,o69_verificaano ,o69_labelrel ,o69_manual ,o69_totalizador ,o69_ordem ,o69_nivellinha ,o69_observacao ,o69_desdobrarlinha ,o69_origem ) 
values 
( 4000004 ,2 ,'Receita Corrente Líquida Ajustada para Cálculo dos Limites de Endividamento' ,1 ,0 ,1 ,'f' ,'f' ,'f' ,'f' ,'f' ,'Receita Corrente Líquida Ajustada para Cálculo dos Limites de Endividamento' ,'t' ,'f' ,2 ,1 ,'Receita Corrente Líquida Ajustada para Cálculo dos Limites de Endividamento' ,'f' ,0 );

insert into orcparamseq( o69_codparamrel ,o69_codseq ,o69_descr ,o69_grupo ,o69_grupoexclusao ,o69_nivel ,o69_libnivel ,o69_librec ,o69_libsubfunc ,o69_libfunc ,o69_verificaano ,o69_labelrel ,o69_manual ,o69_totalizador ,o69_ordem ,o69_nivellinha ,o69_observacao ,o69_desdobrarlinha ,o69_origem ) 
values 
( 4000004 ,3 ,'Receita Corrente Líquida Ajustada para Cálculo dos Limites da Despesa com Pessoal' ,1 ,0 ,1 ,'f' ,'f' ,'f' ,'f' ,'f' ,'Receita Corrente Líquida Ajustada para Cálculo dos Limites da Despesa com Pessoal' ,'t' ,'f' ,3 ,1 ,'Receita Corrente Líquida Ajustada para Cálculo dos Limites da Despesa com Pessoal' ,'f' ,0 );

insert into orcparamseq( o69_codparamrel ,o69_codseq ,o69_descr ,o69_grupo ,o69_grupoexclusao ,o69_nivel ,o69_libnivel ,o69_librec ,o69_libsubfunc ,o69_libfunc ,o69_verificaano ,o69_labelrel ,o69_manual ,o69_totalizador ,o69_ordem ,o69_nivellinha ,o69_observacao ,o69_desdobrarlinha ,o69_origem ) 
values 
( 4000004 ,4 ,'Dívida Consolidada Líquida' ,1 ,0 ,1 ,'f' ,'f' ,'f' ,'f' ,'f' ,'Dívida Consolidada Líquida' ,'t' ,'f' ,4 ,1 ,'Dívida Consolidada Líquida' ,'f' ,0 );

insert into orcparamseq( o69_codparamrel ,o69_codseq ,o69_descr ,o69_grupo ,o69_grupoexclusao ,o69_nivel ,o69_libnivel ,o69_librec ,o69_libsubfunc ,o69_libfunc ,o69_verificaano ,o69_labelrel ,o69_manual ,o69_totalizador ,o69_ordem ,o69_nivellinha ,o69_observacao ,o69_desdobrarlinha ,o69_origem ) 
values 
( 4000004 ,5 ,'Total das Garantias Concedidas' ,1 ,0 ,1 ,'f' ,'f' ,'f' ,'f' ,'f' ,'Total das Garantias Concedidas' ,'t' ,'f' ,5 ,1 ,'Total das Garantias Concedidas' ,'f' ,0 );

insert into orcparamseq( o69_codparamrel ,o69_codseq ,o69_descr ,o69_grupo ,o69_grupoexclusao ,o69_nivel ,o69_libnivel ,o69_librec ,o69_libsubfunc ,o69_libfunc ,o69_verificaano ,o69_labelrel ,o69_manual ,o69_totalizador ,o69_ordem ,o69_nivellinha ,o69_observacao ,o69_desdobrarlinha ,o69_origem ) 
values 
( 4000004 ,6 ,'Operações de Crédito Internas e Externas' ,1 ,0 ,1 ,'f' ,'f' ,'f' ,'f' ,'f' ,'Operações de Crédito Internas e Externas' ,'t' ,'f' ,6,1 ,'Operações de Crédito Internas e Externas' ,'f' ,0 );

insert into orcparamseq( o69_codparamrel ,o69_codseq ,o69_descr ,o69_grupo ,o69_grupoexclusao ,o69_nivel ,o69_libnivel ,o69_librec ,o69_libsubfunc ,o69_libfunc ,o69_verificaano ,o69_labelrel ,o69_manual ,o69_totalizador ,o69_ordem ,o69_nivellinha ,o69_observacao ,o69_desdobrarlinha ,o69_origem ) 
values 
( 4000004 ,7 ,'Operações de Crédito por Antecipação da Receita' ,1 ,0 ,1 ,'f' ,'f' ,'f' ,'f' ,'f' ,'Operações de Crédito por Antecipação da Receita' ,'t' ,'f' ,7 ,1 ,'Operações de Crédito por Antecipação da Receita' ,'f' ,0 );

insert into orcparamseq( o69_codparamrel ,o69_codseq ,o69_descr ,o69_grupo ,o69_grupoexclusao ,o69_nivel ,o69_libnivel ,o69_librec ,o69_libsubfunc ,o69_libfunc ,o69_verificaano ,o69_labelrel ,o69_manual ,o69_totalizador ,o69_ordem ,o69_nivellinha ,o69_observacao ,o69_desdobrarlinha ,o69_origem ) 
values 
( 4000004 ,8 ,'Valor Total Da Disponibilidade de Caixa Líquida' ,1 ,0 ,1 ,'f' ,'f' ,'f' ,'f' ,'f' ,'Valor Total Da Disponibilidade de Caixa Líquida' ,'t' ,'f' ,8 ,1 ,'Valor Total Da Disponibilidade de Caixa Líquida' ,'f' ,0 );

insert into orcparamrelperiodos( o113_sequencial ,o113_periodo ,o113_orcparamrel ) 
values ( nextval('orcparamrelperiodos_o113_sequencial_seq')+4000000 ,12 ,4000004 );

insert into orcparamrelperiodos( o113_sequencial ,o113_periodo ,o113_orcparamrel ) 
values ( nextval('orcparamrelperiodos_o113_sequencial_seq')+4000000 ,13 ,4000004 );

insert into orcparamrelperiodos( o113_sequencial ,o113_periodo ,o113_orcparamrel ) 
values ( nextval('orcparamrelperiodos_o113_sequencial_seq')+4000000 ,14 ,4000004 );

insert into orcparamrelperiodos( o113_sequencial ,o113_periodo ,o113_orcparamrel ) 
values ( nextval('orcparamrelperiodos_o113_sequencial_seq')+4000000 ,15 ,4000004 );

insert into orcparamrelperiodos( o113_sequencial ,o113_periodo ,o113_orcparamrel ) 
values ( nextval('orcparamrelperiodos_o113_sequencial_seq')+4000000 ,16 ,4000004 );


insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna),1 ,4000004 ,103 ,0 ,12 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna),1 ,4000004 ,103 ,0 ,13 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna),1 ,4000004 ,103 ,0 ,14 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna),1 ,4000004 ,103 ,0 ,15 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna),1 ,4000004 ,103 ,0 ,16 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna),2 ,4000004 ,103 ,0 ,12 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna),2 ,4000004 ,103 ,0 ,13 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna),2 ,4000004 ,103 ,0 ,14 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna),2 ,4000004 ,103 ,0 ,15 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna),2 ,4000004 ,103 ,0 ,16 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna),3 ,4000004 ,103 ,0 ,12 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna),3 ,4000004 ,103 ,0 ,13 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna),3 ,4000004 ,103 ,0 ,14 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna),3 ,4000004 ,103 ,0 ,15 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna),3 ,4000004 ,103 ,0 ,16 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna),4 ,4000004 ,103 ,0 ,12 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna),4 ,4000004 ,103 ,0 ,13 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna),4 ,4000004 ,103 ,0 ,14 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna),4 ,4000004 ,103 ,0 ,15 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna),4 ,4000004 ,103 ,0 ,16 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna),5 ,4000004 ,103 ,0 ,12 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna),5 ,4000004 ,103 ,0 ,13 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna),5 ,4000004 ,103 ,0 ,14 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna),5 ,4000004 ,103 ,0 ,15 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna),5 ,4000004 ,103 ,0 ,16 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna),6 ,4000004 ,103 ,0 ,12 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna),6 ,4000004 ,103 ,0 ,13 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna),6 ,4000004 ,103 ,0 ,14 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna),6 ,4000004 ,103 ,0 ,15 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna),6 ,4000004 ,103 ,0 ,16 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna),7 ,4000004 ,103 ,0 ,12 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna),7 ,4000004 ,103 ,0 ,13 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna),7 ,4000004 ,103 ,0 ,14 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna),7 ,4000004 ,103 ,0 ,15 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna),7 ,4000004 ,103 ,0 ,16 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna),8 ,4000004 ,103 ,0 ,12 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna),8 ,4000004 ,103 ,0 ,13 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna),8 ,4000004 ,103 ,0 ,14 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna),8 ,4000004 ,103 ,0 ,15 ,'' );
insert into orcparamseqorcparamseqcoluna( o116_sequencial ,o116_codseq ,o116_codparamrel ,o116_orcparamseqcoluna ,o116_ordem ,o116_periodo ,o116_formula ) values ( (select max(o116_sequencial) + 1 from orcparamseqorcparamseqcoluna),8 ,4000004 ,103 ,0 ,16 ,'' );
 
COMMIT;

SQL;
        $this->execute($sql);
    } 
}
 
